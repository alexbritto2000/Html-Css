<?php
error_reporting(1); 
session_start();
ob_start();

$ip=$_SERVER["SERVER_ADDR"]; 
if($ip=="::1")
{ 
	define("DB_HOST", "localhost");
	define("DB_NAME", "commission");
	define("DB_USER", "root");
	define("DB_PASS", "");

	$sitepath='http://localhost:81/commission/';
}
else
{  
    define("DB_HOST", "localhost");
    define("DB_NAME", "commission");
    define("DB_USER", "zst_mysql_admin");
    define("DB_PASS", "4QHbBDEkXMJj9zIg");

	$sitepath='http://192.168.1.103/sampletask/commission/';
	$siteadminpath='http://192.168.1.103/sampletask/commission/webadmin'; 
} 
define("DB_PREFIX", "commission"); 
$date = date('m/d/Y');
$datetime = date('Y/m/d h:i:s');
define('CURRENT_DATE',$date); 
include("mysqli_class.php");

$db_cms = new DBManager(); 
if($db_cms->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME)== FALSE){
	echo "Could not connect";
    exit;
}  
?>