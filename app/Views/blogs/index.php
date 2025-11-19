<?= $this->extend('layouts/main') ?>

<?= $this->section('head_js') ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Blog",
  "url": "https://www.example.com/blog",
  "name": "Blog",
  "description": "Latest posts from YourSiteName"
}
</script>


<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
  <div class="row">

    <!-- MAIN CONTENT -->
    <div class="col-lg-8">

      <!-- ======================
        FEATURED POST SECTION
      ======================= -->

      <section class="featured-slider bg-light">
        <div class="container">
          <header class="mb-4 text-center">
            <h1 class="display-5 fw-bold">Latest From the Blog</h1>
            <p class="lead text-muted">Featured stories</p>
          </header>
          <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($featured_posts as $index => $post): ?>
              <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <div class="aspect aspect-2x3">
                      <img src="<?= esc($post['image']) ?>" alt="<?= esc($post['image_alt']) ?>">
                    </div>
                  </div>
                  <div class="col-md-6 p-4">
                    <h3 class="h4"><?= esc($post['title']) ?></h3>
                    <p class="text-muted"><?= esc($post['summary']) ?></p>
                    <a href="<?= site_url(route_to('blog.show', $post['slug'])) ?>" class="btn btn-primary">Read More</a>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>



            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>

          </div>
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
            <?php if (empty($posts)): ?>
              <p>No posts found.</p>
            <?php else: ?>
              <?php foreach ($posts as $post): ?>
                <?php
                    $image      = $post['image'] ?? '';
                    $imageAlt   = $post['image_alt'] ?? '';
                    $imageBase  = pathinfo($image, PATHINFO_FILENAME); // e.g. "my-beautiful-ci-flame-1200"
                    $imageBase  = preg_replace('/-(\d+)$/', '', $imageBase); // strip trailing -1200 -> "my-beautiful-ci-flame"

                    // Check if optimized directory exists; use fallback if not
                    $publicPath      = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'optimized' . DIRECTORY_SEPARATOR . $imageBase;
                    $hasOptimizedSet = is_dir($publicPath);
                ?>
                <article class="col-12 col-md-6 col-lg-4">
                  <div class="card h-100 shadow-sm">
                    <div class="aspect aspect-16x9 mb-3">
                      <?php if ($hasOptimizedSet): ?>
                        <!-- responsive picture using optimized set -->
                        <picture>
                          <source type="image/webp" srcset="
                            /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-300.webp 300w,
                            /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-600.webp 600w,
                            /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-900.webp 900w,
                            /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-1200.webp 1200w
                          ">
                          <img
                            src="/uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-1200.jpg"
                            srcset="
                              /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-300.jpg 300w,
                              /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-600.jpg 600w,
                              /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-900.jpg 900w,
                              /uploads/optimized/<?= esc($imageBase) ?>/<?= esc($imageBase) ?>-1200.jpg 1200w
                            "
                            sizes="(min-width: 992px) 33vw, (min-width: 768px) 50vw, 100vw"
                            alt="<?= esc($imageAlt) ?>"
                            loading="lazy"
                            decoding="async"
                            class="img-fluid"
                          >
                        </picture>
                      <?php else: ?>
                        <!-- fallback to original single image -->
                        <img
                          src="/uploads/<?= esc($image) ?>"
                          alt="<?= esc($imageAlt) ?>"
                          loading="lazy"
                          decoding="async"
                          class="img-fluid"
                        >
                      <?php endif; ?>
                    </div>
                    <div class="card-body">
                      <h3 class="h5 card-title"><?= esc($post['title']) ?></h3>
                      <p class="card-text text-muted"><?= esc($post['summary']) ?></p>
                      <a href="<?= site_url(route_to('blog.show', $post['slug'])) ?>" class="btn btn-sm btn-primary">Read More</a>
                    </div>
                  </div>
                </article>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <?= $pager->links('news-group', 'custom_full') ?>
      <section>
      <!-- ======================
          Sample Card
      ======================= -->
      <h2>Sample card, remove or replace this section</h2>
      <article class="blog-card card h-100 shadow-sm">
        <div class="aspect aspect-16x9 mb-3">
          <picture>
            <source type="image/webp" srcset="
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-300.webp 300w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-600.webp 600w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-900.webp 900w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-1200.webp 1200w
            ">
            <img
              src="/uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-1200.jpg"
              srcset="
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-300.jpg 300w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-600.jpg 600w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-900.jpg 900w,
                /uploads/optimized/my-beautiful-ci-flame/my-beautiful-ci-flame-1200.jpg 1200w
              "
              sizes="100vw"
              alt="My Beautiful Ci Flame"
              loading="lazy"
              decoding="async"
              class="img-fluid"
            >
          </picture>
        </div>
        <div class="card-body">
          <h3 class="h5 card-title">Blog Post Title</h3>
          <p class="card-text text-muted">Short excerpt that introduces the post...</p>
          <a href="#" class="btn btn-sm btn-primary">Read More</a>
        </div>
      </article>
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
                <div class="aspect aspect-16x9 mb-3">
                  <img src="/uploads/CodeIgniter_16x9.jpg" alt="this is the image alt text" loading="lazy">
                </div>
                <div class="card-body">
                  <h3 class="h6 card-title">Related Post Title</h3>
                  <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                </div>
              </div>
            </article>

            <!-- Repeat for 2 more... -->
            <article class="col-12 col-md-4">
              <div class="card h-100 shadow-sm">
                <div class="aspect aspect-16x9 mb-3">
                  <img src="/uploads/CodeIgniter_16x9.jpg" alt="this is the image alt text" loading="lazy">
                </div>
                <div class="card-body">
                  <h3 class="h6 card-title">Related Post Title</h3>
                  <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
                </div>
              </div>
            </article>
            <article class="col-12 col-md-4">
              <div class="card h-100 shadow-sm">
                <div class="aspect aspect-16x9 mb-3">
                  <img src="/uploads/CodeIgniter_16x9.jpg" alt="this is the image alt text" loading="lazy">
                </div>
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


    </div>

    <!-- SIDEBAR -->
    <aside class="col-lg-4 sidebar">

      <!-- Search -->
      <div class="sidebar-widget mb-4">
        <h3 class="h6 mb-3">Search</h3>
        <form>
          <input type="text" class="form-control" placeholder="Search posts...">
        </form>
      </div>

      <!-- Categories -->
      <div class="sidebar-widget mb-4">
        <h3 class="h6 mb-3">Categories</h3>
        <?php if (! empty($categories)): ?>
          <ul class="list-unstyled">
            <?php foreach ($categories as $category): ?>
              <li class="mb-1">
                <a href="<?= site_url(route_to('blog.categories.show', $category['slug'])) ?>">
                  <?= esc($category['name']) ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="text-muted mb-0">No categories yet.</p>
        <?php endif; ?>
      </div>

      <!-- Tags -->
      <div class="sidebar-widget mb-4">
        <h3 class="h6 mb-3">Tags</h3>
        <?php if (! empty($tags)): ?>
          <div class="d-flex flex-wrap gap-2">
            <?php foreach ($tags as $tag): ?>
              <a
                href="<?= site_url(route_to('blog.tags.show', $tag['slug'])) ?>"
                class="badge bg-secondary text-decoration-none"
              >
                <?= esc($tag['name']) ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-muted mb-0">No tags yet.</p>
        <?php endif; ?>
      </div>
    </aside>
  </div>
</div>

<?= $this->endSection() ?>
