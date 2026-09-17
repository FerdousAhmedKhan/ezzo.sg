<?php

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/catalog-data.php';

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function encode_url_path(string $path): string
{
    $segments = explode('/', str_replace('\\', '/', $path));

    return implode('/', array_map(
        static fn(string $segment): string => rawurlencode(rawurldecode($segment)),
        $segments
    ));
}

function url(string $path = ''): string
{
    return rtrim((string) SITE_URL, '/') . '/' . ltrim($path, '/');
}

function production_site_url(): string
{
    if (defined('PRODUCTION_SITE_URL') && trim((string) PRODUCTION_SITE_URL) !== '') {
        return rtrim((string) PRODUCTION_SITE_URL, '/');
    }

    return 'https://www.ezzo.sg';
}

function production_url(string $path = ''): string
{
    if (is_external_url($path)) {
        return $path;
    }

    return production_site_url() . '/' . ltrim($path, '/');
}

function request_host(): string
{
    $host = strtolower(trim((string) ($_SERVER['HTTP_HOST'] ?? '')));

    return preg_replace('/:\d+$/', '', $host) ?: '';
}

function is_preview_host(): bool
{
    $host = request_host();

    return $host === 'preview-ezzo.ezzogenics.com'
        || strpos($host, 'preview-') === 0;
}

function send_preview_robots_header(): void
{
    if (is_preview_host() && !headers_sent()) {
        header('X-Robots-Tag: noindex, nofollow, noarchive', true);
    }
}

function site_path(string $path = ''): string
{
    $path = trim($path);

    if ($path === '' || $path === 'index.php' || $path === 'index') {
        return '/';
    }

    $path = preg_replace('/\.php$/', '', $path) ?? $path;

    return '/' . ltrim($path, '/');
}

function product_link(string $slug): string
{
    return '/product/' . rawurlencode($slug);
}

function project_link(string $slug): string
{
    return '/project/' . rawurlencode($slug);
}

function blog_link(string $slug): string
{
    return '/blog/' . rawurlencode($slug);
}

function asset(string $path): string
{
    return '/assets/' . ltrim(encode_url_path($path), '/');
}

function current_page(): string
{
    return basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
}

function canonical_url(?string $requestUri = null): string
{
    $uri = $requestUri ?? (string) ($_SERVER['REQUEST_URI'] ?? '/');
    $uri = (string) (strtok($uri, '?') ?: '/');
    $uri = preg_replace('#/index(?:\.php)?$#i', '/', $uri) ?? $uri;
    $uri = preg_replace('/\.php$/i', '', $uri) ?? $uri;
    $uri = '/' . ltrim($uri, '/');

    return production_url($uri);
}

function current_url(): string
{
    return canonical_url();
}

function is_external_url(string $source): bool
{
    return (bool) preg_match('/^https?:\/\//i', $source);
}

function is_first_party_host(string $host): bool
{
    $host = strtolower($host);
    $productionHost = strtolower((string) parse_url(production_site_url(), PHP_URL_HOST));

    return $host === ''
        || $host === request_host()
        || $host === $productionHost
        || $host === 'ezzo.sg'
        || $host === 'www.ezzo.sg'
        || $host === 'preview-ezzo.ezzogenics.com';
}

function encode_local_url(string $source): string
{
    $parts = parse_url($source);

    if ($parts === false) {
        return $source;
    }

    $path = encode_url_path((string) ($parts['path'] ?? $source));
    $query = isset($parts['query']) ? '?' . $parts['query'] : '';
    $fragment = isset($parts['fragment']) ? '#' . rawurlencode($parts['fragment']) : '';

    return $path . $query . $fragment;
}

function media_src($source): string
{
    $source = trim((string) $source);

    if ($source === '') {
        return asset('images/Ezzo-doors-windows-and-skylights.jpg');
    }

    if (is_external_url($source)) {
        $host = (string) parse_url($source, PHP_URL_HOST);

        // Prevent production pages from depending on the public preview domain.
        if (is_first_party_host($host)) {
            return encode_local_url($source);
        }

        return $source;
    }

    return encode_local_url('/' . ltrim($source, '/'));
}

