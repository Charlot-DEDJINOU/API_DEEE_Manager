<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/ville.php';
 
$database = new Database();
$db = $database->getConnection();

$ville = new Ville($db);
 
$stmt = $ville->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $villes=array();
    $villes["villes"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
 
        $ville=array(
            "id" => $id ,
            "nom_ville" => html_entity_decode($nom_ville) ,
        );
 
        array_push($villes["villes"], $ville);
    }
 
    http_response_code(200);
 
    echo json_encode($villes);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de ville.")
    );
}