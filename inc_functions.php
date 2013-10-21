<?php
include("util_functions.php");
global $global_headofficeid;
$global_headofficeid = "907";
function IndexDirDisplay() {  
      
     $documentdir=opendir("../uploads/");  
      
     while ($file = readdir($documentdir)) {  
          
      if ($file == "." || $file == "..") { }  
         else { 
             print "<tr><td class=Row><a href='http://www.globalnett.co.uk/uploads/$file' target=_blank>$file</a></font></td>"; 
			 echo "</tr>"; 
           
          } 
        
     }  
     closedir($documentdir);  
}  

function IndexDirWebsiteDisplay() {  
      
     $documentdir=opendir("customeruploads/");  
      
     while ($file = readdir($documentdir)) {  
          
      if ($file == "." || $file == "..") { }  
         else { 
             print "<tr><td class=Row><a href='http://www.global-nett.co.uk/customeruploads/$file' target=_blank>$file</a></font></td>"; 
			 echo "</tr>"; 
           
          } 
        
     }  
     closedir($documentdir);  
}  
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
function UKdst_datetime()
{
    // created by Matthew Waygood (www.waygoodstuff.co.uk)
    $timestamp = strtotime('now');
    $timestamp=$timestamp-3600; // foward one hour
    return $timestamp;
}

