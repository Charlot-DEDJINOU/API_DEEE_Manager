<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/reparateur.php';
include_once '../objects/Metier.php' ;
include_once '../objects/ville.php' ;
include_once '../objects/utilisateur.php' ;
include_once '../objects/quartier.php' ;
 
$database = new Database();
$db = $database->getConnection();

$reparateur = new Reparateur($db);
 
$stmt = $reparateur->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $reparateur_arr=array();
    $reparateur_arr["reparateurs"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ville = new Ville($db) ;
        $ville->id = $id_ville ;
        $ville = $ville->get_name_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->id = $id_quartier ;
        $quartier = $quartier->get_name_quartier() ;

        $metier = new Metier($db) ;
        $metier->id = $id_metier ;
        $metier = $metier->get_name_metier() ;

        $utilisateur = new Utilisateur($db) ;
        $utilisateur->id = $id_utilisateur ;
        $utilisateur = $utilisateur->get_utilisateur_infos() ;

        $reparateur_item = array(
            "id_utilisateur" => $id_utilisateur ,
            "nom_utilisateur" => html_entity_decode($utilisateur[0]) ,
            "prenom_utilisateur" => html_entity_decode($utilisateur[1]) ,
            "metier" => html_entity_decode($metier) ,
            "ville" => html_entity_decode($ville) ,
            "quartier" => html_entity_decode($quartier) ,
            "annee_experience" => $annee_experience ,
            "etoile" => $etoile ,
            "image" => $image ,
            "fin_abonnement" => $fin_abonnement ,
            "nombre_projet" => $nombre_projet ,
            "description" => html_entity_decode($description) ,
            "premium" => strtotime($fin_abonnement) >= strtotime(date("Y-m-d H:i:s")) ,
            "publier" => $publier ,
        ) ;

        array_push($reparateur_arr["reparateurs"], $reparateur_item);
    }
 
    http_response_code(200);
 
    echo json_encode($reparateur_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas de réparateurs.")
    );
}