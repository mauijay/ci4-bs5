<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use Config\Services;

final class AccessControlTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public static function setUpBeforeClass(): void
    {
        $migrations = Services::migrations();
        // Ensure migrations run on the testing DB connection
        if (method_exists($migrations, 'setGroup')) {
            $migrations->setGroup('tests');
        }
        // Migrate specific namespaces explicitly to ensure vendor migrations run
        foreach (['CodeIgniter\\Settings', 'CodeIgniter\\Shield', 'App'] as $ns) {
            $migrations->setNamespace($ns);
            $migrations->latest();
        }
    }

    public function testHomeIsPublic(): void
    {
        $result = $this->get('/');
        $result->assertOK();
    }

    public function testAccountRequiresLogin(): void
    {
        $result = $this->get('account/settings');
        $result->assertRedirect();
        $location = $result->response()->getHeaderLine('Location');
        $this->assertStringContainsString('/login', $location);
    }

    public function testAdminRequiresLogin(): void
    {
        $result = $this->get('admin');
        $result->assertRedirect();
        $location = $result->response()->getHeaderLine('Location');
        $this->assertStringContainsString('/login', $location);
    }

    public function testAccountAccessibleWhenLoggedIn(): void
    {
        $email    = 'user_' . uniqid('', true) . '@example.com';
        $password = 'Passw0rd!';

        $this->createUser($email, $password);

        // Login via HTTP to establish session
        $login = $this->post('login', [
            'login'    => $email,
            'password' => $password,
        ]);
        $login->assertRedirect();

        $res = $this->get('account/settings');
        $res->assertOK();
    }

    public function testAdminForbiddenForNormalUser(): void
    {
        $email    = 'user_' . uniqid('', true) . '@example.com';
        $password = 'Passw0rd!';

        $this->createUser($email, $password);

        $this->post('login', [
            'login'    => $email,
            'password' => $password,
        ])->assertRedirect();

        $res = $this->get('admin/settings');
        if ($res->isRedirect()) {
            $this->assertTrue(in_array($res->response()->getStatusCode(), [302, 303, 307, 308], true));
        } else {
            $this->assertTrue(in_array($res->response()->getStatusCode(), [401, 403], true));
        }
    }

    public function testAdminAccessibleForAdminUser(): void
    {
        $email    = 'admin_' . uniqid('', true) . '@example.com';
        $password = 'Passw0rd!';

        $user = $this->createUser($email, $password, makeAdmin: true);

        $this->post('login', [
            'login'    => $email,
            'password' => $password,
        ])->assertRedirect();

        $res = $this->get('admin/settings');
        $res->assertOK();
    }

    private function createUser(string $email, string $password, bool $makeAdmin = false): User
    {
        $users = new UserModel();
        $user  = new User([
            'username' => $email,
            'email'    => $email,
            'password' => $password,
        ]);

        $users->save($user);
        $user = $users->findById($users->getInsertID());

        if ($makeAdmin) {
            $user->addGroup('admin');
        }

        return $user;
    }
}
