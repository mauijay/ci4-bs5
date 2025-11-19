<?php
// app/Views/layouts/admin.php
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title><?= esc($title ?? 'Admin') ?> | <?= esc(app_settings()->siteName) ?></title>

      <link rel="icon" type="image/png" href="/favicon.png">
      <link href="<?= base_url('assets/css/admin_styles.css') ?>" rel="stylesheet">

      <?= $this->renderSection('head_js') ?>
  </head>
  <?php
      $settings     = app_settings();
      $isLoggedIn   = function_exists('auth') && auth()->loggedIn();
      $user         = $isLoggedIn ? auth()->user() : null;
      $groups       = $user && method_exists($user, 'getGroups') ? (array) $user->getGroups() : [];
      $primaryGroup = $groups[0] ?? null;
      $displayName  = $user ? ($user->username ?? $user->email ?? '') : '';
  ?>
  <body class="admin-layout">
    <div class="admin-wrapper">

      <!-- SIDEBAR -->
      <aside class="admin-sidebar d-flex flex-column p-3">
        <h2 class="h5 mb-4">Admin</h2>
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item mb-1">
            <a href="<?= site_url(route_to('admin.dashboard.index')) ?>" class="nav-link py-2 px-3">
              Dashboard
            </a>
          </li>
          <li class="nav-item mb-1">
            <a href="<?= site_url(route_to('admin.blogs.index')) ?>" class="nav-link py-2 px-3">
              Blog Posts
            </a>
          </li>
          <li class="nav-item mb-1">
            <a href="<?= site_url(route_to('admin.users.index')) ?>" class="nav-link py-2 px-3">
              Users
            </a>
          </li>
          <li class="nav-item mb-1">
            <a href="<?= site_url(route_to('admin.settings.index')) ?>" class="nav-link py-2 px-3">
              Settings
            </a>
          </li>
        </ul>
      </aside>

      <!-- MAIN COLUMN -->
      <div class="admin-main">
        <!-- TOPBAR -->
        <header class="admin-topbar px-4 py-2 d-flex justify-content-between align-items-center">
          <div>
            <span class="fw-semibold"><?= esc($title ?? 'Admin') ?></span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <?php if ($user): ?>
              <span class="text-muted small"><?= esc($displayName) ?></span>
            <?php endif; ?>
            <a href="<?= site_url('/') ?>" class="btn btn-sm btn-outline-secondary">View site</a>
            <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">Logout</a>
          </div>
        </header>

        <!-- CONTENT -->
        <main class="admin-content">
          <?= $this->renderSection('content') ?>
        </main>
      </div>
    </div>

    <script src="<?= base_url('assets/js/admin.bundle.js') ?>" defer></script>
    <?= $this->renderSection('footer_js') ?>
  </body>
</html>
