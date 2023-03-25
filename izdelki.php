<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers: *");

$header = apache_request_headers();

$mysqli = require __DIR__ . "/database.php";

if(isset($header["id"])){

    $sql = "SELECT i.IdIzdelek, i.naziv, CAST(AVG(o.vrednost) AS FLOAT) AS vrednost, MIN(t.cena) AS cena FROM izdelek i 
    INNER JOIN ocena o ON o.IdIzdelek = i.IdIzdelek 
    INNER JOIN trgovina t ON t.IdIzdelek = i.Idizdelek 
    WHERE i.IdKategorija = ? 
    GROUP BY i.IdIzdelek, i.naziv ORDER BY naziv";

    $stmt = $mysqli->stmt_init();

    if (!$stmt->prepare($sql)){
        echo("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("i", $header["id"]);

    $stmt->execute();

    $rs = $stmt->get_result();

    $result = array();
    while($r = $rs->fetch_assoc()){
        array_push($result, $r);
    }

    $stmt->close();
    echo json_encode($result);
}
else{
    $sql = "SELECT IdIzdelek, naziv FROM izdelek ORDER BY naziv";
    $rs = $mysqli->query($sql);
    $result = array();
    while($r = $rs->fetch_assoc()){
        array_push($result, $r);
    }
    echo json_encode($result);
}
?>