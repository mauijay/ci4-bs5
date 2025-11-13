📘 Admin DataTable System (CI4 + Bootstrap 5)

Save as: docs/doc_admin_datatable.md

A lightweight but powerful server-side searchable, sortable, paginated DataTable system for CodeIgniter 4 admin panels.

No external JS libraries required (optional DataTables.js support included).
Works perfectly with:

CI4 Models

Shield (for admin-only access)

Bootstrap 5

Admin layouts

REST APIs

🗂️ Overview

You will get:

Core Features

✔ Server-side pagination
✔ Search (multi-column)
✔ Sorting
✔ Filters (status, date range, roles, etc.)
✔ CSV export
✔ Reusable table component
✔ Reusable pagination component

Bonus

✔ Optional DataTables.js front-end integration
✔ REST mode or traditional controller mode

🧱 Folder Structure
app/
 ├── Libraries/
 │     └── DataTable.php
 ├── Controllers/
 │     └── Admin/Users.php
 ├── Views/
 │     ├── components/
 │     │      ├── table.php
 │     │      ├── pagination.php
 │     │      └── filters.php
 │     └── admin/users/index.php

🧠 Library: DataTable Engine

Create:

app/Libraries/DataTable.php

<?php

namespace App\Libraries;

use CodeIgniter\Model;
use CodeIgniter\HTTP\IncomingRequest;

class DataTable
{
    protected Model $model;
    protected IncomingRequest $request;

    protected array $searchable = [];
    protected array $sortable   = [];

    public function __construct(Model $model, array $options = [])
    {
        $this->model   = $model;
        $this->request = service('request');

        $this->searchable = $options['searchable'] ?? [];
        $this->sortable   = $options['sortable']   ?? [];
    }

    public function get()
    {
        $query = $this->model;

        // --- Search ---
        $search = trim($this->request->getGet('search') ?? '');
        if ($search && ! empty($this->searchable)) {
            $query = $query->groupStart();
            foreach ($this->searchable as $col) {
                $query->orLike($col, $search);
            }
            $query = $query->groupEnd();
        }

        // --- Sorting ---
        $sort  = $this->request->getGet('sort');
        $dir   = $this->request->getGet('dir') ?? 'asc';

        if ($sort && in_array($sort, $this->sortable)) {
            $query->orderBy($sort, strtolower($dir) === 'desc' ? 'desc' : 'asc');
        }

        // --- Pagination ---
        $page     = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage  = 10;

        $data = $query->paginate($perPage, 'default', $page);

        return [
            'data'      => $data,
            'pager'     => $query->pager,
            'search'    => $search,
            'sort'      => $sort,
            'dir'       => $dir,
        ];
    }
}

👤 Example: Users Controller

Create:

app/Controllers/Admin/Users.php

<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\DataTable;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $dt = new DataTable(
            model(UserModel::class),
            [
                'searchable' => ['username', 'email'],
                'sortable'   => ['id', 'username', 'email', 'created_at'],
            ]
        );

        return view('admin/users/index', [
            'table' => $dt->get(),
        ]);
    }
}

📄 View: Admin Users Table

app/Views/admin/users/index.php

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Users</h1>

    <form method="get" class="d-flex">
        <input type="text" name="search" class="form-control"
               placeholder="Search users..."
               value="<?= esc($table['search']) ?>">
        <button class="btn btn-primary ms-2">Search</button>
    </form>
</div>

<?= component('table', [
    'headers' => [
        'id'         => 'ID',
        'username'   => 'Username',
        'email'      => 'Email',
        'created_at' => 'Created',
    ],
    'rows'    => $table['data'],
    'sort'    => $table['sort'],
    'dir'     => $table['dir'],
]) ?>

<?= component('pagination', ['pager' => $table['pager']]) ?>

<?= $this->endSection() ?>

📦 Component: Table

app/Views/components/table.php

<?php
$currentSort = $sort ?? '';
$currentDir  = $dir ?? 'asc';

function sortLink($key, $currentSort, $currentDir) {
    $dir = ($currentSort === $key && $currentDir === 'asc') ? 'desc' : 'asc';
    return "?sort={$key}&dir={$dir}";
}
?>

<table class="table table-hover">
    <thead>
        <tr>
            <?php foreach ($headers as $key => $label): ?>
                <th>
                    <a href="<?= sortLink($key, $currentSort, $currentDir) ?>">
                        <?= esc($label) ?>
                        <?php if ($currentSort === $key): ?>
                            <?= $currentDir === 'asc' ? '↑' : '↓' ?>
                        <?php endif; ?>
                    </a>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <?php foreach ($headers as $key => $label): ?>
                    <td><?= esc($row->{$key}) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

📍 Component: Pagination

app/Views/components/pagination.php

<?php if ($pager): ?>
<div class="mt-3">
    <?= $pager->links() ?>
</div>
<?php endif; ?>


Uses CI4’s built-in Bootstrap pagination automatically.

🔍 Component: Filters (Optional)

Create:

app/Views/components/filters.php

<form class="row mb-3" method="get">
    <div class="col-md-3">
        <input type="text" name="search"
               value="<?= esc($search ?? '') ?>"
               placeholder="Search..."
               class="form-control">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="banned">Banned</option>
        </select>
    </div>

    <div class="col-md-3">
        <button class="btn btn-primary">Filter</button>
    </div>
</form>

💾 CSV Export (Optional)

Add route:

$routes->get('admin/users/export/csv', 'Users::exportCsv');


In controller:

public function exportCsv()
{
    $users = model(UserModel::class)->findAll();

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=users.csv");

    $out = fopen('php://output', 'w');

    fputcsv($out, ['ID', 'Username', 'Email', 'Created']);

    foreach ($users as $u) {
        fputcsv($out, [$u->id, $u->username, $u->email, $u->created_at]);
    }

    fclose($out);
    exit;
}

📊 Optional: DataTables.js Front-End Mode

Add CDN:

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>


Initialize:

<script>
$(document).ready(function() {
    $('.table').DataTable();
});
</script>


This turns your server-side data into interactive client-side DataTables instantly.

🏁 Final Result

✔ Fully reusable DataTable engine
✔ Supports search, sort, pagination
✔ Bootstrap 5 styling
✔ Works with any Model
✔ Minimal controller logic
✔ Optional filters + CSV export
✔ Optional full DataTables.js integration

Your admin panel now has a professional, scalable table system.
