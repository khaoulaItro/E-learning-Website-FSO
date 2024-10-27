<?php
session_start();
include 'includes/control.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/apropos.css">
    <link rel="stylesheet" href="CSS/search.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <title>A propos</title>
    <style>
        .img-projet {
            width: 300px;
            /* Définissez la largeur souhaitée */
            height: 500px;
            /* Définissez la hauteur souhaitée */
            object-fit: cover;
            /* Ajustez la taille de l'image pour couvrir le conteneur sans déformer l'image */
            margin-right: 60px;
        }

        body {

            justify-content: center;
            align-items: center;

        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['error'])) {
        echo '<script language="javascript">';
        echo 'alert("Vous avez tapé un message ou un email vide, essayez à nouveau!")';
        echo '</script>';
        unset($_GET);
    }
    ?>

    <div class="headerr">
        <a href="index.php">
            <div class="logo">
                <img src="images/logoo.png" alt="logo" width="50" height="50" />
            </div>
        </a>
        <div class="navv">
            <ul class="ull">
                <a href="accueil.php">
                    <li class="lii"><button class="inscription">Accueil</button></li>
                </a>
                <a href="matiere.php">
                    <li class="lii"><button class="inscription">Matiers</button></li>
                </a>
                <a href="forum.php">
                    <li class="lii"><button class="inscription">Forum</button></li>
                </a>
                <a href="profile.php">
                    <li class="lii"><button class="inscription">Mon profil</button></li>
                </a>
                <a href="contact.php">
                    <li class="lii"><button class="inscription">Contact Us</button></li>
                </a>
                <a href="cours.php">
                    <div class="lii"><button class="inscription">cours</button></div>
                </a>
                <a href="includes/deconnexion.php">
                    <li class="lii"><button class="connection">Déconnexion</button></li>
                </a>
                <?php
                if (isset($_SESSION['nom']))
                    echo "<a><li class=\"lii\"><button class=\"connection\">" . $_SESSION['nom'] . "</button></li></a>";
                ?>
                <form action="searchMembersPage.php" method="POST">
                    <li>
                        <div class="buscar-caja">
                            <input type="text" name="result" class="buscar-txt" placeholder="search..." />
                            <button type="submit" name="search" value="blabla" href="searchMembersPage.php" class="buscar-btn">
                                <img src="images/search.png" alt="search" width="20" height="20" />
                            </button>
                        </div>
                    </li>
                </form>
            </ul>
        </div>
    </div>


    <div class="container">
        <h1>cours</h1>
        <?php
        // Connexion à MongoDB
        require_once __DIR__ . '/vendor/autoload.php';
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $db = $client->selectDatabase('webprojet');
        $collection = $db->selectCollection('cours');

        // Récupérer le document contenant le chemin de l'image 1
        $imageDocument1 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bf95054bffbb675e77477c')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument1) {
            // Récupérer le chemin de l'image
            $imagePath1 = "ba.png";
            // Afficher l'image dans votre page HTML
            echo "<img src='$imagePath1' alt='Image 1' class='img-projet' />";
        } else {
            echo "Image non trouvée.";
        }

        // Récupérer le document contenant le chemin de l'image 2
        $imageDocument2 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bfa18a4bffbb675e774781')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument2) {
            // Récupérer le chemin de l'image
            $imagePath2 = "java.jfif";

            // Afficher l'image dans votre page HTML
            echo "<a href='matiere.php?id=java'><img src='$imagePath2' alt='Image 2' class='img-projet' /></a>";
        } else {
            echo "Image non trouvée.";
        }

        // Récupérer le document contenant le chemin de l'image 3
        $imageDocument3 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bfa6f84bffbb675e774782')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument3) {
            // Récupérer le chemin de l'image
            $imagePath3 = "c.jpg";

            // Afficher l'image dans votre page HTML
            echo "<img src='$imagePath3' alt='Image 3' class='img-projet' />";
        } else {
            echo "Image non trouvée.";
        }
        // Récupérer le document contenant le chemin de l'image 3
        $imageDocument4 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bfa7084bffbb675e774783')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument4) {
            // Récupérer le chemin de l'image
            $imagePath4 = "mongo.jfif";

            // Afficher l'image dans votre page HTML
            echo "<a href='matiere.php?id=mongodb'><img src='$imagePath4' alt='Image 4' class='img-projet' /></a>";
        } else {
            echo "Image non trouvée.";
        } // Récupérer le document contenant le chemin de l'image 3
        $imageDocument5 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65c0b8711cb11940c3a8d2d5')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument5) {
            // Récupérer le chemin de l'image
            $imagePath5 = "python.jpg";

            // Afficher l'image dans votre page HTML
            echo "<a href='matiere.php?id=python'><img src='$imagePath5' alt='Image 4' class='img-projet' /></a>";
        } else {
            echo "Image non trouvée.";
        }
        // Récupérer le document contenant le chemin de l'image 3
        $imageDocument4 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bfa7084bffbb675e774783')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument4) {
            // Récupérer le chemin de l'image
            $imagePath4 = "mongo.jfif";

            // Afficher l'image dans votre page HTML
            echo "<img src='$imagePath4' alt='Image 4' class='img-projet' />";
        } else {
            echo "Image non trouvée.";
        }
        // Récupérer le document contenant le chemin de l'image 1
        $imageDocument1 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65bf95054bffbb675e77477c')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument1) {
            // Récupérer le chemin de l'image
            $imagePath1 = "ba.png";
            // Afficher l'image dans votre page HTML
            echo "<img src='$imagePath1' alt='Image 1' class='img-projet' />";
        } else {
            echo "Image non trouvée.";
        }
        // Récupérer le document contenant le chemin de l'image 1
        $imageDocument6 = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId('65c0b99f1cb11940c3a8d2d6')]);

        // Vérifier si le document a été trouvé
        if ($imageDocument6) {
            // Récupérer le chemin de l'image
            $imagePath6 = "noe4j.jpg";
            // Afficher l'image dans votre page HTML
            echo "<img src='$imagePath6' alt='Image 1' class='img-projet' />";
        } else {
            echo "Image non trouvée.";
        }
        ?>
    </div>
    <div class="center">
    </div>
    <div class="footer">
        <div class="content-footer">
            <div class="content-sociale">
                <p href="#" class="java" style="font-size: 20px; font-weight: 300; font-family: Georgia, 'Times New Roman', Times, serif;">Contacts :</p> <br>
                <p>Tel : +212-461-184-986</p>
                <p>Email: fso@oujda.com</p>
                <div class="social-img">
                    <p href="#" class="java" style="font-size: 20px; font-weight: 300; font-family: Georgia, 'Times New Roman', Times, serif;">Abonnez nous sur:</p> <br>
                    <img src="images/facebook (1).png" alt="" />
                    <img src="images/ii.png" alt="" />
                    <img src="images/tt.png" alt="" />
                    <img src="images/ll.png" alt="" />
                </div>
            </div>
            <br>
            <div class="content-about">
                <a href="#" class="java" style="font-size: 20px; font-weight: 300; font-family: Georgia, 'Times New Roman', Times, serif; color: aliceblue;">cours</a>
                <div class="about-show">
                    <p> Comme vous le savez de nos jours, nous voyons une <br>
                        transition énorme de l'utilisation des produits numériques <br>
                        de plus en plus dans notre vie. <br><br><br>
                    </p>
                </div>
                <a href="cours.php"><button class="voir-plus">Voir plus >></button></a>
            </div>
            <div class="content-contact">
                <p href="#" class="java" style="font-size: 20px; font-weight: 300; font-family: Georgia, 'Times New Roman', Times, serif;">Contactez-nous</p>
                <form action="includes/sentMessage.php" method="post">
                    <input type="text" name="sentEmail" placeholder="Adresse Email" class="email" /><br />
                    <input type="text" name="sentMessage" placeholder="Message..." class="message" /><br />
                    <button type="submit" name="sentMsg" value=<?= basename($_SERVER['PHP_SELF']); ?> class="envoyer">Envoyer</button>
                </form>
            </div>
        </div>
        <div class="bottom">
            &copy; FSO.com
        </div>
    </div>
</body>

</html>