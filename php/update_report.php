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

function checkCorrectPassword($user,$oldpass,$database){
	$sql_query = "SELECT password FROM USER WHERE user_id='".$user."' AND password = '" .$oldpass."'";
	$result= mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	}
	return $result;
}

$result = checkCorrectPassword($user,$oldpass,$database);
if(mysql_num_rows($result) == 0){
	echo "<script type='text/javascript'>alert('Wrong password!');</script>";
	return "NO";
	/*$sql_query = 'INSERT INTO USER (user_id, name_first, name_last, password, phone_num) VALUES ("';
	$sql_query .= mysql_real_escape_string($user).'","'.mysql_real_escape_string($fname).'","'.mysql_real_escape_string($lname);
	$sql_query .= '","'.mysql_real_escape_string($pass).'","'.mysql_real_escape_string($phone).'")';
	if(!mysql_query($sql_query) && $admin==1){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
	}
	$sql_query2 = 'INSERT INTO INVENTORY (inv_name, number_items) VALUES ("' .  mysql_real_escape_string($user) . ' inventory","0")';
	if(!mysql_query($sql_query2) && $admin==1){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query2;
		echo "ERROR!";
	}
	$sql_query3 = 'SELECT inventory_id FROM INVENTORY WHERE inv_name = "' .  mysql_real_escape_string($user) . ' inventory"';

	
	if(!$result2 && $admin==1){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
	}else{
		$row = mysql_fetch_row($result2);
		$inv_id = $row[0];
		$sql_query4 = 'INSERT INTO HASACCESSTO (user_id, inventory_id) VALUES ("' .  mysql_real_escape_string($user) . '","' .  $inv_id .'")';
		//echo $sql_query4;
		if(!mysql_query($sql_query4)){
			echo mysql_errno($database) . ": " . mysql_error($database). "\n";
			echo $sql_query;
			echo "ERROR!";
		}
	}
	*/

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
