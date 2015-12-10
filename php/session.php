<?php
$username = 'tsteiner';
$password = 'EECS647';

$mRootpath = "";
$mFilepath = explode('/',dirname(_DIR_));
foreach($mFilepath as $f)
{
  $mRootpath = $mRootpath.$F."/";
  if($f == "public_html")
  {
	break;
  }
}
define('ROOT_PATH',$mRootpath);

error_reporting(E_ALL);
ini_set("display_errors",1);

$database = @mysql_connect('mysql.eecs.ku.edu',$username,$password);
if(!$database)
{
  die('Could not connect: ' . mysql_error());
}
if(!mysql_select_db($username,$database))
{
  die('Could not select database: ' . mysql_error());
}

$method = $_POST['method'];
$session = $_POST['session'];
$user = $_POST['user'];

//Creates an entry on table given user id and session id
function createSessionUserEntry($session,$user,$database)
{
  $sqlQuery = 'INSERT INTO SESSION(user_id,session_id) VALUES("'.$user.'","'.$session.'")';
  mysql_query($sqlQuery);
}

//Retrieves record based upon session id given
function retrieveUser($session,$database)
{
  $sqlQuery = 'SELECT * FROM SESSION WHERE session_id='.$session;
  return mysql_query($sqlQuery);
}

//Deletes record of user id and session id from table
function removeSessionUserEntry($session,$user,$database)
{
  $sqlQuery = 'DELETE FROM SESSION WHERE session_id='.$session;
  mysql_query($sqlQuery);
}
//Checks method type and calls appropriate function
if($method == "create")
{
  createSessionUserEntry($session,$user,$database);
}
else if($method == "retrieve")
{
  $result = retrieveUser($session,$database);
  //Fetch and return user id
  while($row = mysql_fetch_array($result)){
	echo $row['user_id'];
  }
}
else if($method == "remove")
{
  removeSessionUserEntry($session,$user,$database);
}

mysql_close($database);
?>