function UKdst_time()
{
    // created by Matthew Waygood (www.waygoodstuff.co.uk)
    $timestamp = mktime(gmdate("H, i, s, m, d, Y")); // UTC time
    $this_year=gmdate("Y", $timestamp);

    // last sunday in march at 1am UTC
    $last_day_of_march=gmmktime(1,0,0,3,31,$this_year);
    $last_sunday_of_march=strtotime("-".gmdate("w", $last_day_of_march)." day", $last_day_of_march);
    
    // last sunday in october at 1am UTC
    $last_day_of_october=gmmktime(1,0,0,10,31,$this_year);
    $last_sunday_of_october=strtotime("-".gmdate("w", $last_day_of_october)." day", $last_day_of_october);

    if( ($timestamp > $last_sunday_of_march) && ($timestamp < $last_sunday_of_october) )
    {
        $timestamp=$timestamp+3600; // foward one hour
    }
    return $timestamp;
}
function check_records($idno,$type)
{
	$orders_found=false;
	$users_found=false;
	$rates_found=false;
	$customers_found=false;
	$beneficiaries_found=false;
	$currencies_found=false;
	$check_message="";
	$delete_flag=true;
		if($type=='contact')
	{
		
		$rows_found=0;
		$check_sql="select contactid from sales_master where contactid='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);
     
			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select contactid from ben_master where contactid='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);
 
			if($rows_found>0)
		{
				$beneficiaries_found=true;
				$delete_flag=false;
		}
	}
if($type=='beneficiary')
	{
		$rows_found=0;
		$check_sql="select benid from sales_master where benid='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
	}
	if($type=='country')
	{
		$rows_found=0;
		$check_sql="select country from ben_master where country='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$beneficiaries_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select country from contact_master where country='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$customers_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select country from currency_master where country='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$currencies_found=true;
				$delete_flag=false;
		}
	}
	if($type=='bank')
	{
		$rows_found=0;
		$check_sql="select bankname from ben_master where bankname='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$beneficiaries_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select bankname from sales_master where bankname='$idno' and collectiontype='Bank'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
	}
	if($type=='currency')
	{
		$rows_found=0;
		$check_sql="select currency from rate_master where currency='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$rates_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select currency from sales_master where currency='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
	}
	if($type=='users')
	{
		$rows_found=0;		
		$check_sql="select orderby from sales_master where orderby='$idno' or processby='$idno'";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
	}
	if($type=='office')
	{
		$rows_found=0;
		$check_sql="select officeid from sales_master where officeid='$idno' ";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$orders_found=true;
				$delete_flag=false;
		}
		$rows_found=0;
		$check_sql="select useroffice from user_master where useroffice='$idno' ";
		$check_result = mysql_query($check_sql) or die(mysql_error());
		$rows_found=mysql_num_rows($check_result);

			if($rows_found>0)
		{
				$users_found=true;
				$delete_flag=false;
		}
	}
	
    if($orders_found)
	{
		$check_message=$check_message."<li> Orders found for the record you wish to delete. Child records must be deleted before deleting the master record </li>";
	}
	if($users_found)
	{
		$check_message=$check_message."<li> Users found for the record you wish to delete. Child records must be deleted before deleting the master record  </li>";
	}
	if($rates_found)
	{
		$check_message=$check_message."<li> Rates found for the record you wish to delete. Child records must be deleted before deleting the master record  </li> ";
	}
	if($beneficiaries_found)
	{
		$check_message=$check_message."<li> Beneficiaries found for the record you wish to delete. Child records must be deleted before deleting the master record </li> ";
	}
	if($customers_found)
	{
		$check_message=$check_message."<li> Customers found for the record you wish to delete. Child records must be deleted before deleting the master record  </li>";
	}
	if($currencies_found)
	{
		$check_message=$check_message."<li> Currencies found for the record you wish to delete. Child records must be deleted before deleting the master record  </li>";
	}
    if($check_message!='')
	{
	display_message("Warning:<ul>".$check_message."</ul>");
	}
	
	return $delete_flag;
	
}
function addmtsale()
{
	$contactid=$_POST['contactid'];
	$benid=$_POST['benid'];
	$currency=$_POST['currency'];
	$collectiontype=$_POST['collectiontype'];
	$collectionofficeid=$_POST['collectionofficeid'];
	$bankname=$_POST['bankname'];
	$branchname=$_POST['branchname'];
	$accountno=$_POST['accountno'];
	$sortcode=$_POST['sortcode'];
	$accounttype=addslashes($_POST['accounttype']);
	$benamount=$_POST['benamount'];
	$exchangerate=$_POST['exchangerate'];
	$orderamount=$_POST['orderamount'];
	$orderstatus=$_POST['orderstatus'];
	$officeid=$_POST['officeid'];
	$agentcommission=$_POST['agentcommission'];
	$orderby=$_POST['orderby'];
	$instructions=$_POST['instructions'];
	$paymenttype=$_POST['paymenttype'];
	$idno=$_POST['idno'];
	$ibanno=$_POST['ibanno'];
	$swiftcode=$_POST['swiftcode'];
	$branchaddress=$_POST['branchaddress'];
	$sms = $_POST['sms'];
	$orderdate=date("Y-m-d");
	$orderdate=date("Y-m-d");
	$ordertime =  date("H:i:s", UKdst_time());
	$pickupidothers = $_POST['pickupidothers'];
	$pickupidtype = $_POST['pickupidtype'];
	$payingagent = $_POST['payingagent'];
	$ordercountry = $_POST['ordercountry'];
	$depositbankname = $_POST['depositbankname'];
	$sourceoffunds = $_POST['sourceoffunds'];
	$purposeoftransfer = $_POST['purposeoftransfer'];
	$agentbankcharges = $_POST['agentbankcharges'];
       
	$agentpaymenttype = getagentpaymenttype($officeid);
	
	if($collectiontype == 'Bank')
	{
	$commpercentage1 = getagentcommissionvalue($officeid,$ordercountry,$orderamount);
	$commpercentage2 = getpayingagentcommissionvalue($payingagent);
	
	}
	else
	{
	//$payingagent = getpayingagentforagent($collectionofficeid);
	$commpercentage1 = getagentcommissionvalue($officeid,$ordercountry,$orderamount);
	$commpercentage2 = getpayingagentcommissionvalue($payingagent);
	
	}

	if(is_numeric($commpercentage1) && $commpercentage1>0)
		{
			$commission1 = round((($agentcommission*$commpercentage1)/100),2);
		}
	if(is_numeric($commpercentage2) && $commpercentage2>0)
		{
			$commission2 = round((($agentcommission*$commpercentage2)/100),2);
		}

	if($agentpaymenttype == 'PAYASYOUGO')
	{
		$accountcommission = $agentcommission-$commission1;
	}
	else
	{
		$accountcommission = $agentcommission;
	}

	if(is_numeric($orderamount) && is_numeric($agentcommission) && is_numeric($benamount))
	{
   $insertSQL = "INSERT INTO sales_master
  (contactid,benid,currency,collectiontype,collectionofficeid,bankname,  branchname,accountno,sortcode,benamount,exchangerate,orderamount,orderstatus,officeid,agentcommission,orderby,instructions,orderdate,paymenttype,idno,ibanno,swiftcode,branchaddress,sms,pickupidtype,pickupidothers,payingagent,commission1,commission2,commpercentage1,commpercentage2,ordercountry,ordertime,depositbankname,accountcommission,agentpaymenttype,releaseorder,is_hidden,sourceoffunds,purposeoftransfer,agentbankcharges,accounttype)
	VALUES ('$contactid','$benid','$currency','$collectiontype','$collectionofficeid','$bankname',  '$branchname','$accountno','$sortcode','$benamount','$exchangerate','$orderamount','$orderstatus','$officeid','$agentcommission','$orderby','$instructions','$orderdate','$paymenttype','$idno','$ibanno','$swiftcode','$branchaddress','$sms','$pickupidtype','$pickupidothers','$payingagent','$commission1','$commission2','$commpercentage1','$commpercentage2','$ordercountry','$ordertime','$depositbankname','$accountcommission','$agentpaymenttype','Y','N','$sourceoffunds','$purposeoftransfer','$agentbankcharges','$accounttype')";
	//echo $insertSQL;
	//exit;

	$Result1 = mysql_query($insertSQL) or die(mysql_error());
	$inserted_saleid = mysql_insert_id();
	$agentprefix=getagentprefix($officeid);
	$agentsuffix=getagentsuffix($officeid);
	$agentcount = getagenttransactioncount($officeid);
	$orderid=$agentprefix.$agentcount.$agentsuffix;
  

  
  // $update_creditlimit__sql = "update agent_master set agentcreditlimit=agentcreditlimit-$orderamount where agentid='".$officeid."'";
  // mysql_query($update_creditlimit__sql) ;
    
  $orderchecksql    = "select count(*) as ordercount from sales_master where orderid='$orderid'"; // folders of the user
	//echo $orderchecksql;
    $Result1 = safe_query($orderchecksql) ;
    while ($row1      = mysql_fetch_array( $Result1))
	{
     $recordcount = $row1['ordercount'];
	}
    
	if($recordcount == 0)
		{
   $update_order_id_sql = "update sales_master set orderid='".$orderid."'where saleid='".$inserted_saleid."'";
   mysql_query($update_order_id_sql) ;
		}
		else
		{
	$agentcount = getagenttransactioncount($officeid);
	$orderid=$agentprefix.$agentcount.$agentsuffix;
	$update_order_id_sql = "update sales_master set orderid='".$orderid."'where saleid='".$inserted_saleid."'";
	mysql_query($update_order_id_sql) ;
		}
	
	$update_sequence_id_sql = "update sales_master set sequence='".$agentcount."'where saleid='".$inserted_saleid."'";
	mysql_query($update_sequence_id_sql) ;

	$amlMessage = validateAMLConditions($inserted_saleid);
    if(strlen($amlMessage))
		{
		$update_order_id_sql = "update sales_master set amlnotes='".$amlMessage."',releaseorder='N',releasemessage = null where saleid='".$inserted_saleid."'";
		mysql_query($update_order_id_sql) ;
		}
   print "<b><p align=center>Money Transfer information has been successfully added</p>";
   return $inserted_saleid;
   exit;
	}
	else
	{
		  display_message( "<b><p align=center>There is a problem. please try again</p>");

	}
}

