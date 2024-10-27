<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Connexion à MongoDB
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://localhost:27017");
$collection = $mongoClient->webprojet->utilisateur;

$email = $_SESSION['email'];
$user = $collection->findOne(['email' => $email]);

$nom = $user['nom'] ?? '';
$sexe = $user['sexe'] ?? '';
$password = $user['password'] ?? '';

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les nouvelles données du formulaire
    $newName = $_POST['nom'];
    $newSexe = $_POST['sexe'];
    $newPass = $_POST['password'];
    $confirmPass = $_POST['confirmpass'];

    // Vérifier si le mot de passe confirmé correspond
    if ($newPass !== $confirmPass) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    // Mettre à jour les informations de l'utilisateur
    $updateResult = $collection->updateOne(
        ['email' => $email],
        ['$set' => [
            'nom' => $newName,
            'sexe' => $newSexe,
            'password' => $newPass
        ]]
    );

    // Vérifier si la mise à jour a réussi
    if ($updateResult->getModifiedCount() > 0) {
        // Rediriger vers la page d'accueil
        header("Location: accueil.php");
        exit;
    } else {
        echo "Une erreur s'est produite lors de la mise à jour des informations.";
    }

    // Rafraîchir la page pour afficher les nouvelles informations
    header("Refresh:0");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="CSS/Login&Inscription.css" />
    <title>Form Validator</title>
</head>

<body>
    <div class="container">
        <div>
            <form id="form" class="form" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                <h2>Modifiez vos données :</h2>
                <div class="form-control">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" placeholder="Entrer votre nom" name="nom" value="<?= $nom; ?>" />
                    <small>Error message</small>
                    <!-- Ajoutez ici le code pour afficher les messages d'erreur -->
                </div>
                <div class="form-control">
                    <label for="sexe">Sexe</label>
                    <select name="sexe" id="sexe">
                        <optgroup>
                            <option value="homme" <?= ($sexe == 'homme') ? 'selected' : ''; ?>>homme</option>
                            <option value="femme" <?= ($sexe == 'femme') ? 'selected' : ''; ?>>femme</option>
                        </optgroup>
                    </select>
                    <small>Error message</small>
                    <!-- Ajoutez ici le code pour afficher les messages d'erreur -->
                </div>
                <div class="form-control">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Entrer le password" name="password" value="<?= $password; ?>" />
                    <small>Error message</small>
                    <!-- Ajoutez ici le code pour afficher les messages d'erreur -->
                </div>
                <div class="form-control">
                    <label for="password2">Confirmer le Password</label>
                    <input type="password" id="password2" placeholder="Entrer le password à nouveau" name="confirmpass" />
                    <small>Error message</small>
                    <!-- Ajoutez ici le code pour afficher les messages d'erreur -->
                </div>
                <button type="submit" name="submit">Valider</button>
            </form>
        </div>
        <div>
            <img src="images/edit.png" alt="sing in" width="590" height="550">
        </div>
    </div>
</body>

</html>