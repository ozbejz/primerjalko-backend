<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');

$data = json_decode(file_get_contents('php://input'));

$mysqli = require __DIR__ . "/database.php";
$x = $data->uporabnik;
$sql = "SELECT aktiven FROM uporabnik WHERE Id = $x";
$rs = $mysqli->query($sql);
$r = $rs->fetch_assoc();
$o = !$r["aktiven"];
$q;
if($o){
    $q = "UPDATE uporabnik SET aktiven = $o
        WHERE Id = $x"
    ;
}
else{
    $q = "UPDATE uporabnik SET aktiven = 0
    WHERE Id = $x"
;
}
$rs = $mysqli->query($q);
if ($mysqli->query($q)) {
  echo json_encode(['status' => 1]);
  exit;
} else {
  echo json_encode(['status' => 0]);
  exit;
}
?>