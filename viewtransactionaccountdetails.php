<?  session_start();
$userrole=$_SESSION["MM_USERROLE"];
$agentref=$_SESSION["MM_AGENTREF"];
$agentid=$_SESSION["MM_AGENTID"];
   include('inc_header.php');
 if($_POST['orderid']!='')
  {
 $orderid= $_POST['orderid'];
  }
  elseif($_GET['orderid']!='')
  {
 $orderid= $_GET['orderid'];
  }
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style.css" type=text/css rel=stylesheet>
<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
<title>Transaction Account Statement - Saajan Money Transfer</title>
<style type="text/css">
<!--

.style3 {
        font-family: verdana, arial, helvetica, sans-serif;
        font-size: 11px;
}
.style5 {font-family: verdana, arial, helvetica, sans-serif}
.style23 {font-family: verdana, arial, helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style_2 {font-family: verdana, arial, helvetica, sans-serif; font-size: 9px; }
.style_3 {font-size: 1px}
-->

</style>
<form name="contactform" action="viewtransactionaccountdetails.php" method="post">
<input type=hidden name=displayPageNo value="<?php echo $displayPageNo?>">
<input Type="hidden" name="dataOrder" value="<?php echo $dataOrder?>">
<input Type="hidden" name="pageAction" value="">
<input Type="hidden" name="txtsearch" value="<?php echo $txtsearch?>">
<input Type="hidden" name="option" value="<?php echo $option?>">
<input type=hidden name=status value="<?php echo base64_encode('viewsdn')?>">
 <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td class="TableHeader">Transaction Account Statement</span></td>
                    </tr>
                    <tr>
                      <td class="Row">
<?  
if($userrole == "Administrator")
{
$ordersql    = "select forex_orders.forexid,forex_orders.saleid from forex_orders,sales_master where forex_orders.saleid = sales_master.saleid and sales_master.orderid='$orderid'";
}
//echo $ordersql;
$orderResult = safe_query($ordersql) ;
  while ($orderrow      = mysql_fetch_array($orderResult))
     {
 $forexid     = (isset($orderrow['forexid'])) ? $orderrow['forexid'] : 0;
 $saleid     = (isset($orderrow['saleid'])) ? $orderrow['saleid'] : 0;
 $querypaymentid = $forexid;

 $reports_rows = array();
 					
$sql    = "select agentamount,paymentid from agentpayments where paymentid='$querypaymentid'"; // folders of the user
//echo $sql;
$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
   $paymentid     = (isset($row['paymentid'])) ? $row['paymentid'] : 0;
   $agentamount      = (isset($row['agentamount'])) ? $row['agentamount'] : "";
   $toamount = ($agentamount);
 
}
?>
 

<table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">
<td width="10%" class="TableHeader"><b>ID</B></td>
   <td width="10%" class="TableHeader"><b>Date</B></td>
      <td width="10%" class="TableHeader"><b>Corresponding Agent Name</B></td>
	  <td width="10%" class="TableHeader"><b>Payment Type</B></td>
      <td width="5%" class="TableHeader"><b>Amount</B></td>
	   <td width="5%" class="TableHeader"><b>Currency</B></td>
	    <td width="10%" class="TableHeader"><b>Buying Rate</B></td>
		<td width="10%" class="TableHeader"><b>Brokers Rate</B></td>
		<td width="10%" class="TableHeader"><b>Amount in GBP</B></td>
		<td width="10%" class="TableHeader"><b>Broker Amount in GBP</B></td>
		 <td width="10%" class="TableHeader"><b>Bank</B></td>
	  <td width="20%" class="TableHeader"><b>Reference</B></td>
	  <td width="10%" class="TableHeader"><b>Sold Amount</B></td>
	  <td width="10%" class="TableHeader"><b>Balance</B></td>
	  </tr>
  </thead>
  <tbody>
 <?  
					
$sql            = "select * from agentpayments where paymentid='$paymentid'"; // folders of the user
//echo $sql;
$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
  $payingagent     = (isset($row['payingagent'])) ? $row['payingagent'] : 0;
   $paymentid     = (isset($row['paymentid'])) ? $row['paymentid'] : 0;
   $agentamount      = (isset($row['agentamount'])) ? $row['agentamount'] : "";
  $paymentdate        = (isset($row['paymentdate'])) ? $row['paymentdate'] : "";
   $paymenttype        = (isset($row['paymenttype'])) ? $row['paymenttype'] : "";
   $currency        = (isset($row['currency'])) ? $row['currency'] : "";
   $buyingexchangerate        = (isset($row['exchangerate'])) ? $row['exchangerate'] : "";
   $bankname        = (isset($row['bankname'])) ? $row['bankname'] : "";
   $accountname        = (isset($row['accountname'])) ? $row['accountname'] : "";
   $accountno        = (isset($row['accountno'])) ? $row['accountno'] : "";
   $sortcode        = (isset($row['sortcode'])) ? $row['sortcode'] : "";
   $reference        = (isset($row['reference'])) ? $row['reference'] : "";
   $description        = (isset($row['description'])) ? $row['description'] : "";
   $brokerrate        = (isset($row['brokerrate'])) ? $row['brokerrate'] : "";
    if($exchangerate>0)
		 {
   $poundamount = round($agentamount/$exchangerate,2);
		 }
   if($brokerrate>0)
		 {
 $brokerpoundamount = round($agentamount/$brokerrate,2);
		 }
$soldamount = getsoldamountbyforexid($paymentid);
$balanceamount = $agentamount-$soldamount;

?>
 
 
  <tr>
     <td class="Row"  ><?php echo "CPM".$paymentid;?></td>
  <td class="Row"  ><?php echo changeddate($paymentdate)?></td>
	 <td class="Row"  ><?php echo getpayingagentname($payingagent)?></td>
	   <td class="Row"  ><?php echo ($paymenttype)?></td>
     <td class="Row"  ><?php echo number_format(round($agentamount,2), 2, '.', '')?></td>
	      <td class="Row"  ><?php echo getcurrencyname($currency)?></td>
		      <td class="Row"  ><?php echo number_format($buyingexchangerate,2)?></td>
			   <td class="Row"  ><?php echo number_format($brokerrate,2)?></td>
			  <td class="Row"  >£<?php echo number_format($poundamount,2)?></td>
			  <td class="Row"  >£<?php echo number_format($brokerpoundamount,2)?></td>
			  <td class="Row"  ><?php echo ($bankname)?></td>
			  <td class="Row"  ><?php echo ($reference)?></td>
			   <td class="Row"  ><?php echo number_format(round($soldamount,2), 2, '.', '')?></td>
			   <td class="Row"  ><?php echo number_format(round($balanceamount,2), 2, '.', '')?></td>
			   </tr>

<? } ?>
  </tfoot>
  </table>
