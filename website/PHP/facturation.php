<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../CSS/accueil.css" media="screen" type="text/css" />
<?php
    include("../HTML/header.html");
?>
<body>

<style>
    .green{
        background-color:green!important;
    }
    .red {
        background-color:red!important;
    }
</style>
 
<div id="container">
    <div id="facture">
<?php

    include("database_login.php");
    $db=connexion(); 
             
    $SQL=" SELECT date_debut,date_fin FROM reservation
    WHERE reservation.id_bien=:id_bien
    AND date_debut BETWEEN :date_debut AND :date_fin
    OR date_fin BETWEEN :date_debut AND :date_fin 
    OR :date_debut BETWEEN date_debut AND date_fin
    LIMIT 1";
              
    $requete = $db->prepare($SQL);
    $requete->bindValue(":id_bien", $_POST["biens"]);
    $requete->bindValue(":date_debut", $_POST["date_debut"]);
    $requete->bindValue(":date_fin", $_POST["date_fin"]);

    $requete->execute();
    $result=$requete->fetch();

    $current_date=date('Y/m/d', time());

    if (!empty($result)){
        print_r($result);
        echo("<div><b>Erreur!</b>
        <p>Impossible d'effectuer la réservation parce que l'appartement est déjà réservé
        du : <b>".$result["date_debut"]."</b> Au <b>".$result["date_fin"]."</b>.
        <br><br><a href='réservation.php' class='red button'>revenir en arrière...</a></div>");
    } else if($_POST["date_debut"]<$current_date) {
        echo("<div><b>Erreur!</b>
        <p>La date de début  de la réservation est inférieur à la date actuelle, veuillez corriger cette erreur.</p>
        <br><br><a href='réservation.php' class='red button'>revenir en arrière...</a></div>");

    } else if ($_POST["date_debut"]>$_POST["date_fin"]){
        echo("<div><b>Erreur!</b>
        <p>La date de début est supérieure à la date de fin, veuillez corriger cette erreur.</p>
        <br><br><a href='réservation.php' class='red button'>revenir en arrière...</a></div>");
    }
    else {
        $SQL2="SELECT id_bien,tarif_nuit, tarif_saison FROM bien_immobilier, saison
        WHERE saison.debut_saison<=:date_debut
          AND  saison.fin_saison>=:date_debut
        AND id_bien=:id_bien
        LIMIT 1";
    
        $number_of_days = date_diff(date_create($_POST["date_debut"]), date_create($_POST["date_fin"]))->format('%R%a');
    
        $requete = $db->prepare($SQL2);
        $requete->bindValue(":id_bien", $_POST["biens"]);
        $requete->bindValue(":date_debut", $_POST["date_debut"]);
        $requete->execute();
        $prix_infos=$requete->fetch();
    
    
        
        $prix_hors_frais=$number_of_days*$prix_infos["tarif_nuit"];
        $frais_agence=$prix_hors_frais*0.1;
        $tarif_saison=$prix_hors_frais*$prix_infos["tarif_saison"];
        $prix_total=$prix_hors_frais+$frais_agence+$tarif_saison;
    
        echo("Facture : <ul>");
        echo("<li>  Prix hors frais : " .$prix_hors_frais." DA</li>");
        echo("<li>+ Frais de l'agence : " .$frais_agence." DA</li>");
        echo("<li>+ Tarif de saison : " .$tarif_saison." DA</li>");
        echo("<li>= Prix total : " .$prix_total." DA</li></ul>");
    
        $distante_reservation = date_diff(date_create(date('Y-m-d')), date_create($_POST["date_debut"]))->format('%R%a');
    
        if ($distante_reservation>=90){
            $prix_avance=$prix_total*0.3;
            echo("<b>Attention !</b> <p>C'est une réservation distance (Parce que la location commence dans 90 jours ou plus)</p>
            <p>Le client doit verser 30% du prix total de la location à l'avance avant de pouvoir signer le contrat.
            Ce qui équivaut à : ".$prix_avance." DA</p>");
        }

        echo("<a href='réservation.php' class='green button'>Confimer</a>");
        echo("<a href='réservation.php' class='red button'>Annuler</a>");

    }


?>
    </div>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>