function processmtsale()
{
	
    
	$orderstatus=$_POST['orderstatus'];	
	$beneficiaryidno=$_POST['beneficiaryidno'];	
	$saleid=$_POST['saleid'];
	$processby=$_POST['processby'];
	$processdate=date("Y-m-d");
	$processtime =  date("H:i:s", UKdst_time());
 
  $insertSQL = "update sales_master set
     orderstatus='$orderstatus',
     processdate='$processdate',
     processby='$processby',processtime='$processtime',beneficiaryidno='$beneficiaryidno'
    where saleid='$saleid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());

  display_message( "<b><p align=center>Money Transfer information has been successfully processed</p>");


	
}

function updatecancelledorder($saleid)
{
	 $sql    = "select ordertime,instructions,orderdate from sales_master where saleid='$saleid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $orderdate = (isset($row['orderdate'])) ? $row['orderdate'] : "";
		$ordertime = (isset($row['ordertime'])) ? $row['ordertime'] : "";
		$instructions = (isset($row['instructions'])) ? $row['instructions'] : "";
 }
	$additionalinstructions = $instructions."\nOrder Cancelled. Original order date and time is  ".changeddate($orderdate)." ".$ordertime;
    $currentorderdate=date("Y-m-d");
	$currentordertime =  date("H:i:s", UKdst_time());
	$updateSQL = "update sales_master set orderdate='$currentorderdate',ordertime= '$currentordertime', instructions = '$additionalinstructions',processdate=null,processtime=null where saleid='$saleid'";
	//echo $updateSQL;
	$Result1 = mysql_query($updateSQL) or die(mysql_error());


}

function updatecancelledwithoutcommissionorder($saleid)
{
	$updateSQL = "update sales_master set processdate=null,processtime=null where saleid='$saleid'";
	//echo $updateSQL;
	$Result1 = mysql_query($updateSQL) or die(mysql_error());


}