</td>
</tr>
</table>
			<BR>

 <?

 $DISP_REC_COUNT = 50;  // No of rows appearing per page
 $displayPageNo  = (isset($displayPageNo)) ? $displayPageNo : 1;
 $dataOrder      = isset($dataOrder)?$dataOrder:"a.orderid desc";
 $temp = "";
   $sql            = "select fo.benamount as orderbenamount,fo.forexprofit,fo.localforexprofit,fo.brokerprofit,fo.brokerlocalprofit,a.benamount,d.username as username,a.orderdate as orderdate,a.orderstatus as orderstatus,a.exchangerate as orderexchangerate,a.orderby,a.ordercountry as country,concat(c.firstname,' ',c.surname) as customername,b.firstname as beneficiaryname,a.orderid as orderid,a.orderamount as orderamount,a.agentcommission as agentcommission,a.commission1 as commission1,a.collectiontype as ordertype from sales_master a,ben_master b,contact_master c,forex_orders fo left join user_master d on d.userid=a.orderby where a.contactid=c.contactid and a.benid=b.benid and fo.saleid=a.saleid and fo.forexid ='$querypaymentid' and fo.benamount>0";
   $temp           = $temp."  order by ".$dataOrder;
  $sql            = $sql.$temp; 
  $reportquery = $sql;
 //echo $sql;
  $Result         = safe_query($sql) ;
  while ($row = mysql_fetch_array( $Result))
  {
	$reports_rows[] = $row;
  }
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned

  
  
  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="100%" colspan=20>
  <b> Currently there are no transactions in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
            <td width="3%" class="TableHeader"><b>S No</b></td>
            <td width="7%" class="TableHeader"><b>Date</b></td>
			<td width="10%" class="TableHeader"><b>Trans Code</b></td>
			<td width="10%" class="TableHeader"><b>Order Amount</b></td>
			<td width="12%" class="TableHeader"><b>Sold Exch Rate</b></td>
			<td width="12%" class="TableHeader"><b>Sold Amount</b></td>
			<td width="12%" class="TableHeader"><b>P/L(Local)</b></td>
			<td width="12%" class="TableHeader"><b>P/L(£)</b></td>
			<td width="12%" class="TableHeader"><b>Broker P/L(Local)</b></td>
			<td width="12%" class="TableHeader"><b>Broker P/L(£)</b></td>
		
			  
 </tr>

  <?
  $i=0;
  $no=0;
  $balamount=0;
  $totalcreditamount =0;
  $totaldebitamount =0;
  $orderprofit=0;

