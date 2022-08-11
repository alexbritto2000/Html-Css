<?php 
ob_start();
session_start();
include("../lib/config.php"); 

if(empty($_SESSION['mozcon_id']) && empty($_SESSION['username'])){
    $_SESSION["cms_status"]="error";
    $_SESSION["cms_msg"]="Please login now!";
    header('Location:login.php');
    exit();
} 
$sitetitle.=" |  Home Services";

//  manage settings + action---#
$is_add_enabled=true;
$is_edit_enabled=true;
$is_delete_enabled=true;

$table_name="`".DB_PREFIX."_home_services`";
$current_page="home_services.php";


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
            $sql="DELETE FROM $table_name WHERE `web_id`='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
            $res=$db_cms->delete_query($sql);
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
 if(!empty($_FILES["upload_file"]) && $_FILES["upload_file"]["error"]!=4) {
        if (validate_image($_FILES["upload_file"])) {
            if ($_FILES['upload_file']['name'] != "") {
                list($width,$height) = getimagesize($_FILES['upload_file']['tmp_name']);
                if($width<635||$height<415)
                { 
                    $v = $_FILES['upload_file']['name'];
                    $source = $_FILES['upload_file']['tmp_name'];
                    $v = time().$v;
                    $parts=explode(".",$v);
                    $v=$parts[0].".png";
                    $originalpath = "../webupload/original/home_services/".$v;
                    $thumbnailpath = "../webupload/thumb/home_services/".$v; 
                    move_uploaded_file($source,$originalpath);
                    include_once('../include/imgresize.php');
                    resize($originalpath, $thumbnailpath, 635, 415); 
                }
                else
                { 
                    include('../include/resize.php');
                    $v = $_FILES['upload_file']['name'];
                    $source = $_FILES['upload_file']['tmp_name'];
                    $v = time().$v;
                    $originalpath = "../webupload/original/home_services/".$v;
                    $thumbnailpath = "../webupload/thumb/home_services/".$v; 
                    move_uploaded_file($source,$originalpath);
                    $objimg = new SimpleImage();
                    $objimg -> load($originalpath);
                    $objimg -> resize(635,415);
                    $objimg -> save($thumbnailpath);
                    $objimg -> resize(635, 415);
                    $objimg -> save($iconimage);
                }
			}
		}
 }
else { 
	$v = get_entity($_REQUEST['theValue']); 
}  

