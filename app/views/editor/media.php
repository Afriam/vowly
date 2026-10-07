<?php require __DIR__ . '/_nav.php'; ?>
<form class="card" method="post" enctype="multipart/form-data" action="<?= url('editor/media/upload') ?>">
  <?= csrf_field() ?>
  <h2>Upload a photo or video</h2>
  <div class="grid2">
    <label>File <input type="file" name="file" accept="image/*,video/mp4,video/webm" required><small>Photos up to 8 MB. Videos (MP4 or WebM) up to 60 MB.</small></label>
    <label>Description <input name="caption" maxlength="255" placeholder="Our first trip together, Baguio 2023"></label>
  </div>
  <button class="btn">Upload</button>
</form>
<div class="card">
  <h2>Your files</h2>
  <?php if (!$items): ?><p class="muted">Nothing uploaded yet.</p><?php endif; ?>
  <div class="media-grid">
  <?php foreach ($items as $m): $isHero = (int)$w['hero_media_id'] === (int)$m['id']; ?>
    <div class="media">
      <?php if ($m['type'] === 'image'): ?><img src="<?= url($m['path']) ?>" alt="" loading="lazy">
      <?php else: ?><video src="<?= url($m['path']) ?>" controls preload="metadata"></video><?php endif; ?>
      <form method="post" action="<?= url('editor/media/caption/' . $m['id']) ?>" class="inline">
        <?= csrf_field() ?><input name="caption" value="<?= e($m['caption']) ?>" placeholder="Add a description" maxlength="255"><button class="btn small">Save</button>
      </form>
      <div class="row">
        <?php if ($isHero): ?>
          <form method="post" action="<?= url('editor/media/clear-hero') ?>"><?= csrf_field() ?><button class="link">Hero background ✓ (remove)</button></form>
        <?php else: ?>
          <form method="post" action="<?= url('editor/media/hero/' . $m['id']) ?>"><?= csrf_field() ?><button class="link">Use as hero background</button></form>
        <?php endif; ?>
        <form method="post" action="<?= url('editor/media/delete/' . $m['id']) ?>" onsubmit="return confirm('Delete this file?')"><?= csrf_field() ?><button class="link danger">Delete</button></form>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
