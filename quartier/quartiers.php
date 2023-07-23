<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/quartier.php';
include_once '../objects/ville_quartier.php';
 
$database = new Database();
$db = $database->getConnection();

$quartier = new Quartier($db);
 
$stmt = $quartier->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $quartiers=array();
    $quartiers["quartiers"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);

        $ville_quartier = new Ville_quartier($db) ;
        $ville_quartier->id_quartier = $id ;
        $ville_quartier = $ville_quartier->get_ville();

        $array=array() ;

        while($row = $ville_quartier->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            array_push($array , $id_ville) ;
        }
 
        $quartier=array(
            "id" => $id ,
            "nom_quartier" => html_entity_decode($nom_quartier) ,
            "id_ville" => $array
        );
 
        array_push($quartiers["quartiers"], $quartier);
    }
 
    http_response_code(200);
 
    echo json_encode($quartiers);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de quartier.")
    );
}