<?
function updateaccounttransaction()
{
     $type=addslashes($_POST['type']);
	 $amount=addslashes($_POST['amount']);
	 $reference=addslashes($_POST['reference']);
	 $transtype=addslashes($_POST['transtype']);
	 $transdate=addslashes($_POST['transdate']);
	 $selaccount=addslashes($_POST['selaccount']);
	 $transid=addslashes($_POST['transid']);
	 $paymenttype = addslashes($_POST['paymenttype']);
	 $account=addslashes($_POST['account']);

	  $transdate = dateConvert($transdate);


    if($selaccount!='' && $amount!='' && $transdate!='' && $transid != "")
   {
     $insertSQL = "update account_transactions set customer='$selaccount',reference='$reference',transdate='$transdate',transtype='$transtype',amount='$amount',paymenttype='$paymenttype',account='$account' where transid='$transid'";
   $updateSQL = "update agentpayments set reference='$reference',paymentdate='$transdate',agentamount='$amount',paymenttype='$paymenttype' where transid='$transid'";
	  
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Account transaction information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Account transaction information has not been added.Please try again</p>");
   }
   
}

function addaccounttransaction()
{
	 global $username;
	 global $global_headofficeid;
     $type=addslashes($_POST['type']);
	 $amount=addslashes($_POST['amount']);
	 $reference=addslashes($_POST['reference']);
	 $transtype=addslashes($_POST['transtype']);
	 $paymenttype=addslashes($_POST['paymenttype']);
	 $transdate=addslashes($_POST['transdate']);
	 $selaccount=addslashes($_POST['selaccount']);
	 $account=addslashes($_POST['account']);
	 $transdate = dateConvert($transdate);
	 $paymenttime = date("H:i:s", UKdst_datetime());  
	 $paymentuser = $username;
    if($selaccount!='' && $amount!='' && $transdate!='')
   {   
  $insertSQL = "INSERT INTO account_transactions (customer,reference,transdate,transtype,amount,paymenttype,account,username)
  VALUES ('$selaccount','$reference','$transdate','$transtype','$amount','$paymenttype','$account','$username')";
	 
 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  $transid = mysql_insert_id();
  if($transtype == "Credit")
	   {
  $insertSQL = "INSERT INTO agentpayments (agentname,agentamount,paymentdate,userofficeid,paymenttype,bankname,accountname,accountno,sortcode,reference,description,paymenttime,paymentuser,transid)
  VALUES ('$global_headofficeid','$amount','$transdate','$global_headofficeid','$paymenttype','$bankname','$accountname','$accountno','$sortcode','$reference',
  '$description','$paymenttime','$paymentuser','$transid')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
	   }


  display_message(  "<b><p align=center>Account transaction information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Account transaction information has not been added.Please try again</p>");
   }
   
}

function totalcustomerbalancebeforedate($contactid,$beforedate)
{ 
	$sql    = "select sum(orderamount) as totalsales from sales_master where contactid='$contactid' and orderdate<'$beforedate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(agentcommission) as totalcommission from sales_master where  contactid='$contactid' and orderdate<'$beforedate' and agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}
			
		$sql    = "select sum(amount) as totalcreditamount from account_transactions where customer='$contactid' and transdate<'$beforedate' and transtype='Credit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalcreditamount  = (isset($row['totalcreditamount'])) ? $row['totalcreditamount'] : "";
		}

		$sql    = "select sum(amount) as totaldebitamount from account_transactions where customer='$contactid' and transdate<'$beforedate' and transtype='Debit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totaldebitamount  = (isset($row['totaldebitamount'])) ? $row['totaldebitamount'] : "";
		}
  
    
   return($totalcreditamount-$totalsales-$totalcommission-$totalcashcommission-$totaldebitamount);
}

function totalcustomerbalanceafterdate($contactid,$afterdate)
{ 
	$sql    = "select sum(orderamount) as totalsales from sales_master where contactid='$contactid' and orderdate>'$afterdate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(agentcommission) as totalcommission from sales_master where contactid='$contactid' and orderdate>'$afterdate' and agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}


		$sql    = "select sum(amount) as totalcreditamount from account_transactions where customer='$contactid' and transdate>'$afterdate' and transtype='Credit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalcreditamount  = (isset($row['totalcreditamount'])) ? $row['totalcreditamount'] : "";
		}

		$sql    = "select sum(amount) as totaldebitamount from account_transactions where customer='$contactid' and transdate>'$afterdate' and transtype='Debit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totaldebitamount  = (isset($row['totaldebitamount'])) ? $row['totaldebitamount'] : "";
		}
  

    return($totalcreditamount-$totalsales-$totalcommission-$totalcashcommission-$totaldebitamount);
}

function totalcustomerbalance($contactid)
{ 
	$sql    = "select sum(orderamount) as totalsales from sales_master where contactid='$contactid' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(agentcommission) as totalcommission from sales_master where  contactid='$contactid' and agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}

		
		
		$sql    = "select sum(amount) as totalcreditamount from account_transactions where customer='$contactid'  and transtype='Credit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalcreditamount  = (isset($row['totalcreditamount'])) ? $row['totalcreditamount'] : "";
		}

		$sql    = "select sum(amount) as totaldebitamount from account_transactions where customer='$contactid'  and transtype='Debit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totaldebitamount  = (isset($row['totaldebitamount'])) ? $row['totaldebitamount'] : "";
		}
  
    
   return($totalcreditamount-$totalsales-$totalcommission-$totalcashcommission-$totaldebitamount);
}

function availablecustomerlimit($contactid)
{
					 $sql    = "select sum(orderamount) as totalsales from sales_master where contactid='$contactid'  and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(agentcommission) as totalcommission from sales_master where  contactid='$contactid'  and agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}	
		$sql    = "select sum(amount) as totalcreditamount from account_transactions where customer='$contactid'  and transtype='Credit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalcreditamount  = (isset($row['totalcreditamount'])) ? $row['totalcreditamount'] : "";
		}

		$sql    = "select sum(amount) as totaldebitamount from account_transactions where customer='$contactid'  and transtype='Debit'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totaldebitamount  = (isset($row['totaldebitamount'])) ? $row['totaldebitamount'] : "";
		}
  
    
   return($totalcreditamount-$totalsales-$totalcommission-$totalcashcommission-$totaldebitamount);
}


function getsoldamountbyforexid($paymentid)
{ $sql    = "select sum(benamount) as totalsoldamount from forex_orders where forexid='$paymentid' and benamount>0"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalsoldamount  = (isset($row['totalsoldamount'])) ? $row['totalsoldamount'] : "";
      }
    return($totalsoldamount);
}
function gettotalagentbalance($agentid)
{
$creditamount=getagentcreditlimit($agentid);
$agentopeningbalance = getagentopeningbalance($agentid);
$salesamount=getagentsalestotal($agentid);
$commissionamount=getagentcommissiontotal($agentid);
$paymentamount=getagentpaymentamount($agentid);
$agentcreditbalance = $creditamount+$agentopeningbalance+$paymentamount-$salesamount-$commissionamount;
return $agentcreditbalance;
}
function newexpense()
{
	 
     $expensehead=addslashes($_POST['expensehead']);
	 $expenseamount=addslashes($_POST['expenseamount']);
	 $expensedate=addslashes($_POST['expensedate']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);
     $expensedate = dateConvert($expensedate);
	 global $username;
	 $expensetime = date("H:i:s", UKdst_datetime());  
	 $expenseuser = $username;


    if($expensehead!='' && $expenseamount!='' && $expensedate!='')
   {
  $insertSQL = "INSERT INTO expenses (expensehead,expenseamount,expensedate,reference,description,expensetime,expenseuser)
  VALUES ('$expensehead','$expenseamount','$expensedate','$reference','$description','$expensetime','$expenseuser')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Expense information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Expense Information has not been added.Please try again</p>");
   }
   
}

function editexpense()
{ 
	$expensehead=addslashes($_POST['expensehead']);
	 $expenseamount=addslashes($_POST['expenseamount']);
	 $expensedate=addslashes($_POST['expensedate']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);
      $expensedate = dateConvert($expensedate);

		$expenseid=addslashes($_POST['expenseid']);
		global $username;
	 $expensetime = date("H:i:s", UKdst_datetime());  
	 $expenseuser = $username;
		
    if($expensehead!='' && $expenseamount!='' && $expensedate!='' && $expenseid!='')
   {
  $insertSQL = "update expenses set expensehead='$expensehead',expenseamount='$expenseamount',expensedate='$expensedate',reference='$reference',description='$description',expensetime='$expensetime',expenseuser='$expenseuser' where  expenseid='$expenseid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Expense information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Expense Information has not been updated.Please try again</p>");

   }
}

function getexpenseheads($name,$selected_value){
    $temp   = "<select size=1 name=".$name." style=\"background-color:#EAEAEA; border-style: solid\">";
	  $temp        = $temp."<option value='' >--Choose one--</option>";
   $sql    = "select expenseheadname,expenseheadid from expensehead_master ";
	
		$sql    = $sql." order by expenseheadname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$expenseheadname  = (isset($row['expenseheadname'])) ? $row['expenseheadname'] : 0;
        $expenseheadid  = (isset($row['expenseheadid'])) ? $row['expenseheadid'] : 0;
		 if($expenseheadid==$selected_value)
         $temp        = $temp."<option value='".$expenseheadid."' selected>".stripslashes($expenseheadname)."</option>";
		 else
		 $temp        = $temp."<option value='".$expenseheadid."'>".stripslashes($expenseheadname)."</option>";
    }

    $temp = $temp."</select>";
    return($temp);
}

function getexpenseheadname($expenseheadid)
{
 $sql    = "select expenseheadname from expensehead_master where expenseheadid='$expenseheadid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $expenseheadname = (isset($row['expenseheadname'])) ? $row['expenseheadname'] : "";
 }
    return($expenseheadname);
}