function editmtsale()
{
    $currency=$_POST['currency'];
	$collectiontype=$_POST['collectiontype'];
	$collectionofficeid=$_POST['collectionofficeid'];
	$bankname=$_POST['bankname'];
	$branchname=$_POST['branchname'];
	$accountno=$_POST['accountno'];
	$sortcode=$_POST['sortcode'];
	$benamount=$_POST['benamount'];
	$exchangerate=$_POST['exchangerate'];
	$agentcommission=$_POST['agentcommission'];
	$orderamount=$_POST['orderamount'];
	$orderstatus=$_POST['orderstatus'];
	$instructions=$_POST['instructions'];
	$officeid=$_POST['officeid'];
	$paymenttype=$_POST['paymenttype'];
	$idno=$_POST['idno'];
	$saleid=$_POST['saleid'];
	$ibanno=$_POST['ibanno'];
	$swiftcode=$_POST['swiftcode'];
	$branchaddress=$_POST['branchaddress'];
	$sms = $_POST['sms'];
	$pickupidothers = $_POST['pickupidothers'];
	$pickupidtype = $_POST['pickupidtype'];
	$payingagent = $_POST['payingagent'];
    $ordercountry = $_POST['ordercountry'];
	$depositbankname = $_POST['depositbankname'];
	$sourceoffunds = $_POST['sourceoffunds'];
	$purposeoftransfer = $_POST['purposeoftransfer'];
	$agentbankcharges = $_POST['agentbankcharges'];
	$accounttype=addslashes($_POST['accounttype']);

    $agentpaymenttype = getagentpaymenttype($officeid);
	
	if($collectiontype == 'Bank')
	{
	$commpercentage1 = getagentcommissionvalue($officeid,$ordercountry,$orderamount);
	$commpercentage2 = getpayingagentcommissionvalue($payingagent);
	
	}
	else
	{
	//$payingagent = getpayingagentforagent($collectionofficeid);
	$commpercentage1 = getagentcommissionvalue($officeid,$ordercountry,$orderamount);
	$commpercentage2 = getpayingagentcommissionvalue($payingagent);
	
	}

	if(is_numeric($commpercentage1) && $commpercentage1>0)
		{
			$commission1 = round((($agentcommission*$commpercentage1)/100),2);
		}
	if(is_numeric($commpercentage2) && $commpercentage2>0)
		{
			$commission2 = round((($agentcommission*$commpercentage2)/100),2);
		}

	
   if($orderstatus=="Cancelled With Commission")
	{
	 $orderamount = "-".abs($orderamount);
   $agentcommission = "-".abs($agentcommission);
   $commission1 = "-".abs($commission1);
   $commission2 = "-".abs($commission2);
   $benamount = "-".abs($benamount);
	}
	elseif($orderstatus=="Cancelled Without Commission")
	{
   $orderamount = "-".abs($orderamount);
    $benamount = "-".abs($benamount);
	$agentcommission = abs($agentcommission);
	 $commission1 = abs($commission1);
   $commission2 = abs($commission2);
	}


if($agentpaymenttype == 'PAYASYOUGO')
	{
		$accountcommission = $agentcommission-$commission1;
	}
	else
	{
		$accountcommission = $agentcommission;
	}

if(is_numeric($orderamount) && is_numeric($agentcommission) && is_numeric($benamount))
	{

  $updateSQL = "update sales_master set
   currency='$currency',
	   agentbankcharges='$agentbankcharges',
   collectiontype='$collectiontype',
   collectionofficeid='$collectionofficeid',
	   paymenttype='$paymenttype',
   bankname='$bankname',
   branchname='$branchname',
   accountno='$accountno',
   accounttype ='$accounttype',
     benamount='$benamount',
	   agentcommission='$agentcommission',
     exchangerate='$exchangerate',
     orderamount='$orderamount',
     orderstatus='$orderstatus',payingagent='$payingagent',sourceoffunds='$sourceoffunds',purposeoftransfer='$purposeoftransfer', instructions='$instructions',sms='$sms',sortcode='$sortcode',idno='$idno',ibanno='$ibanno',swiftcode='$swiftcode',branchaddress='$branchaddress',pickupidothers='$pickupidothers',pickupidtype='$pickupidtype',commission1='$commission1',commission2='$commission2',commpercentage1='$commpercentage1',commpercentage2='$commpercentage2',ordercountry='$ordercountry',depositbankname='$depositbankname',accountcommission='$accountcommission',agentpaymenttype='$agentpaymenttype' where saleid='$saleid'";
 //echo $updateSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());


 if($orderstatus=="Cancelled With Commission")
	{
	updatecancelledorder($saleid);
   }
  	elseif($orderstatus=="Cancelled Without Commission")
	{
   updatecancelledwithoutcommissionorder($saleid);
  }
  display_message( "<b><p align=center>Money Transfer information has been successfully updated</p>");

	}


}


function getagentprefix($agentrefid)
{
 $sql    = "select agentref from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentprefix = (isset($row['agentref'])) ? $row['agentref'] : "";
 }
    return($agentprefix);
}

function getagentpaymenttype($agentrefid)
{
 $sql    = "select agentpaymenttype from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentpaymenttype = (isset($row['agentpaymenttype'])) ? $row['agentpaymenttype'] : "";
 }
    return($agentpaymenttype);
}

function getpayingagentforagent($agentrefid)
{
 $sql    = "select payingagent from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $payingagent = (isset($row['payingagent'])) ? $row['payingagent'] : "";
 }
    return($payingagent);
}

function getagentbankcharges($agentrefid)
{
 $sql    = "select bank_charge from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $bank_charge = (isset($row['bank_charge'])) ? $row['bank_charge'] : "";
 }
    return($bank_charge);
}

function getagenttransactioncount($agentrefid)
{
 $sql    = "select max(sequence) as count from sales_master where officeid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentcount = (isset($row['count'])) ? $row['count'] : "";
 }

 $agentcount = $agentcount + 1;
    return($agentcount);
}

function getagentsuffix($agentrefid)
{
 $sql    = "select agentsuffix from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentsuffix = (isset($row['agentsuffix'])) ? $row['agentsuffix'] : "";
 }
    return($agentsuffix);
}

function getorderamount($saleid)
{
 $sql    = "select orderamount from sales_master where saleid='$saleid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $orderamount = (isset($row['orderamount'])) ? $row['orderamount'] : "";
 }
    return($orderamount);
}

function getagentcommission($agentrefid)
{
 $sql    = "select commission from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentcommission = (isset($row['commission'])) ? $row['commission'] : "";
 }
    return($agentcommission);
}
function getagentcreditlimit($agentrefid)
{
 $sql    = "select agentcreditlimit from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentcreditlimit = (isset($row['agentcreditlimit'])) ? $row['agentcreditlimit'] : "";
 }
    return($agentcreditlimit);
}
function getagenttype($agentrefid)
{
 $sql    = "select agenttype from agent_master where agentid='$agentrefid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agenttype = (isset($row['agenttype'])) ? $row['agenttype'] : "";
 }
    return($agenttype);
}

