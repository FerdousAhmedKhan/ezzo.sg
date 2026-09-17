<?php
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) { http_response_code(403); exit('Invalid request'); }
$product=trim($_POST['product_name'] ?? 'Product inquiry');
$name=trim($_POST['name'] ?? ''); $phone=trim($_POST['phone'] ?? ''); $email=trim($_POST['email'] ?? ''); $city=trim($_POST['city'] ?? ''); $message=trim($_POST['message'] ?? '');
$pdo=db();
if($pdo){$stmt=$pdo->prepare("INSERT INTO leads(name,phone,email,city,product_interest,message,source_page,created_at) VALUES(?,?,?,?,?,?,?,NOW())");$stmt->execute([$name,$phone,$email,$city,$product,$message,'product-page']);}
@mail(BUSINESS_EMAIL,'New product inquiry - '.$product,"Product: $product\nName: $name\nPhone: $phone\nEmail: $email\nCity: $city\nMessage:\n$message","From: no-reply@".$_SERVER['HTTP_HOST']);
header('Location: /thank-you'); exit;
?>
