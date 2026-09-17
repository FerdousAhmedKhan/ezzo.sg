<?php
$admin_title='Blog Posts'; 
include __DIR__.'/inc/header.php'; 

$pdo=db();

if($pdo && isset($_POST['delete'])){
    $pdo->prepare("DELETE FROM blog_posts WHERE id=?")
        ->execute([(int)$_POST['delete']]);
}

if($pdo && $_SERVER['REQUEST_METHOD']==='POST' && !isset($_POST['delete'])){

    $id=(int)($_POST['id']??0);

    $title=trim($_POST['title']??'');
    $slug=slugify($_POST['slug'] ?: $title);

    $image=upload_image('image','blog') ?: ($_POST['current_image'] ?? '');

    /*
     * IMPORTANT:
     * Do NOT escape TinyMCE HTML content here.
     * TinyMCE already produces HTML.
     */
    $content=$_POST['content'] ?? '';

    $data=[
        $title,
        $slug,
        trim($_POST['category']??''),
        trim($_POST['excerpt']??''),
        $content,
        $image,
        trim($_POST['seo_title']??''),
        trim($_POST['meta_description']??''),
        $_POST['status']??'published',
        trim($_POST['published_at']??date('Y-m-d'))
    ];


    if($id){

        $pdo->prepare("
            UPDATE blog_posts 
            SET 
            title=?,
            slug=?,
            category=?,
            excerpt=?,
            content=?,
            image=?,
            seo_title=?,
            meta_description=?,
            status=?,
            published_at=?
            WHERE id=?
        ")
        ->execute([...$data,$id]);

    }else{

        $pdo->prepare("
            INSERT INTO blog_posts
            (
                title,
                slug,
                category,
                excerpt,
                content,
                image,
                seo_title,
                meta_description,
                status,
                published_at,
                created_at
            )
            VALUES(?,?,?,?,?,?,?,?,?,?,NOW())
        ")
        ->execute($data);
    }


    header('Location: blog.php');
    exit;
}


$edit=isset($_GET['id'])
    ? fetch_one(
        "SELECT * FROM blog_posts WHERE id=?",
        [(int)$_GET['id']]
      )
    : null;


$rows=fetch_all(
    "SELECT * FROM blog_posts ORDER BY published_at DESC,id DESC"
);


$p=$edit ?: [
    'id'=>'',
    'title'=>'',
    'slug'=>'',
    'category'=>'Guide',
    'excerpt'=>'',
    'content'=>'',
    'image'=>'',
    'seo_title'=>'',
    'meta_description'=>'',
    'status'=>'published',
    'published_at'=>date('Y-m-d')
];

?>


<script src="https://cdn.tiny.cloud/1/ntdrho7hv1iwvt8pryqggyjf20dj2s99zihbjd5u91nookaa/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


<script>

tinymce.init({

    selector:'#content',

    height:500,

    menubar:true,

    entity_encoding:'raw',

    forced_root_block:'p',

    plugins:[
        'advlist',
        'autolink',
        'lists',
        'link',
        'image',
        'charmap',
        'preview',
        'anchor',
        'searchreplace',
        'visualblocks',
        'code',
        'fullscreen',
        'insertdatetime',
        'media',
        'table',
        'help',
        'wordcount'
    ],


    toolbar:
    'undo redo | formatselect | '+
    'bold italic underline | '+
    'alignleft aligncenter alignright alignjustify | '+
    'bullist numlist | '+
    'link image table | '+
    'removeformat | code fullscreen | help',


    content_style:
    'body {font-family:Arial,sans-serif;font-size:16px;}'

});

</script>



<div class="admin-card">

<h2><?= $edit?'Edit':'Add' ?> Blog Post</h2>


<form method="post" enctype="multipart/form-data">


<input type="hidden" 
name="id" 
value="<?= e($p['id']) ?>">



<input type="hidden" 
name="current_image" 
value="<?= e($p['image']) ?>">



<div class="form-grid">


<input 
name="title"
required
placeholder="Post title"
value="<?= e($p['title']) ?>">



<input 
name="slug"
placeholder="slug"
value="<?= e($p['slug']) ?>">



<input 
name="category"
placeholder="Category"
value="<?= e($p['category']) ?>">



<input 
name="published_at"
type="date"
value="<?= e(substr($p['published_at']??date('Y-m-d'),0,10)) ?>">



<textarea 
class="full"
name="excerpt"
placeholder="Short excerpt / meta intro"><?= e($p['excerpt']) ?></textarea>



<!-- IMPORTANT FIX:
     No e() here.
     TinyMCE needs raw HTML.
-->

<textarea 
id="content"
class="full"
name="content"
style="min-height:260px"
placeholder="Article content"><?= $p['content'] ?></textarea>



<input 
type="file"
name="image"
accept="image/*">



<select name="status">

<option value="published">
published
</option>


<option value="draft" <?= $p['status']==='draft'?'selected':'' ?>>
draft
</option>


</select>



<input 
class="full"
name="seo_title"
placeholder="SEO title"
value="<?= e($p['seo_title'] ?? '') ?>">



<textarea 
class="full"
name="meta_description"
placeholder="Meta description"><?= e($p['meta_description'] ?? '') ?></textarea>



<button class="btn btn-accent full">
Save Blog Post
</button>


</div>


</form>


</div>



<table class="table">

<tr>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>
</tr>


<?php foreach($rows as $r): ?>


<tr>

<td>
<?= e($r['title']) ?>

<br>

<small>
<?= e($r['slug']) ?>
</small>

</td>


<td>
<?= e($r['category']) ?>
</td>


<td>
<?= e($r['status']) ?>
</td>


<td>
<?= e($r['published_at']) ?>
</td>


<td>


<a 
class="btn btn-small"
href="blog.php?id=<?= e($r['id']) ?>">
Edit
</a>


<form method="post" style="display:inline">

<button 
class="btn btn-small"
name="delete"
value="<?= e($r['id']) ?>"
onclick="return confirm('Delete post?')">

Delete

</button>

</form>


</td>


</tr>


<?php endforeach; ?>


</table>


<?php include __DIR__.'/inc/footer.php'; ?>