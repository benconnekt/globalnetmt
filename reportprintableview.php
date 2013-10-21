<?php session_start();
    if($type =='excel')
  {
   header("Content-Type: application/vnd.ms-excel");
   header("Content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=REPORT_EXPORT.xls");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
   include('inc_header.php');
  }
  else
  {	   
	  include('inc_header.php');
	  include("companyheader.html");
	  ?>
	  <script language=javascript>
/**
 * Set browser window size.
 *
 * Created this function based on the getSize() function, added the Safari section.
 *
 */
function setSize(x, y, center_after_resize) {

	// Prevent window from being resized to a size bigger than the screen:
	var max_x = screen.width - 30;
	var max_y = screen.height - 80;
	if(x > max_x) x = max_x;
	if(y > max_y) y = max_y;

	//Safari
	if(navigator.userAgent.indexOf("Safari")!=-1) {
		top.window.resizeTo(x, y);

	//Non-IE
	} else if( typeof( window.innerWidth ) == 'number' ) {
		top.window.innerWidth = x;
		top.window.innerHeight = y;

	//IE 6+ in 'standards compliant mode'
	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {

		// If this function is called from within a frameset, use resizeTo().
		if(top.document.documentElement.clientWidth != document.documentElement.clientWidth) {
			top.window.resizeTo(x, y);
		} else {
			top.document.documentElement.clientWidth = x;
			top.document.documentElement.clientHeight = y;
		}

	//IE 4 compatible:
	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		top.window.resizeTo(x, y);
	}

}

/** Center browser window on screen. */

function getSize(dimension) {

	var myWidth = 0, myHeight = 0;

	//Non-IE
	if( typeof( top.window.innerWidth ) == 'number' ) {
		myWidth = top.window.innerWidth;
		myHeight = top.window.innerHeight;

	//IE 6+ in 'standards compliant mode'
	} else if( top.document.documentElement && ( top.document.documentElement.clientWidth || top.document.documentElement.clientHeight ) ) {
		myWidth = top.document.documentElement.clientWidth;
		myHeight = top.document.documentElement.clientHeight;

	//IE 4 compatible
	} else if( top.document.body && ( top.document.body.clientWidth || top.document.body.clientHeight ) ) {
		myWidth = top.document.body.clientWidth;
		myHeight = top.document.body.clientHeight;
	}

	// Return requested dimension:
	if(dimension == "x" || dimension == "width") return myWidth;
	else return myHeight;
}

</script>
<script language=javascript>
setSize(800, 600, true);
</script>
<body leftmargin="10" topmargin="0" marginwidth="0" marginheight="0" bottommargin=0>
<form name="taskform" action="index.php" method="get">

    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" height="100%" id="AutoNumber2">
      <tr>
        <td width="84%" valign="top">
        <div align="center">
          <center>
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber3">
          <tr>
            <td width="100%">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%">
            <p align="center"><b><font size="2">
			<?
			echo $title. "-";
            echo "".(changeddate($_POST['startsalesdate']));
			echo "-".(changeddate($_POST['endsalesdate']));?>           
         </font></b></td>
          </tr>
          <tr>
            <td width="100%"><hr color="#000000" size="1"></td>
          </tr>
        </table>
          </center>
        </div>
	  <?
  }

   if (isset($_SESSION["MM_Username1"]))
{
$username=$_SESSION["MM_Username1"];
$userid=getuserid($username);
$userrole=getuserrole($username);
$agentid=getagentid($userid);

}
$today = date("d/m/Y");
 $lastmonth= date ("d/m/Y", mktime (0,0,0,date("m")-1,date("d"),  date("Y")));
 $startsalesdate  = (isset($_POST['startsalesdate'])) ? $_POST['startsalesdate'] : $lastmonth;
  $selagent  = (isset($_POST['selagent'])) ? $_POST['selagent'] : $agentid;
 $endsalesdate  = (isset($_POST['endsalesdate'])) ? $_POST['endsalesdate'] : $today;
if(isset($_POST['queryagent'])!="")
   {
   $queryagent=$_POST['queryagent'];
   }
if(isset($_POST['query'])!="")
   {
   $sql=$_POST['query'];
   }
   else
   {
   $sql="";
   }
 $sql = str_replace("\'", "'", $sql);
 if(isset($_POST['bankquery'])!="")
   {
   $banksql=$_POST['bankquery'];
   }
   else
   {
   $banksql="";
   }
 $banksql = str_replace("\'", "'", $banksql);

 if(isset($_POST['paymentquery'])!="")
   {
   $paymentsql=$_POST['paymentquery'];
   }
   else
   {
   $paymentsql="";
   }
 $paymentsql = str_replace("\'", "'", $paymentsql);
   ?>


      <? if($reporttype=='agentcommissionreport')
	  {?>

<?
	$sql1    = "select * from agent_master  where agentid='$queryagent'"; // folders of the user
$Result1 = safe_query($sql1) ;
    while ($row      = mysql_fetch_array( $Result1))
     {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
         
}
?>
 <?

 $startsalesdate = dateConvert($startsalesdate);
 $endsalesdate = dateConvert($endsalesdate);

 $dataOrder      = isset($dataOrder)?$dataOrder:"a.orderdate";
   $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="14%">
  <b> Currently there are no transactions in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
            <td width="5%" class="TableHeader"><b>S No</b></td>
            <td width="12%" class="TableHeader"><b>Date</b></td>
			<td width="12%" class="TableHeader"><b>Country</b></td>
			<td width="12%" class="TableHeader"><b>Trans Code</b></td>
			<td width="12%" class="TableHeader"><b>Send Amount</b></td>
			<td width="12%" class="TableHeader"><b>Bank Charge</b></td>
			<td width="12%" class="TableHeader"><b>Total Comm</b></td>
			<td width="12%" class="TableHeader"><b>Agent Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Agent Comm</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm</b></td>
			  
 </tr>

  <?php

  $i=0;
  $no=0;
  $totalagentcommission=0;
  $totalcompanycommission=0;
   $totalallcommission=0;
  while ($row = mysql_fetch_array( $Result))
  {
$i++;
$orderdate     = (isset($row['orderdate'])) ? $row['orderdate'] : 0;
$country     = (isset($row['country'])) ? $row['country'] : 0;
$orderid = (isset($row['orderid'])) ? $row['orderid'] : "";
$orderamount = (isset($row['orderamount'])) ? $row['orderamount'] : "";
$agentcommission = (isset($row['agentcommission'])) ? $row['agentcommission'] : "";
$agentcommissionamount = (isset($row['commission1'])) ? $row['commission1'] : "";
$agentcommissionpercentage = (isset($row['commpercentage1'])) ? $row['commpercentage1'] : "";
$companycommissionpercentage = 100- $agentcommissionpercentage;
$agentbankcharges = (isset($row['agentbankcharges'])) ? $row['agentbankcharges'] : "";

if($agentcommission<0)
	  {
	$agentcommission=0;
	  }
	    if($agentcommissionamount<0)
	  {
	$agentcommissionamount=0;
	  }
	  if($commission1<0)
	  {
	$commission1=0;
	  }

	 
	$companycommissionamount = $agentcommission-$agentcommissionamount;
    $totalagentcommission = $totalagentcommission + $agentcommissionamount;
	$totalcompanycommission = $totalcompanycommission + $companycommissionamount;
	$totalallcommission = $totalallcommission + $agentcommission;
		$totalbankcharges = $totalbankcharges + $agentbankcharges;


	 
?>
  

  <tr><td class="Row" width="5%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $i?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo getcountryname($country)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($orderamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentbankcharges,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommission,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($agentcommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommissionamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($companycommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($companycommissionamount,2)?></td>
  </tr>
 
   <? 
  } ?>

 <tr><td class="Row" width="2%" bgcolor="<?php echo $bgcolor?>"></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>Totals</b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalbankcharges,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalallcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalagentcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalcompanycommission,2)?></b></td>
  </tr>
  <?
 }?>


