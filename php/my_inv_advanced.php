<?php
/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: my_inv_advanced.php
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
$name = $_POST["name"];
$price = $_POST["price"];
$cat = $_POST["cat"];

/*
 *  The following function generates the SELECT query from the supplied variables and runs it against the datbase.  It returns
 *  the results of that query to the calling function.
 */
function Query($database, $un, $name, $price, $cat){
	/*
	 *  Generates the SELECT query for the items in the user's inventory. The following line is the base query followed by 3 if statements
	 *  that add to the query if conditions where sent.  If no conditions were sent, the query will return the same result as the my_inv
	 *  pageLoadQuery function.
	 */
	$sql_query = "SELECT * FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\") AND is_sold=0";
	if(!($name == "")){
		$sql_query .= " AND item_name=\"$name\"";		
	}
	if(!($price == "")){
		$sql_query .= " AND value=\"$price\"";		
	}
	if(!($cat == "")){
		$sql_query .= " AND category=\"$cat\"";		
	}
	$sql_query .=" LIMIT 0, 20";
	
	// Runs the generated query against the database.  If the query fails to run, an ERROR will be returned, otherwise the result of the
	// query will be returned.
	$result = mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
		echo "ERROR!";
		return 0;
	}else{
		return $result;
	}
}

// The following is the result of the query run agains the database.
$result = Query($database, $user, $name, $price, $cat);

// $max is the maximum number of times the for-loop below will run.
$max = mysql_num_rows($result);

// Echo's a spacer div for the html
echo '<div style="height: 8px; width: 100%"></div>';

/*
 *  The following for-loop generates the html code to display the item(s) in the user's inventory according
 *  to the results returned from the search query.  It runs from 0 to 20 times depending on how many items are in the inventory.
 *  The Query function will return a max of 20 items so the for-loop will write no more than 20 items onto the page.
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

// closes the connection to the database.
mysql_close($database);
?>
