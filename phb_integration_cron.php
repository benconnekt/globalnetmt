<?php
session_start();
error_reporting(1);
include("inc_header1.php");
include("phpparser.php");
$CorrespID = "1001205286";
$BankPhbID = "082";
$payingagentid="12";
$in_directory = "PHB".$CorrespID."/IN/";
$out_directory = "PHB".$CorrespID."/OUT/";
$old_directory = "PHB".$CorrespID."/OLD/";
//mkdir($in_directory, 0775);
//mkdir($out_directory, 0775);


$datetoday = date("Y-m-d");
$currenttime = date("H:i:s");
$datedmy = date("dmY");
$orders_string_start = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><OrderImport>";
$orders_string = "";

$sql            = "select a.ordertime as ordertime,b.dob as senderdob,b.idno as senderidno,b.idtype as senderidtype,b.issuedby as senderidissuedby,b.expirydate as senderidexpirydate,a.purposeoftransfer,a.sourceoffunds,b.phone as senderphone,b.state as senderstate,b.city as sendercity,b.address as senderaddress,b.postcode as senderpostcode,c.phone as benphone,c.address as benaddress,c.postcode as benpostcode,state.statename,a.pickupidtype,city.cityname,a.instructions,sendcnt.countrycode as sendcountrycode, cnt.countrycode as bencountrycode,a.agentbankcharges,a.depositbankname as depositbankname,a.collectionofficeid,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c left join city_master city on c.city = city.cityid left join state_master state on c.state = state.stateid ,agent_master d,country_master cnt,country_master sendcnt,sales_master a left join forex_orders fo on a.saleid = fo.saleid left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid  where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid and c.country=cnt.countryid  and b.country=sendcnt.countryid and orderstatus='Confirmed' and a.payingagent='".$payingagentid."' and processdate is null";

//echo $sql;
 $Result = safe_query($sql) ;
   $found_orders = false;
