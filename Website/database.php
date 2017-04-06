<?php

# Edit this to your needs
$servername = DB_SERVERNAME;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$db = DB_NAME;

try {
  $con_db = new PDO(
      'mysql:host=' . $servername . ';dbname=' . $db,$username,$password
   
);
} catch(PDOException $e) {
  die($e->getMessage());
  
}

return $con_db;

?>
