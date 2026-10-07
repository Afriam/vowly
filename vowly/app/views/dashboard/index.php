<?php if (!$w): ?>
<form class="card narrow" method="post" action="<?= url('dashboard/create') ?>">
  <h1>Name your wedding site</h1>
  <?= csrf_field() ?>
  <label>Groom's name <input name="groom_name" required></label>
  <label>Bride's name <input name="bride_name" required></label>
  <label>Web address
    <span class="slug"><?= e($_SERVER['HTTP_HOST'] . url('w/')) ?><input name="slug" pattern="[a-z0-9]+(-[a-z0-9]+)*" minlength="3" maxlength="40" placeholder="juan-and-maria" required></span>
    <small>Lowercase letters, numbers and hyphens.</small>
  </label>
  <button class="btn">Create site</button>
</form>
<?php else: ?>
<h1><?= e($w['groom_name']) ?> &amp; <?= e($w['bride_name']) ?></h1>
<p class="muted">Hi <?= e($user['name']) ?>. Your site is <b><?= $w['is_published'] ? 'published' : 'a draft, visible only to you' ?></b>.</p>
<div class="stats">
  <div><b><?= $stats['photos'] ?></b> photos</div><div><b><?= $stats['videos'] ?></b> videos</div>
  <div><b><?= $stats['people'] ?></b> entourage</div><div><b><?= $stats['rsvps'] ?></b> RSVPs</div>
</div>
<div class="row">
  <a class="btn" href="<?= url('editor/details') ?>">Edit your site</a>
  <a class="btn ghost" target="_blank" href="<?= url('w/' . $w['slug']) ?>">Preview</a>
</div>
<?php endif; ?>
