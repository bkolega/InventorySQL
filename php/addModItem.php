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

$method = $_POST['method'];
$invId = $_POST['invId'];
$item = $_POST['item'];
$model = $_POST['model'];
$serial = $_POST['serial'];
$cat = $_POST['cat'];
$man = $_POST['man'];
$pdate = $_POST['pdate'];
$value = $_POST['value'];
$notes = $_POST['notes'];

mysql_close($database);

function addNewItem($invId,$serial,$item,$model,$cat,$man,$pdate,$value,$notes,$database)
{
  $sql_query = "INSERT INTO ITEM(inventory_id,serial_number, item_name,value, model,manufactuer,category,item_purchase_date,notes,is_sold)".$invId.",".$serial.",".$item.",".$value.",".$model.",".$man.",".$cat.",".$pdate.",".notes.",0";
  mysql_query($sql_query);
}

function findItem($serial,$invId,$database)
{
  $sql_query = "SELECT * FROM ITEM WHERE inventory_id=".$invId." AND serial_number=".$serial;
  return mysql_query($sql_query,$database);
}

function updateItem($invId,$serial,$item,$model,$cat,$man,$pdate,$value,$notes,$database)
{
  $sql_query = "UPDATE ITEM SET item_name=".$item.",value=".$value.",model=".$model.",manufacturer=".$man.",category=".$cat.",item_purhcase_date=".$pdate.",notes=".$notes." WHERE inventory_id=".$invId." AND serial_number=".$serial;
  mysql_query($sql_query);
}

if($method == "addItem")
{
  addNewItem($invId,$serial,$item,$model,$cat,$man,$pdate,$value,$notes,$database);
}
else if($method == "findItem")
{
  $result = findItem($serial,$invId,$database);
  while($row = mysql_fetch_array($result))
  {
    echo '{"item":{';
    echo '"itemName":"'.$row['item_name'].'",';
    echo '"value":"'.$row['value'].'",';
    echo '"model":"'.$row['model'].'",';
    echo '"man":"'.$row['manufacturer'].'",';
    echo '"cat":"'.$row['category'].'",';
    echo '"pdate":"'.$row['item_purchase_date'].'",';
    echo '"notes":"'.$row['notes'].'"';
    echo '}}';
  }
}
else if($method == "modItem");
{
  updateItem($invId,$serial,$item,$model,$cat,$man,$pdate,$value,$notes,$database);
}

mysql_close($database);
?>
