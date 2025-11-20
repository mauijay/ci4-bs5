<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\TagModel;

class BlogsController extends BaseController
{
    /**
     */
    public function index(): string
    {
      $blogModel      = model(BlogModel::class);
      $categoryModel  = model(CategoryModel::class);
      $tagModel       = model(TagModel::class);
    $posts          = $blogModel
                    ->withImage()
                    ->published()
                    ->orderBy('published_at', 'DESC')
                    ->paginate(12, 'news-group');
      $pager          = $blogModel->pager;
      $data = [
          'title' => 'Blog News',
          'posts' => $posts,
          'pager' => $pager,
          'categories'     => $categoryModel->orderBy('name', 'ASC')->findAll(),
          'tags'           => $tagModel->orderBy('name', 'ASC')->findAll(),
          'featured_posts' => [
              [
                  'slug'    => 'first-post',
                  'title'   => 'Amazing Featured Post 1 Title',
                  'summary' => 'A short summary of your featured post. Enough to grab attention and encourage readers to continue.',
                  'image_id'  => 1,
                  'image'  => '/uploads/default_img.jpg',
                  'image_alt' => 'Featured post 1 image'
              ],
              [
                  'slug'    => 'second-post',
                  'title'   => 'Another Day, Another Post',
                  'summary' => 'A short summary of your featured post. Enough to grab attention and encourage readers to continue.',
                  'image_id'  => 2,
                  'image'  => '/uploads/default_img.jpg',
                  'image_alt' => 'Featured post 2 image'
              ],
              [
                  'slug'    => 'third-post',
                  'title'   => 'Read This Important Update',
                  'summary' => 'A short summary of your featured post. Enough to grab attention and encourage readers to continue.',
                  'image_id'  => 3,
                  'image'  => '/uploads/default_img.jpg',
                  'image_alt' => 'Featured post 3 image'
              ],
          ],
      ];

        return view('blogs/index', $data);
    }

    /**
     */
    public function show(string $slug): string
    {
        $model = model(BlogModel::class);

                $post = $model
                        ->withImage()
                        ->published()
                        ->where('slug', $slug)
                        ->first();

        if (! $post) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $title = $post['title'];

        return view('blogs/post', [
            'title' => $title,
            'post'  => $post,
        ]);
    }
}