function editexpensehead()
{
    $expenseheadname=addslashes($_POST['expenseheadname']);
    $expenseheadid=$_POST['expenseheadid'];
     
   if($expenseheadname!='' && $expenseheadid!='')
   {
  $insertSQL = "update expensehead_master
  set expenseheadname='$expenseheadname' where
  expenseheadid='$expenseheadid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Expense Head information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Expense Head Information has not been updated.Please try again</p>");

   }
}

function addexpensehead()
{
  $expenseheadname=addslashes($_POST['expenseheadname']);
	  
   if($expenseheadname!='')
   {
  $insertSQL = "INSERT INTO expensehead_master
  (expenseheadname)
  VALUES ('$expenseheadname')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Expense Head information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Expense Head Information has not been added.Please try again</p>");
   }
  
}

function changeddatewithtime($txt_date1)
 {

	 if($txt_date1!='0000-00-00' && $txt_date1!='')
	 {
 $display_date1 = strtotime($txt_date1);
 $month1= date('m', $display_date1);
 $mday1= date('d', $display_date1);
 $year1= date('Y', $display_date1);
 $hour1= date('H', $display_date1);
 $min1= date('i', $display_date1);
 $sec1= date('s', $display_date1);


 $changeddate= date("d/m/Y H:i:s", mktime ($hour1,$min1,$sec1,$month1,$mday1,$year1));
	 }
	 else
	 {
		// $changeddate='00/00/0000';
	 }
 return $changeddate;

 }
function changeddate($txt_date1)
 {

	 if($txt_date1!='0000-00-00' && $txt_date1!='')
	 {
 $display_date1 = strtotime($txt_date1);
 $month1= date('m', $display_date1);
 $mday1= date('d', $display_date1);
 $year1= date('Y', $display_date1);


 $changeddate= date("d/m/Y", mktime (0,0,0,$month1,$mday1,  $year1));
	 }
	 else
	 {
		 $changeddate='00/00/0000';
	 }
 return $changeddate;

 }


function getreportfields($name,$selected_value,$javascript){
    $temp   = "<select name=".$name." ".$javascript.">";
   $sql    = "select displayname,fieldid from report_fields order by displayname ASC"; // folders of the user
    $Result = mysql_query($sql) ;
	
	while ($row  = mysql_fetch_array( $Result)) {
      
		$fieldid  = (isset($row['fieldid'])) ? $row['fieldid'] : 0;
        $displayname  = (isset($row['displayname'])) ? $row['displayname'] : 0;
		 
		 if($fieldid == $selected_value)
         $temp        = $temp."<option value='".$fieldid."' >".$displayname."</option>";
		 else
		 $temp        = $temp."<option value='".$fieldid."' selected>".$displayname."</option>";
		
    }

    $temp = $temp."</select>";
    return($temp);
}


function editreport()
{
		$reportname=$_POST['reportname'];
		$is_empty_allowed=$_POST['is_empty_allowed'];
		$export_headers=$_POST['export_headers'];
		$reportid=$_POST['reportid'];
		$apply_id_document_rule=$_POST['apply_id_document_rule'];
		$payingagent=$_POST['payingagent'];
		
	$SQL = "update report_master set reportname = '".$reportname."',is_empty_allowed = '".$is_empty_allowed."',apply_id_document_rule='".$apply_id_document_rule."',export_headers='".$export_headers."',payingagent='".$payingagent."' where reportid=".$reportid;
	 $Result = mysql_query($SQL) or die(mysql_error()."<br>".$SQL);
	 if($Result){
		display_message(  "<b><p align=center>Report information has been successfully updated.</p>");
	} else {
		display_message(  "<b><p align=center>Error: There is a problem. The Report Information has not been updated. Please try again</p>");
	}
	
}

function addreport()
{
		$reportname=$_POST['reportname'];
		$report_fields=$_POST['SelectedItems'];
		$is_empty_allowed=$_POST['is_empty_allowed'];
		$export_headers=$_POST['export_headers'];
			$apply_id_document_rule=$_POST['apply_id_document_rule'];
			$payingagent=$_POST['payingagent'];
		
    if($reportname!='' && $report_fields!='')
   {
  $report_fields = substr($report_fields,0,(strlen($report_fields)-2));
  $insertSQL = "INSERT INTO report_master(reportname,report_fields,is_empty_allowed,export_headers,apply_id_document_rule,payingagent)  VALUES ('$reportname','$report_fields','$is_empty_allowed','$export_headers','$apply_id_document_rule','$payingagent')";

  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Report information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Report Information has not been added.Please try again</p>");
   }
  
}

function addfield()
{
		$fieldid=$_POST['fieldid'];
		$reportid=$_POST['reportid'];
		$position=$_POST['position'];
			
    if($reportid!='' && $fieldid!='')
   {
  $insertSQL = "INSERT INTO report_field_group(fieldid,reportid,position)  VALUES ('$fieldid','$reportid','$position')";

  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Field information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Field Information has not been added.Please try again</p>");
   }
  
}


function getreportnames($name,$selected_value){
    $temp   = "<select size=1 name=".$name." >";
    $temp        = $temp."<option value=''>--Choose the report--</option>";
	$sql    = "select reportid,reportname from report_master order by reportname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row1     = mysql_fetch_array( $Result)) {
      
		$reportname  = (isset($row1['reportname'])) ? $row1['reportname'] : 0;
        $reportid  = (isset($row1['reportid'])) ? $row1['reportid'] : 0;
		 if($reportid==$selected_value)
		{
         $temp        = $temp."<option value='".$reportid."' selected>".$reportname."</option>";
		}
		else
		{
		 $temp        = $temp."<option value='".$reportid."'>".$reportname."</option>";
		}

		
    }

    $temp = $temp."</select>";
    return($temp);
}

 function getexchangerate($orderamount,$currency,$payingagent)
{ 
	global $agentid;
	$exchangerate="0";
	$orderamount = round($orderamount);

	$sql    = "select rate from rate_master where currency='$currency' and rangefrom<='$orderamount' and rangeto>='$orderamount' and agent='$agentid' and payingagent='$payingagent' "; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	while ($row      = mysql_fetch_array( $Result))
		{
        $exchangerate  = (isset($row['rate'])) ? $row['rate'] : "";
		return $exchangerate;
		}

    if(strlen($payingagent))
	{
		$sql    = "select rate from rate_master where currency='$currency' and rangefrom<='$orderamount' and rangeto>='$orderamount' and payingagent='$payingagent'  and agent = ''"; // folders of the user
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
			{
			$exchangerate  = (isset($row['rate'])) ? $row['rate'] : "";			
			}
	return $exchangerate;
	}

	$sql    = "select rate from rate_master where currency='$currency' and rangefrom<='$orderamount' and rangeto>='$orderamount'  and agent = ''"; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	while ($row      = mysql_fetch_array( $Result))
		{
        $exchangerate  = (isset($row['rate'])) ? $row['rate'] : "";
		}
  return $exchangerate; 
}



 function getbenexchangerate($benamount,$currency,$payingagent)
{ 
	$exchangerate="0";
	$benamount = round($benamount);
	global $agentid;
	$sql    = "select rate,rangefrom,rangeto from rate_master where currency='$currency' and agent='$agentid' and payingagent='$payingagent'"; // folders of the user
			//echo $sql;
			$Result = safe_query($sql) ;
			while ($row      = mysql_fetch_array( $Result))
				{
					$rate  = (isset($row['rate'])) ? $row['rate'] : "";
					$rangefrom  = (isset($row['rangefrom'])) ? $row['rangefrom'] : "";
					$rangeto  = (isset($row['rangeto'])) ? $row['rangeto'] : "";

					$benrangefrom = $rate*$rangefrom;
					$benrangeto=$rate*$rangeto;

					if($benamount>=$benrangefrom && $benamount<=$benrangeto)
						{
						$exchangerate = $rate;
						}
				return $exchangerate; 
				}
		
	if(strlen($payingagent))
	{	
		 $sql    = "select rate,rangefrom,rangeto from rate_master where currency='$currency' and payingagent='$payingagent' and agent = ''"; // folders of the user
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
			{
			$rate  = (isset($row['rate'])) ? $row['rate'] : "";
			$rangefrom  = (isset($row['rangefrom'])) ? $row['rangefrom'] : "";
			$rangeto  = (isset($row['rangeto'])) ? $row['rangeto'] : "";

			$benrangefrom = $rate*$rangefrom;
			$benrangeto=$rate*$rangeto;

			if($benamount>=$benrangefrom && $benamount<=$benrangeto)
				{
				$exchangerate = $rate;
				}
			return $exchangerate; 
			}
	return $exchangerate; 
	}

	$sql    = "select rate,rangefrom,rangeto from rate_master where currency='$currency' and agent = '' "; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	while ($row      = mysql_fetch_array( $Result))
		{
        $rate  = (isset($row['rate'])) ? $row['rate'] : "";
		$rangefrom  = (isset($row['rangefrom'])) ? $row['rangefrom'] : "";
		$rangeto  = (isset($row['rangeto'])) ? $row['rangeto'] : "";

		$benrangefrom = $rate*$rangefrom;
		$benrangeto=$rate*$rangeto;

		if($benamount>=$benrangefrom && $benamount<=$benrangeto)
			{
			$exchangerate = $rate;
			}
		}
  return $exchangerate; 
}

