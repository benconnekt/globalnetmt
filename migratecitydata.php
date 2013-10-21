<?     
$server= "localhost";
$user= "root";          /* FTP-username */
$password= "";         /* FTP-Password */
$database= "globalnetmt";         /* name of database */
MYSQL_CONNECT($server, $user, $password) or die ( "<H3>Server unreachable</H3>");
MYSQL_SELECT_DB($database) or die ( "<H3>Database non existent</H3>");

function safe_query($query="")

{
    if (empty($query))
    {
     return FALSE;
     }
     $result = mysql_query($query)  or die ("Query.. failed."
           ."<li>Query    : ".$query
           ."<li>Error No : ".mysql_errno()
           ."<li>Error    : ".mysql_error());
    return $result;
}
 $sql            = "select receiver.state, state_master.stateid from receiver, state_master where lower(receiver.state) = lower(state_master.statename)";
  // echo $sql;
   $Result         = safe_query($sql) ;
   while ($row = mysql_fetch_array($Result))
  {
  print("update receiver set state = '$row[1]' where receiver.state='$row[0]';<br>");
  }
?>

