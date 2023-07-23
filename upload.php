<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    if ($file['error'] === UPLOAD_ERR_OK) {
      $fileName = basename($file['name']);
      $filePath = '../images/' . $fileName;
      if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(array(
            "message" => "Le fichier a été téléchargé avec succès."
        )) ;
      } else {
        echo json_encode(array(
            "message" => 'Une erreur est survenue lors du téléchargement du fichier.'
        ));
      }
    } else {
      echo json_encode(array(
        "message" => 'Une erreur est survenue lors du téléchargement du fichier.'
      ));
    }
  } else {
    echo json_encode(array(
        "message" => "Aucun fichier sélectionné."
    ));
  }
}
?>
