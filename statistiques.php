<!doctype html>
<html lang="fr">
    
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<?php require_once "includes/head.php"; ?>
<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="corps">
   
    <?php
        if(isset($_GET['id'])) 
        {
            $maReq = "SELECT * FROM histoire WHERE hist_id=:idhistoire";
            $response = $BDD->prepare($maReq);
            $response->execute(array('idhistoire' => $_GET['id']));
            while($tuple = $response->fetch())
            { 
            ?>
                <h1> Statistiques sur l'histoire: <?= $tuple["titre"] ?></h1>
                <?php
                if($tuple["nb_joue"]==0)
                {?>
                    <p>Cette histoire n'a jamais été jouée!</p>
                <?php
                }
                else //si l'histoire a été jouée au moins une fois
                {
                    //calcul des statistiques
                    $poucentage_reussite=$tuple["nb_gagne"] / $tuple["nb_joue"] * 100; 
                    $pourcentage_mort = $tuple["nb_perdue"] / $tuple["nb_joue"] * 100;  
                    $poucentage_reussite = number_format($poucentage_reussite,2);
                    $pourcentage_mort = number_format($pourcentage_mort,2);
                ?>
                    <p>L'histoire a été jouée <?=$tuple["nb_joue"]?> fois. <br/>
                    Le pourcentage de réussite est de <?=$poucentage_reussite?>%. <br/>
                    Le pourcentage de morts est de <?=$pourcentage_mort?>%.</p>
                <?php
                }
        
            }   
               
        }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>