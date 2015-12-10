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

$sdate = $_POST["sdate"];
$ponum = $_POST["ponum"];
$items = $_POST["items"];
$sellId = $_POST["sellId"];
$invId = $_POST["invId"];
$sold = $_POST["sold"];

//Add sale record to sale table.
function executeSale($sdate,$ponum,$sellId,$database)
{
  $sql_query = "INSERT INTO SALE(purchase_order_num,date,user_id) VALUES (".$ponum.",\"".$sdate."\",".$sellId.")";
  mysql_query($sql_query);
}

//Call function to add record
executeSale($sdate,$ponum,$sellId,$database);

//Checks wheter item is an array or object (multiple serial numbers)
//If only one serial number doesn't need foreach to iterate through and can just make one call
if(is_array($items) || is_object($items))
{
  //Uses foreach to iterate through serial numbers given
  foreach($items as $item)
  {
    $sql_query = "UPDATE ITEM SET is_sold=".$sold." WHERE inventory_id=".$invId." AND serial_number=".$item;
    mysql_query($sql_query);
  }
}
else
{
  $sql_query = "UPDATE ITEM SET is_sold=".$sold." WHERE inventory_id=".$invId." AND serial_number=".$items;
  mysql_query($sql_query);
}

mysql_close($database);
?>
