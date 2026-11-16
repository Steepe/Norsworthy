<?php
$section = service('uri')->getSegment(2) ?: 'dashboard';
$name = (string) session()->get('cms_user_name');
$initials = implode('', array_map(static fn ($part) => strtoupper(substr($part, 0, 1)), array_filter(explode(' ', $name)))) ?: 'NF';
$newInquiryCount = $newInquiryCount ?? (new \App\Models\InquiryModel())->where('status', 'new')->countAllResults();
?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Norsworthy Website Editor') ?></title>
<link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>"><link rel="stylesheet" href="<?= base_url('assets/admin-extras.css') ?>"><link rel="stylesheet" href="<?= base_url('assets/admin-reference.css') ?>">
</head><body>
<div class="cms-shell">
<aside class="cms-sidebar">
    <a class="cms-brand" href="<?= site_url('admin') ?>"><span class="cms-mark" aria-hidden="true"></span><span>NORSWORTHY<small>WEBSITE EDITOR</small></span></a>
    <nav class="cms-nav" aria-label="CMS navigation">
        <a class="<?= $section === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('admin') ?>">Dashboard</a>
        <p class="cms-nav-label">Content</p>
        <a class="<?= in_array($section, ['pages', 'content'], true) ? 'active' : '' ?>" href="<?= site_url('admin/pages') ?>">Pages &amp; posts</a>
        <a class="<?= $section === 'media' ? 'active' : '' ?>" href="<?= site_url('admin/media') ?>">Photos &amp; files</a>
        <p class="cms-nav-label">Inbox</p>
        <a class="<?= $section === 'inquiries' ? 'active' : '' ?>" href="<?= site_url('admin/inquiries') ?>">Enquiries<?php if (($newInquiryCount ?? 0) > 0): ?><span class="nav-count"><?= $newInquiryCount ?></span><?php endif ?></a>
        <p class="cms-nav-label">Site</p>
        <a class="<?= $section === 'profile' ? 'active' : '' ?>" href="<?= site_url('admin/profile') ?>">Team &amp; permissions</a>
    </nav>
    <div class="cms-sidebar-bottom"><a class="cms-view-site" href="<?= site_url('/') ?>" target="_blank" rel="noopener">View website ↗</a><a class="cms-user" href="<?= site_url('admin/profile') ?>"><span class="cms-avatar"><?= esc(substr($initials, 0, 2)) ?></span><span><strong><?= esc($name) ?></strong><small>ADMIN</small></span></a><form method="post" action="<?= site_url('admin/logout') ?>"><?= csrf_field() ?><button class="cms-signout">Sign out</button></form></div>
</aside>
<main class="cms-main"><?php if (session('success')): ?><div class="notice success cms-flash"><?= esc(session('success')) ?></div><?php endif ?><?php if (session('error')): ?><div class="notice error cms-flash"><?= esc(session('error')) ?></div><?php endif ?><?= $this->renderSection('content') ?></main>
</div>
</body></html>