function page_slug(): string
{
    return pathinfo(current_page(), PATHINFO_FILENAME);
}

function is_active(string $file): string
{
    return current_page() === $file ? ' active' : '';
}

function aria_current(string $file): string
{
    return current_page() === $file ? ' aria-current="page"' : '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return (string) $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals((string) $_SESSION['csrf_token'], (string) $_POST['csrf_token']);
}

function fetch_all(string $sql, array $params = []): array
{
    $pdo = db();

    if (!$pdo) {
        return [];
    }

    try {
        $statement = $pdo->prepare($sql);
        $statement->execute($params);

        return $statement->fetchAll();
    } catch (Throwable $exception) {
        error_log('Database query failed: ' . $exception->getMessage());

        return [];
    }
}

function fetch_one(string $sql, array $params = []): ?array
{
    $rows = fetch_all($sql, $params);

    return $rows[0] ?? null;
}

function db_table_columns(string $table): array
{
    if (!preg_match('/^[A-Za-z0-9_]+$/', $table)) {
        return [];
    }

    $rows = fetch_all('SHOW COLUMNS FROM `' . $table . '`');

    return array_map(static fn(array $row): string => (string) ($row['Field'] ?? ''), $rows);
}

function db_has_column(string $table, string $column): bool
{
    static $cache = [];

    if (!isset($cache[$table])) {
        $cache[$table] = db_table_columns($table);
    }

    return in_array($column, $cache[$table], true);
}

function split_lines($text): array
{
    if (is_array($text)) {
        return $text;
    }

    $text = (string) $text;

    if ($text === '') {
        return [];
    }

    return array_values(array_filter(array_map(
        'trim',
        preg_split('/\r\n|\r|\n|\|/', $text) ?: []
    )));
}

function first_line($text): string
{
    $lines = split_lines($text);

    return (string) ($lines[0] ?? '');
}

function slugify($text): string
{
    $slug = strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', (string) $text), '-'));

    return $slug !== '' ? $slug : 'item';
}

function meta_defaults(): array
{
    return [
        'title' => 'Premium Aluminium Doors, Windows & Skylights in Singapore | ' . SITE_NAME,
        'description' => 'Premium aluminium doors, windows and skylights in Singapore with custom sizing, insulated glass, refined finishes and professional installation.',
        'image' => production_url(asset('images/Ezzo-doors-windows-and-skylights.jpg')),
        'type' => 'website',
        'canonical' => canonical_url(),
        'robots' => is_preview_host()
            ? 'noindex, nofollow, noarchive'
            : 'index, follow, max-image-preview:large',
    ];
}

function public_file_path(string $source): ?string
{
    $parts = parse_url($source);

    if ($parts === false) {
        return null;
    }

    $host = strtolower((string) ($parts['host'] ?? ''));

    if ($host !== '' && !is_first_party_host($host)) {
        return null;
    }

    $path = rawurldecode((string) ($parts['path'] ?? ''));

    if ($path === '' || strpos($path, "\0") !== false) {
        return null;
    }

    $root = realpath(dirname(__DIR__)) ?: dirname(__DIR__);
    $candidate = $root . DIRECTORY_SEPARATOR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    $real = realpath($candidate);

    if ($real === false || !is_file($real)) {
        return null;
    }

    $normalizedRoot = rtrim(str_replace('\\', '/', $root), '/') . '/';
    $normalizedReal = str_replace('\\', '/', $real);

    if (strpos($normalizedReal, $normalizedRoot) !== 0) {
        return null;
    }

    return $real;
}

function versioned_asset(string $path): string
{
    $source = asset($path);
    $file = public_file_path($source);

    if ($file === null) {
        return $source;
    }

    return $source . '?v=' . filemtime($file);
}

