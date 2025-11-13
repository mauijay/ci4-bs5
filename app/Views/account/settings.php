<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">My Settings</h1>

<?php if (session('message')): ?>
    <div class="alert alert-success"><?= esc(session('message')) ?></div>
<?php endif; ?>

<?php if (session('error')): ?>
    <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>

<form action="<?= site_url('account/settings') ?>" method="post" class="row g-3">
    <?= csrf_field() ?>

    <?php if ($settings->allowUserThemePreference): ?>
        <div class="col-md-4">
            <label for="theme" class="form-label">Theme</label>
            <select name="theme" id="theme" class="form-select">
                <?php foreach ($settings->availableThemes as $theme): ?>
                    <option value="<?= esc($theme) ?>" <?= ($currentTheme ?? $settings->theme) === $theme ? 'selected' : '' ?>>
                        <?= ucfirst($theme) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <div class="col-12 mt-3">
        <button class="btn btn-primary">Save</button>
    </div>
</form>

<?= $this->endSection() ?>
