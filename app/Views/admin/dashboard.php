<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

  <div class="container-fluid">
    <h1 class="h3 mb-4">Admin Dashboard</h1>
    <p class="text-muted">Welcome back, <?= esc($displayName ?? '') ?>.</p>
  </div>
  
<?= $this->endSection() ?>
