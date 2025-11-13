🎨 Bootstrap 5 Form Components Library (CI4)

Reusable Form Components for Admin Panels

Save as:
docs/doc_bootstrap_form_components.md

🎨 Bootstrap 5 Form Components Library
Reusable Inputs for All Admin Forms (CI4 + BS5)

This document provides a drop-in form component system that makes building admin forms dramatically cleaner.

You get:

<x-input> — text, email, number, password

<x-textarea> — multi-line

<x-select> — dropdown

<x-toggle> — checkbox styled as switch

<x-file> — file uploads

<x-repeater> — repeatable groups

Built for CodeIgniter 4 + Bootstrap 5

100% PHP-view based, no Blade/Twig/etc

Designed to work inside any admin theme

📁 Directory Structure

Place all components here:

app/Views/components/


Each component is a plain PHP view snippet.

Add the component loader helper:

app/Helpers/components_helper.php


In app/Config/Autoload.php add:

public $helpers = ['components'];

🧰 1. Component Loader Helper

Create:

app/Helpers/components_helper.php

<?php

if (! function_exists('component')) {
    function component(string $name, array $data = [])
    {
        return view("components/{$name}", $data);
    }
}


Usage example:

<?= component('input', ['name' => 'title', 'label' => 'Title', 'value' => $item->title ?? '' ]) ?>

🧩 2. Input Component

Create:

app/Views/components/input.php

<div class="mb-3">
    <label class="form-label"><?= esc($label ?? ucfirst($name)) ?></label>

    <input
        type="<?= esc($type ?? 'text') ?>"
        name="<?= esc($name) ?>"
        value="<?= esc($value ?? '') ?>"
        class="form-control <?= isset($error) ? 'is-invalid' : '' ?>"
        <?= isset($required) && $required ? 'required' : '' ?>
    >

    <?php if (isset($error)): ?>
        <div class="invalid-feedback"><?= esc($error) ?></div>
    <?php endif; ?>
</div>

Usage
<?= component('input', [
    'name'  => 'title',
    'label' => 'Product Title',
    'value' => $item->title ?? '',
]) ?>


Supports:

type="text"

type="number"

type="email"

type="password"

type="date"

📝 3. Textarea Component

app/Views/components/textarea.php

<div class="mb-3">
    <label class="form-label"><?= esc($label ?? ucfirst($name)) ?></label>

    <textarea
        name="<?= esc($name) ?>"
        rows="<?= esc($rows ?? 4) ?>"
        class="form-control <?= isset($error) ? 'is-invalid' : '' ?>"
        <?= isset($required) && $required ? 'required' : '' ?>
    ><?= esc($value ?? '') ?></textarea>

    <?php if (isset($error)): ?>
        <div class="invalid-feedback"><?= esc($error) ?></div>
    <?php endif; ?>
</div>

Usage
<?= component('textarea', [
    'name'  => 'description',
    'label' => 'Description',
    'rows'  => 5,
    'value' => $item->description ?? '',
]) ?>

📦 4. Select Component

app/Views/components/select.php

<div class="mb-3">
    <label class="form-label"><?= esc($label ?? ucfirst($name)) ?></label>

    <select name="<?= esc($name) ?>" class="form-select <?= isset($error) ? 'is-invalid' : '' ?>">
        <?php foreach (($options ?? []) as $key => $text): ?>
            <option value="<?= esc($key) ?>"
                <?= (string)($value ?? '') === (string)$key ? 'selected' : '' ?>>
                <?= esc($text) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if (isset($error)): ?>
        <div class="invalid-feedback"><?= esc($error) ?></div>
    <?php endif; ?>
</div>

Usage
<?= component('select', [
    'name'    => 'theme',
    'label'   => 'Default Theme',
    'value'   => $settings->theme ?? 'light',
    'options' => [
        'light' => 'Light',
        'dark'  => 'Dark',
    ]
]) ?>

🔘 5. Toggle Switch Component

app/Views/components/toggle.php

<div class="form-check form-switch mb-3">
    <input
        class="form-check-input"
        type="checkbox"
        name="<?= esc($name) ?>"
        id="<?= esc($name) ?>"
        value="1"
        <?= !empty($value) ? 'checked' : '' ?>
    >
    <label class="form-check-label" for="<?= esc($name) ?>">
        <?= esc($label ?? ucfirst($name)) ?>
    </label>
