<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT t.IdTrgovina, t.ime, t.cena, i.naziv FROM trgovina t INNER JOIN izdelek i ON i.IdIzdelek = t.IdIzdelek ORDER BY t.ime ";

$rs = $mysqli->query($sql);
$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}
echo json_encode($result);

?>