<?php
//dump taula participacions en format json

//connect to db
$db=new SQLite3("db.sqlite",SQLITE3_OPEN_READONLY);

//query
$sql="SELECT * FROM participacions";
$res=$db->query($sql) or die(print_r($db->errorInfo(), true));

//process query
$payload=[];
while($row=$res->fetchArray(SQLITE3_ASSOC)){
  $obj=(object)$row;

  //parseja text camp json
  $obj->json = json_decode($obj->json);

  $payload[]=$obj;
}
echo json_encode($payload);
?>
