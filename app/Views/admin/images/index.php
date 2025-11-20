<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <h1 class="h3 mb-4">Images</h1>

  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table align-middle table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Preview</th>
          <th scope="col">Alt</th>
          <th scope="col">Title</th>
          <th scope="col">Path</th>
          <th scope="col">Created</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($images as $image): ?>
        <tr>
          <td><?= esc($image['id']) ?></td>
          <td>
            <img src="<?= esc($image['path']) ?>" alt="" style="max-height: 60px;" class="img-thumbnail">
          </td>
          <td><?= esc($image['alt'] ?? '') ?></td>
          <td><?= esc($image['title'] ?? '') ?></td>
          <td class="text-truncate" style="max-width: 220px;">
            <code><?= esc($image['path']) ?></code>
          </td>
          <td><?= esc($image['created_at'] ?? '') ?></td>
          <td class="text-end">
            <a href="<?= site_url(route_to('admin.images.edit', $image['id'])) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?= $pager->links('admin-images', 'default_full') ?>
</div>
<?= $this->endSection() ?>
