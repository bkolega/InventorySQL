<?php
/*
 *	Author: Tyler Steiner
 *	For: WISQL Project; EECS 647
 *	Date: 12/11/2015
 *	File: view.php
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

/*
 *  The following function generates the sql query and runs it against the database
 *  to get the total number of items in the entire database.  It does this by doing a
 *  SELECT * on a view that returns the count of the total rows in the ITEMS table.  The
 *  function returns the result of the query.
 */
function getNumItems($database){
	$sql_query = 'SELECT * FROM TOTAL_ITEMS';
	return mysql_query($sql_query,$database);
}

// Gets and stores the result from the getNumItems function.
$res = getNumItems($database);

//  echo's code with the result of the query so long as the query executed successfully
while($row=mysql_fetch_assoc($res)){
	echo '		';
	echo 'Keeping Track of (' . $row["COUNT(*)"] . ') items';
}

//Closes the connection to the database.
mysql_close($database);
?>
