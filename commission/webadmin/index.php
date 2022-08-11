<?php
error_reporting(1);
ob_start();
session_start();
if(empty($_SESSION['commission_id']) && empty($_SESSION['commission_username'])){
    $_SESSION["cms_status"]="error";
    $_SESSION["cms_msg"]="Please login now!";
    header('Location:login.php');
    exit();
}
include("../lib/config.php");
$sitetitle.=" | Welcome";
include("include/header.php");
?>
<style>
    .msg_cont_position{
        padding:100px 0;
    }
    .msg_cont_style{
        margin:0 auto;
        float: none
    }
    .msg_style{
        line-height: 40px;
    }
</style>
<?php
/*  Space in head tag  */

include("include/sidebar.php");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) 
        <section class="content-header">
            <h1>
                Welcome
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Welcome</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="row msg_cont_position">
                        <div class="col-xs-5 text-center msg_cont_style">
                            <h4 class="msg_style">Welcome to <b>Commission Admin Panel</b>!<br/> 
                                Please choose an option from the left menu.</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
<?php 
include("include/footer.php");
?>