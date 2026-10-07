<?php require __DIR__ . '/_nav.php';
$link = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . url('w/' . $w['slug']);
$checks = [
  'Wedding date set' => (bool)$w['wedding_date'],
  'Ceremony venue added' => $w['ceremony_venue'] !== '',
  'Hero background chosen' => (bool)$w['hero_media_id'],
]; ?>
<div class="card">
  <h2><?= $w['is_published'] ? 'Your site is live' : 'Ready to publish?' ?></h2>
  <p>Web address: <a target="_blank" href="<?= e($link) ?>"><?= e($link) ?></a></p>
  <ul class="checks"><?php foreach ($checks as $l => $ok): ?><li class="<?= $ok ? 'yes' : 'no' ?>"><?= $ok ? '✓' : '○' ?> <?= e($l) ?></li><?php endforeach; ?></ul>
  <form method="post" action="<?= url('editor/publish') ?>"><?= csrf_field() ?>
    <button class="btn <?= $w['is_published'] ? 'ghost' : '' ?>"><?= $w['is_published'] ? 'Unpublish' : 'Publish site' ?></button>
  </form>
</div>
