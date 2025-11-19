<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\CategoryModel;
use App\Models\TagModel;
use CodeIgniter\Database\BaseBuilder;

class TagsController extends BaseController
{
    public function index(): string
    {
        // Basic tag index: show latest posts (reuse blog index)
        $db = db_connect();
        $pager = service('pager');
        $posts = $db->table('blogs')->orderBy('published_at', 'DESC')->get(5)->getResultArray();
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

        $db = db_connect();
        $pager = service('pager');

        // Build join to fetch blogs with this tag
        $builder = $db->table('blogs b')
            ->select('b.*')
            ->join('blog_tags bt', 'bt.blog_id = b.id', 'inner')
            ->where('bt.tag_id', $tag['id'])
            ->orderBy('b.published_at', 'DESC');

        // Simple manual pagination: fetch latest 5
        $posts = $builder->get(5)->getResultArray();

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
