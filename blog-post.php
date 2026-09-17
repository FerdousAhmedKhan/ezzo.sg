<?php

require_once __DIR__.'/includes/functions.php';


$slug=$_GET['slug']??'';

$post=get_blog_post_by_slug($slug);



if(!$post){

    http_response_code(404);

    $meta=[
        'title'=>'Blog Post Not Found | ezzo.sg'
    ];

    include __DIR__.'/includes/header.php';

    echo '
    <section class="page-hero">
        <div class="container">
            <h1>Post not found</h1>
            <p>The article may have been moved.</p>
            <a class="btn btn-light" href="/blog">Back to blog</a>
        </div>
    </section>';

    include __DIR__.'/includes/footer.php';

    exit;
}



$meta=[
    'title'=>$post['title'].' | ezzo.sg Blog',
    'description'=>$post['excerpt'] ?? '',
    'image'=>url(media_src($post['image'] ?? '')),
    'type'=>'article'
];



$schema_markup=[
    '@context'=>'https://schema.org',
    '@type'=>'BlogPosting',
    'headline'=>$post['title'],
    'description'=>$post['excerpt'] ?? '',
    'image'=>url(media_src($post['image'] ?? '')),
    'datePublished'=>$post['date'] ?? date('Y-m-d'),

    'author'=>[
        '@type'=>'Organization',
        'name'=>SITE_NAME
    ],

    'publisher'=>[
        '@type'=>'Organization',
        'name'=>SITE_NAME
    ]
];



include __DIR__.'/includes/header.php';

?>

<section 
class="page-hero"
style="background-image: linear-gradient(110deg, rgb(6 36 53 / 88%), rgb(7 9 9 / 10%)), url(/uploads/blog/img_6a46ae3f58d263.50599064.webp);
    height: 700px;
    background-position: top;">

<div class="container">


<div class="eyebrow">
<?=e($post['category'] ?? 'Guide')?>
</div>



<h1>
<?=e($post['title'])?>
</h1>



<p>
<?=e($post['excerpt'] ?? '')?>
</p>


</div>


</section>





<section class="section blog-detail">


<div class="container" style="max-width:860px">


<article >


<p class="small-muted">
Updated:
<?=e($post['date'] ?? date('Y-m-d'))?>
</p>



<div class="article-content">

<?= $post['content'] ?? '' ?>

</div>




<h2>
Need help choosing a model?
</h2>



<p>
Our team can recommend suitable systems from the doors, windows and skylights catalogue based on your opening size, location and preferred finish.
</p>




<div class="actions">


<a 
class="btn btn-accent"
href="/quote">

Get a Free Quote

</a>



<a 
class="btn btn-ghost"
href="/products">

View Products

</a>


</div>



</article>


</div>


</section>



<?php include __DIR__.'/includes/footer.php'; ?>