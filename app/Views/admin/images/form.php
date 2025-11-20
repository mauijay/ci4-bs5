<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4">Edit Image</h1>

  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="<?= esc($image['path']) ?>" alt="" class="img-fluid mb-3">
          <p class="small text-muted mb-0"><code><?= esc($image['path']) ?></code></p>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <form method="post" action="<?= site_url(route_to('admin.images.update', $image['id'])) ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label class="form-label">Alt Text</label>
          <input type="text" name="alt" class="form-control" value="<?= esc($image['alt'] ?? '') ?>" placeholder="Describe the image for accessibility and SEO">
        </div>

        <div class="mb-3">
          <label class="form-label">Title (optional)</label>
          <input type="text" name="title" class="form-control" value="<?= esc($image['title'] ?? '') ?>" placeholder="Optional image title">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?= site_url(route_to('admin.images.index')) ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
