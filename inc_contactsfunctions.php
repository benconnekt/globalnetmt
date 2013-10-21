<?
function getaccountcontactnames($name,$selected)
{
    $temp   = "<select name=".$name."  class=bigSelect  ".">";

   $sql    = "select contactid,firstname,surname from contact_master where contactstatus='Active' order by firstname ASC"; // folders of the user
  // echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
         $surname  = (isset($row['surname'])) ? $row['surname'] : 0;
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
		$dob  = (isset($row['dob'])) ? $row['dob'] : "";
        $contactid    = (isset($row['contactid'])) ? $row['contactid'] : 0;

        if($selected==$contactid)
            $temp        = $temp."<option value='".$contactid."' selected>".stripslashes($firstname)."-".stripslashes($surname)."-".getcustomeridno($contactid)."</option>";
        else
            $temp        = $temp."<option value='".$contactid."'>".stripslashes($firstname)."-".stripslashes($surname)."-".getcustomeridno($contactid)."</option>";
    }
         if($selected=='')
       {
     $temp        = $temp."<option value='' selected>PLEASE SELECT ONE</option>";
     }
     else
      {
     $temp        = $temp."<option value=''>PLEASE SELECT ONE</option>";
     }
    $temp = $temp."</select>";
    return($temp);
}
  function addimage($filename,$contactid,$documenttype,$documentno,$documentexpiry,$verifiedby,$description)

{
	$documentexpiry = dateConvert($documentexpiry);
	$insertSQL = "INSERT INTO proof_images (imagename, contactid, documenttype,documentno,documentexpiry,verifiedby,description) VALUES ('$filename','$contactid','$documenttype','$documentno','$documentexpiry','$verifiedby','$description')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
   display_message( "<b><p align=center>Proof of ID/Address Document Information has been successfully added</p>");
}

  function addpaymentimage($filename,$paymentid,$expenseid,$agentid)

{
	$insertSQL = "INSERT INTO payment_images (imagename, paymentid, expenseid,agentid) VALUES ('$filename','$paymentid','$expenseid','$agentid')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
   display_message( "<b><p align=center>Payment/Expense Document Information has been successfully added</p>");
}

function deletePaymentImage($val)
{
	$sql="select imagename from payment_images where imageid='$val'";
	 $Result          = safe_query($sql);
	   while ($row = mysql_fetch_array( $Result))
  {
    $imagename      = (isset($row['imagename'])) ? $row['imagename'] : 0;
   }
   if($imagename!='noimage.gif' || $imagename!='')
	{
	    $file="globalnetmt/proofimages/".$imagename;
       $conn = ftp_connect("ftp.global-nett.co.uk") or die("Could not connect");
		ftp_login($conn,"u49081853","Alt&*Globalnet091");
		ftp_delete($conn,$file);
		ftp_close($conn);
	}
	    $sql   = "delete from payment_images where imageid= $val" ;
        $Result1= safe_query($sql) ;

	
}

function getcustomerIdTypes($name,$selected)
{
	$idString="<select name=".$name." class=bigSelect>";
	if($selected!='')
	  {
	$idString= $idString."<option value='".$selected."'>".$selected."</option>";
	 } else 
	 {
	$idString= $idString."<option value='' >Choose one</option>";
	 }
  $idString= $idString."<option value='UK NAME ID' >UK NAME ID</option><option value='PASSPORT'>PASSPORT</option><option value='PHOTO DRIVING LICENCE OTHERS'>PHOTO DRIVING LICENCE OTHERS</option><option value='ADDRESS UTILITY BILL'>ADDRESS UTILITY BILL</option><option value='BANK STATEMENT'>BANK STATEMENT</option><option value='OTHERS'>OTHERS</option></select>";

return $idString;
}
function datesBetween($startdate, $enddate){
    // get the number of days between the two given dates.
    $datefrom = str_replace('/','-', $startdate);
	$dateto   = str_replace('/','-', $enddate);
// calc to seconds
$datefrom = strtotime($datefrom, 0);
$dateto   = strtotime($dateto, 0);
// calc difference in seconds
$difference = $dateto - $datefrom;
    $startMonth = date("m", strtotime($startDate));
    $startDay = date("d", strtotime($startDate));
    $startYear = date("Y", strtotime($startDate));    
    $dates;//the array of dates to be passed back
    for($i=0; $i<$difference; $i++){
        $dates[$i] = date("d/m/Y", mktime(0, 0, 0, ($startDay+$i) ,$startMonth , $startYear));
    }
    return $dates;    
}

function getdatediff($startdate,$enddate)
{
	//echo "the startdate is ".$startdate;
	//echo "the enddate is ".$enddate;

// convert dots to hyphens
$datefrom = str_replace('/','-', $startdate);
$dateto   = str_replace('/','-', $enddate);
// calc to seconds
$datefrom = strtotime($datefrom, 0);
$dateto   = strtotime($dateto, 0);
// calc difference in seconds
$difference = $dateto - $datefrom;
// reformat to days
$datediff = floor($difference / 86400);

return $datediff;

}

function deleteImage($val)
{
	$sql="select imagename from proof_images where imageid='$val'";
	 $Result          = safe_query($sql);
	   while ($row = mysql_fetch_array( $Result))
  {
    $imagename      = (isset($row['imagename'])) ? $row['imagename'] : 0;
   }
   if($imagename!='noimage.gif' || $imagename!='')
	{
	    $file="globalnetmt/proofimages/".$imagename;
       $conn = ftp_connect("ftp.global-nett.co.uk") or die("Could not connect");
		ftp_login($conn,"u49081853","Alt&*Globalnet091");
		ftp_delete($conn,$file);
		ftp_close($conn);
	}
	    $sql   = "delete from proof_images where imageid= $val" ;
        $Result1= safe_query($sql) ;

	
}


 function getagentname($sessuserid)
{
 $sql    = "select agentname from user_master a,agent_master b where a.useroffice=b.agentid and a.userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
 }
    return(stripslashes($agentname));
}

 function getagentlockstatus($sessuserid)
{
 /*$sql    = "select b.lockstatus from user_master a,agent_master b where a.useroffice=b.agentid and a.userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $lockstatus = (isset($row['lockstatus'])) ? $row['lockstatus'] : "";
 }
    return(stripslashes($lockstatus));*/
}

 function getcontactdocumenttypes($contactid)
{
	$documenttype="";
 $sql    = "select documenttype from proof_images where contactid='$contactid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $documenttype = $documenttype.$row['documenttype']."<br>";
 }
    return(stripslashes($documenttype));
}
function getagentidold($sessuserid)
{
 $sql    = "select agentid from user_master a,agent_master b where a.useroffice=b.agentid and a.userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentid = (isset($row['agentid'])) ? $row['agentid'] : "";
 }
    return($agentid);
}
function getagentid($sessuserid)
{
 $sql    = "select useroffice from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $useroffice = (isset($row['useroffice'])) ? $row['useroffice'] : "";
 }
    return($useroffice);
}
 function getuseroffice($sessuserid)
{
 $sql    = "select useroffice from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $useroffice = (isset($row['useroffice'])) ? $row['useroffice'] : "";
 }
    return($useroffice);
}

