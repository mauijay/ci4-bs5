<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use App\Libraries\AppSettingsService;

class Settings extends BaseController
{
    public function index()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $settings = AppSettingsService::get();

        // Load user's profile for preferences
        $user = auth()->user();
        $currentTheme = $user->theme ?? $settings->theme;

        return view('account/settings', [
            'title'        => 'My Settings',
            'settings'     => $settings,
            'user'         => auth()->user(),
            'currentTheme' => $currentTheme,
        ]);
    }

    public function update()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $settings = AppSettingsService::get();

        if (! $settings->allowUserThemePreference) {
            return redirect()->back()->with('error', 'User theme preference is disabled.');
        }

        $theme = $this->request->getPost('theme');

        if (! in_array($theme, $settings->availableThemes, true)) {
            return redirect()->back()->with('error', 'Invalid theme selected.');
        }

        // Save on user entity
        $user        = auth()->user();
        $user->theme = $theme;
        model(\App\Models\UserModel::class)->save($user);

        return redirect()->back()->with('message', 'Preferences saved.');
    }
}
