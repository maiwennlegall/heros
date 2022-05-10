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
    <h1> Fin de votre histoire <h1>
    <?php
        if($_GET["perdu"]==1)
        {
            ?> <h2> Vous avez perdu... </h2>
            <?php
            if(isset($_GET["vie"]))
            {
                ?>
                <h3> Vous n'aviez plus aucune vie ! </h3>
                <?php
            }

            $req = "SELECT nb_perdue FROM histoire WHERE hist_id=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $nbperdue = $reponse -> fetch();
            $newnbperdue = $nbperdue["nb_perdue"] + 1;

            $requete = $BDD->prepare('UPDATE histoire SET nb_perdue=:newnb_perdue WHERE hist_id=:idhistoire');
            $requete->execute(array('newnb_perdue' => $newnbperdue,'idhistoire'=> $_GET["hist"]));
            
        }
        else
        {
            ?><h2> BRAVO! Vous avez gagné ! </h2>
            <?php
            $req = "SELECT nb_gagne FROM histoire WHERE hist_id=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $nbgagne = $reponse -> fetch();
            $newnbgagne = $nbgagne["nb_gagne"] + 1;

            $requete = $BDD->prepare('UPDATE histoire SET nb_gagne=:newnb_gagne WHERE hist_id=:idhistoire');
            $requete->execute(array('newnb_gagne' => $newnbgagne,'idhistoire'=> $_GET["hist"]));
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
            <hr/>
                <div class="container recap_chap" id="recap_chap">
                <h4 class="fin_hist"> Chapitre n°<?=$numero_ch?> </h4>
                
                    <?php echo $tuple["text_chapitre"] ;
                    if($tuple["text_choix_fait"]!="NULL")
                    { ?>
                        <h5> Choix fait </h5>
                     <?php echo $tuple["text_choix_fait"] ;
                    }
                    ?>
                </div>
                
            <?php
        }
        $requete = 'DELETE FROM historique_partie WHERE id_joueur=:joueur and id_hist=:hist';
        $response = $BDD->prepare($requete);
        $response->execute(array(
            "joueur" => $_SESSION["login"],
            "hist" => $_GET["hist"],
        ));

        $requete = 'DELETE FROM partie WHERE id_utilisateur=:joueur and id_hist=:hist';
        $response = $BDD->prepare($requete);
        $response->execute(array(
            "joueur" => $_SESSION["login"],
            "hist" => $_GET["hist"],
        ));
        ?>
    </div>
    <button type="button" class="btn btn-info" onClick="window.location.href='index.php';">Revenir à l'accueil</button>
    </div>

</body>