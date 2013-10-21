<?  session_start();
   include('inc_header.php');
   ?>
 <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style.css" type=text/css rel=stylesheet>
<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
<title><? echo $pagetitle?> - Global Net Money Transfer</title>
</head>
<body style="margin:0px">

<form name="usersform" action="index.php" method="get">
 <script language=javascript>

 function quickaddradd(val,val1)
{
        var temp = "";
         var temp1 = "";
         temp = parent.document.form1.txt_to_users.value;
                if (temp != "")
                {
                        temp += ",";
                }
                temp += val;
                 temp1 = parent.document.form1.txt_to_users1.value;
                if (temp1 != "")
                {
                        temp1 += ",";
                }
                temp1 += val1;
                parent.document.form1.txt_to_users.value = temp;
                parent.document.form1.txt_to_users1.value = temp1;

}

   </script>
<input type=hidden name=displayPageNo value="1">
<input type=hidden name=status value="<?php echo base64_encode('users')?>">


  <table border="0" cellpadding="1" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr><td width="100%" class="tableHeader" ><b>Address Book</b>
  </td>
  </tr>


<?php
  $DISP_REC_COUNT = 20;  // No of rows appearing per page
 $displayPageNo  = (isset($displayPageNo)) ? $displayPageNo : 1;
 $dataOrder      = isset($dataOrder)?$dataOrder:"userid";
 $sql            = "select a.userid,a.username,b.agentname,c.agentname as payingagentname,a.is_payingagent from user_master a left join agent_master b on a.useroffice=b.agentid left join payingagent_master c on a.useroffice = c.agentid ";
   if($HTTP_GET_VARS['txt_search']!='' && $HTTP_GET_VARS['option']!='')
  {
  $parameter=$HTTP_GET_VARS['option'];
  $value=$HTTP_GET_VARS['txt_search'];
  $temp           = $temp." where ".$parameter ." like  '%".$value."%'";
  }

  $temp           = $temp."  order by ".$dataOrder;


  $sql            = $sql.$temp;
//echo $sql;


  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise

  $TR             = 0;
  $i              = 0;

  $i=0;
  $no=0;
  while ($row = mysql_fetch_array( $Result))
  {

   $i++;
    $no=$no+1;
   $bgcolor       = ($i % 2) ? "#EAEAEA" : "#eeeeee";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";




  $userid      = (isset($row['userid'])) ? $row['userid'] : 0;
   $agentname      = (isset($row['agentname'])) ? $row['agentname'] : "";
  $username      = (isset($row['username'])) ? $row['username'] : "";
  $payingagentname      = (isset($row['payingagentname'])) ? $row['payingagentname'] : "";
  $is_payingagent      = (isset($row['is_payingagent'])) ? $row['is_payingagent'] : "";
  if($is_payingagent == "Y")
	  {
	  $display_agentname = $payingagentname;
	  }
	  else
	  {
	 $display_agentname = $agentname;
	  }


  ?>

 <tr><td width="100%" class="Row"  bgcolor="<?php echo $bgcolor?>"><a href=javascript:quickaddradd("<?php echo $userid?>","<?php echo $username?>")><font color=darkblue><?php echo $username?> - <?php echo $display_agentname?>
</a></td>
</tr>
         <? } ?>
         </table>
         

         </form>
		 </body>
		 </html>


