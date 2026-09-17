<?php
require_once __DIR__.'/includes/functions.php';
$slug=$_GET['slug']??'';
$product=get_product_by_slug($slug);
if(!$product){http_response_code(404);$meta=['title'=>'Product Not Found | ezzo.sg'];include __DIR__.'/includes/header.php';echo '<section class="page-hero"><div class="container"><h1>Product not found</h1><p>The product may have been moved or unpublished.</p><a class="btn btn-light" href="/products">Back to products</a></div></section>';include __DIR__.'/includes/footer.php';exit;}
$gallery=array_values(array_unique(array_filter(array_merge([$product['hero_image']], split_lines($product['gallery_images'] ?? '')))));
$gallery=array_map('media_src',$gallery);
$meta=[
  'title'=>!empty($product['seo_title']) ? $product['seo_title'] : ($product['name'].' | Premium '.$product['category_name'].' Singapore'),
  'description'=>$product['meta_description'] ?? $product['short_description'],
  'image'=>url($product['hero_image']),
  'type'=>'product'
];
$schema_markup=[
  '@context'=>'https://schema.org','@type'=>'Product','name'=>$product['name'],'description'=>$product['short_description'],'image'=>array_map(fn($g)=>url($g),$gallery),'brand'=>['@type'=>'Brand','name'=>'EZZODOORS / ezzo.sg'],'category'=>$product['category_name'],'url'=>url('product/'.$product['slug']),'additionalProperty'=>[
    ['@type'=>'PropertyValue','name'=>'Model','value'=>$product['model_code'] ?? ''],
    ['@type'=>'PropertyValue','name'=>'Product family','value'=>$product['subcategory'] ?? ''],
    ['@type'=>'PropertyValue','name'=>'Materials','value'=>$product['materials'] ?? '6063-T5 aluminium profile']
  ]
];
include __DIR__.'/includes/header.php';
$related=get_related_products($product,3);
$specRows=array_merge(
  !empty($product['model_code'])?[['Model code',$product['model_code']]]:[],
  !empty($product['subcategory'])?[['Product family',$product['subcategory']]]:[],
  array_map(fn($line)=>str_contains($line,':')?array_map('trim',explode(':',$line,2)):['Specification',$line], split_lines($product['specifications'] ?? ''))
);
?>
<section class="page-hero" style="background-image:linear-gradient(237deg, #12384a52, #2938472e),url('<?=e($product['hero_image'])?>')"><div class="container"><div class="eyebrow"><?=e($product['category_name'])?> / <?=e($product['subcategory'] ?? 'Catalogue model')?></div><h1><?=e($product['name'])?></h1><p><?=e($product['short_description'])?></p><div class="hero-actions"><a class="btn btn-accent" href="/quote">Get a Free Quote</a><a class="btn btn-light" href="<?=e(whatsapp_link('Hello ezzo.sg, I am interested in '.$product['name']))?>">WhatsApp about this model</a></div></div></section>
<section class="section product-detail"><div class="container detail-layout">
    
    <div
    class="detail-media product-carousel"
    data-product-carousel
    tabindex="0"
    aria-label="<?= e($product['name']) ?> image gallery"
>
    <div class="carousel-main" data-carousel-stage>

        <?php if (count($gallery) > 1): ?>
            <button
                type="button"
                class="carousel-arrow carousel-arrow-prev"
                data-carousel-prev
                aria-label="Show previous image"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M15 18l-6-6 6-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        <?php endif; ?>

        <button
            type="button"
            class="carousel-image-button"
            data-carousel-lightbox
            data-lightbox="<?= e($gallery[0]) ?>"
            aria-label="Open enlarged image of <?= e($product['name']) ?>"
        >
            <img
                data-carousel-main
                src="<?= e($gallery[0]) ?>"
                alt="<?= e($product['name']) ?> image 1"
                loading="eager"
                decoding="async"
                fetchpriority="high"
            >
        </button>

        <?php if (count($gallery) > 1): ?>
            <button
                type="button"
                class="carousel-arrow carousel-arrow-next"
                data-carousel-next
                aria-label="Show next image"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 6l6 6-6 6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        <?php endif; ?>

        <div
            class="carousel-counter"
            aria-live="polite"
            aria-atomic="true"
        >
            <span data-carousel-current>1</span>
            <span aria-hidden="true"> / </span>
            <span><?= count($gallery) ?></span>
        </div>
    </div>

    <?php if (count($gallery) > 1): ?>
        <div class="carousel-thumbnails-wrap">

            <button
                type="button"
                class="thumbnail-scroll thumbnail-scroll-prev"
                data-thumbs-prev
                aria-label="Scroll thumbnails left"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M15 18l-6-6 6-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>

            <div
                class="thumbs"
                data-carousel-thumbs
                role="list"
                aria-label="Product image thumbnails"
            >
                <?php foreach ($gallery as $i => $image): ?>
                    <button
                        type="button"
                        class="thumb <?= $i === 0 ? 'active' : '' ?>"
                        data-thumb
                        data-index="<?= $i ?>"
                        data-src="<?= e($image) ?>"
                        data-alt="<?= e($product['name']) ?> image <?= $i + 1 ?>"
                        role="listitem"
                        aria-label="Show image <?= $i + 1 ?>"
                        aria-current="<?= $i === 0 ? 'true' : 'false' ?>"
                    >
                        <img
                            src="<?= e($image) ?>"
                            alt=""
                            loading="lazy"
                            decoding="async"
                        >
                    </button>
                <?php endforeach; ?>
            </div>

            <button
                type="button"
                class="thumbnail-scroll thumbnail-scroll-next"
                data-thumbs-next
                aria-label="Scroll thumbnails right"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M9 6l6 6-6 6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>

        </div>
    <?php endif; ?>
