<?php
// DB Variables as env variables
$dbhost = getenv("MYSQL_SERVICE_HOST");
$dbuser = getenv("MYSQL_USERNAME");
$dbpass = getenv("MYSQL_PASSWORD");
$dbname = getenv("MYSQL_DATABASE");
// Connection
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
/*
if ($connect){
	echo "we are connected";
}
 */
?>
