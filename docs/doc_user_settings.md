User Settings & Preferences (CI4 + Shield)
Per-User Theme, Metadata, Profile Settings, & Access Control

Save as:
docs/doc_user_settings.md

👤 User Settings & Preferences in CodeIgniter 4.6.3 + Shield 1.2

This document explains how to implement and manage per-user settings on top of:

CodeIgniter 4.6.3

Shield 1.2.0

Settings v2.2.0

We use Shield Meta for storing user-specific data (preferences, options, roles, etc).

🧱 1. Understanding Shield Meta

Each Shield user has a metadata table entry:

auth_identities + auth_identities_meta


Meta is stored as key/value pairs, for example:

user	key	value
#1	theme	dark
#1	layout	compact

Meta is automatically JSON-encoded when needed.

📝 2. Setting User Preferences

To save/update a user preference:

auth()->user()->setMeta('theme', 'dark')->save();


Other examples:

$user->setMeta('sidebar_collapsed', true)->save();
$user->setMeta('timezone', 'Pacific/Honolulu')->save();
$user->setMeta('items_per_page', 50)->save();

🔍 3. Reading User Preferences
$theme = auth()->user()->getMeta('theme');


If no preference exists, it returns null.

To read with default:

$theme = $user->getMeta('theme') ?? 'light';

🗑️ 4. Deleting a User Preference
$user->deleteMeta('theme')->save();

🔐 5. Setting Permissions / Abilities Per User

Shield allows:

role-based permissions (recommended)

OR direct abilities per user

Add ability:
auth()->user()->addPermission('admin.settings')->save();

Remove ability:
auth()->user()->removePermission('admin.settings')->save();

Check inside controller:
if (! auth()->user()->can('admin.settings')) {
    return redirect()->back()->with('error', 'Unauthorized');
}

🌙 6. User Theme Preference System

We combine global settings with user meta.

6.1 Theme Resolution Logic
$s = app_settings();   // global settings

if (!$s->allowUserThemePreference) {
    return $s->theme;  // global enforced
}

$user = auth()->user();

return $user
    ? ($user->getMeta('theme') ?? $s->theme)
    : $s->theme;

6.2 Changing Theme in User Profile

Controller example:

public function updateTheme()
{
    $theme = $this->request->getPost('theme');
    $user  = auth()->user();

    $user->setMeta('theme', $theme)->save();

    return redirect()->back()->with('message', 'Theme updated.');
}

6.3 User Profile View Example
<select name="theme" class="form-select">
    <option value="light" <?= $theme === 'light' ? 'selected' : '' ?>>Light</option>
    <option value="dark"  <?= $theme === 'dark' ? 'selected' : '' ?>>Dark</option>
</select>

🧩 7. Combined: Global + User Settings

Global → stored via Settings

User → stored via Shield meta

Use this pattern for any preference system:

theme

locale

timezone

date format

dashboard layout

pagination settings

accessibility preferences

notification settings

etc.

🧪 8. Recommended Helpers

Add to app/Helpers/user_settings_helper.php:

<?php

function user_pref(string $key, $default = null)
{
    if (!auth()->loggedIn()) {
        return $default;
    }

    return auth()->user()->getMeta($key) ?? $default;
}


Then you can use:

$theme = user_pref('theme', 'light');


Or in a view:

<body data-theme="<?= user_pref('theme', app_settings()->theme) ?>">

📦 9. Storing User Settings as a Structured Object

If you want more complex settings, you can store JSON arrays:

$user->setMeta('dashboard', [
    'widgets' => ['sales', 'traffic', 'tasks'],
    'layout' => 'wide'
])->save();


Retrieve:

$dashboard = $user->getMeta('dashboard');

🛡️ 10. Security Notes

Meta storage is safe for non-critical data

Never store passwords or sensitive encrypted data in meta

Validate user input before saving

Use ability checks for profile updates when appropriate

🎉 Final Result

With this system you now have:

✔ Global settings (via Settings v2.2.0)
✔ Site-wide defaults (cached via service)
✔ Per-user preferences (via Shield meta)
✔ Flexible theme system
✔ Extendable settings system for any feature

You are now running a modern, scalable, multi-layer settings architecture.