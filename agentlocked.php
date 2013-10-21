<? 
 session_start();
  include('inc_header.php');
  $agentid = $_SESSION["MM_AGENTID"];
  ?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-gb">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Global Net MT - Account Locked</title>
<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
<LINK href="style.css" type=text/css rel=stylesheet>
<body style="padding-top:40">

    <table width="30%" class="tableBorder"height=200 align=center border="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
           <tr height=25>
                      <td colspan=2 background="images/table_header_bkg.gif"><span class="tableHeaderText style5">&nbsp;&nbsp;Account Locked</span></td>
                    </tr>  
					 <tr>
                      <td class="Row" valign=top colspan=2 style="padding-top:10;padding-left:10;padding-right:10">
					  <?
					  $salesamount=getagentsalestotal($agentid);
					  $creditamount=getagentcreditlimit($agentid);
                      $paymentamount=getagentpaymentamount($agentid);
					  $commissionamount=getagentcommissiontotal($agentid);
					  $openingbalance = getagentopeningbalance($agentid);
					  ?>
					  <b>Account Balance: <FONT COLOR=RED size=3>£ <? ECHO number_format(($openingbalance+$paymentamount-$salesamount-$commissionamount),2)?></font></b>
					  </td>
					  </tr>
			  <tr>
                      <td class="Row" colspan=2 valign=top style="padding-top:10;padding-left:10;padding-right:10">				 
					 Your Account has been <b>locked</b>.<BR><BR>Please make your payment and contact our account department on <b>0208 3185860</b> 
					 <br><br>
					 <a href="index.php?status=<?php echo base64_encode('logout')?>"><u>Logoff</u></A>
       
   </td>
   </tr>
			
				<tr height=25>
                      <td align=right colspan=2 background="images/table_header_bkg.gif"><span class="tableHeaderText style5">Powered by <a href="http://www.altnsolutions.com" target="_blank"><font color=white>GlobalNet</font></a></span>&nbsp;&nbsp;</td>
                    </tr>
            </table>

  </BODY>
  </HTML>

