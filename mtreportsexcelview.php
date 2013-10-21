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
           {  echo "- ".getofficename($_POST['searchagent']);
           } 
		   if($_POST['searchcustomer']!='')
           {
           $customername=getcontactname($_POST['searchcustomer']);
           echo "-".$customername;
           }
print(",\n");
   print("Office\tOrder Date\tTransaction NO\tCustomer Name\tAmount\tCommission\tTotal Amount\tCurrency\tExchange Rate\tBeneficiary Name\tBeneficiary Amount\tOrdered By\tStatus\n");
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
	$officename=$row['officename'];
	$orderby=$row['orderby'];
	$orderdate=$row['orderdate'];
	$orderid=$row['orderid'];
	$ordertime=$row['ordertime'];
	$agentcommissionamount=$row['agentcommission'];

	$customername=$row['customerfirstname']." ".$row['customersurname'];
	$beneficiaryname=$row['benfirstname'];
	
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
	
	$totalturnover=$totalturnover+$orderamount;
            print(($officename)."\t");
			 print(changeddate($orderdate)." ".$ordertime."\t");
			 print($orderid."\t");
			  print($customername."\t");
			   print($orderamount."\t");
			   print($agentcommissionamount."\t");
			   print(($orderamount+$agentcommissionamount)."\t");
			   print(($currency)."\t");
			   print($exchangerate."\t");
			   print($beneficiaryname."\t");
			   print(number_format($benamount,2)."\t");
			    print(($orderby)."\t");
			   print($orderstatus."\n");
 
 }
 ?>
