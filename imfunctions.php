<?
session_start();
  if($_SESSION["MM_LOCKSTATUS"] == 'Y' && base64_decode($_GET['status'])!="logout")
		{
		 header ("Location:agentlocked.php");
		exit;
		}
 include('inc_header.php');
 error_reporting(0); 
 $pagetitle = "Home";
if(isset($_SESSION["MM_Username1"]))
{
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
$alertrights=$_SESSION["MM_ALERTRIGHTS"];

//echo "the agent id is ".$agentid;
if(ispayingagent($userid)=='Y')
	  {
	$payingagentid = $agentid;
	
	  }
$agenttype=$_SESSION["MM_AGENTTYPE"];
$agentcommission=$_SESSION["MM_AGENTCOMMISSION"];
}
$is_im =1;

function getProfile($id){

    global $userid;
    global $user_fname;
    global $email;
    global $user_lname;
    global $phone;
    global $Remarks;
    global $address;

    $sql            = "select userid,userid,user_fname,user_lname,email,phone,address,Remarks from users where userid='$id'";
    $Result         = safe_query($sql) ;
    $temp           = mysql_num_rows($Result);
    $userid         = mysql_result($Result,0,'userid') ;
    $user_fname     = mysql_result($Result,0,'user_fname') ;
    $user_lname     = mysql_result($Result,0,'user_lname') ;
    $email          = mysql_result($Result,0,'email') ;
    $phone          = mysql_result($Result,0,'phone') ;
    $Remarks        = mysql_result($Result,0,'Remarks') ;
    $address        = mysql_result($Result,0,'address') ;
    }


 function getIMItem($id){

    global $userid;
    global $to_users;
    global $msg_subject;
    global $Msg_Date;
    global $msg_content;
    global $sess_userid;
	global $Msg_Time;

    $sql             = "update im_items set Send_Recd='Y' where Msgid=$id ";  // Marking as sen
    $Result          = safe_query($sql) ;
    

    //echo $sql;
    $sql             = "select msgid,Msg_Time,Msg_Date,userid,msg_subject,to_users,Msg_Content from im_master where Msgid=$id";
    $Result          = safe_query($sql) ;
    $temp            = mysql_num_rows($Result);
    $userid          = mysql_result($Result,0,'userid') ;
    $to_users        = mysql_result($Result,0,'to_users') ;
    $msg_subject     = mysql_result($Result,0,'msg_subject') ;
    $Msg_Date        = mysql_result($Result,0,'Msg_Date') ;
	$Msg_Time        = mysql_result($Result,0,'Msg_Time') ;
    $msg_content     = mysql_result($Result,0,'msg_content') ;
    }


function deleteIMItems(){

    global $chk_box;
    for($count = 0; $count < sizeof($chk_box); $count++) {
        $sql   = "delete from  im_items where autoid= $chk_box[$count]" ;
        $Result1= safe_query($sql) ;
    }
}

function deleteIMItem($val){
    $sql   = "delete from  im_items where autoid= $val" ;
   // echo $sql;
    $Result1= safe_query($sql) ;
}


function moveFolderIMItems(){

    global $chk_box;
    global $cmb_Folders;
    for($count  = 0; $count < sizeof($chk_box); $count++) {
        $sql    = "update im_items set folderid = '$cmb_Folders'  where autoid = $chk_box[$count]" ;
        $Result2= safe_query($sql) ;
    }
}


function moveIMItems(){

    global $Msgid;
    global $row;
    global $userid;
    global $to_users;
    global $Msg_subject;
    global $Msg_date;
    global $msg_content;
    global $Msg_size;
    global $Autoid;
    global $Send_Recd;
	global $Msg_Time;

    
    $Msgid       = (isset($row['Msgid'])) ? $row['Msgid'] : 0;
    $userid      = (isset($row['Userid'])) ? $row['Userid'] : 0;
    $Autoid      = (isset($row['Autoid'])) ? $row['Autoid'] : 0;
    $to_users    = (isset($row['to_users'])) ? $row['to_users'] : 0;
    $Msg_subject = (isset($row['Msg_subject'])) ? $row['Msg_subject'] : 0;
    $Msg_date    = (isset($row['Msg_date'])) ? $row['Msg_date'] : 0;
	 $Msg_Time    = (isset($row['Msg_Time'])) ? $row['Msg_Time'] : "";
    $Msg_size    = (isset($row['Msg_size'])) ? $row['Msg_size'] : 0;
    $Send_Recd        = (isset($row['Send_Recd'])) ? $row['Send_Recd'] : 0;
}


