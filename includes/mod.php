<?php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

// Vérifie si l'utilisateur est connecté ou si une session est active
if (!isset($_SESSION['email'])) {
    // Redirige l'utilisateur vers une page de connexion ou affiche un message d'erreur
    header('Location: http://127.0.0.1/E-learning-Website-FSO/login.php');
    exit; // Assurez-vous de quitter le script après la redirection
}

$email = $error_email = $name = $error_name = $pass = $error_pass =
    $confirm = $error_confirm = $sexe = $error_sexe = '';

function validate_password($field)
{
    if ($field == "") return "<br>Entrer votre mot de passe<br>";
    else if (strlen($field) < 6)
        return "<br>Mot de passe doit contenir au moins 6 caractères<br>";
    return "";
}

function validate_username($field)
{
    if ($field == "") return "<br>Entrer le nom<br>";
    else if (strlen($field) < 4)
        return "<br>Le nom doit contenir au moins 5 caractères<br>";
    else if (preg_match("/[^a-zA-Z ]/", $field))
        return "<br>Le nom est invalide";
    return "";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $mongoClient = new Client("mongodb://localhost:27017");
    $collection = $mongoClient->webprojet->utilisateur;

    $email = $_SESSION['email'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];
    $sexe = $_POST['sexe'];
    $confirm = $_POST['confirmpass'];

    $error_pass = validate_password($pass);
    $error_name = validate_username($name);

    if ($confirm == '') {
        $error_confirm = "<br>Confirmer le mot de passe";
    } elseif ($confirm != $pass) {
        $error_confirm = "<br>Les deux mots de passe sont différents";
    } elseif ($error_confirm == '' && $error_name == '' && $error_pass == '') {
        $result = $collection->updateOne(
            ['email' => $email],
            ['$set' => [
                'nom' => $name,
                'sexe' => $sexe,
                'password' => $pass
            ]]
        );

        if ($result->getModifiedCount() > 0) {
            header('Location: http://127.0.0.1/E-learning-Website-FSO/profile.php');
            exit;
        } else {
            echo "Une erreur est survenue lors de la mise à jour des données.";
        }
    } else {
        session_unset();
        session_destroy();
    }
}
