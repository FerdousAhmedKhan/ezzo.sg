<?php
require_once __DIR__ . '/../includes/functions.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email'] ?? ''); $pass=$_POST['password'] ?? '';
  $user=fetch_one("SELECT * FROM users WHERE email=? AND status='active' LIMIT 1",[$email]);
  if($user && password_verify($pass,$user['password_hash'])){ $_SESSION[ADMIN_SESSION_KEY]=$user['id']; $_SESSION['admin_name']=$user['name']; header('Location: dashboard.php'); exit; }
  $error='Invalid email or password.';
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="../assets/css/admin.css">
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <section class="admin-page" style="min-height:100vh;display:grid;place-items:center"><div class="contact-card" style="width:min(460px,92vw)"><h1 style="color:black">Admin Login</h1><?php if($error): ?><div class="notice" style="background:#fff0f0;border-color:#ffd0d0"><?= e($error) ?></div><?php endif; ?><form method="post"><div class="form-grid"><input class="full" type="email" name="email" required placeholder="Email"><input class="full" type="password" name="password" required placeholder="Password"><button class="btn btn-dark full">Login</button></div></form></div></section></body></html>
