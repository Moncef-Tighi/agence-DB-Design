<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    include("database_login.php");
    $db=connexion();

    $username = $_POST['username'];
    $password= $_POST['password'];
    $mot_de_passe=hash('sha256', $username.$password);
    if($username !== "" && $mot_de_passe !== "")
    {
        $sql = "SELECT identifiant,mot_de_passe,poste FROM employe
        WHERE identifiant = :username AND mot_de_passe = :mot_de_passe ";
        $requete = $db->prepare($sql);
        $requete->bindValue(":username", $username);
        $requete->bindValue(":mot_de_passe", $mot_de_passe);
        $requete->execute();
        $data=$requete->fetch();
        $count=count($data);
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           session_start();
           $_SESSION['username'] = $username;
           $_SESSION['poste'] = $data["poste"];
           header('Location: accueil.php');
        }
        else
        {
           header('Location: ../../index.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: ../../index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: ../../index.php');
}
?>
