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
        $SQL=utf8_encode("SELECT date_debut, date_fin, nom, prenom, montant FROM reservation
        INNER JOIN locataire ON locataire.id_locataire = reservation.id_locataire
        INNER JOIN bien_immobilier ON bien_immobilier.id_bien = reservation.id_bien
        INNER JOIN prix_reel ON prix_reel.id_reservation = reservation.id_location
        INNER JOIN payement_complet ON payement_complet.id_prix = prix_reel.id_prix");
        $requete = $db->prepare($SQL);
        $requete->execute();
        $data=$requete->fetchAll();
        foreach($data as $entry){
            echo("<div class='container'>
            <ul>
                <li><b>Nom locataire : </b>".$entry["nom"]. "</li>
                <li><b>Prenom Locataire : </b> ".$entry["prenom"]. " </li>
                <li><b>date_début: </b>".$entry["date_debut"]. " </li>
                <li><b>date_fin : </b>".$entry["date_fin"]. " </li>
                <li><b>Coût de la location : </b>".$entry["montant"]. " DA</li>

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