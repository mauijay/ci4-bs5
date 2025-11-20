<?= $this->extend('layouts/main') ?>

<?= $this->section('head_js') ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "BlogPosting",
  "headline": <?= json_encode($post['title'] ?? '') ?>,
  "description": <?= json_encode($post['summary'] ?? '') ?>,
  "image": <?= json_encode(base_url($post['image'] ?? '/uploads/default_img.jpg')) ?>,
  "author": {
    "@type": "Person",
    "name": <?= json_encode($post['author_name'] ?? 'Author') ?>
  },

  "publisher": {
    "@type": "Organization",
    "name": <?= json_encode(app_settings()->siteName) ?>,
    "logo": {
      "@type": "ImageObject",
      "url": <?= json_encode(base_url(app_settings()->siteLogo)) ?>
    }
  },
  "datePublished": <?= json_encode($post['published_at'] ?? '') ?>,
  "dateModified": <?= json_encode($post['updated_at'] ?? $post['published_at'] ?? '') ?>,
  "mainEntityOfPage": <?= json_encode(current_url()) ?>
}
</script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- BLOG HEADER / HERO -->
    <header class="post-hero py-5 bg-light">
      <div class="container text-center">
        <h1 class="display-5 fw-bold mb-3"><?= esc($post['title'] ?? $title) ?></h1>
        <p class="text-muted">
          <?= esc(date('M j, Y', strtotime($post['published_at'] ?? 'now'))) ?> · 6 min read · By <?= esc($post['author_name'] ?? 'John Doe') ?>
        </p>
      </div>
    </header>

    <!-- FEATURED IMAGE -->
    <section class="post-featured-image">
      <div class="container">
        <?php
          $image    = $post['image'] ?? '/uploads/default_img.jpg';
          $imageAlt = $post['image_alt'] ?? $post['title'] ?? 'Post image';
        ?>
        <img src="<?= esc($image) ?>" class="img-fluid rounded shadow-sm" alt="<?= esc($imageAlt) ?>">
      </div>
    </section>

    <!-- MAIN ARTICLE BODY -->
    <article class="post-content py-5">
      <div class="container col-lg-8">
        <div class="mb-4">
          <a href="<?= site_url(route_to('blog.index')) ?>" class="btn btn-outline-secondary btn-sm">
            &larr; Back to News
          </a>
        </div>
        <?php if (! empty($post['content'])): ?>
          <?= $post['content'] ?>
        <?php else: ?>
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
        <?php endif; ?>
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
              <div class="aspect aspect-16x9 mb-3">
                  <img src="/uploads/CodeIgniter_16x9.jpg" alt="this is the image alt text" loading="lazy">
                </div>
              <div class="card-body">
                <h3 class="h6 card-title">Related Post Title</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">Read More</a>
              </div>
            </div>
          </article>
          <!-- repeat 2 more -->
           <article class="col-md-4">
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
          <article class="col-md-4">
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

  <?= $this->endSection() ?>