</table>

	  <? } elseif($reporttype=='payingagentcommissionreport') { ?>
    
<?$sql1    = "select * from payingagent_master  where agentid='$queryagent'"; // folders of the user
$Result1 = safe_query($sql1) ;
    while ($row      = mysql_fetch_array( $Result1))
     {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
         $commission = (isset($row['commission'])) ? $row['commission'] : "";
		  
}
?>
 <?

 $startsalesdate = dateConvert($startsalesdate);
 $endsalesdate = dateConvert($endsalesdate);
 $dataOrder      = isset($dataOrder)?$dataOrder:"a.orderdate";
 
  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0 )
  { ?>

  <tr>
  <td width="14%">
  <b> Currently there are no transactions in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
            <td width="5%" class="TableHeader"><b>S No</b></td>
            <td width="12%" class="TableHeader"><b>Date</b></td>
			<td width="12%" class="TableHeader"><b>Country</b></td>
			<td width="12%" class="TableHeader"><b>Trans Code</b></td>
			<td width="12%" class="TableHeader"><b>Send Amount</b></td>
			<td width="12%" class="TableHeader"><b>Total Comm</b></td>
			<td width="12%" class="TableHeader"><b>Corresponding Agent Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Corresponding Agent Comm</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm</b></td>
			  
 </tr>

  <?php

  $i=0;
  $no=0;
  $totalagentcommission=0;
  $totalcompanycommission=0;
  $totalallcommission=0;
  while ($row = mysql_fetch_array( $Result))
  {
$i++;
$orderdate     = (isset($row['orderdate'])) ? $row['orderdate'] : 0;
$country     = (isset($row['country'])) ? $row['country'] : 0;
$orderid = (isset($row['orderid'])) ? $row['orderid'] : "";
$orderamount = (isset($row['orderamount'])) ? $row['orderamount'] : "";
$agentcommission = (isset($row['agentcommission'])) ? $row['agentcommission'] : "";
$agentcommissionpercentage = (isset($row['commpercentage2'])) ? $row['commpercentage2'] : "";
$agentcommissionamount = (isset($row['commission2'])) ? $row['commission2'] : "";
$companycommissionpercentage = 100- $agentcommissionpercentage;
if($agentcommission<0)
	  {
	$agentcommission=0;
	  }
	    if($agentcommissionamount<0)
	  {
	$agentcommissionamount=0;
	  }
	  if($agentcommissionamount<0)
	  {
	$agentcommissionamount=0;
	  }

	
	 
	$companycommissionamount = $agentcommission-$agentcommissionamount;
    $totalagentcommission = $totalagentcommission + $agentcommissionamount;
	$totalcompanycommission = $totalcompanycommission + $companycommissionamount;

	 $totalallcommission = $totalallcommission + $agentcommission;
?>
  

  <tr><td class="Row" width="5%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $i?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo getcountryname($country)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($orderamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommission,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($agentcommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommissionamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($companycommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($companycommissionamount,2)?></td>
  </tr>
 
   <? 
  } ?>



 <tr><td class="Row" width="2%" bgcolor="<?php echo $bgcolor?>"></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>Totals</b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalallcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalagentcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalcompanycommission,2)?></b></td>
  </tr>
  <?
 }?>


