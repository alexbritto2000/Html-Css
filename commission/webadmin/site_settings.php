<?php 
ob_start();
session_start();
include("../lib/config.php"); 

if(empty($_SESSION['commission_id']) && empty($_SESSION['username'])){
    $_SESSION["cms_status"]="error";
    $_SESSION["cms_msg"]="Please login now!";
    header('Location:login.php');
    exit();
}
$sitetitle.=" | Site settings";

//  manage settings + action---#
$is_add_enabled=true;
$is_edit_enabled=true;
$is_delete_enabled=true;

$table_name="`".DB_PREFIX."_site_settings`";
$current_page="site_settings.php";


if(!empty($_REQUEST["action"])) {
    if ($_REQUEST["action"] == "edit" || $_REQUEST["action"] == "add" || $_REQUEST["action"] == "delete" || $_REQUEST["action"] == "view" ) {
        if($_REQUEST["action"] == "edit" && !$is_edit_enabled){
            $_SESSION["cms_status"]="error";
            $_SESSION["cms_msg"]="Edit action disabled!";
            header('Location:'.$current_page.'');
            exit();
        }
        if($_REQUEST["action"] == "add" && !$is_add_enabled){
            $_SESSION["cms_status"]="error";
            $_SESSION["cms_msg"]="Add action disabled!";
            header('Location:'.$current_page.'');
            exit();
        }
        if($_REQUEST["action"] == "delete" && !$is_delete_enabled){
            $_SESSION["cms_status"]="error";
            $_SESSION["cms_msg"]="Delete action disabled!";
            header('Location:'.$current_page.'');
            exit();
        }

        if($_REQUEST["action"] == "delete" && $is_delete_enabled && !empty($_REQUEST["web_id"])){
            $sql="DELETE FROM $table_name WHERE `web_id`='".$db->removeQuote($_REQUEST["web_id"])."'";
            $res=$db->delete_query($sql);
            if($res!=FALSE){
                $_SESSION["cms_status"]="success";
                $_SESSION["cms_msg"]="Deleted successfully!";
                header('Location:'.$current_page.'');
                exit();
            }
            else{
                $_SESSION["cms_status"]="error";
                $_SESSION["cms_msg"]="Unable to delete!";
                header('Location:'.$current_page.'');
                exit();
            }
        }
    }
    else{
        header('Location:'.$current_page.'');
        exit();
    }
}

if(!empty($_POST["submit_action"]) && (!empty($_POST["edit_action"]) || !empty($_POST["add_action"]))){
    if(!empty($_POST["s_phone_no"]) && !empty($_POST["s_address"]) && !empty($_POST["s_email"]) && !empty($_POST["s_copyright"])){
		$content_page="welcome_content";
        if(!empty($_POST["edit_action"])){
            $sql="UPDATE $table_name SET `site_phone_no`='".$db_cms->removeQuote(get_entity($_POST["s_phone_no"]))."', `site_email`='".$db_cms->removeQuote(get_entity($_POST["s_email"]))."', `site_copyright`='".$db_cms->removeQuote(get_entity($_POST["s_copyright"]))."',`site_address`='".$db_cms->removeQuote(get_entity($_POST["s_address"]))."',`modified_date`='".$datetime."' WHERE `web_id`='".$db_cms->removeQuote($_POST["edit_action"])."'";
        }
        else{
            $sql="INSERT INTO $table_name(`site_phone_no`,  `site_email`, `site_copyright`,`site_address`,`created_date`) VALUES ('".$db_cms->removeQuote(get_entity($_POST["s_phone_no"]))."','".$db_cms->removeQuote(get_entity($_POST["s_email"]))."','".$db_cms->removeQuote(get_entity($_POST["s_copyright"]))."','".$db_cms->removeQuote(get_entity($_POST["s_address"]))."',$datetime)";
        }

        $res=$db_cms->update_query($sql);  // <-  normal query function this
        if($res!=FALSE){
            $_SESSION["cms_status"]="success";
            if(!empty($_POST["edit_action"])){
                $_SESSION["cms_msg"]="Updated successfully!";
                header('Location:'.$current_page.'');
                exit();
            }
            else{
                $_SESSION["cms_msg"]="Added successfully!";
                header('Location:'.$current_page.'');
                exit();
            }
        }
        else{
            $_SESSION["cms_status"]="error";
            $_SESSION["cms_msg"]=(!empty($_POST["edit_action"]))?"Unable to update!":"Unable to add!";
        }
    }
    else{
        $_SESSION["cms_status"]="error";
        $_SESSION["cms_msg"]="Field is empty!";
    }
}

// -------------------#

include("include/header.php");
/*  Space in head tag
 *  Use styles, javascript inline, external
 */


