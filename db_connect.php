<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";
$conn = new mysqli($servername, $username, $password,$dbname,3306);
if ($conn->connect_error) {
	die("Connection Failed".$conn->connect_error);	
}
echo""

?>
<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "library";

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

return $mysqli;