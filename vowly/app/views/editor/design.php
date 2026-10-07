<?php require __DIR__ . '/_nav.php'; $t = Wedding::THEMES; ?>
<form class="card" method="post" action="<?= url('editor/design') ?>">
  <?= csrf_field() ?>
  <h2>Theme</h2>
  <div class="themes">
    <?php foreach ($t as $key => [$label, $bg, $tx, $ac, $soft]): ?>
      <label class="theme">
        <input type="radio" name="theme" value="<?= $key ?>" <?= $w['theme'] === $key ? 'checked' : '' ?>>
        <span class="swatch" style="background:<?= $bg ?>;color:<?= $tx ?>"><i style="background:<?= $ac ?>"></i><i style="background:<?= $soft ?>"></i><em>Aa</em></span>
        <?= e($label) ?>
      </label>
    <?php endforeach; ?>
  </div>
  <h2>Fonts</h2>
  <div class="grid2">
    <label>Headings <select name="font_heading"><?php foreach (Wedding::HEADING_FONTS as $f): ?><option <?= $w['font_heading'] === $f ? 'selected' : '' ?>><?= e($f) ?></option><?php endforeach; ?></select></label>
    <label>Body text <select name="font_body"><?php foreach (Wedding::BODY_FONTS as $f): ?><option <?= $w['font_body'] === $f ? 'selected' : '' ?>><?= e($f) ?></option><?php endforeach; ?></select></label>
  </div>
  <h2>Accent colour</h2>
  <label class="check"><input type="checkbox" name="use_accent" value="1" <?= $w['accent'] ? 'checked' : '' ?>> Use my own accent colour instead of the theme's
    <input type="color" name="accent" value="<?= e($w['accent'] ?: $t[$w['theme']][3]) ?>"></label>
  <button class="btn">Save design</button>
</form>
