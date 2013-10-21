<?php include('inc_functions.php');
include('inc_accountsfunctions.php');
include('inc_contactsfunctions.php');
$server= "localhost";
$user= "root";          /* FTP-username */
$password= "";         /* FTP-Password */
$database= "db475954680";         /* name of database */

//  /* Business Server Info */
//$server= "db475954680.db.1and1.com";
//$user= "dbo475954680";          /* FTP-username */
//$password= "syaHHVKp";         /* FTP-Password */
//$database= "db475954680";         /* name of database */

MYSQL_CONNECT($server, $user, $password) or die ( "<H3>Server unreachable</H3>");
MYSQL_SELECT_DB($database) or die ( "<H3>Database non existent</H3>");
?>