function emptyRows($rows,$span){

    $temp="";
    for ($k = 1; $k <= $rows; $k++){
        $temp=$temp."<tr><td class=ROW >&nbsp;</td><td class=ROW >&nbsp;</td><td class=ROW >&nbsp;</td><td class=ROW >&nbsp;</td><td class=ROW >&nbsp;</td><td class=ROW >&nbsp;</td></tr>";
    }
    return($temp);
}

function addFolder($fname){

    global $sess_userid;
    $sql            = "insert into folders (Userid,foldername,foldertype) Values ('$sess_userid','$fname','IN')";
    if($fname!="")
    {
    $Result         = safe_query($sql) ;
    }
  //  header("Location:imin.php");
    }

function deleteFolder($fname){

    global $sess_userid;
    $sql           ="Delete from folders where foldername='$fname' and foldertype='IN'";
    $Result        = safe_query($sql) ;
    $sql           ="Delete from im_items where folderid='$fname'";
    if($fname!="")
    {
    $Result         = safe_query($sql) ;
    }
   // header("Location:imin.php");
    }

function foldersIM($name,$selected){

    global $sess_userid;
    global $sess_bgcolor;
    $temp   = "<select size=1 name=".$name." style=\"background-color:".$sess_bgcolor."; border-style: solid\"".">";

    if($selected=="InBox")
    $temp   = $temp."<option value=InBox selected>InBox</option>";
    else
    $temp   = $temp."<option value=InBox>InBox</option>";
    if($selected=="Sent")
    $temp   = $temp."<option value=Sent selected>Sent</option>";
    else
    $temp   = $temp."<option value=Sent>Sent</option>";
    if($selected=="Trash")
    $temp   = $temp."<option value=Trash selected>Trash</option>";
    else
    $temp   = $temp."<option value=Trash>Trash</option>";
    if($selected=="All")
    $temp   = $temp."<option value=All selected>All</option>";
    else
    $temp   = $temp."<option value=All>All</option>";
    $sql    = "select foldername,folderid from folders where userid='".$sess_userid."' and foldertype='IN'";  // folders of the user
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result)) {
        $foldername  = (isset($row['foldername'])) ? $row['foldername'] : 0;
        $folderid    = (isset($row['folderid'])) ? $row['folderid'] : 0;
       if($selected==$foldername)
        $temp        = $temp."<option value='".$foldername."' selected>".$foldername."</option>";
        else
        $temp        = $temp."<option value='".$foldername."'>".$foldername."</option>";
    }
    $temp = $temp."</select>";
    return($temp);
}



function deleteFiles(){

    global  $usr_sess;
    $usr_sess  =session_id();
    $sql       ="delete from tblcombo where usrsession = '$usr_sess'";
    $result    = safe_query($sql) ;
}

function da2im($id) {

    global $userid;
    global $txt_msg_subject;
    global $txa_msg_content;
    global $autoid;
    global $sess_userid;

    $sql             = "select autoid,dairy_subject,dairy_content from dairy where autoid=".$id." and userid='".$sess_userid."'";
    $Result          = safe_query($sql) ;
    $autoid = mysql_result($Result,0,'autoid') ;
    $txt_msg_subject = "Dairy:".mysql_result($Result,0,'dairy_subject') ;
    $txa_msg_content = "Dairy:".mysql_result($Result,0,'dairy_content') ;
    $txa_msg_content = $txa_msg_content."\n\n\n".$sess_userid."\nDate:".date("Y-m-d:H:i");
}