function getDateDifference($dateFrom, $dateTo, $unit = 'd')
{
   $difference = null;

   $dateFromElements = split(' ', $dateFrom);
   $dateToElements = split(' ', $dateTo);

   $dateFromDateElements = split('-', $dateFromElements[0]);
   $dateFromTimeElements = split(':', $dateFromElements[1]);
   $dateToDateElements = split('-', $dateToElements[0]);
   $dateToTimeElements = split(':', $dateToElements[1]);

   // Get unix timestamp for both dates

   $date1 = mktime($dateFromTimeElements[0], $dateFromTimeElements[1], $dateFromTimeElements[2], $dateFromDateElements[1], $dateFromDateElements[0], $dateFromDateElements[2]);
   $date2 = mktime($dateToTimeElements[0], $dateToTimeElements[1], $dateToTimeElements[2], $dateToDateElements[1], $dateToDateElements[0], $dateToDateElements[2]);

   if( $date1 > $date2 )
   {
       return null;
   }

   $diff = $date2 - $date1;

   $days = 0;
   $hours = 0;
   $minutes = 0;
   $seconds = 0;

   if ($diff % 86400 <= 0)  // there are 86,400 seconds in a day
   {
       $days = $diff / 86400;
   }

   if($diff % 86400 > 0)
   {
       $rest = ($diff % 86400);
       $days = ($diff - $rest) / 86400;

       if( $rest % 3600 > 0 )
       {
           $rest1 = ($rest % 3600);
           $hours = ($rest - $rest1) / 3600;

           if( $rest1 % 60 > 0 )
           {
               $rest2 = ($rest1 % 60);
               $minutes = ($rest1 - $rest2) / 60;
               $seconds = $rest2;
           }
           else
           {
               $minutes = $rest1 / 60;
           }
       }
       else
       {
           $hours = $rest / 3600;
       }
   }

   switch($unit)
   {
       case 'd':
       case 'D':

           $partialDays = 0;

           $partialDays += ($seconds / 86400);
           $partialDays += ($minutes / 1440);
           $partialDays += ($hours / 24);

           $difference = $days + $partialDays;

           break;

       case 'h':
       case 'H':

           $partialHours = 0;

           $partialHours += ($seconds / 3600);
           $partialHours += ($minutes / 60);

           $difference = $hours + ($days * 24) + $partialHours;

           break;

       case 'm':
       case 'M':

           $partialMinutes = 0;

           $partialMinutes += ($seconds / 60);

           $difference = $minutes + ($days * 1440) + ($hours * 60) + $partialMinutes;

           break;

       case 's':
       case 'S':

           $difference = $seconds + ($days * 86400) + ($hours * 3600) + ($minutes * 60);

           break;

       case 'a':
       case 'A':

           $difference = array (
               "days" => $days,
               "hours" => $hours,
               "minutes" => $minutes,
               "seconds" => $seconds
           );

           break;
   }

   return $difference;
}

function getLoginDetails($sessid)
{
 $sql    = "select b.agentname,a.username,c.ipaddress,c.logintime from user_master a,agent_master b,user_logins c where a.useroffice=b.agentid and a.userid=c.userid and c.sessid='$sessid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
		$username = (isset($row['username'])) ? $row['username'] : "";
		$logintime = (isset($row['logintime'])) ? $row['logintime'] : "";
		$ipaddress = (isset($row['ipaddress'])) ? $row['ipaddress'] : "";
 }
$dateFrom = date("d-m-Y H:i:s",strtotime($logintime));
$dateTo = date("d-m-Y H:i:s", strtotime('now'));

$diffa = getDateDifference($dateFrom, $dateTo, 'a');
$duration= $diffa['hours'].":".$diffa['minutes'].":".$diffa['seconds'];
$logintime = date("M d, Y : h:i a", strtotime($logintime));
 
 $login_string=$username." | ".$agentname." | Logged in time: ".$logintime." | Logged in since: ".$duration." | Logged in from IP Address: ".$ipaddress;
    return($login_string);
}

function getCollectionLoginDetails($sessid)
{
 $sql    = "select b.agentname,a.username,c.logintime from user_master a,payingagent_master b,user_logins c where a.useroffice=b.agentid and a.userid=c.userid and c.sessid='$sessid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
		$username = (isset($row['username'])) ? $row['username'] : "";
		$logintime = (isset($row['logintime'])) ? $row['logintime'] : "";
 }
$dateFrom = date("d-m-Y H:i:s",strtotime($logintime));
$dateTo = date("d-m-Y H:i:s", strtotime('now'));

$diffa = getDateDifference($dateFrom, $dateTo, 'a');
$duration= $diffa['hours'].":".$diffa['minutes'].":".$diffa['seconds'];
$logintime = date("M d, Y : h:i a", strtotime($logintime));
 
 $login_string=$username." | ".$agentname." | Logged in time: ".$logintime." | Logged in since: ".$duration;
    return($login_string);
}
 function getofficename($officeid)
{
 $sql    = "select agentname from agent_master where agentid='$officeid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
 }
    return(stripslashes($agentname));
}
function getcustomermobilefororder($saleid)
{
 $sql    = "select b.mobile as mobile from sales_master a,contact_master b where a.contactid=b.contactid and saleid='$saleid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $mobile = (isset($row['mobile'])) ? $row['mobile'] : "";
 }
    return(stripslashes($mobile));
}

function getbeneficiarymobilefororder($saleid)
{
 $sql    = "select b.mobile as mobile from sales_master a,ben_master b where a.benid=b.benid and saleid='$saleid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $mobile = (isset($row['mobile'])) ? $row['mobile'] : "";
 }
    return(stripslashes($mobile));
}


function getcollectiondetailsforsms($collectionofficeid)
{ 
	
	 $sql    = "select a.agentaddress as pickupaddress, b.agentname as correspondingagent, a.city as city, a.state as state from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agentid='$collectionofficeid'"; // folders of the user
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		 {
        $pickupaddress = (isset($row['pickupaddress'])) ? $row['pickupaddress'] : "";
        $correspondingagent = (isset($row['correspondingagent'])) ? $row['correspondingagent'] : "";
        $city = (isset($row['city'])) ? $row['city'] : "0";
           $state = (isset($row['state'])) ? $row['state'] : "";
		}
      $returnstring = "\nAgent:".$correspondingagent."\nPickup Address:".$pickupaddress."\n".getcityname($city);
	  return $returnstring;
}

function getsmsmessagedetailsfororder($saleid)
{
	$sms_message="";
 $sql    = "select orderid,collectiontype,bankname,accountno,benamount,collectionofficeid,pickupidothers from sales_master where saleid='$saleid'"; // folders of the user

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $collectiontype = (isset($row['collectiontype'])) ? $row['collectiontype'] : "";
		$orderid = (isset($row['orderid'])) ? $row['orderid'] : "";
		$bankname = (isset($row['bankname'])) ? $row['bankname'] : "";
		$accountno = (isset($row['accountno'])) ? $row['accountno'] : "";
		$benamount = (isset($row['benamount'])) ? $row['benamount'] : "";
		$pickupidothers = (isset($row['pickupidothers'])) ? $row['pickupidothers'] : "";
		$collectionofficeid = (isset($row['collectionofficeid'])) ? $row['collectionofficeid'] : "";
 }
    if($collectiontype == 'Bank')
	{
		$sms_message = "Trans Code:".$orderid."\nYour bank transfer instruction has been authorised.\nAmt:".$benamount."\nBank Name:".$bankname."\nAccount No:".$accountno."\nDeposit Time:".$pickupidothers;
	}
	else
	{
            $sms_message = "Trans Code:".$orderid."\nAmt Recd:".$benamount.getcollectiondetailsforsms($collectionofficeid)."\nPickup Time:".$pickupidothers;
	}

	return $sms_message."\nWith thanks from GlobalNett - 02083185860, www.globalnett.co.uk";
}




function getuserrole($sessuserid)
{
 $sql    = "select usertype from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $usertype = (isset($row['usertype'])) ? $row['usertype'] : 0;
 }
    return($usertype);
}

function ispayingagent($sessuserid)
{
 /*$sql    = "select is_payingagent from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $is_payingagent = (isset($row['is_payingagent'])) ? $row['is_payingagent'] : 0;
 }
    return($is_payingagent);*/
}

