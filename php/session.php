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

$method = $_POST["method"];
$session = $_POST["session"];
$user = $_POST["user"];

function createSessionUserEntry($session,$user,$database)
{
  $sqlQuery = 'INSERT INTO SESSION(user_id,session_id) VALUES("'.$user.'","'.$session.'")';
  mysql_query($sqlQuery);
}

function retrieveUser($session,$database)
{
  $sqlQuery = 'SELECT user_id FROM SESSION WHERE session_id='.$session;
  return mysql_query($sqlQuery,$database);
}

function removeSessionUserEntry($session,$user,$database)
{
  $sqlQuery = 'DELETE FROM SESSION WHERE session_id='.$session;
  mysql_query($sqlQuery);
}

if($method == "create")
{
  createSessionUserEntry($session,$user,$database);
}
else if($method == "retrieve")
{
  $result = retrieveUser($session,$database);
  echo $result["user_id"];
}
else if($method == "remove")
{
  removeSessionUserEntry($session,$user,$database);
}

mysql_close($database);
?>
