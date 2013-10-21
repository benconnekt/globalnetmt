<?php
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
$confirmrights=$_SESSION["MM_CONFIRMRIGHTS"];

//echo "the agent id is ".$agentid;
if(ispayingagent($userid)=='Y')
	  {
	$payingagentid = $agentid;
	
	  }
$agenttype=$_SESSION["MM_AGENTTYPE"];
$agentcommission=$_SESSION["MM_AGENTCOMMISSION"];
}  ?>
<DIV ID="popup_cal" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>
     
<?
  if(base64_decode($_GET['status'])=="agentlists")
   {
	$is_system=true;  
   $pagetitle = "List of Offices/Agents";
   include('agentlists.html');
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewwebsiteorders")
   {
   $is_online=true;
   $pagetitle = "List of Online Orders";
   include('viewwebsiteorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="onlineconfirmorders")
   {
   $is_reports=true;
   $pagetitle = "Confirm Online Orders";
   include('onlineconfirmorders.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewwebsiteuploadeddocuments")
   {
   $is_online=true;
   $pagetitle = "List of Website Uploaded Documents";
   include('viewwebsiteuploadeddocuments.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="customerloginreport")
   {
   $is_online=true;
   $pagetitle = "View Online Customer Login Report";
   include('customerloginreport.html');
   
   exit;
   }
     elseif(base64_decode($_GET['status'])=="contacts_online")
   {
   $is_online=true;
   $pagetitle = "List of Online Customers";
   include('contactmanager_online.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="contacts_onlinenew")
   {
   $is_online=true;
   $pagetitle = "List of New Online Customers Waiting for Approval";
   include('contactmanager_onlinenew.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="contacts_onlineinactive")
   {
   $is_online=true;
   $pagetitle = "List of Online Inactive Customers";
   include('contactmanager_onlineinactive.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="customeraccountreport")
   {
   $is_reports=true;   
   $pagetitle = "Customer Account Report";
   include('customeraccountreport.html');
   exit;
   }
    elseif(base64_decode($_GET['status'])=="editcustomeraccounttransaction")
   {
	 $is_contacts=true;
	 $pagetitle = "Update Customer Transaction";
   include('editcustomeraccounttransaction.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addcustomeraccounttransaction")
   {
	$is_contacts=true;
	$pagetitle = "Add Customer Account Transaction";
   include('addcustomeraccounttransaction.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewcustomeraccounttransactions")
   {
$is_contacts=true;
$pagetitle = "List of  Customer Account Transactions";
   include('viewcustomeraccounttransactions.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="agentbankcharges")
   {
	$is_system=true;
	$pagetitle = "Bank Charges";
   include('agentbankcharges.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newagentbankcharges")
   {
	$is_system=true;
	$pagetitle = "Add Bank Charges";
   include('newagentbankcharges.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editagentbankcharges")
   {
	$is_system=true;
	$pagetitle = "Update Bank Charges";
   include('editagentbankcharges.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="newpaymentdocument")
   {
	$is_reports=true;
	$pagetitle = "Payment/Expense documents";
   include('newpaymentdocument.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="releasedorders")
   {
	$is_reports=true;
	$pagetitle = "List of Security Q Released Orders";
   include('viewreleasedorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="ratecalculator")
   {
	$is_reports=true;
	$pagetitle = "Rate Calculator";
   include('ratecalculator.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewforexorders")
   {
	$is_accounts=true;
	$pagetitle = "List of Forex Profits by Orders";
   include('viewforexorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewarchiveorders")
   {
	$is_reports=true;
	$pagetitle = "List of Archived Orders";
   include('viewarchiveorders.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="newagentcommission")
   {
	$is_system=true;
	$pagetitle = "New Agent Commission";
   include('newagentcommission.html');
   
   exit;
   }
     elseif(base64_decode($_GET['status'])=="editagentcommission")
   {
	$is_system=true;
	$pagetitle = "Update Agent Commission";
   include('editagentcommission.html');
   
   exit;
   }
     elseif(base64_decode($_GET['status'])=="agentcommissions")
   {
	$is_system=true;
	$pagetitle = "View Agent Commissions";
   include('agentcommissions.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="updateforex")
   {
	$is_reports=true;
	$pagetitle = "Update Orders with Corresponding Agent Forex Record";
   include('updateforex.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewuploadeddocuments")
   {
	$is_reports=true;
	$pagetitle = "List of Uploaded Documents";
   include('viewuploadeddocuments.html');   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="updatesdn")
   {
	 $is_reports=true;
	 $pagetitle = "Update SDN List";
   include('updatesdn.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="configuremlrules")
   {
	 $is_reports=true;
	 $pagetitle = "Configure Anti Money Laundering Rules";
   include('configuremlrules.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="failedmllist")
   {
	   $is_reports=true;
	   $pagetitle = "List of Security Q Waiting List";
   include('failedmllist.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewsdn")
   {
	   $is_reports=true;
	   $pagetitle = "List of SDN and Blocked Persons List";
   include('viewsdn.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="allagentcommissionsummary")
   {
   $is_reports=true;   
   $pagetitle = "All Agents Commissions Summary";
   include('allagentcommissionsummary.html');
   exit;
   }
     elseif(base64_decode($_GET['status'])=="idexpirylist")
   {
   $is_reports=true;   
   $pagetitle = "Expired Customer ID's List";
   include('idexpirylist.html');
   exit;
   }
   elseif(base64_decode($_GET['status'])=="allagentaccountsummary")
   {
   $is_reports=true;   
   $pagetitle = "All Agents Account Summary";
   include('allagentaccountsummary.html');
   exit;
   }
    elseif(base64_decode($_GET['status'])=="sendagentsms")
   {
   $is_reports=true;   
   $pagetitle = "Send Agent SMS";
   include('sendagentsms.html');
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newagent")
   {
   $is_system=true;   
   $pagetitle = "New Office/Agent";
   include('newagent.html');
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewwebsiteorders")
   {
   $is_online=true;
   $pagetitle = "List of Online Orders";
   include('viewwebsiteorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="backupdatabase")
   {
   $is_system=true;
   $pagetitle = "Backup Database";
   include('backupdatabase.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="contacts_online")
   {
   $is_online=true;
   $pagetitle = "List of Online Customers";
   include('contactmanager_online.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="allpayingagentcommissionsummary")
   {
   $is_online=true;
   $pagetitle = "All Corresponding Agent Commission Summary";
   include('allpayingagentcommissionsummary.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="contacts_onlineinactive")
   {
   $is_online=true;
   $pagetitle = "List of Online Inactive Customers";
   include('contactmanager_onlineinactive.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewsales")
   {
    $is_reports=true;
	$pagetitle = "List of Money Transfer Sales";
   include('viewsales.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addaccounttransaction")
   {
    $is_accounts=true;
	$pagetitle = "Add Account Transaction";
   include('addaccounttransaction.html');
  
   exit;
   }
    elseif(base64_decode($_GET['status'])=="editaccounttransaction")
   {
	 $is_accounts=true;
	 $pagetitle = "Update Account Transaction";
   include('editaccounttransaction.html');
  
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewaccounttransactions")
   {
	 $is_accounts=true;
	 $pagetitle = "List of Account Transactions";
   include('viewaccounttransactions.html');
  
   exit;
   }

     elseif(base64_decode($_GET['status'])=="editcustomeraccounttransaction")
   {
	 $is_online=true;
	 $pagetitle = "Update Customer Transaction";
   include('editcustomeraccounttransaction.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addcustomeraccounttransaction")
   {
	$is_online=true;
	$pagetitle = "Add Customer Account Transaction";
   include('addcustomeraccounttransaction.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="viewcustomeraccounttransactions")
   {
$is_online=true;
$pagetitle = "List of  Customer Account Transactions";
   include('viewcustomeraccounttransactions.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="soldforexstocks")
   {
$is_accounts=true;
$pagetitle = "List of Sold Forex Stocks";
   include('soldforexstocks.html');
   
   exit;
   }
    elseif(base64_decode($_GET['status'])=="releasedorders")
   {
	$is_reports=true;
	$pagetitle = "List of Security Q Released Orders";
   include('viewreleasedorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="updatesdn")
   {
	 $is_reports=true;
	 $pagetitle = "Update SDN List";
   include('updatesdn.html');
  
   exit;
   }
    elseif(base64_decode($_GET['status'])=="bankstatementorders")
   {
$is_reports=true;
$pagetitle = "Import Bank Statement";
   include('bankstatementorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="configuremlrules")
   {
	 $is_reports=true;
	 $pagetitle = "Configure Anti Money Laundering Rules";
   include('configuremlrules.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="failedmllist")
   {
	   $is_reports=true;
	   $pagetitle = "List of Security Q Waiting List";
   include('failedmllist.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewsdn")
   {
	   $is_reports=true;
	   $pagetitle = "List of SDN and Blocked Persons List";
   include('viewsdn.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editagent")
   {
	    $is_system=true;
		$pagetitle = "Update Office/Agent Information";
   include('editagent.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="accounts")
   {
	   $is_accounts=true;
	   $pagetitle = "List of Accounts";
   include('accountsmanager.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="cargosales")
   {
	    $is_system=true;
   include('cargosales.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="cargoapplication")
   {
	   $is_system=true;
   include('cargoapplication.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="updatecashpayment")
   {
	    $is_accounts=true;
   include('updatecashpayment.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="dailyreport")
   {
	   $is_accounts=true;
	   $pagetitle = "Agent Account Summary";
   include('dailyreport.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addpayment")
   {
	   $is_accounts=true;
	   $pagetitle = "Add Payment";
   include('addpayment.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewpayments")
   {
	    $is_accounts=true;
		$pagetitle = "View Payments";
   include('viewpayments.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editpayment")
   {
	   $is_accounts=true;
	   $pagetitle = "Update Payment";
   include('editpayment.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="collectionsales")
   {
	if(ispayingagent($userid)=='Y')
	   {
		$is_moneytransfer=true;
	   }
	   else
	   {
   $is_reports=true;
	   }
	 $pagetitle = "List of Collection Point Sales";
   include('collectionsales.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="collectionagentsales")
   {
	   $is_moneytransfer=true;
   include('collectionagentsales.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="processmt")
   {
	    $is_moneytransfer=true;
		$pagetitle = "Process Money Transfer Application";
   include('processmt.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="searchcustomer")
   {
	   $is_contacts=true;
   include('searchcustomer.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcollectionpoint")
   {
	    $is_system=true;
		$pagetitle = "Add Collection Point Information";
   include('newcollectionpoint.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="configurations")
   {
	   $is_system=true;
   include('configurations.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="mtsales")
   {
	   if($_GET['reporttype'] != "" && $_GET['reporttype'] != "usersales" )
	   {
		   $is_reports=true;
	   }
	   else
	   {
		   $is_moneytransfer=true;
	   }
	$pagetitle = "List of Money Transfer Transactions";
   include('mtsales.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="mtdailysales")
   {
	    $is_moneytransfer=true;
   include('mtdailysales.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="beneficiaryaccounthistory")
   {
	    $is_contacts=true;
		$pagetitle = "Beneficiary Account History";
   include('beneficiaryaccounthistory.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="mtcustomersales")
   {
	    $is_contacts=true;
   include('mtcustomersales.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="customersales")
   {
	   $is_moneytransfer=true;
	 $pagetitle = "List of Customer Transactions";
   include('customersales.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editmt")
   {
	   $is_moneytransfer=true;
	   $pagetitle = "Update Money Transfer Application";
   include('editmt.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="mtedit")
   {
	   $is_moneytransfer=true;
	   $pagetitle = "Update Money Transfer Application";
   include('editmt.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewcurrencies")
   {
	    $is_system=true;
		$pagetitle = "List of Currencies";
   include('viewcurrencies.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcustomerrequest")
   {
	    $is_contacts=true;
   include('editcustomerrequest.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcollectionpoint")
   {
	    $is_system=true;
		$pagetitle = "Update Collection Point Information";
   include('editcollectionpoint.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="collectionpoints")
   {
	   $is_system=true;
	   $pagetitle = "List of Collection Points";
   include('collectionpoints.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="customerdetails")
   {
	   $is_contacts=true;
	   $pagetitle = "Customer Details";
   include('customerdetails.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcurrency")
   {
	   $is_system=true;
	   $pagetitle = "New Currency";
   include('newcurrency.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="users")
   {
	    $is_system=true;
		$pagetitle = "List of Users";
   include('usermanager.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcurrency")
   {
	    $is_system=true;
		$pagetitle = "Update Currency Information";
   include('editcurrency.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="contacts")
   {
	    $is_contacts=true;
		$pagetitle = "List of Customers";
   include('contactmanager.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="office")
   {
	   $is_moneytransfer=true;
	   $pagetitle = "New Money Transfer Application";
   include('officemanager.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="accounts")
   {
	   $is_accounts=true;
	   $pagetitle = "List of Accounts";
   include('accountsmanager.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="groups")
   {
	   $is_contacts=true;
	   $pagetitle = "List of Groups";
   include('groupmanager.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="help")
   {
	    $is_system=true;
   include('onlinehelp.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcontact")
   {
	     $is_contacts=true;
		 $pagetitle = "New Customer";
   include('newcontact.html');
 
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newgroup")
   {
	     $is_contacts=true;
		 $pagetitle = "New Group";
   include('newgroup.html');
 
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newuser")
   {
	   $is_system=true;
	   $pagetitle = "New User";
   include('newuser.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editgroup")
   {
	   $is_contacts=true;
	   $pagetitle = "Update Group Information";
   include('editgroup.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcontact")
   {
	    $is_contacts=true;
		$pagetitle = "Update Customer Information";
   include('editcontact.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="edituser")
   {
	   $is_system=true;
	   $pagetitle = "Update User Information";
   include('edituser.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="processedorder")
   {
	    $is_moneytransfer=true;
		$pagetitle = "View Processed Money Transfer Application";
   include('processedorder.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcountry")
   {
	    $is_system=true;
		$pagetitle = "New Country";
   include('newcountry.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcountry")
   {
	     $is_system=true;
		 $pagetitle = "Update Country Information";
   include('editcountry.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewcountries")
   {
	    $is_system=true;
		$pagetitle = "List of Countries";
   include('viewcountries.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="confirmorders")
   {
	    $is_reports=true;
		$pagetitle = "Confirm Orders";
   include('confirmorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="updateorders")
   {
	    $is_reports=true;
		$pagetitle = "Update Orders";
   include('updateorders.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="updatebankorders")
   {
	     $is_reports=true;
		 $pagetitle = "Update Orders";
   include('updatebankorders.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="usercommissionreport")
   {
	     $is_accounts=true;
		 $pagetitle = "User Commission Report";
   include('usercommissionreport.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="accountlists")
   {
	    $is_accounts=true;
		$pagetitle = "List of Accounts";
   include('accountlists.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editnote")
   {
	   $is_contacts=true;
	   $pagetitle = "Update Note Information";
   include('editnote.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="notes")
   {
	    $is_contacts=true;
   include('notesmanager.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newmeeting")
   {
	    $is_contacts=true;
		$pagetitle = "New Schedule Information";
   include('newmeeting.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newrate")
   {
	   $is_system=true;
	   $pagetitle = "New Rate";
   include('newrate.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editrate")
   {
	    $is_system=true;
		$pagetitle = "Update Rate Information";
   include('editrate.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="appointments")
   {
	     $is_contacts=true;
		 $pagetitle = "List of Appointments";
   include('appointmentmanager.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editmeeting")
   {
	     $is_contacts=true;
		 $pagetitle = "Update Schedule Information";
   include('editmeeting.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="rates")
   {
	     $is_system=true;
		 $pagetitle = "List of Rates";
   include('rates.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="collectionpointcommissions")
   {
	    $is_accounts=true;
		$pagetitle = "List of Collection Point Commissions";
   include('collectionpointcommissions.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcollectionpointcommission")
   {
	    $is_system=true;
		$pagetitle = "New Collection Point Commission";
   include('newcollectionpointcommission.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcollectionpointcommission")
   {
	    $is_system=true;
		$pagetitle = "Update Collection Point Commission";
   include('editcollectionpointcommission.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="customers")
   {
	    $is_contacts=true;
		$pagetitle = "List of Customers";
   include('customers.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="newcommission")
   {
	    $is_system=true;
		$pagetitle = "Add Commission";
   include('newcommission.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editcommission")
   {
	    $is_system=true;
		$pagetitle = "Update Commission";
   include('editcommission.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="commissions")
   {
	    $is_system=true;
		$pagetitle = "List of Commissions";
   include('commissions.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addagentpayment")
   {
	   $is_accounts=true;
	   $pagetitle = "Add Agent Payment";
   include('addagentpayment.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewagentpayments")
   {
	    $is_accounts=true;
		$pagetitle = "List of Agent Payments";
   include('viewagentpayments.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editagentpayment")
   {
	   $is_accounts=true;
	   $pagetitle = "Update Agent Payment";
   include('editagentpayment.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="dailyaccountreport")
   {
	    $is_accounts=true;
		$pagetitle = "Daily Report";
   include('dailyaccountreport.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="addpayingagentpayment")
   {
	    $is_accounts=true;
		$pagetitle = "Add Corresponding Agent Payment";
   include('addpayingagentpayment.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="editpayingagentpayment")
   {
	    $is_accounts=true;
		$pagetitle = "Update Corresponding Agent Information";
   include('editpayingagentpayment.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="viewpayingagentpayments")
   {
	    $is_accounts=true;
		$pagetitle = "List of Corresponding Agent Forex Payments";
   include('viewpayingagentpayments.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="instantcollectionsales")
   {
	    $is_moneytransfer=true;
   include('instantcollectionsales.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="instantprocessedorder")
   {
	    $is_moneytransfer=true;
   include('instantprocessedorder.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="searchcustomer")
   {
	   $is_moneytransfer=true;
   include('searchcustomer.html');
    
   exit;
   }
   elseif(base64_decode($_GET['status'])=="readonlyrates")
   {
	     $is_moneytransfer=true;
		 $pagetitle = "List of Rates";
   include('ratesreadonly.html');
  
   exit;
   }
   elseif(base64_decode($_GET['status'])=="commissionsreadonly")
   {
	    $is_moneytransfer=true;
		$pagetitle = "List of Commissions";
   include('commissionsreadonly.html');
   
   exit;
   }
   elseif(base64_decode($_GET['status'])=="confirminstantorders")
   {
	    $is_reports=true;
   include('confirminstantorders.html');
   
   exit;
   }
   elseif(base64_decode($_POST['status'])=="searchcustomer")
   {
	    $is_moneytransfer=true;
	include('searchcustomer.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="processinstantmt")
	{
		$is_moneytransfer=true;
	include('processinstantmt.html');
	 
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newaccount")
	{
		$is_accounts=true;
	include('newaccount.html');
	 
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newcomplaint")
	{
		$is_moneytransfer=true;
		$pagetitle = "New Complaint";
	include('newcomplaint.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editcomplaint")
	{
		$is_moneytransfer=true;
		$pagetitle = "Update Complaint Information";
	include('editcomplaint.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewcomplaints")
	{
		$is_moneytransfer=true;
		$pagetitle = "List of Complaints";
	include('viewcomplaints.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="customerinstantsales")
	{
		$is_moneytransfer=true;
	include('customerinstantsales.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="payingagents")
	{
		$is_system=true;
		$pagetitle = "List of Corresponding Agents";
	include('payingagents.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newpayingagent")
	{
		$is_system=true;
		$pagetitle = "Add Corresponding Agent";
	include('newpayingagent.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editpayingagent")
	{
		$is_system=true;
		$pagetitle = "Update Corresponding Agent";
	include('editpayingagent.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="accounts")
	{
		$is_system=true;
	include('accountlists.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newstate")
	{
		$is_system=true;
		$pagetitle = "New State";
	include('newstate.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editstate")
	{
		$is_system=true;
		$pagetitle = "Update State Information";
	include('editstate.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewstates")
	{
		$is_system=true;
		$pagetitle = "List of States";
	include('viewstates.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newcity")
	{
		$is_system=true;
		$pagetitle = "New City";
	include('newcity.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editcity")
	{
		$is_system=true;
		$pagetitle = "Update City Information";
	include('editcity.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewcities")
	{
		$is_system=true;
		$pagetitle = "List of Cities";
	include('viewcities.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="agentexport")
	{
		$is_reports=true;
		$pagetitle = "Corresponding Agent Export";
	include('agentexport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="addreport")
	{
		$is_reports=true;
		$pagetitle = "Add Report";
	include('addreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewreports")
	{
		$is_reports=true;
		$pagetitle = "List of Reports";
	include('viewreports.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editreport")
	{
		$is_reports=true;
		$pagetitle = "Update Report";
	include('editreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="exportedorders")
	{
		$is_reports=true;
		$pagetitle = "List of Uploaded Orders";
	include('exportedorders.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="payingagentreport")
	{
		$is_accounts=true;
		$pagetitle = "Corresponding Agent Account Summary";
	include('payingagentreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="agentcommissionreport")
	{
		$is_accounts=true;
		$pagetitle = "Agent Commission Report";
	include('agentcommissionreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="agentaccountreport")
	{
		$is_accounts=true;
		$pagetitle = "Agent Account Report";
	include('agentaccountreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="payingagentaccountreport")
	{
		$is_accounts=true;
		$pagetitle = "Corresponding Agent Account Report";
	include('payingagentaccountreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="payingagentcommissionreport")
	{
		$is_accounts=true;
		$pagetitle = "Corresponding Agent Commission Report";
	include('payingagentcommissionreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="generalcommissionreport")
	{
		$is_accounts=true;
		$pagetitle = "General Commission Report";
	include('generalcommissionreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="readonlycollectionpoints")
	{
		$is_moneytransfer=true;
		$pagetitle = "List of Collection Points";
	include('readonlycollectionpoints.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newexpensehead")
	{
		$is_system=true;
		$pagetitle = "New Expense Head";
	include('newexpensehead.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editexpensehead")
	{
		$is_system=true;
		$pagetitle = "Update Expense Head";
	include('editexpensehead.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewexpenseheads")
	{
		$is_system=true;
		$pagetitle = "List of Expense Heads";
	include('viewexpenseheads.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newexpense")
	{
		$is_accounts=true;
		$pagetitle = "New Expense";
	include('newexpense.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editexpense")
	{
		$is_accounts=true;
		$pagetitle = "Update Expense";
	include('editexpense.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewexpenses")
	{
		$is_accounts=true;
		$pagetitle = "List of Expenses";
	include('viewexpenses.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="generalaccountreport")
	{
		$is_accounts=true;
		$pagetitle = "Profit/Loss Report";
	include('generalaccountreport.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="contacts_inactive")
	{
		$is_contacts=true;
		$pagetitle = "List of Inactive Customers";
	include('contactmanager_inactive.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewuserlogins")
	{
		$is_system=true;
		$pagetitle = "User Login Report";
	include('viewuserlogins.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="sendcustomersms")
	{
		$is_moneytransfer=true;
		$pagetitle = "Send SMS to Customers";
	include('sendcustomersms.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="smsfororders")
	{
		$is_moneytransfer=true;
		$pagetitle = "Send SMS for Orders";
	include('smsfororders.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewevents")
	{
		$is_system=true;
		$pagetitle = "List of Events";
	include('viewevents.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newevent")
	{
		$is_system=true;
		$pagetitle = "Add Event";
	include('newevent.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editevent")
	{
		$is_system=true;
		$pagetitle = "Update Event";
	include('editevent.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewpasswords")
	{
		$is_system=true;
		$pagetitle = "List of Passwords";
	include('viewpasswords.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newbank")
	{
		$is_system=true;
		$pagetitle = "New Bank";
	include('newbank.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editbank")
	{
		$is_system=true;
		$pagetitle = "Update Bank";
	include('editbank.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewbanks")
	{
		$is_system=true;
		$pagetitle = "List of Banks";
	include('viewbanks.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editcontactorder")
	{
		$is_contacts=true;
	include('editcontactorder.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newbeneficiary")
	{
		$is_contacts=true;
		$pagetitle = "New Beneficiary";
	include('newbeneficiary.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewbeneficiaries")
	{
		$is_contacts=true;
		$pagetitle = "List of Beneficiaries";
	include('viewbeneficiaries.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editbeneficiary")
	{
		$is_contacts=true;
		$pagetitle = "Update Beneficiary";
	include('editbeneficiary.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="newdocument")
	{
		$is_contacts=true;
		$pagetitle = "Add Document";
	include('newdocument.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewdocuments")
	{
		$is_contacts=true;
		$pagetitle = "List of Documents";
	include('viewdocuments.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="addforexstock")
	{
		$is_accounts=true;
		$pagetitle = "Add Forex Stock";
	include('addforexstock.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="editforexstock")
	{
		$is_accounts=true;
		$pagetitle = "Update Forex Stock";
	include('editforexstock.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewforexstocks")
	{
		$is_accounts=true;
		$pagetitle = "List of Forex Stocks";
	include('viewforexstocks.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="viewpaymentaccountstatement")
	{
		$is_accounts=true;
		$pagetitle = "Corresponding Agent Forex Payment Statement";
	include('viewpaymentaccountstatement.html');
	
	exit;
	}
	elseif(base64_decode($_GET['status'])=="logout")
	   {
			$sess_id = $_SESSION['session_id'];
			$logouttime = date("y/m/d H:i:s", UKdst_datetime());
			$logoutSQL = "update user_logins set logouttime='$logouttime' where sessid='$sess_id'";
			$Result1 = mysql_query($logoutSQL) or die(mysql_error()); 
				$_SESSION['session_id']="";
				$_SESSION['MM_Username1']="";
				$_SESSION['MM_UserAuthorization1']="";
			
	 //  echo "<b><font color=red><p align=center>You have successfully logged out of the system</p></font>";
	   include('login.html');
	   exit;
	   }
  elseif(base64_decode($_GET['status'])=="loginsuccess")
	   {
			   if(ispayingagent($userid)=='Y')
			  {
				    $is_moneytransfer=true;
					$pagetitle = "List of Money Transfer Sales";
					include('collectionsales.html');
			exit;
			  }
			  else
			   {
		     $is_home=true;
			 $pagetitle = "Home";
			include('home.html');
			exit;
			   }
		}
		elseif(base64_decode($_GET['status'])=="loginfailure")
	   {
		echo "<b><font color=white><p align=center>Login Failed.Please try Again</p></font>";
		include('login.html');
		exit;
	   }
	   elseif(base64_decode($_GET['status'])=="sessionexpired")
	   {
		echo "<b><font color=white><p align=center>Session Expired.Please Login again</p></font>";
		include('login.html');
		exit;
	   }
		elseif(base64_decode($_GET['status'])=="You are not authorized to login this day of the week")
	   {
		echo "<b><font color=white><p align=center>You are not authorized to login this day of the week</p></font>";
		include('login.html');
		exit;
	   }
		elseif(base64_decode($_GET['status'])=="You are not authorized to login this time of the day")
	   {
		echo "<b><font color=white><p align=center>You are not authorized to login this time of the day</p></font>";
		include('login.html');
		exit;
	   }
	   elseif($_SESSION["session_id"]!='')
		{
			 if($agenttype=='collectionpoint')
				  {
				        $is_moneytransfer=true;
						$pagetitle = "List of Money Transfer Collections";
						include('collectionsales.html');
				exit;
				  }
				  else
				   {
			  $is_home=true;
			  $pagetitle = "Home";
				include('home.html');
				exit;
				   }
		}
		elseif(base64_decode($_GET['status']) != "")
			   {
			echo "<b><font color=white><p align=center>".base64_encode($_GET['status'])."</p></font>";
		   // include('login.html');
			exit; 
	    }
		else
	    {
		include('login.html');
	    exit;
		   }
	    ?>