function getcommissionamount($orderamount,$currency)
{ 
	$commission="0";
	global $agentid;
	$orderamount = round($orderamount);

	$sql    = "select commission,percentage from commission_master where currency='$currency' and rangefrom<='$orderamount' and rangeto>='$orderamount' and agent='$agentid' "; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	
		while ($row      = mysql_fetch_array( $Result))
		{
        $commission  = (isset($row['commission'])) ? $row['commission'] : "";
		$percentage  = (isset($row['percentage'])) ? $row['percentage'] : "";

		if(is_numeric($percentage) && $percentage>0)
		{
			$commission = round((($orderamount*$percentage)/100),2);
		}
		return $commission;
		}
		


	$sql    = "select commission,percentage from commission_master where currency='$currency' and rangefrom<='$orderamount' and rangeto>='$orderamount'"; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	
		while ($row      = mysql_fetch_array( $Result))
		{
        $commission  = (isset($row['commission'])) ? $row['commission'] : "";
		$percentage  = (isset($row['percentage'])) ? $row['percentage'] : "";
		}
		if(is_numeric($percentage) && $percentage>0)
		{
			$commission = round((($orderamount*$percentage)/100),2);
		}
		
  return $commission; 
}

function getorderpayingagentcommission($payingagent,$orderamount)
{ 
	$commission="0";
	$sql    = "select commission from payingagent_master where agentid='$payingagent'"; // folders of the user
	//echo $sql;
    $Result = safe_query($sql) ;
	
		while ($row      = mysql_fetch_array( $Result))
		{
        $commission  = (isset($row['commission'])) ? $row['commission'] : "";
		}
		if(is_numeric($percentage) && $percentage>0)
		{
			//echo "the figure is ".(($orderamount*$percentage)/100);
			$commission = round((($orderamount*$percentage)/100));
		}
		//echo "the commission is ".$commission;
  return $commission; 
}

function getcurrencies($name,$selected_value,$bencountry){
	 $temp   = "<select size=1 name=".$name." >";
     $temp        = $temp."<option value='' selected>--Choose the currency--</option>";
	$sql    = "select currencyname,currencyid,is_default,country from currency_master ";
	$sql    = $sql." order by currencyname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$currencyname  = (isset($row['currencyname'])) ? $row['currencyname'] : 0;
        $currencyid  = (isset($row['currencyid'])) ? $row['currencyid'] : 0;
		$currcountry  = (isset($row['country'])) ? $row['country'] : 0;
		 $is_default  = (isset($row['is_default'])) ? $row['is_default'] : 0;
		 if($currencyid==$selected_value)
         $temp        = $temp."<option value='".$currencyid."' selected>".$currencyname."</option>";
		 else
		 $temp        = $temp."<option value='".$currencyid."'>".$currencyname."</option>";

		 if($is_default=="Y" && $selected_value == "" && $bencountry ==$currcountry)
		{
        $temp        = $temp."<option value='".$currencyid."' selected>".$currencyname."</option>";
		}
    }

    $temp = $temp."</select>";
    return($temp);
}

function getreportcurrencies($name,$selected_value,$javascript){
	 $temp   = "<select size=1 name=".$name." style=\"background-color:#EAEAEA; border-style: solid\"".$javascript.">";
     $temp        = $temp."<option value='' selected>--Choose the currency--</option>";
	$sql    = "select currencyname,currencyid,is_default,country from currency_master ";
	$sql    = $sql." order by currencyname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$currencyname  = (isset($row['currencyname'])) ? $row['currencyname'] : 0;
        $currencyid  = (isset($row['currencyid'])) ? $row['currencyid'] : 0;
		$currcountry  = (isset($row['country'])) ? $row['country'] : 0;
		 $is_default  = (isset($row['is_default'])) ? $row['is_default'] : 0;
		 if($currencyid==$selected_value)
         $temp        = $temp."<option value='".$currencyid."' selected>".$currencyname."</option>";
		 else
		 $temp        = $temp."<option value='".$currencyid."'>".$currencyname."</option>";

		
    }

    $temp = $temp."</select>";
    return($temp);
}
function getbanks($name,$selected_value,$country="",$additional=""){
    $temp   = "<select size=1 name=".$name."  ".$additional.">";
	  $temp        = $temp."<option value='' >--Choose one--</option>";
   $sql    = "select bankname,bankid from bank_master ";
	if($country!='')
	{
		$sql    = $sql." where country='$country'";
	}
		$sql    = $sql." order by bankname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$bankname  = (isset($row['bankname'])) ? $row['bankname'] : 0;
        $bankid  = (isset($row['bankid'])) ? $row['bankid'] : 0;
		 if($bankid==$selected_value)
         $temp        = $temp."<option value='".$bankid."' selected>".stripslashes($bankname)."</option>";
		 else
		 $temp        = $temp."<option value='".$bankid."'>".stripslashes($bankname)."</option>";
    }

    $temp = $temp."</select>";
    return($temp);
}

function getstates($name,$selected_value,$country="",$javascript=""){
    $temp   = "<select size=1 name=".$name." ".$javascript.">";
	$temp        = $temp."<option value='' >--Choose one--</option>";
   $sql    = "select statename,stateid from state_master ";
	if($country!='')
	{
		$sql    = $sql." where country='$country'";
	}
		$sql    = $sql." order by statename ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$statename  = (isset($row['statename'])) ? $row['statename'] : 0;
        $stateid  = (isset($row['stateid'])) ? $row['stateid'] : 0;
		 if($stateid==$selected_value)
         $temp        = $temp."<option value='".$stateid."' selected>".stripslashes($statename)."</option>";
		 else
		 $temp        = $temp."<option value='".$stateid."'>".stripslashes($statename)."</option>";
    }

    $temp = $temp."</select>";
    return($temp);
}

function getcities($name,$selected_value,$state="",$javascript=""){
    $temp   = "<select size=1 name=".$name." ".$javascript.">";
	$temp        = $temp."<option value='' >--Choose one--</option>";
   $sql    = "select cityname,cityid from city_master ";
	if($state!='')
	{
		$sql    = $sql." where state='$state'";
	}
		$sql    = $sql." order by cityname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row      = mysql_fetch_array( $Result)) {
      
		$cityname  = (isset($row['cityname'])) ? $row['cityname'] : 0;
        $cityid  = (isset($row['cityid'])) ? $row['cityid'] : 0;
		 if($cityid==$selected_value)
         $temp        = $temp."<option value='".$cityid."' selected>".stripslashes($cityname)."</option>";
		 else
		 $temp        = $temp."<option value='".$cityid."'>".stripslashes($cityname)."</option>";
    }

    $temp = $temp."</select>";
    return($temp);
}

function getcountryname($countryid)
{
 $sql    = "select countryname from country_master where countryid='$countryid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $countryname = (isset($row['countryname'])) ? $row['countryname'] : "";
 }
    return($countryname);
}

function getcityname($cityid)
{
 $sql    = "select cityname from city_master where cityid='$cityid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $cityname = (isset($row['cityname'])) ? $row['cityname'] : "";
 }
    return($cityname);
}
function getcurrencyname($currencyid)
{
 $sql    = "select currencyname,currencycode from currency_master where currencyid='$currencyid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $currencyname = (isset($row['currencyname'])) ? $row['currencyname'] : "";
		 $currencycode = (isset($row['currencycode'])) ? $row['currencycode'] : "";
 }
    return($currencyname."-".$currencycode);
}
function getshortcurrencyname($currencyid)
{
 $sql    = "select currencycode from currency_master where currencyid='$currencyid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $currencycode = (isset($row['currencycode'])) ? $row['currencycode'] : "";
 }
    return($currencycode);
}


