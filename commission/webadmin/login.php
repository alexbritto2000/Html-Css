<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>COMMISSION Admin Panel | Login</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/square/blue.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .err .status_msg_error{
            font-size: 13px;
            color: red;
            font-style: italic;
            text-align: center;
            font-weight: bold;
            padding-bottom: 25px;
        }
        .err .status_msg_success{
            font-size: 13px;
            color: green;
            font-style: italic;
            text-align: center;
            font-weight: bold;
            padding-bottom: 25px;
        }
        .shake_text{
            animation: shake-vertical 100ms ease-in-out 2;
        }
        .login-box-msg{
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo" style="margin-bottom:2px;">
        <a href="../index.php" target="_blank">
            <img src="../images/Logo.png" height="100" style="padding:9px;"/>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg" style="color:green;">Admin Panel</p>

        <div class="err">
            <?php
            if(!empty($_SESSION["cms_status"]) && !empty($_SESSION["cms_msg"])){
                switch($_SESSION["cms_status"]){
                    case 'error':
                        ?>
                        <div class="status_msg_error">
                            <?php
                            echo $_SESSION["cms_msg"];
                            ?>
                        </div>
                        <?php
                        break;
                    case 'success':
                        ?>
                        <div class="status_msg_success">
                            <?php
                            echo $_SESSION["cms_msg"];
                            ?>
                        </div>
                        <?php
                        break;
                }
                unset($_SESSION["cms_status"]);
                unset($_SESSION["cms_msg"]);
            }
            ?>
        </div>

        <form action="check.php" id="form_submit" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
               
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">

                    </div>
                </div>
                <div class="col-xs-4">
                    <input type="hidden" name="change_pwd" value="Change"/>
                    <input type="button" class="btn btn-primary btn-block btn-flat" value="Sign In" onclick="validation()"/>
                </div>
            </div>
        </form>

        <!--<a href="#">I forgot my password</a><br>-->
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/icheck.min.js"></script>
<script>
    function validation(){
        $(".err").html("");
        web_user = document.getElementById('username').value;
        if(web_user === '')
        {
            $(".err").html("<div class=\"status_msg_error\"></div>");
            $(".err").find(".status_msg_error").html("Please enter username!").removeClass("shake_text").addClass("shake_text");
            document.getElementById('username').focus();
            return false;
        }

        web_pass = document.getElementById('password').value;
        if(web_pass === '')
        {
            $(".err").html("<div class=\"status_msg_error\"></div>");
            $(".err").find(".status_msg_error").html("Please enter password!").removeClass("shake_text").addClass("shake_text");

            document.getElementById('password').focus();
            return false;
        }
        $.ajax({
            url: 'ajax/chk_auth.php',
            data: {username: web_user,password:web_pass},
            type: 'post',
            cache: false,
            async:true,
            success: function(data) { 
                if(data.toString()==="1"){
                    if($(".err").find(".status_msg_error").length>0){
                        $(".status_msg_error").html("");
                    }
                    document.getElementById("form_submit").submit();
                    return true;
                }
                else if(data.toString()==="2"){
                    $(".err").html("<div class=\"status_msg_error\"></div>");
                    $(".err").find(".status_msg_error").html("Invalid Username/Password!").removeClass("shake_text").addClass("shake_text");

                    return false;
                }
                else if(data.toString()==="3"){
                    $(".err").html("<div class=\"status_msg_error\"></div>");
                    $(".err").find(".status_msg_error").html("Please fill all fields!").removeClass("shake_text").addClass("shake_text");
                    return false;
                }
            }
        });
    }

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });

        $('#username').on("keydown",function(){
            if($(".err").find(".status_msg_error").length>0){
                $(".status_msg_error").detach();
            }
        });

        $('#password').on("keydown",function(){
            if($(".err").find(".status_msg_error").length>0){
                $(".status_msg_error").detach();
            }
        });
    });
	$("input").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        $("form").submit();
    }
	});
</script>
</body>
</html>