<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/enregistrer_deees.php';
include_once '../objects/quartier.php' ;
include_once '../objects/ville.php' ;
include_once '../objects/utilisateur.php' ;

$database = new Database();
$db = $database->getConnection();

$enregistrer_deee = new Deee($db);

if(isset($_GET["id"])){

    $enregistrer_deee->id = htmlentities($_GET["id"]) ;
    
    $stmt = $enregistrer_deee->read_one_by_id() ;
    
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

        $utilisateur = new Utilisateur($db) ;
        $utilisateur->id = $id_utilisateur ;
        $utilisateur = $utilisateur->get_utilisateur_infos() ;

        $enregistrer_deee = array(
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

        http_response_code(200);
 
        echo json_encode($enregistrer_deee);
    }
    else{

        http_response_code(201) ;

        echo json_encode(array(
                "message"=>"Cet enregistrement n'existe pas"
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