function getcountries($name,$selected_value){
    $temp   = "<select size=1 name=".$name." >";
    $temp        = $temp."<option value=''>--Choose the country--</option>";
	$sql    = "select countryid,countryname,is_default from country_master order by countryname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row1     = mysql_fetch_array( $Result)) {
      
		$countryname  = (isset($row1['countryname'])) ? $row1['countryname'] : 0;
        $countryid  = (isset($row1['countryid'])) ? $row1['countryid'] : 0;
		$is_collectiondefault  = (isset($row1['is_default'])) ? $row1['is_default'] : 0;
		 if($countryid==$selected_value)
		{
         $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
		
		else
		{
		 $temp        = $temp."<option value='".$countryid."'>".$countryname."</option>";
		}

		if($is_collectiondefault=="Y" && $selected_value == "")
		{
        $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
    }

    $temp = $temp."</select>";
    return($temp);
}

function getreportcountries($name,$selected_value){
    $temp   = "<select size=1 name=".$name." >";
    $temp        = $temp."<option value=''>--Choose the country--</option>";
	$sql    = "select countryid,countryname from country_master order by countryname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row1     = mysql_fetch_array( $Result)) {
      
		$countryname  = (isset($row1['countryname'])) ? $row1['countryname'] : 0;
        $countryid  = (isset($row1['countryid'])) ? $row1['countryid'] : 0;
		 if($countryid==$selected_value)
		{
         $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
		
		else
		{
		 $temp        = $temp."<option value='".$countryid."'>".$countryname."</option>";
		}

		
    }

    $temp = $temp."</select>";
    return($temp);
}


function getcollectioncountries($name,$selected_value,$javascript=""){
    $temp   = "<select size=1 name=".$name."  ".$javascript.">";
    $temp        = $temp."<option value=''>--Choose the country--</option>";
	$sql    = "select countryid,countryname,is_default from country_master order by countryname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($row1     = mysql_fetch_array( $Result)) {
      
		$countryname  = (isset($row1['countryname'])) ? $row1['countryname'] : 0;
        $countryid  = (isset($row1['countryid'])) ? $row1['countryid'] : 0;
		 if($countryid==$selected_value)
		{
         $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
		else
		{
		 $temp        = $temp."<option value='".$countryid."'>".$countryname."</option>";
		}

		
    }

    $temp = $temp."</select>";
    return($temp);
}

function getbencountries($name,$selected_value,$javascript=""){
    $temp   = "<select size=1 name=".$name."  ".$javascript.">";
     $temp        = $temp."<option value='' selected>--Choose the country--</option>";
	$sql    = "select countryid,countryname,is_default,is_bendefault from country_master order by countryname ASC"; // folders of the user
    $Result = safe_query($sql) ;
          
	while ($benrow      = mysql_fetch_array( $Result)) {
      
		$countryname  = (isset($benrow['countryname'])) ? $benrow['countryname'] : 0;
        $countryid  = (isset($benrow['countryid'])) ? $benrow['countryid'] : 0;
		 $is_bendefault  = (isset($benrow['is_bendefault'])) ? $benrow['is_bendefault'] : 0;
		 if($countryid==$selected_value)
		{
         $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
		 else
		{
			 $temp        = $temp."<option value='".$countryid."'>".$countryname."</option>";
		}
		
		if($is_bendefault=="Y" && $selected_value == "")
		{
        $temp        = $temp."<option value='".$countryid."' selected>".$countryname."</option>";
		}
    }

    $temp = $temp."</select>";
    return($temp);
}
function editbank()
{
    $bankname=addslashes($_POST['bankname']);
    $bankid=$_POST['bankid'];
     $country=$_POST['country'];

   if($bankname!='' && $bankid!='' && $country!='')
   {
  $insertSQL = "update bank_master
  set bankname='$bankname',country='$country' where
  bankid='$bankid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>bank information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Bank Information has not been updated.Please try again</p>");

   }
}

function editstate()
{
    $statename=addslashes($_POST['statename']);
    $stateid=$_POST['stateid'];
     $country=$_POST['country'];

   if($statename!='' && $stateid!='' && $country!='')
   {
  $insertSQL = "update state_master
  set statename='$statename',country='$country' where
  stateid='$stateid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>State information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The State Information has not been updated.Please try again</p>");

   }
}

function editcity()
{
    $cityname=addslashes($_POST['cityname']);
    $cityid=$_POST['cityid'];
     $state=$_POST['state'];

   if($cityname!='' && $cityid!='' && $state!='')
   {
  $insertSQL = "update city_master
  set cityname='$cityname',state='$state' where
  cityid='$cityid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>City information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The City Information has not been updated.Please try again</p>");

   }
}

function addbank()
{
  $bankname=addslashes($_POST['bankname']);
 $country=$_POST['country'];
	  
   if($bankname!='' && $country!='')
   {
  $insertSQL = "INSERT INTO bank_master
  (bankname,country)
  VALUES ('$bankname','$country')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Bank information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Bank Information has not been added.Please try again</p>");
   }
  
}

function addstate()
{
  $statename=addslashes($_POST['statename']);
 $country=$_POST['country'];
	  
   if($statename!='' && $country!='')
   {
  $insertSQL = "INSERT INTO state_master
  (statename,country)
  VALUES ('$statename','$country')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>State information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The State Information has not been added.Please try again</p>");
   }
  
}

function addcity()
{
  $cityname=addslashes($_POST['cityname']);
 $state=$_POST['state'];
	  
   if($cityname!='' && $state!='')
   {
  $insertSQL = "INSERT INTO city_master
  (cityname,state)
  VALUES ('$cityname','$state')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>City information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The City Information has not been added.Please try again</p>");
   }
  
}

function editcountry()
{
    $countryname=$_POST['countryname'];
    $countryid=$_POST['countryid'];
	$is_default=$_POST['is_default'];
	$is_bendefault=$_POST['is_bendefault'];
	$countrycode=$_POST['countrycode'];

   if($countryname!='' && $countryid!='')
   {
  $insertSQL = "update country_master
  set countryname='$countryname',is_default='$is_default',is_bendefault='$is_bendefault',countrycode='$countrycode' where
  countryid='$countryid'";


//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());

  if($is_bendefault =='Y')
	   {
	  $updatebensql = "update country_master
  set is_bendefault='N' where  countryid not in ('$countryid')";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());

	   }
	    if($is_default =='Y')
	   {
	  $updatebensql = "update country_master
  set is_default='N' where  countryid not in ('$countryid')";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());

	   }
  display_message(  "<b><p align=center>Country information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Country Information has not been updated.Please try again</p>");

   }
}
function addcountry()
{
  $countryname=$_POST['countryname'];
$is_default=$_POST['is_default'];
	$is_bendefault=$_POST['is_bendefault'];
	$countrycode=$_POST['countrycode'];
   if($countryname!='' )
   {

	    if($is_default =='Y')
	   {
	  $updatebensql = "update country_master
  set is_default='N'";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());

	   }
	    if($is_bendefault =='Y')
	   {
	  $updatebensql = "update country_master
  set is_bendefault='N'";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());

	   }
  $insertSQL = "INSERT INTO country_master
  (countryname,is_default,is_bendefault,countrycode)
  VALUES ('$countryname','$is_default','$is_bendefault','$countrycode')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Country information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Country Information has not been added.Please try again</p>");
   }
  
}

function addcommission()
{
  $currency=$_POST['currency'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $commission=$_POST['commission'];
		 $percentage=$_POST['percentage'];
		 $agent=$_POST['agent'];
	
    
   if($currency!='' && $rangefrom!='' && $rangeto!='' && $commission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($commission) && is_numeric($percentage))
   {
	    if($commission>0 && $percentage>0)
	   {
		   display_message(  "<b><p align=center>Error: There is a problem. You cannot specify both flat and percentage commissions. Please try again</p>");
	   }
	   else
	   {
  $insertSQL = "INSERT INTO commission_master(currency,rangefrom,rangeto,commission,percentage,agent)  VALUES ('$currency','$rangefrom','$rangeto','$commission','$percentage','$agent')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Commission information has been successfully added</p>");
	   }
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The commission Information has not been added.Please try again</p>");
   }
  
}

function addagentcommission()
{
  $specialcommission=$_POST['specialcommission'];
  $agentname=$_POST['agentname'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $specialcommcountry=$_POST['specialcommcountry'];
		 $agentcommission=$_POST['agentcommission'];
	
    
   if ($agentname != "" && $rangefrom!='' && $rangeto!='' && $agentcommission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($specialcommission) && is_numeric($agentcommission))
   {
	   
  $insertSQL = "INSERT INTO agentcommission_master(agentname,rangefrom,rangeto,specialcommcountry,specialcommission,agentcommission)  VALUES ('$agentname','$rangefrom','$rangeto','$specialcommcountry','$specialcommission','$agentcommission')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Commission information has been successfully added</p>");
	  
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The commission Information has not been added.Please try again</p>");
   }
  
}

function editagentcommission()
{
  $specialcommission=$_POST['specialcommission'];
  $agentname=$_POST['agentname'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $specialcommcountry=$_POST['specialcommcountry'];
		 $agentcommission=$_POST['agentcommission'];
		 $commissionid=$_POST['commissionid'];
	
    
   if ($agentname != "" && $rangefrom!='' && $rangeto!='' && $agentcommission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($specialcommission) && is_numeric($agentcommission) && is_numeric($commissionid))
   {
	   
  $updateSQL = "update agentcommission_master set agentname='$agentname',rangefrom = '$rangefrom' ,rangeto = '$rangeto',specialcommcountry='$specialcommcountry',specialcommission='$specialcommission',agentcommission='$agentcommission' where commissionid='$commissionid'";

 //echo $insertSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Commission information has been successfully updated</p>");
	  
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The commission Information has not been updated.Please try again</p>");
   }
  
}



function addagentbankcharges()
{
  $bankcharges=$_POST['bankcharges'];
  $agentname=$_POST['agentname'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	   
    
   if ($rangefrom!='' && $rangeto!='' && $bankcharges!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($bankcharges))
   {
	   
  $insertSQL = "INSERT INTO agentbankcharges_master(agentname,rangefrom,rangeto,bankcharges)  VALUES ('$agentname','$rangefrom','$rangeto','$bankcharges')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Bank Charges information has been successfully added</p>");
	  
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Bank Charges Information has not been added.Please try again</p>");
   }
  
}

function editagentbankcharges()
{
  $bankcharges=$_POST['bankcharges'];
  $agentname=$_POST['agentname'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $bankchargesid=$_POST['bankchargesid'];
	
    
   if ($rangefrom!='' && $rangeto!='' && $bankcharges!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($bankcharges) && is_numeric($bankchargesid))
   {
	   
  $updateSQL = "update agentbankcharges_master set agentname='$agentname',rangefrom = '$rangefrom' ,rangeto = '$rangeto',bankcharges='$bankcharges' where bankchargesid='$bankchargesid'";

 //echo $insertSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Bank Charges information has been successfully updated</p>");
	  
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The commission Information has not been updated.Please try again</p>");
   }
  
}

function addcollectionpointcommission()
{
  $collectionpoint=$_POST['collectionpoint'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $commission=$_POST['commission'];
		 $percentage=$_POST['percentage'];
	
    
   if($collectionpoint!='' && $rangefrom!='' && $rangeto!='' && $commission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($commission) && is_numeric($percentage))
   {
	    if($commission>0 && $percentage>0)
	   {
		   display_message(  "<b><p align=center>Error: There is a problem. You cannot specify both flat and percentage commissions. Please try again</p>");
	   }
	   else
	   {
  $insertSQL = "INSERT INTO collcommission_master(collectionpoint,rangefrom,rangeto,commission,percentage)  VALUES ('$collectionpoint','$rangefrom','$rangeto','$commission','$percentage')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Paying Agent Commission information has been successfully added</p>");
	   }
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Paying Agent commission Information has not been added.Please try again</p>");
   }
  
}
function editcommission()
{
  $currency=$_POST['currency'];
     $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $commission=$_POST['commission'];
		   $commissionid=$_POST['commissionid'];
		   $percentage=$_POST['percentage'];
		    $agent=$_POST['agent'];
	
    
   if($currency!='' && $rangefrom!='' && $rangeto!='' && $commission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($commission) && is_numeric($percentage))
   {
	   if($commission>0 && $percentage>0)
	   {
		   display_message(  "<b><p align=center>Error: There is a problem. You cannot specify both flat and percentage commissions. Please try again</p>");
	   }
	   else
	   {
  $updateSQL="update commission_master set currency='$currency',percentage='$percentage', rangefrom='$rangefrom',rangeto='$rangeto',commission='$commission',agent='$agent' where commissionid='$commissionid'";
 // echo $updateSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>commission information has been successfully updated</p>");
	   }
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The commission Information has not been updated.Please try again</p>");
   }
  
}

function editcollectionpointcommission()
{
  $collectionpoint=$_POST['collectionpoint'];
     $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $commission=$_POST['commission'];
		   $commissionid=$_POST['commissionid'];
		   $percentage=$_POST['percentage'];
	
    
   if($collectionpoint!='' && $rangefrom!='' && $rangeto!='' && $commission!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($commission) && is_numeric($percentage))
   {
	   if($commission>0 && $percentage>0)
	   {
		   display_message(  "<b><p align=center>Error: There is a problem. You cannot specify both flat and percentage commissions. Please try again</p>");
	   }
	   else
	   {
  $updateSQL="update collcommission_master set collectionpoint='$collectionpoint',percentage='$percentage', rangefrom='$rangefrom',rangeto='$rangeto',commission='$commission' where commissionid='$commissionid'";
 // echo $updateSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Paying Agent commission information has been successfully updated</p>");
	   }
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Paying Agent commission Information has not been updated.Please try again</p>");
   }
  
}

function addrate()
{
  $currency=$_POST['currency'];
    $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $rate=$_POST['rate'];
		$agent=$_POST['agent'];
		$payingagent=$_POST['payingagent'];
	
    
   if($currency!='' && $rangefrom!='' && $rangeto!='' && $rate!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($rate))
   {
  $insertSQL = "INSERT INTO rate_master(currency,rangefrom,rangeto,rate,agent,payingagent)  VALUES ('$currency','$rangefrom','$rangeto','$rate','$agent','$payingagent')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Rate information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Rate Information has not been added.Please try again</p>");
   }
  
}
function editrate()
{
  $currency=$_POST['currency'];
     $rangefrom=$_POST['rangefrom'];
	  $rangeto=$_POST['rangeto'];
	    $rate=$_POST['rate'];
		   $rateid=$_POST['rateid'];
		   $agent=$_POST['agent'];
		   $payingagent=$_POST['payingagent'];
	
    
   if($currency!='' && $rangefrom!='' && $rangeto!='' && $rate!='' && is_numeric($rangefrom) && is_numeric($rangeto) && is_numeric($rate))
   {
  $updateSQL="update rate_master set currency='$currency',rangefrom='$rangefrom',rangeto='$rangeto',rate='$rate',agent='$agent',payingagent='$payingagent' where rateid='$rateid'";
 //echo $insertSQL;
  $Result1 = mysql_query($updateSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Rate information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Rate Information has not been updated.Please try again</p>");
   }
  
}

function editcurrency()
{
    $currencyname=$_POST['currencyname'];
	 $currencycode=$_POST['currencycode'];
	 $currencyid=$_POST['currencyid'];
	  $country=$_POST['country'];
	  $is_default=$_POST['is_default'];

   if($currencyname!='' && $currencycode!='' && $currencyid!=''  && $country!='')
   {
  $insertSQL = "update currency_master
  set currencyname='$currencyname',currencycode='$currencycode',is_default='$is_default',country='$country' where
  currencyid='$currencyid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Currency information has been successfully updated</p>");


  if($is_default =='Y')
	   {
	  $updatebensql = "update currency_master
  set is_default='N' where  currencyid not in ('$currencyid')  and country='$country'";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());

	   }
	   
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Currency Information has not been updated.Please try again</p>");

   }
}
function addcurrency()
{


  $currencyname=$_POST['currencyname'];
	 $currencycode=$_POST['currencycode'];
	 $country=$_POST['country'];
	 $is_default=$_POST['is_default'];
	
	 
   if($currencyname!='' && $currencycode!=''  && $country!='')
   {
	   if($is_default =='Y')
	   {
	  $updatebensql = "update currency_master
  set is_default='N' where country='$country'";
  $Result1 = mysql_query($updatebensql) or die(mysql_error());
	   }
    
  $insertSQL = "INSERT INTO currency_master
  (currencyname,currencycode,country,is_common,is_default)
  VALUES ('$currencyname','$currencycode','$country','N','$is_default')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Currency information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Currency Information has not been added.Please try again</p>");
   }
  
}

function addevent()
{
  $eventname=addslashes($_POST['eventname']);
	 $eventdescription=addslashes($_POST['eventdescription']);
	 $eventtype=addslashes($_POST['eventtype']);
	 $eventcustomerid=addslashes($_POST['eventcustomerid']);
	
    
   if($eventname!='' && $eventdescription!='' )
   {
  $insertSQL = "INSERT INTO event_master
  (eventname,eventdescription,eventtype,eventcustomerid)
  VALUES ('$eventname','$eventdescription','$eventtype','$eventcustomerid')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Event information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Event Information has not been added.Please try again</p>");
   }
  
}
function editevent()
{
    $eventname=addslashes($_POST['eventname']);
	 $eventdescription=addslashes($_POST['eventdescription']);
	 $eventid=$_POST['eventid'];
	  $eventtype=addslashes($_POST['eventtype']);
	 $eventcustomerid=addslashes($_POST['eventcustomerid']);
	
	
   if($eventname!='' && $eventdescription!='' && $eventid!=''  )
   {
  $insertSQL = "update event_master
  set eventname='$eventname',eventdescription='$eventdescription',eventtype='$eventtype',eventcustomerid='$eventcustomerid' where
  eventid='$eventid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Event information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Event Information has not been updated.Please try again</p>");

   }
}

function getbankname($bankid)
{ $sql    = "select bankname from bank_master where bankid='$bankid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $bankname  = (isset($row['bankname'])) ? $row['bankname'] : "";
      }
    return stripslashes($bankname);
}

function getstatename($stateid)
{ $sql    = "select statename from state_master where stateid='$stateid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $statename  = (isset($row['statename'])) ? $row['statename'] : "";
      }
    return stripslashes($statename);
}
function getpaymentstotal($startsalesdate,$endsalesdate)
{ $sql    = "select sum(beneficiaryamount*beneficiarycurrency) as totalpayments from accounts_payments where paymentdate>='$startsalesdate' and paymentdate<='$endsalesdate'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
      }
    return($totalpayments);
}

function totalsalesbypaymenttype($paymenttype,$agentid,$startsalesdate,$endsalesdate)
{ $sql    = "select sum(orderamount+agentbankcharges) as totalsales from sales_master where officeid='$agentid' and orderdate>='$startsalesdate' and orderdate<='$endsalesdate' and paymenttype='$paymenttype'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
      }
    return($totalsales);
}

