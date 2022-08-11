<?php
class DBManager{
    private $conn;
    function __construct(){
        $this->conn=new MySQLi;
    }
    function __destruct(){
        if(!$this->conn->connect_error){
            $this->conn->close();
        }
    }

    function connect($host,$uname,$upass,$dbname){
        @$this->conn->connect($host,$uname,$upass,$dbname);
        if($this->conn->connect_errno){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    function mysqli_error(){
        return $this->conn->error;
    }

    function select_db($new_dbname){
        @$this->conn->select_db($new_dbname);
        if($this->conn->error){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }


    function select_query($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows>0){
            if(method_exists($this->conn,"fetch_all")){
                $values = $res->fetch_all(MYSQLI_ASSOC);
                return $values;
            }
            else{
                $rows=array();
                while($row=$res->fetch_assoc()){
                    $rows[]=$row;
                }
                return $rows;
            }
        }
        else{
            return FALSE;

        }
    }

    function select_query_with_row($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows==1){
            $values = $res->fetch_assoc();
            return $values;
        }
        else{
            return FALSE;

        }
    }

    function select_query_with_rows($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows>0){
            $rows=array();
            while($row=$res->fetch_assoc()){
                $rows[]=$row;
            }
            return $rows;
        }
        else{
            return FALSE;

        }
    }

    function select_query_with_no_rows($sql){
        $res=$this->conn->query($sql);
        if($res->num_rows>0){
            return $res->num_rows;
        }
        else{
            return FALSE;
        }
    }