function getcustomeridno($contactid)
{
	/* $sql    = "select idno from contact_master where contactid='$contactid'"; // folders of the user
//echo $sql;
    $Result2 = safe_query($sql) ;
    while ($row2      = mysql_fetch_array( $Result2))
 {
        $idno1 = $row2['idno'];
 }
    return($idno1);*/
	return "CM".$contactid;
}
function gettodayapp($currentdate,$sessionuserid)
{
$sql    = "select historyid,activity_type,status,regarding,minutes,hours,meredian,withcontact from history_master where toid='$sessionuserid'
 and date='$currentdate' "; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $type  = (isset($row['activity_type'])) ? $row['activity_type'] : "";
         $regarding1  = (isset($row['regarding'])) ? $row['regarding'] : "";
          $withcontact1  = (isset($row['withcontact'])) ? $row['withcontact'] : "";
          $historyid  = (isset($row['historyid'])) ? $row['historyid'] : "";
           $status1  = (isset($row['status'])) ? $row['status'] : "";
            $minutes  = (isset($row['minutes'])) ? $row['minutes'] : "";
             $hours  = (isset($row['hours'])) ? $row['hours'] : "";
              $meredian  = (isset($row['meredian'])) ? $row['meredian'] : "";
 if($type=='Call')
{
$output=$output."<a href=index.php?status=".base64_encode('editmeeting')."&historyid=".$historyid."><img border='0' src='images/CALL.GIF' alt=CALL> with ".getcontactname($withcontact1)." regarding ".$regarding1."-<b><br>".$hours."&nbsp;".$minutes."&nbsp;".$meredian."&nbsp;".$status1."</b></a><br>";
 }
if($type=='Meeting')
{
$output=$output."<a href=index.php?status=".base64_encode('editmeeting')."&historyid=".$historyid."><img border='0' src='images/MEET.GIF' alt=MEETING> with ".getcontactname($withcontact1)." regarding ".$regarding1."-<b><br>".$hours."&nbsp;".$minutes."&nbsp;".$meredian."&nbsp;".$status1."</b></a><br>";
}
if($type=='Todo')
{
$output=$output."<a href=index.php?status=".base64_encode('editmeeting')."&historyid=".$historyid."><img border='0' src='images/TODO.GIF' alt=TODO> with ".getcontactname($withcontact1)." regarding ".$regarding1."-<b><br>".$hours."&nbsp;".$minutes."&nbsp;".$meredian."&nbsp;".$status1."</b></a><br>";
 }
 //ECHO $output;
      }
    return($output);
}
 function dateConvert1($user_date)
 {
  $result = '0000-00-00';
  $d_pattern = array('/\//','/\./','/,/', '/\s/','/\\\/');
  $d_replace = '-';
  $d_result = preg_replace($d_pattern, $d_replace, $user_date);
  $t = explode('-', $d_result);
  $month = 0;
  $day = 1;
  $year = 2;
  if(preg_match('/\d{4}-\d{1,2}-\d{1,2}/', $d_result)){
    $month = 1;
    $day = 2;
    $year = 0;
    if(intval($t[1]) > 12){
      $month = 2;
      $day = 1;
    }
    if(checkdate($t[$month], $t[$day], $t[$year]))
      $result = $t[$year].'-'.$t[$month].'-'.$t[$day];
  }
  elseif(preg_match('/\d{1,2}-\d{1,2}-\d{4}/', $d_result)){
    if(intval($t[0]) > 12){
      $day = 0;
      $month = 1;
    }
    if(checkdate($t[$month], $t[$day], $t[$year]));
      $result = $t[$year].'-'.$t[$month].'-'.$t[$day];
  }
  return $result;
}
 function dateConvert($user_date)
 {
 $parts=explode("/",$user_date);
 $result=$parts[2]."-".$parts[1]."-".$parts[0];
// echo $result;
 return $result;
}
function getuserid($username)
{ $sql    = "select userid from user_master where username='$username'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $id  = (isset($row['userid'])) ? $row['userid'] : "";
      }
    return($id);
}
function getusername($sessuserid)
{ $sql    = "select username from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $sessusername  = (isset($row['username'])) ? $row['username'] : "";
      }
    return($sessusername);
}
function getgroupname($sessgroupid)
{ $sql    = "select name from group_master where groupid='$sessgroupid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $groupname  = (isset($row['name'])) ? $row['name'] : "";
      }
    return($groupname);
}
function getaddrights($sessuserid)
{ $sql    = "select add_rights from user_master where userid='$sessuserid'"; // folders of the user
 //echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $add_rights  = (isset($row['add_rights'])) ? $row['add_rights'] : "";
      }
    return($add_rights);
}
function getupdaterights($sessuserid)
{ $sql    = "select update_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $update_rights  = (isset($row['update_rights'])) ? $row['update_rights'] : "";
      }
    return($update_rights);
}

function getdeleterights($sessuserid)
{ $sql    = "select delete_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $delete_rights  = (isset($row['delete_rights'])) ? $row['delete_rights'] : "";
      }
    return($delete_rights);
}
function getreportrights($sessuserid)
{ $sql    = "select create_reports from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $create_reports  = (isset($row['create_reports'])) ? $row['create_reports'] : "";
      }
    return($create_reports);
}
function getcontactsrights($sessuserid)
{ $sql    = "select contacts_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $contacts_rights  = (isset($row['contacts_rights'])) ? $row['contacts_rights'] : "";
      }
    return($contacts_rights);
}
function getsmsrights($sessuserid)
{
 $sql    = "select sms_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $sms_rights  = (isset($row['sms_rights'])) ? $row['sms_rights'] : "";
      }
    return($sms_rights);
   
}
function getgroupsrights($sessuserid)
{ $sql    = "select groups_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $groups_rights  = (isset($row['groups_rights'])) ? $row['groups_rights'] : "";
      }
    return($groups_rights);
}
function getaccountsrights($sessuserid)
{ $sql    = "select accounts_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $accounts_rights  = (isset($row['accounts_rights'])) ? $row['accounts_rights'] : "";
      }
    return($accounts_rights);
}
function getusersrights($sessuserid)
{ $sql    = "select users_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $users_rights  = (isset($row['users_rights'])) ? $row['users_rights'] : "";
      }
    return($users_rights);
}

function getsuperuserrights($sessuserid)
{ 
   $sql    = "select superuser_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $superuser_rights  = (isset($row['superuser_rights'])) ? $row['superuser_rights'] : "";
      }
    return($superuser_rights);
}
function getalertrights($sessuserid)
{ $sql    = "select alert_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $alert_rights  = (isset($row['alert_rights'])) ? $row['alert_rights'] : "";
      }
    return($alert_rights);
}
function getconfirmrights($sessuserid)
{ $sql    = "select confirm_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $confirm_rights  = (isset($row['confirm_rights'])) ? $row['confirm_rights'] : "";
      }
    return($confirm_rights);
}
function getofficerights($sessuserid)
{ $sql    = "select office_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $office_rights  = (isset($row['office_rights'])) ? $row['office_rights'] : "";
      }
    return($office_rights);
}
function getusercreationrights($sessuserid)
{ $sql    = "select usercreation_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $usercreation_rights  = (isset($row['usercreation_rights'])) ? $row['usercreation_rights'] : "";
      }
    return($usercreation_rights);
}
function getsendersmsrights($sessuserid)
{ $sql    = "select sms_sender_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $sms_sender_rights  = (isset($row['sms_sender_rights'])) ? $row['sms_sender_rights'] : "";
      }
    return($sms_sender_rights);
}
function getbeneficiarysmsrights($sessuserid)
{ $sql    = "select sms_beneficiary_rights from user_master where userid='$sessuserid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $sms_beneficiary_rights  = (isset($row['sms_beneficiary_rights'])) ? $row['sms_beneficiary_rights'] : "";
      }
    return($sms_beneficiary_rights);
}

function getcontactname($contactid)
{ $sql    = "select firstname,surname from contact_master where contactid='$contactid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : "";
         $lastname  = (isset($row['surname'])) ? $row['surname'] : "";
      }
      $givenname=stripslashes($firstname)."-".stripslashes($lastname);
    //  echo "the givenname is".$givenname;
    if($givenname=='-')
    {
    $givenname=$contactid;
    }
    return($givenname);
}
function getbeneficiaryname($benid)
{ $sql    = "select firstname from ben_master where benid='$benid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : "";
          }
      $givenname=stripslashes($firstname);
    
    return($givenname);
}
function getcustomerdetailsfororder($contactid)
{ $sql    = "select firstname,surname,address,city,postcode,country,phone,mobile from contact_master where contactid='$contactid'"; 

	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $firstname      = (isset($row['firstname'])) ? $row['firstname'] : "";
	$surname      = (isset($row['surname'])) ? $row['surname'] : "";
	$phone  = (isset($row['phone'])) ? $row['phone'] : "";
	$email  = (isset($row['email'])) ? $row['email'] :"";
    $address  = (isset($row['address'])) ? $row['address'] :"";
    $postcode  = (isset($row['postcode'])) ? $row['postcode'] :"";
    $city  = (isset($row['city'])) ? $row['city'] :"";
    $country  = (isset($row['country'])) ? $row['country'] :"";
	$mobile  = (isset($row['mobile'])) ? $row['mobile'] :"";
	$telephone  = (isset($row['telephone'])) ? $row['telephone'] :"";
 }
      $returnstring="<tr><td width=50% valign=top>Surname</td><td width=50% valign=top>".$surname."</td></tr><tr><td width=50% valign=top>First Name</td><td width=50% valign=top>".$firstname."</td></tr><tr><td width=50% valign=top>Address</td><td width=50% valign=top>".nl2br($address)."</td></tr><tr><td width=50% valign=top>City</td><td width=50% valign=top>".$city."</td></tr><tr><td width=50% valign=top>Postcode</td><td width=50% valign=top>".$postcode."</td></tr><tr><td width=50% valign=top>Country</td><td width=50% valign=top>".getcountryname($country)."</td></tr><tr><td width=50% valign=top>Telephone</td><td width=50% valign=top>".$telephone."</td></tr>";
	  return $returnstring;
}

