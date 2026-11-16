<?= $this->extend('site/layout') ?>
<?= $this->section('content') ?>
<section class="inner-hero" style="background-image:linear-gradient(90deg,rgba(15,42,29,.8),rgba(15,42,29,.25)),url('<?= base_url($page['hero_image'] ?: 'assets/images/banner1.jpg') ?>')"><p class="eyebrow">Norsworthy Farms</p><h1><?= esc($page['title']) ?></h1><p><?= esc($page['excerpt']) ?></p></section><article class="prose"><?= $page['body'] ?></article>
<?= $this->endSection() ?>
