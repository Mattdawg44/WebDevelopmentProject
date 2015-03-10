<?php 
  $db_hostname = 'localhost';
  $db_database = "mtsg3c";
  $db_username = "mtsg3c";
  $db_password = "7U3mn1aLo4";
  
  $db_server = mysql_connect($db_hostname, $db_username,$db_password);
mysql_select_db($db_database) or die("Unable to select db: " . mysql_errno());

if (!$db_server)
    die("Unable to connect to MySQL: " . mysql_error());

?>