function addagentinfo()
{
   $agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$agentstatus = $_POST['agentstatus'];
	$agentloginid = $_POST['agentloginid'];
	$agentcommission = $_POST['agentcommission'];
	$agentcreditlimit = $_POST['agentcreditlimit'];
	$agenttype = $_POST['agenttype'];
	$agentref = $_POST['agentref'];
	$country = $_POST['country'];
	$commcountry = $_POST['commcountry'];
	$agentcommission1 = $_POST['agentcommission1'];
	$agentopeningbalance = $_POST['agentopeningbalance'];
	$agentsuffix = $_POST['agentsuffix'];
	$agentpaymenttype = $_POST['agentpaymenttype'];
	$is_online = $_POST['is_online'];
	$bank_charge = $_POST['bank_charge'];
    global $querystatus;


   if($agentname!=''  && $agentref!=''  && $country!='' && is_numeric($agentcreditlimit))
   {

	$FF_dupKeySQL = "SELECT agentname FROM agent_master WHERE lower(agentsuffix) ='" . strtolower($agentsuffix) . "'";
	$FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {
    display_message( "<b><p align=center>Agent with same transaction suffix already exists.Please try again</b></p>");
   }
   else
   {
   
  $insertSQL = "INSERT INTO agent_master
  (agentname,agentaddress,agenttelephone,agentfax,agentmobile,agentemail,agentstatus,agentref,userid,agenttype,commission,agentcreditlimit,country,commcountry,commission1,agentopeningbalance,agentsuffix,agentpaymenttype,is_online,bank_charge)
  VALUES ('$agentname','$agentaddress','$agenttelephone','$agentfax','$agentmobile','$agentemail','$agentstatus','$agentref','$agentloginid','$agenttype','$agentcommission','$agentcreditlimit','$country','$commcountry','$agentcommission1','$agentopeningbalance','$agentsuffix','$agentpaymenttype','$is_online','$bank_charge')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Agent information has been successfully added</p>");
  $querystatus="done";
   }
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Agent Information has not been added.Please try again</p>");
  $querystatus="notdone";
   }

   return $querystatus;
}
function addcollectionpointinfo()
{
   $agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$agentstatus = $_POST['agentstatus'];
	$agenttype = $_POST['agenttype'];
	$country = $_POST['country'];
	$is_default = $_POST['is_default'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$contactperson = $_POST['contactperson'];
	$payingagent = $_POST['payingagent'];
    global $querystatus;


   if($agentname!=''  && $country!='' && $state!='' && $city!='' && $payingagent!='')
   {
   
  $insertSQL = "INSERT INTO agent_master
  (agentname,agentaddress,agenttelephone,agentfax,agentmobile,agentemail,agentstatus,city,state,agenttype,contactperson,payingagent,country,is_default)
  VALUES ('$agentname','$agentaddress','$agenttelephone','$agentfax','$agentmobile','$agentemail','$agentstatus','$city','$state','$agenttype','$contactperson','$payingagent','$country','$is_default')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Collection Point information has been successfully added</p>");
  $querystatus="done";
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Collection Point Information has not been added.Please try again</p>");
  $querystatus="notdone";
   }

   return $querystatus;
}

function addpayingagentinfo()
{
   $agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$agentstatus = $_POST['agentstatus'];
	$country = $_POST['country'];
	$commission = $_POST['commission'];
	$agentopeningbalance = $_POST['agentopeningbalance'];
	$poundopeningbalance = $_POST['poundopeningbalance'];
	$show_online = $_POST['show_online'];

	  global $querystatus;


   if($agentname!=''  && $country!='')
   {
   
  $insertSQL = "INSERT INTO payingagent_master
  (agentname,agentaddress,agenttelephone,agentfax,agentmobile,agentemail,country,commission,agentopeningbalance,poundopeningbalance,agentstatus,show_online)
  VALUES ('$agentname','$agentaddress','$agenttelephone','$agentfax','$agentmobile','$agentemail','$country','$commission','$agentopeningbalance','$poundopeningbalance','$agentstatus','$show_online')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Corresponding Agent information has been successfully added</p>");
  $querystatus="done";
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Corresponding Agent Information has not been added.Please try again</p>");
  $querystatus="notdone";
   }

   return $querystatus;
}
function getcustomernames($name,$selected,$agentref1)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select distinct UCASE(customername),UCASE(customertelephone2) from moneytransfer_sales where agentref='$agentref1' order by customername ASC "; // folders of the user
     $temp        = $temp."<option value='' >SELECT ONE</option>";
    $Result = safe_query($sql) ;
   // echo $sql;
    while ($row      = mysql_fetch_array( $Result))
 {
           $customername  = (isset($row['UCASE(customername)'])) ? $row['UCASE(customername)'] : 0;
            $customertelephone2  = (isset($row['UCASE(customertelephone2)'])) ? $row['UCASE(customertelephone2)'] : 0;
         $selectedname=$customername."-".$customertelephone2;
        if($selected==$selectedname)
            $temp        = $temp."<option value='".$customername."-".$customertelephone2."' selected>".$customername." ".$customertelephone2."</option>";
        else
            $temp        = $temp."<option value='".$customername."-".$customertelephone2."'>".$customername." ".$customertelephone2."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}
function editagentinfo()

{
	$agentid = $_POST['editagentid'];
	$agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$agentstatus = $_POST['agentstatus'];
	$agentloginid = $_POST['agentloginid'];
	$agentcommission = $_POST['agentcommission'];
	$agenttype = $_POST['agenttype'];
	$agentcreditlimit = $_POST['agentcreditlimit'];
	$agentref = $_POST['agentref'];
	$country = $_POST['country'];
	$commcountry = $_POST['commcountry'];
	$agentcommission1 = $_POST['agentcommission1'];
	$agentopeningbalance = $_POST['agentopeningbalance'];
	$agentsuffix = $_POST['agentsuffix'];
	$agentpaymenttype = $_POST['agentpaymenttype'];
	$is_online = $_POST['is_online'];
	$bank_charge = $_POST['bank_charge'];


  if($agentid!='' && $agentname!='' && $agentref!='' && $country!='' && is_numeric($agentcreditlimit))
  {
	  $FF_dupKeySQL = "SELECT agentname FROM agent_master WHERE lower(agentsuffix) ='" . strtolower($agentsuffix) . "' and agentid != '$agentid'";
	$FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {
    display_message( "<b><p align=center>Agent with same transaction suffix already exists.Please try again</b></p>");
   }
   else
   {
$sql="update agent_master set
         agentname='$agentname',agentaddress='$agentaddress',agenttelephone='$agenttelephone',
         agentmobile='$agentmobile',agentfax='$agentfax', agentemail='$agentemail',agentref='$agentref',
         agentstatus='$agentstatus',country='$country',commission='$agentcommission',agentcreditlimit='$agentcreditlimit',agenttype='$agenttype',agentsuffix='$agentsuffix',commission1='$agentcommission1',commcountry='$commcountry',agentopeningbalance='$agentopeningbalance',agentpaymenttype='$agentpaymenttype',is_online='$is_online',bank_charge='$bank_charge'
         where agentid='$agentid'";
//echo $sql;
    $Result= safe_query($sql);
  display_message( "<b><p align=center>Agent information has been successfully updated</p>");
  $querystatus="done";
   }

   }
   else
   {
   display_message( "<font color=red><p align=center>Error: There is a problem.The Agent information has not been updated.Please try again</p>");
   $querystatus="notdone";
   }
 return $querystatus;
}

function editcollectionpointinfo()

{
	$agentid = $_POST['editagentid'];
	$agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$agenttype = $_POST['agenttype'];
	$agentstatus = $_POST['agentstatus'];
	$country = $_POST['country'];
	$is_default = $_POST['is_default'];
	$state = $_POST['state'];
	$city = $_POST['city'];
	$contactperson = $_POST['contactperson'];
	$payingagent = $_POST['payingagent'];



  if($agentid!='' && $agentname!='' && $country!='')
  {
$sql="update agent_master set
         agentname='$agentname',agentstatus='$agentstatus',agentaddress='$agentaddress',agenttelephone='$agenttelephone',
         agentmobile='$agentmobile',agentfax='$agentfax', agentemail='$agentemail',city='$city',
         agentstatus='$agentstatus',country='$country',is_default='$is_default',state='$state',payingagent='$payingagent',contactperson='$contactperson',agenttype='$agenttype'
         where agentid='$agentid'";
//echo $sql;
    $Result= safe_query($sql);
  display_message( "<b><p align=center>Collection point information has been successfully updated</p>");
  $querystatus="done";

   }
   else
   {
   display_message( "<font color=red><p align=center>Error: There is a problem.The Collection point information has not been updated.Please try again</p>");
   $querystatus="notdone";
   }
 return $querystatus;
}

function editpayingagentinfo()

{
	$agentid = $_POST['editagentid'];
	$agentname = $_POST['agentname'];
	$agentaddress = $_POST['agentaddress'];
	$agenttelephone = $_POST['agenttelephone'];
	$agentfax = $_POST['agentfax'];
	$agentmobile = $_POST['agentmobile'];
	$agentemail = $_POST['agentemail'];
	$country = $_POST['country'];
	$commission = $_POST['commission'];
	$agentstatus = $_POST['agentstatus'];
	$agentopeningbalance = $_POST['agentopeningbalance'];
	$poundopeningbalance = $_POST['poundopeningbalance'];
	$show_online = $_POST['show_online'];

  if($agentid!='' && $agentname!='' && $country!='')
  {
$sql="update payingagent_master set
         agentname='$agentname',agentaddress='$agentaddress',agenttelephone='$agenttelephone',
         agentmobile='$agentmobile',commission='$commission',agentfax='$agentfax', agentemail='$agentemail',country='$country',agentstatus='$agentstatus',agentopeningbalance='$agentopeningbalance',poundopeningbalance='$poundopeningbalance',show_online='$show_online' where agentid='$agentid'";
//echo $sql;
    $Result= safe_query($sql);
  display_message( "<b><p align=center>Corresponding Agent information has been successfully updated</p>");
  $querystatus="done";

   }
   else
   {
   display_message( "<font color=red><p align=center>Error: There is a problem.The Corresponding Agent information has not been updated.Please try again</p>");
   $querystatus="notdone";
   }
 return $querystatus;
}



function getagentlists($name,$selected){
    $temp   = "<select size=1 name=".$name.">";
    $sql    = "select agentref,agentname from agent_master where agenttype='Agent' and agentstatus='Active' order by agentname ASC"; // folders of the user
       $temp        = $temp."<option value='' >SELECT ONE</option>";
     $temp        = $temp."<option value='Admin'>Admin</option>";
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result)) {
        $agentname  = (isset($row['agentname'])) ? $row['agentname'] : 0;
        $agentref    = (isset($row['agentref'])) ? $row['agentref'] : 0;
        if($selected==$agentref)
            $temp        = $temp."<option value='".$agentref."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentref."'>".$agentname."</option>";
    }
    $temp = $temp."</select>";
    return($temp);
}
function getagentnames($name,$selected,$show_all=false)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select agentname,agentid from agent_master where agentstatus='Active' and agenttype!='collectionpoint'";
	$sql    =$sql."  order by agentname  ASC "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	 
	if($show_all)
	{
		
     if($selected=="ALL")
		{
			$all_selected="selected";
		}
		 $temp        = $temp."<option value='ALL' ".$all_selected.">ALL</option>";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}


