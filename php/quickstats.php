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
// echo $user . '<br />';
// $user = "tuser";

function getNumItems($database, $un){
	$sql_query = "SELECT COUNT(*) as c FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
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

function getSumValue($database, $un){
	$sql_query = "SELECT SUM(value) AS s FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
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

function getDepSumValue($database, $un){
	$sql_query = "SELECT SUM(depreciated_value) AS s FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
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

function getOldest($database, $un){
	$sql_query = "SELECT ITEM.item_purchase_date AS oldest FROM ITEM, ITEM AS I WHERE ITEM.item_purchase_date >= I.item_purchase_date GROUP BY ITEM.item_purchase_date ";
	$sql_query .= "AND ITEM.inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\")";
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


$numItems = getNumItems($database, $user);
$sum = getSumValue($database, $user);
$depSum = getDepSumValue($database, $user);
$oldest = getOldest($database, $user);

echo '<h4>&nbsp Quick Statistics</h4>';
echo '<p>&nbsp Total Number items: ' . $numItems . '<br/>';
echo '&nbsp Total Value: $' . $sum . '<br/>';
echo '&nbsp Total Deprecated Value: $' . $depSum . '<br/>';
echo '&nbsp Oldest Item Purchased: ' . $oldest . '<br/>';

?>
