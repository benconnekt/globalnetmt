<?php
 header("Content-Type: application/vnd.ms-excel");
   header("Content-type: application/octet-stream");
   header("Content-Disposition: attachment; filename=MONEYTRANSFER_EXPORT.xls");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
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
  $report1sql = "select * from report_master where reportid='$reportid' ";
 $report1Result         = safe_query($report1sql) ;
 while ($sub1row = mysql_fetch_array( $report1Result))
  {
	 $is_empty_allowed = $sub1row['is_empty_allowed'];
	 $print_headers = $sub1row['export_headers'];
	 $apply_id_document_rule  = (isset($sub1row['apply_id_document_rule'])) ? $sub1row['apply_id_document_rule'] : "";
      
	 
  }
   print("<table border=1 cellpadding=0 cellspacing=0>");
  $reportsql = "select fieldname,displayname,is_dummy from report_fields,report_field_group where reportid='$reportid'  and report_fields.fieldid=report_field_group.fieldid order by report_field_group.position ASC";
 $reportResult         = safe_query($reportsql) ;
 $reportrowcount = mysql_num_rows($reportResult);
	if($reportrowcount>0)
  {
   $reportcolumns = $reportcolumns."<tr>";
 while ($subrow = mysql_fetch_array( $reportResult))
  {
	  if(strlen($subrow['fieldname']))
	  {
	  $reportsubquery = $reportsubquery.$subrow['fieldname'].",";
	  }
	 $reportcolumns = $reportcolumns."<td class=TableHeader>".strtoupper($subrow['displayname'])."</td>";
	 
  }
  $reportcolumns = $reportcolumns."</tr>";
  if($print_headers=='Y')
	  {
print($reportcolumns); 
	  }

  $i=0;
  $no=0;
  $totalprofit=0;
   $Result         = safe_query($sql) ;
     $bankResult         = safe_query($banksql) ;
  $noOfRecords    = @mysql_num_rows($Result); // Total no of records returned
   while ($row = mysql_fetch_array( $Result))
  {

	 $saleid=$row['saleid'];
	$adminstatus=$row['adminstatus'];

	if($exportonlyuploaded == "true")
	  {
		if($adminstatus == "Uploaded")
		  {
			continue;
		  }
	  }
	  $reportrows="<tr>";
   for($j=0;$j<$reportrowcount;$j++)
	  {
		if(strlen($row[$j]))
		  {
			$value = $row[$j];
		  }
		  else
		  {
			  if($is_empty_allowed =='Y')
			  {
			  $value = "NONE";
			  }
			  else
			  {
				  $value = "";
			  }
		  }
		   if($apply_id_document_rule == 'Y')
						 {
				      if(substr($value,0,5) == 'No ID' || substr($value,0,6) == 'Others' || substr($value,0,15) == 'Driving Licence' || substr($value,0,8) == 'Passport' || substr($value,0,9) == 'School ID' || substr($value,0,7) == 'Work ID' || substr($value,0,11) == 'National ID' || substr($value,0,6) == 'Any ID' || substr($value,0,8) == 'Bank  ID')
							 {
						         if(substr($value,0,5) == 'No ID' || substr($value,0,7) == 'Others ')
									 {
									 $value = "NO ID";
									 }
									 else
									 {
									 $value = "ANY ID";
									 }
							 }
						 }
	   $reportrows = $reportrows."<td class=Row>".$value."</td>";
	  }
	  $reportrows = $reportrows."</tr>";
	 print($reportrows);
	 
  }
 
  }
   print("</table>");
?> 


