<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4"><?= esc($title ?? 'Post') ?></h1>

  <form method="post" action="<?= isset($post['id'])
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
<script src="https://cdn.ckeditor.com/ckeditor5/43.0.0/classic/ckeditor.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const el = document.querySelector('#editor');
    if (!el) return;

    ClassicEditor
      .create(el, {
        toolbar: [
          'heading', '|',
          'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
          'undo', 'redo'
        ]
      })
      .catch(console.error);
  });
</script>
<?= $this->endSection() ?>
