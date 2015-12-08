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

$user = $_POST["user"];
$pass = $_POST["pass"];

function validateLogin($user,$pass,$database)
{
  $sql_query = "SELECT * FROM USER WHERE user_id = ".$user." AND password = ".$pass;
  return ($sql_query,$database);
}

$result = validateLogin($user,$pass,$database);
if(mysql_num_rows($result) == 0)
{
  return "NO";
}
else
{
  return "YES";
}
mysql_close($database);
?>
