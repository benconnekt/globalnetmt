<?     
$server= "db475954680.db.1and1.com";
$user= "dbo475954680";          /* FTP-username */
$password= "syaHHVKp";         /* FTP-Password */
$database= "db475954680";         /* name of database */
MYSQL_CONNECT($server, $user, $password) or die ( "<H3>Server unreachable</H3>");
MYSQL_SELECT_DB($database) or die ( "<H3>Database non existent</H3>");
include("inc_header1.php");
/*

 $sql            = "select agentcommission,orderdate,saleid,orderid,commission1,commpercentage1,officeid,ordercountry,orderamount from sales_master where commpercentage1=0 and officeid != '1' and officeid != '169' and officeid != '181'";
   $Result         = safe_query($sql) ;
   while ($row1 = mysql_fetch_array($Result))
  {
	 $commission1 =0;
     $commpercentage1=0;
	  $saleid = $row1['saleid'];
	  $orderamount = $row1['orderamount'];
	 $commpercentage1 = getagentcommissionvalue($row1['officeid'],$row1['ordercountry'],$orderamount);
	 if(is_numeric($commpercentage1) && $commpercentage1>0)
		{
			$commission1 = round((($row1['agentcommission']*$commpercentage1)/100),2);
		}
	//print("<br>the sale id ".$row1['saleid']." - the country is ".$row1['ordercountry']." - the orderid is ".$row1['orderid']." - the date is ".$row1['orderdate']." - the commission1 is ".$row1['commission1']." - the commpercentage1 is ".$row1['commpercentage1']." - the officeid is ".$row1['officeid']." and the agent commission is ".$row1['agentcommission']." and the order amount is ".$row1['orderamount']);
 $updatesql="update sales_master set commission1='$commission1',commpercentage1='$commpercentage1' where saleid='$saleid'";
 //print("<br>$updatesql;");
 //safe_query($updatesql);
  }
  */
?>

