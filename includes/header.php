<?php
require_once __DIR__ . '/functions.php';

send_preview_robots_header();

$meta = array_merge(meta_defaults(), $meta ?? []);
$canonical = (string) ($meta['canonical'] ?? canonical_url());
$robots = (string) ($meta['robots'] ?? meta_defaults()['robots']);
$metaImage = (string) ($meta['image'] ?? meta_defaults()['image']);
$metaImage = is_external_url($metaImage) ? $metaImage : production_url($metaImage);
$cssUrl = versioned_asset('css/style.css');
$fontUrl = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap';
$phoneHref = phone_uri((string) BUSINESS_PHONE);
$preloadImage = !empty($meta['preload_image']) ? (string) $meta['preload_image'] : '';
$preloadImage = $preloadImage !== '' && !is_external_url($preloadImage)
    ? media_src($preloadImage)
    : $preloadImage;

$schemaGraph = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'HomeAndConstructionBusiness',
            '@id' => production_url('/#business'),
            'name' => SITE_NAME,
            'url' => production_url('/'),
            'logo' => production_url(asset('images/ezzo-logo.png')),
            'image' => $metaImage,
            'telephone' => BUSINESS_PHONE,
            'email' => BUSINESS_EMAIL,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Bartley Biz Centre, Blk 15 Kaki Bukit Rd 4, #01-44',
                'addressLocality' => 'Singapore',
                'postalCode' => '417808',
                'addressCountry' => 'SG',
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Singapore',
            ],
            'serviceType' => [
                'Aluminium door supply and installation',
                'Aluminium window supply and installation',
                'Skylight supply and installation',
                'Architectural glazing',
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => production_url('/#website'),
            'url' => production_url('/'),
            'name' => SITE_NAME,
            'publisher' => ['@id' => production_url('/#business')],
            'inLanguage' => 'en-SG',
        ],
    ],
];
?>
<!doctype html>
<html lang="en-SG">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">

    <title><?= e($meta['title']) ?></title>
    <meta name="description" content="<?= e($meta['description']) ?>">
    <meta name="robots" content="<?= e($robots) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="en-SG" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">

    <meta property="og:locale" content="en_SG">
    <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
    <meta property="og:title" content="<?= e($meta['title']) ?>">
    <meta property="og:description" content="<?= e($meta['description']) ?>">
    <meta property="og:type" content="<?= e($meta['type'] ?? 'website') ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($metaImage) ?>">
    <meta property="og:image:alt" content="<?= e($meta['image_alt'] ?? 'Ezzo.sg aluminium doors, windows and skylights in Singapore') ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($meta['title']) ?>">
    <meta name="twitter:description" content="<?= e($meta['description']) ?>">
    <meta name="twitter:image" content="<?= e($metaImage) ?>">

    <meta name="theme-color" content="#12384a">
    <link rel="icon" type="image/png" href="<?= e(asset('images/favicon.png')) ?>">

    <?php if ($preloadImage !== ''): ?>
        <link rel="preload" as="image" href="<?= e($preloadImage) ?>" fetchpriority="high">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="<?= e($fontUrl) ?>">
    <link rel="stylesheet" href="<?= e($fontUrl) ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?= e($fontUrl) ?>"></noscript>

    <!-- Critical above-the-fold styles. The full stylesheet loads asynchronously below. -->
    <style>
        :root{--ink:#12212b;--muted:#60717d;--brand:#12384a;--brand-2:#0a2634;--accent:#8cc63e;--line:#dce5e7;--container:1180px}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;background:#fff;color:var(--ink);line-height:1.65}img{display:block;max-width:100%;height:auto}a{color:inherit;text-decoration:none}.container{width:min(var(--container),calc(100% - 40px));margin-inline:auto}.skip-link{position:fixed;left:12px;top:12px;z-index:1000;padding:10px 14px;background:#fff;color:#000;border-radius:8px;transform:translateY(-180%)}.skip-link:focus{transform:none}.ezzo-topbar{position:relative;z-index:130;width:100%;background:#073b40;color:#fff;font-size:13px}.ezzo-topbar__container{width:min(100% - 40px,1400px);min-height:44px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:24px}.ezzo-topbar__message,.ezzo-topbar__actions,.ezzo-topbar__link{display:flex;align-items:center}.ezzo-topbar__actions{gap:18px}.ezzo-topbar__link{gap:7px}.ezzo-topbar__location{font-style:normal;color:rgba(255,255,255,.82)}.ezzo-topbar__quote{min-height:44px;padding:0 21px;display:inline-flex;align-items:center;background:#b7793f;color:#fff;text-transform:uppercase;font-size:11px;font-weight:700}.site-header{position:sticky;top:0;z-index:120;display:flex;align-items:center;justify-content:space-between;gap:24px;padding:14px clamp(18px,4vw,46px);background:rgba(255,255,255,.94);border-bottom:1px solid rgba(220,229,231,.8)}.brand-logo img{width:172px;max-height:54px;object-fit:contain}.main-nav{display:flex;align-items:center;gap:22px;font-size:14px;font-weight:800}.nav-toggle{display:none;width:42px;height:42px;border:1px solid var(--line);background:#fff;border-radius:14px;align-items:center;justify-content:center;flex-direction:column;gap:5px}.nav-toggle span{width:19px;height:2px;background:var(--ink)}.hero{position:relative;min-height:760px;display:flex;align-items:center;overflow:hidden;background:var(--brand);color:#fff}.hero:after{content:"";position:absolute;inset:0;background:linear-gradient(237deg,rgba(18,56,74,.32),rgba(10,38,52,.5))}.hero-media{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.hero-content{position:relative;z-index:2}.hero h1{max-width:980px;margin:10px 0 16px;color:#fff;font-family:"Playfair Display",Georgia,serif;font-size:clamp(44px,7vw,86px);line-height:1.05;letter-spacing:-.045em}.hero .lead{max-width:760px;color:rgba(255,255,255,.86);font-size:19px}.hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px}.btn{display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent;border-radius:999px;padding:14px 22px;font-weight:600;line-height:1}.btn-accent{background:var(--accent);color:#fff}.btn-light{background:#fff;color:var(--brand-2)}
        @media(max-width:920px){.nav-toggle{display:flex}.main-nav{position:fixed;top:118px;left:16px;right:16px;display:none;flex-direction:column;align-items:flex-start;background:#fff;border:1px solid var(--line);border-radius:24px;padding:22px}.main-nav.open{display:flex}.main-nav a{width:100%}.hero{min-height:680px}}
        @media(max-width:767px){.ezzo-topbar__message,.ezzo-topbar__location{display:none}.ezzo-topbar__container{width:100%;min-height:48px}.ezzo-topbar__actions{width:100%;display:grid;grid-template-columns:1fr auto 1.35fr;gap:0}.ezzo-topbar__phone,.ezzo-topbar__whatsapp,.ezzo-topbar__quote{min-height:48px;padding:8px 10px;justify-content:center}.site-header{padding:12px 14px}.brand-logo img{width:136px}.main-nav{top:106px}.hero{min-height:80vh}.hero h1{font-size:44px}.hero-actions .btn{width:100%}}
    </style>

    <link rel="preload" href="<?= e($cssUrl) ?>" as="style">
    <link rel="stylesheet" href="<?= e($cssUrl) ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?= e($cssUrl) ?>"></noscript>

    <script type="application/ld+json"><?= schema_json($schemaGraph) ?></script>
    <?php if (!empty($schema_markup)): ?>
        <script type="application/ld+json"><?= schema_json($schema_markup) ?></script>
    <?php endif; ?>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>

<div class="ezzo-topbar" role="region" aria-label="Ezzo contact information">
    <div class="ezzo-topbar__container">
        <div class="ezzo-topbar__message">
            <span>Premium Aluminium Doors, Windows &amp; Skylights in Singapore</span>
        </div>

        <div class="ezzo-topbar__actions">
            <address class="ezzo-topbar__location">Bartley Biz Centre, Blk 15 Kaki Bukit Rd 4, #01-44, Singapore 417808</address>

            <a class="ezzo-topbar__link ezzo-topbar__phone" href="<?= e($phoneHref) ?>" aria-label="Call Ezzo Singapore at <?= e(BUSINESS_PHONE) ?>">
                <span aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="20" height="20" focusable="false"><path d="M6.6 10.8a15.7 15.7 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.2 11.5 11.5 0 0 0 3.6.6 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.6 21 3 13.4 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.5 11.5 0 0 0 .6 3.6 1 1 0 0 1-.3 1Z" fill="currentColor"/></svg>
                </span>
                <span class="ezzo-topbar__phone-text"><?= e(BUSINESS_PHONE) ?></span>
            </a>

            <a class="ezzo-topbar__link ezzo-topbar__whatsapp" href="<?= e(whatsapp_link('Hello Ezzo, I would like more information about your doors, windows or skylights.')) ?>" aria-label="Chat with Ezzo Singapore on WhatsApp">
                <span aria-hidden="true">
                    <svg viewBox="0 0 32 32" width="22" height="22" focusable="false"><path fill="currentColor" d="M16 3a12.7 12.7 0 0 0-11 19.1L3.2 29l7.1-1.9A12.8 12.8 0 1 0 16 3Zm0 23.2c-1.9 0-3.8-.5-5.4-1.5l-.4-.2-4.2 1.1 1.1-4.1-.3-.4A10.4 10.4 0 1 1 16 26.2Zm5.7-7.8c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-.9 1.2-.2.2-.3.2-.7.1a8.5 8.5 0 0 1-2.5-1.6 9.4 9.4 0 0 1-1.7-2.1c-.2-.3 0-.5.1-.6l.5-.6.3-.5c.1-.2.1-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.4 1.4 3.6c.2.2 2.5 3.8 6 5.3.8.4 1.5.6 2 .7.8.3 1.6.2 2.2.1.7-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.2-.3-.5-.4-.8-.6Z"/></svg>
                </span>
                <span class="ezzo-topbar__desktop-text">WhatsApp</span>
            </a>

            <a class="ezzo-topbar__quote" href="/quote">Request a Free Site Consultation</a>
        </div>
    </div>
</div>

<header class="site-header" id="siteHeader">
    <a href="/" class="brand brand-logo" aria-label="<?= e(SITE_NAME) ?> home">
        <img src="<?= e(asset('images/ezzo-logo.png')) ?>" alt="<?= e(SITE_NAME) ?>" width="170" height="54" decoding="async">
    </a>

    <button class="nav-toggle" type="button" aria-label="Open navigation" aria-controls="mainNav" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <nav class="main-nav" id="mainNav" aria-label="Main navigation">
        <a class="<?= e(trim(is_active('index.php'))) ?>"<?= aria_current('index.php') ?> href="/">Home</a>
        <a class="<?= e(trim(is_active('doors.php'))) ?>"<?= aria_current('doors.php') ?> href="/doors">Doors</a>
        <a class="<?= e(trim(is_active('windows.php'))) ?>"<?= aria_current('windows.php') ?> href="/windows">Windows</a>
        <a class="<?= e(trim(is_active('skylights.php'))) ?>"<?= aria_current('skylights.php') ?> href="/skylights">Skylights</a>
        <a class="<?= e(trim(is_active('projects.php'))) ?>"<?= aria_current('projects.php') ?> href="/projects">Projects</a>
        <a class="<?= e(trim(is_active('about.php'))) ?>"<?= aria_current('about.php') ?> href="/about">About</a>
        <a class="<?= e(trim(is_active('blog.php'))) ?>"<?= aria_current('blog.php') ?> href="/blog">Blog</a>
        <a class="<?= e(trim(is_active('contact.php'))) ?>"<?= aria_current('contact.php') ?> href="/contact">Contact</a>
        <a class="btn btn-accent btn-small" href="/quote">Get a Free Quote</a>
    </nav>
</header>

<main id="main-content">
