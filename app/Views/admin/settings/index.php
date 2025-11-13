<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Site Settings</h1>

<?php if (session('message')): ?>
    <div class="alert alert-success"><?= esc(session('message')) ?></div>
<?php endif; ?>

<form action="<?= site_url('admin/settings') ?>" method="post" class="row g-3">
    <?= csrf_field() ?>

    <div class="col-md-6">
        <label class="form-label">Site Name</label>
        <input type="text" name="siteName"
               value="<?= esc($settings->siteName) ?>"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Default Theme</label>
        <select name="theme" class="form-select">
            <?php foreach ($settings->availableThemes as $theme): ?>
                <option value="<?= $theme ?>" <?= $settings->theme === $theme ? 'selected' : '' ?>>
                    <?= ucfirst($theme) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input"
               type="checkbox" name="allowUserThemePreference"
               <?= $settings->allowUserThemePreference ? 'checked' : '' ?>>
        <label class="form-check-label">Allow User Theme Preference</label>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input"
               type="checkbox" name="maintenanceMode"
               <?= $settings->maintenanceMode ? 'checked' : '' ?>>
        <label class="form-check-label">Maintenance Mode</label>
    </div>

    <div class="col-md-3 form-check mt-4">
        <input class="form-check-input"
               type="checkbox" name="adminRegistrationOnly"
               <?= $settings->adminRegistrationOnly ? 'checked' : '' ?>>
        <label class="form-check-label">Admin Registration Only</label>
    </div>

    <div class="col-12 mt-3">
        <button class="btn btn-primary">Save</button>
    </div>
</form>

<?= $this->endSection() ?>