</table>
 <? } elseif($reporttype=='generalcommissionreport') { ?>
 
 <?
	$startsalesdate = dateConvert($startsalesdate);
 $endsalesdate = dateConvert($endsalesdate);

 $dataOrder      = isset($dataOrder)?$dataOrder:"a.orderdate";
  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="14%">
  <b> Currently there are no transactions in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
            <td width="5%" class="TableHeader"><b>S No</b></td>
            <td width="12%" class="TableHeader"><b>Date</b></td>
			<td width="12%" class="TableHeader"><b>Country</b></td>
			<td width="12%" class="TableHeader"><b>Trans Code</b></td>
			<td width="12%" class="TableHeader"><b>Send Amount</b></td>
			<td width="12%" class="TableHeader"><b>Total Comm</b></td>
			<td width="12%" class="TableHeader"><b>Agent Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Agent Comm</b></td>
			<td width="12%" class="TableHeader"><b>Corresponding Agent Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Corresponding Agent Comm</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm%</b></td>
			<td width="12%" class="TableHeader"><b>Company Comm</b></td>
			  
 </tr>

  <?php

  $i=0;
  $no=0;
  $totalagentcommission=0;
  $totalcompanycommission=0;
 while ($row = mysql_fetch_array( $Result))
  {
$i++;
$orderdate     = (isset($row['orderdate'])) ? $row['orderdate'] : 0;
$payingagent     = (isset($row['payingagent'])) ? $row['payingagent'] : 0;
$collectiontype     = (isset($row['collectiontype'])) ? $row['collectiontype'] : 0;
$collectionofficeid     = (isset($row['collectionofficeid'])) ? $row['collectionofficeid'] : 0;
$officeid     = (isset($row['officeid'])) ? $row['officeid'] : 0;
$orderstatus     = (isset($row['orderstatus'])) ? $row['orderstatus'] : 0;

$country     = (isset($row['country'])) ? $row['country'] : 0;
$orderid = (isset($row['orderid'])) ? $row['orderid'] : "";
$orderamount = (isset($row['orderamount'])) ? $row['orderamount'] : "";
$agentcommission = (isset($row['agentcommission'])) ? $row['agentcommission'] : "";
$agentcommissionamount = (isset($row['agentcommissionamount'])) ? $row['agentcommissionamount'] : "";
$payingagentcommissionamount = (isset($row['payingagentcommissionamount'])) ? $row['payingagentcommissionamount'] : "";
$agentcommissionpercentage = (isset($row['agentcommissionpercentage'])) ? $row['agentcommissionpercentage'] : "";
$payingagentcommissionpercentage = (isset($row['payingagentcommissionpercentage'])) ? $row['payingagentcommissionpercentage'] : "";

if($agentcommission<0)
	  {
	$agentcommission=0;
	  }
	  if($agentcommissionamount<0)
	  {
	$agentcommissionamount=0;
	  }
	  if($payingagentcommissionamount<0)
	  {
	$payingagentcommissionamount=0;
	  }
	  if($orderstatus == 'Processed' || $orderstatus =='Confirmed')
	  {
		  $payingagentcommissionamount = $payingagentcommissionamount;
		  $payingagentcommissionpercentage = $payingagentcommissionpercentage;
	  }
	  else
	  {
		  $payingagentcommissionamount =0;
		  $payingagentcommissionpercentage =0;
	  }
$companycommissionpercentage = 100 - $agentcommissionpercentage - $payingagentcommissionpercentage;
$companycommissionamount = $agentcommission-$agentcommissionamount-$payingagentcommissionamount;

    $totalagentcommission = $totalagentcommission + $agentcommissionamount;
	$totalpayingagentcommission = $totalpayingagentcommission + $payingagentcommissionamount;
	$totalcompanycommission = $totalcompanycommission + $companycommissionamount;
	$totalallcommission = $totalallcommission + $agentcommission;
	 
?>
  

  <tr><td class="Row" width="5%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $i?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo getcountryname($country)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($orderamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommission,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($agentcommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($agentcommissionamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($payingagentcommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($payingagentcommissionamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><? echo number_format($companycommissionpercentage,2)?>%</td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($companycommissionamount,2)?></td>
  </tr>
 
   <? 
  } ?>

 <tr><td class="Row" width="2%" bgcolor="<?php echo $bgcolor?>"></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>Totals</b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"><b>£ <? echo number_format($totalallcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>" nowrap><b>£ <? echo number_format($totalagentcommission,2)?></b></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>" nowrap><b>£ <? echo number_format($totalpayingagentcommission,2)?></b></td>

<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>" nowrap><b>£ <? echo number_format($totalcompanycommission,2)?></b></td>
  </tr>
  <?
 }?>


