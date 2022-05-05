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

    <?php $res = $BDD->prepare('UPDATE partie SET etat_fin =1 WHERE id_utilisateur = :id and id_hist=:hist'); 
                $res->execute(array(
                "hist" => $_GET["hist"],
                "id" => $_SESSION["login"],
            )); ?>

    <div class="container" id="corps">
    <h1> Fin de votre histoire <h1>
    <?php
        if($_GET["perdu"]==true)
        {
            ?> <h2> Vous avez perdu... </h2>
            <?php
            if(isset($_GET["vie"]))
            {
                ?>
                <h3> Vous n'aviez plus aucune vie ! </h3>
                <?php
            }
        }
    ?>
    <h3> Récapitulatif de votre partie </h3>
    <div class="container">
        <?php
        $req = "SELECT * FROM historique_partie WHERE id_joueur=:joueur and id_hist=:hist";
        $reponse = $BDD -> prepare($req);
        $reponse ->execute(array(
            "joueur" => $_SESSION["login"],
            "hist" => $_GET["hist"],
            ));   
        $numero_ch=0;           
        while($tuple = $reponse->fetch()){
            $numero_ch = $numero_ch +1;
            ?>
                <h4> Chapitre n°<?=$numero_ch?> </h4>
                <div class="container">
                    <?= $tuple["text_chapitre"] ?>
                    <h5> Choix fait </h5>
                    <?= $tuple["text_choix_fait"] ?>
                </div>
            <?php
        }
        $requete = 'DELETE FROM historique_partie WHERE id_joueur=:joueur and id_hist=:hist';
        $response = $BDD->prepare($requete);
        $response->execute(array(
            "joueur" => $_SESSION["login"],
            "hist" => $_GET["hist"],
        ));
        ?>
    </div>

    </div>

</body>