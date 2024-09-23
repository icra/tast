<?php
//esborra vot

$db = new SQLite3("db.sqlite");

//camps entrada
$id = isset($_POST['id']) ? $db->escapeString($_POST['id']) : "NOT_DEFINED";

if($id=="NOT_DEFINED"){
  die("camp id no definit");
}

$sql="
  DELETE FROM resultats WHERE id='$id'
";
$db->exec($sql) or die(print_r($db->lastErrorMsg(), true));

//final tot OK
echo "Resultat esborrat correctament";
?>
