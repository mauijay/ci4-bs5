<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ImageController extends BaseController
{
    protected ImageModel $imageModel;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
    }

    public function index(): string
    {
        $images = $this->imageModel
            ->orderBy('created_at', 'DESC')
            ->paginate(20, 'admin-images');

        return view('admin/images/index', [
            'title'  => 'Images',
            'images' => $images,
            'pager'  => $this->imageModel->pager,
        ]);
    }

    public function edit(int $id): string
    {
        $image = $this->imageModel->find($id);

        if (! $image) {
            throw PageNotFoundException::forPageNotFound('Image not found');
        }

        return view('admin/images/form', [
            'title' => 'Edit Image',
            'image' => $image,
        ]);
    }

    public function update(int $id)
    {
        $image = $this->imageModel->find($id);

        if (! $image) {
            throw PageNotFoundException::forPageNotFound('Image not found');
        }

        $data = $this->request->getPost();

        $this->imageModel->update($id, [
            'alt'   => $data['alt'] ?? null,
            'title' => $data['title'] ?? null,
        ]);

        return redirect()->route('admin.images.index')->with('message', 'Image updated.');
    }
}
