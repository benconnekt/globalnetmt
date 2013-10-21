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
 
 <?
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
}

 

     for($repeat=1;$repeat<=1;$repeat++)
	  {
	  include('companyheader.html');

	  ?>
   <table border="0" cellpadding="2" cellspacing="2" width="100%" height="700">
   
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
    <td width="100%" valign="top" colspan="2"><b>BENEFICIARY DETAILS</b></td>
  </tr>
  <? echo getbeneficiarydetailsfororder($benid)?>

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
    </table>
    </td>
    </tr>
	 <tr>
    <td width="50%" ALIGN=CENTER valign=top>
	 <table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">


  <tr>
    <td width="100%" valign="top" colspan="2"><b>BRANCH/AGENT OFFICE DETAILS</b></td>
  </tr>
  <? echo getofficedetailsfororder($officeid)?>
   <tr>
   </table>
	</td>
	<td width="50%" ALIGN=CENTER valign=top>
	 <table border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111" width="100%"  id="AutoNumber1">

    <tr>
    <td width="100%" valign="top" colspan="2"><b>ORDER DETAILS </b></td>
  </tr>
     <tr>
    <td width="50%" valign="top">Sent Amount</td>
    <td width="50%" valign="top"><b><font size=2>£<?php echo number_format(round($orderamount,2),2)?></font></b></td>
  </tr>
   <tr>
    <td width="50%" valign="top">Commission Paid</td>
    <td width="50%" valign="top">£<?php echo number_format(round($agentcommissionamount,2),2)?></td>
  </tr>
      <tr>
    <td width="50%" valign="top">Total</td>
    <td width="50%" valign="top"><b><font size=2>£<?php echo number_format(round(($orderamount+$agentcommissionamount),2),2)?></font></b></td>
  </tr>
    
  <tr>
    <td width="50%" valign="top">Rate</td>
    <td width="50%" valign="top"><?php echo $exchangerate?></td>
  </tr>
    <tr>
    <td width="50%" valign="top">Beneficiary Amount*</td>
    <td width="50%" valign="top"><b><font size=2><?php echo number_format(round($benamount,2),2)?></font></b></td>
  </tr>
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
  </tr>
    </table>
  
  <br>
    <table border="0" cellpadding="2" cellspacing="2" width="100%">
   <tr>
    <td width="100%" class=text  valign=top ><font size=1>I/We hereby declare that the money paid to you by me/us was or is not derived or obtained by me/us by any illegal means or transactions including but not limited to any unlawful drug dealings.</font></td>
  </tr>
  
  <tr>
    <td width="100%"  valign=top ><br>Signature ________________________________ </td>
	</tr>
	<tr>
	<td width="100%"  valign=top >
	<font size=1>Thank you, we will be happy to serve you in the next visit. Identification required for transaction above £2000.00<br><hr></font></td>
	</tr>
	</table>
	</td>
	<tr>
	<td valign=top>
	 <table border="0" cellpadding="2" cellspacing="2" width="100%">   
	<tr><td width="100%" valign=top align="center">
	<b><U>TERMS AND CONDITIONS</u></b>
	</td>
	</tr>
	<tr><td width="100%" valign=top><font size=1>
<b>International Transfer:</b><br>
Availability of the money transfer may be restricted under Money Laundering regulations. Our service delivery level is same day payment on most of our routes except otherwise advised. However certain condition might delay payment, even in these circumstances we do promise not to exceed 7 working days for payment or we would refund your money back to you.
<br><b>Refunds/Cancellation:</b><br>
Refunds of Principle Amount and cancellation of the money transfer will be made upon written request by the Sender if payment to the Receiver has not yet been made at the time the request is processed by Global Net; you agree that TRANSFER FEES will NOT be refunded after the transaction has been processed by Global Net. You agree that REFUND OF CAPITAL AMOUNT can only be made after 5 working days from day of request for cancellation.
<br><b>Charges For Amendment Of Transaction:</b><br>
you agree to pay an Amendment Charge of £5  for amending a transaction that has been already  processed by Global Net, based on the information you supplied to us on the Transfer Request Form. You agree that the charge will have to be paid to our collecting agent , or paid directly into Global Net Integrated Limited clients Account with Barclays Bank. You agree that for every amendment made to a specific transfer, a £5 charge will apply
<br><b>Beneficiary Account Payments:</b><br>
When recipient account payments are made, Global Net will guarantee and proved
payment into the receiving branch holding account. You agree thereafter that Global Net cannot take responsibility as to the length of time it will take for funds to be available in recipient account. You agree that Global Net will not be liable for errors when sender provides incorrect/invalid beneficiary account details for any reasons whatsoever.
<br><b>Receiver Information:</b><br>
Global Net or her agents make delivery of money transfer on cash pick up basis at a collection point as advised. Identification is normally required at pick up points, which will be advised at the time of sending If the recipient is unable to provide valid identification, the payout branch reserves the right not to pay the transaction.
Under no circumstances shall Global Net or her agent be liable for more than the principal amount of the money transferred by sender as shown in this receipt. Even in the event of delay, non-delivery, under-payment due to error or omission of Global Net or her agents, only the principle amount shown on this receipt shall be refunded. In no even shall Global Net or her agent be responsible for incidental or consequential damages.
</font>
</td>
	</tr>
	</table>
		</td>
	<tr>
	<tr>
	<td valign=bottom>
	 <table border="0" cellpadding="2" cellspacing="2" width="100%" valign=bottom>	
<tr><td width="100%" align=center valign=bottom><B><U>Money Service Number: 12214386</U></B></td>
	</tr>
</table>
</td>
</tr>
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


