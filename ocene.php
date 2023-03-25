<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT o.IdOcena, o.vrednost, o.komentar, u.ime, i.naziv FROM ocena o 
INNER JOIN uporabnik u ON u.Id = o.IdUporabnik 
INNER JOIN izdelek i ON i.IdIzdelek = o.IdIzdelek
ORDER BY u.ime";

$rs = $mysqli->query($sql);
$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}
echo json_encode($result);

?>