<?php
require_once __DIR__ . '/includes/functions.php';

$meta = [
    'title' => 'Premium Doors, Windows & Skylights in Singapore | ezzo.sg',
    'description' => 'Premium aluminium doors, windows and skylights in Singapore, with custom configurations, insulated glass, refined finishes and professional installation.',
    'image' => production_url(asset('images/Ezzo-doors-windows-and-skylights.jpg')),
    'image_alt' => 'Premium aluminium doors, windows and skylights by Ezzo.sg',
    'preload_image' => asset('images/Asset 10.webp'),
];

$featured = get_featured_products(6);
$projects = get_featured_projects(3);
$testimonials = get_testimonials();

include __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <?= responsive_image(
        asset('images/Asset 10.webp'),
        '',
        [
            'class' => 'hero-media',
            'loading' => 'eager',
            'decoding' => 'async',
            'fetchpriority' => 'high',
            'sizes' => '100vw',
            'aria-hidden' => 'true',
        ]
    ) ?>
    <div class="container hero-content">
        <h1>Premium Aluminium Doors, Windows &amp; Skylights for Singapore</h1>
        <p class="lead">Designed for light. Engineered for Singapore heat, rain, noise and large-format living.</p>
        <div class="hero-actions">
            <a class="btn btn-accent" href="/quote">Request a Free Site Consultation</a>
            <a class="btn btn-light" href="/products">Explore Doors, Windows &amp; Skylights</a>
        </div>
    </div>
</section>

