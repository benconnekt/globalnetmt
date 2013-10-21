<?php
  session_start();
   include('inc_header.php');

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
$Getpaymentid=0;
if(isset($_POST['paymentid'])!="")
   {
   $Getpaymentid=$_POST['paymentid'];
   }
   else
   {
    $Getpaymentid=$_GET['paymentid'];
   }
include("companyheader.html");

if($Getpaymentid!="")
   {
     $sql            = "select * from agentpayments  where paymentid='$Getpaymentid'";
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
	$agentname     = (isset($row['agentname'])) ? $row['agentname'] : "";
	$payingagent     = (isset($row['payingagent'])) ? $row['payingagent'] : "";
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

   $paymentmethod        = (isset($row['paymentmethod'])) ? $row['paymentmethod'] : "";
   $receiving_amount        = (isset($row['receiving_amount'])) ? $row['receiving_amount'] : "";
   $purposeoftransfer        = (isset($row['purposeoftransfer'])) ? $row['purposeoftransfer'] : "";
   $beneficiaryname        = (isset($row['beneficiaryname'])) ? $row['beneficiaryname'] : "";
   $beneficiaryaddress        = (isset($row['beneficiaryaddress'])) ? $row['beneficiaryaddress'] : "";
   $beneficiaryidno        = (isset($row['beneficiaryidno'])) ? $row['beneficiaryidno'] : "";
   $beneficiaryidexpiry        = (isset($row['beneficiaryidexpiry'])) ? $row['beneficiaryidexpiry'] : "";
   $beneficiarypaymentref        = (isset($row['beneficiarypaymentref'])) ? $row['beneficiarypaymentref'] : "";
   $beneficiaryiddocument        = (isset($row['beneficiaryiddocument'])) ? $row['beneficiaryiddocument'] : "";
   $swiftcode        = (isset($row['swiftcode'])) ? $row['swiftcode'] : "";
   $ibanno        = (isset($row['ibanno'])) ? $row['ibanno'] : "";
   $routingno       = (isset($row['routingno'])) ? $row['routingno'] : "";
   $clearingcode        = (isset($row['clearingcode'])) ? $row['clearingcode'] : "";
    $paymentdate = changeddate($paymentdate);

	$poundamount = round($agentamount/$exchangerate,2);
 $brokerpoundamount = round($agentamount/$brokerrate,2);
}

 

     for($repeat=1;$repeat<=1;$repeat++)
	  {
 ?>
	  
  <table border="0" cellpadding="2" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  
	<? if(is_numeric($agentname))
		  {?>
 <tr>
    <td width="100%" bordercolor="#F2F4F8" colspan="2" ><b><u>AGENT INFORMATION</U></b></td>
	</tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Agent Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo getofficename($agentname)?></td>
     </tr>
	
		  <tr>
    <td width="15%"  bordercolor="#F2F4F8" >ID</td>
    <td width="15%"  bordercolor="#F2F4F8" ><?php echo "APM".$paymentid;?></td>
     </tr>
	  <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Payment Type</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $paymenttype?></td>
	</tr>
	<tr> <td width="15%" bordercolor="#FFFFFF" >
    Payment Date</td>
    <td width="15%" bordercolor="#FFFFFF" ><?php echo $paymentdate?></td>
  </tr>
	  <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Agent Amount</td>
    <td width="15%"  bordercolor="#F2F4F8" >� <? echo number_format($agentamount,2)?></td>
    </tr>



	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Agent Reference</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $reference?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Agent Description</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $description?></td>
    </tr>
	 <tr>
    <td width="100%" bordercolor="#F2F4F8" colspan="2" ><b><u>BANK INFORMATION</U></b></td>
	</tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Bank Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $bankname?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Account Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $accountname?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Account No</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $accountno?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Sort Code</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $sortcode?></td>
    </tr>

	<tr>
    <td width="15%"  valign=top ><br>Customer Signature<br><br> ________________________________ </td>
	 <td width="15%"  valign=top ><br>Agent/Staff Signature<br><br>  ________________________________ </td>
	</tr>


		  <? } else { ?>
		   <tr>
    <td width="100%" bordercolor="#F2F4F8" colspan="2" ><b><u>CORRESPONDING AGENT INFORMATION</U></b></td>
	</tr>
   <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Corresponding Agent Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo getpayingagentname($payingagent)?></td>
     </tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >ID</td>
    <td width="15%"  bordercolor="#F2F4F8" ><?php echo "CPM".$paymentid;?></td>
     </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Payment Type</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $paymenttype?></td>
	</tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Currency</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo getcurrencyname($currency)?>
	</td>
	</tr>
	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Purpose of Transfer</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $purposeoftransfer?></td>
	</tr>
	<tr> <td width="15%" bordercolor="#FFFFFF" >
    Payment Date</td>
    <td width="15%" bordercolor="#FFFFFF" ><?php echo $paymentdate?></td>
  </tr>
	  <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Agent Amount</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo number_format($agentamount,2)?></td>
    </tr>

	
 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Buying Exchange rate(to GBP)</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $exchangerate?></td>
    </tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Amount in GBP</td>
    <td width="15%"  bordercolor="#F2F4F8" >� <? echo number_format($poundamount,2)?></td>
    </tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Broker Amount in GBP</td>
    <td width="15%"  bordercolor="#F2F4F8" >� <? echo number_format($brokerpoundamount,2)?></td>
    </tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Brokage</td>
    <td width="15%"  bordercolor="#F2F4F8" >� <?php echo number_format(($brokerpoundamount-$poundamount),2)?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Corresponding Agent Reference</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $reference?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Corresponding Agent Description</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $description?></td>
    </tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Payment Method</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $paymentmethod?></td>
	</tr>
    <tr>
    <td width="100%" bordercolor="#F2F4F8" colspan="2" ><b><u>BENEFICIARY INFORMATION</U></b></td>
	</tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiaryname?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Address</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiaryaddress?></td>
    </tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Id Document</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiaryiddocument?>
	</td>
	</tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Id No</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiaryidno?></td>
    </tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Expiry Date</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiaryidexpiry?></td>
    </tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Beneficiary Payment Ref</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $beneficiarypaymentref?></td>
    </tr>

	 <tr>
    <td width="100%" bordercolor="#F2F4F8" colspan="2" ><b><u>BENEFICIARY BANK INFORMATION</U></b></td>
	</tr>

	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Bank Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $bankname?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Account Name</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $accountname?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Account No</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $accountno?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Sort Code</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $sortcode?></td>
    </tr>

	<tr>
    <td width="15%"  bordercolor="#F2F4F8" >Swift Code</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $swiftcode?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >IBAN No</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $ibanno?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Routing No</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $routingno?></td>
    </tr>
	 <tr>
    <td width="15%"  bordercolor="#F2F4F8" >Clearing Code</td>
    <td width="15%"  bordercolor="#F2F4F8" ><? echo $clearingcode?></td>
    </tr>
	<tr>
	<td valign=top colspan=2>
	 <table border="0" cellpadding="0" cellspacing="0" width="100%">   
	<tr><td width="100%" valign=top align="center">
	<b><U>TERMS AND CONDITIONS</u></b>
	</td>
	</tr>
	<tr><td width="100%" valign=top colspan=2><font size=1>
<UL><li>ID DOCUMENT IS REQUIRED FOR ALL  PICK UP AMOUNT</li>
<li>BUSINESS INVOICE  IS REQUIRED FOR ALL BUSINESS TRANSACTIONS</li>
<li>INTERNATIONAL PAYMENT TAKES 5 WORKING DAYS, BANK ACCOUNT PAYMENT  TAKES 3 WORKING DAYS. HOWEVER SAME DAY CASH PAYMENT CLOSES AT 1PM</li>
<li>CASH PAYMENT CAN ONLY BE MADE AT LEWISHAM OFFICE WHICH REQUIRES VALID ID AND PROOF OF ADDRESS FOR PAYMENT OVER �2500.</li>
<li>A DAY NOTICE IS REQUIRED FOR CASH PICK UP AT THE LEWISHAM OFFICE.</li></ul>

</font>
</td>
	</tr>
	<tr>
    <td width="50%"  valign=top ><br>Customer Signature<br><br> ________________________________ </td>
	 <td width="50%"  valign=top ><br>Agent/Staff Signature<br><br>  ________________________________ </td>
	</tr>
     <? } ?>
	
	</table>
	
<?}?>

 <script language=javascript>
// print();
 </script>
 <? }
 else
 {
display_message("No record found for the order");
} ?>

</form>


