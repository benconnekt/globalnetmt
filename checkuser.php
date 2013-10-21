<?php
 session_start();
  error_reporting(1);
$server= "localhost";
$user= "root";          /* FTP-username */
$password= "";         /* FTP-Password */
$database= "db475954680";         /* name of database *

  /* Business Server Info */
  /* Business Server Info */
//$server= "db475954680.db.1and1.com";
//$user= "dbo475954680";          /* FTP-username */
//$password= "syaHHVKp";         /* FTP-Password */
//$database= "db475954680";         /* name of database */

MYSQL_CONNECT($server, $user, $password) or die ( "<H3>Server unreachable</H3>");
MYSQL_SELECT_DB($database) or die ( "<H3>Database non existent</H3>");
// Effectively turn off dangerous register_globals without having to edit php.ini
if($_POST['payingagent']=='Y')
{
	$FF_valUsername=$_POST['username'];
  $FF_fldUserAuthorization="";
  $FF_rsUser_Source="SELECT username,a.userid as userid ";
  if ($FF_fldUserAuthorization != "") $FF_rsUser_Source .= "," . $FF_fldUserAuthorization;
  $FF_rsUser_Source .= " FROM user_master a,payingagent_master b where a.useroffice = b.agentid and a.username='" . $FF_valUsername . "' AND a.password='" . $_POST['password2'] . "' and a.status='Active' and a.is_payingagent='Y'";
//echo $FF_rsUser_Source;
}
else
{
  $FF_valUsername=$_POST['username'];
  $FF_fldUserAuthorization="";
  $FF_rsUser_Source="SELECT username,a.userid as userid ";
  if ($FF_fldUserAuthorization != "") $FF_rsUser_Source .= "," . $FF_fldUserAuthorization;
  $FF_rsUser_Source .= " FROM user_master a,agent_master b where a.useroffice = b.agentid and b.agentstatus='Active' and a.username='" . $FF_valUsername . "' AND a.password='" . $_POST['password2'] . "' and a.status='Active' and a.is_payingagent!='Y'";
//echo $FF_rsUser_Source;
}

if (isset($_POST['username']))
{
require_once('inc_functions.php');
require_once('inc_contactsfunctions.php');
  $FF_rsUser=mysql_query($FF_rsUser_Source) or die(mysql_error());
  $row_FF_rsUser = mysql_fetch_assoc($FF_rsUser);
 if(mysql_num_rows($FF_rsUser) > 0)
    {
		$userid = $row_FF_rsUser['userid'];
		$username = $row_FF_rsUser['username'];
 
   $logintime = date("y/m/d H:i:s", UKdst_datetime());
  $session_id = substr(md5(uniqid(rand(),1)),3,30);
  $_SESSION['session_id']=$session_id;
  $ipaddress= $_SERVER[REMOTE_ADDR];

 
  $loginSQL = "INSERT INTO user_logins
  (userid,username,logintime,sessid,ipaddress)
  VALUES ('$userid','$username','$logintime','$session_id','$ipaddress')";
 //echo $insertSQL;
  $Result1 = mysql_query($loginSQL) or die(mysql_error()); 
    
	// username and password match - this is a valid user
    $_SESSION['MM_Username1']=$FF_valUsername;
	$_SESSION['MM_Username1']=$FF_valUsername;
$_SESSION["MM_USERID"]=getuserid($username);
$_SESSION["MM_USERID"]=getuserid($username);
$_SESSION["MM_ADDRIGHTS"]=getaddrights($userid);
$_SESSION["MM_UPDATERIGHTS"]=getupdaterights($userid);
$_SESSION["MM_DELETERIGHTS"]=getdeleterights($userid);
$_SESSION["MM_REPORTRIGHTS"]=getreportrights($userid);
$_SESSION["MM_USERRIGHTS"]=getusersrights($userid);
$_SESSION["MM_CUSTOMERRIGHTS"]=getcontactsrights($userid);
$_SESSION["MM_CUSTOMERRIGHTS"]=getcontactsrights($userid);
$_SESSION["MM_GROUPRIGHTS"]=getgroupsrights($userid);
$_SESSION["MM_ACCOUNTRIGHTS"]=getaccountsrights($userid);
$_SESSION["MM_OFFICERIGHTS"]=getofficerights($userid);
$_SESSION["MM_USEROFFICEID"]=getuseroffice($userid);
$_SESSION["MM_USERROLE"]=getuserrole($userid);
$_SESSION["MM_AGENTREF"]=getagentname($userid);
$_SESSION["MM_AGENTID"]=getagentid($userid);
$agentid = getagentid($userid);
$_SESSION["MM_AGENTTYPE"]=getagenttype($agentid);
$_SESSION["MM_AGENTCOMMISSION"]=getagentcommission($agentid);
$_SESSION["MM_SMSRIGHTS"]=getsmsrights($userid);
$_SESSION["MM_USERCREATIONRIGHTS"]=getusercreationrights($userid);
$_SESSION["MM_SUPERUSERRIGHTS"]=getsuperuserrights($userid);
$_SESSION["MM_ALERTRIGHTS"]=getalertrights($userid);
$_SESSION["MM_CONFIRMRIGHTS"]=getconfirmrights($userid);
$_SESSION["MM_LOCKSTATUS"]=getagentlockstatus($userid);
  //  session_register("MM_Username1");

    if ($FF_fldUserAuthorization != "")
    {
      $MM_UserAuthorization1=$row_FF_rsUser[$FF_fldUserAuthorization];
    } else
    {
      $MM_UserAuthorization1="";
    }
	 $_SESSION['MM_UserAuthorization1']=$MM_UserAuthorization1;
   // session_register("MM_UserAuthorization1");
    if (isset($accessdenied) && false)
    {
      $FF_redirectLoginSuccess = $accessdenied;
    }
    mysql_free_result($FF_rsUser);
	 $_SESSION['FF_login_failed']="";
    //session_register("FF_login_failed");
	if($_SESSION["MM_LOCKSTATUS"] == 'Y')
		{
		 header ("Location:agentlocked.php");
		exit;
		}
        $FF_login_failed = false;
   $statusparameter=base64_encode('loginsuccess');
   header ("Location:index.php?status=$statusparameter");
    exit;


  
  
} //greater than zero

  mysql_free_result($FF_rsUser);
  session_register("FF_login_failed");
  $FF_login_failed = true;
  $statusparameter=base64_encode('loginfailure');
 // echo "the status parameter is ".$statusparameter;
   header ("Location:index.php?status=$statusparameter");
  exit;

}  // end of if



if (isset($_SESSION["MM_UserAuthorization1"]))
{
$statusparameter=base64_encode('loginsuccess');
   header ("Location:index.php?status=$statusparameter");
exit;
}
?>
