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

if(!empty($data->ville) && !empty($data->id_utilisateur) && !empty($data->fin_abonnement) &&
    !empty($data->annee_experience) && !empty($data->nombre_projet) && ($data->etoile >= 0) &&
    ($data->publier == 0 || $data->publier == 1) && !empty($data->metier) && !empty($data->description) && 
    !empty($data->image) && !empty($data->contact)){

    $reparateur->id_utilisateur = htmlentities($data->id_utilisateur) ; 

    $stmt = $reparateur->read_one_by_id() ;

    $number = $stmt->rowCount() ;

    if($number > 0){

        $ville = new Ville($db) ;
        $ville->nom_ville = htmlentities($data->ville) ;
        $ville = $ville->get_id_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->nom_quartier = htmlentities($data->quartier) ;
        $quartier = $quartier->get_id_quartier() ;

        $metier = new Metier($db) ;
        $metier->designation = $data->metier ;
        $metier = $metier->get_id_metier() ;

        $reparateur->id_ville = $ville ;
        $reparateur->id_quartier = $quartier ;
        $reparateur->image = htmlentities($data->image) ;
        $reparateur->id_metier = $metier ;
        $reparateur->annee_experience = htmlentities($data->annee_experience) ;
        $reparateur->nombre_projet = htmlentities($data->nombre_projet) ;
        $reparateur->description = htmlentities($data->description) ;
        $reparateur->etoile =  htmlentities($data->etoile);
        $reparateur->fin_abonnement = $data->fin_abonnement ;
        $reparateur->contact = htmlentities($data->contact) ;
        $reparateur->publier =  htmlentities($data->publier);

        if($reparateur->update()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Mise à jour réussie"
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
            "message"=>"Pas de reparateur avec cet id"
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