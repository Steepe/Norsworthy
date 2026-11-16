<?= $this->extend('site/layout') ?>
<?= $this->section('content') ?>
<section class="listing-head"><p class="eyebrow">Norsworthy Farms</p><h1><?= esc($title) ?></h1><p><?= esc($intro) ?></p></section><section class="listing-grid"><?php foreach ($items as $item): ?><article class="listing-card"><img src="<?= base_url($item['cover_image'] ?: 'assets/images/palm_oil.jpg') ?>" alt=""><div><p class="eyebrow"><?= esc($item['type']) ?></p><h2><?= esc($item['title']) ?></h2><p><?= esc($item['excerpt']) ?></p><a class="text-link" href="<?= site_url($item['type'] === 'project' ? 'projects/' . $item['slug'] : 'news/' . $item['slug']) ?>">Read more →</a></div></article><?php endforeach ?></section>
<?= $this->endSection() ?>
