<?php
require_once __DIR__ . '/../includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf()) { http_response_code(403); exit('Invalid request'); }
$project_type=trim($_POST['project_type'] ?? '');
$product_category=implode(', ', $_POST['product_category'] ?? []);
$city=trim($_POST['city'] ?? ''); $timeline=trim($_POST['timeline'] ?? ''); $details=trim($_POST['project_details'] ?? '');
$name=trim($_POST['name'] ?? ''); $phone=trim($_POST['phone'] ?? ''); $email=trim($_POST['email'] ?? ''); $preferred=trim($_POST['preferred_contact'] ?? ''); $message=trim($_POST['message'] ?? '');
$pdo=db();
if($pdo){$stmt=$pdo->prepare("INSERT INTO quote_requests(project_type,product_category,city,timeline,project_details,name,phone,email,preferred_contact,message,created_at) VALUES(?,?,?,?,?,?,?,?,?,?,NOW())");$stmt->execute([$project_type,$product_category,$city,$timeline,$details,$name,$phone,$email,$preferred,$message]);}
$body="Project type: $project_type\nProducts: $product_category\nCity: $city\nTimeline: $timeline\nDetails: $details\nName: $name\nPhone: $phone\nEmail: $email\nPreferred contact: $preferred\nMessage: $message";
@mail(BUSINESS_EMAIL,'New quote request - '.SITE_NAME,$body,"From: no-reply@".$_SERVER['HTTP_HOST']);
header('Location: /thank-you'); exit;
?>
