<?php
require_once __DIR__ . '/includes/functions.php';
$message = $_GET['message'] ?? 'Hello, I would like a free consultation.';
$pdo=db();
if($pdo){
  try{$stmt=$pdo->prepare("INSERT INTO whatsapp_clicks(message,source_page,ip_address,user_agent,created_at) VALUES(?,?,?,?,NOW())");$stmt->execute([$message,$_SERVER['HTTP_REFERER'] ?? '',$_SERVER['REMOTE_ADDR'] ?? '',$_SERVER['HTTP_USER_AGENT'] ?? '']);}catch(Throwable $e){}
}
header('Location: https://wa.me/'.WHATSAPP_NUMBER.'?text='.urlencode($message)); exit;
?>