if(!empty($_POST["submit_action"]) && (!empty($_POST["edit_action"]) || !empty($_POST["add_action"]))){  
			if(!empty($_POST["content_title"]) && !empty($_POST["content_description"])){
				$content_page = "services";
                if(!empty($_POST["edit_action"])){
                    $sql="UPDATE $table_name SET `content_title`='".$db_cms->removeQuote(get_entity($_POST["content_title"]))."',`content_description`='".$db_cms->removeQuote(get_symbol($_POST["content_description"]))."',`content_image`='".$v."',`modified_date`='".$datetime."' WHERE `web_id`='".$db_cms->removeQuote($_POST["edit_action"])."'";
                }
                else{
                    $sql="INSERT INTO $table_name (`content_title`,`content_description`, `content_image`,`created_date`) VALUES ('".$db_cms->removeQuote(get_entity($_POST["content_title"]))."','".$db_cms->removeQuote(get_symbol($_POST["content_description"]))."','".$v ."','".$datetime."')";
                }
                $res = $db_cms->update_query($sql);   // <-  normal query function this
				//echo  $sql;  exit;
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
include("include/sidebar.php");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Home Services Management
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"> Home Services </li>
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
                                <h3 class="box-title"><?php echo ucfirst($_REQUEST["action"]);?> Home Services </h3>
                                <?php
                            }
                            else{
                                ?>
                                <!--<div class="pull-right">
                                    <a class="btn bg-maroon <?php echo ($is_add_enabled)?"":"disabled";?>" href="<?php echo ($is_add_enabled)?"?action=add":"javascript:void(0);";?>"><i class="fa  fa-plus"></i> &nbsp;Add</a>
                                </div>-->
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
                        if(!empty($_REQUEST["action"])){
                            $no_action=false;
                            $c_id="";
                            $c_text="";
                            $c_type="";
                            $c_title="";
                            if(($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="view") && !empty($_REQUEST["web_id"])){
                                $sql="SELECT * FROM $table_name WHERE web_id='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
                                $res=$db_cms->select_query_with_row($sql);
                                $c_id=$res["web_id"];
                                $c_text=$res["content_description"];  
                                $c_name=$res["content_title"];
                                $img_path=$res["content_image"];
                            }
                            if($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="add"){
                                ?>
                                <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body"> 
                                    <div class="form-group">
                                        <label class="control-label col-xs-2">Title&nbsp;:&nbsp;<span class="star">*</span></label>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <input type="text" name="content_title" id="content_title" class="form-control" value="<?php echo $c_name;?>"/>
                                            </div>
											<label class="error-message" id="err_title"></label>
                                        </div>
                                    </div> 
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Description&nbsp;:&nbsp;<span class="star">*</span></label>
                                    <div class="col-xs-6">
                                            <div class="form-group">
                                                <textarea id="content_description" name="content_description"><?php echo get_symbol($c_text);?></textarea>
                                            </div>
											<label class="error-message" id="err_description"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Image&nbsp;:&nbsp;<span class="star">*</span></label>
                                    <div class="col-xs-6">
                                             <?php if($_REQUEST["action"]!="add"){  ?>
                                            <div>
                                                <img src="../include/image.php?width=200&amp;height=200&amp;image=<?php echo $sitepath;?>webupload/thumb/home_services/<?php echo $img_path;?>" alt="Image"/>
                                            </div>
                                            <br/>
                                        <?php  }  ?>
                                        <div class="form-group">
                                            <input type="file" id="upload_file" name="upload_file" accept=".jpeg, .jpg, .png, .gif"   onchange="return test();"/>
                                            <p class="help-block">(Required Image Size (Width*Height): 600*350. Upload .jpg, .jpeg, .gif, .png)</p>
											<input type="hidden" value="<?=$img_path?>" id="theValue" name="theValue" />
										</div>
										<label class="error-message" id="err_image"></label>
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
                                    </div>
                                </form>
                                <?php
                            }
                            elseif($_REQUEST["action"]=="view"){
                                ?>
                                <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body"> 

                                    <div class="form-group">
                                        <label class="control-label col-xs-2">Title</label>
                                        <div class="col-xs-6">
                                            <div style="padding: 7px 0">
                                                <?php
                                                echo $c_name;
                                                ?>
                                            </div>
                                        </div>
                                    </div> 
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Description</label>
                                    <div class="col-xs-6">
                                        <div style="padding: 7px 0">
                                            <?php echo get_symbol($c_text);?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">Image</label>
                                    <div class="col-xs-6">
                                        <div style="padding: 7px 0">
                                           <img src="<?=$sitepath?>webupload/thumb/home_services/<?=$img_path;?>" border="0" class="imgborder" id="web_image" style="vertical-align:top;" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label">&nbsp;</label>
                                    <div class="col-xs-6">
                                        <div style="padding: 10px 0">
                                                <a class="btn bg-purple" href="<?php echo $current_page;?>"><i class="fa  fa-chevron-left"></i> &nbsp;Back</a>
                                        </div>
                                    </div>
                                </div>
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
                                    <th style="text-align:center">Name</th> 
                                    <th style="text-align:center">Description</th>
                                    <th class="action">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql="SELECT * FROM $table_name";
                                $res=$db_cms->select_query_with_rows($sql);
                                if($res!=FALSE){
                                    $i=1;
                                    foreach ($res as $row){
                                        ?>
                                        <tr>
                                            <td width="100" align="center" style="vertical-align: middle"><?php echo $i;?></td>
                                            <td align="center" style="vertical-align: middle">
                                                <?php
                                                echo $row["content_title"];
                                                ?>
                                            </td> 
											<td><?=mb_substr(strip_tags(html_entity_decode(stripslashes(get_symbol($row['content_description'])), ENT_QUOTES, 'UTF-8')), 0,50) .'...';?></td>
                                            </td>
                                            <td width="350" style="vertical-align: middle">
                                                <a class="btn btn-info" href="?action=view&web_id=<?php echo $row["web_id"];?>"><i class="fa fa-eye"></i> View</a>
                                                <a class="btn btn-success <?php echo ($is_edit_enabled)?"":"disabled";?>" href="<?php echo ($is_edit_enabled)?"?action=edit&web_id=".$row["web_id"]:"javascript:void(0);";?>"><i class="fa fa-edit"></i> Edit</a>
												 <!--<a class="btn display_none btn-danger <?php echo ($is_delete_enabled)?"delete_process":"disabled";?>" <?php echo ($is_delete_enabled)?'data-toggle="modal" data-target="#modal-default"':'';?> href="javascript:void(0);" <?php echo ($is_delete_enabled)?'data-delete-id="'.$row["web_id"].'"':'';?>><i class="fa fa-trash"></i> Delete</a>
												 <a class="btn btn-danger" href="?action=delete&web_id=<?=$row['web_id']?>"  onClick="return confirmDelete();"  title="Delete"><i class="fa fa-trash"></i> Delete</a>-->
												 
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                                </tbody>
                            </table>

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
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#manage_about').DataTable();
            $(".delete_process").click(function(){
                $(".delete_modal_box").find("#del_proceed").attr("href","?action=delete&id="+$(this).data("delete-id"));
            });
        });
    </script>
    <script src="js/select2.full.min.js"></script>
    <script type="text/javascript" language="javascript1.2" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        var ckedit=CKEDITOR.replace("content_description",
            {
                height:"125", width:"665",
                filebrowserBrowseUrl : 'ckeditor/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Images',
                filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Flash',
                filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
    </script>
    <script>
        function validation(){  
            c_text=document.getElementById("content_title").value;
            if(c_text===""){
               document.getElementById("err_title").innerHTML = "Please enter title";
                document.getElementById('content_title').focus();
                return false;
            } 
			else{
				document.getElementById("err_title").innerHTML = "";
			}
            c_text1 = CKEDITOR.instances['content_description'].getData().replace(/<[^>]*>/gi, '');
            if(c_text1==="")
            {
                document.getElementById("err_description").innerHTML = "Please enter description";
                document.getElementById('content_description').focus();
                return false;
            }
			else{
				document.getElementById("err_description").innerHTML = "";
			}
			var file = document.getElementById('theValue').value;  
			var FileExt = file.substr(file.lastIndexOf('.')+1); 
			if(file == "")
			{
				document.getElementById("err_image").innerHTML = "Please upload the image";
				document.getElementById('theValue').focus();
				return false;
			}
			else if(FileExt == "gif" || FileExt == "GIF" || FileExt == "JPEG" || FileExt == "jpeg" || FileExt == "jpg" || FileExt == "JPG" || FileExt == "png")
			{
				return true;
			} 
			else
			{
				document.getElementById("err_image").innerHTML = "Upload Gif or Jpg or png images only"; 
				document.getElementById('theValue').focus();
				return false;
			}	  
            return true;
        } 
		function test()
		{	
			document.getElementById('theValue').value=$('input[id=upload_file]').val().replace(/C:\\fakepath\\/i, ''); 
			return true;
		}
		function confirmDelete(){	
			answer = confirm("Do you want to delete this item?");
			if (answer ==0) 
			{ 
				return false;
			} 	
		}
    </script>

    <?php
include("include/footer.php");
?>