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
use Config\Services;

class Home extends BaseController
{
    public function index(): string
    {
        return Services::renderer()
            ->setVar('title', 'Welcome to My CI4 App')
            ->render('home');
    }
}
