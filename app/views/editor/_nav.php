<?php $tabs = ['details' => 'Details', 'entourage' => 'Entourage', 'media' => 'Photos & videos', 'design' => 'Design', 'publish' => 'Publish', 'rsvps' => 'RSVPs']; ?>
<nav class="tabs">
  <?php foreach ($tabs as $k => $label): ?>
    <a href="<?= url("editor/$k") ?>" class="<?= $tab === $k ? 'on' : '' ?>"><?= $label ?></a>
  <?php endforeach; ?>
  <a class="preview" target="_blank" href="<?= url('w/' . $w['slug']) ?>">Preview site</a>
</nav>
