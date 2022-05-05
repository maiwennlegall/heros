<?php 
    require_once "includes/head.php";
    include("includes/connect.php");
    require_once "includes/functions.php";
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>
        <?php require_once "includes/head.php"; 

        if(!empty($_POST["login"])&&!empty($_POST["mdp"]))
            {   
                $maReq = $BDD -> prepare("INSERT INTO utilisateur (id_joueur, mdp) VALUES (:identifiant, :mdp)");
                $maReq -> execute(array(
                    'identifiant' => $_POST["login"],
                    'mdp' => $_POST["mdp"],
                ));
                redirect("connexion.php");
            }
        ?>

    </div>
        <br/> <br/><br/>
    <h1 class="text-center">Inscription</h1>

<div class="text-center">
        <form method="post" action="inscription.php"> <!--changer le fichier dans action-->
        <input type="text"  name="login" placeholder="Entrez un identifiant" > <br/><br/>
        <input type="password"  name="mdp" placeholder="Entrez un mot de passe" ><br/><br/>
        <input type="submit" name="s_inscrire" id="s_inscrire" value="S'inscrire"/>            
</div>
<p class="text-center"> J'ai déjà un compte: <a href="connexion.php">Se connecter</a></p>
    <?php require_once "includes/scripts.php"; ?>
</body>