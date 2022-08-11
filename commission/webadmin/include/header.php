<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    // Don't edit this range -----------------------------------
    $sitetitle=(isset($sitetitle)?(!empty($sitetitle)?$sitetitle:"Admin Panel 1"):"Admin Panel 3");
    ?>
    <title>Comission<?php echo $sitetitle;?></title>
    <?php
    // ---------------------------------------------------------
    ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/morris.css">
    <link rel="stylesheet" href="css/jquery-jvectormap.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/daterangepicker.css">
    <link rel="stylesheet" href="plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/skins/skin-custom-blue.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" /> 
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.repeater.js"></script>
	<script src="js/jquery.form-repeater.js" type="text/javascript"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
<header class="main-header">
    <a href="../index.php" class="logo" target="_blank" style="height: 100px;    border: 1px solid #7Ec242;">
        <span class="logo-mini"><img src="../images/Logo.png" alt="commission" height="45" width="45"/></span>
        <span class="logo-lg" style="height: 50px;">
            <img src="../images/Logo.png" alt="commission" height="60"/>
        </span>
    </a>
    <nav class="navbar navbar-static-top" style="height: 25px;">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        
                        <span class="hidden-xs">
                            <?php
                            if(!empty($_SESSION["comission_username"])){
                                echo $_SESSION["comission_username"];
                            }
                            else{
                                echo "User";
                            }
                            ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            
                            <p>
                                <?php
                                if(!empty($_SESSION["comission_username"])){
                                    echo $_SESSION["comission_username"]." - Administrator";
                                }
                                else{
                                    echo "User - Unknown";
                                }
                                ?>

                                <small></small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="row">

                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="changepassword.php" class="btn btn-default btn-flat">Change Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="logout.php" class="btn btn-default btn-flat">Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>