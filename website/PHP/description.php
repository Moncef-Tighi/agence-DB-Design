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
    <form action="description.php" method="POST">
        <h1>Ajouter une description</h1>

        <label><b>Description du bien immobilier numéro : </b></label>
        <select name="id_bien">
            <?php
                include("database_login.php");
                $db=connexion();            
                $SQL="SELECT id_bien,tarif_nuit FROM bien_immobilier";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo(utf8_encode("<option value='".$value["id_bien"]."'>Bien : ".$value["id_bien"]." tarif/nuit : ".$value["tarif_nuit"]."</option>"));
                }        

            ?>
        </select>
        
        <label><b>Surface en mètre carré</b></label>
        <input type="text"  name="surface" required>

        <label><b>Nombre de pièce</b></label>
        <input type="text" name="nombre_piece">

        <label><b>numéro de la maison</b></label>
        <input type="text" name="numero_maison">

        <label><b>Nom du quartier</b></label>
        <input type="text" name="quartier" required>

        <label><b>étage</b></label>
        <input type="text" placeholder="0" name="etage" required>
        
        <label><b>Wilaya</b></label>
        <select name="wilaya_id">
            <?php
                $SQL="SELECT wilaya_id,nom FROM wilaya";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo(utf8_encode("<option value='".$value["wilaya_id"]."'>".$value["nom"]."</option>"));
                }        

            ?>
        </select>


        <label><b>Ville</b></label>
        <select name="ville_id">
            <?php
                $SQL="SELECT ville_id,nom FROM ville";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                $i=0;
                foreach($data as $value){
                    $i+=1;
                    echo(utf8_encode("<option value='".$value["ville_id"]."'>".$value["nom"]."</option>"));
                }        

            ?>
        </select>

        <label><b>Fiche de proximité : </b></label>
        <select name="lieu_interet">
            <?php
                $SQL="SELECT id_type, type_lieu FROM lieu_interet";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo(utf8_encode("<option value='".$value["id_type"]."'>".$value["type_lieu"]."</option>"));
                }        

            ?>
        </select>
        <input type="text" placeholder="distance en KM" name="distance" required>

        <label><b>équipements disponibles : </b></label>
        <select name="id_equipement">
            <?php
                $SQL="SELECT id_type, type_equipement FROM type_equipement";
                $requete = $db->prepare($SQL);
                $requete->execute();
                $data=$requete->fetchAll();
                foreach($data as $value){
                    echo(utf8_encode("<option value='".$value["id_type"]."'>".$value["type_equipement"]."</option>"));
                }        

            ?>
        </select>

        <label><b>Lien de l'image</b></label>
        <input type="text"  name="src" placeholder="../bien/image.png" required>

        <label><b>Description de l'image</b></label>
        <textarea name="description_image" rows="8"></textarea>



        <input type="submit" id='submit' value='Confirmer' >





<?php
    if(isset($_POST["id_bien"]) && isset($_POST["surface"])  && isset($_POST["numero_maison"]) && isset($_POST["distance"]))
    {
        $SQL="INSERT INTO description(surface, nombre_piece, id_bien)
        VALUES (:surface, :nombre_piece, :id_bien)";
        $requete = $db->prepare($SQL);
        $requete->execute(array(
                ':nombre_piece' =>$_POST["nombre_piece"],
                ':surface' => $_POST["surface"],
                ':id_bien' => $_POST["id_bien"]
            ));   
        $SQL2="INSERT INTO adresse(numero_maison, etage, quartier, wilaya_id, ville_id, id_description)
        SELECT :numero_maison, :etage, :quartier, :wilaya_id, :ville_id, id_description 
        FROM description ORDER BY id_description DESC LIMIT 1";
        $requete = $db->prepare($SQL2);
        $requete->execute(array(
                ':numero_maison' =>$_POST["numero_maison"],
                ':etage' => $_POST["etage"],
                ':quartier' => $_POST["quartier"],
                ':wilaya_id' => $_POST["wilaya_id"],
                ':ville_id' => $_POST["ville_id"]

        ));   
        $SQL3="INSERT INTO fiche_proximite(distance, id_description, id_type)
            SELECT :distance,:id_type, id_description 
            FROM description ORDER BY id_description DESC LIMIT 1";
        $requete = $db->prepare($SQL3);
        $requete->execute(array(
            ':distance' =>$_POST["distance"],
            ':id_type' => $_POST["lieu_interet"],
            ));   
                    
        $SQL4="INSERT INTO equipements( id_type, id_description)
        SELECT :id_type, id_description 
        FROM description ORDER BY id_description DESC LIMIT 1";
        $requete = $db->prepare($SQL4);
        $requete->execute(array(
            ':id_type' => $_POST["id_equipement"],
        )); 
        $SQL5="INSERT INTO images(src, description_image, id_description)
        SELECT :src, :description_image, id_description 
        FROM description ORDER BY id_description DESC LIMIT 1";
        $requete = $db->prepare($SQL5);
        $requete->execute(array(
            ':src' =>$_POST["src"],
            ':description_image' => $_POST["description_image"],
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