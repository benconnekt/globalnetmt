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

if(isset($_POST['module'])!="")
   {
   $module=$_POST['module'];
   }
   else
   {
   $module="customersales";
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
			 if($_POST['startsalesdate']!='')
           {
            echo "".(changeddate($_POST['startsalesdate']));
			echo "-".(changeddate($_POST['endsalesdate']));
		   }?>
           <?
           if($_POST['searchagent']!='')
           {  echo "- ".getofficename($_POST['searchagent']);
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


     <? echo getMoneyTransferOrders("",$module,true,$sql,"");?>

<script language=javascript>
 print();
 </script>
  </form>
  </body>
  </html>
