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
        $blogModel = model(BlogModel::class);

        $posts = $blogModel
            ->withImage()
            ->published()
            ->orderBy('published_at', 'DESC')
            ->paginate(5, 'category-group');

        return view('blogs/index', [
            'title'          => 'Blog by Category',
            'posts'          => $posts,
            'pager'          => $blogModel->pager,
            'featured_posts' => [],
        ]);
    }

    public function show(string $slug): string
    {
        $categoryModel = model(CategoryModel::class);
        $tagModel      = model(TagModel::class);
        $blogModel     = model(BlogModel::class);

        $category = $categoryModel
            ->where('slug', $slug)
            ->first();

        if (! $category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }

        $posts = $blogModel
            ->withImage()
            ->published()
            ->where('category_id', $category['id'])
            ->orderBy('published_at', 'DESC')
            ->paginate(5, 'category-group');

        return view('blogs/index', [
            'title'      => 'Category: ' . $category['name'],
            'tags'       => $tagModel->orderBy('name', 'ASC')->findAll(),
            'categories' => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'posts'      => $posts,
            'pager'      => $blogModel->pager,
            'featured_posts' => [],
        ]);
    }
}
