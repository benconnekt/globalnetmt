<?
include('imfunctions.php');
include("header.html");
include("imsidemenu.html");


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
    // To get next page or the given page no - val
    function nextPage(val){
        document.form1.displayPageNo.value=val;
        document.form1.action="imin.php?PAGE="+val;
        document.form1.submit();
    }

    // -- The actual records are deleted when the page is submited which is trapped below
    function  formAction1(val){
    var agree=confirm("Do you wish to delete the selected messages ?");
if (agree)
{
        document.form1.pageAction.value=val;
        document.form1.submit();
        }
else
{
        return false ;
        }



    }
     function  formAction2(val){
         var agree=confirm("Do you wish to delete the folder ?");
if (agree)
{
         document.form1.pageAction.value=val;
        document.form1.submit();
        }
else
{
        return false ;
        }




    }
     function  formAction3(val){
         var agree=confirm("Do you wish to move the selected messages to the selected folder ?");
if (agree)
{
         document.form1.pageAction.value=val;
        document.form1.submit();
        }
else
{
        return false ;
        }




    }
    
     function  formAction4(val){
         var agree=confirm("Do you wish to create a new folder ?");
if (agree)
{
         document.form1.pageAction.value=val;
        document.form1.submit();
        }
else
{
        return false ;
        }




    }

    // -- the order in which the sorting must be done
    function pageOrder(val){
        document.form1.dataOrder.value=val;
        document.form1.submit();
    }

    function goFolder(){
        document.form1.submit();
    }
    function setFolder(){

        parent.frames("if2").document.location ="imad.php"

    }

    function moveFolder(){
        document.form1.pageAction.value="MoveFolder";
        document.form1.submit();
    }

</script>


</head>
  <form name="form1"  method=post action="imin.php">
  <?
    $txt_search=isset($txt_search)?$txt_search:"";
  $DISP_REC_COUNT = 20;  // No of rows appearing per page
  $displayPageNo  = (isset($displayPageNo)) ? $displayPageNo : 1; // Currenet page being displayed
  $folderName     = isset($folderName)?$folderName:"InBox";
  $cmd_folders     = isset($cmd_folders)?$cmd_folders:"";
  ?>
  <input Type="hidden" name="displayPageNo" value="<?echo($displayPageNo)?>" >
<input Type="hidden" name="pageAction" value="">
<input Type="hidden" name="dataOrder" value="userid">
<input Type="hidden" name="folderName" value="InBox">
 <input type=hidden name="sess_userid" value="<?php echo $userid?>">
