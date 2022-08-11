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
$sitetitle.=" | Banner Management";

//  manage settings + action---#
$is_add_enabled=true;
$is_edit_enabled=true;
$is_delete_enabled=false;

$table_name="`".DB_PREFIX."_banner`";
$current_page="home_banner.php";


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
		if($width<1600||$height<450)
		{ 
			$v = $_FILES['upload_file']['name'];
			$source = $_FILES['upload_file']['tmp_name'];
			$v = time().$v;
			$parts=explode(".",$v);
			$v=$parts[0].".png";
			$originalpath = "../webuploads/original/banner/".$v;
			$thumbnailpath = "../webuploads/thumb/banner/".$v;
			move_uploaded_file($source,$originalpath);
			include_once('../include/imgresize.php');
			resize($originalpath, $thumbnailpath, 1600, 450);
		}
		else
		{ 
			include('../include/resize.php');
			$v = $_FILES['upload_file']['name'];
			$source = $_FILES['upload_file']['tmp_name'];
			$v = time().$v;
			$originalpath = "../webuploads/original/banner/".$v;
			$thumbnailpath = "../webuploads/thumb/banner/".$v;
			move_uploaded_file($source,$originalpath);
			$objimg = new SimpleImage();
			$objimg -> load($originalpath);
			$objimg -> resize(1600,450);
			$objimg -> save($thumbnailpath);
		}
	}
		}
}
else { 
	$v = get_entity($_REQUEST['theValue']); 
} 
if(!empty($_POST["submit_action"]) && (!empty($_POST["edit_action"]) || !empty($_POST["add_action"]))){   
	$banner_page = "home";
	$banner_content = $db_cms->removeQuote($_POST["banner_content"]);
	if(!empty($_POST["edit_action"])){
		$sql="UPDATE $table_name SET `banner_image`='".$v."',`modified_date`='".$datetime."' WHERE `web_id`='".$db_cms->removeQuote($_POST["edit_action"])."'";
	}
	else{
		$sql="INSERT INTO $table_name(`banner_image`,`created_date`) VALUES ('".$v."','".$datetime."')";
	}
	$res = $db_cms->update_query($sql);   // <-  normal query function this
	 //echo $sql;  exit;
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

// -------------------#

include("include/header.php"); 
?>

<?php
include("include/sidebar.php");
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Banner Management
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Banner Management</li>
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
                                <h3 class="box-title"><?php echo ucfirst($_REQUEST["action"]);?> Banner Management</h3>
                                
                                <?php
                            }
                            else{
                                ?>
                               <div class="pull-right">
                                    <a class="btn bg-maroon <?php echo ($is_add_enabled)?"":"disabled";?>" href="<?php echo ($is_add_enabled)?"?action=add":"javascript:void(0);";?>"><i class="fa  fa-plus"></i> &nbsp;Add</a>
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
                        if(!empty($_REQUEST["action"])){
                            $c_id="";
                            $img_path="";
                            if(($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="view") && !empty($_REQUEST["web_id"])){
                                $sql="SELECT * FROM $table_name WHERE web_id='".$db_cms->removeQuote($_REQUEST["web_id"])."'";
                                $res=$db_cms->select_query_with_row($sql);
                                $c_id=$res["web_id"];
                                $img_path=$res["banner_image"];
                                $banner_content=$res["banner_content"];
                            }
                            if($_REQUEST["action"]=="edit" || $_REQUEST["action"]=="add"){
                                ?>
                        <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Banner Image<span class="star">*</span>:</label>
                                    <div class="col-sm-6">
                                        <?php if($_REQUEST["action"]!="add"){  ?>
                                            <div>
                                                <img src="../include/image.php?width=500&amp;height=190&amp;cropratio=125:47&amp;image=<?php echo $sitepath;?>webuploads/thumb/banner/<?php echo $img_path;?>" alt="Image" style="width:500px;"/>
                                            </div>
                                            <br/>
                                        <?php  }  ?>
                                        <div class="form-group">
                                            <input type="file" id="upload_file" name="upload_file" accept=".jpeg, .jpg, .png, .gif"   onchange="return test();"/>
                                            <p class="help-block">(Required Image Size (Width*Height): 1600*450. Upload .jpg, .jpeg, .gif, .png)</p>
											<input type="hidden" value="<?=$img_path?>" id="theValue" name="theValue" />
                                        </div>
										<label class="error-message" id="err_image"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-6">
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
                        </form>
                                <?php
                            }
                            elseif($_REQUEST["action"]=="view"){
                                ?>
                        <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Banner Image</label>
                                    <div class="col-sm-6">
                                            <div>
                                                <img src="../include/image.php?width=500&amp;height=190&amp;cropratio=125:47&amp;image=<?php echo $sitepath;?>webuploads/thumb/banner/<?php echo $img_path;?>" alt="Image" style="width:500px;"/>
                                            </div>
                                            <br/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">&nbsp;</label>
                                    <div class="col-sm-6">
                                            <a class="btn bg-purple" href="<?php echo $current_page;?>"><i class="fa  fa-chevron-left"></i> &nbsp;Back</a>
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
                        else {
                            no_action:
                            $no_action = true;
                            ?>
							<div class="box-body">
                            <table id="manage_banner" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align:center">S.No.</th>
                                    <th style="text-align:center">Banner Image</th>
                                    <th>Action</th>
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
                                            <td align="center" width="100" style="vertical-align: middle"><?php echo $i;?></td>
                                            <td align="center">
                                                <img src="../include/image.php?width=250&amp;height=95&amp;cropratio=125:47&amp;image=<?php echo $sitepath;?>webuploads/thumb/banner/<?php echo $row["banner_image"];?>" alt="Image" style="width:150px;"/>
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
            $('#manage_banner').DataTable();
            $(".delete_process").click(function(){
                $(".delete_modal_box").find("#del_proceed").attr("href","?action=delete&id="+$(this).data("delete-id"));
            });
        }); 
		function confirmDelete(){	
			answer = confirm("Do you want to delete this item?");
			if (answer ==0) 
			{ 
				return false;
			} 	
		} 
        function validation(){
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
		}
		function test()
		{	
			document.getElementById('theValue').value=$('input[id=upload_file]').val().replace(/C:\\fakepath\\/i, ''); 
			return true;
		}
		
    </script>
<?php 
include("include/footer.php");
?>