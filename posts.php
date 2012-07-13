<?php
require ".conf.php"; 
$objData = json_decode(file_get_contents("php://input"));
$db = new SQLite3("db.db");
$db->query("CREATE TABLE IF NOT EXISTS posts (id INTEGER PRIMARY KEY, title TEXT, content TEXT);");
if($_SERVER['REQUEST_METHOD'] == "POST") {
  if(hash("sha512", hash("sha512",$objData->psw)) == $psw) {
    if (isset($objData->id)){
      $query = "update posts SET title='".$objData->title."', content='".$objData->content."' where id = ".intval($objData->id).";";
      $db->exec($query);
      echo 'true;'.$objData->id;
    } else {
      $query = "insert into posts (title, content) values ('".$objData->title."','".$objData->content."');";
      $db->exec($query);
      echo 'true;'.$db->lastInsertRowID();
    }
  } else echo 'false;0';
}
else if($_SERVER['REQUEST_METHOD'] == "GET"){
  $result = $db->query("select * from posts order by id DESC;");
  $rtrn = array();
  while ($result && $n = $result->fetchArray(SQLITE3_ASSOC)){
    array_push($rtrn, $n);
  } echo ($result) ? json_encode($rtrn) : "tomt";
}
