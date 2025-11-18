<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- BLOG HEADER / HERO -->
    <header class="post-hero py-5 bg-light">
      <div class="container text-center">
        <h1 class="display-5 fw-bold mb-3"><?= esc($title) ?></h1>
        <p class="text-muted">
          Published on Jan 20, 2025 · 6 min read · By John Doe
        </p>
      </div>
    </header>

    <!-- FEATURED IMAGE -->
    <section class="post-featured-image">
      <div class="container">
        <img src="images/post-hero.jpg" class="img-fluid rounded shadow-sm" alt="Post Image">
      </div>
    </section>

    <!-- MAIN ARTICLE BODY -->
    <article class="post-content py-5">
      <div class="container col-lg-8">

        <p class="lead">
          This is the introductory paragraph of your blog post. It should be engaging and lead the reader into the content.
        </p>

        <h2>Section Heading</h2>
        <p>Your blog content goes here...</p>

        <h3>Subsection</h3>
        <p>More content here...</p>

        <blockquote class="blockquote my-4 p-4 bg-light border-start border-4 border-primary">
          “A meaningful quote or highlight from the article.”
        </blockquote>

        <p>Final thoughts...</p>

      </div>
    </article>

    <!-- RELATED POSTS -->
    <section class="related-posts py-5 bg-light">
      <div class="container">
        <header class="text-center mb-4">
          <h2 class="h4">Related Posts</h2>
        </header>

        <div class="row g-4">
          <!-- 3 articles -->
          <article class="col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="images/related1.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article>

          <!-- repeat 2 more -->
           <article class="col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="images/related1.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article>
          <article class="col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="images/related1.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

  <?= $this->endSection() ?>
