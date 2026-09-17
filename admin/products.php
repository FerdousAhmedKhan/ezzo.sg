<?php
$admin_title='Products'; include __DIR__.'/inc/header.php'; $pdo=db();
if($pdo && isset($_POST['delete'])){$pdo->prepare("DELETE FROM products WHERE id=?")->execute([(int)$_POST['delete']]);}
$rows=fetch_all("SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.sort_order ASC,p.id DESC");
?>
<div class="admin-card"><a class="btn btn-accent" href="product-edit.php">Add Product</a><a class="btn btn-ghost" href="/products" target="_blank">View Catalogue</a></div>
<table class="table"><tr><th>Image</th><th>Name</th><th>Category</th><th>Model</th><th>Status</th><th>Actions</th></tr><?php foreach($rows as $r): ?><tr><td><img src="../<?= e($r['hero_image']) ?>" style="width:90px;height:70px;object-fit:cover;border-radius:10px" onerror="this.src='<?= e($r['hero_image']) ?>'"></td><td><?= e($r['name']) ?><br><small><?= e($r['slug']) ?></small></td><td><?= e($r['category_name']) ?><br><small><?= e($r['subcategory'] ?? '') ?></small></td><td><?= e($r['model_code'] ?? '') ?></td><td><?= e($r['status']) ?></td><td><a class="btn btn-small" href="product-edit.php?id=<?= e($r['id']) ?>">Edit</a><form method="post" style="display:inline"><button class="btn btn-small" name="delete" value="<?= e($r['id']) ?>" onclick="return confirm('Delete product?')">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php include __DIR__.'/inc/footer.php'; ?>
