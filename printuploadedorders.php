<?php session_start();
   include('inc_header.php');
   if (isset($_SESSION["MM_Username1"]))
{
$username=$_SESSION["MM_Username1"];
$userid=getuserid($username);
$userrole=getuserrole($username);

}
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
            echo "".(changeddate($_POST['startdate']));
			echo "-".(changeddate($_POST['enddate']));?>
           
         </font></b></td>
          </tr>
          <tr>
            <td width="100%"><hr color="#000000" size="1"></td>
          </tr>
        </table>
          </center>
        </div>
        <div align="center">

		<?

if(isset($_POST['query'])!="")
   {
   $sql=$_POST['query'];
   }
   else
   {
   $sql="";
   }
  $sql = str_replace("\'", "'", $sql);
 $report1sql = "select * from report_master where reportid='$reportid' ";
 $report1Result         = safe_query($report1sql) ;
 while ($sub1row = mysql_fetch_array( $report1Result))
  {
	 $is_empty_allowed = $sub1row['is_empty_allowed'];
	 $print_headers = $sub1row['export_headers'];
	 $apply_id_document_rule  = (isset($sub1row['apply_id_document_rule'])) ? $sub1row['apply_id_document_rule'] : "";
      
	 
  }
   print("<table border=0 cellpadding=1 cellspacing=1 style=border-collapse: collapse bordercolor=#111111 width=100% id=AutoNumber1>");
  $reportsql = "select fieldname,displayname,is_dummy from report_fields,report_field_group where reportid='$reportid'  and report_fields.fieldid=report_field_group.fieldid order by report_field_group.position ASC";
 $reportResult         = safe_query($reportsql) ;
 $reportrowcount = mysql_num_rows($reportResult);
	if($reportrowcount>0)
  {
   $reportcolumns = $reportcolumns."<tr>";
 while ($subrow = mysql_fetch_array( $reportResult))
  {
	  if(strlen($subrow['fieldname']))
	  {
	  $reportsubquery = $reportsubquery.$subrow['fieldname'].",";
	  }
	 $reportcolumns = $reportcolumns."<td class=TableHeader>".strtoupper($subrow['displayname'])."</td>";
	 
  }
  $reportcolumns = $reportcolumns."</tr>";
 
print($reportcolumns); 


  $i=0;
  $no=0;
  $totalprofit=0;
   $Result         = safe_query($sql) ;
     $bankResult         = safe_query($banksql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
   $noOfbankRecords    = @mysql_num_rows($bankResult); // Total no of records returned
  while ($row = mysql_fetch_array( $Result))
  {

	 $saleid=$row['saleid'];
	$adminstatus=$row['adminstatus'];

	if($exportonlyuploaded == "true")
	  {
		if($adminstatus == "Uploaded")
		  {
			continue;
		  }
	  }
	  $reportrows="<tr>";
   for($j=0;$j<$reportrowcount;$j++)
	  {
		if(strlen($row[$j]))
		  {
			$value = $row[$j];
		  }
		  else
		  {
			  if($is_empty_allowed =='Y')
			  {
			  $value = "NONE";
			  }
			  else
			  {
				  $value = "";
			  }
		  }
		   if($apply_id_document_rule == 'Y')
						 {
				      if($value == 'No ID' || substr($value,0,7) == 'Others ' || $value == 'Driving Licence' || $value == 'Passport' || $value == 'School ID' || $value == 'Work ID' || $value == 'National ID' || $value == 'Any ID' || $value == 'Bank  ID')
							 {
						         if($value == 'No ID ' || substr($value,0,7) == 'Others ')
									 {
									 $value = "NO ID";
									 }
									 else
									 {
									 $value = "ANY ID";
									 }
							 }
						 }
	   $reportrows = $reportrows."<td class=Row>".$value."</td>";
	  }
	  $reportrows = $reportrows."</tr>";
	 print($reportrows);
	 
  }
 
  }
   print("</table>");
?> 

<script language=javascript>
 print();
 </script>
