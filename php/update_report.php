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
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$phone = $_POST["phone"];
$oldpass = $_POST["oldpw"];
$newpass1 = $_POST["newpass1"];

function checkValid($user,$oldpass,$database){
	$sql_query = "SELECT password FROM USER WHERE user_id='".$user."' AND password = '" .$oldpass."'";
	$result= mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	}
	return $result;
}

function createQuery($

$result = checkCorrectPassword($user,$oldpass,$database);
if(mysql_num_rows($result) == 0){
	echo "<script type='text/javascript'>alert('Wrong password!');</script>";
	return "NO";

}else{
	$sql_query = 'UPDATE USER SET name_first="'.$fname.'", name_last="'.$lname.'", password="'.$newpass1.'", phone_num="'.$phone.'" WHERE user_id="' .$user. '"';
	if(!mysql_query($sql_query))
	{
		
	}
	echo 'Yes';
	return "YES";
}
mysql_close($database);
?>
