
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<title>Home - Commission</title>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="images/favicon.png">
<link href="css/stylz.css" type="text/css" rel="stylesheet" />
<link href="css/banner.css" typle="text/css" rel="stylesheet">
</head>
<body>
<?php
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];

if($currentFile=="index.php"){ $index="class='active'"; } else {  $index=""; }
if($currentFile=="about.php"){ $about="class='active'"; } else {  $about=""; }
if($currentFile=="services.php"){ $services="class='active'"; } else {  $services=""; }
if($currentFile=="contact.php"){ $contact="class='active'"; } else {  $contact=""; }
$table_welcomecontent="`".DB_PREFIX."_welcomecontent`";
$table_banner="`".DB_PREFIX."_banner`";
$table_partners_section="`".DB_PREFIX."_partners_section`";
$table_advance="`".DB_PREFIX."_advance`";
$table_site_settings="`".DB_PREFIX."_site_settings``";
$table_social_media="`".DB_PREFIX."_social_media`";
$table_testimonials="`".DB_PREFIX."_testimonials`";
?>