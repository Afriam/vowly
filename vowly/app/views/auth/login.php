<form class="card narrow" method="post" action="<?= url('login') ?>">
  <h1>Log in</h1>
  <?= csrf_field() ?>
  <label>Email <input type="email" name="email" value="<?= e($email) ?>" required autofocus></label>
  <label>Password <input type="password" name="password" required></label>
  <button class="btn">Log in</button>
  <p class="muted">New here? <a href="<?= url('register') ?>">Create an account</a></p>
</form>