    function multi_query($sql){
        $res=$this->conn->multi_query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function free_multi_query_result(){
        do {
            if ($result = $this->conn->store_result()) {
                while ($row = $result->fetch_row()) {
                }
                $result->free();
            }
            if ($this->conn->more_results()) {
            }
        } while ($this->conn->next_result());
    }



    function insert_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function update_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function delete_query($sql){
        $res=$this->conn->query($sql);
        if($res){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function removeQuote($input){
        $input=str_replace('"','\"',$input);
        $input=str_replace("'","\'",$input);
        return $input;
    }

    function count_query($sql){
        $res=$this->conn->query($sql);
        $values=$res->num_rows;
        return $values;

    }

    function insert_query_last($sql){

        $res=$this->conn->query($sql);
        if($res){
            $test=$this->conn->insert_id;
            return $test;
        }
        else{
            return FALSE;
        }
    }

    function sort_query($table, $posid, $web_id)
    {
        $posid=$posid;
        $trackid=$web_id;
        $s="select * from $table order by web_id asc";
        $r=$this->conn->query($s);
        if(method_exists($this->conn,"fetch_all")){
            $fetchrow=$r->fetch_all(MYSQLI_ASSOC);
        }
        else{
            $fetchrow=array();
            while($r1=$r->fetch_assoc()){
                $fetchrow[]=$r1;
            }
        }

        foreach($fetchrow as $fetchrow)
        {
            $tid=$fetchrow['web_id'];

            if($trackid==$tid)
            {
                $oldsortid=$fetchrow['web_display_order'];
                $oldid=$fetchrow['web_id'];

                $r2="select * from $table where web_display_order='$posid' order by web_display_order asc";
                $fetchrow2c=$this->conn->query($r2);
                if(method_exists($this->conn,"fetch_all")){
                    $fetchrow2=$fetchrow2c->fetch_all(MYSQLI_ASSOC);
                }
                else{
                    $fetchrow2=array();
                    while($fetchrow2c2=$fetchrow2c->fetch_assoc()){
                        $fetchrow2[]=$fetchrow2c2;
                    }
                }

                $newpos=$fetchrow2[0]['web_display_order'];
                $newid=$fetchrow2[0]['web_id'];

                $upquery=$this->conn->query("update $table set web_display_order='$oldsortid' where web_id='$newid' ");
                $upquery1=$this->conn->query("update $table set web_display_order='$newpos' where web_id='$trackid' ");
                return true;
            }
        }
    }

    //  User Login - Home 
    function UserLogin($user,$pass,$acctype){
		$enc_pass = md5($pass);
        $sql="SELECT * FROM `".DB_PREFIX."_users` WHERE `web_useremail`='".$this->removeQuote($user)."' AND `web_encrypt_pass`='".$this->removeQuote($enc_pass)."' and active_status = 1 and login_status = 1 and web_user_role ='".$this->removeQuote($acctype)."'" ;
        $res=$this->conn->query($sql);
       
        if($res->num_rows==1){
            $row=$res->fetch_assoc();
            $_SESSION['user_id']=$row['web_id'];
            $_SESSION['web_username']=$row['web_username'];
            $_SESSION['user_type']=$row['web_user_role'];
            return TRUE;
        }
        else{
			$sql1="SELECT * FROM `".DB_PREFIX."_users` WHERE `web_useremail`='".$this->removeQuote($user)."' AND `web_encrypt_pass`='".$this->removeQuote($enc_pass)."'and web_user_role ='".$this->removeQuote($acctype)."' ";
			$result=$this->conn->query($sql1);
			if($result->num_rows == 0){

				return FALSE;
			}
			else{ 
                
				$rows=$result->fetch_assoc();
				$active_status = $rows['active_status'];
				$login_status = $rows['login_status'];
				if($active_status != 1 && $login_status != 1){
					return "inactive";
				}
				else{
					return FALSE;
				}
			}
        }
    }


function loginsession($user_id){
    // print_r($user_id);
    // print_r($web_user_role);
    $sql="SELECT `web_user_role` FROM `".DB_PREFIX."_users` WHERE `web_id`='".$this->removeQuote($user_id)."'" ;
     $res=$this->conn->query($sql);
     // print_r($res->num_rows);
     $rows=$res->fetch_assoc();
     // print_r( $rows);
            if($rows['web_user_role']== 1){

                return "user";
            }else{
                return "distributor";
            }
     // print_r($res);
     // exit;
}
	// Admin Login
    function WebAdminLogin($user,$pass){
        $sql="SELECT * FROM `".DB_PREFIX."_admin` WHERE (`username`='".$user."' AND `password`='".$pass."')";
        $res=$this->conn->query($sql);
        if($res->num_rows==1){
            $row=$res->fetch_assoc();  
            $_SESSION['commission_id']=$row['web_id'];
            $_SESSION['username']=$row['username']; 
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
	
	function chkAuth($user,$pass){
        $sql="SELECT * FROM `".DB_PREFIX."_admin` WHERE (`username`='".$user."' AND `password`='".$pass."')";
        $res=$this->conn->query($sql);
        if($res->num_rows==1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function XML2Array(SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
                && (1 === count($node) ? $node = array($node) : 1)
                && $node = & $node[];

            $node = $element->count() ? XML2Array($element) : trim($element);
        }

        return $array;
    }

    ///splitvalues///

        function split_values($resp){ 
        $text_val =array_filter(explode(',', $resp));
        $commaList = implode(',', $text_val);
        $text1 =explode(',',$commaList);
		// echo ("<pre>");
  //        print_r($text1);
  //        echo ("</pre>"); 
        // $tid=substr($text1[25],1,15);
        $tid=$text1[6];
         // print_r($tid);

		  // exit;
        return $tid; 
        }
	
    function site_email(){
        $sql="SELECT * FROM `".DB_PREFIX."_site_settings` WHERE web_id='1'";
        $res=$this->conn->query($sql);
        $row=$res->fetch_assoc();
        return $row['site_email'];
    }

    function email_header(){
        $header_content="<html lang='en-US'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<title>Weedzbio</title>
</head>
<body leftmargin='0' marginwidth='0' topmargin='0' marginheight='0' offset='0'>
	<div id='wrapper' dir='ltr' style='background-color: #f7f7f7; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;'>
	<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:100%'><tr>
	<td align='center' valign='top'> 
		<table border='0' cellpadding='0' cellspacing='0' width='600' id='template_container' style='  width: 100%;'>
			<tr>
					<td align='center' valign='top' >
					<!-- Header -->
						<table border='0' cellpadding='0' cellspacing='0' width='600' id='template_header' style='background-color: #d0d6cf;padding: 10px;    width: 80%;'>
							<tr>
								<td id='header_wrapper' style='text-align: center;    height: 115px;'>
									<img src='http://www.zerosofttech.com/dev/weedzbio/images/headerlogo.png' alt='Weedzbio Logo' border='0'>
								</td>
							</tr>
						</table>
					<!-- End Header -->
					</td>
			</tr>";
        return $header_content;
    }

    function email_footer(){

        $footer_content = "<tr>
					<td align='center' valign='top' style='color:#fff;'>
					
						<table border='0' cellpadding='0' cellspacing='0' width='600' id='template_header' style='background-color: #d0d6cf;padding: 40px;font-size: 17px; width: 80%; text-align: center;'>
							<tr>
								<td id='header_wrappers'  style='text-align: center;  color: #3f7738;  font-weight: bold;'>
									 Copyright &copy; 2019 Weedzbio. All rights reserved.
								</td>
							</tr>
						</table>
					<!-- End footer -->
					</td>
			</tr>
			</table>
	</td>
	</table>
	</div>
</body>
</html>";
        return $footer_content;

    }

    function sendphpmail($to_emailid,$bodytext,$subject){
        $site_email = $this->site_email();
		$message = $this->email_header();
        $message .= $bodytext;
		$message .= $this->email_footer();

        $headers = "From: ".$site_email."\r\n"."X-Mailer: PHP/" . phpversion();
        $headers .= "Reply-To: ".$site_email."\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        // $headers .= "Bcc: jebachristy.zerosoft@hotmail.com";

        if(mail($to_emailid,$subject,$message,$headers)){
		return true;
		} else{
			return false;
		}
    }


}

function http_ref_chk($sitepath)
{
$HTTP_REFERER= $_SERVER["HTTP_REFERER"];
if($HTTP_REFERER != NULL)
{
$result = strstr($HTTP_REFERER,$sitepath); 
if ($result == false) {
header('Location:index.php');exit();	
}
}
else{
header('Location:index.php');exit();
}
}

$searchReplaceArray = array(
    '$' => '%24',
    '&' => '%26',
    '+'=>'%2B',
    ','=>'%2C',
    '/'=>'%2F',
    ':'=>'%3A',
    ';'=>'%3B',
    '='=>'%3D',
    '?'=>'%3F',
    "\'"=>'%27',
    "'"=>'%27',
    '"'=>'%93',
    '‘'=>'%91',
    '”'=>'%94',
    '’'=>'%92',
    '<'=>'%3C',
    '>'=>'%3E'
);

$ReplaceArray = array(
    '%24' => '$',
    '%26' => '&',
    '%2B'=>'+',
    '%2C'=>',',
    '%2F'=>'/',
    '%3A'=>':',
    '%3B'=>';',
    '%3D'=>'=',
    '%3F'=>'?',
    '%27'=>"\'",
    '%27'=>"'",
    '%93'=>'"',
    '%91'=>'‘',
    '%94'=>'”',
    '%92'=>'’',
    '%3C'=>'<',
    '%3E'=>'>'
);

function get_symbol($symbol)
{
    global $ReplaceArray; global $searchReplaceArray;
    return $rslt=str_replace(array_keys($ReplaceArray),array_values($ReplaceArray),$symbol);
}

function get_entity($symbol)
{
    global $ReplaceArray; global $searchReplaceArray;
    return $rslt=str_replace(array_keys($searchReplaceArray),array_values($searchReplaceArray),$symbol);
}

function validate_image($upload){ 
	$array_image=array("image/jpeg","image/jpg","image/png","image/gif");
	$array_img_ext=array(".jpeg",".jpg",".png",".gif");
	$finfo = new finfo(FILEINFO_MIME_TYPE);
	$original_extension = (false === $pos = strrpos($upload["name"], '.')) ? '' : strtolower(substr($upload["name"], $pos));
	$type = $finfo->file($upload["tmp_name"]);

	if (in_array($type, $array_image) && in_array($original_extension, $array_img_ext))
	{
		return true;
	}
	else{
		return false;
	}
}


?>