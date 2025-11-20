<?= $this->extend('layouts/admin') ?>

<?=  $this->section('head_js') ?>
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/hd6ozf2uv0gygacxtjtjqb0bg8ikejvybmvpkngmuq57ciso/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid p-4">
  <h1 class="h3 mb-4"><?= esc($title ?? 'Post') ?></h1>

    <form method="post" enctype="multipart/form-data" action="<?= isset($post['id'])
      ? site_url(route_to('admin.blogs.update', $post['id']))
      : site_url(route_to('admin.blogs.store')) ?>">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= esc($post['title'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Summary</label>
      <textarea name="summary" class="form-control" rows="3"><?= esc($post['summary'] ?? '') ?></textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label d-block">Featured Image</label>

        <?php if (! empty($post['image'])): ?>
          <div class="card mb-2">
            <div class="card-body text-center">
              <img src="<?= esc($post['image']) ?>"
                   alt=""
                   class="img-fluid rounded mb-2"
                   style="max-height: 180px;">
              <p class="small text-muted mb-0 text-truncate">
                <code><?= esc($post['image']) ?></code>
              </p>
            </div>
          </div>
        <?php else: ?>
          <p class="text-muted small mb-2">No image selected yet.</p>
        <?php endif; ?>

        <?php if (! empty($post['image_id'])): ?>
          <a href="<?= site_url(route_to('admin.images.edit', $post['image_id'])) ?>"
             class="btn btn-sm btn-outline-secondary mt-1">
            Edit image details
          </a>
        <?php endif; ?>
      </div>

      <div class="col-md-8">
        <div class="mb-2">
          <label class="form-label">Upload New Image</label>
          <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>

        <div class="mb-2">
          <label class="form-label">Image Alt Text</label>
          <input type="text"
                 name="image_alt"
                 class="form-control"
                 value=""
                 placeholder="Describe the image for accessibility and SEO">
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">SEO Title (optional)</label>
      <input type="text" name="seo_title" class="form-control" value="<?= esc($post['seo_title'] ?? '') ?>" placeholder="Overrides browser title if set">
    </div>

    <div class="mb-3">
      <label class="form-label">SEO Description (optional)</label>
      <textarea name="seo_description" class="form-control" rows="2" placeholder="Overrides meta description if set (155–160 chars ideal)"><?= esc($post['seo_description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select">
        <option value="">— None —</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?= esc($category['id']) ?>"
            <?= isset($post['category_id']) && (int)$post['category_id'] === (int)$category['id'] ? 'selected' : '' ?>>
            <?= esc($category['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <?php $status = $post['status'] ?? 'draft'; ?>
      <select name="status" class="form-select">
        <option value="draft"     <?= $status === 'draft' ? 'selected' : '' ?>>Draft</option>
        <option value="published" <?= $status === 'published' ? 'selected' : '' ?>>Published</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Published At</label>
      <input type="datetime-local" name="published_at" class="form-control"
             value="<?= isset($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : '' ?>">
    </div>

    <div class="mb-4">
      <label class="form-label">Content</label>
      <textarea id="editor" name="content" rows="10"><?= esc($post['content'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">
      <?= isset($post['id']) ? 'Update Post' : 'Create Post' ?>
    </button>
    <a href="<?= site_url(route_to('admin.blogs.index')) ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer_js') ?>
<script>
tinymce.init({
  selector: '#editor',
  menubar: false,
  plugins: 'lists link image code',
  toolbar: 'undo redo | blocks | bold italic | bullist numlist | blockquote | link | removeformat | code',
  block_formats: 'Paragraph=p; Lead paragraph=p.lead; Heading 2=h2; Heading 3=h3',
  style_formats: [
    {
      title: 'Lead paragraph',
      selector: 'p',
      classes: 'lead'
    },
    {
      title: 'Bootstrap blockquote',
      selector: 'blockquote',
      classes: 'blockquote my-4 p-4 bg-light border-start border-4 border-primary'
    }
  ],
  content_css: [
    '<?= base_url("assets/css/style.css") ?>'
  ]
});
</script>


<?= $this->endSection() ?>
