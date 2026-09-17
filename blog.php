<?php

$meta=[
    'title'=>'Blog | Doors, Windows & Skylights Guides Singapore',
    'description'=>'Read ezzo.sg guides about choosing doors, windows, skylights, glass, aluminium profiles and installation options for Singapore projects.'
];

include __DIR__.'/includes/header.php';

$posts=get_blog_posts();

?>


<section class="page-hero">

<div class="container">

<div class="eyebrow">
Knowledge hub
</div>


<h1>
Guides for Better Architectural Decisions
</h1>


<p>
SEO-ready educational content for doors, windows, skylights, glass options, Singapore weather performance and product selection.
</p>


</div>

</section>



<section class="section">

<div class="container">


<div class="grid-3">


<?php foreach($posts as $post): ?>


<article class="blog-card">


<img 
loading="lazy"
src="<?= e(media_src($post['image'] ?? '')) ?>"
alt="<?= e($post['title'] ?? 'Blog image') ?>">



<div class="card-body">


<span class="pill">
<?= e($post['category'] ?? 'Guide') ?>
</span>



<h2>
<a href="<?= e(blog_link($post['slug'])) ?>">
<?= e($post['title']) ?>
</a>
</h2>



<p>
<?= e($post['excerpt'] ?? '') ?>
</p>

<a class="btn-155" href="<?= e(blog_link($post['slug'])) ?>" aria-label="Read article <?= e($pr['title']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">Read guide</span>
                        </a>


</div>


</article>


<?php endforeach; ?>


</div>


</div>


</section>



<?php include __DIR__.'/includes/footer.php'; ?>