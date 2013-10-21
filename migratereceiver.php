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
 $sql            = "select FULL as firstname,address as address,state as state,country as country,telephone as mobile,email as email,receiver_id as idno from receiver";
   $Result         = safe_query($sql) ;
   while ($row = mysql_fetch_array($Result))
  {
  $firstname = str_replace(";","",$row[0]);
  $address = str_replace(";","",$row[1]);
  $state = str_replace(";","",$row[2]);
  $country = str_replace(";","",$row[3]);
  $mobile = str_replace(";","",$row[4]);
  $email = str_replace(";","",$row[5]);
  $idno = str_replace(";","",$row[6]);


  $firstname = str_replace("'","",$firstname);
  $address = str_replace("'","",$address);
  $state = str_replace("'","",$state);
  $country = str_replace("'","",$country);
  $mobile = str_replace("'","",$mobile);
  $email = str_replace("'","",$email);
  $idno = str_replace("'","",$idno);

  print("insert into ben_master(firstname,address,state,country,mobile,idno) values ('$firstname','$address','$state','$country','$mobile','$idno');<br>");
  }
?>

