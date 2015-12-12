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
$column1 = $_POST["col1"];
$column2 = $_POST["col2"];
$column3 = $_POST["col3"];
$condition1 = $_POST["cond1"];
$condition2 = $_POST["cond2"];
$conditionval = $_POST["cond3"];
$fname = $_POST["fname"];

function getQuery($user,$column1,$column2,$column3,$condition1,$condition2,$conditionval,$fname,$database){
	$sql_query= "SELECT it." .$column1. ", it." .$column2. ", it." .$column3. " FROM INVENTORY AS inv, ITEM AS it WHERE inv.inv_name = '" .$user. " inventory' AND it.inventory_id = inv.inventory_id";
	/*if($condition1 != "none" && $condition2 == "equals")
	{
		$sql_query .= " AND " .$condition1. "='".$conditionval."'";
	} else if($condition1 != "none" && $condition2 == "dne")
	{
		$sql_query .= " AND " .$condition1. "!='".$conditionval."'";
	}*/

	$save_query='INSERT INTO REPORTS (user_id,query,report_name) VALUES ("'.$user.'","'.$sql_query.'","'.$fname.'")';
	$result= mysql_query($sql_query,$database);
	if(mysql_num_rows($result) != 0 || $result)
	{
		$secondresult = mysql_query($save_query,$database);
	}
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	}
	return $result;
}

$result = getQuery($user,$column1,$column2,$column3,$condition1,$condition2,$conditionval,$fname,$database);
echo "<table>";
while ($row = mysql_fetch_array($result)) {
    echo '<tr>';
    foreach($row as $field) {
        echo '<td>' . htmlspecialchars($field) . '</td>';
    }
    echo '</tr>';
}

echo "</table>"; //Close the table in HTML

mysql_close(); //Make sure to close out the database connection

/*if(mysql_num_rows($result) == 0){
	//echo "<script type='text/javascript'>alert('Wrong password!');</script>";
	return "NO";

}else{
	echo 'Yes';
	return "YES";
}*/
mysql_close($database);
?>
