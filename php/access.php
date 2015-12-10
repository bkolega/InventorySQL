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

$user = $_POST["un"];

//Returns inventory id given user id from Query
function getInvId($user,$database)
{
  $sqlQuery = 'SELECT * FROM HASACCESSTO WHERE user_id="'.$user.'"';
  return mysql_query($sqlQuery);
}

$result = getInvId($user,$database);

//Returns inventory id to JavaScript
while($row = mysql_fetch_array($result))
{
  echo $row['inventory_id'];
}

mysql_close($database);
?>
