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

$data = json_decode(file_get_contents("php://input"));

if( !empty($data->id) && !empty($data->contact) && 
    !empty($data->ville) && !empty($data->id_utilisateur) &&
    !empty($data->quartier) && !empty($data->repere) &&
    !empty($data->quantite_livrer) && !empty($data->description) &&
    ($data->collecter == 1 || $data->collecter == 0 ) && ($data->traiter == 1 || $data->traiter == 0) && !empty($data->type_gestion) &&
    !empty($data->detail_traitement) && (!empty($data->date_enregistrement) || $data->date_enregistrement == null ) &&
    (!empty($data->date_collecte) || $data->date_collecte == null ) && (!empty($data->date_traitement) || $data->date_traitement == null )){

        $ville = new Ville($db) ;
        $ville->nom_ville = $data->ville ;
        $ville = $ville->get_id_ville() ;

        $quartier = new Quartier($db) ;
        $quartier->nom_quartier = $data->quartier ;
        $quartier = $quartier->get_id_quartier() ;

        $enregistrement_deee->id = htmlentities($data->id) ;
        $enregistrement_deee->id_utilisateur = htmlentities($data->id_utilisateur) ;
        $enregistrement_deee->id_ville = htmlentities($ville) ;
        $enregistrement_deee->id_quartier = htmlentities($quartier) ;
        $enregistrement_deee->contact = htmlentities($data->contact) ;
        $enregistrement_deee->repere = htmlentities($data->repere) ;
        $enregistrement_deee->qte_livrer = htmlentities($data->quantite_livrer) ;
        $enregistrement_deee->collecter = htmlentities($data->collecter) ;
        $enregistrement_deee->description = htmlentities($data->description) ;
        $enregistrement_deee->traiter = htmlentities($data->traiter) ;
        $enregistrement_deee->type_gestion = htmlentities($data->type_gestion) ;
        $enregistrement_deee->detail_traitement = htmlentities($data->detail_traitement) ;
        $enregistrement_deee->date_enregistrement = htmlentities($data->date_enregistrement) ;
        $enregistrement_deee->date_collecte = htmlentities($data->date_collecte) ;
        $enregistrement_deee->date_traitement = htmlentities($data->date_traitement) ;
    
    $stmt = $enregistrement_deee->read_one_by_id() ;
    
    $num = $stmt->rowCount();

    if($num == 1){
        if($enregistrement_deee->update()){

            http_response_code(200) ;
            echo json_encode(array(
                "message"=>"Mise à jour reussi"
            )) ;
        }
        else{
            http_response_code(400) ;
            echo json_encode(array(
                "message"=>"Echec de mise à jour.Une eureur s'est intervenue lors de la mise à jour"
            )) ;
        }
    }
    else{

        http_response_code(201) ;
        echo json_encode(array(
                "message"=>"Ce enregistrement_deee n'existe pas"
            )) ;
    }
       
}
else{

    http_response_code(404);
 
    echo json_encode(array(
        "message"=>"Pas assez donnee"
    )) ;
}