<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title><?= esc($title ?? app_settings()->siteName) ?></title>
      <!-- Primary Meta Tags -->
      <meta name="title" content="<?= esc($title ?? app_settings()->siteName) ?>">
      <meta name="description" content="Your page or post description goes here. 155–160 chars is ideal.">
      <!-- Canonical -->
      <link rel="canonical" href="<?= current_url() ?>">
      <!-- Open Graph / Facebook -->
      <meta property="og:type" content="website">
      <meta property="og:url" content="<?= current_url() ?> ">
      <meta property="og:title" content="<?= esc($title ?? app_settings()->siteName) ?>">
      <meta property="og:description" content="Your page/post summary.">
      <meta property="og:image" content="https://www.example.com/images/og-image.jpg">
      <!-- Twitter -->
      <meta property="twitter:card" content="summary_large_image">
      <meta property="twitter:url" content="<?= current_url() ?>">
      <meta property="twitter:title" content="<?= esc($title ?? app_settings()->siteName) ?>">
      <meta property="twitter:description" content="Your page/post summary.">
      <meta property="twitter:image" content="https://www.example.com/images/og-image.jpg">
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="/favicon.png">
      <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
  </head>
  <?php
      $settings = app_settings();
      $theme = $settings->theme;
      $currentUser = null;
      $primaryGroup = null;
      if ($settings->allowUserThemePreference && auth()->loggedIn()) {
          $user = auth()->user();
        $currentUser = $user;
        $groups = method_exists($user, 'getGroups') ? (array) $user->getGroups() : [];
        $primaryGroup = $groups[0] ?? null;
          if (! empty($user->theme)) {
              $theme = $user->theme;
          }
      }
  ?>
  <body class="theme-<?= esc($theme) ?>">
    <!-- NAV + OFF-CANVAS -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
      <div class="container">
        <a class="navbar-brand fw-bold" href="<?= site_url(route_to('home.index')) ?>">BrandName</a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileNav"
                aria-controls="mobileNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-none d-lg-block">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="#hero" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="<?= site_url(route_to('blog.index')) ?>" class="nav-link">News</a></li>
            <li class="nav-item"><a href="#services" class="nav-link">Services</a></li>
            <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
            <?php if (auth()->loggedIn()): ?>
              <li class="nav-item">
                  <a class="nav-link" href="<?= site_url(route_to('admin.users.index')) ?>">Users</a>
              </li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav ms-auto align-items-center">
                  <?php if (auth()->loggedIn() && function_exists('url_is') && url_is('admin*')): ?>
                    <li class="nav-item me-3">
                      <form action="<?= site_url(route_to('admin.settings.siteOnline')) ?>" method="post" class="d-flex align-items-center">
                        <?= csrf_field() ?>
                        <input type="hidden" name="siteOnline" value="0">
                        <div class="form-check form-switch m-0">
                          <input class="form-check-input" type="checkbox" name="siteOnline" value="1" id="siteOnlineSwitch" <?= app_settings()->siteOnline ? 'checked' : '' ?> onchange="this.form.submit()">
                          <label class="form-check-label ms-2" for="siteOnlineSwitch">Public</label>
                        </div>
                      </form>
                    </li>
                  <?php endif; ?>
                  <?php if (! auth()->loggedIn()): ?>
                      <li class="nav-item">
                          <a class="nav-link" href="<?= site_url(route_to('auth.login.new')) ?>">login icon</a>
                      </li>
                  <?php else: ?>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <span>avatar icon here...</span>
                          <?php if (! empty($primaryGroup)): ?>
                            <span class="badge bg-secondary text-uppercase ms-2"><?= esc($primaryGroup) ?></span>
                          <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li class="nav-item text-center">
                              <span class="navbar-text me-2">
                                  <?= esc(auth()->user()->username ?? auth()->user()->email) ?>
                              </span>
                          </li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="<?= site_url(route_to('account.settings.index')) ?>">My Account</a></li>
                          <li><a class="dropdown-item" href="<?= site_url(route_to('admin.profile.index')) ?>">Admin Profile</a></li>
                          <li><a class="dropdown-item" href="<?= site_url(route_to('admin.dashboard.index')) ?>">Admin</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">Logout</a></li>
                        </ul>
                      </li>
                  <?php endif; ?>
              </ul>
        </div>
      </div>
    </nav>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNav">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav">
          <li class="nav-item mb-2"><a href="#hero" class="nav-link">Home</a></li>
          <li class="nav-item mb-2"><a href="#features" class="nav-link">Features</a></li>
          <li class="nav-item mb-2"><a href="#services" class="nav-link">Services</a></li>
          <li class="nav-item mb-2"><a href="#contact" class="nav-link">Contact</a></li>
          <?php if (auth()->loggedIn()): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url(route_to('account.settings.index')) ?>">My Settings</a>
            </li>
            <hr>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url(route_to('admin.profile.index')) ?>">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url(route_to('admin.dashboard.index')) ?>">Admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url(route_to('admin.users.index')) ?>">Users</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <!--BreadCrumbs-->
    <nav class="breadcrumb-wrapper" aria-label="Breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
        <li class="breadcrumb-item active" aria-current="page">Post Title</li>
      </ol>
    </nav>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://www.example.com/"
          },
          {
            "@type": "ListItem",
            "position": 2,
            "name": "Blog",
            "item": "https://www.example.com/blog"
          },
          {
            "@type": "ListItem",
            "position": 3,
            "name": "Design",
            "item": "https://www.example.com/blog/design"
          },
          {
            "@type": "ListItem",
            "position": 4,
            "name": "Post Title"
          }
        ]
      }
    </script>
    <main class="py-5">
      <!-- MAIN CONTENT -->
      <?= $this->renderSection('content') ?>
    </main>
    <!-- CTA -->
    <section class="cta-section py-5 text-center">
      <div class="container">
        <h2 class="h1 mb-3">Ready to Get Started?</h2>
        <p class="lead mb-4">
          Use this starter layout as the foundation for your next Bootstrap + SCSS project.
        </p>
        <a href="#contact" class="btn btn-primary btn-lg">Contact Us</a>
      </div>
    </section>
    <!-- FOOTER / CONTACT -->
    <footer id="contact" class="py-4 bg-dark text-light text-center">
      <div class="container">
        <p class="mb-2">Need help or want to collaborate? Drop us a line.</p>
        <a href="mailto:hello@example.com" class="text-light d-block mb-3">hello@example.com</a>
        <p class="mb-0">&copy; 2025 My Bootstrap SCSS Website.</p>
      </div>
    </footer>
    <script src="<?= base_url('assets/js/app.bundle.js') ?>" defer></script>
  </body>
</html>
