<?php require __DIR__ . '/_nav.php';
$yes = array_sum(array_map(fn($r) => $r['attending'] ? $r['guests'] : 0, $rows)); ?>
<div class="card">
  <h2>RSVPs <span class="muted">· <?= $yes ?> guests attending</span></h2>
  <?php if (!$rows): ?><p class="muted">No replies yet. They appear here once guests use the form on your site.</p><?php else: ?>
  <div class="scroll"><table>
    <tr><th>Name</th><th>Reply</th><th>Guests</th><th>Message</th><th>Sent</th></tr>
    <?php foreach ($rows as $r): ?>
      <tr><td><?= e($r['name']) ?><br><small><?= e($r['email']) ?></small></td><td><?= $r['attending'] ? 'Attending' : 'Declined' ?></td><td><?= (int)$r['guests'] ?></td><td><?= e($r['message']) ?></td><td><?= e(substr($r['created_at'], 0, 10)) ?></td></tr>
    <?php endforeach; ?>
  </table></div><?php endif; ?>
</div>
