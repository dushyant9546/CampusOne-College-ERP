<?php
require_once __DIR__.'/config.php'; require_role(['admin']);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }
verify_csrf();
$title=trim($_POST['title']??''); $message=trim($_POST['message']??'');
if ($title==='' || $message==='') { $_SESSION['flash']='Please complete both announcement fields.'; header('Location: dashboard.php#settings'); exit; }
$data=load_json(PORTAL_FILE); $items=$data['announcements']??[];
array_unshift($items,['id'=>time(),'title'=>mb_substr($title,0,100),'message'=>mb_substr($message,0,500),'date'=>date('Y-m-d'),'by'=>'Campus Administration']);
$data['announcements']=array_slice($items,0,50);
$_SESSION['flash']=save_json(PORTAL_FILE,$data)?'Announcement published successfully.':'Could not save announcement. Check data folder permissions.';
header('Location: dashboard.php#settings'); exit;
