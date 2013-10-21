<?
include('imfunctions.php');
include("header.html");
include("imsidemenu.html");



global $lst_image;
global $action1;
?>
<?php  if($officerights!='Y')
  { ?>
    <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td class="tableHeader">Access Denied </span></td>
                    </tr>
                    <tr>
                      <td class="Row">
     <table align=center border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="70%" id="AutoNumber1">
    <tr>
      <td width="18%" valign=top>
      <img border="0" src="images/EXCL.GIF" width="42" height="40"></td>
      <td width="82%" valign=top >You do not have permissions for this module.<br>
      Please contact your system administrator for office rights</td>
    </tr>

  </table>
  </td>
  </tr>
  </table>

  <? exit;
}
 ?>
<script language="javascript" src="myjs.js"></script>

<script language="javascript">


    // -- The actual records are deleted when the page is submited which is trapped below


function valid()
{

if(chkBlank(document.form1.txt_msg_subject,"Subject"))
{
if(chkBlank(document.form1.msgcontent,"Message"))
{
document.form1.txa_msg_content.value=document.form1.msgcontent.value
document.form1.pageAction.value="Insert";
document.form1.submit();
 }
}
}

function show()
{
window.document.frmupload.txt_msg_subject.value=document.form1.txt_msg_subject.value;
window.document.frmupload.txt_to_users.value=document.form1.txt_to_users.value;
window.document.frmupload.txa_msg_content.value=document.form1.txa_msg_content.value;
window.document.frmupload.submit();
}

</script>

</head>
<body bgcolor = <?echo $sess_bgcolor?> topmargin="5" leftmargin="5" >


<form name="form1" method="post" action="imad.php">
 <input Type="hidden" name="displayPageNo" value="<?echo($displayPageNo)?>" >
 <input type=hidden name="sess_userid" value="<?php echo $userid?>">
<input Type="hidden" name="pageAction" value="">
<input Type="hidden" name="dataOrder" value="userid">
<input Type="hidden" name="folderName" value=<?echo $folderName?>>
<input type="hidden" name=id value="<?echo $id;?>">
<input type="hidden" name=vuid value="<?echo $vuid;?>">
<input type="hidden" name="role" >
<input type="hidden" name="arr" value="<?echo $arr;?>">
<input type="hidden" name="userid" value="<?echo $id;?>">
<input type="hidden" name="txt_url" size="24" value="<?echo $HTTP_REFERER;?>">
<?
    global $pageAction;
    global $data1;
     //  global $lst_image;


$action= isset($action)?$action:"";
 //actions bases on the component from which inter messaging is called
  if($action=="ex")
   ex2in($id);
    if($action=="da")
   da2in($id);
    if($action=="ta")
   ta2in($id);
    if($action=="rm")
   rm2in($id);
     if($action=="ap")
   ap2in($id);
      if($action=="im")
   in2in($id);

 if (isset($pageAction) and $pageAction=="Insert")
 {     ?>
  <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td class="tableHeader">Message sent Information </span></td>
                    </tr>
                    <tr>
                      <td class="Row">
<? insertMessage();?>
</td>
 </tr>
 </table>
 </td>
  </tr>
  <? include('footer.html');   ?>
 <?
 exit;
 }

?>

<table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td class="tableHeader">Compose Message Information </span></td>
                    </tr>
                    <tr>
                      <td class="Row">
                      <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td width="50%" valign=top align="left">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td width="30%" align="left"  valign="top">To</font></td>
    <td width="40%" align="left"  valign="top"><input type=text name="txt_to_users1" value="<?php echo getusername($txt_to_users)?>" readonly size=40>
    <input type=hidden name="txt_to_users" value="<?php echo $txt_to_users?>" readonly size=40>
    </td>
	<?if($userrole=='Administrator' || $superuserrights == 'Y')
			 {?>
  <td class=Row rowspan=3 valign="top">
<iframe src="userlists.php" name=bol width="400" height="500" marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="auto" align="right" >
</iframe>
</td>
<? } ?>
  </tr>
  <tr>
    <td  width="30%" align="left"  valign="top" >Subject </font></td>
    <td width="40%" align="left"  valign="top"><input type="text" name="txt_msg_subject" size="40" value="<?echo stripslashes($txt_msg_subject)?>">
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" width="30%">Message</td>
    <td width="40%" align="left" valign="top"><input type=hidden name="txa_msg_content" >
      <textarea rows="10" name="msgcontent" cols="60"><?echo stripslashes($txa_msg_content)?></textarea></td>
	  
</tr>
  </table>
  </td>
</tr>

  </table>



  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2">
        <?
    // -- Displaying the posting resulys

    ?>
    <tr>
      <td>
      <? if ($addrights=='Y')
    {?>
      <input type=button class="btn3" onmouseover="this.className='btn btnhov1'" onmouseout="this.className='btn3'"  onclick="javascript:valid()" name=s1 value="  Submit Information" >
      <?}
      else {?>
      <input type=button class="btn3" onmouseover="this.className='btn btnhov1'" onmouseout="this.className='btn3'"  onclick="javascript:valid()" name=s1 value="  Submit Information" disabled>
      <?}?>
       </td>
    </tr>
   </table>
 </td>
 </tr>
 </table>
 </form>
  </td>
  </tr>
  <? include('footer.html');   ?>
