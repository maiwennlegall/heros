<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>
!doctype html>
<html>

<?php require_once "includes/head.php"; ?>
<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="corps">
    <br/> <br/> <br/> <br/>
    <h1> Page administrateur </h1>
    </div>
    <a href="creationhistoire.php" class="bouton">Créer une nouvelle histoire</a>
    <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) {
                ?>

                <p>
                    <a href="modification.php?name=<?= $tuple["identifiant"] ?>">  <!-- Modification -->
                        <img src="includes/crayon.png" id="logo">
                    </a>
                    <img src="includes/eye.png" id="logo"> <!-- Cacher / Rendre visible -->
                    <?= $tuple["titre"] ?>  <!-- Titre de l'histoire -->
                    <a href="statistiques.php?name=<?= $tuple["identifiant"] ?>">  <!-- Page statisqtiques -->
                        <img src="includes/charts.png" id="logo">
                    </a>
                    <img src="includes/poubelle.png" id="logo"> <!-- Supprimer -->
                </p>
            
                <?php
            
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>