<?php
//esborra una jornada
$db = new SQLite3("../db/db.sqlite");

//camp entrada
$id = isset($_POST['id']) ? $db->escapeString($_POST['id']) : "NOT_DEFINED";

if($id=="NOT_DEFINED"){
  die("camp id no definit");
}

$sql="DELETE FROM jornades WHERE id='$id'";
$db->exec($sql) or die(print_r($db->lastErrorMsg(), true));

//final OK
echo "Jornada esborrada correctament";
?>