<section class="section category-band">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Doors, Windows &amp; Skylights Singapore</div>
                <h2>Discover the Ideal Doors, Windows &amp; Skylights for Your Property</h2>
            </div>
            <p>Ezzo.sg focuses on modern aluminium and glass systems for Singapore homes and commercial properties. Our product range includes sliding doors, folding doors, casement windows, sliding windows, skylights, sunroofs, entrance doors and selected custom aluminium-glass solutions.</p>
        </div>

        <div class="hero-stats">
            <div class="stat"><span>Thermal-Break &amp; Non-Thermal Systems</span></div>
            <div class="stat"><span>Singapore-Based Support</span></div>
            <div class="stat"><span>Professional Installation Support</span></div>
            <div class="stat"><span>Custom Colours, Sizes &amp; Finishes</span></div>
            <div class="stat"><span>After-Sales Assistance</span></div>
        </div>

        <div class="grid-3">
            <a class="category-card" href="/doors">
                <?= responsive_image(
                    asset('images/Ezzo-sg-doors-windows.jpg'),
                    'Premium aluminium sliding and folding doors in Singapore',
                    ['sizes' => '(max-width: 920px) 50vw, 33vw']
                ) ?>
                <div>
                    <span class="pill">Doors</span>
                    <h3>Sliding, Folding, Flat, Pivot &amp; Room Doors</h3>
                    <span class="btn-155">
                        <span class="button-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                        </span>
                        <span class="button-text">View products</span>
                    </span>
                </div>
            </a>

            <a class="category-card" href="/windows">
                <?= responsive_image(
                    asset('images/windows-video-poster.jpg'),
                    'Premium aluminium casement and sliding windows in Singapore',
                    ['sizes' => '(max-width: 920px) 50vw, 33vw']
                ) ?>
                <div>
                    <span class="pill">Windows</span>
                    <h3>Casement, Sliding, Folding &amp; Electric-Lift Windows</h3>
                    <span class="btn-155">
                        <span class="button-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                        </span>
                        <span class="button-text">View products</span>
                    </span>
                </div>
            </a>

            <a class="category-card" href="/skylights">
                <?= responsive_image(
                    asset('images/custom-skylights-singapore.webp'),
                    'Automated skylights and sunroof systems in Singapore',
                    ['sizes' => '(max-width: 920px) 50vw, 33vw']
                ) ?>
                <div>
                    <span class="pill">Skylights</span>
                    <h3>Automated Skylights, Sunroofs &amp; Mobile Sunrooms</h3>
                    <span class="btn-155">
                        <span class="button-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                        </span>
                        <span class="button-text">View products</span>
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Project portfolio</div>
                <h2>Explore Completed Projects and Find Inspiration for Your Space</h2>
            </div>
            <a class="btn btn-dark" href="/projects">View projects</a>
        </div>

        <div class="grid-3">
            <?php foreach ($projects as $pr): ?>
                <article
                    class="project-card"
                    data-card
                    data-category="<?= e(strtolower($pr['project_type'] ?? '')) ?>"
                    data-tags="<?= e($pr['filters'] ?? '') ?>">
                    <?= responsive_image(
                        media_src($pr['main_image']),
                        (string) $pr['title'],
                        ['sizes' => '(max-width: 920px) 50vw, 33vw']
                    ) ?>
                    <div class="card-body">
                        <span class="pill"><?= e($pr['project_type']) ?><?= !empty($pr['year']) ? ' · ' . e($pr['year']) : '' ?></span>
                        <h3><?= e($pr['title']) ?></h3>
                        <p><?= e($pr['description']) ?></p>
                        <a class="btn-155" href="<?= e(project_link($pr['slug'])) ?>" aria-label="View project: <?= e($pr['title']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View project</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section video-showcase">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Product video gallery</div>
                <h2 style="color:#fff">See Ezzo.sg Door, Window &amp; Skylight Systems in Motion</h2>
            </div>
            <p style="color:#c0c1c2">Explore how our door, window and skylight systems perform in motion for Singapore homes and commercial spaces.</p>
        </div>

        <div class="video-grid">
            <article class="video-card">
                <video controls playsinline preload="none" poster="<?= e(asset('images/Folding-Door.webp')) ?>">
                    <source src="<?= e(asset('videos/Ezzo_Door.mp4')) ?>" type="video/mp4">
                </video>
                <div><span>Doors</span><h3>Anti-Pinch Heavy-Duty Folding Door with Non-Thermal-Break Frame</h3></div>
            </article>

            <article class="video-card">
                <video controls playsinline preload="none" poster="<?= e(asset('images/windows-video-poster.jpg')) ?>">
                    <source src="<?= e(asset('videos/Ezzo-110-series-windows.mp4')) ?>" type="video/mp4">
                </video>
                <div><span>Windows</span><h3>PRO110 Series Casement Window</h3></div>
            </article>

            <article class="video-card">
                <video controls playsinline preload="none" poster="<?= e(asset('images/80mm-thermal-break-sliding-window.jpg')) ?>">
                    <source src="<?= e(asset('videos/80mm-thermal-brake-sliding-window.mp4')) ?>" type="video/mp4">
                </video>
                <div><span>Windows</span><h3>80 mm Thermal-Break Sliding Window with Continuous Track</h3></div>
            </article>

            <article class="video-card">
                <video controls playsinline preload="none" poster="<?= e(asset('images/doors-video-poster.jpg')) ?>">
                    <source src="<?= e(asset('videos/Ezzo SG Folding door installation video.mp4')) ?>" type="video/mp4">
                </video>
                <div><span>Doors</span><h3>Series 001 Folding Door Installation Guide</h3></div>
            </article>

            <article class="video-card">
                <video controls playsinline preload="none" poster="<?= e(asset('images/Heavy sliding door with 127 and 190 mm frame platform_3.webp')) ?>">
                    <source src="<?= e(asset('videos/Series 127 Sliding door installation .mp4')) ?>" type="video/mp4">
                </video>
                <div><span>Doors</span><h3>Series 127 Sliding Door Installation</h3></div>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Popular Systems in Singapore</div>
                <h2>Find the Best System for Your Design, Comfort and Budget</h2>
            </div>
            <a class="btn btn-dark" href="/products">View all products</a>
        </div>

        <div class="grid-3">
            <?php foreach ($featured as $p): ?>
                <article
                    class="product-card"
                    data-card
                    data-category="<?= e($p['category_slug']) ?>"
                    data-tags="<?= e(strtolower(($p['subcategory'] ?? '') . ' ' . ($p['model_code'] ?? ''))) ?>">
                    <?= responsive_image(
                        media_src($p['hero_image']),
                        (string) $p['name'],
                        ['sizes' => '(max-width: 920px) 50vw, 33vw']
                    ) ?>
                    <div class="card-body">
                        <span class="pill"><?= e($p['category_name']) ?><?= !empty($p['model_code']) ? ' · ' . e($p['model_code']) : '' ?></span>
                        <h3><?= e($p['name']) ?></h3>
                        <p><?= e($p['short_description']) ?></p>
                        <a class="btn-155" href="<?= e(product_link($p['slug'])) ?>" aria-label="View product: <?= e($p['name']) ?>">
                            <span class="button-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" focusable="false"><path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path></svg>
                            </span>
                            <span class="button-text">View details</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Product performance</div>
                <h2>Protect Your Space with Eight Advanced Performance Features</h2>
            </div>
            <p>Our systems are selected for real project requirements including rain protection, wind-pressure resistance, sound control, insulation, airtightness, security and mechanical strength. Every recommendation depends on the product model, glass type, frame profile, installation condition and site requirements.</p>
        </div>

        <div class="grid-4">
            <div class="feature-card"><div class="feature-icon">1</div><h3>Watertightness</h3><p>Designed to reduce water ingress when installed with the correct frame, glass, sealant and drainage details.</p></div>
            <div class="feature-card"><div class="feature-icon">2</div><h3>Wind-Pressure Resistance</h3><p>Suitable system options are recommended based on opening size, height, exposure and project requirements.</p></div>
            <div class="feature-card"><div class="feature-icon">3</div><h3>Energy Saving &amp; Insulation</h3><p>Thermal-break aluminium systems and Low-E glass options help improve indoor comfort and reduce heat transfer.</p></div>
            <div class="feature-card"><div class="feature-icon">4</div><h3>Sound Insulation</h3><p>Glass and frame combinations can be selected to support quieter indoor spaces for homes, offices and commercial interiors.</p></div>
            <div class="feature-card"><div class="feature-icon">5</div><h3>Airtight Performance</h3><p>Quality sealing and accurate installation help improve comfort, reduce drafts and support better indoor performance.</p></div>
            <div class="feature-card"><div class="feature-icon">6</div><h3>Security Support</h3><p>Stronger profiles, suitable locking systems and proper installation help improve protection for doors and windows.</p></div>
            <div class="feature-card"><div class="feature-icon">7</div><h3>Mechanical Strength</h3><p>Durable aluminium profiles and hardware are selected to support smooth operation and long-term daily use.</p></div>
            <div class="feature-card"><div class="feature-icon">8</div><h3>Quality Assurance</h3><p>From product selection to installation, each project is handled with attention to measurements, finishing and after-sales support.</p></div>
        </div>
    </div>
