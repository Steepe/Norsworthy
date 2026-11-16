<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Norsworthy Farms — responsible oil palm cultivation, processing and quality products.">
    <title><?= esc($title ?? 'Norsworthy Farms') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/site.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/contact.css') ?>">
</head>
<body>
<header class="site-header">
    <a class="brand" href="<?= site_url('/') ?>"><img src="<?= base_url('assets/images/Norsworthy-Logo-1.png') ?>" alt="Norsworthy Farms"><span>Norsworthy<br><b>Farms</b></span></a>
    <button class="nav-toggle" aria-label="Toggle navigation">Menu</button>
    <nav class="site-nav"><a href="<?= site_url('about') ?>">About</a><a href="<?= site_url('services') ?>">Services</a><a href="<?= site_url('projects') ?>">Projects</a><a href="<?= site_url('news') ?>">News</a><a class="nav-contact" href="<?= site_url('contact') ?>">Contact us</a></nav>
</header>
<main><?= $this->renderSection('content') ?></main>
<footer class="site-footer"><div><strong>Norsworthy Farms</strong><p>Growing quality. Creating value.</p></div><div><a href="<?= site_url('about') ?>">Our story</a><a href="<?= site_url('projects') ?>">Our work</a><a href="<?= site_url('contact') ?>">Contact</a></div><small>© <?= date('Y') ?> Norsworthy Farms. All rights reserved.</small></footer>
<script>document.querySelector('.nav-toggle').onclick=()=>document.querySelector('.site-nav').classList.toggle('open')</script>
</body>
</html>
