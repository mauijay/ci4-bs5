<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use CodeIgniter\Database\BaseBuilder;

class TagsController extends BaseController
{
    public function index(): string
    {
        // Basic tag index: show latest posts (reuse blog index)
        $blogModel = model(BlogModel::class);

        $posts = $blogModel
            ->withImage()
            ->published()
            ->orderBy('published_at', 'DESC')
            ->paginate(5, 'tag-group');

        $pager = $blogModel->pager;
        return view('blogs/index', [
            'title' => 'Blog by Tag',
            'posts' => $posts,
            'pager' => $pager,
            'featured_posts' => [],
        ]);
    }

    public function show(string $slug): string
    {
        $tag = model(TagModel::class)
            ->where('slug', $slug)
            ->first();

        if (! $tag) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Tag not found');
        }

        $blogModel = model(BlogModel::class);

        // Build join to fetch blogs with this tag using the model
        $posts = $blogModel
            ->withImage()
            ->published()
            ->select('blogs.*')
            ->join('blog_tags bt', 'bt.blog_id = blogs.id', 'inner')
            ->where('bt.tag_id', $tag['id'])
            ->orderBy('blogs.published_at', 'DESC')
            ->paginate(5, 'tag-group');

        $pager = $blogModel->pager;

        return view('blogs/index', [
            'title' => 'Tag: ' . $tag['name'],
            'tags' => model(TagModel::class)->orderBy('name', 'ASC')->findAll(),
            'categories' => model(CategoryModel::class)->orderBy('name', 'ASC')->findAll(),
            'posts' => $posts,
            'pager' => $pager,
            'featured_posts' => [],
        ]);
    }
}
