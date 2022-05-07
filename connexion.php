<?php require_once "includes/head.php";
require_once "includes/functions.php";
include("includes/connect.php"); 
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>

    <?php
    if (!empty($_POST['login']) and !empty($_POST['mdp'])) {
    $login = $_POST['login'];
    $password = $_POST['mdp'];
    $stmt = $BDD->prepare('select * from utilisateur where id_joueur=? and mdp=?');
    $stmt->execute(array($login, $password));
        if ($stmt->rowCount() == 1) {
            // Authentication successful
            $_SESSION['login'] = $login;
            redirect("index.php");
        }
        else {
            $error = "Utilisateur non reconnu";
        }
    } ?>

        <br/> <br/><br/>
    <h1 class="text-center">Connexion</h1>
<?php if (isset($error)) { ?>
        <div class="alert alert-danger">
        <strong>Erreur !</strong> <?= $error ?>
        </div>
<?php } ?>
<div class="text-center">
        <form method="post" action="connexion.php"> <!--changer le fichier dans action-->
        <input type="text"  name="login" placeholder="Entrez votre login" > <br/><br/>
        <input type="password"  name="mdp" placeholder="Entrez votre mot de passe" ><br/><br/>
        <input type="submit" name="se_connecter" id="se_connecter" value="Se connecter"/>            
</div>
<p class="text-center">Je n'ai pas de compte: <a href="inscription.php">Créer un compte</a></p>
    <?php require_once "includes/scripts.php"; ?>
</body>