function totalinstantsalesbypaymenttype($paymenttype,$agentid,$startsalesdate,$endsalesdate)
{ $sql    = "select sum(orderamount) as totalsales from instantsales_master where officeid='$agentid' and orderdate>='$startsalesdate' and orderdate<='$endsalesdate' and paymenttype='$paymenttype'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
      }
    return($totalsales);
}

function totalbenamount($agentid,$startsalesdate,$endsalesdate)
{ $sql    = "select sum(benamount) as totalbensales from sales_master where officeid='$agentid' and orderdate>='$startsalesdate' and orderdate<='$endsalesdate'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalbensales  = (isset($row['totalbensales'])) ? $row['totalbensales'] : "";
      }
    return($totalbensales);
}


function totalagentbalancebeforedate($agentid,$beforedate)
{ 
	$sql    = "select sum(orderamount+agentbankcharges) as totalsales from sales_master where officeid='$agentid' and orderdate<'$beforedate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(accountcommission) as totalcommission from sales_master where officeid='$agentid' and orderdate<'$beforedate' and accountcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}

		$sql    = "select sum(agentamount) as totalpayments from agentpayments where agentname='$agentid' and paymentdate<'$beforedate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
  
     $openingbalance = getagentopeningbalance($agentid);

    return($openingbalance-$totalsales-$totalcommission+$totalpayments);
}


function totalpayingagentbalancebeforedate($agentid,$beforedate)
{ 
	$sql    = "select sum(orderamount) as totalsales from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate<'$beforedate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(a.agentcommission) as totalcommission from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate<'$beforedate'  and orderdate<'$beforedate' and a.agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}

		$sql    = "select sum(agentamount/exchangerate) as totalpayments from agentpayments where payingagent='$agentid' and paymentdate<'$beforedate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
  
 
    $poundopeningbalance = getpayingagentpoundopeningbalance($agentid);
  
  return($poundopeningbalance-$totalsales-$totalcommission+$totalpayments);
}

function totalpayingagentbalanceafterdate($agentid,$afterdate)
{ 
	
		$sql    = "select sum(orderamount) as totalsales from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate>'$afterdate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(a.agentcommission) as totalcommission from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate<'$beforedate'  and orderdate>'$afterdate' and a.agentcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}

		$sql    = "select sum(agentamount/exchangerate) as totalpayments from agentpayments where payingagent='$agentid' and paymentdate<'$beforedate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
	
	
  return($totalsales-$totalcommission+$totalpayments);
  
}



function totalpayingagentlocalbalancebeforedate($agentid,$beforedate)
{ 
	
		$sql    = "select sum(benamount) as totalsales from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate<'$beforedate' and a.orderstatus in ('Processed','Confirmed') and benamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		

		$sql    = "select sum(agentamount) as totalpayments from agentpayments where payingagent='$agentid' and paymentdate<'$beforedate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
  
     $openingbalance = getpayingagentopeningbalance($agentid);

    return($openingbalance-$totalsales+$totalpayments);
}


