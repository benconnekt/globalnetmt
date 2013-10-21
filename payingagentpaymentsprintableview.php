<?php 
if($_GET['type'] == 'excel')
{
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=PAYMENTS.xls");
}
else
{
include("companyheader.html");
}
include('inc_header1.php');
 if(isset($_POST['query'])!="")
   {
   $sql=$_POST['query'];
   }
   else
   {
   $sql="";
   }
 $sql = str_replace("\'", "'", $sql);
 $Result2         = safe_query($sql) ;
 $noOfRecords2    = @mysql_num_rows($Result2); // Total no of records returned



 ?>

        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber3">
          <tr>
            <td width="100%">&nbsp;</td>
          </tr>
          <tr>
            <td width="100%">
            <p align="center"><b><font size="2">PAYMENTS  - <? ECHO changeddate($startsalesdate)?> -  <? ECHO changeddate($endsalesdate)?> 
           
         </font></b></td>
          </tr>
         
        </table>
        
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
		<td width="10%" class="TableHeader"><b>Brokage</B></td>
		 <td width="10%" class="TableHeader"><b>Bank</B></td>
	  <td width="20%" class="TableHeader"><b>Reference</B></td>
	  <td width="5%" class="TableHeader"><b>User</B></td>
	  </tr>
  </thead>
  <tbody>

<?php

  if($noOfRecords2==0)
  { ?>

  <tr>
      <td align="middle" colSpan="8">No corresponding agent payments.</td>
    </tr>
 <?php }
  else
 {

  $i=0;
  $no=0;
  while ($row = mysql_fetch_array( $Result2))
  {

   $i++;
    $no=$no+1;
   $bgcolor       = ($i % 2) ? "#EAEAEA" : "#eeeeee";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";





  $payingagent     = (isset($row['payingagent'])) ? $row['payingagent'] : 0;
   $paymentid     = (isset($row['paymentid'])) ? $row['paymentid'] : 0;
   $agentamount      = (isset($row['agentamount'])) ? $row['agentamount'] : "";
  $paymentdate        = (isset($row['paymentdate'])) ? $row['paymentdate'] : "";
   $paymenttype        = (isset($row['paymenttype'])) ? $row['paymenttype'] : "";
   $currency        = (isset($row['currency'])) ? $row['currency'] : "";
   $exchangerate        = (isset($row['exchangerate'])) ? $row['exchangerate'] : "";
   $bankname        = (isset($row['bankname'])) ? $row['bankname'] : "";
   $accountname        = (isset($row['accountname'])) ? $row['accountname'] : "";
   $accountno        = (isset($row['accountno'])) ? $row['accountno'] : "";
   $sortcode        = (isset($row['sortcode'])) ? $row['sortcode'] : "";
   $reference        = (isset($row['reference'])) ? $row['reference'] : "";
   $description        = (isset($row['description'])) ? $row['description'] : "";
    $brokerrate        = (isset($row['brokerrate'])) ? $row['brokerrate'] : "";
	 $paymenttime        = (isset($row['paymenttime'])) ? $row['paymenttime'] : "";
   $paymentuser        = (isset($row['paymentuser'])) ? $row['paymentuser'] : "";
   
   
   $poundamount = round($agentamount/$exchangerate,2);
   $brokerpoundamount = round($agentamount/$brokerrate,2);

 $totalpaymentamount=$totalpaymentamount+$agentamount;
 $totalpoundamount=$totalpoundamount+$poundamount;
 $totalbrokerpoundamount=$totalbrokerpoundamount+$brokerpoundamount;


  ?>



   <tr>
    <td class="Row"  ><?php echo "CPM".$paymentid;?></td>
 <td class="Row"  ><?php echo changeddate($paymentdate)?> <? echo $paymenttime?></td>
      <td class="Row"  ><?php echo getpayingagentname($payingagent)?></td>
	   <td class="Row"  ><?php echo ($paymenttype)?></td>
     <td class="Row"  ><?php echo number_format(round($agentamount,2), 2, '.', '')?></td>
	      <td class="Row"  ><?php echo getcurrencyname($currency)?></td>
		      <td class="Row"  ><?php echo number_format($exchangerate,2)?></td>
			  <td class="Row"  ><?php echo number_format($brokerrate,2)?></td>
			  <td class="Row"  >£<?php echo number_format($poundamount,2)?></td>
			  <td class="Row"  >£<?php echo number_format($brokerpoundamount,2)?></td>
			   <td class="Row"  >£<?php echo number_format(($brokerpoundamount-$poundamount),2)?></td>
			  <td class="Row"  ><?php echo ($bankname)?></td>
	 <td class="Row"  ><?php echo ($reference)?></td>
	  <td class="Row"  ><?php echo ($paymentuser)?></td>
	
    </tr>


   <?

         }
       ?>

   </tbody>
   <tfoot>
     <tr>
	 <td class=Row > </td>
          <td class=Row > </td>
		   <td class=Row > </td>
          <td class=Row ><b>Totals</b> </td>
<td class=Row >  <b><font color=red><? echo number_format(round($totalpaymentamount,2), 2, '.', '') ?></font></b>    </td>
 <td class=Row > </td>
  <td class=Row > </td>
<td class=Row > </td>
 <td class=Row >  <b><font color=red> £ <? echo number_format(round($totalpoundamount,2), 2, '.', '') ?></font></b>    </td>
  <td class=Row >  <b><font color=red> £ <? echo number_format(round($totalbrokerpoundamount,2), 2, '.', '') ?></font></b>    </td>
<td class=Row > </td>
<td class=Row width=2% >   </td>
<td class=Row width=2% >   </td>
<td class=Row width=2% >   </td>

     </tr>


  </tfoot>


  <? }?>
  </table>
  <script language=javascript>
 print();
 </script>
