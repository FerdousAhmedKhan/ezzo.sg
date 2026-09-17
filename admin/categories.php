<?php
$admin_title='Categories'; include __DIR__.'/inc/header.php'; $pdo=db();
if($pdo && $_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['delete'])){$pdo->prepare("DELETE FROM categories WHERE id=?")->execute([(int)$_POST['delete']]);}
  else{$id=(int)($_POST['id']??0);$name=trim($_POST['name']??'');$slug=strtolower(trim($_POST['slug']??preg_replace('/[^a-z0-9]+/i','-',$name),'-'));$sort=(int)($_POST['sort_order']??0); if($id){$pdo->prepare("UPDATE categories SET name=?,slug=?,sort_order=? WHERE id=?")->execute([$name,$slug,$sort,$id]);}else{$pdo->prepare("INSERT INTO categories(name,slug,sort_order) VALUES(?,?,?)")->execute([$name,$slug,$sort]);}}
}
$rows=fetch_all("SELECT * FROM categories ORDER BY sort_order,name");
?>
<div class="admin-card"><h2>Add / edit category</h2><form method="post"><div class="form-grid"><input name="id" placeholder="ID for edit only"><input name="name" required placeholder="Category name"><input name="slug" placeholder="slug"><input name="sort_order" type="number" placeholder="Sort order"><button class="btn btn-dark full">Save Category</button></div></form></div>
<table class="table"><tr><th>ID</th><th>Name</th><th>Slug</th><th>Sort</th><th>Action</th></tr><?php foreach($rows as $r): ?><tr><td><?= e($r['id']) ?></td><td><?= e($r['name']) ?></td><td><?= e($r['slug']) ?></td><td><?= e($r['sort_order']) ?></td><td><form method="post"><button class="btn btn-small" name="delete" value="<?= e($r['id']) ?>" onclick="return confirm('Delete category?')">Delete</button></form></td></tr><?php endforeach; ?></table>
<?php include __DIR__.'/inc/footer.php'; ?>
