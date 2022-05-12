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
    
    <button type="button" class="bouton btn-lg" onClick="window.location.href='creationhistoire.php';">Créer une nouvelle histoire</button><br/><br/><br/>
    <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) 
            {
                ?>
                
                <div class="bloc_hist">
                    <em>  <?= $tuple["titre"] ?> </em> <!-- Titre de l'histoire -->
                    <p class="paragraphe"> <?=$tuple["resumer"] ?> </p>
                <div class="row">
                    <div class="col-m">
                    <button type="button" class="btn_admin" onClick="window.location.href='modification.php?id=<?= $tuple["hist_id"] ?>';">
                        Modifier
                        <img src="includes/crayon.png" class="logo" alt="dessin de crayon"> <!-- Modification -->
                    </button>
                    </div>
                    <div class="col-m">
                    <?php 
                    if($tuple["cache"]==0)
                    {?>
                        <button type="button" class="btn_admin" onClick="window.location.href='cacher.php?id=<?= $tuple["hist_id"] ?>';">
                            Masquer
                            <img src="includes/closedeye.png" class="logo" alt="dessin d'oeil barré"> <!-- Cacher -->
                        </button>
                    
                    <?php
                    }
                    else if($tuple["cache"]==1)
                    {?>
                        <button type="button" class="btn_admin" onClick="window.location.href='afficher.php?id=<?= $tuple["hist_id"] ?>';">
                            Rendre visible
                            <img src="includes/eye.png" class="logo" alt="dessin d'oeil">  <!-- Rendre visible -->
                        </button>  
                    <?php
                    }?>
                    </div>
                    
                    <div class="col-m">
                    <button type="button" class="btn_admin" onClick="window.location.href='afficher.php?id=statistiques.php?id=<?= $tuple["hist_id"] ?>';"> 
                        Statistiques
                        <img src="includes/charts.png" class="logo" alt="dessin de graphique" ><!-- Page statisqtiques -->
                    </button>   
                    </div>
                    <div class="col-m">
                    <button class="btn_admin" onclick="Suppression(<?=$tuple['hist_id']?>)">
                        Supprimer
                        <img src="includes/poubelle.png" class="logo" alt="dessin de poubelle"> <!-- Supprimer -->
                    </button> 
                    </div>
                    <br/><br/>
                </div>
                
            
                <?php
            
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>