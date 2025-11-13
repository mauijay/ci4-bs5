<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', ['title' => 'Welcome to My CI4 App']);
    }
}
