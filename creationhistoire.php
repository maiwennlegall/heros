<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<!doctype html>
<html>

<?php require_once "includes/head.php"; 

if(!empty($_POST["nom"])&&!empty($_POST["resume"])&&!empty($_POST["vie"]))
            {   $maReq = $BDD -> query("SELECT COUNT(hist_id) as nb FROM histoire");
                $data = $maReq->fetch();
                echo $data['nb'];
                $nb = $data['nb'];
                $nb = $nb+1;

                $maReq = $BDD -> prepare("INSERT INTO histoire (hist_id, titre, resumer, nb_vie_dbt) VALUES (:id, :title, :resumer, :nbvie)");
                $maReq -> execute(array(
                    'id' => $nb,
                    'title' => $_POST["nom"],
                    'resumer' => $_POST["resume"],
                    'nbvie' => $_POST["vie"],
                ));
                redirect("creationchapitre.php?debut=1&histoire=".$nb);
            }
        ?>


<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="trophaut">
        
        <h1>Creation d'une histoire</h1>

        <div class="formulaire">
            <form method="POST" action="creationhistoire.php"> <!--changer le fichier dans action-->

            <label for="nom">Entrez le titre de votre histoire</label> <br/>
            <input type="varchar"  name="nom"> <br/><br/>

            <label for="resume">Entrez le resumé de votre histoire</label><br/>
            <input type="text"  name="resume"> <br/><br/>

            <label for="vie">Combien de vie aura le personnage au début de l'histoire</label><br/>
            <input type="text"  name="vie"> <br/><br/>
            
            <button type="submit" class="btn btn-default btn-primary btn-lg"> Envoyer </button>          
        </div>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>