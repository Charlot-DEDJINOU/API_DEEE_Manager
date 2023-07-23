<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/enregistrer_deees.php';
include_once '../objects/quartier.php' ;
include_once '../objects/ville.php' ;

$database = new Database();
$db = $database->getConnection();

$enregistrement_deee = new Deee($db);

$data = json_decode($_GET["data"]);

if( !empty($data->contact) && !empty($data->ville) && 
    !empty($data->id_utilisateur) && !empty($data->quartier) && 
    !empty($data->repere) && !empty($data->quantite_livrer) && 
    !empty($data->description) ){

    $enregistrement_deee->id_utilisateur = htmlentities($data->id_utilisateur) ;

    if(!$enregistrement_deee->yet_register()){

        $enregistrement_deee->id_ville = htmlentities($data->ville) ;
        $enregistrement_deee->id_quartier = htmlentities($data->quartier) ;
        $enregistrement_deee->contact = htmlentities($data->contact) ;
        $enregistrement_deee->repere = htmlentities($data->repere) ;
        $enregistrement_deee->qte_livrer = htmlentities($data->quantite_livrer) ;
        $enregistrement_deee->description = htmlentities($data->description) ;

        if($enregistrement_deee->create()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Enregistrement réussie avec succès"
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
            "message"=>"Vous avez un enregistrement en cours"
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