<?php
$meta=['title'=>'Projects | Door, Window & Skylight Installations Singapore','description'=>'View completed ezzo.sg residential and commercial projects with doors, windows, skylights, scope, materials, challenges and solutions.'];
include __DIR__.'/includes/header.php';
$projects=get_projects();
?>
<section class="page-hero"><div class="container"><div class="eyebrow">Project portfolio</div><h1>Installation projects for refined Singapore spaces.</h1><p>Browse residential and commercial examples with product scope, materials used, challenges, solutions and image galleries.</p><div class="hero-actions"><a class="btn btn-accent" href="/quote">Plan Your Project</a></div></div></section>
<section class="section"><div class="container"><div class="toolbar"><input class="search" data-search placeholder="Search by location, product, project type or material..."><div class="filter-buttons"><button class="filter-btn active" data-filter="all">All</button><button class="filter-btn" data-filter="residential">Residential</button><button class="filter-btn" data-filter="commercial">Commercial</button><button class="filter-btn" data-filter="doors">Doors</button><button class="filter-btn" data-filter="windows">Windows</button><button class="filter-btn" data-filter="skylights">Skylights</button></div></div><div class="masonry-grid"><?php foreach($projects as $p): ?><article class="project-card" data-card data-category="<?=e(strtolower($p['project_type']??''))?>" data-tags="<?=e($p['filters']??'')?>"><img loading="lazy" src="<?=e(media_src($p['main_image']))?>" alt="<?=e($p['title'])?>"><div class="card-body"><span class="pill"><?=e($p['project_type'])?> · <?=e($p['year']??'')?></span><h3><?=e($p['title'])?></h3><p><?=e($p['description'])?></p><p><strong>Location:</strong> <?=e($p['location'])?><br><strong>Scope:</strong> <?=e($p['product_type'])?></p>
<a class="btn-155" href="<?=e(project_link($p['slug']))?>" aria-label="View project: <?= e($pr['title']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View project details</span>
                        </a>

</div></article><?php endforeach; ?></div></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
