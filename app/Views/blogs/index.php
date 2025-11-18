<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <!-- ======================
         FEATURED POST SECTION
    ======================= -->
    <section class="featured-post py-5">
      <div class="container">
        <header class="mb-4 text-center">
          <h1 class="display-5 fw-bold">Latest From the Blog</h1>
          <p class="lead text-muted">Featured story</p>
        </header>

        <article class="card featured-article shadow-sm">
          <div class="row g-0 align-items-center">

            <div class="col-md-6">
              <img src="images/featured.jpg" class="img-fluid rounded-start" alt="Featured Post Image">
            </div>

            <div class="col-md-6 p-4">
              <h2 class="h3">Amazing Featured Post Title</h2>
              <p class="text-muted">
                A short summary of your featured post. Enough to grab attention and encourage readers to continue.
              </p>
              <a href="<?= site_url(route_to('blogs.show', 1)) ?>" class="btn btn-primary">Read More</a>
            </div>

          </div>
        </article>
      </div>
    </section>


    <!-- ======================
         BLOG INDEX (12 POSTS)
    ======================= -->
    <section class="blog-index py-5">
      <div class="container">

        <header class="mb-4">
          <h2 class="h4">All Posts</h2>
        </header>

        <div class="row g-4">

          <!-- Repeat this 12 times using a loop or CMS -->
          <article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article>

          <!-- (11 more cards...) -->
           <article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
              <img src="images/thumb1.jpg" class="card-img-top" alt="">
              <div class="card-body">
                <h3 class="h5 card-title">Blog Post Title</h3>
                <p class="card-text text-muted">Short summary excerpt for the blog post...</p>
                <a href="#" class="btn btn-sm btn-primary">Read More</a>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>


    <!-- ======================
         RELATED POSTS (3)
    ======================= -->
    <section class="related-posts py-5 bg-light">
      <div class="container">

        <header class="text-center mb-4">
          <h2 class="h4">Related Posts</h2>
        </header>

        <div class="row g-4">

          <!-- 3 related posts -->
          <article class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="images/related1.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article>

          <!-- Repeat for 2 more... -->
           <article class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
              <img src="images/related1.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article><article class="col-12 col-md-4">
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


    <!-- ======================
         CTA SECTION
    ======================= -->
    <section class="cta-section py-5 text-center">
      <div class="container">
        <h2 class="h3 mb-3">Want More Stories?</h2>
        <p class="text-muted mb-4">Subscribe and never miss an update.</p>
        <a href="#" class="btn btn-primary btn-lg">Subscribe Now</a>
      </div>
    </section>

  <?= $this->endSection() ?>
