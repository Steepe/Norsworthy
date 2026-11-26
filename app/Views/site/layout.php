<?php $segment = service('uri')->getSegment(1); $home = $segment === ''; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Norsworthy Farms — responsible oil palm cultivation, processing and quality products.">
  <title><?= esc($title ?? 'Norsworthy Farms') ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/site.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/contact.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/reference.css') ?>">
</head>
<body class="<?= $home ? 'is-home' : 'is-inner' ?>">
  <header class="ref-header">
    <div class="ref-header-shell">
      <a class="ref-brand" href="<?= site_url('/') ?>"><img src="<?= base_url('assets/images/Norsworthy-Logo-1.png') ?>" alt="Norsworthy Farms"><span>Norsworthy <b>Farms</b></span></a>
      <button class="ref-menu" aria-expanded="false" aria-controls="ref-nav">Menu</button>
      <nav id="ref-nav" class="ref-nav">
        <a class="<?= $home ? 'active' : '' ?>" href="<?= site_url('/') ?>"<?= $home ? ' aria-current="page"' : '' ?>>Home</a>
        <a class="<?= $segment === 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">About</a>
        <a class="<?= $segment === 'services' ? 'active' : '' ?>" href="<?= site_url('services') ?>">What we do</a>
        <a class="<?= $segment === 'projects' ? 'active' : '' ?>" href="<?= site_url('projects') ?>">Projects</a>
        <a class="<?= $segment === 'partnerships' ? 'active' : '' ?>" href="<?= site_url('partnerships') ?>">Partnerships</a>
        <a class="<?= $segment === 'news' ? 'active' : '' ?>" href="<?= site_url('news') ?>">News</a>
        <a class="mobile-contact" href="<?= site_url('contact') ?>">Contact</a>
      </nav>
      <a class="ref-contact" href="<?= site_url('contact') ?>">Contact us <span>↗</span></a>
    </div>
  </header>
  <main><?= $this->renderSection('content') ?></main>
  <?php if (! $home && $segment !== 'contact'): ?><section class="v3-cta inner-cta"><p class="v3-eyebrow">Get in touch</p><h2>Let’s grow<br><em>something lasting.</em></h2><div><a class="v3-button lime" href="<?= site_url('contact') ?>?type=Bulk%20palm%20oil">Buy palm oil <b>↗</b></a><a class="v3-button clear" href="<?= site_url('contact') ?>?type=Seedlings">Order seedlings <b>↗</b></a><a class="v3-button clear" href="<?= site_url('contact') ?>?type=Partnership%20%2F%20investment">Partner or invest <b>↗</b></a></div></section><?php endif ?>
  <footer class="ref-footer">
    <div class="ref-footer-brand"><a class="ref-brand" href="<?= site_url('/') ?>"><img src="<?= base_url('assets/images/Norsworthy-Logo-1.png') ?>" alt="Norsworthy Farms"><span>Norsworthy <b>Farms</b></span></a><p>Growing quality.<br>Creating value.</p></div>
    <div><p class="foot-label">COMPANY</p><a href="<?= site_url('about') ?>">About</a><a href="<?= site_url('projects') ?>">Projects</a><a href="<?= site_url('partnerships') ?>">Partnerships</a><a href="<?= site_url('news') ?>">News</a></div>
    <div><p class="foot-label">SERVICES</p><a href="<?= site_url('services/processing-of-crude-palm-oil') ?>">Crude palm oil</a><a href="<?= site_url('services/cultivation-of-high-breed-oil-palm-seedlings') ?>">High-breed seedlings</a><a href="<?= site_url('services/technical-palm-oil') ?>">Technical palm oil</a></div>
    <div><p class="foot-label">CONTACT</p><a href="mailto:info@norsworthy.com.ng">info@norsworthy.com.ng</a><a href="<?= site_url('contact') ?>">Send an enquiry</a><a href="<?= site_url('contact') ?>">Nigeria</a></div>
    <small>© <?= date('Y') ?> Norsworthy Farms. All rights reserved. <a href="<?= site_url('admin/login') ?>">Staff login</a></small>
  </footer>
  <script>
    const menuButton = document.querySelector('.ref-menu');
    const navigation = document.querySelector('.ref-nav');
    const headerShell = document.querySelector('.ref-header-shell');
    const contactLink = document.querySelector('.ref-contact');
    const mobileNav = matchMedia('(max-width: 1039px)');
    const placeNavigation = () => { if (mobileNav.matches) document.body.append(navigation); else { headerShell.insertBefore(navigation, contactLink); navigation.classList.remove('open'); menuButton.textContent = 'Menu'; menuButton.setAttribute('aria-expanded', 'false'); } };
    placeNavigation(); mobileNav.addEventListener('change', placeNavigation);
    menuButton?.addEventListener('click', () => { const open = navigation.classList.toggle('open'); menuButton.textContent = open ? 'Close' : 'Menu'; menuButton.setAttribute('aria-expanded', String(open)); });
    const header = document.querySelector('.ref-header');
    const updateHeader = () => header?.classList.toggle('is-scrolled', scrollY > 24);
    updateHeader(); addEventListener('scroll', updateHeader, { passive: true });
  </script>
</body>
</html>
