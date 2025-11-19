<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BlogController extends BaseController
{
   protected BlogModel $blogModel;
    protected CategoryModel $categoryModel;
    protected TagModel $tagModel;

    public function __construct()
    {
        $this->blogModel     = model(BlogModel::class);
        $this->categoryModel = model(CategoryModel::class);
        $this->tagModel      = model(TagModel::class);
    }
    public function index(): string
    {
        $posts = $this->blogModel
            ->orderBy('published_at', 'DESC')
            ->paginate(10, 'admin-blog-group');

        return view('admin/blogs/index', [
            'title' => 'Blog Posts',
            'posts' => $posts,
            'pager' => $this->blogModel->pager,
        ]);
    }

    public function create(): string
    {
        return view('admin/blogs/form', [
            'title'      => 'Create Post',
            'post'       => null,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'tags'       => $this->tagModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $this->blogModel->insert([
            'title'         => $data['title'] ?? '',
            'slug'          => url_title($data['title'] ?? '', '-', true),
            'summary'       => $data['summary'] ?? '',
            'content'       => $data['content'] ?? '',
            'category_id'   => $data['category_id'] ?? null,
            'status'        => $data['status'] ?? 'draft',
            'published_at'  => $data['published_at'] ?: date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.blogs.index')->with('message', 'Post created.');
    }

    public function edit(int $id): string
    {
        $post = $this->blogModel->find($id);

        if (! $post) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/blogs/form', [
            'title'      => 'Edit Post',
            'post'       => $post,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'tags'       => $this->tagModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $data = $this->request->getPost();

        $this->blogModel->update($id, [
            'title'        => $data['title'] ?? '',
            'slug'         => url_title($data['title'] ?? '', '-', true),
            'summary'      => $data['summary'] ?? '',
            'content'      => $data['content'] ?? '',
            'category_id'  => $data['category_id'] ?? null,
            'status'       => $data['status'] ?? 'draft',
            'published_at' => $data['published_at'] ?: date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.blogs.index')->with('message', 'Post updated.');
    }

    public function delete(int $id)
    {
        $this->blogModel->delete($id);

        return redirect()->route('admin.blogs.index')->with('message', 'Post deleted.');
    }
}
