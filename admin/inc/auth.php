<?php
require_once __DIR__ . '/../../includes/functions.php';
function require_admin(){ if(empty($_SESSION[ADMIN_SESSION_KEY])){ header('Location: login.php'); exit; } }
function admin_user(){ return $_SESSION['admin_name'] ?? 'Admin'; }
?>