function image_dimensions(string $source): ?array
{
    static $cache = [];

    $source = media_src($source);

    if (array_key_exists($source, $cache)) {
        return $cache[$source];
    }

    $file = public_file_path($source);

    if ($file === null) {
        return $cache[$source] = null;
    }

    $size = @getimagesize($file);

    if ($size === false) {
        return $cache[$source] = null;
    }

    return $cache[$source] = [
        'width' => (int) $size[0],
        'height' => (int) $size[1],
        'mime' => (string) ($size['mime'] ?? ''),
    ];
}

function image_url_variant(string $source, string $suffix, string $extension): string
{
    $parts = parse_url($source);
    $path = (string) ($parts['path'] ?? $source);
    $directory = str_replace('\\', '/', dirname($path));
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $variant = ($directory === '/' ? '' : $directory) . '/' . $filename . $suffix . '.' . $extension;

    return encode_local_url($variant);
}

function image_source_set(string $source, string $extension, array $widths = [480, 768, 1200, 1600]): string
{
    $entries = [];
    $source = media_src($source);
    $originalExtension = strtolower(pathinfo((string) parse_url($source, PHP_URL_PATH), PATHINFO_EXTENSION));
    $baseCandidate = image_url_variant($source, '', $extension);

    if ($originalExtension === strtolower($extension)) {
        $baseCandidate = $source;
    }

    foreach ($widths as $width) {
        $width = (int) $width;

        if ($width <= 0) {
            continue;
        }

        $candidate = image_url_variant($source, '-' . $width, $extension);

        if (public_file_path($candidate) !== null) {
            $entries[$width] = $candidate . ' ' . $width . 'w';
        }
    }

    $baseFile = public_file_path($baseCandidate);

    if ($baseFile !== null) {
        $size = @getimagesize($baseFile);
        $baseWidth = $size !== false ? (int) $size[0] : 0;

        if ($baseWidth > 0 && !isset($entries[$baseWidth])) {
            $entries[$baseWidth] = $baseCandidate . ' ' . $baseWidth . 'w';
        } elseif ($baseWidth === 0 && $entries === []) {
            return $baseCandidate;
        }
    }

    ksort($entries);

    return implode(', ', $entries);
}

function responsive_image(string $source, string $alt, array $options = []): string
{
    $source = media_src($source);
    $dimensions = image_dimensions($source);
    $sizes = (string) ($options['sizes'] ?? '(max-width: 767px) 100vw, 50vw');
    $widths = is_array($options['widths'] ?? null) ? $options['widths'] : [480, 768, 1200, 1600];
    $extension = strtolower(pathinfo((string) parse_url($source, PHP_URL_PATH), PATHINFO_EXTENSION));

    $attributes = [
        'src' => $source,
        'alt' => $alt,
        'loading' => (string) ($options['loading'] ?? 'lazy'),
        'decoding' => (string) ($options['decoding'] ?? 'async'),
    ];

    foreach (['class', 'id', 'fetchpriority', 'title', 'role', 'aria-hidden'] as $attribute) {
        if (isset($options[$attribute]) && $options[$attribute] !== '') {
            $attributes[$attribute] = (string) $options[$attribute];
        }
    }

    if ($dimensions !== null) {
        $attributes['width'] = (string) ($options['width'] ?? $dimensions['width']);
        $attributes['height'] = (string) ($options['height'] ?? $dimensions['height']);
    } else {
        foreach (['width', 'height'] as $attribute) {
            if (isset($options[$attribute])) {
                $attributes[$attribute] = (string) $options[$attribute];
            }
        }
    }

    $fallbackSet = image_source_set($source, $extension, $widths);

    if ($fallbackSet !== '') {
        $attributes['srcset'] = $fallbackSet;
        $attributes['sizes'] = $sizes;
    }

    $attributeString = implode(' ', array_map(
        static fn(string $name, string $value): string => $name . '="' . e($value) . '"',
        array_keys($attributes),
        array_values($attributes)
    ));

    $sources = [];

    if ($extension !== 'avif') {
        $avifSet = image_source_set($source, 'avif', $widths);

        if ($avifSet !== '') {
            $sources[] = '<source type="image/avif" srcset="' . e($avifSet) . '" sizes="' . e($sizes) . '">';
        }
    }

    if ($extension !== 'webp') {
        $webpSet = image_source_set($source, 'webp', $widths);

        if ($webpSet !== '') {
            $sources[] = '<source type="image/webp" srcset="' . e($webpSet) . '" sizes="' . e($sizes) . '">';
        }
    }

    $image = '<img ' . $attributeString . '>';

    if ($sources === []) {
        return $image;
    }

    return '<picture>' . implode('', $sources) . $image . '</picture>';
}