/*  Space in head tag  */
include("include/sidebar.php");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Site Settings Management
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li> 
                <li class="active">Site Settings</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header col-xs-11">
                            <?php
                            if(!empty($_REQUEST["action"])){
                                ?>
                                <h3 class="box-title"><?php echo ucfirst($_REQUEST["action"]);?> Site Settings</h3>
                                <?php
                            }
                            else{
                                ?>
								<div class="pull-right">
                                    <a class="btn bg-maroon display_none <?php echo ($is_add_enabled)?"":"disabled";?>" href="<?php echo ($is_add_enabled)?"?action=add":"javascript:void(0);";?>"><i class="fa  fa-plus"></i> &nbsp;Add</a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div style="clear: both"></div>
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
                        <?php
                        $no_action=false;
                        if(!empty($_REQUEST["action"])) {
                            $no_action = false;
                            $c_id="";
                            $s_phone_no="";
                            $s_email=""; 
                            $s_copy="";
                            $s_address="";
                            // $site_country="";
                            if(($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="view") && !empty($_REQUEST["web_id"])){
                                $sql="SELECT * FROM $table_name WHERE web_id='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
                                $res=$db_cms->select_query_with_row($sql);
                                $c_id=$res["web_id"];
                                $s_phone_no=$res["site_phone_no"];
                                $s_email=$res["site_email"]; 
                                $s_copy=$res["site_copyright"];
                                $s_address=$res["site_address"];
                                // $site_country=$res["site_country"];
                            }
                            if($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="add"){
                        ?>
                        <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site Address&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                            <div class="form-group">
                                                <textarea id="s_address" class="form-control" name="s_address"><?php echo get_symbol($s_address);?></textarea>  
                                            </div>
											<label class="error-message" id="err_s_address"></label>
                                    </div>
                                </div>
									<div class="form-group">
										<label class="col-xs-2 control-label" >
											Site phone no&nbsp;:&nbsp;<span class="star">*</span>
										</label>
										<div class="col-xs-6">
												<div class="form-group">
													<input type="text" id="s_phone_no" class="form-control" name="s_phone_no" value="<?php echo get_symbol($s_phone_no);?>" maxlength="200"/>
												</div>
												<label class="error-message" id="err_s_phone_no"></label>
										</div>
									</div>
								<div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site Email&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                                <input type="text" id="s_email" class="form-control" name="s_email" value="<?php echo get_symbol($s_email);?>" maxlength="200"/>
                                        </div>
										<label class="error-message" id="err_s_email"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site Copyright&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                            <div class="form-group">
												<textarea id="s_copyright" class="form-control" name="s_copyright"><?php echo get_symbol($s_copy);?></textarea>  
                                            </div>
											<label class="error-message" id="err_s_copyright"></label>
                                    </div>
                                </div>  
                                
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">&nbsp;</label>
                                    <div class="col-xs-6">
                                        <div style="padding: 10px 0">
                                            <?php
                                                $action=($_REQUEST["action"]=="edit")?"edit_action":(($_REQUEST["action"]=="add")?"add_action":"none_action");
                                                $val=(!empty($res))?$res["web_id"]:"1";
                                                ?>
                                                <div class="form-group">
                                                    <input type="hidden" name="<?php echo $action;?>" value="<?php echo $val;?>"/>
                                                    <input type="submit" name="submit_action" value="Submit" class="btn btn-success" onclick="return validation()"/> &nbsp;<a class="btn bg-purple" href="<?php echo $current_page;?>">Back</a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            <?php

                            ?>
                            </div>
                        </form>
                            <?php
                            }
                            elseif($_REQUEST["action"]=="view"){
                            ?>
                            <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label" >
                                            Site phone no
                                        </label>
                                        <div class="col-xs-6">
                                                <div style="padding: 7px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_phone_no);?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
										<label class="col-xs-2 control-label" >
											Site Email
										</label>
										<div class="col-xs-6">
											 <div style="padding: 7px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_email);?>
                                                    </div>
                                                </div>
										</div>
									</div>
                                  <div class="form-group">
                                        <label class="col-xs-2 control-label" >
                                            Site Address
                                        </label>
                                        <div class="col-xs-6">
                                             <div style="padding: 5px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_address);?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label" >
                                            Site Copyright
                                        </label>
                                        <div class="col-xs-6">
                                                <div style="padding: 5px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_copy);?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label">&nbsp;</label>
                                        <div class="col-xs-6">
                                            <div style="padding: 10px 0">
                                                <?php
                                                    $action=($_REQUEST["action"]=="edit")?"edit_action":(($_REQUEST["action"]=="add")?"add_action":"none_action");
                                                    $val=(!empty($res))?$res["web_id"]:"1";
                                                    ?>
                                                    <a class="btn bg-purple" href="<?php echo $current_page;?>"><i class="fa  fa-chevron-left"></i> &nbsp;Back</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php

                                ?>
                                </div>
                            </form>
                                <?php
                            }
                            else{
                                goto no_action;
                            }
                        }
                        else{
                            no_action:
                            $no_action=true;
                            ?>
							 <div class="box-body">
                            <table id="manage_about" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align:center">S.No.</th>
                                    <th>Site phone no</th>
                                    <th>Site Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql="SELECT `web_id`, `site_phone_no`, `site_email` FROM $table_name";
                                $res=$db_cms->select_query_with_rows($sql);
                                if($res!=FALSE){
                                    $i=1;
                                    foreach ($res as $row){
                                        ?>
                                        <tr>
                                            <td width="100" align="center" style="vertical-align: middle"><?php echo $i;?></td>
                                            <td style="vertical-align: middle">
                                                <?php
                                                $get_text_1=get_symbol($row["site_phone_no"]);
                                                $get_text_1=strip_tags($get_text_1);
                                                $get_text_1=str_replace("<","&lt;",$get_text_1);
                                                $get_text_1=str_replace(">","&gt;",$get_text_1);
                                                echo substr($get_text_1,0,50);
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <?php
                                                $get_text_1=get_symbol($row["site_email"]);
                                                $get_text_1=strip_tags($get_text_1);
                                                $get_text_1=str_replace("<","&lt;",$get_text_1);
                                                $get_text_1=str_replace(">","&gt;",$get_text_1);
                                                echo substr($get_text_1,0,50);
                                                ?>
                                            </td>
                                            <td width="350" style="vertical-align: middle">
                                                <a class="btn btn-info" href="?action=view&web_id=<?php echo $row["web_id"];?>"><i class="fa fa-eye"></i> View</a>
                                                <a class="btn btn-success <?php echo ($is_edit_enabled)?"":"disabled";?>" href="<?php echo ($is_edit_enabled)?"?action=edit&web_id=".$row["web_id"]:"javascript:void(0);";?>"><i class="fa fa-edit"></i> Edit</a>
                                                <a class="btn display_none btn-danger <?php echo ($is_delete_enabled)?"delete_process":"disabled";?>" <?php echo ($is_delete_enabled)?'data-toggle="modal" data-target="#modal-default"':'';?> href="javascript:void(0);" <?php echo ($is_delete_enabled)?'data-delete-id="'.$row["web_id"].'"':'';?>><i class="fa fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
							</div>
                            <div class="modal fade delete_modal_box" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Do you really want to delete this?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            <a id="del_proceed" class="btn btn-primary" href="">Yes</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
/*  Space in above </body> tag
 *  Use javascript inline, external
 */
if($no_action==true){
    ?>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#manage_about').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : false
            });
            $(".delete_process").click(function(){
                $(".delete_modal_box").find("#del_proceed").attr("href","?action=delete&id="+$(this).data("delete-id"));
            });
        });
    </script>

    <?php
}
else
{
    ?>
    <script src="js/select2.full.min.js"></script>
    <script type="text/javascript" language="javascript1.2" src="ckeditor/ckeditor.js"></script>
    <script>
        function validation(){
            c_sel1=document.getElementById("s_phone_no").value;
            if(c_sel1===""){
                document.getElementById("err_s_phone_no").innerHTML = "Please enter site phone no";
                document.getElementById('s_phone_no').focus();
                return false;
            }
			else{
				document.getElementById("err_s_phone_no").innerHTML = "";
			}
            c_sel3=document.getElementById("s_email").value;
            if(c_sel3===""){
                document.getElementById("err_s_email").innerHTML = "Please enter email";
                document.getElementById('s_email').focus();
                return false;
            }
			else{
				document.getElementById("err_s_email").innerHTML = "";
			}
			 if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(c_sel3)))
            {
                document.getElementById("err_s_email").innerHTML = "Invalid email address";
                document.getElementById('s_email').focus();
                return false;
            } 
			else{
				document.getElementById("err_s_email").innerHTML = "";
			}
			c_sel4=document.getElementById("s_copyright").value; 
            if(c_sel4===""){
                document.getElementById("err_s_copyright").innerHTML = "Please enter site copyright";
                document.getElementById('s_copyright').focus();
                return false;
            }
			else{
				document.getElementById("err_s_copyright").innerHTML = "";
			}
			c_sel3=document.getElementById("s_address").value; 
            if(c_sel3===""){ 
                document.getElementById("err_s_address").innerHTML = "Please enter site address";
                document.getElementById('s_address').focus();
                return false;
            }
            
        }
        $('.pos_type').select2();
    </script>

    <?php
}
/*  Space in above </body> tag  */
include("include/footer.php");
?>