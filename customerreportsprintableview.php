<?php  
   if($_GET['type'] =='excel')
 {
 header("Content-Type: application/vnd.ms-excel; name='excel'");
 header("Content-Disposition: attachment; filename=CUSTOMEREPORT.xls");
 }
 else
 {
	 include("companyheader.html");
 }
 include('inc_header1.php');
   if (isset($_SESSION["MM_Username1"]))
{
$username=$_SESSION["MM_Username1"];
$userid=getuserid($username);
$userrole=getuserrole($username);

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

   ?>

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
            echo "".getcontactname($_POST['contactid']);
			echo "-".getbeneficiaryname($_POST['benid']);?>
           </font></b></td>
          </tr>
          <tr>
            <td width="100%"><hr color="#000000" size="1"></td>
          </tr>
        </table>
          </center>
        </div>
        <div align="center">


      <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="1">
    <tr>
      <td width="100%" height="1" bgcolor="#FFFFFF" valign="top">
       <?php
   $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
//  $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise

  $TR             = 0;
  $i              = 0;

  ?>

<table border="0" cellpadding="1" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">


<?php

  if($noOfRecords==0)
  { ?>

  <tr>
  <td width="100%" colspan=4>
  <b> Currently there is no Money transfer sales information in the system.</b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>

<tr>
    <td width="5%" class="TableHeader">
                 <b><B> Office</b></td>
<td class="TableHeader">
                 <b>Order Date</a></b></td>
                 <td class="TableHeader">
                 <b> Trans Code</b></td>


    <td class="TableHeader">
                 <b>Customer</b></td>
                <td width=5% class="TableHeader">
                 <b>Amount</a></b></td>
				 <td width=5%  class="TableHeader">
                 <b>Comm</a></b></td>
				 <td width=5% class="TableHeader">
                 <b>Total Amount</a></b></td>
				 <td class="TableHeader">
                 <b>Currency</a></b></td>
   <td class="TableHeader">
                 <b>Rate</b></td>
   <td class="TableHeader">
                 <b>Beneficiary</a></b></td>

                <td class="TableHeader">
                 <b>Beneficiary Amount</b></td>
				    <td class="TableHeader">
                 <b>Ordered By</b></td>
				    <td class="TableHeader">
                 <b>Status</b></td>

               </tr>
  <?php

  $i=0;
  $no=0;
  $totalprofit=0;
  while ($row = mysql_fetch_array( $Result))
  {

   $i++;
    $no=$no+1;
  $bgcolor       = ($i % 2) ? "#FFFFFF" : "#EAEAEA";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";
  $currency=$row['currency'];
	$saleid=$row['saleid'];
	$benamount=$row['benamount'];
	$exchangerate=$row['exchangerate'];
	$orderamount=$row['orderamount'];
	$orderstatus=$row['orderstatus'];
	$officeid=$row['officeid'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$orderid=$row['orderid'];
	$ordertime=$row['ordertime'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname']." ".$row['bensurname'];
	$agentcommissionamount=$row['agentcommission'];

	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname'];
	
	$totalturnover=$totalturnover+$orderamount;
	$totalturnovercomm=$totalturnovercomm+$agentcommissionamount;
    
  ?>







              </tr>
          
   <tr>
  
                <td width="5%" class=Row>
              <?php echo getofficename($officeid)?></td>
               <td width="7%" class=Row >
              <?php echo changeddate($orderdate)?> <? echo $ordertime?></td>
               <td width="5%" class=Row >
              <?php echo $orderid?></b></font></td>
               <td width="10%" class=Row >
              <?php echo $customername?> </b></font></td>
               <td width="5%" class=Row>
              <?php echo number_format($orderamount,2)?></b></font></td>
			  <td width="5%" class=Row>
              <?php echo number_format($agentcommissionamount,2)?></b></font></td>
			   <td width="5%" class=Row>
              <?php echo number_format(($orderamount+$agentcommissionamount),2)?></b></font></td>
               <td width="5%" class=Row >
              <?php echo getshortcurrencyname($currency)?></b></font></td>
              
			   <td width="5%" class=Row >
              <?php echo $exchangerate?></b></font></td>
               <td width="10%" class=Row >
              <?php echo $beneficiaryname?></b></font></td>

                <td width="5%" class=Row >
              <?php echo number_format($benamount,2)?></font></td>
			  
			  <td width="5%" class=Row >
              <?php echo getusername($orderby)?></b></font></td>
			  <td width="5%" class=Row >
              <?php echo $orderstatus?></b></font></td>



                 </tr>
 <? }  ?>

 <tr>

                 <td width="5%">
                 <b><br></b></td>
                  <td width="5%">
                 <b><br></b></td>
				   <td width="5%">
                 <b><br></b></td>
                  <td width="5%">
                 <b><br></b></td>
                  <td width="5%" >
                 <b><br></b></td>
                  <td width="5%" >
                 <b><br></b></td>
                  <td width="5%" >
                 <b><br></b></td>
				   <td width="5%">
                 <b><br></b></td>
                  <td width="5%">
                 <b><br></b></td>
                  <td width="5%" >
                 <b><br></b></td>
				  </tr>
        <tr>

                 <td width="5%">
                 <b>Totals:</b></td>
                  <td width="5%" >
                 <b></b></td>
                  <td width="5%" >
                 <b></b></td>
                  <td width="5%" >
                 <b></b></td>
       <td width="5%" >
                 <b>£ <?php echo number_format($totalturnover,2)?></b></td>
				   <td width="5%" >
                 <b>£ <?php echo number_format($totalturnovercomm,2)?></b></td>
				   <td width="5%" >
                 <b>£ <?php echo number_format(($totalturnover+$totalturnovercomm),2)?></b></td>
                  <td width="5%">
				  <td width="5%">
                </td><td></td>
                 
                 <td width="5%" >
                 </td>
				 <td width="5%" >
                 <b><br></b></td>




  </tr>
                   <? } ?>

     </table></center>
        </center>
      </div>
    <BR>
<BR>
	<?
	if($_GET['type'] !='excel')
 {?>
<script language=javascript>
 print();
 </script>
 <? } ?>
  </form>
  </body>
  </html>
