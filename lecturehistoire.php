<?php session_start() ?>
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
<br/> <br/><br/><br/><br/>
    <?php 
        $premReq = "SELECT COUNT(*) as nb FROM partie WHERE id_utilisateur=:id and id_hist=:hist";
        $repp = $BDD -> prepare($premReq);
        $repp -> execute(array(
            "id" => $_SESSION["login"],
            "hist" => $_GET["hist"],
        ));
        $line = $repp -> fetch();
        if($line['nb']==0)
        {
            $req = $BDD -> prepare("INSERT INTO partie (id_utilisateur, id_hist, point_de_vie, id_chap, etat_fin) VALUES (:id, :hist, 0, :ch, 0)");
            $req -> execute(array(
                            'id' => $_SESSION["login"],
                            'hist' => $_GET['hist'],
                            'ch' => $_GET['ch'],
                            ));
        }
        else
        {
            $res = $BDD->prepare('UPDATE partie SET id_chap =:ch WHERE id_utilisateur = :id and id_hist=:hist'); 
            $res->execute(array(
                'id' => $_SESSION["login"],
                "hist" => $_GET["hist"],
                "ch" => $_GET["ch"],
            )); 
        }

        $maReq = "SELECT * FROM chapitre WHERE identifiant=:iden and id_hist=:histoire";
        $reponse = $BDD -> prepare($maReq);
        $reponse ->execute(array(
            "iden"=>$_GET["ch"],
            "histoire" => $_GET["hist"],
        ));
        $ligne = $reponse -> fetch();
        $text = $ligne["textes"];
        $title =$ligne["titre"];
        $choix1 = $ligne["choix1"];
        $choix2 = $ligne["choix2"];
        $choix3 = $ligne["choix3"];
        $c1 = $ligne["id_ch_choix1"];
        $c2 = $ligne["id_ch_choix2"];
        $c3 = $ligne["id_ch_choix3"];
    ?>
    <div class="container" id="trophaut">
        
        <h1 id="bleu"><?=$title ?></h1>

        <div class="container" id="chapitre">
            <?=$text?> 
        </div>

        <?php 
        if($choix1!=NULL)
        {
            ?>
            <div class="container" id="choix">
            <div class="row">
                <div class="col">
                    <?=$choix1?> <br/>
                    <button type="button" class="btn btn-info" onClick="window.location.href='lecturehistoire.php?hist=<?=$_GET["hist"]?>&ch=<?=$c1?>';">Choix n°1</button>
                </div>
                <div class="col">
                    <?=$choix2?> <br/>
                    <button type="button" class="btn btn-info" onClick="window.location.href='lecturehistoire.php?hist=<?=$_GET["hist"]?>&ch=<?=$c2?>';">Choix n°2</button>
                </div>
                <div class="col">
                    <?=$choix3?> <br/>
                    <button type="button" class="btn btn-info" onClick="window.location.href='lecturehistoire.php?hist=<?=$_GET["hist"]?>&ch=<?=$c3?>';">Choix n°3</button>
                </div>
            </div>

        <?php 
        }
        else
        {
            echo "FIN";
        }
        ?>
        
        </div>

        
        
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>