// -- Inserting messages in to the master and child records
function insertMessage(){

    global $sess_userid;
    global $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    global $pageAction;
    global $DisplayResult;
    global $lst_image  ;
    global $mobilephone;
    global $sendmobile;
    global $txt_group;


   if((substr($txt_to_users, -1)==",") )
    {
        $txt_to_users=substr($txt_to_users, 0, strlen ($txt_to_users)-1) ;
    }
      if((substr($txt_to_users, 0,1)==",") )
    {
        $txt_to_users=substr($txt_to_users, 1, strlen ($txt_to_users)) ;
    }
    $pieces    = explode(",", $txt_to_users);
    $noOfUsers = sizeof($pieces);
    $msg_len   = strlen($txa_msg_content);
    $Date1     = date("Y-m-d:H:i");
    $temp      = "";
    $messagestatus="sent";

         if($messagestatus=='sent')
         {
                // -- Inserting message into the master record



          // -- Inserting records into to_users table for each of the users
          // -- Sender record insertion - 1 record





              // -- now inserting the receiver record(s) -  one record per user
          for($count = 0; $count < sizeof($pieces); $count++)
            {
			$msgtime =  date("H:i:s", UKdst_time());
            $sql="insert into im_master
          (Userid,Msg_subject,to_users,Msg_content,Msg_date,msg_size,msg_users,Msg_Time)
          Values ('$sess_userid','$txt_msg_subject','$pieces[$count]','$txa_msg_content','$Date1',$msg_len,$noOfUsers+1,'$msgtime')";
          $Result= safe_query($sql) ;
          $inserted_msgid = mysql_insert_id();
          
           $sql    =  "insert into im_items
                  (Userid,Msgid,folderID,Send_recd)
                  Values ('$pieces[$count]',$inserted_msgid,'InBox','')";
                //  echo $sql;
           $Result   =   safe_query($sql) ;
          

           }
            $sql="insert into im_items
          (Userid,Msgid,folderID,Send_recd)
          Values ('$sess_userid',$inserted_msgid,'Sent','S')";
          $Result= safe_query($sql) ;

           if ($recs=1) $DisplayResult = "Message Succesfully  sent to".$noOfUsers." users";
           if($recs>0 and $Result=="" and $DisplayResult=""){
             $DisplayResult="Message could not be posted...";
            }
             $pageAction="";

            if((substr($txt_to_users, -1)==",") ){
             $txt_to_users=substr($txt_to_users, 0, strlen ($txt_to_users)-1) ;
            }
             $pieces = explode(",", $txt_to_users);

             $noOfUsers = sizeof($pieces);
             $msg_len   = strlen($txa_msg_content);
             $Date1     = date("Y-m-d:H:i");

    }
    echo "<font color=red><b>".$DisplayResult."</b></font>";
 return($DisplayResult);
 }



function viewAttachments($name){

    global $id;
    global $FilePath;
    global $FileName;
    global $sess_bgcolor;
    $temp   = "<SELECT NAME=lst_image onClick= \"javascript:newone(document.form1.lst_image.options[document.form1.lst_image.selectedIndex].value)\"; style=\"background-color:".$sess_bgcolor."; border-style: solid\"".">";

    $sql    = "select FilePath,FileName from attachments where Ref_ID ='".$id."' and Ref_Type= 'IM' ";  // folders of the user
  //  echo $sql;
    $Result = safe_query($sql) ;
     $num            = mysql_num_rows($Result);
    while ($row      = mysql_fetch_array( $Result)) {
        $FilePath  = (isset($row['FilePath'])) ? $row['FilePath'] : 0;
        $FileName    = (isset($row['FileName'])) ? $row['FileName'] : 0;
        $temp        = $temp."<option  value='".$FilePath."' selected>".$FileName."</option>";
    }
    $temp = $temp."</select>";
    $temp=$temp."";
    $temp="<font size=\"2\">View Attachments</font>".$temp ;
     if($num>0){
    return($temp);
    }
}

function deleteAttachment($lstImage){

    global $sess_userid;
    $sql           ="Delete from attachments where  FilePath='$lstImage'";
    $Result       = safe_query($sql) ;
}

function da2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject="";
    $txt_to_users="";
    $txa_msg_content="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select dairy_subject,dairy_content from dairy where autoid=".$id;
    $Result = safe_query($sql) ;


    $txt_msg_subject = mysql_result($Result,0,'dairy_subject') ;
    $txa_msg_content = mysql_result($Result,0,'dairy_content') ;
    }


}

  function rm2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject="";
    $txt_to_users="";
    $txa_msg_content="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select rem_subject,rem_content from reminders where reminderid=".$id;
    $Result = safe_query($sql) ;
    $txt_msg_subject = mysql_result($Result,0,'rem_subject') ;
    $txa_msg_content = mysql_result($Result,0,'rem_content') ;
    }
}

function ta2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject="";
    $txt_to_users="";
    $txa_msg_content="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select task_subject,task_content from tasks where taskid=".$id;
    $Result = safe_query($sql) ;


    $txt_msg_subject = mysql_result($Result,0,'task_subject') ;
    $txa_msg_content = mysql_result($Result,0,'task_content') ;
      }
}


function ap2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject="";
    $txt_to_users="";
    $txa_msg_content="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select app_subject,app_content from appointments where autoid=".$id;
    $Result = safe_query($sql) ;


    $txt_msg_subject = mysql_result($Result,0,'app_subject') ;
    $txa_msg_content = mysql_result($Result,0,'app_content') ;
    }

}

