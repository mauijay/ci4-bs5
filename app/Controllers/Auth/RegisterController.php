<?php
/**
 * Register controller (extends Shield)
 *
 * @package    App
 * @category   Controllers
 * @license    MIT
 * @link       https://github.com/mauijay/ci4-bs5
 */

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegisterController;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;

class RegisterController extends ShieldRegisterController
{
    /**
     * Show the registration form (we can reuse Shield's view or customize).
     */
    public function registerView()
    {
        return (string) \call_user_func('view', 'auth/register', [
            'title' => 'Register',
        ]);
    }

    /**
     * Attempts to register the user with extra fields.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validation rules including extra fields
        $rules = $this->getValidationRules();
        $rules['full_name'] = 'required|string|min_length[3]|max_length[100]';
        $rules['phone']     = 'permit_empty|string|max_length[30]';

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost([
            'username',
            'email',
            'password',
            'password_confirm',
            'full_name',
            'phone',
        ]);

        // Create the User entity
        $user = new \App\Entities\User([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'full_name' => $data['full_name'] ?? null,
            'phone'     => $data['phone'] ?? null,
        ]);

        // Save user
        $users->save($user);

        // Reload to get ID
        $user = $users->findById($users->getInsertID());

        // Extra fields are stored directly on the users table via custom entity/model

        // Add to default group
        $users->addToDefaultGroup($user);

        // Let Shield handle post-registration flow (actions, redirect)
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));
    }
}