function getloginofficenames($name,$selected,$show_all=false)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select agentname,agentid from agent_master where agentstatus='Active' and agenttype!='collectionpoint'";
	$sql    =$sql."  order by agentname  ASC "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	 
	if($show_all)
	{
		
     if($selected=="ALL")
		{
			$all_selected="selected";
		}
		 $temp        = $temp."<option value='ALL' ".$all_selected.">ALL</option>";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


		$sql    = "select agentname,agentid from payingagent_master ";
		$sql    =$sql."  order by agentname  ASC "; // folders of the user
		 
	 $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }



    $temp = $temp."</select>";
    return($temp);
}

function getagentonlynames($name,$selected,$show_all=false)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select agentname,agentid from agent_master where agenttype!='collectionpoint'  and agentstatus='Active' ";
	$sql    =$sql."  order by agentname  ASC "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	 
	if($show_all)
	{
		
     if($selected=="ALL")
		{
			$all_selected="selected";
		}
		 $temp        = $temp."<option value='ALL' ".$all_selected.">ALL</option>";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getagentonlydropdown($name,$agent_name)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select agentname,agentid from agent_master where agenttype!='collectionpoint' and agentid='$agent_name'  and agentstatus='Active' ";
	$sql    =$sql."  order by agentname  ASC "; // folders of the user
	 $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

           $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
        
    }


    $temp = $temp."</select>";
    return($temp);
}