function getcustomerdetailsfororderpage($contactid)
{ $sql    = "select firstname,surname,address,city,postcode,country,phone,mobile from contact_master where contactid='$contactid'"; 

	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $firstname      = (isset($row['firstname'])) ? $row['firstname'] : "";
	$surname      = (isset($row['surname'])) ? $row['surname'] : "";
	$phone  = (isset($row['phone'])) ? $row['phone'] : "";
	$email  = (isset($row['email'])) ? $row['email'] :"";
    $address  = (isset($row['address'])) ? $row['address'] :"";
    $postcode  = (isset($row['postcode'])) ? $row['postcode'] :"";
    $city  = (isset($row['city'])) ? $row['city'] :"";
    $country  = (isset($row['country'])) ? $row['country'] :"";
	$mobile  = (isset($row['mobile'])) ? $row['mobile'] :"";
	$telephone  = (isset($row['telephone'])) ? $row['telephone'] :"";
 }
      $returnstring="<table border=0 cellpadding=0 style=border-collapse: collapse bordercolor=#111111 width=100% id=AutoNumber1><tr><td width=100% colspan=2 valign=top>".$surname." ".$firstname."</td></tr><tr><td width=100% valign=top>".getcountryname($country)."</td></tr><tr><td width=100% valign=top><b>".getcustomeridno($contactid)."</b></td></tr></table>";
	  return $returnstring;
}
function getbeneficiarydetailsfororderpage($benid)
{ $sql    = "select * from ben_master where benid='$benid'";  		
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $firstname      = (isset($row['firstname'])) ? $row['firstname'] : "";
	$surname      = (isset($row['surname'])) ? $row['surname'] : "";
	$phone  = (isset($row['phone'])) ? $row['phone'] : "";
	$email  = (isset($row['email'])) ? $row['email'] :"";
    $address  = (isset($row['address'])) ? $row['address'] :"";
    $postcode  = (isset($row['postcode'])) ? $row['postcode'] :"";
     $city  = (isset($row['city'])) ? $row['city'] :"";
	 $state  = (isset($row['state'])) ? $row['state'] :"";
    $country  = (isset($row['country'])) ? $row['country'] :"";
	$mobile  = (isset($row['mobile'])) ? $row['mobile'] :"";
	$bankname  = (isset($row['bankname'])) ? $row['bankname'] :"";
$branchname  = (isset($row['branchname'])) ? $row['branchname'] :"";
$accountno  = (isset($row['accountno'])) ? $row['accountno'] :"";
 }
      $returnstring="<table border=0 cellpadding=0 style=border-collapse: collapse bordercolor=#111111 width=100% id=AutoNumber1><tr><td width=100% colspan=2 valign=top>".$firstname."</td></tr><tr><td width=100% valign=top>".getcountryname($country)."</td></tr></table>";
	  return $returnstring;
}


function getcollectioncustomerdetailsfororder($contactid)
{ $sql    = "select firstname,surname from contact_master where contactid='$contactid'"; 

	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $firstname      = (isset($row['firstname'])) ? $row['firstname'] : "";
	$surname      = (isset($row['surname'])) ? $row['surname'] : "";
	 }
      $returnstring="<tr><td width=50% valign=top>Surname</td><td width=50% valign=top>".$surname."</td></tr><tr><td width=50% valign=top>First Name</td><td width=50% valign=top>".$firstname."</td></tr>";
	  return $returnstring;
}

function getbeneficiarydetailsfororder($benid)
{ $sql    = "select * from ben_master where benid='$benid'";  		
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $firstname      = (isset($row['firstname'])) ? $row['firstname'] : "";
	$surname      = (isset($row['surname'])) ? $row['surname'] : "";
	$phone  = (isset($row['phone'])) ? $row['phone'] : "";
	$email  = (isset($row['email'])) ? $row['email'] :"";
    $address  = (isset($row['address'])) ? $row['address'] :"";
    $postcode  = (isset($row['postcode'])) ? $row['postcode'] :"";
     $city  = (isset($row['city'])) ? $row['city'] :"";
	 $state  = (isset($row['state'])) ? $row['state'] :"";
    $country  = (isset($row['country'])) ? $row['country'] :"";
	$mobile  = (isset($row['mobile'])) ? $row['mobile'] :"";
	$bankname  = (isset($row['bankname'])) ? $row['bankname'] :"";
$branchname  = (isset($row['branchname'])) ? $row['branchname'] :"";
$accountno  = (isset($row['accountno'])) ? $row['accountno'] :"";
 }
      $returnstring="<tr><td width=50% valign=top>ID</td><td width=50% valign=top>BM".$benid."</td></tr><tr><tr><td width=50% valign=top>Full Name</td><td width=50% valign=top>".$firstname."</td></tr><tr><td width=50% valign=top>Address</td><td width=50% valign=top>".nl2br($address)." ".getcityname($city)." ".getstatename($state)." ".getcountryname($country)."</td></tr>";
	  return $returnstring;
}

function getbankdetailsfororder($orderid)
{ $sql    = "select * from sales_master where saleid='$orderid'";  		
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
    $bankname  = (isset($row['bankname'])) ? $row['bankname'] :"";
	$branchname  = (isset($row['branchname'])) ? $row['branchname'] :"";
	$accountno  = (isset($row['accountno'])) ? $row['accountno'] :"";
	$branchaddress  = (isset($row['branchaddress'])) ? $row['branchaddress'] :"";
	$swiftcode  = (isset($row['swiftcode'])) ? $row['swiftcode'] :"";
	$ibanno  = (isset($row['ibanno'])) ? $row['ibanno'] :"";
	$sortcode  = (isset($row['sortcode'])) ? $row['sortcode'] :"";
	$accounttype  = (isset($row['accounttype'])) ? $row['accounttype'] :"";
 }
      $returnstring="<tr><td width=50% valign=top>Bank Name</td><td width=50% valign=top>".$bankname."</td></tr><tr><td width=50% valign=top>Branch Name</td><td width=50% valign=top>".nl2br($branchname)."</td></tr><tr><td width=50% valign=top>Branch Address</td><td width=50% valign=top>".nl2br($branchaddress)."</td></tr><tr><td width=50% valign=top>Account No</td><td width=50% valign=top>".$accountno."</td></tr><tr><td width=50% valign=top>Account Type</td><td width=50% valign=top>".$accounttype."</td></tr><tr><td width=50% valign=top>Sortcode</td><td width=50% valign=top>".$sortcode."</td></tr><tr><td width=50% valign=top>Swift Code</td><td width=50% valign=top>".$swiftcode."</td></tr><tr><td width=50% valign=top>IBAN No</td><td width=50% valign=top>".$ibanno."</td></tr>";
	  return $returnstring;
}

function getcollectiondetailsfororder($collectionofficeid)
{ 
	
	 $sql    = "select a.agentaddress as pickupaddress, b.agentname as correspondingagent, a.city as city, a.state as state from agent_master a,payingagent_master b where a.payingagent = b.agentid and a.agentid='$collectionofficeid'"; // folders of the user
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		 {
        $pickupaddress = (isset($row['pickupaddress'])) ? $row['pickupaddress'] : "";
        $correspondingagent = (isset($row['correspondingagent'])) ? $row['correspondingagent'] : "";
        $city = (isset($row['city'])) ? $row['city'] : "0";
           $state = (isset($row['state'])) ? $row['state'] : "";
		}
      $returnstring = "<tr><td width=50% valign=top>Agent:</td><td width=50% valign=top>".$correspondingagent."</td></tr><tr><td width=50% valign=top>Pickup Address:</td><td width=50% valign=top>".$pickupaddress."<br>".getcityname($city)."</td></tr>";
	  return $returnstring;
}

