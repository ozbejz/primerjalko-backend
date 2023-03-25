<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM kategorija ORDER BY naziv";

$rs = $mysqli->query($sql);
$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}
echo json_encode($result);

?>