function getreportusernames($name,$selected,$show_all=false)
{
	global $reportrights;
	global $agentid;

    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select username,userid from user_master where is_payingagent = 'N' ";
	if($reportrights != "Y")
	{
	$sql    =$sql." and useroffice ='$agentid'";
	}
	$sql    =$sql."  order by username  ASC "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	 
	if($show_all)
	{
		
     if($selected=="ALL")
		{
			$all_selected="selected";
		}
		 $temp        = $temp."<option value='ALL' ".$all_selected.">ALL</option>";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $username   = (isset($row['username'])) ? $row['username'] : 0;
             $userid   = (isset($row['userid'])) ? $row['userid'] : 0;

        if($selected==$userid)
            $temp        = $temp."<option value='".$userid."' selected>".$username."</option>";
        else
            $temp        = $temp."<option value='".$userid."'>".$username."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getordercollectionpoints($name,$selected,$country,$state="",$city="",$collectionname="",$javascript="",$payingagent)
{
    $temp   = "<select name=".$name." style=\"background-color:#EAEAEA; font-size:10px;border-style: solid\" ".$javascript.">";
	$temp        = $temp."<option value='' >--Choose one--</option>";
   global $userrole;
	global $superuserrights;
	if($userrole == "Administrator")
	{
		$sql    = "select a.agentaddress,a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agenttype='collectionpoint'  and payingagent='$payingagent'"; 
	}
	else
	{
	$sql    = "select a.agentaddress,a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and b.agentstatus='Active' and a.agenttype='collectionpoint'  and a.agentstatus='Active'  and payingagent='$payingagent'"; 
	}
	// folders of the user
	$collectionname = strtolower($collectionname);
	if($country!='')
	{
		$sql    = $sql." and a.country='$country' ";
	}
	if($state!='')
	{
		$sql    = $sql." and a.state='$state' ";
	}
	if($city!='')
	{
		$sql    = $sql." and a.city='$city' ";
	}
	if($collectionname!='')
	{
		$sql    = $sql." and lower(a.agentname) like '%$collectionname%' ";
	}
		$sql    = $sql." order by a.agentname ASC"; // folders of the user
  //  echo $sql; 
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentaddress   = (isset($row['agentaddress'])) ? $row['agentaddress'] : "";
		   $agentname   = (isset($row['agentname'])) ? $row['agentname'] : "";
             $agentid1   = (isset($row['agentid'])) ? $row['agentid'] : 0;
			  $is_default   = (isset($row['is_default'])) ? $row['is_default'] : 0;

        if($selected==$agentid1)
            $temp        = $temp."<option value='".$agentid1."' selected>".$agentname."-".$agentaddress."</option>";
       	else
            $temp        = $temp."<option value='".$agentid1."'>".$agentname."-".$agentaddress."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getupdateordercollectionpoints($name,$selected,$country,$state="",$city="",$collectionname="",$javascript="")
{
    $temp   = "<select name=".$name." style=\"background-color:#EAEAEA; border-style: solid\" ".$javascript.">";
	$temp        = $temp."<option value='' >--Choose one--</option>";
   global $userrole;
	global $superuserrights;
	if($userrole == "Administrator")
	{
	$sql    = "select a.agentaddress,a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agenttype='collectionpoint' "; 
	}
	else
	{
	$sql    = "select a.agentaddress,a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and b.agentstatus='Active' and a.agenttype='collectionpoint'  and a.agentstatus='Active' "; 
	}
	// folders of the user
	$collectionname = strtolower($collectionname);
	if($country!='')
	{
		$sql    = $sql." and a.country='$country' ";
	}
	if($state!='')
	{
		$sql    = $sql." and a.state='$state' ";
	}
	if($city!='')
	{
		$sql    = $sql." and a.city='$city' ";
	}
	if($collectionname!='')
	{
		$sql    = $sql." and lower(a.agentname) like '%$collectionname%' ";
	}
		$sql    = $sql." order by a.agentname ASC"; // folders of the user
  //  echo $sql; 
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentaddress   = (isset($row['agentaddress'])) ? $row['agentaddress'] : 0;
		   $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;
			  $is_default   = (isset($row['is_default'])) ? $row['is_default'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."-".$agentaddress."</option>";
       	else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."-".$agentaddress."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getcollectionpoints($name,$selected,$country,$state="",$city="")
{
    $temp   = "<select name=".$name." style=\"background-color:#EAEAEA; border-style: solid\" >";
	$temp        = $temp."<option value='' >--Choose one--</option>";
    
	global $userrole;
	global $superuserrights;
	if($userrole == "Administrator")
	{
	$sql    = "select a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agenttype='collectionpoint' "; 
	}
	else
	{
		$sql    = "select a.agentname,a.agentid,a.is_default from agent_master a,payingagent_master b where a.payingagent = b.agentid and b.agentstatus='Active' and a.agenttype='collectionpoint'  and a.agentstatus='Active' "; 
	}
	
	// folders of the user
	if($country!='')
	{
		$sql    = $sql." and a.country='$country' ";
	}
	if($state!='')
	{
		$sql    = $sql." and a.state='$state' ";
	}
	if($city!='')
	{
		$sql    = $sql." and a.city='$city' ";
	}
		$sql    = $sql." order by a.agentname ASC"; // folders of the user
     
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;
			  $is_default   = (isset($row['is_default'])) ? $row['is_default'] : 0;

        if($selected == $agentid)
	 {
		$selected_string = " selected ";
	 }
	 elseif($is_default=="Y")
	 {
		 $selected_string = " selected  ";
	 }
	 else
	 {
		 $selected_string = "  ";
	 }

         $temp        = $temp."<option value='".$agentid."' ".$selected_string.">".$agentname."</option>";
       
    }


    $temp = $temp."</select>";
    return($temp);
}


function getcollectionnames($name,$selected,$country,$state="",$city="",$javascript="",$payingagent)
{
    $temp   = "<select name=".$name." style=\"background-color:#EAEAEA; border-style: solid\" ".$javascript.">";
	$temp        = $temp."<option value='' >--Choose one--</option>";
    global $userrole;
	global $superuserrights;
	if($userrole == "Administrator")
	{
	$sql    = "select distinct a.agentname from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agenttype='collectionpoint' and payingagent='$payingagent' ";
	}
	else
	{
	 $sql    = "select distinct a.agentname from agent_master a,payingagent_master b where a.payingagent = b.agentid and b.agentstatus='Active' and a.agenttype='collectionpoint'  and a.agentstatus='Active'  and payingagent='$payingagent'";
	}
	// folders of the user
	if($country!='')
	{
		$sql    = $sql." and a.country='$country' ";
	}
	if($state!='')
	{
		$sql    = $sql." and a.state='$state' ";
	}
	if($city!='')
	{
		$sql    = $sql." and a.city='$city' ";
	}
		$sql    = $sql." order by a.agentname ASC"; // folders of the user
     
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
        	
        if($selected==$agentname)
            $temp        = $temp."<option value='".$agentname."' selected>".$agentname."</option>";
       else
            $temp        = $temp."<option value='".$agentname."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getpayingagents($name,$selected,$country,$javascript="",$show_onlineonly = false,$pagename="")
{
   
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\"  ".$javascript.">";
	 if($pagename=="View_Corresponding_Agent_Payments")
        $temp        = $temp."<option value='' >ALL</option>";
         
         else
        $temp        = $temp."<option value='' >SELECT ONE</option>";
         
	global $userrole;
	global $superuserrights;
	if($userrole == "Administrator")
	{
	$sql    = "select agentname,agentid from payingagent_master where agentid is not null "; // folders of the user
	}
	else
	{
    $sql    = "select agentname,agentid from payingagent_master where agentstatus='Active' "; // folders of the user
	}
	if($show_onlineonly)
	{
	$sql    = $sql." and show_online='Y' ";
	}
	if($country!='')
	{
		$sql    = $sql." and country='$country' ";
	}
		$sql    = $sql." order by agentname ASC"; // folders of the user
     
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;
			 
        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
       else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getpayingagentname($agentid)
{
 $sql    = "select agentname from payingagent_master where agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
 }
    return($agentname);
}

function getreportcollectionpoints($name,$selected,$country)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select agentname,agentid,is_default from agent_master where agenttype='collectionpoint'  and agentstatus='Active' "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	
	if($country!='')
	{
		$sql    = $sql." and country='$country' ";
	}
		$sql    = $sql." order by agentname ASC"; // folders of the user
     
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;
			  $is_default   = (isset($row['is_default'])) ? $row['is_default'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option value='".$agentid."' selected>".$agentname."</option>";
       else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

?>