</table>
  <? } elseif($reporttype=='agentaccountreport') { ?>

 <?

 $startsalesdate = dateConvert($startsalesdate);
 $endsalesdate = dateConvert($endsalesdate);
 $Result         = safe_query($sql) ;
  while ($row = mysql_fetch_array( $Result))
  {
	$reports_rows[] = $row;
  }
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned

   $paymentResult         = safe_query($paymentsql) ;
   while ($row = mysql_fetch_array( $paymentResult))
  {
	$reports_rows[] = $row;
  }
  $noOfpaymentRecords    = @mysql_num_rows($paymentResult); // Total no of records returned

		foreach ($reports_rows as $key => $value) 
		{
		$orderdate[$key] = $value['orderdate'];
		$ordertype[$key] = $value['ordertype'];
		$orderid[$key] = $value['orderid'];
		}
		array_multisort($orderdate, SORT_ASC, $ordertype, SORT_ASC,$orderid,SORT_ASC,$reports_rows);
	


  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0 && $noOfpaymentRecords==0)
  { ?>

  <tr>
  <td width="14%">
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
			<td width="7%" class="TableHeader"><b>Ordered By</b></td>
			<td width="10%" class="TableHeader"><b>Type</b></td>
			<td width="12%" class="TableHeader"><b>Sender Name</b></td>
			<td width="12%" class="TableHeader"><b>Receiver Name</b></td>
			<td width="12%" class="TableHeader"><b>Country</b></td>
			<td width="5%" class="TableHeader"><b>Cash DR</b></td>
			<td width="5%" class="TableHeader"><b>Bank DR</b></td>
			<td width="5%" class="TableHeader"><b>CR</b></td>
			<td width="5%" class="TableHeader"><b>Balance</b></td>
			
			  
 </tr>

  <?php
$startingbalance = totalagentbalancebeforedate($queryagent,$startsalesdate);
  ?>
<tr>
 <td width="10%" colspan=3 align=left class="Row"><b>Starting Balance</b></td>
 <td width="90%" colspan=9 align=right class="Row"><b><? echo number_format($startingbalance,2);?></b></td>
</tr>
  <?
  $i=0;
  $no=0;
  $balanceamount=0;
  $totalcreditamount =0;
  $totaldebitamount =0;
$cashamount=0;
$bankamount=0;
for($i=0;$i<sizeof($reports_rows);$i++) {
	$searchrows=$reports_rows[$i];
	$orderdate     = $searchrows['orderdate'];
	$officeid     = $searchrows['officeid'];
	$country     = $searchrows['country'];
	$orderid = $searchrows['orderid'];
	$orderamount = $searchrows['orderamount'];
	$agentcommission = $searchrows['agentcommission'];
	$customername = $searchrows['customername'];
	$username = $searchrows['username'];
	$beneficiaryname = $searchrows['beneficiaryname'];
	$description = $searchrows['description'];
	$agentamount = $searchrows['agentamount']; 
	$ordertype = $searchrows['ordertype'];
	$orderstatus = $searchrows['orderstatus'];
	$reference = $searchrows['reference'];
	$paymenttype = $searchrows['paymenttype'];
	$depositbankname = $searchrows['depositbankname'];
	$collectiontype = $searchrows['collectiontype'];
 $cashamount=0;
$bankamount=0;
 if($ordertype == 'Payment')
	 {	
/*if($agentamount<0)
	  {
	$agentamount=0;
	  }
*/	
$balanceamount = $balanceamount+$agentamount;
$totalcreditamount = $totalcreditamount + $agentamount;
	 }
	 else
	{

if($orderamount<0)
	  {
	$orderamount=0;
	  }
	 
	 if($agentcommission<0)
	  {
	$agentcommission=0;
	  }

	  if($paymenttype =='Cash')
		{
$totalcashdebitamount = $totalcashdebitamount + $orderamount + $agentcommission;
$cashamount = $orderamount + $agentcommission;
		}
		else
		{
$totalbankdebitamount = $totalbankdebitamount + $orderamount + $agentcommission;
$bankamount = $orderamount + $agentcommission;
		}
$balanceamount = $balanceamount-$orderamount-$agentcommission;
	}
	 
?>
  <? if($ordertype == 'MT')
	 { ?>

  <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo ($i+1)?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo $username?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $paymenttype?> <? echo strlen($depositbankname)?"<br>(".$depositbankname.")":""?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $customername?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $beneficiaryname?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo getcountryname($country)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><?  
	if($paymenttype =='Cash') { 
	echo number_format(($cashamount),2);
}
?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? 
	if($paymenttype !='Cash') { 
	echo number_format(($bankamount),2);
}
?></td>
<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>"></td>

<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startingbalance+$balanceamount,2)?></b></td>


 </tr>
 <? } else { ?>


 <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo ($i+1)?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $reference?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $paymenttype?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($agentamount),2)?></td>

<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startingbalance+$balanceamount,2)?></b></td>


 </tr>
