<?php session_start();
   include('inc_header1.php');
    include('companyheader.html');
	$today = getdate();
$month = $today['mon'];
$mday = $today['mday'];
$year = $today['year'];

  if (isset($HTTP_SESSION_VARS["MM_UserAuthorization1"]))
{
$username=$HTTP_SESSION_VARS["MM_Username1"];
$userid=getuserid($username);
 $loginstatus="User logged:<font color=darkblue>".$HTTP_SESSION_VARS["MM_Username1"]."</font>";
}
$today = date("Y-m-d");
 $lastmonth= date ("Y-m-d", mktime (0,0,0,date("m")-1,date("d"),  date("Y")));
 $startsalesdate  = (isset($_POST['startsalesdate'])) ? $_POST['startsalesdate'] : $lastmonth;
 $endsalesdate  = (isset($_POST['endsalesdate'])) ? $_POST['endsalesdate'] : $today;
  $agentid  = (isset($_POST['agentid'])) ? $_POST['agentid'] : "";
 $userrole=getuserrole($userid);

?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber3">
          <tr>
            <td width="100%">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%">
            <p align="center"><b><font size="2">AGENT ACCOUNT REPORT</font></b></td>
          </tr>
         
        </table>
        
<form name=paymentsform method=post action=index.php>

<input type=hidden name=status value="<?php echo base64_encode('dailyreport')?>">
<input type=hidden name=displayPageNo value="1">
<input type=hidden name=pageAction >
 <?
 $temp="";
  $DISP_REC_COUNT = 50;  // No of rows appearing per page
 $displayPageNo  = (isset($displayPageNo)) ? $displayPageNo : 1;
 $dataOrder      = isset($dataOrder)?$dataOrder:"agentname";

 if($userrole=='Administrator')
 {
	  $sql            = "select * from agent_master where agenttype!='collectionpoint'";
 }
 else
 {
	   $sql            = "select * from agent_master where  agenttype!='collectionpoint' and agentid='$agentid'";
 } $temp           = $temp."  order by ".$dataOrder;


  $sql            = $sql.$temp;
 // echo $sql;


  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise

  $TR             = 0;
  $i              = 0;

   
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
               <td width="12%" class="TableHeader"><b>Office</b></td>
               <td width="12%" class="TableHeader"><b>Credit Limit</b></td>
			   <td width="12%" class="TableHeader"><b>Paid Amount</b></td>
			   <td width="12%" class="TableHeader"><b>Total MT Sales</b></td>
			   <td width="12%" class="TableHeader"><b>MT Commissions</b></td>
			   <td width="12%" class="TableHeader"><b>Balance</b></td>
			   
			   
              </tr>

  <?php

  $i=0;
  $no=0;
  $totalallsales=0;
  while ($row = mysql_fetch_array( $Result))
  {


$agentid     = (isset($row['agentid'])) ? $row['agentid'] : 0;
$agentname     = (isset($row['agentname'])) ? $row['agentname'] : 0;
$creditamount=getagentcreditlimit($agentid);
$salesamount=getagentsalestotal($agentid);
$commissionamount=getagentcommissiontotal($agentid);
$paymentamount=getagentpaymentamount($agentid);


  ?>
  

  <tr><td class="Row" width="10%" bgcolor="<?php echo $bgcolor?>">
 <?php echo $agentname?></a></td>
 <td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($creditamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($paymentamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($salesamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format($commissionamount,2)?></td>
<td class="Row" width="12%" bgcolor="<?php echo $bgcolor?>">£ <? echo number_format(($paymentamount-$salesamount-$commissionamount),2)?></td>

  </tr>
   <? 
  }
 }?>




</table>