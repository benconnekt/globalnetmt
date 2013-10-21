<?php session_start();
   include('inc_header.php');
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
<?include("companyheader.html");?>
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
           <?
           if($_POST['searchagent']!='')
           {  echo "- ".getpayingagentname($_POST['searchagent']);
           } ?>
             <?
                if($_POST['searchcustomer']!='')
           {
           $customername=getcontactname($_POST['searchcustomer']);
           echo "<font color=darkblue>- ".$customername;
           }?>
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

  if($noOfRecords==0 )
  { ?>

  <tr>
  <td width="100%" colspan=4>
  <b> Currently there is no Corresponding Agent Collections information in the system.</b>
  </td>
                   </tr>
 <?php }
  else
 {  ?>


 
<tr>
   		  <td width=5% class="TableHeader">
                 <b>Id No</a></b></td>
				
  <td class="TableHeader">
                 <b>Beneficiary Name</b></td>
                
               <td class="TableHeader">
                 <b>Account No</b></td>
				    <td class="TableHeader">
                 <b>Bank</b></td>
				    <td class="TableHeader">
                 <b>Branch</b></td>
				    <td class="TableHeader">
                 <b>Amount TK</b></td>
				    <td class="TableHeader">
                 <b>Remitter</b></td>
				 <td class="TableHeader">
                 <b>Auth Code</b></td>
				  
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
	$officename=$row['officename'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$orderid=$row['orderid'];
	$idno=$row['idno'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname']." ".$row['bensurname'];
    $agentcommissionamount=$row['agentcommission'];
$bankname=$row['bankname'];
	$benamount=$row['benamount'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname'];
	$beneficiaryidno=$row['beneficiaryidno'];
	
	if($orderamount>0)
	  {
	$totalturnover=$totalturnover+$orderamount;
	  }
	  if($agentcommissionamount>0)
	  {
	$totalturnovercomm=$totalturnovercomm+$agentcommissionamount;
	  }
	  if($benamount>0)
	  {
	$totalbenturnover=$totalbenturnover+$benamount;
	  }
  
             ?>
			<tr> <td width="7%" class=Row >
             <? echo $idno?></td>
			 <td width="10%" class=Row >
              <?php echo $beneficiaryname?></b></font></td>
              
                <td width="10%" class=Row >
              <?php echo $accountno?> </b></font></td>
               <td width="5%" class=Row>
              <?php echo $bankname?></b></font></td>
			    <td width="5%" class=Row >
              <?php echo $branchname?></b></font></td>
			  <td width="5%" class=Row >
              <?php echo number_format($benamount,2)?></font></td>			  
			  <td width="5%" class=Row >
              <?php echo $customername?></b></font></td>
			  <td width="5%" class=Row >
			  <?php echo $beneficiaryidno?></td>
			  </tr>
 <? } ?>

       <? } ?>

     </table></center>
        </center>
      </div>
    <BR>
<BR>
<script language=javascript>
 print();
 </script>
  </form>
  </body>
  </html>
