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
 $sql            = "select contactid,idno from contact_master";
   $Result         = safe_query($sql) ;
   while ($row = mysql_fetch_array($Result))
  {
  $contactid = str_replace(";","",$row[0]);
  $idno = str_replace(";","",$row[1]);
   print("update ben_master set contactid='$contactid' where idno='$idno';<br>");
  }
?>

