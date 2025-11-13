<?php

namespace App\Controllers\Auth;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;

class LoginController extends ShieldLoginController
{
    /**
     * Show the login form.
     */
    public function loginView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        return view('auth/login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Handle login attempt.
     */
    public function loginAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->loginRedirect());
        }

        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Determine login field according to Auth.validFields
        $validFields = setting('Auth.validFields') ?? ['email'];
        $field       = 'email';
        if (in_array('username', $validFields, true) && ! filter_var((string) $login, FILTER_VALIDATE_EMAIL)) {
            $field = 'username';
        } elseif (in_array('email', $validFields, true)) {
            $field = 'email';
        }

        // Attempt authentication via Shield (basic attempt)
        $result = auth()->attempt([
            $field    => $login,
            'password' => $password,
        ]);

        if (! $result->isOK()) {
            return redirect()->back()->withInput()->with('error', $result->reason());
        }

        // Optional remember-me handling (if implemented in future)
        // if ($remember) { /* persistent login logic */ }

        return redirect()->to(config('Auth')->loginRedirect())
            ->with('message', lang('Auth.loginSuccess'));
    }

    /**
     * Log the user out (custom endpoint optional – default Shield route still available).
     */
    public function logout(): RedirectResponse
    {
        auth()->logout();
        return redirect()->to(config('Auth')->logoutRedirect())
            ->with('message', lang('Auth.logoutSuccess'));
    }
}