function totalpayingagentlocalbalanceafterdate($agentid,$afterdate)
{ 
	
		
		$sql    = "select sum(benamount) as totalsales from sales_master a,payingagent_master c where a.payingagent=c.agentid  and c.agentid='$agentid' and orderdate>'$afterdate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		

		$sql    = "select sum(agentamount) as totalpayments from agentpayments where payingagent='$agentid' and paymentdate>'$afterdate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
  
   
    return($totalpayments-$totalsales);
}


function totalagentbalanceafterdate($agentid,$afterdate)
{ 
	$sql    = "select sum(orderamount+agentbankcharges) as totalsales from sales_master where officeid='$agentid' and orderdate>'$afterdate' and orderamount>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
		}

		$sql    = "select sum(accountcommission) as totalcommission from sales_master where officeid='$agentid' and orderdate>'$afterdate' and accountcommission>0"; 
		//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
		{
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
		}

		$sql    = "select sum(agentamount) as totalpayments from agentpayments where agentname='$agentid' and paymentdate>'$afterdate'"; 
		//echo $sql;
		$Result = safe_query($sql) ;
		while ($row      = mysql_fetch_array( $Result))
		{
        $totalpayments  = (isset($row['totalpayments'])) ? $row['totalpayments'] : "";
		}
  

    return($totalpayments-$totalsales-$totalcommission);
}

function getagentopeningbalance($agentid)
{ $sql    = "select agentopeningbalance from agent_master where agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentopeningbalance  = (isset($row['agentopeningbalance'])) ? $row['agentopeningbalance'] : "";
      }
    return($agentopeningbalance);
}


function getpayingagentopeningbalance($agentid)
{ $sql    = "select agentopeningbalance from payingagent_master where agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $agentopeningbalance  = (isset($row['agentopeningbalance'])) ? $row['agentopeningbalance'] : "";
      }
    return($agentopeningbalance);
}

function getpayingagentpoundopeningbalance($agentid)
{ $sql    = "select poundopeningbalance from payingagent_master where agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $poundopeningbalance  = (isset($row['poundopeningbalance'])) ? $row['poundopeningbalance'] : "";
      }
    return($poundopeningbalance);
}


function getagentcommissionvalue($agentid,$country,$orderamount)
{ $sql    = "select specialcommcountry,specialcommission,agentcommission from agentcommission_master where agentname='$agentid' and rangefrom<='$orderamount' and rangeto>='$orderamount'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $specialcommcountry  = (isset($row['specialcommcountry'])) ? $row['specialcommcountry'] : "";
		$agentcommission  = (isset($row['agentcommission'])) ? $row['agentcommission'] : "";
		$specialcommission  = (isset($row['specialcommission'])) ? $row['specialcommission'] : "";
      }
// echo "the commcountry = ".$commcountry;
//  echo "the country = ".$country;

	  if($country == $specialcommcountry)
	{
		 // echo "inside".$commission1;
		  return $specialcommission;
	}
	//echo "inside".$commission;
    return($agentcommission);
}


function getagentbankchargesvalue($orderamount)
{ $sql    = "select bankcharges from agentbankcharges_master where rangefrom<='$orderamount' and rangeto>='$orderamount'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $bankcharges  = (isset($row['bankcharges'])) ? $row['bankcharges'] : "";
		}

    return($bankcharges);
}

function getpayingagentcommissionvalue($agentid)
{ $sql    = "select commission from payingagent_master where agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $commission  = (isset($row['commission'])) ? $row['commission'] : "";
		
      }
 
    return($commission);
}

function getpayingagentcommissionvaluebyagent($agentid)
{ $sql    = "select a.commission as commission from payingagent_master a,agent_master b where a.agentid = b.payingagent and b.agentid='$agentid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $commission  = (isset($row['commission'])) ? $row['commission'] : "";
		
      }
 
    return($commission);
}

function getagentsalestotal($agentid,$startdate="",$enddate="")
{ $sql    = "select sum(orderamount+agentbankcharges) as totalsales from sales_master where officeid='$agentid' and orderamount>0"; // folders of the user
if(strlen($startdate) && strlen($enddate))
	{
$sql = $sql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
      }
    return($totalsales);
}

function getpayingagentcollectionsalestotal($payingagentid,$startdate="",$enddate="")
{ 

	  $specialsql    = "select sum(orderamount) as totalsales from sales_master a,payingagent_master b where a.payingagent=b.agentid and a.payingagent='$payingagentid'  and a.orderstatus in ('Processed','Confirmed') and orderamount>0"; // folders of the user
//echo $specialsql;
if(strlen($startdate) && strlen($enddate))
	{
$specialsql = $specialsql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
		{
        $totalsales  = (isset($specialrow['totalsales'])) ? $specialrow['totalsales'] : "";
      }
		
    return($totalsales);
}

function getpayingagentcollectionsaleslocaltotal($payingagentid)
{ 
	  $specialsql    = "select sum(benamount) as totalsales from sales_master a,payingagent_master b where a.payingagent=b.agentid and a.payingagent='$payingagentid'  and a.orderstatus in ('Processed','Confirmed') and benamount>0"; // folders of the user
//echo $specialsql;
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
		{
        $totalsales  = (isset($specialrow['totalsales'])) ? $specialrow['totalsales'] : "";
      }
		
    return($totalsales);
}

function getpayingagentcommissiontotal($payingagentid,$startdate="",$enddate="")
{ 
	  $specialsql    = "select sum(agentcommission) as totalcommissions from sales_master where payingagent='$payingagentid' and orderstatus in ('Processed','Confirmed') and agentcommission>0"; // folders of the user
	  if(strlen($startdate) && strlen($enddate))
	{
$specialsql = $specialsql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
//echo $specialsql;
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
		{
        $totalcommissions  = (isset($specialrow['totalcommissions'])) ? $specialrow['totalcommissions'] : "";
      }
		
    return($totalcommissions);
}

function availableagentcreditlimit($agentid)
{
					  $salesamount=getagentsalestotal($agentid);
					  $creditamount=getagentcreditlimit($agentid);
                      $paymentamount=getagentpaymentamount($agentid);

					  return ($creditamount+$paymentamount-$salesamount);
}

function getagentcommissiontotal($agentid,$startdate="",$enddate="")
{ $sql    = "select sum(accountcommission) as totalcommission from sales_master where officeid='$agentid' and agentcommission>0 "; 
// folders of the user
//echo $sql;
if(strlen($startdate) && strlen($enddate))
	{
$sql = $sql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
      }
    return($totalcommission);
}

function gettotalagentbankcharges($agentid)
{ $sql    = "select sum(agentbankcharges) as totalbankcharges from sales_master where officeid='$agentid' and agentbankcharges>0 "; 
// folders of the user
//echo $sql;

    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalbankcharges  = (isset($row['totalbankcharges'])) ? $row['totalbankcharges'] : "";
      }
    return($totalbankcharges);
}


function getpayingagentearnedcommissiontotal($payingagentid,$percentage,$startdate="",$enddate="")
{ 
	
		$specialsql    = "select sum(commission2) as earnedcommission1 from sales_master a,payingagent_master b where a.payingagent=b.agentid and a.payingagent='$payingagentid'  and a.orderstatus in ('Processed','Confirmed') and commission2>0 "; // folders of the user
//echo $specialsql;
if(strlen($startdate) && strlen($enddate))
	{
$specialsql = $specialsql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
		{
        $earnedcommission1  = (isset($specialrow['earnedcommission1'])) ? $specialrow['earnedcommission1'] : "";
      }
		
		
  return $earnedcommission1; 
}

function getagentearnedcommissiontotal($agentid,$country,$specialpercentage,$otherpercentage,$startdate="",$enddate="")
{ 
	
$specialsql    = "select sum(commission1) as totalagentcommission from sales_master a where a.officeid='$agentid' and commission1>0 "; 
// folders of the user
//echo $specialsql;
if(strlen($startdate) && strlen($enddate))
	{
$specialsql = $specialsql ." and orderdate>='$startdate' and orderdate<='$enddate'";
	}
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
 {
        $totalagentcommission  = (isset($specialrow['totalagentcommission'])) ? $specialrow['totalagentcommission'] : "";
      }
	  
	 
    return($totalagentcommission);
}

function getagentexpensesforadmin($startdate)
{ 
	
$specialsql    = "select sum(commission1) as totalcommission from sales_master a where commission1>0 and a.orderdate='$startdate'"; // folders of the user
//echo $specialsql;
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
 {
        $totalcommission  = (isset($specialrow['totalcommission'])) ? $specialrow['totalcommission'] : "";
      }
	  
	 return($totalcommission);
}

function getpayingagentexpenseforadmin($startdate)
{ 
	
	$specialsql    = "select sum(commission2) as totalcommission1 from sales_master a where a.orderstatus in ('Processed','Confirmed') and commission2>0 and a.orderdate='$startdate'"; // folders of the user
//echo $specialsql;
    $specialResult = safe_query($specialsql) ;
    while ($specialrow      = mysql_fetch_array( $specialResult))
		{
        $totalcommission1  = (isset($specialrow['totalcommission1'])) ? $specialrow['totalcommission1'] : "";
      }
		
		
  return $totalcommission1; 
}

function totaladmincommission($startsalesdate)
{ $sql    = "select sum(agentcommission) as totaladmincommission from sales_master where orderdate='$startsalesdate' and agentcommission>0"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totaladmincommission  = (isset($row['totaladmincommission'])) ? $row['totaladmincommission'] : "";
      }
    return($totaladmincommission);
}

function totalindirectexpenses($startsalesdate)
{ $sql    = "select sum(expenseamount) as totalindirectexpenses from expenses where expensedate='$startsalesdate' and expensedate>0"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalindirectexpenses  = (isset($row['totalindirectexpenses'])) ? $row['totalindirectexpenses'] : "";
      }
    return($totalindirectexpenses);
}



