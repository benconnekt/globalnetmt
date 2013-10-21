<?php
  session_start();
   include('inc_header1.php');

$today = getdate();
$month = $today['month'];
$mday = $today['mday'];
$year = $today['year'];
 ?>
 <?php

  if (isset($_SESSION["MM_UserAuthorization1"]))
{
$username=$_SESSION["MM_Username1"];
$userid=getuserid($username);
 $loginstatus="User logged:<font color=darkblue>".$_SESSION["MM_Username1"]."</font>";
}
$datetoday = date("Y/m/d");
$Getsaleid=0;
if(isset($_POST['saleid'])!="")
   {
   $Getsaleid=$_POST['saleid'];
   }
   else
   {
    $Getsaleid=$_GET['saleid'];
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<title>Global Nett MT</title>
<LINK href="printstyle.css" rel=stylesheet type=text/css>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
</head>
<script language="javascript1.2">

function printnow()
 {
   window.print();
}

</script>
<body style="margin:0px" >
  
 
 <?
 //echo $_POST['orderselections'];
 if(strlen($_POST['orderselections']))
   {
	   $orders_array = explode(",",$_POST['orderselections']);
   }

   else
   {
	   $orders_array = array($Getsaleid);
   }

  // print_r($orders_array);
  $line =0;
   foreach($orders_array as $Getsaleid)
   {
	   
	   if(count($orders_array)>1 && $line>0)
		 {
			 echo "<div style=\"page-break-before:always\">&nbsp;</div>";
		 }
		 $line++;
   
       if($Getsaleid!="")
   {
     $sql            = "select * from sales_master  where saleid='$Getsaleid'";
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
	$orderid=$row['orderid'];
	$contactid=$row['contactid'];
	$benid=$row['benid'];
	$currency=$row['currency'];
	$collectiontype=$row['collectiontype'];
	$collectionofficeid=$row['collectionofficeid'];
	$bankname=$row['bankname'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$accounttype=$row['accounttype'];
	$sortcode=$row['sortcode'];
	$benamount=$row['benamount'];
	$exchangerate=$row['exchangerate'];
	$orderamount=$row['orderamount'];
	$orderstatus=$row['orderstatus'];
	$officeid=$row['officeid'];
	$agentcommissionamount=$row['agentcommission'];
	$orderby=$row['orderby'];
	$instructions=$row['instructions'];
	$orderdate=$row['orderdate'];
	$processby=$row['processby'];
	$processdate=$row['processdate'];
	$paymenttype=$row['paymenttype'];
	$idno=$row['idno'];
	$bencountry=getbencountry($benid);
	$collectiontype=$row['collectiontype'];
	$payingagent=$row['payingagent'];
	$ordertime = $row['ordertime'];
	$depositbankname = $row['depositbankname'];
	$pickupidothers=$row['pickupidothers'];
	$sourceoffunds=$row['sourceoffunds'];
	$purposeoftransfer=$row['purposeoftransfer'];
	$agentbankcharges=$row['agentbankcharges'];
}

 

     for($repeat=0;$repeat<=1;$repeat++)
	  {
 ?>
	  <table id="AutoNumber1" style="BORDER-COLLAPSE: collapse" borderColor="#111111" height="1" cellPadding="2" width="100%"  border="0">
      <tr>
    <td width="33%" valign="top"><img src="images/resizedprintlogo.jpg" border="0"></td>
	<td width="33%" valign=middle align="center"><b><? echo ($repeat==0)?"CUSTOMER COPY":"OFFICE COPY"?></b></td>
    <td width="33%" align="right" valign="top">GlobalNett Remit <br>72A LEE HIGH ROAD, LONDON. SE13 5PT 
<br>Phone: +442083185860&nbsp;
</td>
  </tr>
      </table>
   <table border="0" cellpadding="2" cellspacing="2" width="100%">
   
	<tr><td width="100%" valign=top align="center">

   <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width=100% id="AutoNumber1">
  
   <tr>
    <td width="25%">Transaction Code*</td><td width="25%"><b><?PHP ECHO $orderid?></b></td>
     <td width="25%">Date</td><td width="25%"><?php echo changeddate($orderdate)?> <? echo $ordertime?></td>
  </tr>
  <tr>
    <td width="25%">Customer ID</td><td width="25%"><?PHP ECHO getcustomeridno($contactid)?></td>
     <td width="25%">Others</td><td width="25%"><?php echo $idno?></td>
  </tr>
 </table><br>
 <table border="0" cellpadding="2" cellspacing="2" style="border-collapse: collapse" bordercolor="#111111" width=100%  id="AutoNumber1">

    <tr>
    <td width="50%" ALIGN=CENTER valign=top>
 <table border="0" cellpadding="0" ALIGN=CENTER style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">
     <tr>
    <td width="100%" valign="top" colspan="2"><b>CUSTOMER DETAILS</b></td>
  </tr>
   <? echo getcustomerdetailsfororder($contactid)?>
    <tr>
    <td width="100%" valign="top" colspan="2"><br/><b>BENEFICIARY DETAILS</b></td>
  </tr>
  <? echo getbeneficiarydetailsfororder($benid)?>
 <tr>
    <td width="50%" valign="top">Payment Type</td>
    <td width="50%" valign="top"><?php echo $paymenttype?></td>
  </tr>
   <tr>
    <td width="50%" valign="top">Deposit Bank Name</td>
    <td width="50%" valign="top"><?php echo $depositbankname?></td>
  </tr>
 
 
  </table>
  </td>

    <td width="50%" ALIGN=CENTER valign=top>
    <table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">


  <tr>
    <td width="100%" valign="top" colspan="2"><b>COLLECTION POINT DETAILS*</b></td>
  </tr>
  <? 
	  if($collectiontype =='Bank')
		  {
	 // echo getpayingagentdetailsfororder($payingagent);
	  echo "<tr><td width=100% valign=top colspan=2>N/A</td></tr>";
		  } else
		  {
			   echo getcollectiondetailsfororder($collectionofficeid);
		  }?>
    <?  if($collectiontype =='Bank')
		  {?>
   <tr>
    <td width="100%" valign="top" colspan="2"><b>BANK DETAILS*</b></td>
  </tr>
  <? echo getbankdetailsfororder($Getsaleid)?>
    
	<? } ?>
	 <tr>
    <td width="50%" valign="top">Pickup Time:</td>
	<td width="50%" valign="top"><? echo $pickupidothers?></td>
  </tr>
    </table><br/>
	<table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">

    <tr>
    <td width="100%" valign="top" colspan="2"><b>ORDER DETAILS </b></td>
  </tr>
     <tr>
    <td width="50%" valign="top">Sent Amount</td>
    <td width="50%" valign="top"><b><font size=2><?php echo number_format(round($orderamount,2),2)?></font></b></td>
  </tr>
   <tr>
    <td width="50%" valign="top">Commission Paid</td>
    <td width="50%" valign="top"><?php echo number_format(round($agentcommissionamount,2),2)?></td>
  </tr>
  <tr>
    <td width="50%" valign="top">Bank Charges</td>
    <td width="50%" valign="top"><?php echo number_format(round($agentbankcharges,2),2)?></td>
  </tr>
      <tr>
    <td width="50%" valign="top">Total</td>
    <td width="50%" valign="top"><b><font size=2><?php echo number_format(round(($orderamount+$agentcommissionamount+$agentbankcharges),2),2)?></font></b></td>
  </tr>
    
  <tr>
    <td width="50%" valign="top">Rate</td>
    <td width="50%" valign="top"><?php echo $exchangerate?></td>
  </tr>
    <tr>
    <td width="50%" valign="top">Beneficiary Amount*</td>
    <td width="50%" valign="top"><b><font size=2>&#8358;<?php echo number_format(round($benamount,2),2)?></font></b></td>
  </tr>
   <tr>
    <td width="50%" valign="top">Source of Funds for Transfer</td>
    <td width="50%" valign="top"><?php echo $sourceoffunds?></td>
  </tr>
 
  <tr>
    <td width="50%" valign="top">Purpose of Transfer</td>
    <td width="50%" valign="top"><?php echo $purposeoftransfer?></td>
  </tr>
 
  </table>
    </td>
    </tr>	
	 <tr>
    <td width="100%" ALIGN=CENTER valign=top colspan="2">
	 <table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">
  <tr>
    <td width="100%" valign="top" colspan="2"><b>BRANCH/AGENT OFFICE DETAILS</b></td>
  </tr>
  <? echo getofficedetailsfororder($officeid)?>
   <tr>
   </table>
	</td>	
  </tr>
    </table>  
    <table border="0" cellpadding="1" cellspacing="1" width="100%">
   <tr>
    <td width="100%" class=text  valign=top colspan=2><font size=1>I/We hereby declare that the money paid to you by me/us was or is not derived or obtained by me/us by any illegal means or transactions including but not limited to any unlawful drug dealings.</font></td> </tr>
  
  <tr>
    <td width="50%"  valign=top ><br/>Customer Signature&nbsp;&nbsp; ________________________________ </td>
	 <td width="50%"  valign=top ><br/>Agent/Staff Signature&nbsp;&nbsp;  ________________________________ </td>
	</tr>
	<tr>
	<td width="100%"  valign=top colspan=2 >
	<font size=1>Thank you, we will be happy to serve you in the next visit. Identification required for transaction above �600.00.<br/><U>Money Service Number: 12214386&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>www.globalnett.co.uk</b></U></div></font></td>
	</tr>		
	</table>
	</td>
	</tr>
	</table><hr size=2> 
<?}?>

 <script language=javascript>
// print();
 </script>
 <? }
 else
 {
display_message("No record found for the order");
} ?>

<? } 

 ?>
</form>


