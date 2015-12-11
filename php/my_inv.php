<?php
/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: my_inv.php
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
$user = "tuser";
$user = $_POST["user"];

/*
 *  The following function returns the results of a SQL query that, given a user_id, returns a SELECT * with a max
 *  of 20 items that are in the user's inventory.
 */
function pageLoadQuery($database, $un){
	// Generates the select query for the database.
	$sql_query = "SELECT * FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\") AND is_sold=0";
	$sql_query .=" LIMIT 0, 20";
	
	// Runs the query against the database.
	$result = mysql_query($sql_query,$database);
	
	// If the query failed to run, return an error.  Else, return the result to the calling function.
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		return $result;
	}
}

// Get the result from the pageLoadQuery function.
$result = pageLoadQuery($database, $user);
// Sets the max number of iterations for the for-loop.
$max = mysql_num_rows($result);

/*
 *  The following for-loop generates the html code to display the item(s) in the user's inventory.
 *  It runs from 0 to 20 times depending on how many items are in the inventory.  The pageLoadQuery will
 *  return a max of 20 items so the for-loop will write no more than 20 items onto the page.
 */
for($i=0; $i<$max; $i++){
	// Fetch the top row of the result of the query (ptr moves to next query which then becomes 'top')
	$row = mysql_fetch_row($result);

	// Sets all values from the row returned from the query to their corresponding variables.
	$itemName = $row[2];
	$serialNumber = $row[1];
	$man = $row[6];
	$value = $row[3];
	$model = $row[5];
	$cat = $row[7];
	$pDate = $row[8];
	$depValue = $row[4];
	$notes = $row[9];

	// Generates and echos the html code to display a single item.
	echo '<div class="my_inv_container">';
	echo '	<div class="my_inv_left">';
	echo '		<div class="my_inv_item">';
	echo '			&nbsp Item: '.$itemName . '<br />';
	echo '			&nbsp Serial Number: '.$serialNumber . '<br />';
	echo '			&nbsp Manufacturer: '.$man . '<br />';
	echo '			&nbsp Value: $'.$value . '<br />';
	echo '		</div>';
	echo '	</div>';
	echo '	<div class="my_inv_right">';
	echo '		<div class="my_inv_item">';
	echo '			&nbsp Model: '.$model . '<br />';
	echo '			&nbsp Category: '.$cat . '<br />';
	echo '			&nbsp Purchase Date: '.$pDate . '<br />';
	echo '			&nbsp Depreciated Value: $'.$depValue . '<br />';
	echo '		</div>';
	echo '	</div>';
	echo '	<div class="my_inv_center">';
	echo '		<div class="my_inv_item">';
	echo '			&nbsp Notes: '.$notes;
	echo '		</div>';
	echo '	</div>';
	echo '</div>';
	echo '<div style="height: 2px; width: 100%"></div>';
}

// Closes the connection to the database.
mysql_close($database);
?>
