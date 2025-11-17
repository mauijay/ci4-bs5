[![CI (PHP 8.3)](https://github.com/mauijay/ci4-bs5/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/mauijay/ci4-bs5/actions/workflows/ci.yml)

project/
│
├── app/
│ ├── Controllers/
│ │ ├── Home.php
│ │ └── Auth (Shield built-in)
│ ├── Models/
│ ├── Views/
│ │ ├── layout.php
│ │ └── home.php
│ ├── Filters/
│ └── Config/
│
├── public/
│ ├── assets/
│ │ ├── css/
│ │ │ └── style.css ← compiled from scss/style.scss
│ │ └── js/
│ │ └── app.js ← compiled from src/js/app.js
│ └── index.php
│
├── src/
│ ├── scss/
│ │ ├── \_variables.scss
│ │ └── style.scss
│ └── js/
│ └── app.js
│
├── package.json
├── webpack.config.js (optional)
└── composer.json

Great question — you caught something important.

🔍 About setMeta() — Yes, it is real, but hidden in the docs

CodeIgniter Shield includes a full metadata system for users, but it’s not front-and-center in the README.
It is documented inside the internal classes:

CodeIgniter\Shield\Entities\User

CodeIgniter\Shield\Models\UserModel

CodeIgniter\Shield\Entities\UserIdentity

And it is used via:

✅ UserEntity::setMeta()
✅ UserEntity::getMeta()

This system allows you to store any number of custom fields without altering the main users table.

This is official Shield functionality.

✔ Where Shield Stores Meta Data

Metadata is stored in:

auth_identities

With the type:

meta

Shield automatically JSON-encodes/decode metadata fields.

✔ How to Use It (Official API)
Add/update metadata:
$user->setMeta('full_name', 'John Doe');
$user->setMeta('phone', '808-555-1212');
$model->save($user);

Retrieve metadata:
$fullName = $user->getMeta('full_name');
$phone = $user->getMeta('phone');

Get all metadata:
$all = $user->getMeta();

This is exactly how Shield wants you to store custom user fields.

Safe. Stable. Forward-compatible.

🎉 Now — Users Management Page in Admin Panel

We'll build a clean Shield-compatible users list:

Features:

✔ Lists all users
✔ Shows username/email
✔ Shows full_name meta
✔ Shows phone meta
✔ Bootstrap table
✔ Only accessible by logged-in users (admin area)

Great question — and this is something many CI4 developers miss when working with Shield.

CodeIgniter Shield fully supports CodeIgniter’s Settings system, and using it gives you a massive advantage:

Centralized configuration

Editable via database or file

Change settings at runtime without redeploying code

Use type-safe DTO-like configuration objects

Automatically cached

Fully compatible with Shield features (auth settings, registration behavior, user policies, etc.)

Below is the cleanest way to integrate CodeIgniter Settings into your CI4 + Shield project.

✅ 1. Understanding CodeIgniter Settings (CI4.5+)

CodeIgniter Settings is a database-backed and file-backed configuration system introduced in CI4.3+, perfected by CI4.5+.

You can store:

Booleans (allowRegistration)

Strings (companyName)

Arrays (allowedDomains)

Integers (maxLoginAttempts)

Even JSON objects

Example:
setting('Auth.allowRegistration');
setting('App.siteName');
setting('MyApp.theme');

You can also modify settings at runtime:

setting()->set('App.siteName', 'My New Title');
setting()->save();

🎯 2. How Shield Already Uses Settings

Shield automatically pulls many of its config values from the Settings system.

Examples:

🔐 Registration Allowed:
setting('Auth.allowRegistration')

⏱ Token expiry:
setting('Auth.sessionConfig')

🔑 Default User Group:
setting('Auth.defaultGroup')

And more found in:

app/Config/Auth.php
app/Config/AuthTokens.php
settings.php (generated)

This means your project can override or add custom Shield-related settings safely.

🚀 3. Enabling Settings for Your Project

If you haven’t already, run:

php spark settings:setup
php spark migrate

This creates:

settings
settings_keys

Two tables that store your values.

6. Tie-In With Shield & Auth Settings

Some examples of how you can now wire everything together:

Disable public registration from the admin panel:

// whenever settings change
setting()->set('Auth.allowRegistration', ! $newSettings['adminRegistrationOnly'])->save();

or just check adminRegistrationOnly in your custom RegisterController like we did earlier.

Show maintenance banner or block non-admins based on maintenanceMode:

In a global filter or in your BaseController:

if (app_settings()->maintenanceMode && (! auth()->loggedIn() || ! auth()->user()->can('admin'))) {
return redirect()->to('/maintenance'); // or show a simple view
}

PART 6 — Per-User Preferences (Shield Meta)

Shield allows user-level setting storage:

$user = auth()->user();

$user->setMeta('theme', 'dark')->save();

Retrieve:

$theme = $user->getMeta('theme');

Combine with global settings:

$theme = $userTheme ?? app_settings()->theme;

## API Health Check

- Route name: `api.v1.health.index`
- Method/Path: `GET /api/v1/health`
- Auth: Protected by the `token` filter (CodeIgniter Shield). Provide a valid Bearer token.

Example request:

```bash
curl -i \
  -H "Authorization: Bearer <your_token_here>" \
  http://localhost:8080/api/v1/health
```

Typical response:

```http
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8

{"status":"ok","timestamp":"2025-01-01T12:34:56+00:00"}
```

Reverse routing:

- Controller/Service: `url_to('api.v1.health.index')`
- View helper: `site_url(route_to('api.v1.health.index'))`

Token notes:

- This endpoint requires a Shield token via `Authorization: Bearer <token>`.
- Generate/manage tokens using your existing Shield token flow for this project. Refer to CodeIgniter Shield documentation for Personal Access Tokens.
