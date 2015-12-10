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

// $user = "tuser";
$user = $_POST["user"];
$name = $_POST["name"];
// echo "\"$name\"" . '<br />';

$database = @mysql_connect('mysql.eecs.ku.edu',$username,$password);
if(!$database){
  die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db($username,$database)){
  die('Could not select database: ' . mysql_error());
}

function Query($database, $un, $name){
	$sql_query = "SELECT * FROM ITEM WHERE inventory_id IN (SELECT inventory_id FROM HASACCESSTO WHERE user_id=\"$un\") AND is_sold=0";
	if(!($name == "")){
		$sql_query .= " AND item_name=\"$name\"";		
	}
	
	$sql_query .=" LIMIT 0, 20";
	//echo $sql_query;
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

$result = Query($database, $user, $name);
$max = mysql_num_rows($result);

echo '<div style="height: 8px; width: 100%"></div>';
for($i=0; $i<$max; $i++){
	$row = mysql_fetch_row($result);
	$itemName = $row[2];
	$serialNumber = $row[1];
	$man = $row[6];
	$value = $row[3];
	$model = $row[5];
	$cat = $row[7];
	$pDate = $row[8];
	$depValue = $row[4];
	$notes = $row[9];

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


mysql_close($database);
?>
