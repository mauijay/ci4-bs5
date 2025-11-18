<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BlogsController extends BaseController
{
    public function index()
    {
        return view('blogs/index', ['title' => 'Blog News']);
    }

    public function show($id)
    {
        // For demonstration, we'll return a simple JSON response.
        $data = [
            'id'      => $id,
            'title'   => 'Sample Blog Post ' . $id,
            'content' => 'This is the content of blog post ' . $id,
        ];
        return view('blogs/post', $data);


    }
}