</div>

Usage
<?= component('toggle', [
    'name'  => 'active',
    'label' => 'Active?',
    'value' => $item->active ?? false,
]) ?>

📁 6. File Upload Component

app/Views/components/file.php

<div class="mb-3">
    <label class="form-label"><?= esc($label ?? ucfirst($name)) ?></label>
    <input type="file" name="<?= esc($name) ?>" class="form-control">

    <?php if (!empty($value)): ?>
        <div class="mt-2">
            <small>Current:</small><br>
            <a href="<?= esc($value) ?>" target="_blank">
                <?= basename($value) ?>
            </a>
        </div>
    <?php endif; ?>
</div>

Usage
<?= component('file', [
    'name'  => 'thumbnail',
    'label' => 'Thumbnail',
    'value' => $item->thumbnail ?? '',
]) ?>

🔁 7. Repeater Component (Dynamic Groups)
JS (Global)

Add this once in admin.js:

document.addEventListener('click', function (e) {
    if (e.target.matches('[data-repeater-add]')) {
        const wrap = e.target.closest('[data-repeater]');
        const template = wrap.querySelector('[data-repeater-item-template]');
        const clone = template.cloneNode(true);

        clone.removeAttribute('data-repeater-item-template');
        clone.style.display = '';

        wrap.querySelector('[data-repeater-list]').appendChild(clone);
    }

    if (e.target.matches('[data-repeater-remove]')) {
        e.target.closest('[data-repeater-item]').remove();
    }
});

Component

app/Views/components/repeater.php

<div class="mb-3" data-repeater>
    <label class="form-label"><?= esc($label) ?></label>

    <div data-repeater-list>
        <?php foreach (($value ?? []) as $row): ?>
            <div data-repeater-item class="border rounded p-3 mb-2">
                <?php foreach ($fields as $field => $comp): ?>
                    <?= component($comp['type'], [
                        'name'  => "{$name}[{$field}][]",
                        'label' => $comp['label'],
                        'value' => $row[$field] ?? '',
                    ]) ?>
                <?php endforeach; ?>

                <button type="button" class="btn btn-sm btn-danger" data-repeater-remove>
                    Remove
                </button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Template -->
    <div data-repeater-item-template style="display:none" class="border rounded p-3 mb-2">
        <?php foreach ($fields as $field => $comp): ?>
            <?= component($comp['type'], [
                'name'  => "{$name}[{$field}][]",
                'label' => $comp['label'],
            ]) ?>
        <?php endforeach; ?>

        <button type="button" class="btn btn-sm btn-danger" data-repeater-remove>
            Remove
        </button>
    </div>

    <button type="button" class="btn btn-secondary mt-2" data-repeater-add>
        Add Item
    </button>
</div>

Usage Example
<?= component('repeater', [
    'name'  => 'gallery',
    'label' => 'Image Gallery',
    'value' => $item->gallery ?? [],
    'fields' => [
        'image' => [ 'type' => 'file', 'label' => 'Image File' ],
        'alt'   => [ 'type' => 'input', 'label' => 'Alt Text' ],
    ],
]) ?>

🧪 8. Using Components in a Form
<form method="post" enctype="multipart/form-data">

    <?= csrf_field() ?>

    <?= component('input', [
        'name'  => 'title',
        'label' => 'Title',
        'value' => $item->title ?? '',
        'required' => true,
    ]) ?>

    <?= component('textarea', [
        'name'  => 'description',
        'label' => 'Description',
        'value' => $item->description ?? '',
    ]) ?>

    <?= component('select', [
        'name'    => 'status',
        'label'   => 'Status',
        'value'   => $item->status ?? '',
        'options' => ['draft' => 'Draft', 'published' => 'Published'],
    ]) ?>

    <?= component('toggle', [
        'name'  => 'active',
        'label' => 'Active?',
        'value' => $item->active ?? false,
    ]) ?>

    <button class="btn btn-primary">Save</button>

</form>

🏁 Final Result

You now have a production-grade form system:

✔ Cleaner, DRY views
✔ Reusable form components
✔ Switches, dropdowns, repeaters
✔ Automatically merges with your layout/theme
✔ Ready for CRUD generator integration

Your admin forms will be far easier to build and maintain.
