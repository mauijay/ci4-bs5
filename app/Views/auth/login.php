<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Login') ?></title>
    <link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header text-center fw-semibold">Login</div>
                <div class="card-body">
                    <?php if (session('message')): ?>
                        <div class="alert alert-success small mb-3"><?= esc(session('message')) ?></div>
                    <?php endif; ?>
                    <?php if (session('error')): ?>
                        <div class="alert alert-danger small mb-3"><?= esc(session('error')) ?></div>
                    <?php endif; ?>
                    <?php if ($errors = session('errors')): ?>
                        <div class="alert alert-danger small mb-3">
                            <ul class="mb-0 ps-3">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('login') ?>" novalidate>
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email or Username</label>
                            <input type="text" name="login" value="<?= old('login') ?>" class="form-control" required autofocus />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" />
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="text-center small">
                            <a href="<?= site_url('register') ?>">Need an account?</a>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted small mt-3">&copy; <?= date('Y') ?> App</p>
        </div>
    </div>
</div>
</body>
</html>
