?php
define('DB_USERNAME', 'tsteiner');
define('DB_PASSWORD', 'EECS647');
$db = @mysql_connect('mysql.eecs.ku.edu',DB_USERNAME,DB_PASSWORD);
$mRootpath = "";
$mFilepath = explode('/',dirname(__DIR__));
foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html/WISQL"){break;}}
define('ROOT_PATH', $mRootpath);

error_reporting(E_ALL);
ini_set("display_errors", 1);
?>