function getagentcommissiontotalbydate($agentid,$startsalesdate,$endsalesdate)
{ $sql    = "select sum(agentcommission) as totalcommission from sales_master where officeid='$agentid'  and orderdate>='$startsalesdate' and orderdate<='$endsalesdate'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalcommission  = (isset($row['totalcommission'])) ? $row['totalcommission'] : "";
      }
    return($totalcommission);
}


function getagentpaymentamount($agentid)
{ $sql    = "select sum(agentamount) as totalpayment from agentpayments where agentname='$agentid' "; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalpayment  = (isset($row['totalpayment'])) ? $row['totalpayment'] : "";
      }
    return ($totalpayment);
}

function getpayingagentpaymentamount($agentid)
{ $sql    = "select sum(agentamount/exchangerate) as totalpayment from agentpayments where payingagent='$agentid' "; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalpayment  = (isset($row['totalpayment'])) ? $row['totalpayment'] : "";
      }
    return round($totalpayment,2);
}

function getpayingagentpaymentlocalamount($agentid)
{ $sql    = "select sum(agentamount) as totalpayment from agentpayments where payingagent='$agentid' "; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalpayment  = (isset($row['totalpayment'])) ? $row['totalpayment'] : "";
      }
    return round($totalpayment,2);
}

function getcustomersalestotal($contactid)
{
	$year = date('Y');
	$sql    = "select sum(orderamount) as totalsales from sales_master where contactid='$contactid' and year(orderdate)='$year'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalsales  = (isset($row['totalsales'])) ? $row['totalsales'] : "";
      }

	  $sql    = "select sum(orderamount) as totalinstantsales from instantsales_master where contactid='$contactid' and year(orderdate)='$year'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
        $totalinstantsales  = (isset($row['totalinstantsales'])) ? $row['totalinstantsales'] : "";
      }
    return($totalsales + $totalinstantsales);
}


function editpayment()
{
    $beneficiaryname=addslashes($_POST['beneficiaryname']);
	 $beneficiaryaddress=addslashes($_POST['beneficiaryaddress']);
	  $beneficiarycity=addslashes($_POST['beneficiarycity']);
	   $beneficiarycountry=addslashes($_POST['beneficiarycountry']);
	    $beneficiarytelephone=addslashes($_POST['beneficiarytelephone']);
		$paymentdate=addslashes($_POST['paymentdate']);
		$beneficiaryaccno=addslashes($_POST['beneficiaryaccno']);
		$beneficiarybankname=addslashes($_POST['beneficiarybankname']);
		$beneficiarybankaddress=addslashes($_POST['beneficiarybankaddress']);
		$beneficiarycurrency=addslashes($_POST['beneficiarycurrency']);
		$beneficiaryamount=addslashes($_POST['beneficiaryamount']);
		$beneficiaryexchangerate=addslashes($_POST['beneficiaryexchangerate']);
		$paymentid=addslashes($_POST['paymentid']);
		$beneficiaryswiftcode=addslashes($_POST['beneficiaryswiftcode']);
		$onbehalfname=addslashes($_POST['onbehalfname']);
		$onbehalfaddress=addslashes($_POST['onbehalfaddress']);
		$onbehalftelephone=addslashes($_POST['onbehalftelephone']);
      $paymentdate = dateConvert($paymentdate);

   if($beneficiaryname!='' && $beneficiaryamount!='' && $beneficiaryexchangerate!='' && $paymentid!='')
   {
  $insertSQL = "update accounts_payments set beneficiaryname='$beneficiaryname',beneficiaryaddress='$beneficiaryaddress',beneficiarycity='$beneficiarycity',beneficiarycountry='$beneficiarycountry',beneficiarytelephone='$beneficiarytelephone',paymentdate='$paymentdate',beneficiaryaccno='$beneficiaryaccno',beneficiarybankname='$beneficiarybankname',beneficiarybankaddress='$beneficiarybankaddress',beneficiarycurrency='$beneficiarycurrency',beneficiaryamount='$beneficiaryamount',beneficiaryexchangerate='$beneficiaryexchangerate',beneficiaryswiftcode='$beneficiaryswiftcode',onbehalfname='$onbehalfname',onbehalfaddress='$onbehalfaddress',onbehalftelephone='$onbehalftelephone'  where
  paymentid='$paymentid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Payment information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Payment Information has not been updated.Please try again</p>");

   }
}
function addpayment()
{
     $beneficiaryname=addslashes($_POST['beneficiaryname']);
	 $beneficiaryaddress=addslashes($_POST['beneficiaryaddress']);
	  $beneficiarycity=addslashes($_POST['beneficiarycity']);
	   $beneficiarycountry=addslashes($_POST['beneficiarycountry']);
	    $beneficiarytelephone=addslashes($_POST['beneficiarytelephone']);
		$paymentdate=addslashes($_POST['paymentdate']);
		$beneficiaryaccno=addslashes($_POST['beneficiaryaccno']);
		$beneficiarybankname=addslashes($_POST['beneficiarybankname']);
		$beneficiarybankaddress=addslashes($_POST['beneficiarybankaddress']);
		$beneficiarycurrency=addslashes($_POST['beneficiarycurrency']);
		$beneficiaryamount=addslashes($_POST['beneficiaryamount']);
		$beneficiaryexchangerate=addslashes($_POST['beneficiaryexchangerate']);
		$paymentid=addslashes($_POST['paymentid']);
		$beneficiaryswiftcode=addslashes($_POST['beneficiaryswiftcode']);
		$onbehalfname=addslashes($_POST['onbehalfname']);
		$onbehalfaddress=addslashes($_POST['onbehalfaddress']);
		$onbehalftelephone=addslashes($_POST['onbehalftelephone']);
		$userofficeid=addslashes($_POST['userofficeid']);
      $paymentdate = dateConvert($paymentdate);


    if($beneficiaryname!='' && $beneficiaryamount!='' && $beneficiaryexchangerate!='')
   {
  $insertSQL = "INSERT INTO accounts_payments (beneficiaryname,beneficiaryaddress,beneficiarycity,beneficiarycountry,beneficiarytelephone,paymentdate,beneficiaryaccno,beneficiarybankname,beneficiarybankaddress,beneficiarycurrency,beneficiaryamount,beneficiaryexchangerate,beneficiaryswiftcode,onbehalfname,onbehalfaddress,onbehalftelephone,userofficeid)
  VALUES ('$beneficiaryname','$beneficiaryaddress','$beneficiarycity','$beneficiarycountry','$beneficiarytelephone','$paymentdate','$beneficiaryaccno','$beneficiarybankname','$beneficiarybankaddress','$beneficiarycurrency','$beneficiaryamount','$beneficiaryexchangerate','$beneficiaryswiftcode','$onbehalfname','$onbehalfaddress','$onbehalftelephone','$userofficeid')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Payment information has been successfully added</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Payment Information has not been added.Please try again</p>");
   }
   
}

function addagentpayment()
{
     $agentname=addslashes($_POST['agentname']);
	 $agentamount=addslashes($_POST['agentamount']);
	 $userofficeid=addslashes($_POST['userofficeid']);
	 $paymentdate=addslashes($_POST['paymentdate']);
	 $paymenttype=addslashes($_POST['paymenttype']);

	 $bankname=addslashes($_POST['bankname']);
	 $accountname=addslashes($_POST['accountname']);
	 $accountno=addslashes($_POST['accountno']);
	 $sortcode=addslashes($_POST['sortcode']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);
      $paymentdate = dateConvert($paymentdate);
	  global $username;
	 $paymenttime = date("H:i:s", UKdst_datetime());  
	 $paymentuser = $username;


    if($agentname!='' && $agentamount!='' && $paymentdate!='')
   {
  $insertSQL = "INSERT INTO agentpayments (agentname,agentamount,paymentdate,userofficeid,paymenttype,bankname,accountname,accountno,sortcode,reference,description,paymenttime,paymentuser)
  VALUES ('$agentname','$agentamount','$paymentdate','$userofficeid','$paymenttype','$bankname','$accountname','$accountno','$sortcode','$reference','$description','$paymenttime','$paymentuser')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  $inserted_saleid = mysql_insert_id();
  display_message(  "<b><p align=center>Agent Payment information has been successfully added<br>The ID is <b><font color=red>APM".$inserted_saleid."</font></b></p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Agent Payment Information has not been added.Please try again</p>");
   }
   
}

