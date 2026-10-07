<?php $app = $GLOBALS['config']['app_name']; ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($app) ?> · Wedding website builder</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Fraunces:opsz,wght@9..144,500;9..144,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= url('assets/app.css') ?>">
</head>
<body>
<header class="top">
  <a class="brand" href="<?= url() ?>"><?= e($app) ?></a>
  <nav>
    <?php if (Auth::check()): ?>
      <a href="<?= url('dashboard') ?>">Dashboard</a>
      <form method="post" action="<?= url('logout') ?>"><?= csrf_field() ?><button class="link">Log out</button></form>
    <?php else: ?>
      <a href="<?= url('login') ?>">Log in</a>
      <a class="btn small" href="<?= url('register') ?>">Create your site</a>
    <?php endif; ?>
  </nav>
</header>
<main class="wrap">
  <?php if ($m = flash('ok')): ?><div class="msg ok"><?= e($m) ?></div><?php endif; ?>
  <?php if ($m = flash('error')): ?><div class="msg err"><?= e($m) ?></div><?php endif; ?>
  <?= $content ?>
</main>
</body>
</html>
