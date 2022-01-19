<!DOCTYPE html>
<html lang="fr">
    
<?php
    include("../HTML/header.html");
?>
<body>

<div id="container">
    <?php
        if ($autorisastion!=1 && $autorisastion!=3) {
            session_destroy();
            header('Location: ../../index.php');
        }
    ?>
    <form action="facturation.php" method="POST">
        <h1>Ajouter une réservation</h1>

        <label><b>Début de réservation</b></label>
        <input type="date" placeholder="Début" name="date_debut" required>

        <label><b>Fin de réservation</b></label>
        <input type="date" placeholder="fin" name="date_fin" required>

        <label><b>Locataire</b></label>
        <select name="locatairs">
            <?php
                include("database_login.php");
                $db=connexion();
                $SQL="SELECT id_locataire, nom, prenom FROM locataire";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo("<option value='".$value["id_locataire"]."'>".$value["nom"]." ".$value["prenom"]."</option>");
                }        

            ?>
        </select>


        <label><b>bien immobilier à réserver</b></label>
        <select name="biens">
            <?php
                $SQL="SELECT id_bien,tarif_nuit FROM bien_immobilier";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo("<option value='".$value["id_bien"]."'>Bien : ".$value["id_bien"]." tarif/nuit : ".$value["tarif_nuit"]."</option>");
                }        

            ?>
        </select>

        <input type="submit" id='submit' value='Confirmer' >

    </form>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>