<?php

// Vérifier si un fichier a été téléchargé
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
    // Connexion à MongoDB
    require_once __DIR__ . '/vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->selectDatabase('webprojet');
    $collection = $db->selectCollection('cours'); // Remplacez 'cours' par le nom de votre collection

    // Récupérer les informations sur le fichier téléchargé
    $fileName = $_FILES['pdf']['name'];
    $fileTmpName = $_FILES['pdf']['tmp_name'];

    // Lire le contenu du fichier
    $fileContent = file_get_contents($fileTmpName);

    // Insérer le fichier PDF dans la collection MongoDB
    $result = $collection->insertOne([
        'filename' => $fileName,
        'content' => new MongoDB\BSON\Binary($fileContent, MongoDB\BSON\Binary::TYPE_GENERIC),
        'upload_date' => new MongoDB\BSON\UTCDateTime()
    ]);

    if ($result->getInsertedCount() === 1) {
        echo "Fichier PDF téléchargé avec succès!";
    } else {
        echo "Une erreur s'est produite lors du téléchargement du fichier PDF.";
    }
} else {
    echo "Erreur lors du téléchargement du fichier PDF.";
}
