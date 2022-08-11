<?php
session_start(); 
include_once("../../lib/config.php");
if(!empty($_POST["username"]) && !empty($_POST["password"])){ 
	$db_cms_res=$db_cms->chkAuth($_POST["username"],$_POST["password"]);
	if(!$db_cms_res){
		echo "2";  //  invalid
	}
	else{
		echo "1";  //   success
	}
}
else{
	echo "3";  // field empty
}
?>