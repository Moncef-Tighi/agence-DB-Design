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
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Ajouter un nouveau bien immobilier</h1>
        <label><b>tarif/nuit : </b></label>
        <input type="text" placeholder="Coût de location par nuit" name="tarif_nuit" required>

        <label><b>Acte de propriété : (opetionnel pour l'instant)</b></label>
        <input type="file" placeholder="Scan de l'acte de propriété" name="acte_propriete">

        <label><b>Longitude (optionnel) : </b></label>
        <input type="text" placeholder="7.00" name="longitude">

        <label><b>latitude (optionnel)</b></label>
        <input type="text" placeholder="36.00" name="latitude">

        <label><b>propriétaire</b></label>
        <select name="id_proprietaire">
            <?php
                include("database_login.php");
                $db=connexion();
                $SQL="SELECT id_proprietaire, nom, prenom FROM proprietaire";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo("<option value='".$value["id_proprietaire"]."'>".$value["nom"]." ".$value["prenom"]."</option>");
                }        

            ?>
        </select>


        <label><b>bien immobilier à réserver</b></label>
        <select name="id_type">
            <?php
                $SQL="SELECT id_type,type FROM type_bien";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo("<option value='".$value["id_type"]."'>Type : ".$value["type"]."</option>");
                }        

            ?>
        </select>


        <input type="submit" id='submit' value='Confirmer' >



        <?php
    if(isset($_POST["tarif_nuit"]) && isset($_POST["id_proprietaire"]) && isset($_POST["id_type"]) ){

        $SQL="INSERT INTO bien_immobilier (tarif_nuit,longitude,latitude,id_type,id_proprietaire)
        VALUES  (:tarif_nuit,:longitude,:latitude,:id_type,:id_proprietaire)";

        $db=connexion();
        $requete = $db->prepare($SQL);
        $requete->execute(array(
            ':tarif_nuit' =>$_POST["tarif_nuit"],
            ':longitude' =>$_POST["longitude"],
            ':latitude' => $_POST["latitude"],
            ':id_type' => $_POST["id_type"],
            ':id_proprietaire' => $_POST["id_proprietaire"]
        ));    
        unset($_POST);
        header("Location: ".$_SERVER['PHP_SELF']."?confirm=1");
    }
    if (isset($_GET["confirm"])) {
        echo("<br><br>La nouvelle propriété a bien été ajouté");
    }
?>


    </form>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>