<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container">

      <!-- Search summary -->
      <header class="mb-5 text-center">
        <h1 class="fw-bold">Search Results</h1>
        <p class="text-muted">Showing results for: <span class="text-primary">“design”</span></p>
      </header>

      <!-- Results -->
      <div class="row g-4">

        <!-- Search result item -->
        <article class="col-md-6">
          <div class="card h-100 shadow-sm">
            <div class="aspect aspect-16x9">
              <img src="images/post1.jpg" alt="">
            </div>
            <div class="card-body">
              <h2 class="h5 card-title">Post Title Matches Query</h2>
              <p class="text-muted">Excerpt that includes the search keyword...</p>
              <a href="#" class="btn btn-sm btn-primary">Read More</a>
            </div>
          </div>
        </article>

        <!-- Repeat for each result -->

      </div>

      <!-- Pagination -->
      <nav class="mt-5" aria-label="Search results pagination">
        <ul class="pagination justify-content-center">
          <li class="page-item disabled">
            <a class="page-link">Prev</a>
          </li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>

    </div>

  <?= $this->endSection() ?>
