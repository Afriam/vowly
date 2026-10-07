<form class="card narrow" method="post" action="<?= url('register') ?>">
  <h1>Create your account</h1>
  <?php foreach ($errors as $er): ?><div class="msg err"><?= e($er) ?></div><?php endforeach; ?>
  <?= csrf_field() ?>
  <label>Your name <input name="name" value="<?= e($old['name']) ?>" required autofocus></label>
  <label>Email <input type="email" name="email" value="<?= e($old['email']) ?>" required></label>
  <label>Password <input type="password" name="password" minlength="8" required><small>At least 8 characters.</small></label>
  <label>Repeat password <input type="password" name="password2" required></label>
  <button class="btn">Create account</button>
  <p class="muted">Already registered? <a href="<?= url('login') ?>">Log in</a></p>
</form>
