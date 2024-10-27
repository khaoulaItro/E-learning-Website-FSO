<?php

// Encoder le contenu binaire de l'image OIP.jfif en base64
$image_base64 = base64_encode(file_get_contents('C:\\xampp\\htdocs\\E-learning-Website-FSO\\images\\OIP.jfif'));

echo $image_base64;
