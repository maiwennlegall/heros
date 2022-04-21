<?php require_once "includes/head.php"; ?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
        <br/> <br/><br/>
    <h1>Connexion</h1>

<div class="formulaire">
        <form method="post" action="traitement.php"> <!--changer le fichier dans action-->
        <input type="text"  name="login" placeholder="Entrez votre login" > <br/><br/>
        <input type="password"  name="mdp" placeholder="Entrez votre mot de passe" ><br/><br/>
        <input type="submit" name="se_connecter" id="se_connecter" value="Se connecter"/>            
</div>

    <?php require_once "includes/scripts.php"; ?>
</body>

