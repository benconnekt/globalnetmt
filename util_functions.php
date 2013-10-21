<?
function importcsv($file,$head=false,$delim=",",$len=1000) {
		$return = false;
		$handle = fopen($file, "r");
		if ($head) {
			$header = fgetcsv($handle, $len, $delim);
		}
		while (($data = fgetcsv($handle, $len, $delim)) !== FALSE) {
			if ($head AND isset($header)) {
				foreach ($header as $key=>$heading) {
					$row[$heading]=(isset($data[$key])) ? $data[$key] : '';
				}
				$return[]=$row;
			} else {
				$return[]=$data;
			}
		}
		fclose($handle);
		return $return;
	}
	function validatecsv($file,$head=false,$delim=",",$len=1000) {
		$return = false;
		$handle = fopen($file, "r");
		if ($head) {
			$header = fgetcsv($handle, $len, $delim);
		}
		while (($data = fgetcsv($handle, $len, $delim)) !== FALSE) {
			$num_columns=sizeof($data);
			fclose($handle);
			return $num_columns;
		}
	}
function updatesetup()
{
  $customermaxyearly=$_POST['customermaxyearly'];
  $customermaxmonthly=$_POST['customermaxmonthly'];
  $customermaxdaily=$_POST['customermaxdaily'];
  $customeramountcheck=$_POST['customeramountcheck'];
  $customeridcheck=$_POST['customeridcheck'];
  $sdncheck=$_POST['sdncheck'];
  $customernamecheck=$_POST['customernamecheck'];
  $customernamecheck_amount=$_POST['customernamecheck_amount'];
  $customeridcheck_amount=$_POST['customeridcheck_amount'];
  $onlinemaxamount=$_POST['onlinemaxamount'];
		
    
   if($customeridcheck!='' && $sdncheck!='' && $customernamecheck!='' && $customeramountcheck!='' && is_numeric($customermaxyearly) && is_numeric($customermaxmonthly) && is_numeric($customermaxdaily) && is_numeric($customernamecheck_amount) && is_numeric($customeridcheck_amount))
   {
  $FF_dupKeySQL = "SELECT * FROM ml_setup";

  $FF_rsKey=mysql_query($FF_dupKeySQL);

  if(mysql_num_rows($FF_rsKey) > 0)
   {
  $updateSQL="update ml_setup set customermaxyearly='$customermaxyearly',customermaxmonthly='$customermaxmonthly',customermaxdaily='$customermaxdaily',customeramountcheck='$customeramountcheck',customeridcheck='$customeridcheck',sdncheck='$sdncheck',customernamecheck='$customernamecheck',customernamecheck_amount='$customernamecheck_amount',customeridcheck_amount='$customeridcheck_amount',onlinemaxamount='$onlinemaxamount'";
 //echo $insertSQL;
   }
   else
	   {
	  $updateSQL = "INSERT INTO ml_setup
  (customermaxyearly,customermaxmonthly,customermaxdaily,customeramountcheck,customeridcheck,sdncheck,customernamecheck,customernamecheck_amount,customeridcheck_amount,onlinemaxamount)
  VALUES ('$customermaxyearly','$customermaxmonthly','$customermaxdaily','$customeramountcheck','$customeridcheck','$sdncheck','$customernamecheck','$customernamecheck_amount','$customeridcheck_amount','$onlinemaxamount')";
	   }
  $Result1 = mysql_query($updateSQL) or die(mysql_error());

  display_message(  "<b><p align=center>Setup information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Setup Information has not been updated.Please try again</p>");
   }
  
}
function formatInIndianStyle($num)
{
    // This is my function
    $pos = strpos((string)$num, ".");
    if ($pos === false) { $decimalpart="00";}
    else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

    if(strlen($num)>3 & strlen($num) <= 12){
                $last3digits = substr($num, -3 );
                $numexceptlastdigits = substr($num, 0, -3 );
                $formatted = makecomma($numexceptlastdigits);
                $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
    }elseif(strlen($num)<=3){
                $stringtoreturn = $num.".".$decimalpart ;
    }elseif(strlen($num)>12){
                $stringtoreturn = number_format($num, 2);
    }

    if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}

    return $stringtoreturn;
}
function makecomma($input)
{
    // This function is written by some anonymous person - I got it from Google
    if(strlen($input)<=2)
    { return $input; }
    $length=substr($input,0,strlen($input)-2);
    $formatted_input = makecomma($length).",".substr($input,-2);
    return $formatted_input;
}


function getagentnamesforbankstatement($name,$selected,$show_all=false)
{
    $temp   = "<select name=".$name."  class=bigSelect  ".">";
    $sql    = "select agentname,agentid from agent_master where agentstatus='Active' and agenttype!='collectionpoint'";
	$sql    =$sql."  order by agentname  ASC "; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	 
	if($show_all)
	{
		
     if($selected=="ALL")
		{
			$all_selected="selected";
		}
		 $temp        = $temp."<option value='ALL' ".$all_selected.">ALL</option>";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
           $agentname   = (isset($row['agentname'])) ? $row['agentname'] : 0;
             $agentid   = (isset($row['agentid'])) ? $row['agentid'] : 0;

        if($selected==$agentid)
            $temp        = $temp."<option style='background-color:#FAFAD2' value='".$agentid."' selected>".$agentname."</option>";
        else
            $temp        = $temp."<option value='".$agentid."'>".$agentname."</option>";
    }


    $temp = $temp."</select>";
    return($temp);
}