<? } ?>
 
   <? 
  } ?>

 
<?
	$closingbalance = totalagentbalanceafterdate($queryagent,$endsalesdate);
?>
<tr>
 <td width="10%" colspan=3 align=left class="Row"><b>Closing Balance</b></td>
 <td width="90%" colspan=9 align=right class="Row"><b><? echo number_format($startingbalance+$balanceamount+$closingbalance,2);?></b></td>
 </tr>
<tr>
 <td width="70%" colspan=8 align=right class="Row"><b>Totals</b></td>
 <td width="10%" class="Row"><b><font color=red><? echo number_format($totalcashdebitamount,2);?></font></b></td>
 <td width="10%" class="Row"><b><font color=red><? echo number_format($totalbankdebitamount,2);?></font></b></td>
 <td width="10%" colspan=2 class="Row"><b><font color=blue><? echo number_format($totalcreditamount,2);?></font></b></td>
</tr>

  <?
 }?>


</table>
 <? } elseif($reporttype=='payingagentaccountreport') { ?>

<?
$startsalesdate = dateConvert($startsalesdate);
 $endsalesdate = dateConvert($endsalesdate);

 $dataOrder      = isset($dataOrder)?$dataOrder:"a.orderdate";
 
  

  $Result         = safe_query($sql) ;
  while ($row = mysql_fetch_array( $Result))
  {
	$reports_rows[] = $row;
  }
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned

    $paymentResult         = safe_query($paymentsql) ;
  while ($row = mysql_fetch_array( $paymentResult))
  {
	$reports_rows[] = $row;
  }
  $noOfpaymentRecords    = @mysql_num_rows($paymentResult); // Total no of records returned
		
			foreach ($reports_rows as $key => $value) 
		{
		$orderdate[$key] = $value['orderdate'];
		$ordertype[$key] = $value['ordertype'];
		$orderid[$key] = $value['orderid'];
		}
		array_multisort($orderdate, SORT_ASC, $ordertype, SORT_ASC,$orderid, SORT_ASC, $reports_rows);


  ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0 && $noOfpaymentRecords == 0)
  { ?>

  <tr>
  <td width="14%">
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
			<td width="7%" class="TableHeader"><b>Confirmed By</b></td>
			<td width="10%" class="TableHeader"><b>Type</b></td>
			<td width="12%" class="TableHeader"><b>Sender Name</b></td>
			<td width="12%" class="TableHeader"><b>Receiver Name</b></td>
			<td width="12%" class="TableHeader"><b>Country</b></td>
			<td width="5%" class="TableHeader"><b>DR(£)</b></td>
			<td width="5%" class="TableHeader"><b>DR(Local)</b></td>
			<td width="5%" class="TableHeader"><b>CR(£)</b></td>
			<td width="5%" class="TableHeader"><b>CR(Local)</b></td>
			<td width="5%" class="TableHeader"><b>Balance(£)</b></td>
			<td width="5%" class="TableHeader"><b>Balance(Local)</b></td>
			
			  
 </tr>

  <?php
$startingpoundbalance = totalpayingagentbalancebeforedate($queryagent,$startsalesdate);
$startinglocalbalance = totalpayingagentlocalbalancebeforedate($queryagent,$startsalesdate);

  ?>
<tr>
 <td width="10%" colspan=3 align=left class="Row"><b>Starting Balance</b></td>
 <td width="90%" colspan=10 align=right class="Row"><b><? echo number_format($startingpoundbalance,2);?></b></td>
  <td width="90%" colspan=10 align=right class="Row"><b><? echo number_format($startinglocalbalance,2);?></b></td>

</tr>

  <?
  $i=0;
  $no=0;
  $poundbalanceamount=0;
  $localbalanceamount=0;
  $totallocalcreditamount =0;
  $totallocaldebitamount =0;
  $totalcreditamount =0;
  $totaldebitamount =0;
  
 for($i=0;$i<sizeof($reports_rows);$i++) {
	$searchrows=$reports_rows[$i];

$orderdate     = $searchrows['orderdate'];
	$officeid     = $searchrows['officeid'];
	$country     = $searchrows['country'];
	$orderid = $searchrows['orderid'];
	$orderamount = $searchrows['orderamount'];
	$agentcommission = $searchrows['agentcommission'];
	$customername = $searchrows['customername'];
	$username = $searchrows['username'];
	$beneficiaryname = $searchrows['beneficiaryname'];
	$orderstatus = $searchrows['orderstatus'];
	$localamount = $searchrows['localamount'];
	$agentamount = $searchrows['agentamount'];
	$ordertype = $searchrows['ordertype'];
	$reference = $searchrows['reference'];
	$paymenttype = $searchrows['paymenttype'];
	$exchangerate = $searchrows['exchangerate'];
	$poundamount = round(($agentamount/$exchangerate),2);

if($ordertype == 'Payment')
	 {
	/*if($agentamount<0)
	  {
	$agentamount=0;
	  }
	  if($poundamount<0)
	  {
	$poundamount=0;
	  }
	*/
$poundbalanceamount = $poundbalanceamount+$poundamount;
$localbalanceamount = $localbalanceamount+$agentamount;

 $totallocalcreditamount =$totallocalcreditamount + $agentamount;
 $totalcreditamount = $totalcreditamount + $poundamount;
	 }
	 else
	 {


if($orderamount<0)
	  {
	$orderamount=0;
	  }
	 if($localamount<0)
	  {
	$localamount=0;
	  }
	   if($agentcommission<0)
	  {
	$agentcommission=0;
	  }

$poundbalanceamount = $poundbalanceamount-$orderamount-$agentcommission;
$localbalanceamount = $localbalanceamount-$localamount;


 $totallocaldebitamount =$totallocaldebitamount + $localamount;
 $totaldebitamount = $totaldebitamount + $orderamount + $agentcommission;

	 }

	 
?>
   <? if($ordertype == 'MT')
	 { ?>

  <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo ($i+1)?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $orderid?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo $username?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $orderstatus?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $customername?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $beneficiaryname?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo getcountryname($country)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($orderamount+$agentcommission),2)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($localamount),2)?></td>

<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>"></td>


<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startingpoundbalance+$poundbalanceamount,2)?></b></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startinglocalbalance+$localbalanceamount,2)?></b></td>



 </tr>
 
   <? 
  }  else { ?>
  

  <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo ($i+1)?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo changeddate($orderdate)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $reference?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><? echo $paymenttype?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"></td>

<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($poundamount),2)?></td>
<td class="Row" valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><? echo number_format(($agentamount),2)?></td>


