<?php
/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: quickstats.php
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

/*
 *  The following function generates the query and queries the database for the number of items that are in the user's inventory.
 *  It returns the number of items to the calling function.
 */
function getNumItems($database, $un){
	// Generates the sql query to return number of items in user's inventory (minus the sold items).
	$sql_query = "SELECT COUNT(*) as c FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
	$sql_query .= " AND is_sold=0";
	
	// Runs the generated query against the database.  If the query fails to run, an ERROR will be returned, otherwise the number of items
	// will be returned.
	$result = mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
}

/*
 *  The following function generates the query and queries the database for the total sum value of the items that are in the user's inventory.
 *  It returns the sum to the calling function.
 */
function getSumValue($database, $un){
	// Generates the query to get the total sum of all items in user's inventory (minus the sold items).
	$sql_query = "SELECT SUM(value) AS s FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
	$sql_query .= " AND is_sold=0";
	
	// Runs the generated query against the database.  If the query fails to run, an ERROR will be returned, otherwise the sum of the values
	// will be returned.
	$result = mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
}

/*
 *  The following function generates the query and queries the database for the total depreciated value sum of all items that are in the user's inventory.
 *  It returns the sum to the calling function.
 */
function getDepSumValue($database, $un){
	// Generates the query to get the total depreciated sum of all items in the user's inventory (minus the sold items).
	$sql_query = "SELECT SUM(depreciated_value) AS s FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
	$sql_query .= " AND is_sold=0";
	
	// Runs the generated query against the database.  If the query fails to run, an ERROR will be returned, otherwise the sum of the depreciated 
	// values will be returned.
	$result = mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
}

/*
 *  The following function generates the query and queries the database for the purchase date of the oldest item that is in the user's inventory.
 *  It returns the date to the calling function.
 */
function getOldest($database, $un){
	// Generates the query to get the date of the oldest purchased item still in the user's inventory (not sold);
	$sql_query = "SELECT ITEM.item_purchase_date AS oldest FROM ITEM, ITEM AS I WHERE ITEM.item_purchase_date <= I.item_purchase_date AND ITEM.inventory_id IN ";
	$sql_query .= "(SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\") AND ITEM.is_SOLD=0 ORDER BY ITEM.item_purchase_date ASC LIMIT 1";
	
	// Runs the generated query against the database.  If the query fails to run, an ERROR will be returned, otherwise the date of the oldest item in the user's 
	// inventory will be returned.
	$result = mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		$row = mysql_fetch_row($result);
		return $row[0];
	}
}

/*
 *  The following are the local variables to get the statistics about a user's inventory.  After the variables are given an initial value via
 *  their respective function, a check is done against the sum, depSum, and oldest to see if they are blank.  If so, they are given a default value.
 */
$numItems = getNumItems($database, $user);
$sum = getSumValue($database, $user);
$depSum = getDepSumValue($database, $user);
$oldest = getOldest($database, $user);
if($sum == ""){
	$sum = 0.00;	
}
if($depSum == ""){
	$depSum = 0.00;	
}
if($oldest == ""){
	$oldest = '<br /> &nbsp No Items in Inventory';	
}

/*
 *  The following echo's the html code to add the statistics to the user's My Inventory page.
 */
echo '<h4>&nbsp Quick Statistics</h4>';
echo '<p>&nbsp Total Number items: ' . $numItems . '<br/>';
echo '&nbsp Total Value: $' . $sum . '<br/>';
echo '&nbsp Total Deprecated Value: $' . $depSum . '<br/>';
echo '&nbsp Oldest Item Purchased: <br /> &nbsp ' . $oldest . '<br/>';

//Closes the connection to the database.
mysql_close($database);
?>