while ($row = mysql_fetch_array( $Result))
  {
	  $found_orders= true;

    $i++;
    $no=$no+1;
   $bgcolor       = ($i % 2) ? "Row" : "Row1";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";
	$currency=$row['currency'];
	$saleid=$row['saleid'];
	$benamount=$row['benamount'];
	$bencountrycode=$row['bencountrycode'];
	$instructions=$row['instructions'];
	$sendcountrycode=$row['sendcountrycode'];
	$exchangerate=$row['exchangerate'];
	$orderamount=$row['orderamount'];
	$orderstatus=$row['orderstatus'];
	$officename=$row['officename'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$ordertime=$row['ordertime'];
	$orderid=$row['orderid'];
	$contactid=$row['contactid'];
	$benid=$row['benid'];
	$bankname=$row['bankname'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$collectiontype=$row['collectiontype'];
	$collectionofficeid=$row['collectionofficeid'];
	$cityname=$row['cityname'];
	$agentcommissionamount=$row['agentcommission'];
	$fromcurrency=$row['fromcurrency'];
	$sourceoffunds=$row['sourceoffunds'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$customersurname = $row['customersurname'];
	$customerfirstname = $row['customerfirstname'];
	$beneficiaryname=$row['benfirstname'];
	$payingagentname=$row['payingagentname'];
	$benaddress=$row['benaddress'];
	$benpostcode=$row['benpostcode'];
	$customermobile=$row['customermobile'];
	$beneficiarymobile=$row['beneficiarymobile'];
	$pickupidtype=$row['pickupidtype'];
	$statename=$row['statename'];
	$benphone=$row['benphone'];
	$purposeoftransfer=$row['purposeoftransfer'];
	$depositbankname=$row['depositbankname'];
	$agentbankcharges=$row['agentbankcharges'];

	$senderaddress=$row['senderaddress'];
	$senderpostcode=$row['senderpostcode'];
	$senderstate=$row['senderstate'];
	$sendercity=$row['sendercity'];
	$senderphone=$row['senderphone'];
	$senderidtype=$row['senderidtype'];
	$senderidno=$row['senderidno'];
	$senderidissuedby=$row['senderidissuedby'];
	$senderidexpirydate=$row['senderidexpirydate'];
	$senderdob=$row['senderdob'];

	$paymentaccounttype = (strtolower($collectiontype)=="bank")?2:1;
	$accounttype = "Savings";


$orders_string .="<Order>
		<CorrespID>".$CorrespID."</CorrespID>
		<OrderNo>".$orderid."</OrderNo>
		<BankPhbID>".$BankPhbID."</BankPhbID>
		<SalesDate>".$orderdate."</SalesDate>
		<SalesTime>".$ordertime."</SalesTime>
		<CountryFrom>".$sendcountrycode."</CountryFrom>
		<CountryTo>".$bencountrycode."</CountryTo>
		<BeneQuestion></BeneQuestion>
		<BeneAnswer></BeneAnswer>
		<PmtInstruction>".$instructions."</PmtInstruction>
		<PaymentToBenCurrency>".$currency."</PaymentToBenCurrency>
		<PaymentToBenAmount>".number_format($benamount,2)."</PaymentToBenAmount>
		<PaymentType>".$paymentaccounttype."</PaymentType>
		<AccountNo>".$accountno."</AccountNo>
            <ServiceCharge></ServiceCharge>
		<BankName>".$bankname."</BankName>
		<BankAccType>".$accounttype."</BankAccType>
		<BankCity>".$cityname."</BankCity>
		<BeneID>".$pickupidtype."</BeneID>
		<BeneFirstName>".$beneficiaryname."</BeneFirstName>
		<BeneMiddleName>".$beneficiaryname."</BeneMiddleName>
		<BeneLastName></BeneLastName>
		<BeneCountry>".$bencountrycode."</BeneCountry>
		<BeneState>".$statename."</BeneState>
		<BeneCity>".$cityname."</BeneCity>
		<BeneAddress>".$benaddress."</BeneAddress>
		<BeneZipCode>".$benpostcode."</BeneZipCode>
		<BenePhoneNo>".$benphone." ".$beneficiarymobile."</BenePhoneNo>
		<BeneMessage></BeneMessage>
		<SenderID>CM".$contactid."</SenderID>
		<SenderFirstName>".$customerfirstname."</SenderFirstName>
		<SenderMiddleName></SenderMiddleName>";
		//$orders_string .="<SenderFirstName>SENDER</SenderFirstName>
		//$orders_string .="<SenderMiddleName>".$customersurname."</SenderMiddleName>";
		$orders_string .="<SenderLastName>".$customersurname."</SenderLastName>
		<SenderCountry>".$sendcountrycode."</SenderCountry>
		<SenderState>".$senderstate."</SenderState>
		<SenderCity>".$sendercity."</SenderCity>
		<SenderAddress>".$senderaddress."</SenderAddress>
		<SenderZipCode>".$senderpostcode."</SenderZipCode>
		<SenderPhoneNo>".$senderphone." ".$customermobile."</SenderPhoneNo>
		<TransferReason>".$purposeoftransfer."</TransferReason>
		<SenderIDType>".$senderidtype."</SenderIDType>
		<SenderIDIssuedBy>".$senderidissuedby."</SenderIDIssuedBy>
		<SenderIDNo>".$senderidno."</SenderIDNo>
		<SenderIDExpDate>".$senderidexpirydate."</SenderIDExpDate>
		<SenderTaxID></SenderTaxID>
		<SenderTaxCountry>".$sendcountrycode."</SenderTaxCountry>
		<SenderDateBirth>".$senderdob."</SenderDateBirth>
		<SenderOccupation></SenderOccupation>
		<SenderSourceFunds>".$sourceoffunds."</SenderSourceFunds>
	</Order>";
	

	$updateSQL = "update sales_master set processdate='$datetoday',processtime='$currenttime',statuscodedesc='Order sent to PHB' where orderid='$orderid'";
	// echo $updateSQL;
	$Result1 = mysql_query($updateSQL) or die(mysql_error()); 

  }

$orders_string_end = "</OrderImport>";

$complete_orders_string = $orders_string_start.$orders_string.$orders_string_end;

if($found_orders)
{
write_file($complete_orders_string);
}



$cancellation_orders_string_start = "<?xml version=\"1.0\" encoding=\"utf-8\" ?><CancellationRequest>";
$cancellation_orders_string = "";
$found_cancelled_orders= false;
$sql            = "select a.orderid from sales_master a where orderstatus in ('Cancelled With Commission','Cancelled Without Commission')  and a.payingagent='".$payingagentid."' and processdate is null ";
 $Result = safe_query($sql) ;
   
while ($row = mysql_fetch_array( $Result))
  {
 $found_cancelled_orders = true;
   $orderid=$row['orderid'];
	
$cancellation_orders_string .="<Cancellation>
		<CorrespID>".$CorrespID."</CorrespID>
		<OrderNo>".$orderid."</OrderNo>
	</Cancellation>";
$updateSQL = "update sales_master set processdate='$datetoday',processtime='$currenttime',statuscodedesc='Cancellation sent to PHB' where orderid='$orderid'";
	// echo $updateSQL;
	$Result1 = mysql_query($updateSQL) or die(mysql_error()); 
  }

$cancellation_orders_string_end = "</CancellationRequest>";

$complete_cancellation_orders_string = $cancellation_orders_string_start.$cancellation_orders_string.$cancellation_orders_string_end;
if($found_cancelled_orders)
{
write_cancellation_file($complete_cancellation_orders_string);
}

//reading IN folder files
$documentdir=opendir($in_directory);  
$cancellation_ack_files = array();
$order_ack_files = array();
$order_process_files = array();
while ($file = readdir($documentdir)) { 
	if ($file == "." || $file == "..")
		continue;
	$fileChunks = explode(".", $file);
	if(!is_array($fileChunks))
		continue;
	$ext= $fileChunks[1];
	$filename= $fileChunks[0];
	if(strtolower($ext) != 'xml')
		continue;
	//echo "the ext is ".$ext;
	
    $fileParts = explode("_", $filename);
	if(!is_array($fileParts))
		continue;
	//print_r($fileParts);
//	echo substr($fileParts[2],0,8)."<br>";

	if($fileParts[0] == "OrderAck" && $fileParts[1] == $BankPhbID && substr($fileParts[2],0,8) == $datedmy)
	{
	//	echo "inside".$file;
		$order_ack_files[]  = $file;
	}
	elseif($fileParts[0] == "CancellationAck" && $fileParts[1] == $BankPhbID && substr($fileParts[2],0,8) == $datedmy)
	{
		$cancellation_ack_files[]  = $file;
	}
	elseif($fileParts[0] == "OrderStatusNotifications" && $fileParts[1] == $BankPhbID && substr($fileParts[2],0,8) == $datedmy)
	{
		$order_process_files[]  = $file;
	}

}

sort($order_process_files);
sort($order_ack_files);
sort($cancellation_ack_files);

//print_r($cancellation_ack_files);
//print_r($order_process_files);
//print_r($order_ack_files);
foreach($cancellation_ack_files as $file)
{
$cancellation_ack_array = parseXML($in_directory.$file);
$status_details = array();
$ack_details = array();
$status_details[] = $cancellation_ack_array['CancellationRequestAcknowledgement']['CancellationAcknowledgement'];
		for($j=0;$j<count($status_details);$j++)
		{
			$ack_details[] = $status_details[$j];
		
		for($k=0;$k<count($ack_details);$k++)
			{		
			$process_details = $ack_details[$k];
			//print_r($process_details);
			if(!is_array($process_details))
				continue;
			$processdate = $process_details['ProcessDate'];
			$formatted_processdate = substr($processdate,0,4)."-".substr($processdate,4,2)."-".substr($processdate,6,2);
			$processtime = $process_details['ProcessTime'];
			$formatted_processtime = substr($processtime,0,2).":".substr($processtime,2,2).":".substr($processtime,4,2);
			$statuscodedesc = $process_details['NotificationCode']."-".$process_details['NotificationDesc'];
			$orderid = $process_details['OrderNo'];		 
			$updateSQL = "update sales_master set processdate='$formatted_processdate',processtime='$formatted_processtime',statuscodedesc='$statuscodedesc' where orderid='$orderid'";
		 // echo $updateSQL;
		 $Result1 = mysql_query($updateSQL) or die(mysql_error()); 
			}
		}
}

foreach($order_ack_files as $file)
{
$order_acks_array = parseXML($in_directory.$file);
//print_r($order_acks_array);
$ack_details = array();
$status_details = array();
$status_details[] = $order_acks_array['OrderImportAcknowledgement']['ImportAcknowledgement'];
//print_r($status_details);
		for($j=0;$j<count($status_details);$j++)
		{	
			$ack_details = $status_details[$j];		
			for($k=0;$k<count($ack_details);$k++)
			{
			$process_details = $ack_details[$k];
			//print_r($process_details);
			if(!is_array($process_details))
				continue;
			$processdate = $process_details['ProcessDate'];
			//$formatted_processdate = substr($processdate,0,4)."-".substr($processdate,5,2)."-".substr($processdate,8,2);
			//$processtime = $process_details['ProcessTime'];
			//$formatted_processtime = substr($processtime,11,2).":".substr($processtime,14,2).":".substr($processtime,17,2);
			$formatted_processdate = substr($processdate,0,4)."-".substr($processdate,4,2)."-".substr($processdate,6,2);
			$processtime = $process_details['ProcessTime'];
			$formatted_processtime = substr($processtime,0,2).":".substr($processtime,2,2).":".substr($processtime,4,2);
			
			$statuscodedesc = $process_details['NotificationCode']."-".$process_details['NotificationDesc'];
			$orderid = $process_details['OrderNo'];		 
			$updateSQL = "update sales_master set processdate='$formatted_processdate',processtime='$formatted_processtime',statuscodedesc='$statuscodedesc' where orderid='$orderid'";
		//  echo $updateSQL."<br>";
		 $Result1 = mysql_query($updateSQL) or die(mysql_error()); 
		
		}
	}
}

foreach($order_process_files as $file)
{
$order_process_array = parseXML($in_directory.$file);
$status_details = array();
$ack_details = array();
$status_details[] = $order_process_array['OrderStatusChangeNotification']['OrderStatusChange'];
		for($j=0;$j<count($status_details);$j++)
		{
			$ack_details = $status_details[$j];
			//print_r($ack_details);
			for($k=0;$k<count($ack_details);$k++)
			{		
				$process_details = $ack_details[$k];
				//print_r($process_details);			
				if(!is_array($process_details))
					continue;
				$orderstatus = "Processed";
				$processdate = $process_details['StatusDate'];
				$formatted_processdate = substr($processdate,0,4)."-".substr($processdate,4,2)."-".substr($processdate,6,2);
				$statuscodedesc = $process_details['StatusCode']."-".$process_details['StatusCodeDesc'];
				if(!is_array($process_details['BenIDType']))
				{
				$beneficiaryidno = $process_details['BenIDType']." ".$process_details['BenIDNo'];
				}
				$orderid = $process_details['OrderNo'];		 
				$updateSQL = "update sales_master set orderstatus='$orderstatus', processdate='$formatted_processdate',beneficiaryidno='$beneficiaryidno',statuscodedesc='$statuscodedesc' where orderid='$orderid'";
			// echo $updateSQL."<br>";
			 $Result1 = mysql_query($updateSQL) or die(mysql_error()); 
			
			}
		}
}

//cleanOldDataInFolders();

function write_file($data)
{
 global $CorrespID;
 global $out_directory;
 global $old_directory;
 $orders_file_name = "OrderImport_".$CorrespID."_".date("Ymd_his").".xml";
 $fp = fopen($out_directory.$orders_file_name, "w");
 fwrite($fp, $data);
 $fp = fopen($old_directory.$orders_file_name, "w");
 fwrite($fp, $data);
 fclose($fp);
 }

 function write_cancellation_file($data)
{
 global $CorrespID;
 global $out_directory;
 global $old_directory;
 $orders_file_name = "CancellationRequest_".$CorrespID."_".date("Ymd_his").".xml";
 $fp = fopen($out_directory.$orders_file_name, "w");
 fwrite($fp, $data);
 $fp = fopen($old_directory.$orders_file_name, "w");
 fwrite($fp, $data);
 fclose($fp);
 }

 function cleanOutFolder() {
                 $ftp_user_name='phb-globalnett';
				 $ftp_user_pass='phbglobal14';
				 $ftp_server='ftp.globalnett.co.uk';
				 $ftp_dir='OUT';
				 $conn_id = ftp_connect($ftp_server); 
				 $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
				 if ($files = ftp_nlist($conn_id,$ftp_dir)){
						foreach ($files as $file) {
						  ftp_delete($conn_id, $file);
						}
					  }
			ftp_close($conn_id);
		}

function cleanOldDataInFolders() {
	global $out_directory;
	global $old_directory;
	global $in_directory;
                 $ftp_user_name='phb-globalnett';
				 $ftp_user_pass='phbglobal14';
				 $ftp_server='ftp.globalnett.co.uk';
				  $conn_id = ftp_connect($ftp_server); 
				 $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
				
				 if ($files = ftp_nlist($conn_id,$in_directory)){
						foreach ($files as $file) {
						  ftp_delete($conn_id, $file);
						}
					  }
				
				if ($files = ftp_nlist($conn_id,$old_directory)){
						foreach ($files as $file) {
						  ftp_delete($conn_id, $file);
						}
					  }
				
			ftp_close($conn_id);
		}

?>