<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startingpoundbalance+$poundbalanceamount,2)?></b></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>" nowrap><b><? echo number_format($startinglocalbalance+$localbalanceamount,2)?></b></td>

 </tr>

 <? } }?>

<?
	$closingpoundbalance = totalpayingagentbalanceafterdate($queryagent,$endsalesdate);
	$closinglocalbalance = totalpayingagentlocalbalanceafterdate($queryagent,$endsalesdate);
?>
<tr>
 <td width="10%" colspan=3 align=left class="Row"><b>Closing Balance</b></td>
 <td width="90%" colspan=10 align=right class="Row"><b><? echo number_format($startingpoundbalance+$poundbalanceamount+$closingpoundbalance,2);?></b></td>
  <td width="90%" colspan=10 align=right class="Row"><b><? echo number_format($startinglocalbalance+$localbalanceamount+$closinglocalbalance,2);?></b></td>

</tr>

<tr>
 <td width="90%" colspan=8 align=right class="Row"><b>Totals</b></td>
 <td align=left class="Row"><b><font color=red><? echo number_format($totaldebitamount,2);?></font></b></td>
 <td align=left class="Row"><b><font color=red><? echo number_format($totallocaldebitamount,2);?></font></b></td>
 <td align=left class="Row"><b><font color=blue><? echo number_format($totalcreditamount,2);?></font></b></td>
 <td align=left class="Row" colspan=3><b><font color=blue><? echo number_format($totallocalcreditamount,2);?></font></b></td>
 
