<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1 class="mb-4">Users</h1>

<div class="card">
    <div class="card-body table-responsive">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username / Email</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>

            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user->id) ?></td>

                    <td>
                        <?= esc($user->username ?? $user->email) ?><br>
                        <small class="text-muted"><?= esc($user->email) ?></small>
                    </td>

                    <td><?= esc($user->getMeta('full_name')) ?></td>
                    <td><?= esc($user->getMeta('phone')) ?></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>

<?= $this->endSection() ?>