<input type="hidden" name=id value="<?echo $id;?>">
<input type="hidden" name=vuid value="<?echo $vuid;?>">
<input type="hidden" name="role" >
<input type="hidden" name="arr" value="<?echo $arr;?>">
<input type="hidden" name="userid" value="<?echo $id;?>">
<input type="hidden" name="txt_url" size="24" value="<?echo $HTTP_REFERER;?>">
  <?
  //  Deleted all checked records
  if ((isset($pageAction) and $pageAction=="deleteItem") and isset($chk_box) ){
     deleteIMItems();
  }


  if (isset($pageAction) and $pageAction=="addFolder"){
     addFolder($txt_foldername);
  }

  if (isset($pageAction) and $pageAction=="deleteFolder"){
     deleteFolder($cmb_Folders);
  }

  // ---  move the data to specific folder for specified records
  if ((isset($pageAction) and $pageAction=="moveToFolder") and isset($chk_box) ){
     moveFolderIMItems();
     $dataOrder="msg_date";
  }


  // -- Set all the standard variables


   $dataOrder      = isset($dataOrder)?$dataOrder:"autoid";      // order in which the data must appear
  $sql            = "select im_items.Msgid,im_items.Autoid,im_master.Userid as Userid,to_users,Msg_subject,";
  $sql            = $sql." Msg_content,Msg_date,Msg_Time,Msg_replyid,Msg_size,Msg_users,folderId,Send_Recd from im_items,im_master ";
  $temp           = " where im_items.userid='$userid' and folderid='".$folderName."' and im_items.msgid=im_master.msgid order by ".$dataOrder." desc ";
  if ($folderName=="All"){
     $temp        = "  where im_items.userid='$userid' and im_items.msgid=im_master.msgid order by ".$dataOrder." desc ";
  }
  if ($txt_search!=""){
     $temp        = " where im_items.userid='$userid'  and im_items.msgid=im_master.msgid and ";
     $temp        = $temp." ( msg_content like '%$txt_search%' or msg_subject like '%$txt_search%' )order by ".$dataOrder." desc ";
  }
  $sql            = $sql.$temp;
 //echo $sql;
  $Result         = safe_query($sql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
  $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise
  $TR             = 0;
  $i              = 0;
  // Get the result set
  ?>

  <table border="0" cellspacing="0" cellpadding="0" width="100%" >
    <tr>
      <td width="30%" class="tableHeader">
        <b>
      <?echo $folderName.": <font color=#FFFF00>".$noOfRecords?> items</font></b>
    </td>


      <td width="40%" nowrap class="tableHeader">
        <p align="right">

        <input type=text maxlength=15 name=txt_search value = "<?echo $txt_search?>">
        <a  href="JavaScript:goFolder()" ><font color="#FFFF00">&nbsp;Search</font></a>
        &nbsp;&nbsp;
             </td>
  </tr>
</table>
<hr width=100%>
  <table border="1" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse" class="tableBorder">
    <tr>
     <td width="30" class="tableHeader">
      <p align="left"><font color="#FFFFFF">
      <a href="javascript:pageOrder('Send_Recd')" ><font color="#FFFFFF">#</font></a></font></p>
      </td>
      <td width="100" class="tableHeader">
      <p align="left"><font color="#FFFFFF">
      <a href="javascript:pageOrder('msg_date')" ><font color="#FFFFFF">Date</font></a></font></p>
      </td>
      <td width="150" class="tableHeader">
      <p align="left"><a href="javascript:pageOrder('Msg_Users')" >
      <font color="#FFFFFF">From</font></a></p>
      </td>
      <td width="150" class="tableHeader">
      <p align="left"><a href="javascript:pageOrder('to_users')" >
      <font color="#FFFFFF">To</font></a></p>
      </td>
      <td width="200" class="tableHeader">
      <p align="left"><a href="javascript:pageOrder('msg_Subject')" >
      <font color="#FFFFFF">Subject</font></a></p>
      </td>
      <td width="53" class="tableHeader">
      <p align="center"><font size="2">?</font></p>
      </td>
  </tr>

  <?
  while ($row = mysql_fetch_array( $Result)) {
      $i=$i+1;
      if(($i>($displayPageNo-1)*$DISP_REC_COUNT) and ($i<=$displayPageNo*$DISP_REC_COUNT ))  {
          moveIMItems();
          ?>
          <tr>
          <?$TR=$TR+1?></tr>
          <?
 $img_src="newmail.gif";
  if ( $Send_Recd=="S"){
    $img_src="newmail.gif";
 }
 if ( $Send_Recd=="Y"){
    $img_src="openmail.gif";
 }
 if ( $Send_Recd=="R"){
    $img_src="reply.gif";
 }
 if ( $Send_Recd=="S"){
    $img_src="sent.gif";
 }
 ?>

       <td width="30" height="15" class="Row"><img src="images/<?echo $img_src?>"></font></td>
      <td width="100" height="15" class="Row"><a href="imvu.php?id=<?echo($Msgid)?>" ><?echo changeddate($Msg_date) ?> <?echo $Msg_Time;?></a></font></td>
      <? $pos = strpos($userid, "@");
      if($pos==false)
      {?>
      <td width="150" height="15" class="Row"><a href="imvu.php?id=<?echo($Msgid)?>" >
   <?} else {?>
         <td width="150" height="15" class="Row">
         <?}?>
     <?echo (getuserfullname($userid));?></font></a></td>

      <td width="150" height="15" class="Row"><?echo(getuserfullname($to_users));?></font></td>

      <td width="200" height="15" class="Row">
      <a href="imvu.php?id=<?echo($Msgid)?>" >
      <?
      if ( $seen!="Y"){
         echo "<b>";
      }
      ?>
     <?echo stripslashes(($Msg_subject)) ?></a></font></b></td>
      <td width="53" align="center" height="15" class="Row">
      <input type="checkbox" name="chk_box[]" value="<?echo($Autoid);?>">

</td>
          </tr>
      <?}  // End of if
  } // End of WHile
  echo emptyRows($DISP_REC_COUNT-$TR,5);
  ?>

</table>
<hr width=100%>
  <table border="0" width="100%" cellspacing="4" cellpadding="4">
    <tr>   
          <td height="13" align=right>
          <B><font color=red>  <input type="Button" class="btn3" onmouseover="this.className='btn btnhov1'" onmouseout="this.className='btn3'"   value="Delete" name="B12" onClick="JavaScript:formAction1('deleteItem')">
        &nbsp;&nbsp;
        </font>
        <?
        // -- First page has no previous ????
        if ((int)($displayPageNo)>1){?>

          <a href="JavaScript:nextPage(<?echo($displayPageNo-1);?>)" target="_self" >
          Previous</a>
        <?}
        // -- Last page has no next
        if ((int)($displayPageNo)!=(int)($noOfPages)) {?>

           <a href="JavaScript:nextPage(<?echo($displayPageNo+1);?>)" target="_self">
           Next</a>
        <?}?>


        <select size="1" name="cmbselect" style="background-color:<?echo $sess_bgcolor?>; border-style: solid; border=0">
          <?for ($j = 1; $j <= $noOfPages; $j++) {?>
          <option value="<?echo($j);?>"<?if ((int)(trim($j))==(int)(trim(($displayPageNo)))) {
                    // -- ensuring the selected page no is in the combo box for next page
                    echo("SELECTED"." ".":"."");}?> ><?echo($j);?> </option>
          <?}?>
        </select>
               <input type="Button" class="btn3" onmouseover="this.className='btn btnhov1'" onmouseout="this.className='btn3'"   value="Go" name="B12" onClick="JavaScript:nextPage(document.form1.cmbselect.value)">  &nbsp;&nbsp;&nbsp;
</td>
    </tr>
  </table>
  </form>
  </td>
  </tr>
  <? include('footer.html');   ?>
