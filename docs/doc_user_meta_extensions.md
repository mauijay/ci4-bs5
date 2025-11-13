User Meta System (Extended Profiles & Preferences)
CI4 + Shield 1.2.0 — Storing Extra User Fields, Preferences & Profile Data

Save as:
docs/doc_user_meta_extensions.md

🧬 User Meta Extensions for CI4 + Shield 1.2.0

This document explains how to extend Shield's user model using meta fields, giving you a flexible system for storing:

Profile information

Preferences

Settings

Custom fields

Anything per-user

Shield includes User Meta out of the box, using tables:

auth_identities

auth_meta

This system is highly flexible and does not require migrations unless storing structured data.

🧩 1. What User Meta Is

Each user may have unlimited key/value pairs stored like:

user_id | key   | value
-------------------------
3       | phone | 808-555-1212
3       | theme | dark
3       | bio   | "Local artist..."


Shield serializes values internally, so you may store arrays or JSON.

🛠 2. Setting Meta Values

Simple usage:

$user = auth()->user();
$user->setMeta('phone', '808-555-1234')->save();

Arrays allowed:
$user->setMeta('address', [
    'street' => '123 Main',
    'city'   => 'Honolulu',
    'zip'    => '96815'
])->save();

📥 3. Retrieving Meta Values
$phone = $user->getMeta('phone');


If a value does not exist:

$theme = $user->getMeta('theme', 'light'); // fallback default

❌ 4. Deleting Meta
$user->deleteMeta('phone')->save();

🧰 5. Meta Helper Function (Optional)

Add a helper for clean syntax.

app/Helpers/user_helper.php

<?php

if (! function_exists('user_meta')) {
    function user_meta(string $key, $default = null)
    {
        if (! auth()->loggedIn()) {
            return $default;
        }

        return auth()->user()->getMeta($key, $default);
    }
}


Usage:

$currentTheme = user_meta('theme', 'light');

🧱 6. Adding Extended User Fields in Registration

You can customize Shield’s registration form to include new fields:
(full_name, phone, title, etc.)

6.1 Modify Registration View

Create:

app/Views/auth/register.php

<form method="post">

    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="full_name" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>

    <!-- Shield default fields -->
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <button class="btn btn-primary">Register</button>
</form>

6.2 Override Shield’s RegisterController

Create:

app/Controllers/Auth/RegisterController.php

<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;

class RegisterController extends ShieldRegister
{
    public function register()
    {
        $response = parent::register();

        if ($response instanceof \CodeIgniter\HTTP\RedirectResponse) {
            return $response;
        }

        $user = auth()->user();

        // Save custom meta
        $user->setMeta('full_name', $this->request->getPost('full_name'));
        $user->setMeta('phone',     $this->request->getPost('phone'));
        $user->save();

        return redirect()->to('/dashboard');
    }
}

6.3 Route override

In app/Config/Routes.php:

$routes->get('register', 'Auth\RegisterController::registerView');
$routes->post('register', 'Auth\RegisterController::register');

📋 7. Admin: Viewing User Meta (Users Management)

In your Admin Users list:

<td><?= esc($user->getMeta('full_name', '')) ?></td>
<td><?= esc($user->getMeta('phone', '')) ?></td>


If paginating users:

foreach ($users as $user) {
    $userFullName = $user->getMeta('full_name', '(none)');
}

🔧 8. Admin: Editing User Meta

Create a user edit page:

View:

app/Views/admin/users/edit.php

<h1>Edit User</h1>

<form method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name"
               value="<?= esc($user->getMeta('full_name')) ?>"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone"
               value="<?= esc($user->getMeta('phone')) ?>"
               class="form-control">
    </div>

    <button class="btn btn-primary">Save</button>
</form>

Controller:
public function update($id)
{
    $user = $this->userModel->find($id);

    $user->setMeta('full_name', $this->request->getPost('full_name'));
    $user->setMeta('phone',     $this->request->getPost('phone'));
    $user->save();

    return redirect()->to('/admin/users')->with('message', 'Updated.');
}

🧬 9. Advanced Meta Patterns
9.1 Nested data (profile object)
$user->setMeta('profile', [
    'full_name' => 'Jay Smith',
    'phone'     => '808...',
    'city'      => 'Honolulu',
])->save();


Retrieve:

$profile = $user->getMeta('profile');

9.2 Arbitrary application settings
$user->setMeta('ui', [
    'sidebar_collapsed' => true,
    'language'          => 'en',
]);

9.3 Tokens / API keys (encrypted)
$user->setMeta('api_token', bin2hex(random_bytes(32)));

📡 10. Relationship Between CI Settings and User Meta
Feature	Use Settings?	Use User Meta?
Global app title	✅	❌
Global site theme	✅	❌
Per-user theme	❌	✅
Profile info	❌	✅
Feature flags	✅	❌
User-specific flags	❌	✅
Admin-only options	✅	❌

They are meant to work together, not overlap.

🧭 11. Best Practices

✔ Use Settings for global configuration
✔ Use User Meta for per-user values
✔ Keep keys snake_case
✔ Avoid storing giant blobs (use DB table instead)
✔ Use services to avoid code duplication

Example meta key naming:

full_name
phone
address
theme
dashboard_pref
sidebar_state
profile_completed

🏁 Final Result

You now have:

✔ Fully extended user profiles
✔ Admin-editable meta system
✔ Custom registration fields
✔ Per-user preferences
✔ Unlimited structured metadata
✔ Built-in persistence via Shield
✔ Simple API: setMeta(), getMeta()

This system is production-grade and used in large CI4 apps today.