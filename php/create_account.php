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
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$phone = $_POST["phone"];

function checkUserExists($user,$database){
	$sql_query = "SELECT * FROM USER WHERE user_id=".$user;
	return mysql_query($sql_query,$database);
}

$result = checkUserExists($user,$database);
if(mysql_num_rows($result) == 0){
	$sql_query = 'INSERT INTO USER (user_id, name_first, name_last, password, phone_num) VALUES ("';
	$sql_query .= mysql_real_escape_string($user).'","'.mysql_real_escape_string($fname).'","'.mysql_real_escape_string($lname);
	$sql_query .= '","'.mysql_real_escape_string($pass).'","'.mysql_real_escape_string($phone).'")';
	if(!mysql_query($sql_query)){
		echo "ERROR!";
	}
	return "YES";

}else{
	return "NO";
}
mysql_close($database);
?>
