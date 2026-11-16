<?= $this->extend('site/layout') ?>
<?= $this->section('content') ?>
<section class="inner-hero" style="background-image:linear-gradient(90deg,rgba(15,42,29,.8),rgba(15,42,29,.25)),url('<?= base_url($item['cover_image'] ?: 'assets/images/palm_oil.jpg') ?>')"><p class="eyebrow"><?= esc($item['type']) ?></p><h1><?= esc($item['title']) ?></h1><p><?= esc($item['excerpt']) ?></p></section><article class="prose"><?= $item['body'] ?></article>
<?= $this->endSection() ?>
