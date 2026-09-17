<?php
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) { http_response_code(403); exit('Invalid request'); }
$name=trim($_POST['name'] ?? ''); $phone=trim($_POST['phone'] ?? '');
$email=trim($_POST['email'] ?? ''); $city=trim($_POST['city'] ?? '');
$interest=trim($_POST['product_interest'] ?? ''); $message=trim($_POST['message'] ?? ''); $source=trim($_POST['source_page'] ?? 'contact');
$pdo=db();
if($pdo){
  $stmt=$pdo->prepare("INSERT INTO leads(name,phone,email,city,product_interest,message,source_page,created_at) VALUES(?,?,?,?,?,?,?,NOW())");
  $stmt->execute([$name,$phone,$email,$city,$interest,$message,$source]);
}
$subject='New website inquiry - '.SITE_NAME;
$body="Name: $name\nPhone: $phone\nEmail: $email\nCity: $city\nInterest: $interest\nMessage:\n$message";
@mail(BUSINESS_EMAIL,$subject,$body,"From: no-reply@".$_SERVER['HTTP_HOST']);
header('Location: /thank-you'); exit;
?>