for($i=0;$i<sizeof($reports_rows);$i++) {
	$searchrows=$reports_rows[$i];
	$profit=0;
	$orderdate     = $searchrows['orderdate'];
	$officeid     = $searchrows['officeid'];
	$country     = $searchrows['country'];
	$orderid = $searchrows['orderid'];
	$orderamount = $searchrows['orderamount'];
	$orderexchangerate = $searchrows['orderexchangerate'];
	$agentcommission = $searchrows['agentcommission'];
	$commission1 = $searchrows['commission1'];
	$cashcommission = $searchrows['cashcommission'];
	$exchcommission = $searchrows['exchcommission'];
	$customername = $searchrows['customername'];
	$username = $searchrows['username'];
	$beneficiaryname = $searchrows['beneficiaryname'];
	$description = $searchrows['description'];
	$agentamount = $searchrows['agentamount']; 
	$ordertype = $searchrows['ordertype'];
	$orderstatus = $searchrows['orderstatus'];
	$reference = $searchrows['reference'];
	$paymenttype = $searchrows['paymenttype'];
	$benamount = $searchrows['benamount'];
	$orderprofit = $searchrows['forexprofit'];
	$orderbenamount = $searchrows['orderbenamount'];
	$forexprofit = $searchrows['forexprofit'];
	$localforexprofit = $searchrows['localforexprofit'];
	$brokerlocalprofit = $searchrows['brokerlocalprofit'];
	$brokerprofit = $searchrows['brokerprofit'];

	if(!strlen($username))
	  {
		$username="Website Order";
	  }

    $totalorderamount = $totalorderamount + $orderamount;
	$totalpoundprofitamount = $totalpoundprofitamount + $forexprofit;
	$totallocalprofitamount = $totallocalprofitamount + $localforexprofit;

	$totalsoldamount = $totalsoldamount + $orderbenamount;


	$totalbrokerpoundprofitamount = $totalbrokerpoundprofitamount + $brokerprofit;
	$totalbrokerlocalprofitamount = $totalbrokerlocalprofitamount + $brokerlocalprofit;
	
	 
?>
<tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo ($i+1)?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo number_format($orderamount,2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $orderexchangerate?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo number_format($orderbenamount,2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($localforexprofit),2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap>£<? echo number_format(($forexprofit),2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($brokerlocalprofit),2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap>£<? echo number_format(($brokerprofit),2)?></td>

 </tr>
<? } ?>
   <? 
  } ?>


 
</table>
 <hr>

<? } ?>

</td></tr></table>
   </form>
  
