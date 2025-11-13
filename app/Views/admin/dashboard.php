<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="list-group">
            <a href="<?= site_url('admin') ?>" class="list-group-item list-group-item-action active">
                Dashboard
            </a>
            <a href="<?= site_url('admin/users') ?>" class="list-group-item list-group-item-action">
                Users
            </a>
        </div>
    </div>

    <div class="col-md-9">
        <h1 class="mb-4">Admin Dashboard</h1>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Logged-in User</h5>
                        <p class="card-text mb-1">
                            <?= esc(auth()->user()->username ?? auth()->user()->email) ?>
                        </p>
                        <span class="badge bg-primary">ID: <?= esc(auth()->user()->id) ?></span>
                    </div>
                </div>
            </div>
            <!-- Add more admin cards/widgets here -->
        </div>
    </div>
</div>
<?= $this->endSection() ?>
