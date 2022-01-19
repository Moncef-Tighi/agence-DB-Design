<!DOCTYPE html>
<html lang="fr">
<script defer src="../Javascript/slide_show.js"></script>
<script defer src="../Javascript/map.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css" />


<link rel="stylesheet" href="../CSS/afficher_bien.css" media="screen" type="text/css" />
<link rel="stylesheet" href="../CSS/liste_bien.css" media="screen" type="text/css" />

<?php

    include("../HTML/header.html");
?>
<body>

<div id="container">
    <div class="flex">
    <?php
        include("database_login.php");
        $db=connexion();
        $SQL=utf8_encode("SELECT tarif_nuit, type, nom, prenom, surface, nombre_piece, bien_immobilier.id_bien,
         description.id_description,longitude,latitude FROM bien_immobilier
        INNER JOIN proprietaire ON proprietaire.id_proprietaire = bien_immobilier.id_proprietaire
        INNER JOIN type_bien ON type_bien.id_type= bien_immobilier.id_type
        INNER JOIN description ON description.id_bien= bien_immobilier.id_bien
        WHERE :id = bien_immobilier.id_bien");
        $requete1 = $db->prepare($SQL);
        $requete1->bindValue(":id", $_GET["id"]);
        $requete1->execute();
        $data=$requete1->fetch();
        echo("<ul>
            <li><b>Type : </b>".$data["type"]. "</li>
            <li><b>Nombre de pièce : </b> ".$data["nombre_piece"]. " </li>
            <li><b>Nom du propriétaire : </b>".$data["nom"]. " </li>
            <li><b>Prénom : </b>".$data["prenom"]. " </li>
            <li><b>Surface : </b>".$data["surface"]. "m² </li>
            <li class='tarif'><b>tarif/nuit : </b>".$data["tarif_nuit"]. " </li>
        ");

        $SQL3="SELECT numero_maison, etage, quartier, wilaya.nom as wilaya, ville.nom as ville FROM adresse
        INNER JOIN wilaya ON wilaya.wilaya_id = adresse.wilaya_id
        INNER JOIN ville ON ville.ville_id = adresse.ville_id
        WHERE id_description=:id_description";
        $requete3 = $db->prepare($SQL3);
        $requete3->bindValue(":id_description", $data["id_description"]);
        $requete3->execute();
        $adresse=$requete3->fetch();
        echo("<li><b>Adresse complète : </b> ".$adresse["numero_maison"]." ".$adresse["quartier"]." ,"
        .$adresse["ville"]." , ".$adresse["wilaya"] .". etage : ". $adresse["etage"] . "</li>");


        echo("</ul>");
        $SQL2="SELECT src,description_image FROM images WHERE images.id_description=:id_description";
        $requete2 = $db->prepare($SQL2);
        $requete2->bindValue(":id_description", $data["id_description"]);
        $requete2->execute();
        $images=$requete2->fetchAll();
        $i=0;
        echo("<div class='slideshow_container'>");
        foreach($images as $image){
            $i+=1;
            echo('<img class="mySlides" id="number'.$i.'" src="'.$image["src"].'">');
        }
        echo('<button class="w3-button w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
        <button class="w3-button w3-display-right" onclick="plusDivs(+1)">&#10095;</button>
        </div>');


    ?>
    </div>
    <div class="fiches">
    <?php
            // Fiche d'équipements
        $SQL4="SELECT type_equipement FROM type_equipement
        INNER JOIN equipements ON equipements.id_type = type_equipement.id_type
        INNER JOIN description ON description.id_description = equipements.id_description
        WHERE description.id_description = :id_description";
        $requete4 = $db->prepare($SQL4);
        $requete4->bindValue(":id_description", $data["id_description"]);
        $requete4->execute();
        $fiche_equipement=$requete4->fetchAll();
        echo("<div><h2>Fiche d'équipement</h2>");
        echo("<table><th>Equipement</th>");
        foreach ($fiche_equipement as $equipement) {
            echo(utf8_encode("<tr><td>".$equipement["type_equipement"]."</td></tr>"));
        }
        echo("</table></div>");

        // Fiche de proximité
        $SQL5="SELECT distance, type_lieu FROM fiche_proximite
        INNER JOIN lieu_interet ON lieu_interet.id_type = fiche_proximite.id_type
        WHERE fiche_proximite.id_description= :id_description";
        $requete5 = $db->prepare($SQL5);
        $requete5->bindValue(":id_description", $data["id_description"]);
        $requete5->execute();
        $fiche_distance=$requete5->fetchAll();
        echo("<div><h2>Fiche de proximité</h2>");
        echo("<table><th>Lieu</th><th>distance</th>");
        foreach ($fiche_distance as $distance) {
            echo(utf8_encode("<tr><td>".$distance["type_lieu"]."</td>"));
            echo(utf8_encode("<td>".$distance["distance"]."</td></tr>"));

        }
        echo("</table></div>");

        // Fiche d'occupation
    
        $SQL6="SELECT reservation.date_debut, reservation.date_fin FROM description
        INNER JOIN reservation ON reservation.id_bien = description.id_bien
        WHERE description.id_description= :id_description
        ORDER BY date_debut";
        $requete6 = $db->prepare($SQL6);
        $requete6->bindValue(":id_description", $data["id_description"]);
        $requete6->execute();
        $fiche_occupation=$requete6->fetchAll();
        echo("<div><h2>Fiche d'occupation</h2>");
        echo("<table><th>Date de début</th><th>Date de fin</th>");
        foreach ($fiche_occupation as $date) {
            echo(utf8_encode("<tr><td>".$date["date_debut"]."</td>"));
            echo(utf8_encode("<td>".$date["date_fin"]."</td></tr>"));

        }
        echo("</table></div>");

    ?>

    </div>
    <?php
        echo("<span id='longitude'>".$data["longitude"]."</span>");
        echo("<span id='latitude'>".$data["latitude"]."</span>");
    ?>
    <div id="map"></div>
</div>
<?php
    include("../HTML/footer.html");
?>
</body>
</html>