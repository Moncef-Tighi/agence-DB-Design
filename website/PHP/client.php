<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="../CSS/accueil.css" media="screen" type="text/css" />
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
    <form action="client.php" method="POST">
        <h1>Ajouter un nouveau client</h1>
        <label><b>Nom : </b></label>
        <input type="text" placeholder="Entrer le nom de famille du client" name="nom" required>

        <label><b>Prénom : </b></label>
        <input type="text" placeholder="Entrer le prénom du client" name="prenom" required>

        <label><b>Adresse email : </b></label>
        <input type="mail" placeholder="exemple@gmail.com" name="adresse_email" required>

        <label><b>date de naissance</b></label>
        <input type="date" placeholder="date de naissance" name="date_naissance" required>

        <label><b>type de client :</b></label>
        <input type="radio" name="client" value="locataire"><label>Locataire</label>
        <input type="radio" name="client" value="proprietaire"><label>Propriétaire</label>


        <input type="submit" id='submit' value='Confirmer' >


<?php
    if(isset($_POST["nom"]) && isset($_POST["prenom"])  && isset($_POST["client"])){
        $Date = date("Y-m-d", strtotime($_POST["date_naissance"]));

        if ($_POST["client"]=="locataire"){
            $SQL="INSERT INTO locataire (nom,prenom, adresse_email,date_naissance)
            VALUES (:nom,:prenom, :adresse_email,:date_naissance)";
        } else {
            $SQL="INSERT INTO proprietaire (nom,prenom, adresse_email,date_naissance)
            VALUES(:nom,:prenom, :adresse_email,:date_naissance)";
        }
        include("database_login.php");
        $db=connexion();
        $requete = $db->prepare($SQL);
        $requete->execute(array(
            ':nom' =>$_POST["nom"],
            ':prenom' =>$_POST["prenom"],
            ':adresse_email' => $_POST["adresse_email"],
            ':date_naissance' => $Date
        ));
        unset($_POST);
        header("Location: ".$_SERVER['PHP_SELF']."?confirm=1");
    }
    if (isset($_GET["confirm"])) {
        echo("<br><br>Le nouveau client a bien été ajouté");
    }
?>


    </form>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>