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
    <h1> Histoires </h1>
    <?php
        if(isset($_SESSION["login"]))
        {
            $premReq = "SELECT COUNT(*) as nb FROM partie WHERE id_utilisateur=:id";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "id" => $_SESSION["login"] ));
            $line = $repp -> fetch();
            if($line['nb']!=0)
            {
                ?> <h2>Reprendre une histoire</h2> <?php
                $maReq = "SELECT * FROM partie, histoire WHERE id_hist=hist_id and id_utilisateur=:id";
                $repp = $BDD -> prepare($maReq);
                $repp -> execute(array(
                    "id" => $_SESSION["login"] ));
                while($tuple = $repp->fetch()) {
                    if($tuple["etat_fin"]!=1)
                    {
                        ?> <h2> <button type="button" class="btn_hover" onClick="window.location.href='lecturehistoire.php?hist=<?= $tuple["hist_id"] ?>&ch=<?=$tuple['id_chap']?>&retour=true';"><?=$tuple["titre"]?></button>
                        </h2>
                        <div class="container"> <?= $tuple["resumer"] ?> </div> <br/>
                        <?php
                    }
                }
            }
        }
        ?> 
        <h2>Commencer une nouvelle une histoire</h2> 
        <div class="container" id="psthist">
        <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) {
            if($tuple["cache"]==0)
            {
                if(isset($_SESSION["login"]))
                {
                    $test = $tuple["hist_id"];
                    $maNewReq = "SELECT id_chapitre FROM chapitre WHERE id_hist=:histoire";
                    $reponse = $BDD -> prepare($maNewReq);
                    $reponse ->execute(array("histoire"=>$test));
                    $ligne = $reponse -> fetch();
                    $debut = $ligne["id_chapitre"];
                    ?> <h2> <button type="button" class="btn_hover" onClick="window.location.href='lecturehistoire.php?hist=<?= $tuple["hist_id"] ?>&ch=<?=$debut?>&debut=true';"><?=$tuple["titre"]?></button>
                       </h2> <?php
                }
                else
                {
                    ?> <h2> <?= $tuple["titre"] ?></h2> <?php
                }
                ?>
                <div class="container"> <?= $tuple["resumer"] ?> </div>
                <br/>
                <?php
            }
            }
        ?>
        </div>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>