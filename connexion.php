<!doctype html>
<html lang="fr">
    
<?php require_once "includes/head.php";
require_once "includes/functions.php";
include("includes/connect.php"); 
?>


<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>

    <?php
    //On vérifie que le login et le mdp correspondent à un utilisateur de la base, sinon on affiche un message d'erreur.
    if (!empty($_POST['login']) and !empty($_POST['mdp'])) {
    $login = escape($_POST['login']);
    $password = escape($_POST['mdp']);
    $stmt = $BDD->prepare('SELECT COUNT(*) AS nb from utilisateur where id_joueur=? and mdp=?');
    $stmt->execute(array($login, $password));
    $line = $stmt ->fetch();
    if($line['nb']==1)
    {
        // Authentication successful
        $_SESSION['login'] = $login;
        redirect("index.php");
    }
    else {
        $error = "Utilisateur non reconnu";
    }
    } ?>
<div class="container" id="corps">
    <h1 class="text-center">Connexion</h1>
<?php if (isset($error)) { ?>
        <div class="alert alert-danger">
        <strong>Erreur !</strong> <?= $error ?>
        </div>
<?php } ?>

    <div class="text-center">
            <form method="post" action="connexion.php"> 
            <input type="text"  name="login" placeholder="Entrez votre login" > <br/><br/>
            <input type="password"  name="mdp" placeholder="Entrez votre mot de passe" ><br/><br/>
            <input type="submit" class="btn btn-default btn-primary btn-lg" name="se_connecter" id="se_connecter" value="Se connecter"/>            
    </div>
    <p class="text-center">Je n'ai pas de compte: <a class="btn btn-secondary" href="inscription.php" type="button">Créer un compte</a></p>
</div>
    <?php require_once "includes/scripts.php"; ?>
</body>
<html>