</section>

<section class="section dark-band">
    <div class="container split">
        <div>
            <div class="eyebrow">Door, Window &amp; Skylight Installation Process</div>
            <h2>How We Work</h2>
            <p>Our process starts with understanding the project. We review the opening type, usage, building condition, design preference, budget direction and installation constraints. Where needed, we arrange a site visit or request measurements, photos and drawings so the recommendation can be more accurate.</p>
            <p>After product selection, we prepare the quotation and coordinate confirmation, production, delivery and installation. We aim to keep communication clear so customers understand what is being supplied, what needs to be confirmed and what may depend on site conditions.</p>
            <ul class="tick-list">
                <li>Requirement review and site visit</li>
                <li>Quotation, production scheduling and quality inspection</li>
                <li>Packing, shipping, delivery and receipt</li>
                <li>Installation, customer acceptance and aftercare</li>
            </ul>
            <a class="btn btn-accent" href="/quote">Start Your Project</a>
        </div>
        <?= responsive_image(
            asset('images/customer service process flow.webp'),
            'Ezzo customer service and installation process',
            ['sizes' => '(max-width: 920px) 100vw, 50vw']
        ) ?>
    </div>
</section>

<section class="section">
    <div class="container split">
        <?= responsive_image(
            asset('images/About ezzo.sg.webp'),
            'About Ezzo.sg aluminium doors, windows and skylights',
            ['sizes' => '(max-width: 920px) 100vw, 50vw']
        ) ?>
        <div>
            <div class="eyebrow">About Ezzo.sg</div>
            <h2>Premium Aluminium Doors, Windows &amp; Skylights Backed by Ezzogenics</h2>
            <p>Ezzo.sg is a Singapore-focused brand for premium aluminium doors, windows and skylight systems. We help homeowners, landed-property owners, designers, architects, contractors and commercial clients select suitable systems for openings, facades, roofs and interior spaces where design, performance and installation quality matter.</p>
            <p>Our work is not only about supplying a product. A good door, window or skylight depends on the right frame profile, glass configuration, opening method, hardware, site measurement, waterproofing detail, installation approach and after-sales support. Ezzo.sg brings these parts together so clients can make clearer decisions before fabrication and installation.</p>
            <ul class="tick-list">
                <li>Premium aluminium and glass systems</li>
                <li>Custom sizing, colour and specification options</li>
                <li>Thermal-break and non-thermal system choices</li>
                <li>Professional installation and project support</li>
                <li>After-sales service for long-term confidence</li>
            </ul>
            <a class="btn btn-accent" href="/about">Learn about us</a>
        </div>
    </div>
</section>