function getofficedetailsfororder($officeid)
{ 
	
	 $sql    = "select * from agent_master where agentid='$officeid'"; // folders of the user
	$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
        $agentaddress = (isset($row['agentaddress'])) ? $row['agentaddress'] : "";
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
        $agenttelephone = (isset($row['agenttelephone'])) ? $row['agenttelephone'] : "";
         $agentfax = (isset($row['agentfax'])) ? $row['agentfax'] : "";
        $agentemail = (isset($row['agentemail'])) ? $row['agentemail'] : "";
         $agentmobile = (isset($row['agentmobile'])) ? $row['agentmobile'] : "";
         $country = (isset($row['country'])) ? $row['country'] : "";
		 $city = (isset($row['city'])) ? $row['city'] : "0";
           $state = (isset($row['state'])) ? $row['state'] : "";
 }
      $returnstring="<tr><td width=100% valign=top>".$agentname." ".($agentaddress)."<br/>".$agenttelephone." ".getcityname($city)." ".getstatename($state)." ".getcountryname($country)."</td></tr>";
	  return $returnstring;
}

function getpayingagentdetailsfororder($payingagent)
{ 
	
	  $sql    = "select * from payingagent_master where agentid='$payingagent'"; // folders of the user
$Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
     {
        $agentaddress = (isset($row['agentaddress'])) ? $row['agentaddress'] : "";
        $agentname = (isset($row['agentname'])) ? $row['agentname'] : "";
        $agenttelephone = (isset($row['agenttelephone'])) ? $row['agenttelephone'] : "";
         $agentfax = (isset($row['agentfax'])) ? $row['agentfax'] : "";
        $agentemail = (isset($row['agentemail'])) ? $row['agentemail'] : "";
         $agentmobile = (isset($row['agentmobile'])) ? $row['agentmobile'] : "";
         $country = (isset($row['country'])) ? $row['country'] : "";
	  
}
      $returnstring="<tr><td width=50% valign=top>Name</td><td width=50% valign=top>".$agentname."</td></tr><tr><td width=50% valign=top>Address</td><td width=50% valign=top>".nl2br($agentaddress)."</td></tr><tr><td width=50% valign=top>Telephone</td><td width=50% valign=top>".$agenttelephone."</td></tr><tr><td width=50% valign=top>Fax</td><td width=50% valign=top>".$agentfax."</td></tr><tr><td width=50% valign=top>Country</td><td width=50% valign=top>".getcountryname($country)."</td></tr>";
	  return $returnstring;
}

function getbenname($benid)
{ $sql    = "select firstname from ben_master where benid='$benid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : "";
         $lastname  = (isset($row['surname'])) ? $row['surname'] : "";
      }
      $givenname=stripslashes($firstname);
    //  echo "the givenname is".$givenname;
    if($givenname=='-')
    {
    $givenname=$contactid;
    }
    return($givenname);
}

function getcustomeremail($contactid)
{ $sql    = "select email from contact_master where contactid='$contactid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $email  = (isset($row['email'])) ? $row['email'] : "";

      }

    return($email);
}
function getbencountry($benid)
{ $sql    = "select country from ben_master where benid='$benid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $country  = (isset($row['country'])) ? $row['country'] : "";

      }

    return($country);
}


function edituser()
{
   $username1=addslashes($_POST['username1']);
   $password1=addslashes($_POST['password1']);
   $add_rights=addslashes($_POST['add_rights']);
   $update_rights=addslashes($_POST['update_rights']);
   $delete_rights=addslashes($_POST['delete_rights']);
   $create_reports=addslashes($_POST['create_reports']);
   $firstname=addslashes($_POST['firstname']);
   $lastname=addslashes($_POST['lastname']);
   $usertype=addslashes($_POST['usertype']);
    $status=addslashes($_POST['status']);
	 $email=addslashes($_POST['email']);
	  $telephone=addslashes($_POST['telephone']); 
	  $mobile=addslashes($_POST['mobile']); 
	  $address=addslashes($_POST['address']);
	   $usernameid=addslashes($_POST['usernameid']);
	    $contacts_rights=addslashes($_POST['contacts_rights']);
		 $users_rights=addslashes($_POST['users_rights']);
		  $groups_rights=addslashes($_POST['groups_rights']);
		   $accounts_rights=addslashes($_POST['accounts_rights']);
		    $office_rights=addslashes($_POST['office_rights']);
			 $useroffice=addslashes($_POST['useroffice']);
			  $discountleverage=addslashes($_POST['discountleverage']);
			  $usercreation_rights =addslashes($_POST['usercreation_rights']);
			   $sms_rights =addslashes($_POST['sms_rights']);
			  $is_payingagent =addslashes($_POST['is_payingagent']);
			   $superuser_rights =addslashes($_POST['superuser_rights']);
			   $alert_rights =addslashes($_POST['alert_rights']);
			   $confirm_rights =addslashes($_POST['confirm_rights']);
			   $sms_sender_rights =addslashes($_POST['sms_sender_rights']);
			   $sms_beneficiary_rights =addslashes($_POST['sms_beneficiary_rights']);
    if($username1!='' && $firstname!='' && $lastname!=''&& $password1!='')
   {
  $insertSQL = "update user_master
  set username='$username1',
  password='$password1',
	  alert_rights='$alert_rights',
	  confirm_rights='$confirm_rights',
  add_rights='$add_rights',
  update_rights='$update_rights',
  delete_rights='$delete_rights',
  users_rights='$users_rights',
  groups_rights='$groups_rights',
  contacts_rights='$contacts_rights',
  accounts_rights='$accounts_rights',
  office_rights='$office_rights',
  create_reports='$create_reports',
	  usercreation_rights='$usercreation_rights',
	  sms_sender_rights ='$sms_sender_rights',
sms_beneficiary_rights='$sms_beneficiary_rights',
  usertype='$usertype',
  status='$status',
  firstname='$firstname',
  lastname='$lastname',
  email='$email',
  telephone='$telephone',
  mobile='$mobile',is_payingagent='$is_payingagent',
  address='$address',useroffice='$useroffice',discountleverage='$discountleverage',sms_rights='$sms_rights',superuser_rights='$superuser_rights' where userid='$usernameid'";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>User information has been successfully updated</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.Firstname,Lastname,Username and Password are required fields</p>");
   }
}
function adduser()
{
  $username1=addslashes($_POST['username1']);
   $password1=addslashes($_POST['password1']);
   $add_rights=addslashes($_POST['add_rights']);
   $update_rights=addslashes($_POST['update_rights']);
   $delete_rights=addslashes($_POST['delete_rights']);
   $create_reports=addslashes($_POST['create_reports']);
   $firstname=addslashes($_POST['firstname']);
   $lastname=addslashes($_POST['lastname']);
   $usertype=addslashes($_POST['usertype']);
    $status=addslashes($_POST['status']);
	 $email=addslashes($_POST['email']);
	  $telephone=addslashes($_POST['telephone']); 
	  $mobile=addslashes($_POST['mobile']); 
	  $address=addslashes($_POST['address']);
	   $usernameid=addslashes($_POST['usernameid']);
	    $contacts_rights=addslashes($_POST['contacts_rights']);
		 $users_rights=addslashes($_POST['users_rights']);
		  $groups_rights=addslashes($_POST['groups_rights']);
		   $accounts_rights=addslashes($_POST['accounts_rights']);
		    $office_rights=addslashes($_POST['office_rights']);
			 $useroffice=addslashes($_POST['useroffice']);
			 $usercreation_rights=addslashes($_POST['usercreation_rights']);
			  $discountleverage=addslashes($_POST['discountleverage']);
			   $is_payingagent =addslashes($_POST['is_payingagent']);
			   $sms_rights =addslashes($_POST['sms_rights']);
			   $superuser_rights =addslashes($_POST['superuser_rights']);
			   $alert_rights =addslashes($_POST['alert_rights']);
			   $confirm_rights =addslashes($_POST['confirm_rights']);
			   $sms_sender_rights =addslashes($_POST['sms_sender_rights']);
			   $sms_beneficiary_rights =addslashes($_POST['sms_beneficiary_rights']);

    $FF_dupKeySQL = "SELECT username FROM user_master WHERE username='" . $username1 . "'";

  $FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {

    display_message( "<b><p align=center>User already exists.Please try again</b></p>");
   }
   else
   {

   if($username1!='' && $firstname!='' && $lastname!=''&& $password1!='')
   {
  $insertSQL = "INSERT INTO user_master
  (username,password,add_rights,update_rights,delete_rights,create_reports,usertype,status,
  firstname,lastname,email,telephone,mobile,address,contacts_rights,users_rights,groups_rights,accounts_rights,office_rights,useroffice,discountleverage,usercreation_rights,is_payingagent,sms_rights,superuser_rights,alert_rights,confirm_rights,sms_sender_rights,sms_beneficiary_rights)
  VALUES ('$username1','$password1','$add_rights','$update_rights','$delete_rights','$create_reports','$usertype','$status',
  '$firstname','$lastname','$email','$telephone','$mobile','$address','$contacts_rights','$users_rights','$groups_rights','$accounts_rights','$office_rights','$useroffice','$discountleverage','$usercreation_rights','$is_payingagent','$sms_rights','$superuser_rights','$alert_rights','$confirm_rights','$sms_sender_rights','$sms_beneficiary_rights')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>User information has been successfully added</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.Firstname,Lastname,Username and Password are required fields</p>");
   }

    }
}
 function addschedule()
{
   $activity_type = addslashes($_POST['activity_type']);
    $date = addslashes($_POST['date']);
    $regarding = addslashes($_POST['regarding']);
    $hours = addslashes($_POST['hours']);
    $minutes = addslashes($_POST['minutes']);
    $meredian = addslashes($_POST['meredian']);
    $priority = addslashes($_POST['priority']);
    $withcontact = addslashes($_POST['withcontact']);
    $fromid = addslashes($_POST['fromid']);
    $toid = addslashes($_POST['toid']);
    $userid = addslashes($_POST['userid']);
    $groupid = addslashes($_POST['groupid']);
    $details = addslashes($_POST['details']);
    $duration = addslashes($_POST['duration']);
    $telephoneno = addslashes($_POST['telephoneno']);
    $selectwith = addslashes($_POST['selectwith']);
	$meetingstatus=addslashes($_POST['meetingstatus']);
	$userofficeid=addslashes($_POST['userofficeid']);
    if($withcontact=='')
    {
    $choosecontact=$selectwith;
    }
    else
    {
     $choosecontact=$withcontact;
    }
$date = dateConvert($date);
   if($date!='' && $activity_type!='')
   {
  $insertSQL = "INSERT INTO history_master
  (activity_type,date,regarding,hours,minutes,meredian,priority,fromid,toid,groupid,withcontact,details,userid,duration,status,telephoneno,userofficeid)
  VALUES ('$activity_type','$date','$regarding','$hours','$minutes','$meredian','$priority','$fromid','$toid','$groupid','$choosecontact','$details','$userid','$duration','YET TO CONFIRM','$telephoneno','$userofficeid')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Schedule Information has been successfully added</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.Date,Activity and Contact Names are required.</p>");
   }
}

