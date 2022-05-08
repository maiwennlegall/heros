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
    <div class="container" id="corps">
    <h1> Page administrateur </h1>
    
    <a href="creationhistoire.php" class="bouton">Créer une nouvelle histoire</a><br/><br/><br/>
    <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) 
            {
                ?>
                
                <div class="bloc_hist">
                    <em>  <?= $tuple["titre"] ?> </em> <!-- Titre de l'histoire -->
                    <p class="paragraphe"> <?=$tuple["resumer"] ?> </p>
                    <a href="modification.php?id=<?= $tuple["hist_id"] ?>" class="btn_admin gauche">  <!-- Modification -->
                        Modifier
                        <img src="includes/crayon.png" class="logo" alt="dessin de crayon">
                    </a> 
                     
                    <?php 
                    if($tuple["cache"]==0)
                    {?>
                        <a href="cacher.php?id=<?= $tuple["hist_id"] ?>" class="btn_admin gauche">  <!-- Cacher -->
                            Masquer
                            <img src="includes/closedeye.png" class="logo" alt="dessin d'oeil barré">
                        </a>  
                    
                    <?php
                    }
                    else if($tuple["cache"]==1)
                    {?>
                        <a href="afficher.php?id=<?= $tuple["hist_id"] ?>" class="btn_admin">  <!-- Rendre visible -->
                            Rendre visible
                            <img src="includes/eye.png" class="logo" alt="dessin d'oeil">  
                        </a>  
                    <?php
                    }?>
                    
                
                    
                    
                    <a href="statistiques.php?id=<?= $tuple["hist_id"] ?>" class="btn_admin droite">  <!-- Page statisqtiques -->
                        Statistiques
                        <img src="includes/charts.png" class="logo" alt="dessin de graphique" >
                    </a>   
                    <a href="suppression.php?id=<?= $tuple["hist_id"] ?>" class="btn_admin droite">
                        Supprimer
                        <img src="includes/poubelle.png" class="logo" alt="dessin de poubelle"> <!-- Supprimer -->
                    </a> <br/><br/>
                </div>
                
            
                <?php
            
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>