function enrich_product(array $product): array
{
    $product['category_slug'] = $product['category_slug'] ?? slugify($product['category_name'] ?? 'products');
    $product['category_name'] = $product['category_name'] ?? ucfirst(str_replace('-', ' ', (string) $product['category_slug']));
    $product['subcategory'] = $product['subcategory'] ?? '';
    $product['model_code'] = $product['model_code'] ?? '';
    $product['hero_image'] = media_src($product['hero_image'] ?? '');
    $product['gallery_images'] = $product['gallery_images'] ?? $product['hero_image'];
    $product['featured'] = (int) ($product['featured'] ?? 0);

    return $product;
}

function enrich_project(array $project): array
{
    $project['main_image'] = media_src($project['main_image'] ?? '');
    $project['gallery_images'] = $project['gallery_images'] ?? $project['main_image'];
    $project['filters'] = strtolower(
        (string) ($project['filters'] ?? '') . ' '
        . (string) ($project['project_type'] ?? '') . ' '
        . (string) ($project['product_type'] ?? '')
    );
    $project['featured'] = (int) ($project['featured'] ?? 0);

    return $project;
}

function get_categories(): array
{
    $rows = fetch_all('SELECT * FROM categories ORDER BY sort_order ASC, name ASC');

    return $rows ?: catalog_categories();
}

function get_category_by_slug(string $slug): ?array
{
    foreach (get_categories() as $category) {
        if (($category['slug'] ?? '') === $slug) {
            return $category;
        }
    }

    return null;
}

function product_db_rows(): array
{
    $rows = fetch_all(
        "SELECT p.*, c.name category_name, c.slug category_slug
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         WHERE p.status = 'published'
         ORDER BY p.name ASC"
    );

    return array_map('enrich_product', $rows);
}

function get_products(): array
{
    $databaseProducts = product_db_rows();
    $sampleProducts = array_map('enrich_product', catalog_products());

    if (!$databaseProducts) {
        return $sampleProducts;
    }

    $slugs = array_column($databaseProducts, 'slug');

    foreach ($sampleProducts as $product) {
        if (!in_array($product['slug'], $slugs, true)) {
            $databaseProducts[] = $product;
        }
    }

    return $databaseProducts;
}

function get_featured_products(int $limit = 8): array
{
    $products = get_products();
    $items = array_values(array_filter(
        $products,
        static fn(array $product): bool => (int) ($product['featured'] ?? 0) === 1
    ));

    if (count($items) < $limit) {
        foreach ($products as $product) {
            $slug = (string) ($product['slug'] ?? '');
            $alreadyAdded = array_filter(
                $items,
                static fn(array $item): bool => (string) ($item['slug'] ?? '') === $slug
            );

            if ($alreadyAdded === []) {
                $items[] = $product;
            }

            if (count($items) >= $limit) {
                break;
            }
        }
    }

    return array_slice($items, 0, $limit);
}

function get_products_by_category(string $slug): array
{
    return array_values(array_filter(
        get_products(),
        static fn(array $product): bool => ($product['category_slug'] ?? '') === $slug
    ));
}

function get_product_subcategories(string $slug): array
{
    $subcategories = [];

    foreach (get_products_by_category($slug) as $product) {
        $subcategory = (string) ($product['subcategory'] ?? '');

        if ($subcategory !== '' && !in_array($subcategory, $subcategories, true)) {
            $subcategories[] = $subcategory;
        }
    }

    return $subcategories;
}

function get_product_by_slug(string $slug): ?array
{
    foreach (get_products() as $product) {
        if (($product['slug'] ?? '') === $slug) {
            return enrich_product($product);
        }
    }

    return null;
}