function editmeeting()
{
   $activity_type = addslashes($_POST['activity_type']);
    $date = addslashes($_POST['date']);
    $regarding = addslashes($_POST['regarding']);
    $hours = addslashes($_POST['hours']);
    $minutes = addslashes($_POST['minutes']);
    $meredian = addslashes($_POST['meredian']);
    $priority = addslashes($_POST['priority']);
    $withcontact = addslashes($_POST['withcontact']);
    $fromid = addslashes($_POST['fromid']);
    $toid = addslashes($_POST['toid']);
    $userid = addslashes($_POST['userid']);
    $groupid = addslashes($_POST['groupid']);
    $details = addslashes($_POST['details']);
    $duration = addslashes($_POST['duration']);
    $telephoneno = addslashes($_POST['telephoneno']);
    $selectwith = addslashes($_POST['selectwith']);
	$historyid=addslashes($_POST['historyid']);
	$meetingstatus=addslashes($_POST['meetingstatus']);

$date = dateConvert($date);
   if($historyid!='' && $date!='')
   {
  $insertSQL = "update history_master set status='$meetingstatus',
  date='$date',
  regarding='$regarding',
  hours='$hours',
  minutes='$minutes',
  meredian='$meredian',
  priority='$priority',
  details='$details' where historyid='$historyid'";

// echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Schedule information has been successfully updated</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.Select the status of the schedule.Please try again</p>");
   }
}


function addgroup()
{
    $name=addslashes($_POST['name']);
    $description=addslashes($_POST['description']);
	$userofficeid=addslashes($_POST['userofficeid']);
    
   $FF_dupKeySQL = "SELECT name FROM group_master WHERE name='" . $name . "'";

  $FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {

    display_message( "<b><p align=center>Group already exists.Please try again</b></p>");
   }
   else
   {
   if($name!='')
   {
  $insertSQL = "INSERT INTO group_master
  (name,description,userofficeid)
  VALUES ('$name','$description','$userofficeid')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Group information has been successfully added</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Group Information has not been added.Please try again</p>");
   }
   }
}

function editgroup()
{
       $name=addslashes($_POST['name']);
    $description=addslashes($_POST['description']);
    
    $groupid=$_POST['groupid'];
  //echo "the group id is ".$groupid;
   if($name!='' && $groupid!='')
   {
  $insertSQL = "update group_master
  set name='$name',
  description='$description'
  where groupid='$groupid'";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Group information has been successfully updated</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Group Information has not been updated.Please try again</p>");
   }
}

 function editcontact()
{
    $surname=addslashes($_POST['surname']);
    $address=addslashes($_POST['address']);
    $department=addslashes($_POST['department']);
    $firstname=addslashes($_POST['firstname']);
    $title=addslashes($_POST['title']);
    $postcode=addslashes($_POST['postcode']);
    $city=addslashes($_POST['city']);
    $state=addslashes($_POST['state']);
    $country=addslashes($_POST['country']);
    $status=addslashes($_POST['status']);
    $phone=addslashes($_POST['phone']);
      $phone_cc=addslashes($_POST['phone_cc']);
      $phone_ext=addslashes($_POST['phone_ext']);
      $dob=addslashes($_POST['dob']);
      $fax_cc=addslashes($_POST['fax_cc']);
      $website=addslashes($_POST['website']);
      $mobile=addslashes($_POST['mobile']);
      $idtype=addslashes($_POST['idtype']);
      $email=addslashes($_POST['email']);
      $referredby=addslashes($_POST['referredby']);
      $groupnameid=addslashes($_POST['groupnameid']);
      $userid=addslashes($_POST['userid']);
      $altphone=addslashes($_POST['altphone']);
      $altcontact=addslashes($_POST['altcontact']);
      $contactid=addslashes($_POST['contactid']);
	    $passportno=addslashes($_POST['passportno']);
	  $issuedby=addslashes($_POST['issuedby']);
	  $expirydate=addslashes($_POST['expirydate']);
	   $maidenname=addslashes($_POST['maidenname']);
	   $country=addslashes($_POST['country']);
	   $idno=addslashes($_POST['idno']);
	   $additionalinfo=addslashes($_POST['additionalinfo']);
	     $maxdailylimit=addslashes($_POST['maxdailylimit']);
		   $maxmonthlylimit=addslashes($_POST['maxmonthlylimit']);
		   $maxyearlylimit=addslashes($_POST['maxyearlylimit']);

	   $expirydate = dateConvert($expirydate);
	   $dob = dateConvert($dob);

   if($surname!='' && $firstname!='')
   {
  $insertSQL = "update contact_master
 set surname='$surname',
 department='$department',
 firstname='$firstname',
 title='$title',
 phone='$phone',
 phone_cc='$phone_cc',
 phone_ext='$phone_ext',
  dob='$dob',
  fax_cc='$fax_cc',
  mobile='$mobile',
  idtype='$idtype',
  idno='$idno',
  address='$address',
  city='$city',
  state='$state',
  postcode='$postcode',
  country='$country',
  email='$email',
  website='$website',
  altcontact='$altcontact',
  alttelephone='$altphone',
  referredby='$referredby',country='$country', passportno='$passportno',issuedby='$issuedby',expirydate='$expirydate',
  groupid='$groupnameid',maxdailylimit='$maxdailylimit',maxmonthlylimit='$maxmonthlylimit',maxyearlylimit='$maxyearlylimit',additionalinfo='$additionalinfo' where contactid='$contactid'";
  // echo   $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Customer information has been successfully updated</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.First name and Surname are compulsory.The customer Information has not been updated.Please try again</p>");
   }
}

