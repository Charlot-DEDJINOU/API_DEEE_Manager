<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/materiel.php';
 
$database = new Database();
$db = $database->getConnection();

$materiel = new Materiel($db);
 
$stmt = $materiel->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $materiel_arr=array();
    $materiel_arr["materiels"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
 
        $materiel_item=array(
            "id" => $id ,
            "designation" => $designation ,
            "etat" => $etat ,
            "type" => $type ,
            "price" => $prix_unitaire ,
            "image" => $image ,
            "caracteristique" => $caracteristique ,
            "quantite_stock" => $quantite_stock ,
            "publier" => $publier
        ) ;
 
        array_push($materiel_arr["materiels"], $materiel_item);
    }
 
    http_response_code(200);
 
    echo json_encode($materiel_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de materiel.")
    );
}