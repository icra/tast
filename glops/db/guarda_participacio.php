<?php
//guarda resultat
$db=new SQLite3("db.sqlite");

//camps entrada
$json = isset($_POST['json']) ? $db->escapeString($_POST['json']) : false;
if(!$json){
  die("json no definit");
}

//check json malformat
if(!json_decode($json)){
  die("JSON malformat");
}

//insert
$sql="INSERT INTO participacions (json) VALUES ('$json');";
$db->exec($sql) or die(print_r($db->lastErrorMsg(), true));

//final tot OK
echo "Participació registrada correctament";
?>