function get_related_products(array $product, int $limit = 3): array
{
    $related = [];

    foreach (get_products() as $candidate) {
        if (
            ($candidate['slug'] ?? '') !== ($product['slug'] ?? '')
            && ($candidate['category_slug'] ?? '') === ($product['category_slug'] ?? '')
        ) {
            $related[] = $candidate;
        }

        if (count($related) >= $limit) {
            break;
        }
    }

    return $related;
}

function project_db_rows(): array
{
    $rows = fetch_all("SELECT * FROM projects WHERE status = 'published' ORDER BY id DESC");

    return array_map('enrich_project', $rows);
}

function get_projects(): array
{
    $databaseProjects = project_db_rows();
    $sampleProjects = array_map('enrich_project', catalog_projects());

    if (!$databaseProjects) {
        return $sampleProjects;
    }

    $slugs = array_column($databaseProjects, 'slug');

    foreach ($sampleProjects as $project) {
        if (!in_array($project['slug'], $slugs, true)) {
            $databaseProjects[] = $project;
        }
    }

    return $databaseProjects;
}

function get_featured_projects(int $limit = 6): array
{
    $items = array_values(array_filter(
        get_projects(),
        static fn(array $project): bool => (int) ($project['featured'] ?? 0) === 1
    ));

    return array_slice($items ?: get_projects(), 0, $limit);
}

function get_project_by_slug(string $slug): ?array
{
    foreach (get_projects() as $project) {
        if (($project['slug'] ?? '') === $slug) {
            return enrich_project($project);
        }
    }

    return null;
}

function get_related_projects(array $project, int $limit = 3): array
{
    $related = [];

    foreach (get_projects() as $candidate) {
        if (
            ($candidate['slug'] ?? '') !== ($project['slug'] ?? '')
            && ($candidate['project_type'] ?? '') === ($project['project_type'] ?? '')
        ) {
            $related[] = $candidate;
        }

        if (count($related) >= $limit) {
            break;
        }
    }

    if ($related !== []) {
        return $related;
    }

    return array_slice(array_filter(
        get_projects(),
        static fn(array $candidate): bool => ($candidate['slug'] ?? '') !== ($project['slug'] ?? '')
    ), 0, $limit);
}

function get_testimonials(): array
{
    // Do not publish invented fallback reviews. Only show approved database entries.
    return fetch_all("SELECT * FROM testimonials WHERE status = 'published' ORDER BY id DESC LIMIT 8");
}

function get_blog_posts(): array
{
    $rows = fetch_all("SELECT * FROM blog_posts WHERE status = 'published' ORDER BY published_at DESC, id DESC");

    return $rows ?: catalog_blog_posts();
}

function get_blog_post_by_slug(string $slug): ?array
{
    foreach (get_blog_posts() as $post) {
        if (($post['slug'] ?? '') === $slug) {
            return $post;
        }
    }

    return null;
}

function whatsapp_link(string $message = 'Hello ezzo.sg, I would like a free quote.'): string
{
    return '/track-whatsapp?message=' . rawurlencode($message);
}

function phone_uri(string $phone): string
{
    $phone = trim($phone);
    $hasPlus = strpos($phone, '+') === 0;
    $digits = preg_replace('/\D+/', '', $phone) ?? '';

    return 'tel:' . ($hasPlus ? '+' : '') . $digits;
}

function is_gd_image($image): bool
{
    return is_resource($image)
        || (is_object($image) && get_class($image) === 'GdImage');
}

function create_image_canvas(int $width, int $height)
{
    if (!function_exists('imagecreatetruecolor')) {
        return false;
    }

    $canvas = imagecreatetruecolor($width, $height);

    if (!$canvas) {
        return false;
    }

    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);
    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
    imagefill($canvas, 0, 0, $transparent);

    return $canvas;
}

