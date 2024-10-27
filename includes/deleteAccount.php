<?php
// Assurez-vous que le référent existe avant de continuer
if (!isset($_SERVER['HTTP_REFERER'])) {
    die("Page inaccessible");
}

session_start();

// Connexion à MongoDB
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

// Connexion à MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

// Sélectionner la base de données
$database = $mongoClient->webprojet;

// Sélectionner la collection
$collection = $database->utilisateur;

// Vérifiez si l'email de l'utilisateur est défini dans la session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Supprimer l'utilisateur avec cet email
    $result = $collection->deleteOne(['email' => $email]);

    // Vérifier si la suppression a réussi
    if ($result->getDeletedCount() > 0) {
        echo '<script language="javascript">';
        echo 'alert("Votre compte a été supprimé avec succès")';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Une erreur est survenue lors de la suppression de votre compte")';
        echo '</script>';
    }

    // Détruire la session
    session_unset();
    session_destroy();

    // Redirection vers une page spécifique après la suppression
    header('Location: http://127.0.0.1/E-learning-Website-FSO/');
} else {
    echo "L'email de l'utilisateur n'est pas défini dans la session.";
}
