<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Create Account</h1>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('register') ?>" method="post" class="row g-3">
    <?= csrf_field() ?>

    <div class="col-md-6">
        <label for="username" class="form-label">Username</label>
        <input type="text"
               name="username"
               id="username"
               value="<?= old('username') ?>"
               class="form-control"
               required>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email"
               name="email"
               id="email"
               value="<?= old('email') ?>"
               class="form-control"
               required>
    </div>

    <div class="col-md-6">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text"
               name="full_name"
               id="full_name"
               value="<?= old('full_name') ?>"
               class="form-control"
               required>
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="text"
               name="phone"
               id="phone"
               value="<?= old('phone') ?>"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label for="password" class="form-label">Password</label>
        <input type="password"
               name="password"
               id="password"
               class="form-control"
               required>
    </div>

    <div class="col-md-6">
        <label for="password_confirm" class="form-label">Confirm Password</label>
        <input type="password"
               name="password_confirm"
               id="password_confirm"
               class="form-control"
               required>
    </div>

    <div class="col-12 mt-3">
        <button class="btn btn-primary" type="submit">Register</button>
    </div>
</form>

<?= $this->endSection() ?>
