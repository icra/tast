<?php
//obtenir id més recent

//connect db
$db=new SQLite3("db.sqlite",SQLITE3_OPEN_READONLY);

//query
$sql="SELECT id FROM participacions ORDER BY id DESC LIMIT 1";
$res=$db->querysingle($sql) or die(print_r($db->errorInfo(), true));

//show result
echo $res;
?>
