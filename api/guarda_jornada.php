<?php
//guarda jornada
$db = new SQLite3("../db/db.sqlite");

//camps entrada
$json = isset($_POST['json']) ? $db->escapeString($_POST['json']) : false;

if(!$json){
  die("json no definit");
}

$obj = json_decode($json);

if(!$obj){
  die("JSON malformat");
}

$sql="INSERT INTO jornades(json) VALUES ('$json');";
$db->exec($sql) or die(print_r($db->lastErrorMsg(), true));

//final tot OK
echo "Jornada guardada correctament";
?>
