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
    <br/> <br/> <br/> <br/>
   
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
                else
                {
                    $poucentage_reussite=$tuple["nb_gagne"] / $tuple["nb_joue"] * 100; #vérifier les divisions entières
                    $pourcentage_mort = $tuple["nb_perdue"] / $tuple["nb_joue"] * 100;  
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