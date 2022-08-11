<?php 
include("../../lib/config.php");

$table_name="`".DB_PREFIX."_users`";
$email = $_REQUEST['web_useremail'];
$action = $_REQUEST['action'];
$web_id = $_REQUEST['web_id'];
if($action == "add"){
	$mail="select `web_useremail` from $table_name where `web_useremail`='".$email."'";
}
if($action == "edit"){
	$mail="select `web_useremail` from $table_name where `web_useremail`='".$email."' and web_id !=".$web_id;
}
// echo $mail; 
echo ($result=$db_cms->select_query_with_no_rows($mail)!=FALSE)?$result:0;
?>