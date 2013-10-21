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
$Getcomplaintid=0;
if(isset($_POST['complaintid'])!="")
   {
   $Getcomplaintid=$_POST['complaintid'];
   }
   else
   {
    $Getcomplaintid=$_GET['complaintid'];
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
       if($Getcomplaintid!="")
   {
     $sql            = "select * from complaints  where complaintid='$Getcomplaintid'";
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
	 $complaintid      = (isset($row['complaintid'])) ? $row['complaintid'] : 0;
    $question  = (isset($row['question'])) ? $row['question'] : "";
        $answer = (isset($row['answer'])) ? $row['answer'] : "";
		$currsaletype = (isset($row['saletype'])) ? $row['saletype'] : "";
		$lastupdated = (isset($row['lastupdated'])) ? $row['lastupdated'] : "";
		$orderid = (isset($row['orderid'])) ? $row['orderid'] : "";
		$complaintdate = (isset($row['complaintdate'])) ? $row['complaintdate'] : "";
       	$complaintdate = (isset($row['complaintdate'])) ? $row['complaintdate'] : "";
		$complainttime = (isset($row['complainttime'])) ? $row['complainttime'] : "";


}

 
  include('companyheader.html');

	  ?>
   <table border="0" cellpadding="2" cellspacing="2" width="100%" height="700">
   
	<tr><td width="100%" valign=top>
	
   <table border="0" cellpadding="3" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width=100% id="AutoNumber1">
  <tr><td width="100%" colspan=2 valign=top>
	<font size=2><strong>Complaint Details for Order <font color=red><? echo $orderid?></font></strong></font>
</td></tr>
   <tr>
    <td width="25%"  valign="top">Date and Time</td><td width="75%"><?php echo changeddate($complaintdate)?> <? echo $complainttime?></td>
     </tr>
	  <tr>
    <td width="25%"  valign="top">Question</td><td width="75%"><? echo nl2br($question)?></td>
     </tr>
	  <tr>
    <td width="25%" valign="top">Reply</td><td width="75%"><? echo nl2br($answer)?></td>
     </tr>
  
 </table>
</td>
</tr>
</table>


 <script language=javascript>
// print();
 </script>
 <? }
 else
 {
display_message("No record found for the complaint");
} ?>
</form>


