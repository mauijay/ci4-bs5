<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Blog Posts</h1>
    <a href="<?= site_url(route_to('admin.blogs.create')) ?>" class="btn btn-primary">New Post</a>
  </div>

  <?php if (session('message')): ?>
    <div class="alert alert-success"><?= esc(session('message')) ?></div>
  <?php endif; ?>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Published</th>
        <th class="text-end">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($posts)): ?>
      <tr><td colspan="5" class="text-center text-muted">No posts found.</td></tr>
    <?php else: ?>
      <?php foreach ($posts as $post): ?>
        <tr>
          <td><?= esc($post['id']) ?></td>
          <td><?= esc($post['title']) ?></td>
          <td><?= esc($post['status']) ?></td>
          <td><?= esc($post['published_at']) ?></td>
          <td class="text-end">
            <a href="<?= site_url(route_to('admin.blogs.edit', $post['id'])) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="<?= site_url(route_to('admin.blogs.delete', $post['id'])) ?>" method="post" class="d-inline">
              <?= csrf_field() ?>
              <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this post?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>

  <?php if (isset($pager)): ?>
    <?= $pager->links('admin-blog-group', 'custom_full') ?>
  <?php endif; ?>
</div>
<?= $this->endSection() ?>
