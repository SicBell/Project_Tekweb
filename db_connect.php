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