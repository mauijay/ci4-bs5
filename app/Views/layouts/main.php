<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= esc($title ?? app_settings()->siteName) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<?php
    $settings = app_settings();

    $theme = $settings->theme;

    if ($settings->allowUserThemePreference && auth()->loggedIn()) {
        $user = auth()->user();
        if (! empty($user->theme)) {
            $theme = $user->theme;
        }
    }
?>
<body class="theme-<?= esc($theme) ?>">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url('/') ?>">My App</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('/') ?>">Home</a>
                </li>
                <?php if (auth()->loggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('account/settings') ?>">My Settings</a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin') ?>">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/users') ?>">Users</a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto">
                <?php if (! auth()->loggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('register') ?>">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <span class="navbar-text me-2">
                            <?= esc(auth()->user()->username ?? auth()->user()->email) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="<?= site_url('logout') ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-light">Logout</button>
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="container-fluid py-4">
        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="/assets/js/app.js"></script>
</body>
</html>

