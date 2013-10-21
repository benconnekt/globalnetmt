<?php
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=MONEYTRANSFER_REPORT.xls");
 include('inc_header1.php');
 
if(isset($_POST['query'])!="")
   {
   $sql=$_POST['query'];
   }
   else
   {
   $sql="";
   }
 $sql = str_replace("\'", "'", $sql);
 echo $title. "-";
            echo "".($_POST['displaymonth']); 
			if($_POST['searchagent']!='')
           {  echo "- ".getpayingagentname($_POST['searchagent']);
           } 
		   if($_POST['searchcustomer']!='')
           {
           $customername=getcontactname($_POST['searchcustomer']);
           echo "-".$customername;
           }
print(",\n");
   print("Id No\tBeneficiary Name\tAccount\tBank\tBranch\tAmount IK\tRemitter\tAuth Code\n");
  $i=0;
  $no=0;
  $totalprofit=0;
   $Result         = safe_query($sql) ;
     $bankResult         = safe_query($banksql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
   $noOfbankRecords    = @mysql_num_rows($bankResult); // Total no of records returned
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
	$officename=$row['officename'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$orderid=$row['orderid'];
	$idno=$row['idno'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname']." ".$row['bensurname'];
    $agentcommissionamount=$row['agentcommission'];
	$bankname=$row['bankname'];
	$benamount=$row['benamount'];
	$branchname=$row['branchname'];
	$accountno=$row['accountno'];
	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname'];
	$beneficiaryidno=$row['beneficiaryidno'];
	
if($orderamount>0)
	  {
	$totalturnover=$totalturnover+$orderamount;
	  }
	  if($agentcommissionamount>0)
	  {
	$totalturnovercomm=$totalturnovercomm+$agentcommissionamount;
	  }
	  if($benamount>0)
	  {
	$totalbenturnover=$totalbenturnover+$benamount;
	  }

            print($idno."\t");
			print($beneficiaryname."\t");
			print($accountno."\t");			
			print($bankname."\t");
			print($branchname."\t");
			print(number_format($benamount,2)."\t");
			print($customername."\t");
			print($beneficiaryidno."\n");
 
 }

 
 ?>