function addcontact()
{
   $surname=addslashes($_POST['surname']);
    $address=addslashes($_POST['address']);
    $department=addslashes($_POST['department']);
    $firstname=addslashes($_POST['firstname']);
    $title=addslashes($_POST['title']);
    $postcode=addslashes($_POST['postcode']);
    $city=addslashes($_POST['city']);
    $state=addslashes($_POST['state']);
    $country=addslashes($_POST['country']);
    $status=addslashes($_POST['status']);
    $phone=addslashes($_POST['phone']);
      $phone_cc=addslashes($_POST['phone_cc']);
      $phone_ext=addslashes($_POST['phone_ext']);
      $dob=addslashes($_POST['dob']);
      $fax_cc=addslashes($_POST['fax_cc']);
      $website=addslashes($_POST['website']);
      $mobile=addslashes($_POST['mobile']);
      $idtype=addslashes($_POST['idtype']);
      $email=addslashes($_POST['email']);
      $referredby=addslashes($_POST['referredby']);
      $groupnameid=addslashes($_POST['groupnameid']);
      $userid=addslashes($_POST['userid']);
      $altphone=addslashes($_POST['altphone']);
      $altcontact=addslashes($_POST['altcontact']);
      $passportno=addslashes($_POST['passportno']);
	  $issuedby=addslashes($_POST['issuedby']);
	  //$expirydate=addslashes($_POST['expirydate']);
        //$country=addslashes($_POST['country']);
		 $userofficeid=addslashes($_POST['userofficeid']);
		   $idno=addslashes($_POST['idno']);
		   $maxdailylimit=addslashes($_POST['maxdailylimit']);
		   $maxmonthlylimit=addslashes($_POST['maxmonthlylimit']);
		   $maxyearlylimit=addslashes($_POST['maxyearlylimit']);
		   $additionalinfo=addslashes($_POST['additionalinfo']);
   $expirydate = dateConvert($expirydate);
   $dob = dateConvert($dob);
   if($surname!='' && $firstname!='' && $dob != '')
   {
	 
	$FF_dupKeySQL = "SELECT firstname FROM contact_master WHERE lower(firstname) ='" . strtolower($firstname) . "' and lower(surname) ='" . strtolower($surname) . "' and lower(dob) ='" . strtolower($dob) . "'";
   //echo $FF_dupKeySQL;
  $FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {
    display_message( "<b><p align=center>Customer with the same name,address and dob already exists.Please try again</b></p>");
   }
   else
   {
  $insertSQL = "INSERT INTO `contact_master` ( `contactid` , `firstname` , `surname` , `title` , `department` , `phone` , `phone_cc` , `phone_ext` , `fax` , `fax_cc` , `mobile` , `salutation` , `idno` , `address` , `city` , `state` , `postcode` , `country` , `email` , `website` , `altcontact` , `alttelephone` , `referredby` , `userid` , `groupid` , `passportno` , `expirydate` , `issuedby` , `userofficeid` , `dob` , `maxdailylimit` , `maxmonthlylimit` , `maxyearlylimit` , `additionalinfo` , `idtype` , `username` , `password` , `last_password_date` , `is_onlinecustomer` , `contactstatus` )
VALUES (
'', '$firstname', '$surname', '$title', '$department', '$phone', '$phone_cc', '$phone_ext', '', '$fax_cc', '$mobile', '', '$idno', '$address', '$city', '$state', '$postcode', '$country', '$email', '$website', '$altcontact' , '$altphone' , '$referredby' , 
          '$userid' , '$groupnameid' , '$passportno' , '$expirydate', '$issuedby' , '$userofficeid' , '$dob' , '$maxdailylimit' , '$maxmonthlylimit' , '$maxyearlylimit' , '$additionalinfo' , '$idtype' , NULL , NULL , NULL , 'N', NULL
)";
//  $insertSQL = "INSERT INTO `contact_master`
//  (firstname,department,surname,title,phone,phone_cc,phone_ext,
//  dob,fax_cc,mobile,idtype,idno,address,city,state,postcode,country,
//  email,website,altcontact,alttelephone,referredby,userid,groupid,passportno,issuedby,expirydate,userofficeid,maxdailylimit,maxmonthlylimit,maxyearlylimit,additionalinfo)
//  VALUES ('".$firstname."','".$department."','".$surname."','".$title."','".$phone."','".$phone_cc."',
//          '".$phone_ext."','".$dob."','".$fax_cc."','".$mobile."','".$idtype."','".$idno."','".$address."',
//              '".$city."','".$state."','".$postcode."','".$country."','".$email."','".$website."',
//                  '".$altcontact."','".$altphone."','".$referredby."','".$userid."','".$groupnameid."',
//                      '".$passportno."','".$issuedby."','".$expirydate."','".$userofficeid."','".$maxdailylimit."',
//                          '".$maxmonthlylimit."','".$maxyearlylimit."','".$additionalinfo."','N', '')";
 //echo $insertSQL;
 //exit();
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Customer information has been successfully added</p>");
  $contactid = mysql_insert_id();
  return $contactid;
   }
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.First name , Surname and DOB are compulsory.The Customer Information has not been added.Please try again</p>");
   }
   
}

function addbeneficiary()
{
   $surname=addslashes($_POST['surname']);
    $address=addslashes($_POST['address']);
    $firstname=addslashes($_POST['firstname']);
    $postcode=addslashes($_POST['postcode']);
    $city=addslashes($_POST['city']);
    $country=addslashes($_POST['country']);
   $phone=addslashes($_POST['phone']);
     $mobile=addslashes($_POST['mobile']);
      $email=addslashes($_POST['email']);
      $contactid=addslashes($_POST['contactid']);
      $bankname=addslashes($_POST['bankname']);
      $branchname=addslashes($_POST['branchname']);
      $accountno=addslashes($_POST['accountno']);
      $sortcode=addslashes($_POST['sortcode']);
      $idno=addslashes($_POST['idno']);
	  $country=addslashes($_POST['country']);
	  $state=addslashes($_POST['state']);
	  $branchaddress=addslashes($_POST['branchaddress']);
		$ibanno=addslashes($_POST['ibanno']);
		$swiftcode=addslashes($_POST['swiftcode']);
		$accounttype=addslashes($_POST['accounttype']);
   
   if($firstname!='' && is_numeric($contactid))
   {
  $insertSQL = "INSERT INTO ben_master
  (firstname,surname,address,phone,mobile,email,city,country,postcode,bankname,branchname,accountno,sortcode,contactid,idno,state,ibanno,swiftcode,branchaddress,accounttype)
  VALUES ('$firstname','$surname','$address','$phone','$mobile','$email','$city','$country','$postcode','$bankname','$branchname','$accountno','$sortcode','$contactid','$idno','$state','$ibanno','$swiftcode','$branchaddress','$accounttype')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message( "<b><p align=center>Beneficiary information has been successfully added</p>");
   $beneficiaryid = mysql_insert_id();
  return $beneficiaryid;
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Beneficiary Information has not been added.Please try again</p>");
   }
   
}

