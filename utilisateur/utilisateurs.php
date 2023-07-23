<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
 
$database = new Database();
$db = $database->getConnection();

$utilisateur = new Utilisateur($db);
 
$stmt = $utilisateur->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $utilisateur_arr=array();
    $utilisateur_arr["utilisateurs"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
       
        extract($row);
 
        $utilisateur_item=array(
            "id" => $id ,
            "nom" => html_entity_decode($nom) ,
            "prenom" => html_entity_decode($prenom) ,
            "admin" => $admin ,
            "contact" => $contact ,
            "adresse" => html_entity_decode($adresse) ,
            "status" => $statut
        );
 
        array_push($utilisateur_arr["utilisateurs"], $utilisateur_item);
    }
 
    http_response_code(200);
 
    echo json_encode($utilisateur_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas d'utilisateur.")
    );
}