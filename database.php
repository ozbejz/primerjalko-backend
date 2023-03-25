<?php

$host = "localhost";
$dbname = "primerjalko-baza";
$username = "root";
$password = "";

mysqli_report(MYSQLI_REPORT_STRICT);

$mysqli = new mysqli($host, $username, $password, $dbname);

if($mysqli->connect_error){
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

?>