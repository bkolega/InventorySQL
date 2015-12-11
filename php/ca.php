<?php
/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: ca.php
*/
/*
 * The following section supplies the username and password, for the database,
 * expands the directory, and makes the connection to the database.
 */
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

// The following are variables that are posted to this php script.
$user = $_POST["user"];
$pass = $_POST["pass"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$phone = $_POST["phone"];
$admin = $_POST["isAdmin"];

/*
 *  The following prints out the variables sent to the script if admin was sent as a 1.
 *  This is for debugging purposes only. It should not be used/available to the general user.
 */
if($admin==1){
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
}

/*
 *  The following function checks to see if the user_id already exists.  It builds a SQL query based off of the userID
 *  provided by the post from create_account.php.  It returns the the result of the query to the calling function.
 */
function checkUserExists($user,$database){
	$sql_query = "SELECT * FROM USER WHERE user_id='".$user."'";
	$result= mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	}
	return $result;
}

$result = checkUserExists($user,$database);

/*
 *  the following only runs if there is no user returned by checkUserExists.  It builds the strings/queries to insert
 *  the user into the USER table, creates an entry in the INVENTORY table, queries for the inventory_id of the inventory just
 *  created, and creates an entry in the HASACCESSTO table.  It returns "Yes" if all is succesful.
 */
if(mysql_num_rows($result) == 0){
	// Generates the insert into USER table
	$sql_query = 'INSERT INTO USER (user_id, name_first, name_last, password, phone_num) VALUES ("';
	$sql_query .= mysql_real_escape_string($user).'","'.mysql_real_escape_string($fname).'","'.mysql_real_escape_string($lname);
	$sql_query .= '","'.mysql_real_escape_string($pass).'","'.mysql_real_escape_string($phone).'")';
	// Runs the insert query against the database creating the user.  If unsuccessful, returns ERROR.
	if(!mysql_query($sql_query) && $admin==1){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
	}
	
	// Generates the INSERT query for the INVENTORY table.
	$sql_query2 = 'INSERT INTO INVENTORY (inv_name, number_items) VALUES ("' .  mysql_real_escape_string($user) . ' inventory","0")';
	// Runs the insert query against the database creating the inventory.  If unsuccessful, returns ERROR.
	if(!mysql_query($sql_query2) && $admin==1){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query2;
		echo "ERROR!";
	}
	
	// Generates the query to get the inventory_id of the inventory just created for the user.
	$sql_query3 = 'SELECT inventory_id FROM INVENTORY WHERE inv_name = "' .  mysql_real_escape_string($user) . ' inventory"';
	// Runs the query to get the inventory_id
	$result2 = mysql_query($sql_query3,$database);
	if(!$result2 && $admin==1){
		// If no result from the SELECT inventory_id query, returns ERROR
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
	}else{
		// Generates the query for inserting the userID to inventory_id mapping into the HASACCESSTO table
		$row = mysql_fetch_row($result2);
		$inv_id = $row[0];
		$sql_query4 = 'INSERT INTO HASACCESSTO (user_id, inventory_id) VALUES ("' .  mysql_real_escape_string($user) . '","' .  $inv_id .'")';
		// Runs the insert query into the HASACCESSTO table.
		if(!mysql_query($sql_query4)){
			echo mysql_errno($database) . ": " . mysql_error($database). "\n";
			echo $sql_query;
			echo "ERROR!";
		}
	}
	
	// Returns "Yes" if successfull in all operations.
	echo 'Yes';
	return "YES";

}else{
	// Returns "No" if operation user already exists.
	echo 'No';
	return "NO";
}
mysql_close($database);
?>
