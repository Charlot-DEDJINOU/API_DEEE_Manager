<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/reparateur.php';
include_once '../objects/metier.php' ;
include_once '../objects/ville.php' ;
include_once '../objects/utilisateur.php' ;
include_once '../objects/quartier.php' ;

$database = new Database();
$db = $database->getConnection();

$reparateur = new Reparateur($db);

if(isset($_GET["id_utilisateur"])){

    $reparateur->id_utilisateur = htmlentities($_GET["id_utilisateur"]) ;
    
    $stmt = $reparateur->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num > 0){

        $row = $stmt->fetch(PDO::FETCH_ASSOC) ;

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

        $reparateur = array(
            "id_utilisateur" => $id_utilisateur ,
            "nom_utilisateur" => html_entity_decode($utilisateur[0]) ,
            "prenom_utilisateur" => html_entity_decode($utilisateur[1]) ,
            "metier" => html_entity_decode($metier) ,
            "ville" => html_entity_decode($ville) ,
            "quartier" => html_entity_decode($quartier) ,
            "annee_experience" => $annee_experience ,
            "etoile" => $etoile ,
            "contact" => $contact ,
            "image" => $image ,
            "nombre_projet" => $nombre_projet ,
            "fin_abonnement" => $fin_abonnement ,
            "description" => html_entity_decode($description) ,
            "jour_restant" => strtotime($fin_abonnement) - strtotime(date("Y-m-d H:i:s")) ,
            "premium" => strtotime($fin_abonnement) >= strtotime(date("Y-m-d H:i:s")) ,
            "publier" => $publier ,
        ) ;

        http_response_code(200);
 
        echo json_encode($reparateur);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Ce réparateur n'existe pas"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez de donnee pour la lecture"
    )) ;
}
?>