<?php
[$tLabel, $bg, $tx, $ac, $soft] = Wedding::THEMES[$w['theme']] ?? Wedding::THEMES['garden'];
if ($w['accent']) $ac = $w['accent'];
$hf = $w['font_heading']; $bf = $w['font_body'];
$fonts = 'family=' . urlencode($hf) . '&family=' . urlencode($bf) . ':wght@400;700';
$date = $w['wedding_date'] ? date('F j, Y', strtotime($w['wedding_date'])) : '';
$parents = fn($f, $m) => trim($f . ($f && $m ? ' & ' : '') . $m);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($w['groom_name']) ?> &amp; <?= e($w['bride_name']) ?> · Our wedding</title>
<link href="https://fonts.googleapis.com/css2?<?= $fonts ?>&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/site.css') ?>">
<style>:root{--bg:<?= $bg ?>;--tx:<?= $tx ?>;--ac:<?= e($ac) ?>;--soft:<?= $soft ?>;--hf:'<?= e($hf) ?>',serif;--bf:'<?= e($bf) ?>',sans-serif}</style>
</head>
<body>
<?php if (!$w['is_published']): ?><div class="draft">Draft preview. Only you can see this page until you publish it.</div><?php endif; ?>

<header class="hero">
  <?php if ($hero && $hero['type'] === 'video'): ?>
    <video class="bg" src="<?= url($hero['path']) ?>" autoplay muted loop playsinline></video>
  <?php elseif ($hero): ?>
    <div class="bg" style="background-image:url('<?= url($hero['path']) ?>')"></div>
  <?php endif; ?>
  <div class="hero-in">
    <p>We're getting married</p>
    <h1><?= e($w['groom_name']) ?> <span>&amp;</span> <?= e($w['bride_name']) ?></h1>
    <?php if ($date): ?><p class="date"><?= e($date) ?></p><?php endif; ?>
    <?php if ($date): ?><div class="count" data-date="<?= e($w['wedding_date']) ?>T00:00:00"></div><?php endif; ?>
  </div>
</header>

<?php if ($w['story']): ?>
<section><h2>Our story</h2><p class="story"><?= nl2br(e($w['story'])) ?></p></section>
<?php endif; ?>

<?php if ($w['groom_father'] . $w['groom_mother'] . $w['bride_father'] . $w['bride_mother'] !== ''): ?>
<section class="soft"><h2>With our parents</h2>
  <div class="cols">
    <div><h3>Groom's parents</h3><p><?= e($parents($w['groom_father'], $w['groom_mother'])) ?></p></div>
    <div><h3>Bride's parents</h3><p><?= e($parents($w['bride_father'], $w['bride_mother'])) ?></p></div>
  </div>
</section>
<?php endif; ?>

<?php if ($w['ceremony_venue'] . $w['reception_venue'] !== ''): ?>
<section><h2>When and where</h2>
  <div class="cols">
    <?php foreach ([['Ceremony', 'ceremony'], ['Reception', 'reception']] as [$label, $k]): if (!$w[$k . '_venue']) continue; ?>
      <div class="box"><h3><?= $label ?></h3>
        <p><b><?= e($w[$k . '_venue']) ?></b></p>
        <?php if ($w[$k . '_time']): ?><p><?= e($w[$k . '_time']) ?></p><?php endif; ?>
        <?php if ($w[$k . '_address']): ?><p><a target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($w[$k . '_address']) ?>"><?= e($w[$k . '_address']) ?></a></p><?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($w['dress_code']): ?><p class="center">Dress code: <?= e($w['dress_code']) ?></p><?php endif; ?>
</section>
<?php endif; ?>

<?php if ($people): ?>
<section class="soft"><h2>Our entourage</h2>
  <div class="cols wrap3">
    <?php foreach ($people as $role => $names): ?>
      <div><h3><?= e($role) ?><?= count($names) > 1 && !str_ends_with($role, 'r') ? 's' : (count($names) > 1 ? 's' : '') ?></h3>
        <ul><?php foreach ($names as $n): ?><li><?= e($n) ?></li><?php endforeach; ?></ul></div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($photos): ?>
<section><h2>Gallery</h2>
  <div class="gallery">
    <?php foreach ($photos as $p): ?>
      <figure><img src="<?= url($p['path']) ?>" alt="<?= e($p['caption']) ?>" loading="lazy" data-full="<?= url($p['path']) ?>">
        <?php if ($p['caption']): ?><figcaption><?= e($p['caption']) ?></figcaption><?php endif; ?></figure>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($videos): ?>
<section class="soft"><h2>Videos</h2>
  <div class="cols wrap3">
    <?php foreach ($videos as $v): ?>
      <figure class="vid"><video src="<?= url($v['path']) ?>" controls preload="metadata" playsinline></video>
        <?php if ($v['caption']): ?><figcaption><?= e($v['caption']) ?></figcaption><?php endif; ?></figure>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section id="rsvp"><h2>Will you join us?</h2>
  <?php if ($sent): ?><p class="center thanks"><?= e($sent) ?></p><?php else: ?>
  <form class="rsvp" method="post" action="<?= url('w/' . $w['slug'] . '/rsvp') ?>">
    <?= csrf_field() ?>
    <input class="hp" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
    <label>Your name <input name="name" required></label>
    <label>Email <input type="email" name="email"></label>
    <label>Reply <select name="attending"><option value="1">Joyfully accepts</option><option value="0">Regretfully declines</option></select></label>
    <label>Number of guests <input type="number" name="guests" value="1" min="1" max="10"></label>
    <label class="full">Message for the couple <textarea name="message" rows="3"></textarea></label>
    <button>Send reply</button>
  </form><?php endif; ?>
</section>

<footer><?= e($w['groom_name']) ?> &amp; <?= e($w['bride_name']) ?><?= $date ? ' · ' . e($date) : '' ?></footer>
<dialog id="lb"><img alt=""><p></p></dialog>
<script src="<?= url('assets/site.js') ?>"></script>
</body>
</html>
