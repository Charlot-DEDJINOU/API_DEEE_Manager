<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/reparateur.php';
include_once '../objects/metier.php' ;
include_once '../objects/ville.php' ;
include_once '../objects/quartier.php' ;

$database = new Database();
$db = $database->getConnection();

$reparateur = new Reparateur($db);

$data = json_decode($_GET["data"]);

if( !empty($data->ville) && !empty($data->id_utilisateur)  && !empty($data->contact) &&
    !empty($data->annee_experience) && !empty($data->nombre_projet) && 
    !empty($data->metier) && !empty($data->description) && !empty($data->quartier)){

    $reparateur->id_utilisateur = htmlentities($data->id_utilisateur) ; 

    if(!$reparateur->yet_register()){

        $ville = new Ville($db) ;
        $ville->nom_ville = htmlentities($data->ville) ;
        $ville = $ville->get_id_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->nom_quartier = htmlentities($data->quartier);
        $quartier = $quartier->get_id_quartier() ;

        $metier= new Metier($db) ;
        $metier->designation= $data->metier ;
        $metier= $metier->get_id_metier() ;

        $reparateur->id_ville = htmlentities($ville) ;
        $reparateur->id_metier= htmlentities($metier) ;
        $reparateur->id_quartier = htmlentities($quartier) ;
        $reparateur->annee_experience = htmlentities($data->annee_experience) ;
        $reparateur->nombre_projet = htmlentities($data->nombre_projet) ;
        $reparateur->description = htmlentities($data->description) ;
        $reparateur->contact = htmlentities($data->contact) ;
        $reparateur->etoile = 0 ;
        $reparateur->publier = 0 ;

        if($reparateur->create()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Vous êtes désormais réparateur"
            )) ;
        }
        else{
            http_response_code(201) ;
            echo json_encode(array(
                "message"=>"Echec d'ajout.Une eureur s'est intervenue lors de l'ajout"
            )) ;
        }
    } 
    else{
        http_response_code(201) ;
        echo json_encode(array(
            "message"=>"Vous êtes déjà réparateur"
        )) ;
    }
}
else{

    http_response_code(404);

    echo json_encode(array(
        "message"=>"Pas assez de donnee"
    )) ;
    }
?>