<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <h1 class="mb-4">Admin Profile</h1>

  <?php if (! $user): ?>
    <div class="alert alert-warning">No authenticated user.</div>
  <?php else: ?>
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="h5 mb-3">Account</h2>
        <dl class="row mb-0">
          <dt class="col-sm-3">ID</dt>
          <dd class="col-sm-9"><?= esc($user->id) ?></dd>
          <dt class="col-sm-3">Username</dt>
          <dd class="col-sm-9"><?= esc($user->username ?? '') ?></dd>
          <dt class="col-sm-3">Email</dt>
          <dd class="col-sm-9"><?= esc($user->email ?? '') ?></dd>
        </dl>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h5 mb-3">Groups</h2>
            <?php if (empty($groups)): ?>
              <p class="text-muted mb-0">No groups assigned.</p>
            <?php else: ?>
              <ul class="list-group list-group-flush">
                <?php foreach ($groups as $g): ?>
                  <li class="list-group-item"><?= esc($g) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h5 mb-3">Permissions</h2>
            <?php if (empty($permissions)): ?>
              <p class="text-muted mb-0">No permissions granted.</p>
            <?php else: ?>
              <ul class="list-group list-group-flush">
                <?php foreach ($permissions as $p): ?>
                  <li class="list-group-item"><?= esc($p) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
<?= $this->endSection() ?>
