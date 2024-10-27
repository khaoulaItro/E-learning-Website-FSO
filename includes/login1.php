<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

if (!isset($_SERVER['HTTP_REFERER'])) {
    die("Page inaccessible");
}

$email = $pass = $email_error = $pass_error = '';

function validate_email($field)
{
    if ($field == "") return "<br>Entrer votre email<br>";
    else if (
        !((strpos($field, ".") > 0) &&
            (strpos($field, "@") > 0)) ||
        preg_match("/[^a-zA-Z0-9.@_-]/", $field)
    )
        return "<br>L'email est invalide <br>";
    return "";
}

function validate_password($field)
{
    if ($field == "") return "<br>Entrer votre mot de pass<br>";
    else if (strlen($field) < 6)
        return "<br>Mot de pass doit contenir au moins 6 caractères<br>";
    return "";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();

    $client = new Client("mongodb://localhost:27017");

    // Utilisez votre nom de base de données et de collection
    $collection = $client->webprojet->utilisateur;

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $email_error = validate_email($email);
    $pass_error = validate_password($pass);

    if ($email_error == '') {
        $_SESSION['email'] = $email;
    }

    try {
        // Utilisez une approche de hachage sécurisée pour stocker les mots de passe
        $user = $collection->findOne(['email' => $email, 'password' => $pass]);

        if ($user) {
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['sexe'] = $user['sexe'];
            $_SESSION['email'] = $email;
            header('Location: ./accueil.php');
        } elseif ($pass_error == '' || $email_error == '') {
            if ($pass_error == '') {
                $pass_error .= "<br> Verifier le mot de pass";
            } else {
                $email_error .= "<br> Verifier votre email";
            }
            session_unset();
            session_destroy();
        }
    } catch (Exception $e) {
        die("Erreur de connexion à MongoDB : " . $e->getMessage());
    }
}