</div>

<div class="detail-summary">
    <span class="pill">
        <?= e($product['category_name']) ?>
        <?= !empty($product['model_code']) ? ' ¡¤ ' . e($product['model_code']) : '' ?>
    </span><h2><?= e($product['name']) ?></h2><p class="lead"><?=e($product['description'] ?: $product['short_description'])?></p><div class="actions"><a class="btn btn-accent" href="/quote">Get a Free Quote</a><a class="btn btn-ghost" href="/assets/downloads/EZZOSG 080426 Doors Windows and Skylights catalogue final draft.pdf" download>Download Catalogue</a></div><table class="spec-table"><tbody><?php foreach($specRows as $row): ?><tr><th><?=e($row[0])?></th><td><?=e($row[1] ?? '')?></td></tr><?php endforeach; ?></tbody></table><div class="detail-block"><h2>Key features</h2><ul class="tick-list"><?php foreach(split_lines($product['features'] ?? '') as $line): ?><li><?=e($line)?></li><?php endforeach; ?></ul></div><div class="detail-block"><h2>Finishes and options</h2><ul class="tick-list"><?php foreach(split_lines(($product['finishes_options'] ?? '').'|'.($product['colors'] ?? '')) as $line): ?><li><?=e($line)?></li><?php endforeach; ?></ul></div><div class="detail-block"><h2>Technical data</h2><p><?=e($product['technical_data'] ?? 'Final dimensions, loading and installation details are confirmed after site measurement.')?></p><p><strong>Materials:</strong> <?=e(str_replace('|', ', ', $product['materials'] ?? '6063-T5 aluminium profile'))?></p></div></div>

