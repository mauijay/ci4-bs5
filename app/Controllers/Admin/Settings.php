<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\AppSettingsService;

class Settings extends BaseController
{
    public function index()
    {
        return view('admin/settings/index', [
            'settings' => app_settings(),
        ]);
    }

    public function update()
    {
        $data = $this->request->getPost([
            'siteName',
            'theme',
        ]);

        $newSettings = [
            'siteName'  => $data['siteName'] ?? 'My CI4 App',
            'theme'     => $data['theme'] ?? 'light',
            'maintenanceMode'         => $this->request->getPost('maintenanceMode') !== null,
            'adminRegistrationOnly'   => $this->request->getPost('adminRegistrationOnly') !== null,
            'allowUserThemePreference' => $this->request->getPost('allowUserThemePreference') !== null,
        ];

        // Persist each setting using dot syntax
        /** @var \CodeIgniter\Settings\Settings $settingsMgr */
        $settingsMgr = setting();
        foreach ($newSettings as $key => $val) {
            $settingsMgr->set('AppSettings.' . $key, $val);
        }
        // Persist changes if your Settings version requires an explicit save.
        // Uncomment the next line if available in your setup:
        // $settingsMgr->save();

        AppSettingsService::refresh();

        return redirect()->back()->with('message', 'Settings updated.');
    }
}
