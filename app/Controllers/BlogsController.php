<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BlogsController extends BaseController
{
    /**
     */
    public function index(): string
    {
        return view('blogs/index', ['title' => 'Blog News']);
    }

    /**
     */
    public function show(string $slug): string
    {
        $title = ucwords(str_replace('-', ' ', $slug));

        return view('blogs/post', [
            'title' => $title,
            'slug'  => $slug,
        ]);
    }
}
