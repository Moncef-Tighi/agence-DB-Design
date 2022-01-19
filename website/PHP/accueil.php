<!DOCTYPE html>
<html>
<link rel="stylesheet" href="../CSS/accueil.css" media="screen" type="text/css" />
<?php
    include("../HTML/header.html");
?>
<body>

<div id="container">
    <?php
        if ($autorisastion==1 || $autorisastion==3) {
            echo('<a href="réception.php" class="button">Organiser une réception</a>');
            echo('<a href="réservation.php" class="button">Ajouter une réservation</a>');
            echo('<a href="client.php" class="button">Ajouter un nouveau client</a>');
            echo('<a href="bien.php" class="button">Ajouter un nouveau bien</a>');
        }
        if ($autorisastion==1 || $autorisastion==2) {
            echo('<a href="description.php" class="button">Ajouter une description</a>');
            echo('<a href="visite.php" class="button">Organiser une visite</a>');
        }
        echo('<a href="liste_bien.php" class="button">Liste complète des biens</a>');
        echo('<a href="liste_réservation.php" class="button">Liste réservation</a>');
    ?>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>