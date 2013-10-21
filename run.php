<?php
session_start();
if($_GET['download']==1 && strlen($filename))
{
header("Content-type: application/x-download\n");
header("Content-Disposition: attachment; filename=\"".$filename."\"\n");
header("Content-transfer-encoding: binary\n");
header("Content-length: " . filesize("backups/".$filename) . "\n");
$file = file_get_contents ("backups/".$filename); 
echo $file;
exit();
}
$backup_file_name = 'mt_database_backup_'.date('dmYhis').'.sql';
include("inc_header1.php");
function checkSession($sessid,$username)
{
 $sql    = "select count(*) as count from user_master a,user_logins c where a.userid=c.userid and a.username='$username' and c.sessid='$sessid'"; // folders of the user
//echo $sql;
    $Result = safe_query($sql) ;
    while ($row      = mysql_fetch_array( $Result))
 {
       $count = (isset($row['count'])) ? $row['count'] : "";
		
 }

 if($count==1)
	{
	 return true;
	}
	else
	{
		return false;
	}
}
function has_data($value)
{
 if (is_array($value)) return (sizeof($value) > 0)? true : false;
 else return (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) ? true : false;
}
function backupdatabase()
{
   $t_query = mysql_query('show tables');
  $i=0;
  $table="";
  while ($tables = mysql_fetch_array($t_query, MYSQL_ASSOC) )
        {
	     list(,$table) = each($tables);
		 if($table != 'ml_addlist' && $table != 'ml_altlist' && $table != 'ml_sdnlist' && $table != 'user_logins')
			{
         $table_select[$i]=$table;
         $i++;
			}
        }
$thedomain = $_SERVER['HTTP_HOST'];
if (substr($thedomain,0,4)=="www.") $thedomain=substr($thedomain,4,strlen($thedomain));

$buffer = '# Database: '. $db . "\r\n" .
          '# Domain name: ' . $thedomain . "\r\n" .
          '# (c)' . date('Y') . ' ' . $thedomain . "\r\n" .
          '#' . "\r\n" .
          '# Backup Date: ' . strftime("%d %b %Y",time()) . "\r\n\r\n";
$i=0;
foreach ($table_select as $table)
        {
          $i++;
          $export = "\r\n" .'drop table if exists ' . $table . ';' . "\r\n\r\n" .
                    'create table ' . $table . ' (' . "\r\n";
          $table_list = array();
          $fields_query = mysql_query("show fields from " . $table);
          while ($fields = mysql_fetch_array($fields_query)) {
            $table_list[] = $fields['Field'];
            $export .= '  ' . $fields['Field'] . ' ' . $fields['Type'];
            if (strlen($fields['Default']) > 0) $export .= ' default \'' . $fields['Default'] . '\'';
            if ($fields['Null'] != 'YES') $export .= ' not null';
            if (isset($fields['Extra'])) $export .= ' ' . $fields['Extra'];
            $export .= ',' . "\r\n";
          }
          $export = ereg_replace(",\r\n$", '', $export);
          // add the keys
          $index = array();
          $keys_query = mysql_query("show keys from " . $table);
          while ($keys = mysql_fetch_array($keys_query)) {
            $kname = $keys['Key_name'];
            if (!isset($index[$kname])) {
              $index[$kname] = array('unique' => !$keys['Non_unique'],
                                     'columns' => array());
            }
            $index[$kname]['columns'][] = $keys['Column_name'];
          }
          while (list($kname, $info) = each($index)) {
            $export .= ',' . "\r\n";
            $columns = implode($info['columns'], ', ');
            if ($kname == 'PRIMARY') {
              $export .= '  PRIMARY KEY (' . $columns . ')';
            } elseif ($info['unique']) {
              $export .= '  UNIQUE ' . $kname . ' (' . $columns . ')';
            } else {
              $export .= '  KEY ' . $kname . ' (' . $columns . ')';
            }
          }
          $export .= "\r\n" . ');' . "\r\n\r\n";
          $buffer.=$export;
         
		  
		  // dump the data
          $query="select * from " . $table;
          $rows_query = mysql_query($query);
          while ($rows = mysql_fetch_array($rows_query)) {
            $export = 'insert into ' . $table . ' (' . implode(', ', $table_list) . ') values (';
            reset($table_list);
            while (list(,$i) = each($table_list)) {
              if (!isset($rows[$i])) {
                $export .= 'NULL, ';
              } elseif (has_data($rows[$i])) {
                $row = addslashes($rows[$i]);
                $row = ereg_replace("\r\n#", "\r\n".'\#', $row);

                $export .= '\'' . $row . '\', ';
              } else {
                $export .= '\'\', ';
              }
            }
            $export = ereg_replace(', $', '', $export) . ');' . "\r\n";
            $buffer.= $export;
          }
        }
return $buffer;
}

function write_backup($gzdata, $backup_file_name)
{
 $fp = fopen("backups/".$backup_file_name, "w");
 fwrite($fp, $gzdata);
 fclose($fp);
 //check folder is protected - stop HTTP access
 if (!file_exists(".htaccess"))
 {
  $fp = fopen("backups/.htaccess", "w");
  fwrite($fp, "deny from all");
  fclose($fp);
 }
}
if(!checkSession($HTTP_SESSION_VARS["session_id"],$HTTP_SESSION_VARS["MM_Username1"]))
{
	die("You are not authorised to view this page");
}
else
{
$backupcommand = "mysqldump --host=".$server." --opt ".$database." -u ".$user." --password=".$password."  > backups/".$backup_file_name;
system($backupcommand); 
//$data = backupdatabase();
//write_backup($data, $backup_file_name);
//echo $data;
echo "<html><head><LINK href=\"style.css\" rel=stylesheet type=text/css></head><body>Data back up completed successfully";
echo "<br>Click <a href=\"run.php?download=1&filename=$backup_file_name\">here</a> to download the file</a></body></html>";
}
?>
