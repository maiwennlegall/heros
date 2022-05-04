<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<!doctype html>
<html>

<?php require_once "includes/head.php"; 

if(!empty($_POST["nom"])&&!empty($_POST["resume"]))
            {   
                $maReq = $BDD -> prepare("INSERT INTO histoire (titre, resumer) VALUES (:title, :resumer)");
                $maReq -> execute(array(
                    'title' => $_POST["nom"],
                    'resumer' => $_POST["resume"],
                ));


                $maReq = "SELECT identifiant FROM histoire WHERE titre=:title";
                $reponse = $BDD -> prepare($maReq);
                $reponse ->execute(array("title"=>$_POST["nom"]));
                $ligne = $reponse -> fetch($identifiant = $ligne["identifiant"]);
                ?> 
                <?php
                redirect("creationchapitre.php?debut=1&histoire=".$ligne['identifiant']);
            }
        ?>


<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="trophaut">
        
        <h1>Creation d'une histoire</h1> <br/> <br/>

        <div class="formulaire">
            <form method="POST" action="creationhistoire.php"> <!--changer le fichier dans action-->

            <label for="nom">Entrez le titre de votre histoire</label> <br/>
            <input type="varchar"  name="nom"> <br/><br/>

            <label for="resume">Entrez le resumé de votre histoire</label><br/>
            <input type="text"  name="resume"> <br/><br/>
            
            <button type="submit" class="btn btn-default btn-primary"> Envoyer </button>          
        </div>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>