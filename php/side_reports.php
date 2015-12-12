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
function getReports($database, $un){
	$sql_query = "SELECT report_name FROM REPORTS WHERE user_id=\"$un\"";
	echo $sql_query;
	// Generates the sql query to return number of items in user's inventory (minus the sold items).
	
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
		return $result;
	}
}


/*
 *  The following are the local variables to get the statistics about a user's inventory.  After the variables are given an initial value via
 *  their respective function, a check is done against the sum, depSum, and oldest to see if they are blank.  If so, they are given a default value.
 */


$result = getReports($database, $user);
$max = mysql_num_rows($result);

for($i=0; $i<$max; $i++){
	// Fetch the top row of the result of the query (ptr moves to next query which then becomes 'top')
	$row = mysql_fetch_row($result);

	// Sets all values from the row returned from the query to their corresponding variables.
	$name = $row[0];
	// Generates and echos the html code to display a single item.
	echo "<a href=\"javascript:clickReport($name)\"><li id=\"$name\">$name</li></a>";

}
//echo $max;

//Closes the connection to the database.
mysql_close($database);
?>
