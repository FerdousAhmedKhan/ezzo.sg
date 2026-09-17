<?php
$meta=['title'=>'All Products | Premium Doors, Windows & Skylights Singapore','description'=>'Explore all ezzo.sg door, window and skylight catalogue models with images, model codes, specifications and quote CTAs.'];
include __DIR__.'/includes/header.php';
$products=get_products(); $categories=get_categories();
?>
<section class="page-hero"><div class="container"><div class="eyebrow">Complete product catalogue</div><h1>Doors, windows and skylights for modern architecture.</h1><p>Search all sample catalogue models from EZZO.SG and open product pages for carousel images, technical data, related products and quote forms.</p><div class="hero-actions"><a class="btn btn-accent" href="/quote">Get a Free Quote</a><a class="btn btn-light" href="/assets/downloads/EZZOSG 080426 Doors Windows and Skylights catalogue final draft.pdf" download>Download Catalogue</a></div></div></section>
<section class="section"><div class="container"><div class="toolbar"><input class="search" data-search placeholder="Search products, categories, materials or model codes..."><div class="filter-buttons"><button class="filter-btn active" data-filter="all">All</button><?php foreach($categories as $cat): ?><button class="filter-btn" data-filter="<?=e($cat['slug'])?>"><?=e($cat['name'])?></button><?php endforeach; ?></div></div><div class="grid-3"><?php foreach($products as $p): ?><article class="product-card" data-card data-category="<?=e($p['category_slug'])?>" data-tags="<?=e(strtolower(($p['subcategory']??'').' '.($p['model_code']??'').' '.($p['features']??'')))?>"><img loading="lazy" src="<?=e(media_src($p['hero_image']))?>" alt="<?=e($p['name'])?>"><div class="card-body"><span class="pill"><?=e($p['category_name'])?>
<?=!empty($p['model_code'])?' · '.e($p['model_code']):''?></span>
<h3><?=e($p['name'])?></h3><p><?=e($p['short_description'])?></p>
<a class="btn-155" href="<?= e(product_link($p['slug'])) ?>" aria-label="View product: <?= e($p['name']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View details</span>
                        </a></div></article><?php endforeach; ?></div></div></section>

<?php include __DIR__.'/includes/footer.php'; ?>