function getcustomeridsforbankstatement($name,$selected)
{
    $temp   = "<select name=".$name."  class=bigSelect  ".">";
    $sql    = "select contactid,firstname,surname from contact_master order by firstname ASC"; // folders of the user
	$temp        = $temp."<option value='' >SELECT ONE</option>";
	
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
            $contactid   = (isset($row['contactid'])) ? $row['contactid'] : 0;
			$firstname   = (isset($row['firstname'])) ? $row['firstname'] : 0;
			$surname   = (isset($row['surname'])) ? $row['surname'] : 0;
			$dob  = (isset($row['dob'])) ? $row['dob'] : "";
     
	   if(strtolower($selected)==$contactid)
            $temp        = $temp."<option style='background-color:#FAFAD2'  value='".$contactid."' selected>".stripslashes($firstname)."-".stripslashes($surname)."-".getcustomeridno($contactid)."-".$dob."</option>";
        else
            $temp        = $temp."<option value='".$contactid."'>".stripslashes($firstname)."-".stripslashes($surname)."-".getcustomeridno($contactid)."-".$dob."</option>";
     
    }


    $temp = $temp."</select>";
    return($temp);
}

function addsdnentry($entnum,$sdnname,$sdntype,$program,$title,$callsign,$vesstype,$tonnage,$grt,$vessflag,$vessowner,$remarks)
{
   
  $insertSQL = "INSERT INTO ml_sdnlist (ent_num,SDN_Name,SDN_Type,Program,Title,Call_Sign,Vess_type,Tonnage,GRT,Vess_flag,Vess_owner,Remarks)
  VALUES ('$entnum','$sdnname','$sdntype','$program','$title',
	  '$callsign','$vesstype','$tonnage','$grt','$vessflag','$vessowner','$remarks')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
 
}

function addaddentry($entnum,$addnum,$address,$city,$country,$addremarks)
{
	$insertSQL = "INSERT INTO ml_addlist (Ent_num,Add_num,Address,City,Country,Add_remarks)
  VALUES ('$entnum','$addnum','$address','$city','$country','$addremarks')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
}

function addaltentry($entnum,$altnum,$alttype,$altname,$remarks)
{
	$insertSQL = "INSERT INTO ml_altlist (ent_num,alt_num,alt_type,alt_name,alt_remarks)
  VALUES ('$entnum','$altnum','$alttype','$altname','$remarks')";
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
}

function addbankstatementrecord($date,$desc,$amount)
{
	$amount = trim($amount);
	if(strlen($date) && strlen($amount) && strlen($desc))
	{
	$insertSQL = "INSERT INTO bankstatement_import(statementdate,statementamount,statementdesc) VALUES ('$date','$amount','$desc')";
	//echo $insertSQL;
 $Result1 = mysql_query($insertSQL) or die(mysql_error());
	}
 
}
function isorderinbankstatement($orderid)
{
	$count =0;
	$sql = "select count(*) as count from bankstatement_import where orderid = '$orderid'";
//	echo $sql;
	$Result = safe_query($sql) ;
    
  while ($row      = mysql_fetch_array( $Result))
 {
        $count = (isset($row['count'])) ? $row['count'] : "";
 }
    return($count);

}


function isvalidpayingagentorder($orderid,$payingagent)
{
	$count =0;
	$orderid= strtolower($orderid);
	$sql = "select count(*) as count from sales_master where lower(orderid) = '$orderid' and payingagent='$payingagent'";
//	echo $sql;
	$Result = safe_query($sql) ;
    
  while ($row      = mysql_fetch_array( $Result))
 {
        $count = (isset($row['count'])) ? $row['count'] : "";
 }
    return($count);

}


function getfoundagentidinbankstatement($statementdesc)
{
	$agentid ="";
	$statementdesc = strtolower($statementdesc);
	$statementpieces = explode(" ",$statementdesc);
		for($j=0;$j<=sizeof($statementpieces);$j++)
		{
		$formattedagentid = $statementpieces[$j];
		$formattedagentid = strtolower($formattedagentid);
		$formattedagentid = str_replace(' ', '', $formattedagentid);
		if(!strlen($formattedagentid))
			continue;
			$sql = "select agentid from agent_master a where lower(agentsuffix) =  '$formattedagentid'";
			//echo $sql;
			$Result = safe_query($sql);	
		   while ($row      = mysql_fetch_array( $Result))
				{
				$agentid = (isset($row['agentid'])) ? $row['agentid'] : "";
				return ($agentid);
				}
			}
   
	}

function getfoundcontactidinbankstatement($statementdesc)
{
	$contactid ="";
	$statementdesc = strtolower($statementdesc);
	$statementpieces = explode(" ",$statementdesc);
		for($j=0;$j<=sizeof($statementpieces);$j++)
		{
		$formattedcontactid = $statementpieces[$j];
		$formattedcontactid = strtolower($formattedcontactid);
		$formattedcontactid = str_replace(' ', '', $formattedcontactid);
		if(!strlen($formattedcontactid))
			continue;
					$sql = "select contactid from contact_master a and (concat('cm',contactid) = '$formattedcontactid' or lower(surname) = '$formattedcontactid')";
				//echo $sql."<br>";
					$Result = safe_query($sql) ;					
					  while ($row      = mysql_fetch_array( $Result))
					 {
						    $contactid = (isset($row['contactid'])) ? $row['contactid'] : "";
							return $contactid;
					 }
		}  
}

function checkwithbankstatement($orderid)
{
	$count =0;
	$sql = "select agentid from agent_master a ,bankstatement_import b where b = '$orderid'";
//	echo $sql;
	$Result = safe_query($sql) ;
    
  while ($row      = mysql_fetch_array( $Result))
 {
        $count = (isset($row['count'])) ? $row['count'] : "";
 }
    return($count);

}

function checkagentpaymentwithbankstatement($agentid,$reference,$date,$amount)
{
	$count =0;
	$reference = strtolower($reference);
	if(strlen($reference))
	{
			$sql = "select count(*) as count from bankstatement_import a where agentid = '$agentid' and lower(statementdesc) like '%$reference%' and statementdate = '$date' and concat(statementamount,'')='$amount'";
		//	echo $sql;
			$Result = safe_query($sql) ;			
			  while ($row      = mysql_fetch_array( $Result))
			 {
					$count = (isset($row['count'])) ? $row['count'] : "";
			 }
		 if($count>0)
			{
			  return("<font color=red size=1>R</font>");
			}
	}
   

}

