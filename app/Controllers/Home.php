<?php
/**
 * Home controller
 *
 * @package    App
 * @category   Controllers
 * @license    MIT
 * @link       https://github.com/mauijay/ci4-bs5
 */

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', ['title' => 'Welcome to My CI4 App']);
    }
}
