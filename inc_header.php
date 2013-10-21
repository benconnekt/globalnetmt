<?php
include('inc_functions.php');
include('inc_accountsfunctions.php');
include('inc_contactsfunctions.php');

$server= "localhost";
$user= "root";          /* FTP-username */
$password= "";         /* FTP-Password */
$database= "db475954680";         /* name of database */



  /* Business Server Info */
//$server= "db475954680.db.1and1.com";
//$user= "dbo475954680";          /* FTP-username */
//$password= "syaHHVKp";         /* FTP-Password */
//$database= "db475954680";         /* name of database */

MYSQL_CONNECT($server, $user, $password) or die ( "<H3>Server unreachable</H3>");
MYSQL_SELECT_DB($database) or die ( "<H3>Database non existent</H3>");
function isValidSession($sessid,$username)
{
 $sql    = "select count(*) as count from user_master a,user_logins c where a.userid=c.userid and a.username='$username' and c.sessid='$sessid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
       $count = (isset($row['count'])) ? $row['count'] : "";
		
 }

 if($count==1)
	{
	 return true;
	}
	else
	{
		return false;
	}
}
if(!isValidSession($HTTP_SESSION_VARS["session_id"],$HTTP_SESSION_VARS["MM_Username1"]))
{
//$statusparameter=base64_encode('sessionexpired');
include("login.html");
exit;
}?>