function editbeneficiary()
{
   $surname=addslashes($_POST['surname']);
    $address=addslashes($_POST['address']);
    $firstname=addslashes($_POST['firstname']);
    $postcode=addslashes($_POST['postcode']);
    $city=addslashes($_POST['city']);
    $country=addslashes($_POST['country']);
   $phone=addslashes($_POST['phone']);
     $mobile=addslashes($_POST['mobile']);
      $email=addslashes($_POST['email']);
      $contactid=addslashes($_POST['contactid']);
      $bankname=addslashes($_POST['bankname']);
      $branchname=addslashes($_POST['branchname']);
      $accountno=addslashes($_POST['accountno']);
      $sortcode=addslashes($_POST['sortcode']);
      $idno=addslashes($_POST['idno']);
	  $country=addslashes($_POST['country']);
	   $benid=addslashes($_POST['benid']);
	    $state=addslashes($_POST['state']);
		$branchaddress=addslashes($_POST['branchaddress']);
		$ibanno=addslashes($_POST['ibanno']);
		$swiftcode=addslashes($_POST['swiftcode']);
		$accounttype=addslashes($_POST['accounttype']);
   
   if($firstname!='' && is_numeric($contactid) && is_numeric($benid))
   {
  $updateSQL="update ben_master set surname='$surname',
  firstname='$firstname',
	  address='$address',
	  city='$city',
	  postcode='$postcode',
	  country='$country',
	  phone='$phone',
	  mobile='$mobile',
	  email='$email',
	  bankname='$bankname',
	  branchname='$branchname',
	  accountno='$accountno',
	  accounttype = '$accounttype',
	  sortcode='$sortcode',state='$state',ibanno='$ibanno',swiftcode='$swiftcode',branchaddress='$branchaddress',
	  idno='$idno' where benid='$benid'";
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message( "<b><p align=center>Beneficiary information has been successfully updated</p>");
 }
else
   {
   display_message( "<b><p align=center>Error: There is a problem.The Beneficiary Information has not been updated.Please try again</p>");
   }
   
}



function getgroupnames($name,$selected,$agentid)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select groupid,name from group_master where userofficeid='$agentid' order by name ASC"; // folders of the user
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $name  = (isset($row['name'])) ? $row['name'] : 0;
        $group1id    = (isset($row['groupid'])) ? $row['groupid'] : 0;

     if($selected==$group1id)
            $temp        = $temp."<option value='".$group1id."' selected>".stripslashes($name)."</option>";
        else
            $temp        = $temp."<option value='".$group1id."'>".stripslashes($name)."</option>";
    }

	 if($selected=='')
	 {
 $temp        = $temp."<option value='' selected>NONE</option>";
	 }
	 else
	 {
		  $temp        = $temp."<option value=''>NONE</option>";

	 }
  

      $temp = $temp."</select>";
    return($temp);
}
function getusernames($name,$selected)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";
    $sql    = "select userid,firstname,lastname from user_master order by firstname ASC"; // folders of the user
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
        $lastname  = (isset($row['lastname'])) ? $row['lastname'] : 0;
        $userid    = (isset($row['userid'])) ? $row['userid'] : 0;

        if($selected==$userid)
            $temp        = $temp."<option value='".$userid."' selected>".stripslashes($firstname)."-".stripslashes($lastname)."</option>";
        else
            $temp        = $temp."<option value='".$userid."'>".stripslashes($firstname)."-".stripslashes($lastname)."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}
function getcontactnames($name,$selected,$agentid)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";

   $sql    = "select contactid,firstname,surname from contact_master where userofficeid='$agentid'  order by firstname ASC"; // folders of the user

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $surname  = (isset($row['surname'])) ? $row['surname'] : 0;
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
        $contactid    = (isset($row['contactid'])) ? $row['contactid'] : 0;

        if($selected==$contactid)
            $temp        = $temp."<option value='".$contactid."' selected>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
        else
            $temp        = $temp."<option value='".$contactid."'>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
    }
        if($selected=='')
       {
     $temp        = $temp."<option value='' selected>NONE</option>";
     }
     else
      {
     $temp        = $temp."<option value=''>NONE</option>";
     }
    $temp = $temp."</select>";
    return($temp);
}

function getbeneficiariesbycustomer($name,$selected,$contactid)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";

   $sql    = "select benid,firstname from ben_master where contactid='$contactid'  order by firstname ASC"; // folders of the user

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
        $benid    = (isset($row['benid'])) ? $row['benid'] : 0;

        if($selected==$benid)
            $temp        = $temp."<option value='".$benid."' selected>".stripslashes($firstname)."</option>";
        else
            $temp        = $temp."<option value='".$benid."'>".stripslashes($firstname)."</option>";
    }
        if($selected=='')
       {
     $temp        = $temp."<option value='' selected>NONE</option>";
     }
     else
      {
     $temp        = $temp."<option value=''>NONE</option>";
     }
    $temp = $temp."</select>";
    return($temp);
}

function getcontactnames1($name,$selected,$agentid)
{
    $temp   = "<select name=".$name." style=\"background-color:#ffffff; border-style: solid\" ".">";

   $sql    = "select contactid,firstname,surname from contact_master where userofficeid='$agentid' order by firstname ASC"; // folders of the user

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
         $surname  = (isset($row['surname'])) ? $row['surname'] : 0;
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
        $contactid    = (isset($row['contactid'])) ? $row['contactid'] : 0;

        if($selected==$contactid)
            $temp        = $temp."<option value='".$contactid."' selected>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
        else
            $temp        = $temp."<option value='".$contactid."'>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
    }
         if($selected=='')
       {
     $temp        = $temp."<option value='' selected>PLEASE SELECT ONE</option>";
     }
     else
      {
     $temp        = $temp."<option value=''>PLEASE SELECT ONE</option>";
     }
    $temp = $temp."</select>";
    return($temp);
}
function getonlinecontactnames($name,$selected,$agentid)
{
    $temp   = "<select name=".$name."  class=bigSelect  ".">";

   $sql    = "select contactid,firstname,surname from contact_master ";
   
   if($agentid != "")
	{
	   $sql = $sql. " and userofficeid='$agentid' ";
	}
	
	$sql = $sql. "order by firstname ASC"; // folders of the user

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $surname  = (isset($row['surname'])) ? $row['surname'] : 0;
        $firstname  = (isset($row['firstname'])) ? $row['firstname'] : 0;
        $contactid    = (isset($row['contactid'])) ? $row['contactid'] : 0;

        if($selected==$contactid)
            $temp        = $temp."<option value='".$contactid."' selected>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
        else
            $temp        = $temp."<option value='".$contactid."'>".stripslashes($firstname)."-".stripslashes($surname)."</option>";
    }
        if($selected=='')
       {
     $temp        = $temp."<option value='' selected>NONE</option>";
     }
     else
      {
     $temp        = $temp."<option value=''>NONE</option>";
     }
    $temp = $temp."</select>";
    return($temp);
}
function getusertype($username)
{ $sql    = "select usertype from user_master where username='$username'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $usertype  = (isset($row['usertype'])) ? $row['usertype'] : "";

      }

    return($usertype);
}

function display_message($msg)
{
echo "<br> <table class='tableBorder' width='50%' align=center cellpadding='1' cellspacing='0'><tr><td width='100%' class='Menu_Head'> Confirmation Message</td></tr><tr><td class='message_display' width='100%'> ".$msg."</td></tr></table><br>";
//echo "<div style='color: #EC0C14; font: 11px Verdana; width: 92%; border: solid gray 1px; padding: 10px; margin: 5px 5px 5px 5px; font-weight: bold; background-color: #DBEFEF'>".$msg."</div>";

}
function display_heading($msg1="sdfsdfsdfsdf",$msg2="&nbsp;&nbsp;&nbsp;",$msg3="&nbsp;&nbsp;&nbsp;")
{
	echo "<br><table class='tableBorder' width='100%' cellpadding='1' cellspacing='0'>
	<tr>
	<td width='33%' class='message_heading'> Step 1- choose the customer</td>
	<td width='33%' class='message_heading'> Step 2- choose the beneficiary</td>
	<td width='33%' class='message_heading'> Step 3- specify the order details</td>
		</tr>
		<tr>
		<td class='message_display' width='33%'>".$msg1."</td>
		<td class='message_display' width='33%'>".$msg2."</td>
		<td class='message_display' width='33%'>".$msg3."</td>
		</tr></table><br>";

//echo "<div style='color: #EC0C14; font: 11px Verdana; width: 92%; border: solid gray 1px; padding: 10px; margin: 5px 5px 5px 5px;font-weight: bold; background-color: #FFFFFF'>".$msg."</div>";

}

?>