function checkbankstatementwithagentpayment($agentid,$reference,$date,$amount)
{
	$count =0;
	$reference = strtolower($reference);
	if(strlen($reference))
	{
		$referencepieces = explode(" ",$reference);
			for($j=0;$j<=sizeof($referencepieces);$j++)
			{
			$formattedreference = $referencepieces[$j];
			
				$sql = "select count(*) as count from agentpayments a where agentname = '$agentid' and lower(reference) like '%$formattedreference%' and paymentdate = '$date' and concat(agentamount,'') ='$amount'";
			//	echo $sql;
				$Result = safe_query($sql) ;			
				  while ($row      = mysql_fetch_array( $Result))
				 {
						$count = (isset($row['count'])) ? $row['count'] : "";
				 }
			 if($count>0)
				{
				  return("<font color=red size=1>R</font>");
				}
			}
		
	}
   

}

function checkcustomerpaymentwithbankstatement($contactid,$reference,$date)
{
	$count =0;
	$reference = strtolower($reference);
	if(strlen($reference))
	{
		$sql = "select count(*) as count from bankstatement_import a where orderid = '$contactid' and lower(statementdesc) like '%$reference%' and statementdate = '$date'";
		//echo $sql;
		$Result = safe_query($sql) ;
		
		  while ($row      = mysql_fetch_array( $Result))
		 {
				$count = (isset($row['count'])) ? $row['count'] : "";
		 }
		 if($count>0)
			{
			  return("<font color=red size=1>R</font>");
			}
	}
   

}
function validateAMLConditions($saleid)
{
	$amlMessage = "";
	$customeridcheckflag = false;
	$customernamecheckflag = false;
	$customeramountcheckflag = false;
	$yearlysales =0;
	$monthlysales=0;
	$dailysales=0;
	$maxdailylimit=0;
	$maxmonthlylimit=0;
	$maxyearlylimit=0;
	$sdncheckflag = false;
	$amlsql    = "select * from ml_setup "; // folders of the user
	//echo $sql;
    $amlResult = safe_query($amlsql) ;
    while ($amlrow      = mysql_fetch_array($amlResult))
     {
        $customeridcheck  = (isset($amlrow['customeridcheck'])) ? $amlrow['customeridcheck'] : "";
		$customernamecheck  = (isset($amlrow['customernamecheck'])) ? $amlrow['customernamecheck'] : "";
		$customeramountcheck  = (isset($amlrow['customeramountcheck'])) ? $amlrow['customeramountcheck'] : "";
		$sdncheck  = (isset($amlrow['sdncheck'])) ? $amlrow['sdncheck'] : "";
		$customermaxdaily  = (isset($amlrow['customermaxdaily'])) ? $amlrow['customermaxdaily'] : "";
		$customermaxmonthly  = (isset($amlrow['customermaxmonthly'])) ? $amlrow['customermaxmonthly'] : "";
		$customermaxyearly  = (isset($amlrow['customermaxyearly'])) ? $amlrow['customermaxyearly'] : "";
		$customeridcheck_amount  = (isset($amlrow['customeridcheck_amount'])) ? $amlrow['customeridcheck_amount'] : "";
		$customernamecheck_amount  = (isset($amlrow['customernamecheck_amount'])) ? $amlrow['customernamecheck_amount'] : "";       

      }
	$amlsql = "select a.orderamount,b.firstname,b.surname,a.contactid from sales_master a, contact_master b where a.contactid=b.contactid and a.saleid='$saleid'";

	$amlResult = safe_query($amlsql) ;
   
	while ($amlrow      = mysql_fetch_array( $amlResult))
     {
		$orderamount  = (isset($amlrow['orderamount'])) ? $amlrow['orderamount'] : "";
		$firstname  = (isset($amlrow['firstname'])) ? $amlrow['firstname'] : "";
		$surname  = (isset($amlrow['surname'])) ? $amlrow['surname'] : "";
		$contactid  = (isset($amlrow['contactid'])) ? $amlrow['contactid'] : "";
	 }

	$amlsql = "select maxdailylimit,maxmonthlylimit,maxyearlylimit from contact_master where contactid='$contactid'";

	$amlResult = safe_query($amlsql) ;
   
	while ($amlrow      = mysql_fetch_array( $amlResult))
     {
		$maxdailylimit  = (isset($amlrow['maxdailylimit'])) ? $amlrow['maxdailylimit'] : "";
		$maxmonthlylimit  = (isset($amlrow['maxmonthlylimit'])) ? $amlrow['maxmonthlylimit'] : "";
		$maxyearlylimit  = (isset($amlrow['maxyearlylimit'])) ? $amlrow['maxyearlylimit'] : "";
	 }

   if($customeridcheck == 'Y')
	{
	   $amlsql = "select count(*) as count from sales_master where orderamount>'$customeridcheck_amount' and saleid='$saleid'";
	 //  echo $amlsql."<br>";
	   $amlResult = safe_query($amlsql) ;
   
		while ($amlrow      = mysql_fetch_array($amlResult))
			{
            if($amlrow['count']>0)
				{
				$customeridcheckflag = true;
				}
				
			}
	}
  if($customernamecheck == 'Y')
	{
	   $amlsql = "select count(*) as count from sales_master where orderamount>'$customernamecheck_amount' and saleid='$saleid'";
	  // echo $amlsql."<br>";
	   $amlResult = safe_query($amlsql) ;
   
		while ($amlrow      = mysql_fetch_array($amlResult))
			{
            if($amlrow['count']>0)
				{
				$customernamecheckflag = true;
				}
				
			}
	}
	if($sdncheck == 'Y')
	{
	$firstname=strtolower($firstname);
	$surname=strtolower($surname);
	   $amlsql = "select count(*) as count from ml_sdnlist where lower(SDN_Name) like '%$firstname $surname%' ";
	   $amlResult = safe_query($amlsql) ;
   
		while ($amlrow      = mysql_fetch_array($amlResult))
			{
            if($amlrow['count']>0)
				{
				$sdncheckflag = true;
				}
				
			}
	}

	if($customeramountcheck == 'Y')
	{
		$year = date('Y');
		$month = date('m');
		$date = date('d');
		$today = date('Y-m-d');
		$amlsql    = "select sum(orderamount) as yearlysales from sales_master where contactid='$contactid' and year(orderdate)='$year'"; // folders of the user
		//echo $amlsql;
		$amlResult = safe_query($amlsql) ;
		while ($amlrow      = mysql_fetch_array( $amlResult))
			{
			$yearlysales  = (isset($amlrow['yearlysales'])) ? $amlrow['yearlysales'] : "";
			}
		$amlsql    = "select sum(orderamount) as monthlysales from sales_master where contactid='$contactid' and month(orderdate)='$month'"; // folders of the user
	//	echo $amlsql;
		$amlResult = safe_query($amlsql) ;
		while ($amlrow      = mysql_fetch_array( $amlResult))
			{
			$monthlysales  = (isset($amlrow['monthlysales'])) ? $amlrow['monthlysales'] : "";
			}

		$amlsql    = "select sum(orderamount) as dailysales from sales_master where contactid='$contactid' and orderdate='$today'"; // folders of the user
		//echo $amlsql;
		$amlResult = safe_query($amlsql) ;
		while ($amlrow      = mysql_fetch_array( $amlResult))
			{
			$dailysales  = (isset($amlrow['dailysales'])) ? $amlrow['dailysales'] : "";
			}
		
		if($dailysales>$customermaxdaily)
		{
			if($dailysales>$maxdailylimit)
			{
				
			$customeramountcheckflag = true;
			}
			elseif($maxdailylimit<=0)
			{
				$customeramountcheckflag = true;
			}
				
		}
        
		if($monthlysales>$customermaxmonthly)
		{
			if($monthlysales>$maxmonthlylimit)
			{
			   $customeramountcheckflag = true;
			}
			elseif($maxmonthlylimit<=0)
			{
				$customeramountcheckflag = true;
			}
				
		}

		if($yearlysales>$customermaxyearly)
		{
			if($yearlysales>$maxyearlylimit)
			{
			$customeramountcheckflag = true;
			}
			elseif($maxyearlylimit<=0)
			{
				$customeramountcheckflag = true;
			}
				
		}

		
		
	}
   
 
	if($customernamecheckflag == true)
	{
	 $amlMessage .= "Customer Name Check Required &nbsp;";
	}
	 if($customeramountcheckflag)
	{
	 $amlMessage .= "Customer Daily/Monthly/Yearly Amount Check Failed &nbsp;";
	}
	if($customeridcheckflag)
	{
	 $amlMessage .= "Customer ID Check Required &nbsp;";
	}
	if($sdncheckflag)
	{
	 $amlMessage .= "Customer Name found in SDN Block Persons List &nbsp; ";
	}
//echo $amlMessage;
return $amlMessage;
}
function getMoneyTransferOrdersQuery($filters,$module)
{
	$outputHTML = "";
	if($module == "updateorders" || $module == "updatebankorders"  )
	 {
	$sql            = "select h.agentid as payingagent,a.agentbankcharges,a.collectionofficeid,fo.forexorderid,fo.benamount as forexbenamount, a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join forex_orders fo on a.saleid = fo.saleid  left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid and is_hidden='N' ";
	 }
	 elseif($module == "confirmorders")
	 {
	$sql            = "select h.agentid as payingagent,a.agentbankcharges,a.depositbankname as depositbankname,a.collectionofficeid,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join forex_orders fo on a.saleid = fo.saleid  left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid left join agentpayments ap on ap.paymentid = fo.forexid left join payingagent_master pam on pam.agentid = ap.payingagent where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid  and is_hidden='N' ";
	 }
	 else
		{
	$sql            = "select h.agentid as payingagent,a.agentbankcharges,a.collectionofficeid,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join forex_orders fo on a.saleid = fo.saleid  left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid  and is_hidden='N' ";
		}
  if($module == 'qlist')
	{
		$sql  = $sql. " and a.releaseorder = 'N'";
	}
	elseif($module == 'confirmorders' || $module == 'updateorders' || $module == 'updatebankorders' || $module == 'onlineconfirmorders')
	{
		$sql  = $sql. " and a.releaseorder = 'Y'";
	}
	if($module == 'websiteorders' || $module == 'websitecustomersales' || $module == 'onlineconfirmorders')
	{
		$sql  = $sql. ";
	}
	elseif($module != 'qlist')
		{		
	$sql = $sql.";
		}
		
	$sql = $sql.$filters;
	
	return $sql;
}

