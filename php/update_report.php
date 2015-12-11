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

$column1 = $_POST["col1"];
$column2 = $_POST["col2"];
$column3 = $_POST["col3"];
$condition1 = $_POST["cond1"];
$condition2 = $_POST["cond2"];
$fname = $_POST["fname"];

function getQuery($user,$column1,$column2,$column3,$condition1,$condition2,$fname,$database){
	$sql_query= "SELECT " .$column1. ", " .$column2. ", " .$column3. " FROM USERS, ITEM WHERE user_id = " .$user. "";
	//if($condition == "Equals")
	//	$stored_query +=
	$result= mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	} else {
		echo 'HELLO';
	}
	return $result;
}

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
