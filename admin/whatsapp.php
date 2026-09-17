<?php $admin_title='WhatsApp Click Tracking'; include __DIR__.'/inc/header.php'; $rows=fetch_all("SELECT * FROM whatsapp_clicks ORDER BY id DESC LIMIT 300"); ?>
<table class="table"><tr><th>Date</th><th>Message</th><th>Source</th><th>IP</th></tr><?php foreach($rows as $r): ?><tr><td><?= e($r['created_at']) ?></td><td><?= e($r['message']) ?></td><td><?= e($r['source_page']) ?></td><td><?= e($r['ip_address']) ?></td></tr><?php endforeach; ?></table>
<?php include __DIR__.'/inc/footer.php'; ?>
