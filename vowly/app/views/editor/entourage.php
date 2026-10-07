<?php require __DIR__ . '/_nav.php'; ?>
<form class="card" method="post" action="<?= url('editor/entourage') ?>">
  <?= csrf_field() ?>
  <h2>Add people</h2>
  <div class="grid2">
    <label>Role <select name="role"><?php foreach (Wedding::ROLES as $r): ?><option><?= e($r) ?></option><?php endforeach; ?></select></label>
    <label>Names <textarea name="names" rows="4" placeholder="One name per line" required></textarea></label>
  </div>
  <button class="btn">Add to entourage</button>
</form>
<div class="card">
  <h2>Your entourage</h2>
  <?php if (!$people): ?><p class="muted">No one added yet. Start with your principal sponsors.</p><?php endif; ?>
  <?php $by = []; foreach ($people as $p) $by[$p['role']][] = $p; ?>
  <?php foreach (Wedding::ROLES as $r): if (empty($by[$r])) continue; ?>
    <h3><?= e($r) ?></h3>
    <ul class="list">
      <?php foreach ($by[$r] as $p): ?>
        <li><?= e($p['name']) ?>
          <form method="post" action="<?= url('editor/entourage/delete/' . $p['id']) ?>"><?= csrf_field() ?><button class="link danger">Remove</button></form>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endforeach; ?>
</div>
