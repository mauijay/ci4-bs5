<?php

namespace App\Libraries;

use App\Models\ImageModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class ImageService
{
    protected ImageModel $imageModel;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
    }

    /**
     * Store an uploaded image for a blog post and return the new image_id.
     *
     * @param UploadedFile $file
     * @param string|null  $alt       Alt text for accessibility/SEO
     * @param string|null  $title     Optional image title
     * @param string|null  $baseName  Optional base filename (e.g. post slug)
     */
    public function storePostImage(UploadedFile $file, ?string $alt = null, ?string $title = null, ?string $baseName = null): int
    {
        if (! $file->isValid() || $file->hasMoved()) {
            throw new \RuntimeException('Invalid image upload.');
        }

        // Basic validation - adjust MIME types/size as needed.
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowedTypes, true)) {
            throw new \RuntimeException('Unsupported image type.');
        }

        $uploadsPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'images';
        if (! is_dir($uploadsPath)) {
            mkdir($uploadsPath, 0775, true);
        }

        $ext = $file->getExtension();

        // Derive a nice SEO-friendly base name if provided, otherwise from original filename.
        if ($baseName === null || $baseName === '') {
            $originalBase = pathinfo($file->getName(), PATHINFO_FILENAME);
            $baseName     = url_title($originalBase, '-', true);
        } else {
            $baseName = url_title($baseName, '-', true);
        }

        $newName = $baseName . '.' . $ext;

        // Avoid overwriting an existing file: append a short timestamp suffix if needed.
        if (is_file($uploadsPath . DIRECTORY_SEPARATOR . $newName)) {
            $newName = $baseName . '-' . time() . '.' . $ext;
        }
        $file->move($uploadsPath, $newName);

        $relativePath = '/uploads/images/' . $newName;

        $width  = null;
        $height = null;
        $imageSize = @getimagesize($uploadsPath . DIRECTORY_SEPARATOR . $newName);
        if ($imageSize !== false) {
            $width  = $imageSize[0] ?? null;
            $height = $imageSize[1] ?? null;
        }

        $data = [
            'path'   => $relativePath,
            'alt'    => $alt,
            'title'  => $title,
            'width'  => $width,
            'height' => $height,
        ];

        return $this->imageModel->insert($data, true);
    }
}
