<?
include('imfunctions.php');
include("header.html");
include("imsidemenu.html");



global $lst_image;
global $action1;

global $id;
getIMItem($id);
// gets the details of the message for given msg id
?>

 <?php  if($officerights!='Y')
  { ?>
    <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td background="images/table_header_bkg.gif"><span class="tableHeaderText style5">Access Denied </span></td>
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
     <script language="javascript">
     function newone(file)
              {
               window.open(file);
               }
     function  formAction(val){
        document.form1.pageAction.value=val;
        document.form1.submit();
    }


    </script>

</head>

<body topmargin="5" leftmargin="5"  >

<form name=form1 method=post>

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

 <? if ((isset($pageAction) and $pageAction=="deleteAttachmentFile") ){

    deleteAttachment($lst_image);
  }
  ?>

<div align="left">
<table width="100%"  border="0" cellpadding="3" cellspacing="1" class="tableBorder">
                    <tr>
                      <td background="images/table_header_bkg.gif"><span class="tableHeaderText style5">Message Information </span></td>
                    </tr>
                    <tr>
                      <td class="Row">
  <table border="0" width="100%" cellspacing="0" cellpadding="0">

  <tr>
    <td width="16%" align="left">From</font></td>
    <td width="52%" align="left"><b>
   <?echo getuserfullname($userid);?></a></b></font></td>
  </tr>
    <tr>
    <td width="16%" align="left">To</font></td>
    <td width="52%" align="left"><? echo stripslashes(getuserfullname($to_users));?></font></td>
  </tr>
  <tr>
    <td width="16%" align="left">Date</font></td>
    <td width="52%" align="left"><?echo changeddate($Msg_Date);?> <?echo $Msg_Time;?></font></td>

  </tr>
  <tr>
    <td width="16%" align="left">Subject</font></td>
    <td width="52%" align="left">
      <p align="left"><?echo stripslashes($msg_subject);?></font></td>
  </tr>
  <tr><td colspan=2>&nbsp;</td></tr>
 <tr>
      <td width="68%" align="left" colspan="2" nowrap><b>Message</b></font><br>


      <textarea rows="10" name="msgcontent" cols="80"><?echo stripslashes($msg_content)?></textarea>

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
        <input type="Button" value="Reply Message" class="btn3"  name="B12" onClick=javascript:location.href="imad.php?id=<? echo($id);?>&action=im">
        &nbsp;&nbsp;

      </td>
    </tr>
   </table>
</form>

</td>
 </tr>
 </table>
 </form>
  </td>
  </tr>
  <? include('footer.html');   ?>
