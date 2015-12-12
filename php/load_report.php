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

$reportname = $_POST["rn"];

function getQuery($reportname,$database){
	//$find_query="SELECT query FROM REPORTS WHERE report_name='$reportname'";
	$mysql_query = mysql_result(mysql_query("SELECT query FROM REPORTS WHERE report_name='$reportname'"),0);
	$result= mysql_query($sql_query,$database);
	if(!$result){
		echo mysql_errno($database) . ": " . mysql_error($database). "\n";
		echo $sql_query;
	}
	return $result;
}

$result = getQuery($query,$database);

$fields_num = mysql_num_fields($result);

//echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";
// printing table headers
for($i=0; $i<$fields_num; $i++)
{
    $field = mysql_fetch_field($result);
    echo "<td>{$field->name}</td>";
}
echo "</tr>\n";

//echo "<table>";
while ($row = mysql_fetch_assoc($result)) {
    echo '<tr>';
    foreach($row as $field) {
        echo '<td>' . htmlspecialchars($field) . '</td>';
    }
    echo '</tr>';
}

//echo "</table>"; //Close the table in HTML

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
