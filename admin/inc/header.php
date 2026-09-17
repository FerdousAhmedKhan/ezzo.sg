<?php
require_once __DIR__ . '/auth.php';
require_admin();
$admin_title = $admin_title ?? 'Admin';
$asset_version = date('YmdHis'); // temporary cache-buster for cPanel testing
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title><?= e($admin_title) ?> | Admin | <?= e(SITE_NAME) ?></title>
  <link rel="stylesheet" href="/assets/css/style.css?v=<?= e($asset_version) ?>">
  <link rel="stylesheet" href="/assets/css/admin.css?v=<?= e($asset_version) ?>">
</head>
<body class="admin-page">
  <div class="ezzo-admin-layout">
    <aside class="ezzo-admin-sidebar">
      <a class="ezzo-admin-logo" href="dashboard.php" aria-label="Admin dashboard">
        <img src="../assets/images/ezzo-logo.png" alt="<?= e(SITE_NAME) ?> logo">
      </a>

      <nav class="ezzo-admin-nav" aria-label="Admin navigation">
        <a href="dashboard.php">Dashboard</a>
        <a href="categories.php">Categories</a>
        <a href="products.php">Products</a>
        <a href="projects.php">Projects</a>
        <a href="blog.php">Blog Posts</a>
        <a href="testimonials.php">Testimonials</a>
        <a href="leads.php">Contact Leads</a>
        <a href="quotes.php">Quote Requests</a>
        <a href="whatsapp.php">WhatsApp Clicks</a>
        <a href="/" target="_blank" rel="noopener">View Website</a>
        <a href="logout.php">Logout</a>
      </nav>
    </aside>

    <main class="ezzo-admin-main">
      <header class="ezzo-admin-topbar">
        <div>
          <span class="ezzo-admin-kicker">EZZO Admin</span>
          <h1><?= e($admin_title) ?></h1>
        </div>
        <span class="ezzo-admin-user">Signed in as <?= e(admin_user()) ?></span>
      </header>
