<!DOCTYPE html>
<html lang="fr">
<?php
    include("../HTML/header.html");
?>
<body>

<div id="container">
    <?php
        if ($autorisastion!=1 && $autorisastion!=2) {
            session_destroy();
            header('Location: ../../index.php');
        }
    ?>

    <form action="" method="POST">
        <h1>Programmer une visite</h1>

        <label><b>date de la visite</b></label>
        <input type="date" placeholder="date de visite" name="date_visite">

        <label><b>Locataire souhaitant effectuer une visite : </b></label>
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

        <label><b>Agent organisant la visite : </b></label>
        <select name="id_agent">
            <?php
                $SQL="SELECT nom, prenom FROM agent_location";
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

        <label><b>Appartement à visiter : </b></label>

        <select name="id_bien">
            <?php
                $SQL="SELECT id_bien,tarif_nuit FROM bien_immobilier";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                $i=0;
                foreach($data as $value){
                    $i+=1;
                    echo("<option value='".$value["id_bien"]."'>Bien : ".$value["id_bien"]." tarif/nuit : ".$value["tarif_nuit"]."</option>");
                }        

            ?>
        </select>



        <input type="submit" id='submit' value='Confirmer' >



<?php


    if(isset($_POST["id_locataire"]) && isset($_POST["date_visite"])  && isset($_POST["id_bien"])){
        $Date = date("Y-m-d", strtotime($_POST["date_visite"]));

        $SQL="INSERT INTO visite(date_visite, id_locataire, id_employe, id_bien)
        VALUES (:date_visite, :id_locataire, :id_employe, :id_bien)";
        $requete = $db->prepare($SQL);
        $requete->execute(array(
            ':date_visite' =>$Date,
            ':id_locataire' =>$_POST["id_locataire"],
            ':id_employe' => $_POST["id_employe"],
            ':id_bien' => $_POST["id_bien"]
        ));    
                
        $SQL2 = "INSERT INTO bon_visite(fin_validite, id_visite)
        SELECT :fin_validite,id_visite FROM visite ORDER BY id_visite DESC LIMIT 1";
        $requete = $db->prepare($SQL2);
        $time = strtotime($Date);
        $final = date("Y-m-d", strtotime("+1 month", $time));
        echo $final;
        $requete->bindValue(":fin_validite", $final );
        $requete->execute();
        unset($_POST);
        header("Location: ".$_SERVER['PHP_SELF']."?confirm=1");
    }
    if (isset($_GET["confirm"])) {
        echo("<br><br>La nouvelle visite a bien été programmée");
        $db=connexion();

        $SQL3="SELECT fin_validite FROM bon_visite ORDER BY id_bon DESC LIMIT 1";
        $requete = $db->prepare($SQL3);
        $requete->execute();
        $data=$requete->fetch();
        echo("<p>Attention ! Le client doit signer un bon de visite qui sera valide jusqu'au : ".$data["fin_validite"]."</p>");
    }

    
?>




    </form>
</div>


<?php
    include("../HTML/footer.html");
?>
</body>
</html>