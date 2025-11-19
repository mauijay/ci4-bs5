<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\TagModel;

class CategoriesController extends BaseController
{
    public function index(): string
    {
        // Optional: could list categories; reuse blog index for now
        $model = model(BlogModel::class);
        $pager = service('pager');
        return view('blogs/index', [
            'title' => 'Blog by Category',

            'posts' => $model->paginate(5),
            'pager' => $pager,
            'featured_posts' => [],
        ]);
    }

    public function show(string $slug): string
    {
        $category = model(CategoryModel::class)
            ->where('slug', $slug)
            ->first();

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }
         $tagModel      = model(TagModel::class);
        $pager = service('pager');
        $posts = model(BlogModel::class)
            ->where('category_id', $category['id'])
            ->orderBy('published_at', 'DESC')
            ->paginate(5);

        return view('blogs/index', [
            'title' => 'Category: ' . $category['name'],
            'tags' => $tagModel->orderBy('name', 'ASC')->findAll(),
            'categories' => model(CategoryModel::class)->orderBy('name', 'ASC')->findAll(),
            'posts' => $posts,
            'pager' => $pager,
            'featured_posts' => [],
        ]);
    }
}
