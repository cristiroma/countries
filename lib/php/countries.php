<?php

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "countries";


$conn = mysql_connect($host, $user, $pass);
if(!$conn) {
	die("Cannot connect to database: " . mysql_error());
}
mysql_select_db($db);


$cur = mysql_query("SELECT * FROM countries");
while($row = mysql_fetch_assoc($cur)) {

    

}


mysql_close($conn);
