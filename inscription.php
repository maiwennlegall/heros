<!doctype html>
<html lang="fr">

<?php 
    require_once "includes/head.php";
    include("includes/connect.php");
    require_once "includes/functions.php";
?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>
        <?php require_once "includes/head.php";
        $existe=false; 
        if(!empty($_POST["login"])&&!empty($_POST["mdp"]))
            {
                  
                //Vérification que le login n'est pas déjà utilisé

                $login = escape($_POST['login']);
                $password = escape($_POST['mdp']);
                $stmt = $BDD->query('SELECT id_joueur from utilisateur');
                while($tuple = $stmt->fetch()) 
                {
                    if($tuple['id_joueur']==$login)
                    {
                        $existe=true;
                    }
                }
                if($existe==false) //Insertion dans la table utilisateur du nouvel utilisateur si le login n'est pas déjà utilisé
                {
                    $maReq = $BDD -> prepare("INSERT INTO utilisateur (id_joueur, mdp) VALUES (:identifiant, :mdp)");
                    $maReq -> execute(array(
                    'identifiant' => $login,
                    'mdp' => $password,
                    ));
                    redirect("connexion.php");
                }
                
            }

                
            
        ?>

    </div>
<div class="container" id="corps">
    <h1 class="text-center">Inscription</h1>
    <?php
        if($existe==true) //Message d'erreur si le login est déjà utilisé
        { 
            $erreur = "Ce nom d'utilisateur est déjà utilisé"; 
            if (isset($erreur)) 
            { ?>
                    <div class="alert alert-danger">
                    <strong>Erreur !</strong> <?= $erreur ?> 
                    </div>
            <?php }           
         } ?>
<div class="text-center">
        <form method="post" action="inscription.php"> 
        <input type="text"  name="login" placeholder="Entrez un identifiant" > <br/><br/>
        <input type="password"  name="mdp" placeholder="Entrez un mot de passe" ><br/><br/>
        
        <input type="submit" class="btn btn-default btn-primary btn-lg" name="submit" id="submit" value="S'inscrire"/>            
</div>
<br/>
<p class="text-center"> J'ai déjà un compte: <a class="btn btn-secondary" href="connexion.php" type="button">Se connecter</a></p>
    <?php require_once "includes/scripts.php"; ?>
    
</div>
</body>
</html>