</tr>

  <?
 } ?>


</table>
 <? } elseif($reporttype=='generalaccountreport') { ?>

<?
 $datediff = getdatediff($startsalesdate,$endsalesdate);

 //echo "the date difference is ".$datediff;
// exit();

   ?>
	  <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
 <tr>
            <td width="3%" class="TableHeader"><b>S No</b></td>
            <td width="7%" class="TableHeader"><b>Date</b></td>
			<td width="10%" class="TableHeader"><b>Gross Income</b></td>
			<td width="7%" class="TableHeader"><b>Direct Expenses</b></td>
			<td width="10%" class="TableHeader"><b>Indirect Expenses</b></td>
			<td width="12%" class="TableHeader"><b>Net Income</b></td>
			  
 </tr>
  <?
  $i=0;
  $no=0;
  $totalgrossincome=0;
  $totaldirectexpenses=0;
  $totalindirectexpenses=0;
  $totalnetincome=0;
  
  for($no=0; $no<=($datediff+1); $no++){
		$startMonth = date("m", strtotime($startsalesdate));
		$startDay = date("d", strtotime($startsalesdate));
		$startYear = date("Y", strtotime($startsalesdate)); 
        $nextday = date("d/m/Y", mktime(0, 0, 0, $startMonth,($startDay+$no), $startYear));
        $i++;
		$querydate = dateConvert($nextday);
        $agentdirectexpenses =0;
		$payingagentdirectexpenses =0;
		$indirectexpenses = 0;
		$directexpenses=0;
		$netincome=0;
		$grossincome=0;
		
		
		
		$grossincome = totaladmincommission($querydate);		
		$indirectexpenses = totalindirectexpenses($querydate);
	  	$agentdirectexpenses = getagentexpensesforadmin($querydate);
		$payingagentdirectexpenses = getpayingagentexpenseforadmin($querydate);
	    $directexpenses = $agentdirectexpenses+$payingagentdirectexpenses;
        $netincome = $grossincome-$directexpenses-$indirectexpenses;


		 $totaldirectexpenses+=$directexpenses;
		 $totalindirectexpenses+=$indirectexpenses;
		 $totalgrossincome+=$grossincome;
		 $totalnetincome+=$netincome;
        
?>
  

  <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><?php echo $i?></a></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><? echo ($nextday)?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>">£<? echo number_format($grossincome,2);?></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>">£<? echo number_format(($directexpenses),2);?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>">£<? echo number_format($indirectexpenses,2);?></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>">£<? echo number_format(($netincome),2);?></td>
</tr>
 
   <? 
  } ?>

  <tr><td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"></td>
 <td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><b>Totals</b></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><b>£<? echo number_format($totalgrossincome,2);?></b></td>
<td class="Row"  valign=top bgcolor="<?php echo $bgcolor?>"><b>£<? echo number_format(($totaldirectexpenses),2);?></b></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><b>£<? echo number_format($totalindirectexpenses,2);?></b></td>
<td class="Row"  valign=top  bgcolor="<?php echo $bgcolor?>"><b>£<? echo number_format(($totalnetincome),2);?></b></td>
</tr>

</table>

<? } elseif($reporttype=='allagentcommissionsummary') { ?>

<?
  $dataOrder      = isset($dataOrder)?$dataOrder:"agentname";
 
$sql            = "select * from agent_master where  agenttype!='collectionpoint'";
 
 $temp           = $temp."  order by ".$dataOrder;


  $sql            = $sql.$temp;
  
 // echo $sql;


  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
 
   
 ?>
      <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="14%">
  <b> Currently there are no agents in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
                 <td width="12%" class="TableHeader"><b>Agent Name</b></td>
               <td width="12%" class="TableHeader"><b>Total Transfer Amount</b></td>
			    <td width="12%" class="TableHeader"><b>Total Agent Commission Amount</b></td>
			  <td width="12%" class="TableHeader"><b>Total Company Commission Amount</b></td>
			 </tr>

  <?php

  $i=0;
  $no=0;
  $totalallsales=0;
  while ($row = mysql_fetch_array( $Result))
  {

$agentid     = (isset($row['agentid'])) ? $row['agentid'] : 0;
$agentpaymenttype     = (isset($row['agentpaymenttype'])) ? $row['agentpaymenttype'] : "";
$agentname     = (isset($row['agentname'])) ? $row['agentname'] : "";
$agentmobile     = (isset($row['agentmobile'])) ? $row['agentmobile'] : "";
$agenttelephone     = (isset($row['agenttelephone'])) ? $row['agenttelephone'] : "";
$lockstatus     = (isset($row['lockstatus'])) ? $row['lockstatus'] : "";

$agentopeningbalance     = (isset($row['agentopeningbalance'])) ? $row['agentopeningbalance'] : 0;
  $agentcommission = (isset($row['commission'])) ? $row['commission'] : "";
		   $agentcommission1 = (isset($row['commission1'])) ? $row['commission1'] : "";
		    $commcountry = (isset($row['commcountry'])) ? $row['commcountry'] : "";
$salesamount=getagentsalestotal($agentid,$startsalesdate,$endsalesdate);
$commissionamount=getagentcommissiontotal($agentid,$startsalesdate,$endsalesdate);
$earnedcommission=getagentearnedcommissiontotal($agentid,$commcountry,$agentcommission1,$agentcommission,$startsalesdate,$endsalesdate);

  ?>
  

  <tr><td class="Row" width="10%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $agentname?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format(($salesamount),2)?></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format(($earnedcommission),2)?></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format((($commissionamount-$earnedcommission)),2)?></td>
 
 </tr>
 
   <? 
  }
 }?>


