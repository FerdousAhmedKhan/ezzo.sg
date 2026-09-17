<?php
// ezzo.sg cPanel / MySQL configuration.
// Import database/schema.sql, then update the database and business details below.
define('DB_HOST','localhost');
define('DB_NAME','wefixsg_ezzoprev');
define('DB_USER','wefixsg_ezzoprev');
define('DB_PASS','XKKZN}XsZW}$OI}N');
define('SITE_NAME','ezzo.sg');
define('SITE_URL','https://ezzo.sg');
define('BUSINESS_EMAIL','admin@ezzogenics.com');
define('BUSINESS_PHONE','+65 6968 3098');
define('BUSINESS_ADDRESS','Bartley Biz Centre, Blk 15 Kaki Bukit Rd 4, #01-44, Singapore 417808');
define('BUSINESS_HOURS','Monday - Friday: 9:00 AM - 6:00 PM');
define('WHATSAPP_NUMBER','6596320750'); // country code + number, digits only, no + sign or spaces
define('UPLOAD_DIR',__DIR__.'/uploads/');
define('UPLOAD_URL','uploads/');
define('ADMIN_SESSION_KEY','ezzo_admin_id');

function db(): ?PDO {
  static $pdo = null;
  if ($pdo instanceof PDO) return $pdo;
  try {
    $pdo = new PDO(
      'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
      DB_USER,
      DB_PASS,
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
      ]
    );
    return $pdo;
  } catch (Throwable $e) {
    return null;
  }
}

if (session_status() === PHP_SESSION_NONE) session_start();
?>
