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
    
    <a href="creationhistoire.php" class="bouton">Créer une nouvelle histoire</a><br/><br/><br/>
    <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) 
            {
                ?>

                <p class='titre'>
                    <a href="modification.php?id=<?= $tuple["identifiant"] ?>">  <!-- Modification -->
                        <img src="includes/crayon.png" id="logo">
                    </a> 
                    
                    <?php 
                    if($tuple["cache"]==0)
                    {?>
                        <a href="cacher.php?id=<?= $tuple["identifiant"] ?>">  <!-- Cacher -->
                            <img src="includes/closedeye.png" id="logo">
                        </a> 
                    
                    <?php
                    }
                    else if($tuple["cache"]==1)
                    {?>
                        <a href="afficher.php?id=<?= $tuple["identifiant"] ?>">  <!-- Rendre visible -->
                            <img src="includes/eye.png" id="logo">  
                        </a> 
                    <?php
                    }?>
                    
                
                    <?= $tuple["titre"] ?> <!-- Titre de l'histoire -->
                    
                    <a href="statistiques.php?id=<?= $tuple["identifiant"] ?>">  <!-- Page statisqtiques -->
                        <img src="includes/charts.png" id="logo">
                    </a>  
                    <a href="suppression.php?id=<?= $tuple["identifiant"] ?>">
                        <img src="includes/poubelle.png" id="logo"> <!-- Supprimer -->
                    </a>
                </p>
            
                <?php
            
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>