</div></section>
<section class="section" style="padding-top:0"><div class="container contact-panel"><div class="contact-card"><div class="eyebrow">Product quote</div><h2>Request a quote for <?=e($product['name'])?>.</h2><p>Share your project location, dimensions, quantity and preferred finish. Our team will advise suitable configuration for Singapore conditions.</p><ul class="tick-list"><li>Site measurement guidance</li><li>Glass, frame and finish selection</li><li>Installation scheduling support</li></ul></div><div class="contact-card"><form action="/actions/submit-product-inquiry" method="post"><?=csrf_field()?><input type="hidden" name="product_name" value="<?=e($product['name'])?>"><div class="form-grid"><input name="name" required placeholder="Name"><input name="phone" required placeholder="Phone / WhatsApp"><input name="email" type="email" placeholder="Email"><input name="city" placeholder="Project location"><textarea class="full" name="message" placeholder="Dimensions, quantity, preferred finish, timeline"></textarea><button class="btn btn-accent full" type="submit">Send Product Inquiry</button></div></form></div></div></section>
<?php if($related): ?><section class="section category-band"><div class="container"><div class="section-head"><div><div class="eyebrow">Related products</div><h2>More <?=e(strtolower($product['category_name']))?> models.</h2></div></div><div class="grid-3"><?php foreach($related as $p): ?><article class="product-card"><img loading="lazy" src="<?=e(media_src($p['hero_image']))?>" alt="<?=e($p['name'])?>"><div class="card-body"><span class="pill"><?=e($p['subcategory'] ?: $p['category_name'])?></span><h3><?=e($p['name'])?></h3><p><?=e($p['short_description'])?></p><a class="btn-155" href="<?= e(product_link($p['slug'])) ?>" aria-label="View product: <?= e($p['name']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View details</span>
                        </a></div></article><?php endforeach; ?></div></div></section><?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-product-carousel]').forEach(function (carousel) {
        var mainImage = carousel.querySelector('[data-carousel-main]');
        var lightboxButton = carousel.querySelector('[data-carousel-lightbox]');
        var stage = carousel.querySelector('[data-carousel-stage]');
        var previousButton = carousel.querySelector('[data-carousel-prev]');
        var nextButton = carousel.querySelector('[data-carousel-next]');
        var currentCounter = carousel.querySelector('[data-carousel-current]');
        var thumbnailContainer = carousel.querySelector('[data-carousel-thumbs]');
        var thumbnailPrevious = carousel.querySelector('[data-thumbs-prev]');
        var thumbnailNext = carousel.querySelector('[data-thumbs-next]');
        var thumbnails = Array.prototype.slice.call(
            carousel.querySelectorAll('[data-thumb]')
        );

        if (!mainImage || thumbnails.length === 0) {
            return;
        }

        var currentIndex = 0;
        var touchStartX = 0;
        var touchEndX = 0;
        var changeToken = 0;

        function normalizeIndex(index) {
            if (index < 0) {
                return thumbnails.length - 1;
            }

            if (index >= thumbnails.length) {
                return 0;
            }

            return index;
        }

        function centreThumbnail(thumbnail) {
            if (!thumbnailContainer || !thumbnail) {
                return;
            }

            var targetLeft =
                thumbnail.offsetLeft -
                (thumbnailContainer.clientWidth - thumbnail.clientWidth) / 2;

            thumbnailContainer.scrollTo({
                left: Math.max(0, targetLeft),
                behavior: window.matchMedia(
                    '(prefers-reduced-motion: reduce)'
                ).matches ? 'auto' : 'smooth'
            });
        }

        function updateScrollButtons() {
            if (!thumbnailContainer) {
                return;
            }

            var maximumScroll =
                thumbnailContainer.scrollWidth -
                thumbnailContainer.clientWidth;

            if (thumbnailPrevious) {
                thumbnailPrevious.disabled =
                    thumbnailContainer.scrollLeft <= 2;
            }

            if (thumbnailNext) {
                thumbnailNext.disabled =
                    thumbnailContainer.scrollLeft >= maximumScroll - 2;
            }
        }

        function applyImage(index, source, alt) {
            currentIndex = index;

            mainImage.src = source;
            mainImage.alt = alt;
            mainImage.classList.remove('is-changing');

            if (lightboxButton) {
                lightboxButton.dataset.lightbox = source;
                lightboxButton.setAttribute(
                    'aria-label',
                    'Open enlarged image ' + (currentIndex + 1)
                );
            }

            thumbnails.forEach(function (thumbnail, thumbnailIndex) {
                var active = thumbnailIndex === currentIndex;

                thumbnail.classList.toggle('active', active);
                thumbnail.setAttribute(
                    'aria-current',
                    active ? 'true' : 'false'
                );
            });

            if (currentCounter) {
                currentCounter.textContent = String(currentIndex + 1);
            }

            centreThumbnail(thumbnails[currentIndex]);
            updateScrollButtons();
        }

        function updateImage(index) {
            var normalizedIndex = normalizeIndex(index);
            var thumbnail = thumbnails[normalizedIndex];
            var source = thumbnail.dataset.src;
            var alt = thumbnail.dataset.alt || '';

            if (!source) {
                return;
            }

            if (normalizedIndex === currentIndex) {
                centreThumbnail(thumbnail);
                return;
            }

            changeToken += 1;
            var thisChange = changeToken;

            mainImage.classList.add('is-changing');

            var preload = new Image();

            preload.onload = function () {
                if (thisChange !== changeToken) {
                    return;
                }

                applyImage(normalizedIndex, source, alt);
            };

            preload.onerror = function () {
                if (thisChange === changeToken) {
                    mainImage.classList.remove('is-changing');
                }
            };

            preload.src = source;
        }

        function showPrevious() {
            updateImage(currentIndex - 1);
        }

        function showNext() {
            updateImage(currentIndex + 1);
        }

        thumbnails.forEach(function (thumbnail, index) {
            thumbnail.addEventListener('click', function () {
                updateImage(index);
            });
        });

        if (previousButton) {
            previousButton.addEventListener('click', showPrevious);
        }

        if (nextButton) {
            nextButton.addEventListener('click', showNext);
        }

        if (thumbnailPrevious && thumbnailContainer) {
            thumbnailPrevious.addEventListener('click', function () {
                thumbnailContainer.scrollBy({
                    left: -Math.max(
                        240,
                        thumbnailContainer.clientWidth * 0.75
                    ),
                    behavior: 'smooth'
                });
            });
        }

        if (thumbnailNext && thumbnailContainer) {
            thumbnailNext.addEventListener('click', function () {
                thumbnailContainer.scrollBy({
                    left: Math.max(
                        240,
                        thumbnailContainer.clientWidth * 0.75
                    ),
                    behavior: 'smooth'
                });
            });
        }

        if (thumbnailContainer) {
            thumbnailContainer.addEventListener(
                'scroll',
                updateScrollButtons,
                { passive: true }
            );
        }

        carousel.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                showPrevious();
            } else if (event.key === 'ArrowRight') {
                event.preventDefault();
                showNext();
            } else if (event.key === 'Home') {
                event.preventDefault();
                updateImage(0);
            } else if (event.key === 'End') {
                event.preventDefault();
                updateImage(thumbnails.length - 1);
            }
        });

        if (stage) {
            stage.addEventListener(
                'touchstart',
                function (event) {
                    touchStartX = event.changedTouches[0].clientX;
                },
                { passive: true }
            );

            stage.addEventListener(
                'touchend',
                function (event) {
                    touchEndX = event.changedTouches[0].clientX;

                    var distance = touchStartX - touchEndX;

                    if (Math.abs(distance) < 50) {
                        return;
                    }

                    if (distance > 0) {
                        showNext();
                    } else {
                        showPrevious();
                    }
                },
                { passive: true }
            );
        }

        window.addEventListener('resize', updateScrollButtons);
        updateScrollButtons();
    });
});
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