function in2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject="";
    $txt_to_users="";
    $txa_msg_content="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select msg_subject,msg_content,userid from im_master where msgid=".$id;
    //echo $sql;
    $Result = safe_query($sql) ;


    $txt_msg_subject = "Re:".mysql_result($Result,0,'msg_subject') ;
    $txa_msg_content = mysql_result($Result,0,'msg_content') ;
    $txt_to_users = mysql_result($Result,0,'userid') ;
    
    $sql             = "update im_items set Send_Recd='R' where Msgid=$id ";  // Marking as sent
    $Result          = safe_query($sql) ;
    //echo $sql;


    }

}



function ex2in($id) {

    global $userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    $txt_msg_subject  ="";
    $txt_to_users     ="";
    $txa_msg_content  ="";
    global $autoid;
    global $sess_userid;
      if($id>0)
      {
    $sql   = "select expenses_subject,expenses_content from expenses where expensesid=".$id;
    $Result = safe_query($sql) ;


    $txt_msg_subject = mysql_result($Result,0,'expenses_subject') ;
    $txa_msg_content = mysql_result($Result,0,'expenses_content') ;
    }

}


function addFile($filename1_name,$FileName,$filename1_size,$MFileName,$txt_to_users1,$txt_msg_subject1,$txa_msg_content1,$txt_group){

     global  $usr_sess;
     global $sess_userid;
    global  $txt_msg_subject;
    global $txt_to_users;
    global $txa_msg_content;
    global $txt_group;
    $txt_msg_subject  =$txt_msg_subject1;
    $txt_to_users     =$txt_to_users1;
    $txa_msg_content  =$txa_msg_content1;
     $usr_sess=session_id();

    $sql           = "insert into tblcombo
                     (cmbText,cmbValue,usrsession)
                     Values
                     ('$filename1_name','$FileName@$filename1_size~$MFileName','$usr_sess')";
   $Result         = safe_query($sql) ;

header("Location:imad.php?txt_to_users=".urlencode($txt_to_users)."&txt_msg_subject=".urlencode($txt_msg_subject)."&txa_msg_content=".urlencode($txa_msg_content)."&txt_group=".urlencode($txt_group)."");
 //echo("Location:imad.php?txt_to_users='$txt_to_users'&txt_msg_subject='$txt_msg_subject'&txa_msg_content='$txa_msg_content'");
// echo "txt_to_users=$txt_to_users&txt_msg_subject=$txt_msg_subject&txa_msg_content=$txa_msg_content";
  }

function showFile(){

    global  $usr_sess;
    $usr_sess=session_id();
    $sql="select cmbText,cmbValue from tblcombo where usrsession = '$usr_sess'";
    $Result    = safe_query($sql) ;
    $rows=mysql_num_rows($Result);
    if($rows<>0){
    echo "<SELECT NAME=lst_image[] id=lst_image multiple size=2 >";
    for ($i=0; $i<$rows; $i++) {
    echo "<OPTION VALUE=".mysql_result($Result,$i,1).">".mysql_result($Result,$i,0)."</OPTION>";
    }
    echo " </SELECT><a href=\"JavaScript:formAction1('deleteAttachmentFile')\" target=\"_self\"> <img border=\"0\" src=\"images/delete.gif\" alt=\"Delete selected attachment\" width=\"17\" height=\"15\"></a>";
    }

}


function getGroups($name,$selected){

    global $sess_userid;
    global $sess_bgcolor;
    $temp= "<select size=1 name=".$name." style=\"background-color:".$sess_bgcolor."; border-style: solid\"".">";
            $sql="select group_name from groups_master";
   // $sql= "select userid from users";  // folders of the user
    $Result = safe_query($sql) ;
    $temp  = $temp. "<option value=\"None\">"."None"."</option>"  ;
    while ($row = mysql_fetch_array( $Result)) {
    $username  = (isset($row['group_name'])) ? $row['group_name'] : "";
    if($selected==$username)
    $temp        = $temp."<option value=".$username." selected>".$username."</option>";
    else
    $temp        = $temp."<option value=".$username.">".$username."</option>";
    }
    $temp = $temp."</select>";
    return($temp);
}

function deleteAttachmentFile($lstImage){

    global  $usr_sess;

         $usr_sess    = session_id();
         $sql         = "delete from tblcombo where usrsession = '$usr_sess' and cmbValue='$lstImage' ";
         $result      = safe_query($sql) ;

}


function getuserfullname($sessuserid)
{ $sql    = "select firstname,lastname from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : "";
        $lastname  = (isset($row['lastname'])) ? $row['lastname'] : "";
      }
    return($firstname." ".$lastname);
}

?>
