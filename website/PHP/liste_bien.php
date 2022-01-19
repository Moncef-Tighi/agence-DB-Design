<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../CSS/liste_bien.css" media="screen" type="text/css" />
<?php

    include("../HTML/header.html");
?>
<body>

<div id="container">

    <?php
        include("database_login.php");
        $db=connexion();
        $SQL=utf8_encode("SELECT tarif_nuit, type, nom, prenom, surface, nombre_piece, src, bien_immobilier.id_bien
        FROM bien_immobilier
        INNER JOIN proprietaire ON proprietaire.id_proprietaire = bien_immobilier.id_proprietaire
        INNER JOIN type_bien ON type_bien.id_type= bien_immobilier.id_type
        INNER JOIN description ON description.id_bien= bien_immobilier.id_bien
        INNER JOIN images ON images.id_description = description.id_description
        GROUP BY nom");
        $requete = $db->prepare($SQL);
        $requete->execute();
        $data=$requete->fetchAll();
        foreach($data as $entry){
            echo("<div class='container'>
            <img src='".$entry["src"]."'>
            <ul>
                <li><b>Type : </b>".$entry["type"]. "</li>
                <li><b>Nombre de pièce : </b> ".$entry["nombre_piece"]. " </li>
                <li><b>Nom du propriétaire : </b>".$entry["nom"]. " </li>
                <li><b>Prénom : </b>".$entry["prenom"]. " </li>
                <li><b>Surface : </b>".$entry["surface"]. "m² </li>
                <li class='tarif'><b>tarif/nuit : </b>".$entry["tarif_nuit"]. " </li>
                <li> <a href='afficher_bien.php?id=".$entry["id_bien"]."' class='button'>Plus d'informations</a>
            </ul>
            </div>");
        }
    ?>

</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>