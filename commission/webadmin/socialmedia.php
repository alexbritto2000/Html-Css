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
$sitetitle.=" | Site Accounts";

//  manage settings + action---#
$is_add_enabled=true;
$is_edit_enabled=true;
$is_delete_enabled=true;

$table_name="`".DB_PREFIX."_social_media`";
$current_page="socialmedia.php";


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
    if(!empty($_POST["s_facebook"]) && !empty($_POST["s_twitter"]) && !empty($_POST["s_googleplus"]) && !empty($_POST["s_instagram"])){
        if(!empty($_POST["edit_action"])){
            $sql="UPDATE $table_name SET `site_facebook`='".$db_cms->removeQuote(get_entity($_POST["s_facebook"]))."', `site_twitter`='".$db_cms->removeQuote(get_entity($_POST["s_twitter"]))."', `site_googleplus`='".$db_cms->removeQuote(get_entity($_POST["s_googleplus"]))."',`site_instagram`='".$db_cms->removeQuote(get_entity($_POST["s_instagram"]))."' WHERE `web_id`='".$db_cms->removeQuote($_POST["edit_action"])."'";
        }
        else{
            $sql="INSERT INTO $table_name(`site_facebook`,  `site_twitter`, `site_googleplus`,`site_instagram`) VALUES ('".$db_cms->removeQuote(get_entity($_POST["s_facebook"]))."','".$db_cms->removeQuote(get_entity($_POST["s_twitter"]))."','".$db_cms->removeQuote(get_entity($_POST["s_googleplus"]))."','".$db_cms->removeQuote(get_entity($_POST["s_instagram"]))."',$datetime)";
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
                Site socialmedia
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li> 
                <li class="active">Socialmedia</li>
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
                                <h3 class="box-title"><?php echo ucfirst($_REQUEST["action"]);?> Socialmedia</h3>
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
                            $s_facebook="";
                            $s_twitter=""; 
                            $s_googleplus="";
                            $s_instagram="";
                            // $site_country="";
                            if(($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="view") && !empty($_REQUEST["web_id"])){
								$sql="SELECT * FROM $table_name WHERE web_id='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
                                $res=$db_cms->select_query_with_row($sql);
                                $c_id=$res["web_id"];
                                $s_facebook=$res["site_facebook"];
                                $s_twitter=$res["site_twitter"]; 
                                $s_googleplus=$res["site_googleplus"];
                                $s_instagram=$res["site_instagram"];
                                // $site_country=$res["site_country"];
                            }
                            if($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="add"){
                        ?>
                        <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site facebook&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                            <div class="form-group">
                                                <textarea id="s_facebook" class="form-control" name="s_facebook"><?php echo get_symbol($s_facebook);?></textarea>  
                                            </div>
											<label class="error-message" id="err_s_facebook"></label>
                                    </div>
                                </div>
									<div class="form-group">
										<label class="col-xs-2 control-label" >
											Site twitter&nbsp;:&nbsp;<span class="star">*</span>
										</label>
										<div class="col-xs-6">
												<div class="form-group">
													<input type="text" id="s_twitter" class="form-control" name="s_twitter" value="<?php echo get_symbol($s_twitter);?>" maxlength="200"/>
												</div>
												<label class="error-message" id="err_s_twitter"></label>
										</div>
									</div>
								<div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site googleplus&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                                <input type="text" id="s_googleplus" class="form-control" name="s_googleplus" value="<?php echo get_symbol($s_googleplus);?>" maxlength="200"/>
                                        </div>
										<label class="error-message" id="err_s_googleplus"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" >
                                        Site instagram&nbsp;:&nbsp;<span class="star">*</span>
                                    </label>
                                    <div class="col-xs-6">
                                            <div class="form-group">
												<textarea id="s_instagram" class="form-control" name="s_instagram"><?php echo get_symbol($s_instagram);?></textarea>  
                                            </div>
											<label class="error-message" id="err_s_instagram"></label>
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
                                            Site facebook
                                        </label>
                                        <div class="col-xs-6">
                                                <div style="padding: 7px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_facebook);?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
										<label class="col-xs-2 control-label" >
											Site twitter
										</label>
										<div class="col-xs-6">
											 <div style="padding: 7px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_twitter);?>
                                                    </div>
                                                </div>
										</div>
									</div>
                                  <div class="form-group">
                                        <label class="col-xs-2 control-label" >
                                            Site googleplus
                                        </label>
                                        <div class="col-xs-6">
                                             <div style="padding: 5px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_googleplus);?>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label" >
                                            Site instagram
                                        </label>
                                        <div class="col-xs-6">
                                                <div style="padding: 5px 0;">
                                                    <div>
                                                        <?php echo get_symbol($s_instagram);?>
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
                                    <th>Site facebook</th>
                                    <th>Site twitter</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql="SELECT `web_id`, `site_facebook`, `site_twitter` FROM $table_name";
                                $res=$db_cms->select_query_with_rows($sql);
                                if($res!=FALSE){
                                    $i=1;
                                    foreach ($res as $row){
                                        ?>
                                        <tr>
                                            <td width="100" align="center" style="vertical-align: middle"><?php echo $i;?></td>
                                            <td style="vertical-align: middle">
                                                <?php
                                                $get_text_1=get_symbol($row["site_facebook"]);
                                                $get_text_1=strip_tags($get_text_1);
                                                $get_text_1=str_replace("<","&lt;",$get_text_1);
                                                $get_text_1=str_replace(">","&gt;",$get_text_1);
                                                echo substr($get_text_1,0,50);
                                                ?>
                                            </td>
                                            <td style="vertical-align: middle">
                                                <?php
                                                $get_text_1=get_symbol($row["site_twitter"]);
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
            c_sel1=document.getElementById("s_facebook").value;
            if(c_sel1===""){
                document.getElementById("err_s_facebook").innerHTML = "Please enter site facebook acc";
                document.getElementById('s_facebook').focus();
                return false;
            }
			else{
				document.getElementById("err_s_facebook").innerHTML = "";
			}
            c_sel3=document.getElementById("s_twitter").value;
            if(c_sel3===""){
                document.getElementById("err_s_twitter").innerHTML = "Please enter twitter acc";
                document.getElementById('s_twitter').focus();
                return false;
            }
			c_sel4=document.getElementById("s_googleplus").value; 
            if(c_sel4===""){
                document.getElementById("err_s_googleplus").innerHTML = "Please enter site googleplus acc";
                document.getElementById('s_googleplus').focus();
                return false;
            }
			else{
				document.getElementById("err_s_googleplus").innerHTML = "";
			}
			c_sel3=document.getElementById("s_instagram").value; 
            if(c_sel3===""){ 
                document.getElementById("err_s_instagram").innerHTML = "Please enter site insta acc";
                document.getElementById('s_instagram').focus();
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