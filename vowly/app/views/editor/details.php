<?php require __DIR__ . '/_nav.php'; ?>
<form class="card" method="post" action="<?= url('editor/details') ?>">
  <?= csrf_field() ?>
  <h2>The couple</h2>
  <div class="grid2">
    <label>Groom's name <input name="groom_name" value="<?= e($w['groom_name']) ?>" required></label>
    <label>Bride's name <input name="bride_name" value="<?= e($w['bride_name']) ?>" required></label>
    <label>Groom's father <input name="groom_father" value="<?= e($w['groom_father']) ?>"></label>
    <label>Groom's mother <input name="groom_mother" value="<?= e($w['groom_mother']) ?>"></label>
    <label>Bride's father <input name="bride_father" value="<?= e($w['bride_father']) ?>"></label>
    <label>Bride's mother <input name="bride_mother" value="<?= e($w['bride_mother']) ?>"></label>
  </div>
  <h2>When and where</h2>
  <div class="grid2">
    <label>Wedding date <input type="date" name="wedding_date" value="<?= e($w['wedding_date']) ?>"></label>
    <label>Dress code <input name="dress_code" value="<?= e($w['dress_code']) ?>" placeholder="Formal, earth tones"></label>
    <label>Ceremony venue <input name="ceremony_venue" value="<?= e($w['ceremony_venue']) ?>"></label>
    <label>Ceremony time <input name="ceremony_time" value="<?= e($w['ceremony_time']) ?>" placeholder="3:00 PM"></label>
    <label class="full">Ceremony address <input name="ceremony_address" value="<?= e($w['ceremony_address']) ?>"></label>
    <label>Reception venue <input name="reception_venue" value="<?= e($w['reception_venue']) ?>"></label>
    <label>Reception time <input name="reception_time" value="<?= e($w['reception_time']) ?>" placeholder="6:00 PM"></label>
    <label class="full">Reception address <input name="reception_address" value="<?= e($w['reception_address']) ?>"></label>
  </div>
  <h2>Your story</h2>
  <label>How you met, how he proposed, a message to guests <textarea name="story" rows="7"><?= e($w['story']) ?></textarea></label>
  <button class="btn">Save details</button>
</form>
