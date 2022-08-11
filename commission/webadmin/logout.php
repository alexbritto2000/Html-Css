<?php
session_start();
unset($_SESSION['web_id']);
unset($_SESSION['mozcon_username']);

$_SESSION["cms_status"]="success";
$_SESSION["cms_msg"]="You have successfully logged out!";
header('Location:login.php');
exit();
?>