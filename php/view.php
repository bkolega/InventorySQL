<?php
$username = 'tsteiner';
$password = 'EECS647';

$mRootpath = "";
$mFilepath = explode('/',dirname(_DIR_));
foreach($mFilepath as $f){
  $mRootpath = $mRootpath.$F."/";
  if($f == "public_html"){
	break;
  }
}
define('ROOT_PATH',$mRootpath);

error_reporting(E_ALL);
ini_set("display_errors",1);

$database = @mysql_connect('mysql.eecs.ku.edu',$username,$password);
if(!$database){
  die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db($username,$database)){
  die('Could not select database: ' . mysql_error());
}


function getNumItems($database){
	$sql_query = 'SELECT * FROM TOTAL_ITEMS';
	return mysql_query($sql_query,$database);
}

$res = getNumItems($database);
while($row=mysql_fetch_assoc($res)){
	echo 'Total Number of items in inventory: ' . $row["COUNT(*)"];
}

?>