<section class="section" style="background-color:#2d484f">
    <div class="container" style="text-align:center">
        <h2 style="color:#fff">Tell Us About Your Project</h2>
        <p style="color:#fff;padding-bottom:20px">Share your project type, product category, location and measurements. Our team will contact you with suitable model guidance and the next steps.</p>
    </div>

    <div class="container">
        <form class="quote-steps" action="/actions/submit-quote" method="post" accept-charset="UTF-8">
            <?= csrf_field() ?>
            <div class="step-indicator" aria-hidden="true"><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>

            <div class="step active">
                <h3>Step 1: Project Type</h3>
                <div class="option-grid">
                    <label class="radio-card"><input type="radio" name="project_type" value="Landed House" required> Landed House</label>
                    <label class="radio-card"><input type="radio" name="project_type" value="Apartment / Condo"> Apartment / Condo</label>
                    <label class="radio-card"><input type="radio" name="project_type" value="Office"> Office</label>
                    <label class="radio-card"><input type="radio" name="project_type" value="Commercial"> Commercial</label>
                </div>
            </div>

            <div class="step">
                <h3>Step 2: Product Category</h3>
                <div class="option-grid">
                    <label class="radio-card"><input type="checkbox" name="product_category[]" value="Doors"> Doors</label>
                    <label class="radio-card"><input type="checkbox" name="product_category[]" value="Windows"> Windows</label>
                    <label class="radio-card"><input type="checkbox" name="product_category[]" value="Skylights"> Skylights</label>
                    <label class="radio-card"><input type="checkbox" name="product_category[]" value="Not sure - need advice"> Not sure — need advice</label>
                </div>
            </div>

            <div class="step">
                <h3>Step 3: Project Details</h3>
                <div class="form-grid">
                    <label class="sr-only" for="quote-city">Project location in Singapore</label>
                    <input id="quote-city" name="city" autocomplete="address-level2" placeholder="Project location in Singapore">
                    <label class="sr-only" for="quote-timeline">Project timeline</label>
                    <input id="quote-timeline" name="timeline" placeholder="Timeline, e.g. urgent / 1–3 months">
                    <label class="sr-only" for="quote-details">Project details</label>
                    <textarea id="quote-details" class="full" name="project_details" placeholder="Measurements, quantity, floor level, model interest, colour, glass type and site notes"></textarea>
                </div>
            </div>

            <div class="step">
                <h3>Step 4: Contact Information</h3>
                <div class="form-grid">
                    <label class="sr-only" for="quote-name">Name</label>
                    <input id="quote-name" name="name" required autocomplete="name" placeholder="Name">
                    <label class="sr-only" for="quote-phone">Phone or WhatsApp number</label>
                    <input id="quote-phone" name="phone" required type="tel" autocomplete="tel" inputmode="tel" placeholder="Phone / WhatsApp">
                    <label class="sr-only" for="quote-email">Email address</label>
                    <input id="quote-email" name="email" type="email" autocomplete="email" placeholder="Email">
                    <label class="sr-only" for="quote-contact-time">Preferred contact time</label>
                    <input id="quote-contact-time" name="preferred_contact" placeholder="Preferred contact time">
                    <label class="sr-only" for="quote-message">Additional project information</label>
                    <textarea id="quote-message" class="full" name="message" placeholder="Anything else we should know?"></textarea>
                </div>
            </div>

            <div class="actions" style="margin-top:28px">
                <button class="btn btn-ghost" type="button" data-prev>Back</button>
                <button class="btn btn-dark" type="button" data-next>Next</button>
                <button class="btn btn-accent hidden" type="submit" data-submit>Submit Quote Request</button>
            </div>
        </form>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Not Sure Which Performance Features You Need?</h2>
        <p>If you are planning to upgrade doors, windows or skylights, contact Ezzo.sg with your property type, opening size, preferred design and project timeline. Our team can help review the requirement and recommend a suitable next step.</p>
        <div class="hero-actions" style="justify-content:center">
            <a class="btn btn-light" href="<?= e(whatsapp_link('Hello ezzo.sg, I would like a free quote.')) ?>" aria-label="Contact Ezzo.sg on WhatsApp">Talk to Our Specialist</a>
        </div>
    </div>
</section>

<?php if ($testimonials !== []): ?>
<section class="section">
    <div class="container">
        <div class="section-head">
            <div>
                <div class="eyebrow">Client confidence</div>
                <h2>Trusted by Homeowners, Architects and Business Owners</h2>
            </div>
        </div>

        <div class="grid-3">
            <?php foreach ($testimonials as $t): ?>
                <?php $rating = max(0, min(5, (int) ($t['rating'] ?? 5))); ?>
                <div class="testimonial card-body">
                    <div class="stars" aria-label="<?= $rating ?> out of 5 stars"><?= str_repeat('★', $rating) ?></div>
                    <p>“<?= e($t['content']) ?>”</p>
                    <strong><?= e($t['client_name']) ?></strong><br>
                    <span class="small-muted"><?= e($t['client_role'] ?? '') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
