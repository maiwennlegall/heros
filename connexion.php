<?php require_once "includes/head.php";
require_once "includes/functions.php";
include("includes/connect.php"); 
session_start();

if (!empty($_POST['login']) and !empty($_POST['mdp'])) {
    $login = $_POST['login'];
    $password = $_POST['mdp'];
    $stmt = $BDD->prepare('select * from utilisateur where identifiant=? and mdp=?');
    $stmt->execute(array($login, $password));
    if ($stmt->rowCount() == 1) {
        // Authentication successful
        $_SESSION['login'] = $login;
        redirect("accueil.php");
    }
    else {
        $error = "Utilisateur non reconnu";
    }
}
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
        <br/> <br/><br/>
    <h1>Connexion</h1>
<?php if (isset($error)) { ?>
        <div class="alert alert-danger">
        <strong>Erreur !</strong> <?= $error ?>
        </div>
<?php } ?>
<div class="formulaire">
        <form method="post" action="connexion.php"> <!--changer le fichier dans action-->
        <input type="text"  name="login" placeholder="Entrez votre login" > <br/><br/>
        <input type="password"  name="mdp" placeholder="Entrez votre mot de passe" ><br/><br/>
        <input type="submit" name="se_connecter" id="se_connecter" value="Se connecter"/>            
</div>

    <?php require_once "includes/scripts.php"; ?>
</body>

