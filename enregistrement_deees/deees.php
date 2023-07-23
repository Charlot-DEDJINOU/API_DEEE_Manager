<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/enregistrer_deees.php';
include_once '../objects/quartier.php' ;
include_once '../objects/ville.php' ;
include_once '../objects/utilisateur.php' ;
 
$database = new Database();
$db = $database->getConnection();

$enregistrement_deee = new Deee($db);
 
$stmt = $enregistrement_deee->read();
$num = $stmt->rowCount();
 
if($num>0){
 
    $enregistrement_deee_arr=array();
    $enregistrement_deee_arr["enregistrement_deees"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $ville = new Ville($db) ;
        $ville->id = $id_ville ;
        $ville = $ville->get_name_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->id = $id_quartier ;
        $quartier = $quartier->get_name_quartier() ;

        $utilisateur = new Utilisateur($db) ;
        $utilisateur->id = $id_utilisateur ;
        $utilisateur = $utilisateur->get_utilisateur_infos() ;

        $enregistrement_deee_item = array(
            "id" => $id ,
            "nom_utilisateur" => html_entity_decode($utilisateur[0]) ,
            "prenom_utilisateur" => html_entity_decode($utilisateur[1]) ,
            "quartier" => html_entity_decode($quartier) ,
            "ville" => html_entity_decode($ville) ,
            "contact" => html_entity_decode($contact) ,
            "repere" => html_entity_decode($repere) ,
            "quantite_livrer" => $qte_livrer ,
            "description" => html_entity_decode($description) ,
            "collecter" => $collecter ,
            "traiter" => $traiter ,
            "type_gestion" => html_entity_decode($type_gestion) ,
            "detail_traitement" => html_entity_decode($detail_traitement) ,
            "date_enregistrement" => $date_enregistrement ,
            "date_collecte" => $date_collecte ,
            "date_traitement" => $date_traitement ,
        ) ;

        array_push($enregistrement_deee_arr["enregistrement_deees"], $enregistrement_deee_item);
    }
 
    http_response_code(200);
 
    echo json_encode($enregistrement_deee_arr);
}
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Pas d'enregitrement_deees.")
    );
}