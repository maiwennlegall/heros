<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<!doctype html>
<html>

<?php require_once "includes/head.php"; ?>


<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="trophaut">
        
        <h1>Creation d'un chapitre</h1>

        <div class="formulaire">
            <form method="post" action="creation.php"> <!--changer le fichier dans action-->

            <label for="resume">Texte de votre chapitre</label> <br/>
            <input type="text"  name="debut"> <br/><br/>

            <label for="resume">Choix n°1</label>
            <input type="text"  name="resume"> <br/><br/>

            <label for="resume">Choix n°2</label>
            <input type="text"  name="resume"> <br/><br/>

            <label for="resume">Choix n°3</label>
            <input type="text"  name="resume"> <br/><br/>
            
            <button type="submit" class="btn btn-default btn-primary"> Se connecter</button>            
        </div>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>