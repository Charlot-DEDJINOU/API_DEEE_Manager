<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/lieu_depot.php';
include_once '../objects/quartier.php' ;
include_once '../objects/ville.php' ;
 
$database = new Database();
$db = $database->getConnection();

$lieu_depot = new Lieu_depot($db);
 
$stmt = $lieu_depot->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $lieu_depot_arr=array();
    $lieu_depot_arr["lieu_depots"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);

        $ville = new Ville($db) ;
        $ville->id = $id_ville ;
        $ville = $ville->get_name_ville() ;

        $quartier = new quartier($db) ;
        $quartier->id = $id_quartier ;
        $quartier = $quartier->get_name_quartier() ;
 
        $lieu_depot_item = array(
            "id" => $id ,
            "quartier" => html_entity_decode($quartier) ,
            "ville" => html_entity_decode($ville) ,
            "nom" => html_entity_decode($nom) ,
            "longitude" => $longitude ,
            "latitude" => $latitude ,
            "img" => $image ,
            "decris" => html_entity_decode($description) ,
            "repere" => html_entity_decode($repere) ,
            "publier" => $publier
        ) ;
 
        array_push($lieu_depot_arr["lieu_depots"], $lieu_depot_item);
    }
 
    http_response_code(200);
 
    echo json_encode($lieu_depot_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de lieu de depot.")
    );
}