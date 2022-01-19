<!DOCTYPE html>
<html lang="fr">
<?php
    include("../HTML/header.html");
?>
<script defer src="../Javascript/reception.js"></script>
<body>

<div id="container">
    <?php
        if ($autorisastion!=1 && $autorisastion!=3) {
            session_destroy();
            header('Location: ../../index.php');
        }
    ?>
    <form action="" method="POST">
        <h1>Programmer une réception</h1>
        <label><b>Date de la réception : </b></label>
        <input type="date" placeholder="date de la réception" name="date_reception" required>

        <label><b>Commentaire de l'assistant : </b></label>
        <textarea name="commentaire_assistant" rows="8"></textarea>

        <label><b>type de client :</b></label>
        <input type="radio" name="client" value="locataire"><label>Locataire</label>
        <input type="radio" name="client" value="proprietaire"><label>Propriétaire</label>

        <p id="locataire"><b>Locataire</b>
            <select name="id_locataire">
                <?php
                    include("database_login.php");
                    $db=connexion();
                    $SQL="SELECT nom, prenom FROM locataire";
                    $requete = $db->prepare($SQL);
                    $requete->execute();
                    $data=$requete->fetchAll();
                    $i=0;
                    foreach($data as $value){
                        $i+=1;
                        echo("<option value='".$i."'>".$value["nom"]." ".$value["prenom"]."</option>");
                    }        

                ?>
            </select>
        </p>
        <p id="propriétaire"><b>propriétaire</b>
            <select name="id_proprietaire">
                <?php
                    $SQL="SELECT nom, prenom FROM proprietaire";
                    $requete = $db->prepare($SQL);
                    $requete->execute();
                    $data=$requete->fetchAll();
                    $i=0;
                    foreach($data as $value){
                        $i+=1;
                        echo("<option value='".$i."'>".$value["nom"]." ".$value["prenom"]."</option>");
                    }        

                ?>
            </select>
        </p>


        <input type="submit" id='submit' value='Confirmer' >



<?php
    if(isset($_POST["date_reception"]) && isset($_POST["client"]) ){
        $Date = date("Y-m-d", strtotime($_POST["date_reception"]));

        if ($_POST["client"]=="locataire"){
            $SQL="INSERT INTO reception (date_reception, commentaire_assistant, id_locataire, id_proprietaire)
            VALUES (:date_reception, :commentaire_assitant,:id_locataire, null)";
        } else {
            $SQL="INSERT INTO reception (date_reception, commentaire_assistant, id_locataire, id_proprietaire)
            VALUES (:date_reception, :commentaire_assitant,null, :id_proprietaire)";
        }
        $db=connexion();
        $requete = $db->prepare($SQL);
        if ($_POST["client"]=="locataire"){
            $requete->execute(array(
                ':date_reception' =>$Date,
                ':commentaire_assitant' =>$_POST["commentaire_assistant"],
                ':id_locataire' => $_POST["id_locataire"]
            ));    
        } else {
            $requete->execute(array(
                ':date_reception' =>$Date,
                ':commentaire_assitant' =>$_POST["commentaire_assistant"],
                ':id_proprietaire' => $_POST["id_proprietaire"]
            ));    
        }

        unset($_POST);
        header("Location: ".$_SERVER['PHP_SELF']."?confirm=1");
    }
    if (isset($_GET["confirm"])) {
        echo("<br><br>La réception a bien été enregistré");
    }
?>


</form>
</div>




<?php
    include("../HTML/footer.html");
?>
</body>
</html>