function getMoneyTransferOrders($filters,$module,$is_print=false,$formatted_sql="",$deleterights="")
{
	$outputHTML = "";
	$sql = "";

	if($module == 'confirmorders')
	{
		  $balances_array = array();
		  $sql            = "select * from agent_master where  agenttype!='collectionpoint' ";
		  $Result         = safe_query($sql) ;
		  while ($row = mysql_fetch_array( $Result))
		  {
		  $agentid     = (isset($row['agentid'])) ? $row['agentid'] : 0;
		  $startingbalance = gettotalagentbalance($agentid);
		  $balances_array[$agentid]['balance'] = $startingbalance;
		  }
	}


	if($formatted_sql == "")
	{
	 if($module == "updateorders" || $module == "updatebankorders"  )
	 {
	$sql            = "select  h.agentid as payingagent,a.statuscodedesc,a.agentbankcharges,a.collectionofficeid,fo.forexorderid,fo.benamount as forexbenamount,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join forex_orders fo on a.saleid = fo.saleid  left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid  and is_hidden='N' ";
	 }
	 elseif($module == "confirmorders")
	 {
	$sql            = "select h.agentid as payingagent,a.statuscodedesc,a.agentbankcharges,a.depositbankname as depositbankname,a.officeid as officeid,a.collectionofficeid,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join forex_orders fo on a.saleid = fo.saleid  left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid left join agentpayments ap on ap.paymentid = fo.forexid left join payingagent_master pam on pam.agentid = ap.payingagent where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid  and is_hidden='N' ";
	 }
	 else
		{
	$sql            = "select h.agentid as payingagent,a.statuscodedesc,a.agentbankcharges,a.collectionofficeid,a.collectiontype,b.mobile as customermobile,c.mobile as beneficiarymobile,a.releasemessage,a.releaseorder,a.amlnotes,a.bankname,a.branchname,a.accountno,a.ordertime,h.agentname as payingagentname,d.agentname as officename,a.orderdate,a.orderid,a.orderamount,a.agentcommission,e.username as orderby,f.currencycode as currency,a.exchangerate,a.benamount,b.surname as customersurname,b.firstname as customerfirstname,c.surname as bensurname,c.firstname as benfirstname,a.orderstatus,a.saleid,a.benid,a.contactid from contact_master b,ben_master c,agent_master d,sales_master a left join currency_master f on a.currency = f.currencyid left join user_master e on a.orderby = e.userid left join payingagent_master h on a.payingagent = h.agentid where a.contactid=b.contactid and a.benid=c.benid and a.officeid=d.agentid  and is_hidden='N' ";
		}

    if($module == 'qlist')
	{
		$sql  = $sql. " and a.releaseorder = 'N'";
	}
	elseif($module == 'confirmorders' || $module == 'updateorders' || $module == 'updatebankorders' || $module == 'onlineconfirmorders')
	{
		$sql  = $sql. " and a.releaseorder = 'Y'";
	}
	
	if($module == 'websiteorders' || $module == 'websitecustomersales' || $module == 'onlineconfirmorders')
	{
		$sql  = $sql. " and b.is_onlinecustomer = 'Y' ";
	}
	elseif($module != 'qlist')
		{		
	$sql = $sql. " and b.is_onlinecustomer != 'Y' ";
		}
		
	$sql = $sql.$filters;
	}	
	else
	{
	$sql = $formatted_sql."  ";
	}
    if($module == 'confirmorders')
	{
	$sql = $sql." order by orderstatus DESC ";
	}
	else
	{
	$sql = $sql." order by saleid DESC ";
	}
	
  //  echo $sql;
	$Result         = safe_query($sql) ;
	$noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
	// $noOfPages      = ceil($noOfRecords / $DISP_REC_COUNT); // No of pages based on the total records and page sise

	$TR             = 0;
	$i              = 0;

    if($module == "websitecustomersales")
	 {
		$outputHTML.="<table border='0' cellpadding='1' cellspacing='1' style='border-collapse: collapse' bordercolor='#111111' width='100%' id='AutoNumber1'  class='tableBorder'>";

	 }
	 else
	{
	$outputHTML.="<table border='0' cellpadding='1' cellspacing='1' style='border-collapse: collapse' bordercolor='#111111' width='100%' id='AutoNumber1'>";
	}

 if($noOfRecords==0)
  { 
  $outputHTML.="<tr><td width='95%' colspan=20><b> Currently there is no sales information in the system.</b></td></tr>";
  }
  else
 {  
	   if($module == "websitecustomersales")
	 {
		  $outputHTML.="<tr><td class='tableHeader'><b>Order Date</a></b></td> <td class='tableHeader'><b> Trans Code</b></td><td width=5% class='TableHeader'><b>Amount</a></b></td><td width=5%  class='TableHeader'><b>Comm</a></b></td><td width=5% class='TableHeader'><b>Bank Chgs</a></b></td><td width=5% class='TableHeader'><b>Total Amount</a></b></td><td class='TableHeader'><b>Curr</a></b></td><td class='TableHeader'><b>Rate</b></td><td class='TableHeader'><b>Bene</a></b></td><td class='TableHeader'><b>Bene Amount</b></td><td class='TableHeader'> <b>Collection Type</b></td><td class='TableHeader'><b>Status</b></td>";
	 }
	 else
	 {
	
	  $outputHTML.="<tr><td width='5%' class='TableHeader'><b><B> Office</b></td><td class='TableHeader'><b>Order Date</a></b></td>                 <td class='TableHeader'><b> Trans Code</b></td><td class='TableHeader'><b>Customer</b></td><td width=5% class='TableHeader'><b>Amount</a></b></td><td width=5%  class='TableHeader'><b>Comm</a></b></td><td width=5% class='TableHeader'><b>Bank Chgs</a></b></td><td width=5% class='TableHeader'><b>Total Amount</a></b></td><td class='TableHeader'><b>Curr</a></b></td><td class='TableHeader'><b>Rate</b></td><td class='TableHeader'><b>Bene</a></b></td><td class='TableHeader'><b>Bene Amount</b></td><td class='TableHeader'> <b>Collection Type</b></td><td class='TableHeader'> <b>Ordered By</b></td><td class='TableHeader'><b>Status</b></td>";
	 }
	 
	 if($module == "mtsales")
				
	 {
		  $outputHTML = $outputHTML."<td class='TableHeader'><b>Order</b></td>";
		  if($deleterights=='Y')
		 {
			 $outputHTML = $outputHTML." <td class='TableHeader'><b>Action</b></td>";
		 }
	 }
	 elseif($module == "websiteorders")
				
	 {
		  if($deleterights=='Y')
		 {
			 $outputHTML = $outputHTML." <td class='TableHeader'><b>Action</b></td>";
		 }
	 }
	  elseif($module == "updateorders" || $module == "updatebankorders" )
	 {
		  if($module == "updateorders")
		{
			   $outputHTML = $outputHTML."<td class='TableHeader'><b>Collection Point</b></td>";
		}
		if($module == "updatebankorders")
		{
			  $outputHTML = $outputHTML."<td class='TableHeader'><b>Bank</b></td>";
			  $outputHTML = $outputHTML."<td class='TableHeader'><b>Branch</b></td>";
			  $outputHTML = $outputHTML."<td class='TableHeader'><b>Account No</b></td>";
			  $outputHTML = $outputHTML."<td class='TableHeader'><b>Corresponding Agent</b></td>";
		}
		  $outputHTML = $outputHTML."<td class='TableHeader'><b>Update</b></td>";
	 }
	 elseif($module == "confirmorders" || $module == 'onlineconfirmorders')
	 {
		  $outputHTML = $outputHTML."<td width='2%' class='TableHeader'>Deposit Bank/Bank Name</td><td width='2%' class='TableHeader'><b>Confirm</b><br><input type='checkbox' value='on' name='confirmallbox' onclick='checkAll(\"confirm\");'/></td><td width='2%' class='TableHeader'><b>Agent Credit Bal</b></td><td width='2%' class='TableHeader'><b>Hold/ UnHold/ Print</b></td><td width='2%' class='TableHeader'><b>SMS - Cust</b></td><td width='2%' class='TableHeader'><b>SMS - Bene</b></td>";
	 }
	 elseif($module == "smsfororders")
	 {
		  $outputHTML = $outputHTML."<td width='2%' class='TableHeader'><b>SMS - Cust</b></td><td width='2%' class='TableHeader'><b>SMS - Bene</b></td>";
	 }
	  elseif($module == "qlist")
	 {
		  $outputHTML = $outputHTML."<td class='TableHeader'><b>Release</b></td>";
	 }

	 $outputHTML = $outputHTML."</tr>";

 $i=0;
  $no=0;
  $totalprofit=0;
  while ($row = mysql_fetch_array( $Result))
  {

   $i++;
    $no=$no+1;
   $bgcolor       = ($i % 2) ? "Row" : "Row1";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";
	$currency=$row['currency'];
	$saleid=$row['saleid'];
	$benamount=$row['benamount'];
	$exchangerate=$row['exchangerate'];
	$orderamount=$row['orderamount'];
	$orderstatus=$row['orderstatus'];
	$officename=$row['officename'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$ordertime=$row['ordertime'];
	$orderid=$row['orderid'];
	$contactid=$row['contactid'];
	$benid=$row['benid'];
	$bankname=$row['bankname'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$collectiontype=$row['collectiontype'];
	$collectionofficeid=$row['collectionofficeid'];
	$amlnotes=$row['amlnotes'];
	$agentcommissionamount=$row['agentcommission'];
	$fromcurrency=$row['fromcurrency'];
	$cashcommissionamount=$row['cashcommission'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$customersurname = $row['customersurname'];
	$customerfirstname = $row['customerfirstname'];
	$beneficiaryname=$row['benfirstname'];
	$payingagentname=$row['payingagentname'];
	$releaseorder=$row['releaseorder'];
	$customermobile=$row['customermobile'];
	$beneficiarymobile=$row['beneficiarymobile'];
	$forexbenamount=$row['forexbenamount'];
	$forexorderid=$row['forexorderid'];
	$officeid=$row['officeid'];
	$forexpayingagent=$row['forexpayingagent'];
	$depositbankname=$row['depositbankname'];
	$agentbankcharges=$row['agentbankcharges'];
	$statuscodedesc = $row['statuscodedesc'];
	$payingagent = $row['payingagent'];

	if(strlen($statuscodedesc) && $payingagent == '12')
	  {
		$display_statuscodedesc = "<br>".$statuscodedesc;
	  }	 
	  else
	  {
		  $display_statuscodedesc = "";
	  }

	$actualordertype = (strtolower($collectiontype)=='collectionpoint')?"Collection Point":"Bank Account";
	
	if(!strlen($orderby))
	  {
	  $orderby = "Website Order";
	  }
	  
	 if($orderamount>0)
	  {
	$totalturnover=$totalturnover+$orderamount;
	  }
	  if($benamount>0)
	  {
	$totalbenturnover=$totalbenturnover+$benamount;
        $totalBenAmount += $benamount;
	  }
	   if($agentbankcharges>0)
	  {
	$totalbankcharges=$totalbankcharges+$agentbankcharges;
	  }
	  if($agentcommissionamount>0)
	  {
	$totalturnovercomm=$totalturnovercomm+$agentcommissionamount+$cashcommissionamount;
	  }
	  
	  
	if($module =='websitecustomersales')
	  {
		$link="editcustomerorder.php?saleid=".$saleid;
	  }
	  else
	  {
		 if($orderstatus=='Processed')
		  {
		  $link="index.php?status=".base64_encode('processedorder')."&saleid=".$saleid;
		  }
		  else
		  {
			$link="index.php?status=".base64_encode('mtedit')."&saleid=".$saleid;
		  }
	  }
	$contactlink="javascript:opensdndetails(\"".$customersurname."\",\"".$customerfirstname."\")";
	$customerlink="javascript:opencustomerdetails(\"".$contactid."\")";
	
	if(strlen($amlnotes) && $releaseorder != 'Y')
	  {
			$rowClass = "orangeRow";
			$fontColor = "#000000";
			if(strpos($amlnotes,"SDN Block Persons") !== false)
			{
			$rowClass = "redRow";
			$fontColor = "#FFFFFF";
			$contactlink= $contactlink;
			}
			elseif(strpos($amlnotes,"Customer ") !== false)
			{
				$contactlink=$customerlink;
			}
	  }
	  else
	  {
		  $rowClass = $bgcolor;
	  }
	 
  $outputHTML.="<tr>";

  if($module == "websitecustomersales")
	 {
	   $outputHTML.="<td  class=".$rowClass." ><a href='".$link."'>".changeddate($orderdate)." ".$ordertime."</b></a></td>";
	    $outputHTML.="<td  class=".$rowClass." >".$orderid."</b></td>";
	          $outputHTML.="<td class=".$rowClass.">".number_format($orderamount,2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">".number_format(($agentcommissionamount+$cashcommissionamount),2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">".number_format(($agentbankcharges),2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">              ".number_format(($orderamount+$agentcommissionamount+$cashcommissionamount+$agentbankcharges),2)."</b></font></td>";
	          $outputHTML.="<td  class=".$rowClass." >".($currency)."</b></font></td>";
             $outputHTML.="<td  class=".$rowClass." >".$exchangerate."</b></font></td>";
			    $outputHTML.="<td  class=".$rowClass." >".$beneficiaryname."</b></font></td>";
				$outputHTML.="<td class=".$rowClass." >".number_format($benamount,2)."</font></td>";
				$outputHTML.="<td class=".$rowClass." >".$actualordertype."</font></td>";
			  $outputHTML.="<td  class=".$rowClass." >".$orderstatus.$display_statuscodedesc."</b></font></td>";
	 }
	 else
	  {
  if(!$is_print)
	  {
  $outputHTML.="<td  class=".$rowClass."><a href='".$link."'><font color=darkblue> ".$officename."</b></a></font></td>";
  $outputHTML.="<td  class=".$rowClass." ><a href='".$link."'><font color=darkblue>".changeddate($orderdate)." ".$ordertime."</b></a></font></td>";
	  }
	  else
	  {
 $outputHTML.="<td  class=".$rowClass.">".$officename."</b></td>";
  $outputHTML.="<td  class=".$rowClass." >".changeddate($orderdate)." ".$ordertime."</b></td>";

	  }
               $outputHTML.="<td  class=".$rowClass." >".$orderid."</b></font></td>";
			    if($module == "qlist")
				{
			   $outputHTML.="<td  class=".$rowClass." ><a  href='".$contactlink."'><font color=darkblue>".$customername."</font></a></td>";
				}
				elseif($module == "confirmorders" || $module == "smsfororders" || $module == 'onlineconfirmorders')
				{
					$outputHTML.="<td  class=".$rowClass." >".$customername." <br>Mobile:<br>".$customermobile."</font></td>";
					
				}
				else
				{
		  $outputHTML.="<td  class=".$rowClass." >".$customername."</b></font></td>";
				}
			 
			   $outputHTML.="<td class=".$rowClass.">".number_format($orderamount,2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">".number_format(($agentcommissionamount+$cashcommissionamount),2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">".number_format(($agentbankcharges),2)."</b></font></td>";
			   $outputHTML.="<td  class=".$rowClass.">              ".number_format(($orderamount+$agentcommissionamount+$cashcommissionamount+$agentbankcharges),2)."</b></font></td>";
	          $outputHTML.="<td  class=".$rowClass." >".($currency)."</b></font></td>";
             $outputHTML.="<td  class=".$rowClass." >".$exchangerate."</b></font></td>";
			
			 if($module == "confirmorders" || $module == "smsfororders" || $module == 'onlineconfirmorders')
				{
				 $outputHTML.="<td  class=".$rowClass." >".$beneficiaryname."<br>Mobile:<br>".$beneficiarymobile."</b></font></td>";
				}
				else
					{
               $outputHTML.="<td  class=".$rowClass." >".$beneficiaryname."</b></font></td>";
				}
				$outputHTML.="<td class=".$rowClass." >".number_format($benamount,2)."</font></td>";
 
	$outputHTML.=" <td  class=".$rowClass." >".($collectiontype)."</b><br/>".$payingagentname."</font></td>";
	$outputHTML.=" <td  class=".$rowClass." >".($orderby)."</b></font></td>";
	 		  $outputHTML.="<td  class=".$rowClass." >".$orderstatus.$display_statuscodedesc."</b></font></td>";
	  }


if($module == "mtsales")
	  {
			  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><a href='index.php?status=".base64_encode('office')."&contactid=".$contactid."&benid=".$benid."'><font color=darkblue><img src='images/copyicon.gif' alt='Copy Order' border=0></font></a></td>";
				if($deleterights=='Y')
				{
				 $outputHTML.="<td width='2%' align=center class=".$rowClass."><a onclick='return confirmSubmit()'  href='index.php?status=".base64_encode('mtsales')."&saleid=".$saleid."&deleteaction=delete'><img border='0' src='images/del_contact.gif' alt='delete sale'></a></td>";
				}
  }
   elseif($module == "websiteorders")
	{

	   if($deleterights=='Y')
				{
				 $outputHTML.="<td width='2%' align=center class=".$rowClass."><a onclick='return confirmSubmit()'  href='index.php?status=".base64_encode('viewwebsiteorders')."&saleid=".$saleid."&deleteaction=delete'><img border='0' src='images/del_contact.gif' alt='delete sale'></a></td>";
				}
	}

  elseif($module == "updateorders" || $module == "updatebankorders" )
	 {
	  if($module == "updateorders")
	 {
	 $outputHTML.="<td   class=".$rowClass.">".getofficename($collectionofficeid)."</b></font></td>";
	 }
	 elseif($module == "updatebankorders")
	 {
	 $outputHTML.="<td    class=".$rowClass.">".($bankname)."</b></font></td>";
	 $outputHTML.="<td    class=".$rowClass.">".($branchname)."</b></font></td>";
	 $outputHTML.="<td    class=".$rowClass.">".($accountno)."</b></font></td>";
	 $outputHTML.="<td    class=".$rowClass.">".($payingagentname)."</b></font></td>";
	 }
	 // $outputHTML.="<td  class=Row >".$branchname."</b></font></td>";
	 // $outputHTML.="<td  class=Row >".$accountno."</b></font></td>";
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=update_orders[] value=".$saleid."></td>";
	 }
	 elseif($module == "confirmorders" || $module == 'onlineconfirmorders')
	 {
	$outputHTML.="<td    class=".$rowClass.">".($depositbankname)."</b> ".$bankname."</font></td>";
	  if($orderstatus=='Ordered')
		 {
	  $availablebalance  = $balances_array[$officeid]['balance'] - $orderamount; 
	  if($availablebalance>0)
		 {	  
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=confirm_orders[] value=".$saleid."></td>";
		 }
		 else
		 {
	 $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=confirm_orders[] value=".$saleid."><br><font color=red>Not sufficient credit</font></td>";
		 }
		 $balances_array[$officeid]['balance'] = $balances_array[$officeid]['balance']- round($orderamount,2);

		  $outputHTML.="<td width='2%' align=center nowrap class=".$rowClass." ><font color=red>".number_format($balances_array[$officeid]['balance'],2)."</font></td>";
	
		 }
		else
		 {
			$outputHTML.="<td width='2%' align=center  class=".$rowClass.">&nbsp;</td>";
		$outputHTML.="<td width='2%' align=center  class=".$rowClass.">&nbsp;</td>";
		 }
		
		
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=hold_orders[] value=".$saleid." onclick=\"setSelectedOrders()\"></td>";
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=send_customer_sms[] value=".$saleid."></td>";
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=send_beneficiary_sms[] value=".$saleid."></td>";
	 }
	 elseif($module == "smsfororders")
	 {
	 // $outputHTML.="<td  class=Row >".$bankname."</b></font></td>";
	 // $outputHTML.="<td  class=Row >".$branchname."</b></font></td>";
	 // $outputHTML.="<td  class=Row >".$accountno."</b></font></td>";
	   $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=send_customer_sms[] value=".$saleid."></td>";
	  $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=send_beneficiary_sms[] value=".$saleid."></td>";
	 }
	  elseif($module == "qlist")
	 {
	 $outputHTML.="<td width='2%' align=center  class=".$rowClass."><input type=checkbox name=release_orders[] value=".$saleid."></td>";
	 }
$outputHTML.="</tr>";
//if($module == "qlist")
//	 {
	if(strlen($amlnotes) && $releaseorder != 'Y')
	  {
		
$outputHTML.="<tr><td colspan=20 class=".$rowClass."><font color=".$fontColor."><b>".$amlnotes."</b></font></td></tr>";
	  }
//	 }
	
 } 
if($module != 'websitecustomersales' && $module !='confirmorders' && $module != 'onlineconfirmorders')
	 
	 {
		 $outputHTML.="<tr><td ><b>Totals:</b></td><td ><b></b></td><td  ><b><br></b></td><td ><b></b></td><td ><b>".number_format($totalturnover,2)."</b></td><td><b>".number_format($totalturnovercomm,2)."</b></td><td><b>".number_format($totalbankcharges,2)."</b></td><td  ><b>".number_format(($totalturnover+$totalturnovercomm+$totalbankcharges),2)."</b></td><td><br></b></td><td><b></b></td><td></td><td><b>".number_format($totalBenAmount, 2) ."</b></td> <td  ></td> <td ><b><br></b></td></tr>";
 	 }	
	 if($module =='websitecustomersales')
	 
	 {
		  $outputHTML.="<tr><td ><b>Totals:</b></td><td ><b></b></td><td ><b>".number_format($totalturnover,2)."</b></td><td><b>".number_format($totalturnovercomm,2)."</b></td><td><b>".number_format($totalbankcharges,2)."</b></td><td  ><b>".number_format(($totalturnover+$totalturnovercomm+$totalbankcharges),2)."</b></td><td ><td ><b><br></b></td><b><br></b></td><td ></td> <td  ></td> <td ><b><br></b></td></tr>";
 	 }	
	 if($module =='confirmorders' || $module == 'onlineconfirmorders')
	 
	 {
		 $outputHTML.="<tr><td ><b>Totals:</b></td><td ><b></b></td><td  ><b></b></td><td ><b></b></td><td ><b>".number_format($totalturnover,2)."</b></td><td><b>".number_format($totalturnovercomm,2)."</b></td><td><b>".number_format($totalbankcharges,2)."</b></td><td  ><b>".number_format(($totalturnover+$totalturnovercomm+$totalbankcharges),2)."</b></td><td ><td ><b><br></b></td><b><br></b></td><td  ></td><td  ></td><td  ></td><td ><b><br></b></td></tr>";
 	 }	
	
       
                  }

     $outputHTML.="</table>";

	  
 if($module == "qlist" && $amlnotes == "")
	 {
	 $outputHTML = display_message("No orders found in the Q-List");
	 }
return $outputHTML;

}

function getcolorentries()
{
	return "<br><span><div style='width:180' ><table width='100%' cellpadding='1' cellspacing='0' class='Menu_Head'><tr><td width='90%' class='Menu_Head'><img src='images/reports.gif' width='16' height='14'>Color Descriptions</td><td>&nbsp;</td></tr></table></div><div style='width:180'><div><table width=100% cellspacing=1 cellpadding=1 border=1 bgcolor=#EAEAEA bordercolor=#ffffff style='border-collapse:collapse'><tr  height=30><td class=Row width=20>&nbsp;</td><td>All the filtered Transactions </td></tr><tr  height=30><td class=orangeRow width=20>&nbsp;</td><td>Anti-money laundering entries </td></tr><tr  height=30><td class=redRow width=20>&nbsp;</td><td>Black listed ones</td></tr></table></div></div></span>";
}
