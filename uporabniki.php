<?php
header('Access-Control-Allow-Origin:*');

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM uporabnik ORDER BY ime";
$rs = $mysqli->query($sql);

$rs = $mysqli->query($sql);
$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}
echo json_encode($result);

?>