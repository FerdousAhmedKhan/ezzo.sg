<?php
require_once __DIR__ . '/includes/functions.php';
$categorySlug = $categorySlug ?? 'doors';
$categoryTitle = $categoryTitle ?? ucfirst($categorySlug);
$categoryIntro = $categoryIntro ?? '';
$categoryImage = $categoryImage ?? asset('images/Ezzo-products-doors-windows.jpg');
$products = get_products_by_category($categorySlug);
$subcategories = get_product_subcategories($categorySlug);
$meta = [
  'title'=>$categoryTitle.' in Singapore | Premium Catalogue Models | ezzo.sg',
  'description'=>$categoryIntro ?: 'Explore premium '.$categoryTitle.' models in Singapore with custom sizing, aluminium profiles, glass options and installation support.',
  'image'=>url($categoryImage)
];
include __DIR__.'/includes/header.php';
?>
<section class="page-hero" style="background-overlay:linear-gradient(237deg, #12384a52, #2938472e)">
  <div class="container"><div class="eyebrow"><?=e($categoryTitle)?> catalogue</div><h1>Premium <?=e($categoryTitle)?> for Singapore homes and commercial spaces.</h1><p><?=e($categoryIntro)?></p><div class="hero-actions"><a class="btn btn-accent" href="/quote">Get a Free Quote</a><a class="btn btn-light" href="/products">All Products</a></div></div>
</section>
<section class="section">
  <div class="container">
    <div class="section-head"><div><div class="eyebrow">Browse models</div><h2>Product Models and Configurations.</h2></div><p>Filter by product family, compare model features and open any product detail page for carousel, specifications, related products and quote form.</p></div>
    <div class="toolbar"><input class="search" data-search placeholder="Search <?=e(strtolower($categoryTitle))?> by model, feature or frame width..."><div class="filter-buttons"><button class="filter-btn active" data-filter="all">All</button><?php foreach($subcategories as $sub): ?><button class="filter-btn" data-filter="<?=e(slugify($sub))?>"><?=e($sub)?></button><?php endforeach; ?></div></div>
    <div class="grid-3">
      <?php foreach($products as $p): $tags=strtolower(slugify($p['subcategory']).' '.($p['model_code']??'').' '.($p['features']??'').' '.($p['specifications']??'')); ?>
      <article class="product-card" data-card data-category="<?=e(slugify($p['subcategory'] ?? ''))?>" data-tags="<?=e($tags)?>">
        <img loading="lazy" src="<?=e(media_src($p['hero_image']))?>" alt="<?=e($p['name'])?> <?=e($categoryTitle)?> Singapore">
        <div class="card-body"><span class="pill"><?=e($p['subcategory'] ?: $p['category_name'])?><?=!empty($p['model_code'])?' · '.e($p['model_code']):''?></span><h3><?=e($p['name'])?></h3><p><?=e($p['short_description'])?></p><a class="btn-155" href="<?= e(product_link($p['slug'])) ?>" aria-label="View product: <?= e($p['name']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View details</span>
                        </a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section dark-band"><div class="container split"><div><div class="eyebrow">Singapore climate ready</div><h2>Specify the right frame, glass and opening method.</h2><p>For local heat, humidity and rain exposure, our team helps confirm aluminium profile, glass selection, sealing, drainage, hardware and installation requirements before production.</p><ul class="tick-list"><li>Custom dimensions after site measurement</li><li>LOW-E, coated, smart or tinted glass options</li><li>Powder-coated finishes and hardware choices</li><li>Quote support for residential and commercial projects</li></ul><a class="btn btn-accent" href="/quote">Request Model Advice</a></div><img src="<?=e(asset('images/catalog/catalog-page-003.webp'))?>" alt="EZZO product features diagram"></div></section>
<?php include __DIR__.'/includes/footer.php'; ?>
