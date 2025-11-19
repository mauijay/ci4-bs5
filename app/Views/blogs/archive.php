<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">

    <header class="text-center mb-5">
      <h1 class="fw-bold">Posts in: <span class="text-primary">Design</span></h1>
      <p class="text-muted">12 posts found</p>
    </header>

    <div class="row g-4">

      <!-- 12 posts loop -->
      <article class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm">
          <img src="images/thumb-cat1.jpg" class="card-img-top" alt="blah blah blah" loading="lazy">
          <div class="card-body">
            <h2 class="h5 card-title">Post Title</h2>
            <p class="text-muted">Short excerpt...</p>
            <a href="#" class="btn btn-sm btn-primary">Read More</a>
          </div>
        </div>
      </article>

      <!-- more posts -->
    </div>

</div>

<?= $this->endSection() ?>