</table>


<? } elseif($reporttype=='allpayingagentcommissionsummary') { ?>
<?

$sql            = "select * from payingagent_master ";
 
 $temp           = $temp."  order by agentname";


  $sql            = $sql.$temp;
  
 // echo $sql;


  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned

   
 ?>
      <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
<tr style="HEIGHT: 25px">

<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="14%">
  <b> Currently there are no agents in the system </b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>
 <tr>
                 <td width="12%" class="TableHeader"><b>Corresponding Agent Name</b></td>
               <td width="12%" class="TableHeader"><b>Total Transfer Amount</b></td>
			    <td width="12%" class="TableHeader"><b>Total Corresponding Agent Commission Amount</b></td>
			  <td width="12%" class="TableHeader"><b>Total Company Commission Amount</b></td>
			 </tr>

  <?php

  $i=0;
  $no=0;
  $totalallsales=0;
    while ($row = mysql_fetch_array( $Result))
  {

$agentid     = (isset($row['agentid'])) ? $row['agentid'] : 0;
$agentpaymenttype     = (isset($row['agentpaymenttype'])) ? $row['agentpaymenttype'] : "";
$agentname     = (isset($row['agentname'])) ? $row['agentname'] : "";
$agentmobile     = (isset($row['agentmobile'])) ? $row['agentmobile'] : "";
$agenttelephone     = (isset($row['agenttelephone'])) ? $row['agenttelephone'] : "";
$lockstatus     = (isset($row['lockstatus'])) ? $row['lockstatus'] : "";

$agentopeningbalance     = (isset($row['agentopeningbalance'])) ? $row['agentopeningbalance'] : 0;
  $agentcommission = (isset($row['commission'])) ? $row['commission'] : "";
		   $agentcommission1 = (isset($row['commission1'])) ? $row['commission1'] : "";
		    $commcountry = (isset($row['commcountry'])) ? $row['commcountry'] : "";
$salesamount=getpayingagentcollectionsalestotal($agentid,$startsalesdate,$endsalesdate);
$commissionamount=getpayingagentcommissiontotal($agentid,$startsalesdate,$endsalesdate);
$earnedcommission=getpayingagentearnedcommissiontotal($agentid,$commission,$startsalesdate,$endsalesdate);
  ?>
  

  <tr><td class="Row" width="10%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $agentname?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format(($salesamount),2)?></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format(($earnedcommission),2)?></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format((($commissionamount-$earnedcommission)),2)?></td>
 
 </tr>
 
   <? 
  }
 }?>


</table>
<? } ?>
    <BR>
<BR>
<script language=javascript>
 print();
 </script>
  </form>
  </body>
  </html>
