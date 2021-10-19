<?php
require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));
$id = filter_var($input->id,FILTER_SANITIZE_STRING);
$description = filter_var($input->description,FILTER_SANITIZE_STRING);

try {
$db = openDb();

$query = $db->prepare('update task set description=:description where id=:id');
$query->bindValue(':id',$id,PDO::PARAM_STR);
$query->bindValue(':description',$description,PDO::PARAM_STR);
$query->execute();

header('HTTP/1.1 200 OK');
$data = array('id' => $id, 'description' => $description);
print json_encode($data);
} catch (PDOException $pdoex) {
returnError($pdoex);
}
