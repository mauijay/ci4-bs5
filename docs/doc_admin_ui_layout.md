Admin UI Layout (Bootstrap 5 + SCSS + Dark/Light Theme Support)
Reusable Admin Panel Layout for CI4 Projects

Save as:
docs/doc_admin_ui_layout.md

🧩 Admin UI Layout — Bootstrap 5 + Theme System

This document provides a complete admin layout for CodeIgniter 4:

Bootstrap 5 SCSS (your custom build)

Light/Dark theme support

Sidebar navigation

Top navbar with user menu

Flash message area

Content section slot

Responsive mobile behavior

Integration with ThemeService

Integration with Shield (user info, logout)

This becomes the master layout for all admin views.

📁 1. File Structure
app/
    Views/
        layouts/
            admin.php
        admin/
            dashboard.php
public/
    themes/
        light/css/style.css
        dark/css/style.css

🎨 2. Admin Layout File

Save as:

app/Views/layouts/admin.php

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Admin Panel') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?= theme_url('css/style.css') ?>">

    <!-- Bootstrap icons (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="d-flex">

    <!-- Sidebar -->
    <nav id="sidebar"
         class="bg-body-tertiary border-end"
         style="min-width:240px; height:100vh;">

        <div class="p-3">
            <h4 class="mb-4">Admin Panel</h4>

            <ul class="nav flex-column">

                <li class="nav-item mb-2">
                    <a class="nav-link <?= uri_string() == 'admin' ? 'active' : '' ?>"
                       href="<?= site_url('admin') ?>">
                        <i class="bi bi-speedometer2 me-1"></i>
                        Dashboard
                    </a>
                </li>

                <?php if (auth()->user()->can('admin.users.manage')): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= uri_string() == 'admin/users' ? 'active' : '' ?>"
                       href="<?= site_url('admin/users') ?>">
                        <i class="bi bi-people me-1"></i>
                        Users
                    </a>
                </li>
                <?php endif; ?>

                <?php if (auth()->user()->can('admin.settings.manage')): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link <?= uri_string() == 'admin/settings' ? 'active' : '' ?>"
                       href="<?= site_url('admin/settings') ?>">
                        <i class="bi bi-gear me-1"></i>
                        Settings
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-grow-1">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-body border-bottom px-3">
            <div class="container-fluid">

                <span class="navbar-brand">Admin</span>

                <div class="ms-auto d-flex align-items-center">

                    <div class="me-3">
                        <?= esc(auth()->user()->getMeta('full_name', auth()->user()->email)) ?>
                    </div>

                    <form action="<?= site_url('logout') ?>" method="post">
                        <?= csrf_field() ?>
                        <button class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </button>
                    </form>

                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        <div class="container mt-3">
            <?php if (session('message')): ?>
                <div class="alert alert-success">
                    <?= esc(session('message')) ?>
                </div>
            <?php endif; ?>

            <?php if (session('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- View Content -->
        <div class="container py-4">
            <?= $this->renderSection('content') ?>
        </div>

    </main>
</div>

</body>
</html>

🧭 3. Using the Layout

Each admin page extends layouts/admin.php.

Example:

app/Views/admin/dashboard.php

<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h1>Dashboard</h1>
<p>Welcome to the admin panel.</p>

<?= $this->endSection() ?>

📌 4. Admin Routes

Inside your admin group:

$routes->group('admin', ['filter' => 'can:admin.access'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('users', 'Admin\Users::index');
    $routes->get('settings', 'Admin\Settings::index');
});

🧩 5. Controllers Example

app/Controllers/Admin/Dashboard.php

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard',
        ]);
    }
}

🌓 6. Theme System Integration

Your layout automatically loads:

<link rel="stylesheet" href="<?= theme_url('css/style.css') ?>">


This will:

Detect user theme preference

Fall back to global theme

Fall back to light theme

No layout changes required.

📱 7. Making Sidebar Responsive

To collapse sidebar on mobile, add this JS snippet (optional):

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.add('d-none');
    }
});
</script>


Or implement a toggle button in navbar.

🌙 8. Optional: Dark Mode Switch in Navbar

If you want user-driven theme toggling:

Add:

<form action="<?= site_url('profile/theme') ?>" method="post" class="me-3">
    <?= csrf_field() ?>
    <select name="theme" onchange="this.form.submit()" class="form-select form-select-sm">
        <?php foreach (app_settings()->availableThemes as $theme): ?>
            <option value="<?= $theme ?>" <?= user_meta('theme') === $theme ? 'selected' : '' ?>>
                <?= ucfirst($theme) ?>
            </option>
        <?php endforeach ?>
    </select>
</form>

💅 9. Optional SCSS Enhancements

Common admin additions to SCSS themes:

Sidebar
#sidebar {
    background-color: $body-bg;
    border-right: 1px solid rgba(0,0,0,.1);

    .nav-link {
        color: $body-color;

        &.active {
            font-weight: 600;
            background: rgba(0,0,0,.05);
        }
    }
}

Navbar
.navbar {
    background-color: $body-bg;
    border-bottom: 1px solid rgba(0,0,0,.1);
}

🧹 10. Cleaning Up Admin Views

Create reusable components:

app/Views/components/
    card.php
    table.php
    form-group.php


Then load via:

<?= view('components/card', ['title' => 'Users', 'body' => $table ]) ?>


I can create a full component library if you want.

🏁 Final Result

You now have a modern, production-ready admin layout:

✔ Sidebar layout
✔ Responsive design
✔ User menu with logout
✔ Bootstrap Icons
✔ Flash messages
✔ Theme support (light/dark)
✔ Permission-based menu visibility
✔ Clean view inheritance
✔ Works perfectly with CI4 + Shield

This layout is the foundation of a scalable admin panel.