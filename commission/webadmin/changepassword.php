<?php
//error_reporting(1);
ob_start();
session_start();
include("../lib/config.php");

if(empty($_SESSION['comission_id']) && empty($_SESSION['username'])){
    $_SESSION["cms_status"]="error";
    $_SESSION["cms_msg"]="Please login now!";
    header('Location:login.php');
    exit();
}

$sitetitle.=" | Change Password";
$table_name="`".DB_PREFIX."_admin`";
$current_page="changepassword.php";

if(!empty($_POST["change_pwd"])){
    if(!empty($_POST["old_pass"]) && !empty($_POST["pass1"]) && !empty($_POST["pass2"])){
        if($_POST["pass1"]==$_POST["pass2"]){
            $sql="SELECT `web_id`, `username`, `password` FROM $table_name WHERE `web_id`='1'";
            $res=$db_cms->select_query_with_row($sql);
            if($res==TRUE){
                if($_POST["old_pass"]==$res["password"]){
					$sql="UPDATE $table_name SET `password`='".$db_cms->removeQuote($_POST["pass1"])."' WHERE `web_id`='".$res["web_id"]."'";
                    $res=$db_cms->update_query($sql);
                    if($res!=FALSE){
                        $_SESSION["cms_status"]="success";
                        $_SESSION["cms_msg"]="Changed successfully!";
                        header('Location:'.$current_page.'');
                        exit();
                    }
                    else{
                        $_SESSION["cms_status"]="error";
                        $_SESSION["cms_msg"]="Unable to change password!";
                        header('Location:'.$current_page.'');
                        exit();
                    }
                }
                else{
                    $_SESSION["cms_status"]="error";
                    $_SESSION["cms_msg"]="Invalid old password!";
                    header('Location:'.$current_page.'');
                    exit();
                }
            }
            else{
                $_SESSION["cms_status"]="error";
                $_SESSION["cms_msg"]="Error occurred!";
                header('Location:'.$current_page.'');
                exit();
            }
        }
        else{
            $_SESSION["cms_status"]="error";
            $_SESSION["cms_msg"]="New Password mismatched!";
            header('Location:'.$current_page.'');
            exit();
        }
    }
    else{
        $_SESSION["cms_status"]="error";
        $_SESSION["cms_msg"]="Please fill all fields!";
        header('Location:'.$current_page.'');
        exit();
    }
}


include("include/header.php");
/*  Space in head tag
 *  Use styles, javascript inline, external
 */
?>


<?php

/*  Space in head tag  */
include("include/sidebar.php");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Change Password
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Change Password</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Change Password</h3>
                        </div>
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
                        <form class="form-horizontal" id="form_submit" method="post" action="">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputPassword1" class="col-sm-2 control-label">Old Password&nbsp;:&nbsp;<span class="star">*</span></label>

                                    <div class="col-sm-6">
                                        <input type="password" name="old_pass" class="form-control" id="inputPassword1" placeholder="Old Password" autocomplete="off"/>
                                    </div>
									<label class="error-message" id="err_old_pwd"></label>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword2" class="col-sm-2 control-label">Password&nbsp;:&nbsp;<span class="star">*</span></label>

                                    <div class="col-sm-6">
                                        <input type="password" name="pass1" class="form-control" id="inputPassword2" placeholder="Password" autocomplete="off"/>
                                    </div>
									<label class="error-message" id="err_new_pwd"></label>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3"  class="col-sm-2 control-label">Re-Enter Password&nbsp;:&nbsp;<span class="star">*</span></label>

                                    <div class="col-sm-6">
                                        <input type="password" name="pass2" class="form-control" id="inputPassword3" placeholder="Re-Enter Password" autocomplete="off"/>
                                    </div>
									<label class="error-message" id="err_re_new_pwd"></label>
									<label class="error-message" id="err_mis_match"></label>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="change_pwd" value="Change"/>
                                        <input type="button" name="change_pwd" class="btn btn-info" value="Change" onclick="validation()"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
<?php
/*  Space in above </body> tag
 *  Use javascript inline, external
 */
?>
<script>
    function validation(){
        var aReqComplete=false;
        web_op = document.getElementById('inputPassword1').value;
        if(web_op === '')
        {
            document.getElementById("err_old_pwd").innerHTML = "Please enter old password";
            document.getElementById('inputPassword1').focus();
            return false;
        }
		else{
			document.getElementById("err_old_pwd").innerHTML = "";
		}

        $.ajax({
            url: 'ajax/chk_pwd.php',
            data: {pass_str: web_op},
            type: 'post',
            cache: false,
            async:false,
            success: function(data) {
                if(data.toString()=="1"){
                    aReqComplete=true;
                }
                else if(data.toString()=="2"){
					document.getElementById("err_old_pwd").innerHTML = "Invalid old password!";
                    return false;
                }
                else if(data.toString()=="21"){
                    alert("Error occurred!");
                    return false;
                }
                else if(data.toString()=="4"){
                    alert("Database is busy now! Try again later");
                    return false;
                }
                else if(data.toString()=="3"){
                    alert("Your session has expired. Please login again!");
                    window.location.href="index.php";
                    return false;
                }
            }
        });

        if(aReqComplete){
            web_np1 = document.getElementById('inputPassword2').value;
            if(web_np1 == '')
            {
				document.getElementById("err_new_pwd").innerHTML = "Please enter new password";
                document.getElementById('inputPassword2').focus();
                return false;
            }
			else{
				document.getElementById("err_new_pwd").innerHTML = "";
			}
            web_np2 = document.getElementById('inputPassword3').value;
            if(web_np2 == '')
            {
				document.getElementById("err_re_new_pwd").innerHTML = "Please re-enter new password";
                document.getElementById('inputPassword3').focus();
                return false;
            }
			else{
				document.getElementById("err_re_new_pwd").innerHTML = "";
			}
            if(web_np1 != web_np2){
				document.getElementById("err_mis_match").innerHTML = "New password mismatched";
                document.getElementById('inputPassword3').focus();
                return false;
            }
			else{
				document.getElementById("err_mis_match").innerHTML = "";
			}
            document.getElementById("form_submit").submit();
            return true;
        }
        return false;
    }
</script>
<?php
/*  Space in above </body> tag  */
include("include/footer.php");
?>