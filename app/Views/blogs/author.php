<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">

  <!-- Author Header -->
  <header class="author-header text-center mb-5">
    <img src="images/author.jpg" alt="" class="rounded-circle mb-3" width="120">
    <h1 class="fw-bold mb-2">John Doe</h1>
    <p class="text-muted col-lg-6 mx-auto">
      Short bio about the author. Great for highlighting their expertise and personality.
    </p>
  </header>

  <!-- Author's Posts -->
  <div class="row g-4">

    <!-- Loop -->
    <article class="col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="images/thumb-author1.jpg" class="card-img-top" alt="" loading="lazy">
        <div class="card-body">
          <h2 class="h5 card-title">Post Title</h2>
          <p class="text-muted">Summary excerpt...</p>
          <a href="#" class="btn btn-sm btn-primary">Read More</a>
        </div>
      </div>
    </article>

    <!-- More posts -->
  </div>
</div>

<?= $this->endSection() ?>
