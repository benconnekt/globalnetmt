<?  session_start();
   include('inc_header.php');
$username=$_SESSION["MM_Username1"];
$userid=$_SESSION["MM_USERID"];
$sessuserid=$_SESSION["MM_USERID"];
$addrights=$_SESSION["MM_ADDRIGHTS"];
$updaterights=$_SESSION["MM_UPDATERIGHTS"];
$deleterights=$_SESSION["MM_DELETERIGHTS"];
$reportrights=$_SESSION["MM_REPORTRIGHTS"];
$usersrights=$_SESSION["MM_USERRIGHTS"];
$customerrights=$_SESSION["MM_CUSTOMERRIGHTS"];
$contactsrights=$_SESSION["MM_CUSTOMERRIGHTS"];
$groupsrights=$_SESSION["MM_GROUPRIGHTS"];
$accountsrights=$_SESSION["MM_ACCOUNTRIGHTS"];
$officerights=$_SESSION["MM_OFFICERIGHTS"];
$userofficeid=$_SESSION["MM_USEROFFICEID"];
$userrole=$_SESSION["MM_USERROLE"];
$agentref=$_SESSION["MM_AGENTREF"];
$agentid=$_SESSION["MM_AGENTID"];
$smsrights = $_SESSION["MM_SMSRIGHTS"];
$usercreationrights=$_SESSION["MM_USERCREATIONRIGHTS"];
$superuserrights=$_SESSION["MM_SUPERUSERRIGHTS"];
$alertrights=$_SESSION["MM_ALERTRIGHTS"];?>
 <LINK href="style.css" type=text/css rel=stylesheet>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta HTTP-EQUIV=Refresh CONTENT="300;URL=checkmessages.php?status=<? echo $_GET['status']?>">
 </head>
 <body>
<form name="usersform" action="checkmessages.php?status=<? echo $_GET['status']?>" method="get">
<?php
  $DISP_REC_COUNT = 20;  // No of rows appearing per page
 $displayPageNo  = (isset($displayPageNo)) ? $displayPageNo : 1;
 $dataOrder      = isset($dataOrder)?$dataOrder:"userid";
  $sql            = "select a.complaintid from complaints a,sales_master b where a.orderid=b.orderid and readstatus='N'";
if($userrole!='Administrator' && $superuserrights!='Y')
  { 
	 $temp = $temp. "and b.officeid='$agentid' ";
 }
  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise
  $actionstatus="false";
  //echo "the no of records=".$noOfRecords;
  if($noOfRecords>0)
  {
  $actionstatus="true";
  }
  ?>
         </table>

           <script language=javascript>
    function  displayalert(){
    alert("You have unread complaints in the system waiting to be attended");
		 } 
 </script>
    <?
      if($actionstatus=="true")
      {  
		 if(base64_decode($_GET['status'])!="viewcomplaints" && base64_decode($_GET['status'])!="newcomplaint"  && base64_decode($_GET['status'])!="editcomplaint" )
   {?>
     <script language=javascript>
     displayalert();
    </script>
     <? }}
    ?>

         </form>
         </body>
         </html>