function resize_gd_image($source, int $targetWidth)
{
    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);

    if ($targetWidth <= 0 || $sourceWidth <= 0 || $sourceHeight <= 0) {
        return false;
    }

    $targetWidth = min($targetWidth, $sourceWidth);
    $targetHeight = max(1, (int) round($sourceHeight * ($targetWidth / $sourceWidth)));
    $canvas = create_image_canvas($targetWidth, $targetHeight);

    if (!$canvas) {
        return false;
    }

    imagecopyresampled(
        $canvas,
        $source,
        0,
        0,
        0,
        0,
        $targetWidth,
        $targetHeight,
        $sourceWidth,
        $sourceHeight
    );

    return $canvas;
}

function upload_image(string $field, string $folder = 'products'): ?string
{
    if (
        empty($_FILES[$field]['name'])
        || (int) ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
        || !is_uploaded_file((string) $_FILES[$field]['tmp_name'])
    ) {
        return null;
    }

    $temporaryFile = (string) $_FILES[$field]['tmp_name'];
    $fileSize = (int) ($_FILES[$field]['size'] ?? 0);

    if ($fileSize <= 0 || $fileSize > 20 * 1024 * 1024) {
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = (string) $finfo->file($temporaryFile);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif',
    ];

    if (!isset($allowed[$mime])) {
        return null;
    }

    $folder = trim((string) preg_replace('/[^A-Za-z0-9_\/-]/', '', $folder), '/');
    $directory = rtrim((string) UPLOAD_DIR, '/\\') . DIRECTORY_SEPARATOR;
    $urlDirectory = rtrim((string) UPLOAD_URL, '/') . '/';

    if ($folder !== '') {
        $directory .= str_replace('/', DIRECTORY_SEPARATOR, $folder) . DIRECTORY_SEPARATOR;
        $urlDirectory .= $folder . '/';
    }

    if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
        return null;
    }

    $baseName = 'img_' . bin2hex(random_bytes(10));

    // Re-encoding strips EXIF/IPTC metadata and produces modern formats.
    if (function_exists('imagecreatefromstring') && function_exists('imagewebp')) {
        $binary = file_get_contents($temporaryFile);
        $image = $binary !== false ? @imagecreatefromstring($binary) : false;

        if (is_gd_image($image)) {
            $sourceWidth = imagesx($image);
            $sourceHeight = imagesy($image);

            if ($sourceWidth > 0 && $sourceHeight > 0 && ($sourceWidth * $sourceHeight) <= 50_000_000) {
                $mainWidth = min(2000, $sourceWidth);
                $mainImage = resize_gd_image($image, $mainWidth);

                if (is_gd_image($mainImage)) {
                    $webpPath = $directory . $baseName . '.webp';
                    imagewebp($mainImage, $webpPath, 82);

                    if (function_exists('imageavif')) {
                        @imageavif($mainImage, $directory . $baseName . '.avif', 55);
                    }

                    imagedestroy($mainImage);

                    foreach ([480, 768, 1200, 1600] as $width) {
                        if ($width >= $sourceWidth) {
                            continue;
                        }

                        $variant = resize_gd_image($image, $width);

                        if (!is_gd_image($variant)) {
                            continue;
                        }

                        imagewebp($variant, $directory . $baseName . '-' . $width . '.webp', 80);

                        if (function_exists('imageavif')) {
                            @imageavif($variant, $directory . $baseName . '-' . $width . '.avif', 52);
                        }

                        imagedestroy($variant);
                    }

                    imagedestroy($image);

                    return encode_local_url($urlDirectory . $baseName . '.webp');
                }
            }

            imagedestroy($image);
        }
    }

    // Safe fallback when GD/WebP support is unavailable on the server.
    $extension = $allowed[$mime];
    $filename = $baseName . '.' . $extension;

    if (!move_uploaded_file($temporaryFile, $directory . $filename)) {
        return null;
    }

    return encode_local_url($urlDirectory . $filename);
}

function schema_json($data): string
{
    return (string) json_encode(
        $data,
        JSON_UNESCAPED_SLASHES
        | JSON_UNESCAPED_UNICODE
        | JSON_HEX_TAG
        | JSON_HEX_AMP
        | JSON_HEX_APOS
        | JSON_HEX_QUOT
    );
}
