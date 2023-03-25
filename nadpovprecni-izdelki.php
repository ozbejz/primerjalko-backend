<?php

header('Access-Control-Allow-Origin:*');

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT i.naziv, i.IdIzdelek, CAST(AVG(o.vrednost) AS FLOAT) AS vrednost, MIN(t.cena) AS cena FROM izdelek i
INNER JOIN ocena o ON o.IdIzdelek = i.IdIzdelek 
INNER JOIN trgovina t ON t.IdIzdelek = i.Idizdelek 
GROUP BY i.naziv, i.IdIzdelek
ORDER BY AVG(o.vrednost) 
DESC LIMIT 5";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)){
    echo("SQL error: " . $mysqli->error);
}
$stmt->execute();
$rs = $stmt->get_result();
$result = array();
while($r = $rs->fetch_assoc()){
    array_push($result, $r);
}
echo json_encode($result);

?>