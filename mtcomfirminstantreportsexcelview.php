<?php
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=CONFIRM_MONEYTRANSFER_REPORT.xls");
 include('inc_header1.php');
 
if(isset($_POST['query'])!="")
   {
   $sql=$_POST['query'];
   }
   else
   {
   $sql="";
   }
   $selcollectionpoint = $_POST['selcollectionpoint'];
 $sql = str_replace("\'", "'", $sql);
  print("Invoice No\tBeneficiary Name and Address\tPin No\tIdentification\tBranch Name\tAmount (tk)\tRemitter\n");
  $i=0;
  $no=0;
  $totalprofit=0;
   $Result         = safe_query($sql) ;
  while ($row = mysql_fetch_array( $Result))
  {

   $i++;
    $no=$no+1;
  $bgcolor       = ($i % 2) ? "#FFFFFF" : "#EAEAEA";
   $fontcolor       = ($i % 2) ? "#EAEAEA" : "#EAEAEA";
   $currency=$row['currency'];
	$saleid=$row['saleid'];
	$benamount=$row['benamount'];
	$exchangerate=$row['exchangerate'];
	$orderamount=$row['orderamount'];
	$orderstatus=$row['orderstatus'];
	$officeid=$row['officeid'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$orderid=$row['orderid'];
	$bankname=$row['bankname'];
	$benamount=$row['benamount'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$idno=$row['idno'];
	$pinno=$row['pinno'];
	$identification=$row['identification'];
	$collectionofficeid=$row['collectionofficeid'];
	$agentcommissionamount=$row['agentcommission'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname'];
	
	if($orderstatus=='Confirmed' && $collectionofficeid==$selcollectionpoint)
	  {
	$totalturnover=$totalturnover+$benamount;
	           print($idno."\t");
			   print($beneficiaryname."\t");
			   print($pinno."\t");
			   print($identification."\t");
			   print(($branchname)."\t");
			   print(($benamount)."\t");
			   print($customername."\n");
 
 }
  }
 print("\t");
			   print("\t");
			   print("\t");
			   print("\t");
			   print("Totals\t");
			   print(($totalturnover)."\t");
			   print("\n");
 ?>
