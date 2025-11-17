<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- MAIN CONTENT -->
  <main class="py-5">
    <!-- HERO -->
    <header id="hero" class="hero d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">

          <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold mb-3">
              Build Modern, Responsive Sites with Bootstrap & SCSS
            </h1>
            <p class="lead mb-4">
              A clean starter layout with a custom theme, reusable mixins, and a mobile-first grid.
            </p>
            <a href="#features" class="btn btn-primary btn-lg me-2 mb-2">View Features</a>
            <a href="#contact" class="btn btn-outline-light btn-lg mb-2">Contact Us</a>
          </div>

          <div class="col-lg-6 text-center">
            <!-- Optional image -->
            <img src="../dist/images/hero.svg" class="img-fluid" alt="Hero illustration" />
          </div>

        </div>
      </div>
    </header>
    <!-- FEATURES -->
    <section id="features" class="py-5 bg-light">
      <div class="container">
        <div class="row mb-4 text-center">
          <div class="col">
            <h2 class="h1 mb-3">Features</h2>
            <p class="text-muted mb-0">
              Everything you need to ship a polished Bootstrap + SCSS site.
            </p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-3">Custom Theme</h3>
                <p class="card-text">
                  Override Bootstrap variables and keep your brand identity consistent across all components.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-3">Reusable Mixins</h3>
                <p class="card-text">
                  Breakpoints, spacing, and flex helpers make your SCSS clean, DRY, and easy to scale.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-3">Mobile-First Grid</h3>
                <p class="card-text">
                  Built on top of Bootstrap’s grid plus your own flexible grid utilities where needed.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- SERVICES / CARDS -->
    <section id="services" class="py-5">
      <div class="container">
        <div class="row mb-4 text-center">
          <div class="col">
            <h2 class="h1 mb-3">What We Do</h2>
            <p class="text-muted mb-0">
              Use this section for services, product highlights, or “how it works”.
            </p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-2">Responsive Layouts</h3>
                <p class="card-text">
                  Mobile-first design using Bootstrap breakpoints and custom SCSS utilities.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-2">Reusable Components</h3>
                <p class="card-text">
                  Navbars, heroes, cards, and CTAs that you can drop into any new page quickly.
                </p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <h3 class="h5 card-title mb-2">SCSS Architecture</h3>
                <p class="card-text">
                  A logical folder structure for abstracts, base styles, components, and pages.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
      <!-- Example HTML Using the Custom Grid -->
    <section class="py-5">
      <div class="container">
        <h2 class="h2 mb-4 text-center">Custom Grid Example</h2>
        <div class="grid">
          <div class="grid-item">
            <div class="card h-100 shadow-sm">
              <div class="card-body">Item 1</div>
            </div>
          </div>
          <div class="grid-item">
            <div class="card h-100 shadow-sm">
              <div class="card-body">Item 2</div>
            </div>
          </div>
          <div class="grid-item">
            <div class="card h-100 shadow-sm">
              <div class="card-body">Item 3</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<?= $this->endSection() ?>

