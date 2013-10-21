<?  session_start();
   include('inc_header.php');
 if($_GET['ent_num']!='')
  {
 $ent_num= $_GET['ent_num'];
  }
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style.css" type=text/css rel=stylesheet>
<LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
<title>SDN Details</title>
<style type="text/css">
<!--

.style3 {
        font-family: verdana, arial, helvetica, sans-serif;
        font-size: 11px;
}
.style5 {font-family: verdana, arial, helvetica, sans-serif}
.style23 {font-family: verdana, arial, helvetica, sans-serif; font-size: 11px; font-weight: bold; }
.style_2 {font-family: verdana, arial, helvetica, sans-serif; font-size: 9px; }
.style_3 {font-size: 1px}
-->

</style>
<form name="contactform" action="index.php" method="post">
<input type=hidden name=displayPageNo value="<?php echo $displayPageNo?>">
<input Type="hidden" name="dataOrder" value="<?php echo $dataOrder?>">
<input Type="hidden" name="pageAction" value="">
<input Type="hidden" name="txtsearch" value="<?php echo $txtsearch?>">
<input Type="hidden" name="option" value="<?php echo $option?>">
<input type=hidden name=status value="<?php echo base64_encode('viewsdn')?>">
 <?php
 $surname = $_GET['surname'];
 $firstname = $_GET['firstname'];
// echo "the firstname is ".$firstname;
// echo "the surname is ".$surname;
 if(strlen($firstname) || strlen($surname))
 {
	$sql            ="select a.sdn_name,a.sdn_type,a.program,a.title,b.address,b.city,b.country,c.alt_type,c.alt_name from ml_sdnlist a left join ml_addlist b on a.ent_num = b.ent_num left join ml_altlist c on b.ent_num=c.ent_num where lower(SDN_Name) like '%$firstname $surname%'";
 }
 else
 {
	 $sql            = "select a.sdn_name,a.sdn_type,a.program,a.title,b.address,b.city,b.country,c.alt_type,c.alt_name from ml_sdnlist a left join ml_addlist b on a.ent_num = b.ent_num left join ml_altlist c on b.ent_num=c.ent_num where a.ent_num = '$ent_num'";

 }

//echo $sql;
$Result         = safe_query($sql) ;
 ?>

   <table border="0" cellpadding="3" cellspacing="1" class="tableBorder" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
 
  <?php

  $i=0;
  $no=0;
  while ($row = mysql_fetch_array( $Result))
  {
  
  $sdn_name      = (isset($row['sdn_name'])) ? $row['sdn_name'] : "";
  $ent_num      = (isset($row['ent_num'])) ? $row['ent_num'] : "";
   $sdn_type      = (isset($row['sdn_type'])) ? $row['sdn_type'] : "";
  $program      = (isset($row['program'])) ? $row['program'] : "";
  $title        = (isset($row['title'])) ? $row['title'] : "";
  $address        = (isset($row['address'])) ? $row['address'] : "";
  $city  = (isset($row['city'])) ? $row['city'] : "";
   $country  = (isset($row['country'])) ? $row['country'] :"";
    $alt_type  = (isset($row['alt_type'])) ? $row['alt_type'] :"";
	 $alt_name  = (isset($row['alt_name'])) ? $row['alt_name'] :"";
	 	

  ?>
			          
 <tr>
  <td width="10%" class="TableHeader"><b><font color=white>Name</b></td>
 <td width="10%" class="<?php echo $bgcolor?>"><? echo stripslashes($sdn_name)?></a></td>
 </tr><tr>
 <td width="10%" class="TableHeader"><b><font color=white>Type</a></b></td>

<td width="10%" class="<?php echo $bgcolor?>"><? echo stripslashes($sdn_type)?></td>
</tr><tr>
 <td width="10%" class="TableHeader"><b><font color=white>Program</a></b></td>
				
<td width="10%" class="<?php echo $bgcolor?>"><? echo stripslashes($program)?></td>
</tr><tr>
<td width="10%" class="TableHeader"><b><font color=white>Title</a></b></td>
                
<td width="10%" class="<?php echo $bgcolor?>" ><? echo stripslashes($title)?></td>
</tr>
<? if(!strlen($firstname) && !strlen($surname))
 {?>
<tr>
 <td width="10%" class="TableHeader"><b><font color=white>Address</a></b></td>
				  
<td width="10%" class="<?php echo $bgcolor?>" ><? echo stripslashes($address)?></td>
</tr><tr>
 <td width="10%" class="TableHeader"><b><font color=white>City</a></b></td>
                    
<td width="10%" class="<?php echo $bgcolor?>"  ><? echo stripslashes($city)?></td>
</tr><tr>
<td width="10%" class="TableHeader"><b><font color=white>Country</a></b></td>
					   
<td width="10%" class="<?php echo $bgcolor?>"   ><? echo stripslashes($country)?></td>
</tr><tr>
<td width="10%" class="TableHeader"><b><font color=white>Alt Type</a></b></td>
						
<td width="10%" class="<?php echo $bgcolor?>"   ><? echo stripslashes($alt_type)?></td>
</tr><tr>
  <td width="10%" class="TableHeader"><b><font color=white>Alt Name</a></b></td>
						
<td width="10%" class="<?php echo $bgcolor?>"   ><? echo stripslashes($alt_name)?></td>

</tr>
<? } ?>
 <tr>
  <td width="100%" colspan=2 class="white"><hr>
  </td>
  </tr>
   <?
              }
        ?>
         

         </table>
         </form>

