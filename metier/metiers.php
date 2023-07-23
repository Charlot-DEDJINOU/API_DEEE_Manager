<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/metier.php';
 
$database = new Database();
$db = $database->getConnection();

$metier = new Metier($db);
 
$stmt = $metier->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $metiers=array();
    $metiers["metiers"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
 
        $metier=array(
            "id" => $id ,
            "designation" => $designation ,
        );
 
        array_push($metiers["metiers"], $metier);
    }
 
    http_response_code(200);
 
    echo json_encode($metiers);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de metier.")
    );
}