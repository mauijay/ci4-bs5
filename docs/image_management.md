I’ll give you a complete modern image optimization system compatible with Bootstrap, SCSS, and your blog layout.

You get:

Lazyloading strategy

Responsive images with srcset + sizes

Art-direction with <picture> for mobile cropping

High-DPI (retina) images

WebP + JPEG fallbacks

Aspect-ratio placeholders (no layout shift)

SCSS utilities to automate it

Everything works even in static sites and CMS-driven sites.

1️⃣ Lazy Loading (Native HTML5)

Simply add:

<img src="images/post.jpg" alt="Post image" loading="lazy">

Always lazyload:

Blog index thumbnails

Related post images

Sidebar images

Footer images

Never lazyload:

Above-the-fold hero image

Logo

Anything in the navigation

2️⃣ Responsive Images with srcset

This ensures the browser downloads the smallest correct image for each device.

Example blog thumbnail:
<img
  src="images/post-600.jpg"
  srcset="
    images/post-300.jpg 300w,
    images/post-600.jpg 600w,
    images/post-900.jpg 900w
  "
  sizes="(max-width: 576px) 100vw,
         (max-width: 992px) 50vw,
         33vw"
  alt="Post Title"
  loading="lazy">

What this does:

Mobile loads: 300px version

Tablets load: 600px version

Desktops load: 900px version

Huge performance win.

3️⃣ Using <picture> for Format Switching (WebP + JPEG fallback)
<picture>
  <source srcset="images/post-600.webp" type="image/webp">
  <source srcset="images/post-600.jpg" type="image/jpeg">
  <img src="images/post-600.jpg" alt="Post title" loading="lazy">
</picture>

Why:

WebP is smaller, loads faster

Safari fallback to JPEG included

4️⃣ Art Direction (Mobile Cropping)

Use when you want different crops on mobile vs desktop (news sites use this heavily).

<picture>

  <!-- mobile crop -->
  <source
    media="(max-width: 767px)"
    srcset="images/post-mobile-crop.webp"
    type="image/webp">

  <!-- desktop crop -->
  <source
    media="(min-width: 768px)"
    srcset="images/post-desktop-crop.webp"
    type="image/webp">

  <!-- fallback -->
  <img src="images/post-desktop-crop.jpg"
       alt="Post Title"
       loading="lazy">
</picture>


Now you can show a tall portrait crop on mobile
and a wide landscape crop on desktop.

5️⃣ Retina Images for High DPI Screens

If you have high-res versions:

<img
  src="images/post-600.jpg"
  srcset="
    images/post-600.jpg 1x,
    images/post-1200.jpg 2x
  "
  alt="Post image"
  loading="lazy">

6️⃣ Combine with Aspect Ratio Utilities (you already have)

Example:

<div class="aspect aspect-16x9">
  <img
    src="images/post-600.jpg"
    srcset="
      images/post-300.jpg 300w,
      images/post-600.jpg 600w,
      images/post-900.jpg 900w
    "
    sizes="(max-width: 576px) 100vw,
           (max-width: 992px) 50vw,
           33vw"
    alt="Post"
    loading="lazy">
</div>


This gives you:

no layout shift (LCP improvement)

responsive sizes

lazyloading

proper cropping

7️⃣ SCSS Helper Classes to Standardize Images

Create:
scss/utilities/_images.scss

img,
picture {
  max-width: 100%;
  height: auto;
  display: block;
}

.img-cover {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.img-contain {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.img-rounded {
  border-radius: .75rem;
}

.img-shadow {
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.08);
}


Import:

@import "utilities/images";

8️⃣ Recommended Folder Structure for Optimized Images
/images/
    /posts/
        post-title-300.jpg
        post-title-600.jpg
        post-title-900.jpg
        post-title-1200.jpg
        post-title-mobile-crop.jpg
        post-title.webp
    /authors/
    /thumbnails/
    /hero/

9️⃣ Checklist for Every Image on Your Site (SEO + Performance)

 Provide WebP

 Provide fallback JPEG/PNG

 Use srcset for small/medium/large

 Use sizes to let the browser choose

 Add loading="lazy" (below the fold only)

 Wrap in .aspect for best CLS score

 Use <picture> for art direction

 Use retina images when available

 Compress everything (80% JPG / 75% WebP)