function addpayingagentpayment()
{
     $payingagent=addslashes($_POST['payingagent']);
	 $agentamount=addslashes($_POST['agentamount']);
	  $exchangerate=addslashes($_POST['exchangerate']);
	  $brokerrate=addslashes($_POST['brokerrate']);
	 $userofficeid=addslashes($_POST['userofficeid']);
	 $paymentdate=addslashes($_POST['paymentdate']);
	 $paymenttype=addslashes($_POST['paymenttype']);
      $paymentdate = dateConvert($paymentdate);
	   $currency=addslashes($_POST['currency']);

 $bankname=addslashes($_POST['bankname']);
	 $accountname=addslashes($_POST['accountname']);
	 $accountno=addslashes($_POST['accountno']);
	 $sortcode=addslashes($_POST['sortcode']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);

	 $purposeoftransfer=addslashes($_POST['purposeoftransfer']);
	 $paymentmethod=addslashes($_POST['paymentmethod']);
	 $receiving_amount=addslashes($_POST['receiving_amount']);
	 $swiftcode=addslashes($_POST['swiftcode']);
	 $ibanno=addslashes($_POST['ibanno']);
	 $routingno=addslashes($_POST['routingno']);
	 $clearingcode=addslashes($_POST['clearingcode']);
	 $beneficiaryname=addslashes($_POST['beneficiaryname']);
	 $beneficiaryaddress=addslashes($_POST['beneficiaryaddress']);
	 $beneficiaryiddocument=addslashes($_POST['beneficiaryiddocument']);
	 $beneficiaryidno=addslashes($_POST['beneficiaryidno']);
	 $beneficiaryidexpiry=addslashes($_POST['beneficiaryidexpiry']);
	 $beneficiarypaymentref=addslashes($_POST['beneficiarypaymentref']);


	  global $username;
	 $paymenttime = date("H:i:s", UKdst_datetime());  
	 $paymentuser = $username;
    if($payingagent!='' && $agentamount!='' && $paymentdate!='')
   {
  $insertSQL = "INSERT INTO agentpayments (payingagent,agentamount,paymentdate,userofficeid,paymenttype,exchangerate,currency,bankname,accountname,accountno,sortcode,reference,description,brokerrate,paymentuser,paymenttime,purposeoftransfer,paymentmethod,receiving_amount,swiftcode,ibanno,routingno,clearingcode,beneficiaryname,beneficiaryaddress,beneficiaryiddocument,beneficiaryidno,beneficiaryidexpiry,beneficiarypaymentref)
  VALUES ('$payingagent','$agentamount','$paymentdate','$userofficeid','$paymenttype','$exchangerate','$currency','$bankname','$accountname','$accountno','$sortcode','$reference','$description','$brokerrate','$paymentuser','$paymenttime','$purposeoftransfer','$paymentmethod','$receiving_amount','$swiftcode','$ibanno','$routingno','$clearingcode','$beneficiaryname','$beneficiaryaddress','$beneficiaryiddocument','$beneficiaryidno','$beneficiaryidexpiry','$beneficiarypaymentref')";

 //echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  $inserted_saleid = mysql_insert_id();
   display_message(  "<b><p align=center>Paying Agent Payment information has been successfully added<br>The ID is <b><font color=red>CPM".$inserted_saleid."</font></b></p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Paying Agent Payment Information has not been added.Please try again</p>");
   }
   
}

function editagentpayment()
{
     $agentname=addslashes($_POST['agentname']);
	 $agentamount=addslashes($_POST['agentamount']);
	 $userofficeid=addslashes($_POST['userofficeid']);
	 $paymentdate=addslashes($_POST['paymentdate']);
      $paymentdate = dateConvert($paymentdate);
	  $paymenttype=addslashes($_POST['paymenttype']);
$bankname=addslashes($_POST['bankname']);
	 $accountname=addslashes($_POST['accountname']);
	 $accountno=addslashes($_POST['accountno']);
	 $sortcode=addslashes($_POST['sortcode']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);
		$paymentid=addslashes($_POST['paymentid']);


		$purposeoftransfer=addslashes($_POST['purposeoftransfer']);
	 $paymentmethod=addslashes($_POST['paymentmethod']);
	 $receiving_amount=addslashes($_POST['receiving_amount']);
	 $swiftcode=addslashes($_POST['swiftcode']);
	 $ibanno=addslashes($_POST['ibanno']);
	 $routingno=addslashes($_POST['routingno']);
	 $clearingcode=addslashes($_POST['clearingcode']);
	 $beneficiaryname=addslashes($_POST['beneficiaryname']);
	 $beneficiaryaddress=addslashes($_POST['beneficiaryaddress']);
	 $beneficiaryiddocument=addslashes($_POST['beneficiaryiddocument']);
	 $beneficiaryidno=addslashes($_POST['beneficiaryidno']);
	 $beneficiaryidexpiry=addslashes($_POST['beneficiaryidexpiry']);
	 $beneficiarypaymentref=addslashes($_POST['beneficiarypaymentref']);


		 global $username;
	 $paymenttime = date("H:i:s", UKdst_datetime());  
	 $paymentuser = $username;
		
    if($agentname!='' && $agentamount!='' && $paymentdate!='' && $paymentid!='')
   {
  $insertSQL = "update agentpayments set agentname='$agentname',paymenttype='$paymenttype',agentamount='$agentamount',paymentdate='$paymentdate',bankname='$bankname',accountname='$accountname',accountno='$accountno',sortcode='$sortcode',reference='$reference',description='$description',paymenttime='$paymenttime',paymentuser='$paymentuser'  where
  paymentid='$paymentid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Agent Payment information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Agent Payment Information has not been updated.Please try again</p>");

   }
}

function editpayingagentpayment()
{
     $payingagent=addslashes($_POST['payingagent']);
	 $agentamount=addslashes($_POST['agentamount']);
	 $userofficeid=addslashes($_POST['userofficeid']);
	 $paymentdate=addslashes($_POST['paymentdate']);
	  $exchangerate=addslashes($_POST['exchangerate']);
	  $brokerrate=addslashes($_POST['brokerrate']);
      $paymentdate = dateConvert($paymentdate);
	  $paymenttype=addslashes($_POST['paymenttype']);
	  $currency=addslashes($_POST['currency']);
$bankname=addslashes($_POST['bankname']);
	 $accountname=addslashes($_POST['accountname']);
	 $accountno=addslashes($_POST['accountno']);
	 $sortcode=addslashes($_POST['sortcode']);
	 $reference=addslashes($_POST['reference']);
	 $description=addslashes($_POST['description']);

	 $purposeoftransfer=addslashes($_POST['purposeoftransfer']);
	 $paymentmethod=addslashes($_POST['paymentmethod']);
	 $receiving_amount=addslashes($_POST['receiving_amount']);
	 $swiftcode=addslashes($_POST['swiftcode']);
	 $ibanno=addslashes($_POST['ibanno']);
	 $routingno=addslashes($_POST['routingno']);
	 $clearingcode=addslashes($_POST['clearingcode']);
	 $beneficiaryname=addslashes($_POST['beneficiaryname']);
	 $beneficiaryaddress=addslashes($_POST['beneficiaryaddress']);
	 $beneficiaryiddocument=addslashes($_POST['beneficiaryiddocument']);
	 $beneficiaryidno=addslashes($_POST['beneficiaryidno']);
	 $beneficiaryidexpiry=addslashes($_POST['beneficiaryidexpiry']);
	 $beneficiarypaymentref=addslashes($_POST['beneficiarypaymentref']);
		$paymentid=addslashes($_POST['paymentid']);
		 global $username;
	 $paymenttime = date("H:i:s", UKdst_datetime());  
	 $paymentuser = $username;
		
    if($payingagent!='' && $agentamount!='' && $paymentdate!='' && $paymentid!='')
   {
  $insertSQL = "update agentpayments set payingagent='$payingagent',paymenttype='$paymenttype',agentamount='$agentamount',currency='$currency',exchangerate='$exchangerate',paymentdate='$paymentdate',bankname='$bankname',accountname='$accountname',accountno='$accountno',sortcode='$sortcode',reference='$reference',description='$description',brokerrate='$brokerrate',paymenttime='$paymenttime',paymentuser='$paymentuser',purposeoftransfer='$purposeoftransfer',paymentmethod='$paymentmethod'
  ,receiving_amount='$receiving_amount'
  ,swiftcode='$swiftcode'
  ,ibanno='$ibanno'
  ,clearingcode='$clearingcode',routingno='$routingno'
  ,beneficiaryname='$beneficiaryname'
  ,beneficiaryaddress='$beneficiaryaddress'
  ,beneficiaryiddocument='$beneficiaryiddocument'
  ,beneficiaryidno='$beneficiaryidno'
  ,beneficiaryidexpiry='$beneficiaryidexpiry'
  ,beneficiarypaymentref='$beneficiarypaymentref' where
  paymentid='$paymentid'";

//echo $insertSQL;
  $Result1 = mysql_query($insertSQL) or die(mysql_error());
  display_message(  "<b><p align=center>Paying Agent Payment information has been successfully updated</p>");
 }
else
   {
   display_message(  "<b><p align=center>Error: There is a problem.The Paying Agent Payment Information has not been updated.Please try again</p>");

   }
}

function getcorrespondingagentpayments($name,$selected_value,$payingagent = "",$startsalesdate="",$endsalesdate=""){
    $temp   = "<select size=1 name=".$name." ".">";
    $temp        = $temp."<option value=''>--Choose one--</option>";
	$sql    = "select a.paymentid,c.agentname,date_format(paymentdate,'%d/%m/%Y') as paymentdate,a.exchangerate as buyingrate  from agentpayments a,payingagent_master c where a.payingagent =  c.agentid and a.paymentid is not null "; // folders of the user
	if($payingagent != "")
	{
		$sql = $sql." and a.payingagent = '$payingagent' ";
	}
	/*
	if($startsalesdate!='' && $endsalesdate!="")
	{
 $sql=$sql." and a.paymentdate>='$startsalesdate' and a.paymentdate<='$endsalesdate' ";
	 }
	 */
	 $sql = $sql . " order by a.paymentdate DESC limit 10";
	 //echo $sql;
    $Result = safe_query($sql) ;
    $forexinratecount =0;      
	while ($row1     = mysql_fetch_array( $Result)) {
      
		$paymentid  = (isset($row1['paymentid'])) ? $row1['paymentid'] : 0;
		$paymentdate  = (isset($row1['paymentdate'])) ? $row1['paymentdate'] : 0;
		$buyingrate  = (isset($row1['buyingrate'])) ? $row1['buyingrate'] : 0;
        $agentname  = (isset($row1['agentname'])) ? $row1['agentname'] : 0;
		
		 if($paymentid==$selected_value)
		{
         $temp        = $temp."<option value='".$paymentid."' selected>".$agentname."-".$paymentdate."-".$buyingrate."</option>";
		}
		
		else
		{
		 $temp        = $temp."<option value='".$paymentid."'>".$agentname."-".$paymentdate."-".$buyingrate."</option>";
		}

    }

    $temp = $temp."</select>";
    return($temp);
}

?>


