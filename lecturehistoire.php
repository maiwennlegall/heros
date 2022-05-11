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
    <?php 
        //on regarde si une partie est déjà enregistré pour cet utilisateur
        $premReq = "SELECT COUNT(*) as nb FROM partie WHERE id_utilisateur=:id and id_hist=:hist";
        $repp = $BDD -> prepare($premReq);
        $repp -> execute(array(
            "id" => $_SESSION["login"],
            "hist" => $_GET["hist"],
        ));
        $line = $repp -> fetch();
        if($line['nb']==0)
        {
            $premReq = "SELECT nb_vie_dbt FROM histoire WHERE hist_id=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
            ));
            $line = $repp -> fetch();
            $vie_dbt = $line['nb_vie_dbt'];

            $req = $BDD -> prepare("INSERT INTO partie (id_utilisateur, id_hist, point_de_vie, id_chap, etat_fin) VALUES (:id, :hist, :vie, :ch, 0)");
            $req -> execute(array(
                            'id' => $_SESSION["login"],
                            'hist' => $_GET['hist'],
                            'vie' => $vie_dbt,
                            'ch' => $_GET['ch'],
                            ));
        }
        else if(isset($_GET["debut"]))
        {
            //on regarde si il y a un historique de partie qui ne se serait pas supprimé car la personne n'a pas cliqué sur le bouton de récapitulatif
            $premReq = "SELECT COUNT(*) as nb FROM historique_partie WHERE id_joueur=:id and id_hist=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "id" => $_SESSION["login"],
                "hist" => $_GET["hist"],
            ));
            $line = $repp -> fetch();
            if($line['nb']=!0)
            {
                $requete = 'DELETE FROM historique_partie WHERE id_joueur=:joueur and id_hist=:hist';
                $response = $BDD->prepare($requete);
                $response->execute(array(
                    "joueur" => $_SESSION["login"],
                    "hist" => $_GET["hist"],
                ));
            }

            $premReq = "SELECT nb_vie_dbt FROM histoire WHERE hist_id=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
            ));
            $line = $repp -> fetch();
            $vie_dbt = $line['nb_vie_dbt'];

            $res = $BDD->prepare('UPDATE partie SET id_chap =:ch, point_de_vie=:vie, etat_fin=0 WHERE id_utilisateur = :id and id_hist=:hist'); 
            $res->execute(array(
                'id' => $_SESSION["login"],
                'vie' => $vie_dbt,
                "hist" => $_GET["hist"],
                "ch" => $_GET["ch"],
            )); 

            $req = "SELECT nb_joue FROM histoire WHERE hist_id=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $nbjoue = $reponse -> fetch();
            $newnbjoue = $nbjoue["nb_joue"] + 1;

            $requete = $BDD->prepare('UPDATE histoire SET nb_joue=:newnb_joue WHERE hist_id=:idhistoire');
            $requete->execute(array('newnb_joue' => $newnbjoue,'idhistoire'=> $_GET["hist"]));
        }
        //on vérifie qu'on vient bien sur ce chapitre pour la première fois dans cette partie 
        //ce n'est pas un retour depuis la page d'accueil pour reprendre l'histoire
        else if(!isset($_GET["retour"]))
        {

            /*$req = "SELECT * FROM chapitre WHERE id_hist=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $text_choix="";
            $text_chap="";
            while($tuple = $reponse->fetch()){
                if($tuple["id_ch_choix1"]==$_GET["ch"])
                {
                    $text_choix = $tuple["choix1"];
                    $text_chap = $tuple["textes"];
                }
                else if($tuple["id_ch_choix2"]==$_GET["ch"])
                {
                    $text_choix = $tuple["choix2"];
                    $text_chap = $tuple["textes"];
                }
                else if($tuple["id_ch_choix3"]==$_GET["ch"])
                {
                    $text_choix = $tuple["choix3"];
                    $text_chap = $tuple["textes"];
                }
            }
            $req = $BDD -> prepare("INSERT INTO historique_partie (id_hist, id_joueur, text_chapitre, text_choix_fait) VALUES (:hist, :joueur, :ch, :choix)");
            $req -> execute(array(
                    'hist' => $_GET['hist'],
                    'joueur' => $_SESSION["login"],
                    'ch' => $text_chap,
                    'choix' => $text_choix,
            ));
            */
            

            $premReq = "SELECT point_de_vie FROM partie WHERE id_utilisateur=:id and id_hist=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
                "id" => $_SESSION["login"],
            ));
            $line = $repp -> fetch();
            $vie = $line['point_de_vie'];

            $premReq = "SELECT modif_vie FROM chapitre WHERE id_hist=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
                
            ));
            $line = $repp -> fetch();
            $vie_modif = $line['modif_vie'];

            $nouvellevie = $vie + $vie_modif;

            $res = $BDD->prepare('UPDATE partie SET id_chap =:ch, point_de_vie=:vie WHERE id_utilisateur = :id and id_hist=:hist'); 
            $res->execute(array(
                'id' => $_SESSION["login"],
                'vie' => $nouvellevie,
                "hist" => $_GET["hist"],
                "ch" => $_GET["ch"],
            )); 

            if($nouvellevie <= 0)
            {
                echo "test fin vie";
                redirect('finhistoire.php?perdu=1&vie=false&hist='.$_GET["hist"]);
            }
           
        }
        if(!isset($_GET["retour"]) || isset($_GET["debut"]))
        {
            $req = "SELECT * FROM chapitre WHERE id_hist=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $text_chap ="";
            while($tuple = $reponse->fetch()){
                if($tuple["id_ch_hors_hist"]==$_GET["ch"])
                {
                    $text_chap = $tuple["textes"];
                    $req = $BDD -> prepare("INSERT INTO historique_partie (id_hist, id_chap, id_joueur, text_chapitre, text_choix_fait) VALUES (:hist, :chap, :joueur, :ch, :choix)");
                    $req -> execute(array(
                            'hist' => $_GET['hist'],
                            'chap' => $_GET['ch'],
                            'joueur' => $_SESSION["login"],
                            'ch' => $text_chap,
                            'choix' => "NULL",
                            ));
                }
            }
        }

        $maReq = "SELECT * FROM chapitre WHERE id_ch_hors_hist=:iden and id_hist=:histoire";
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
        $fin = $ligne["type_fin"];
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
                    <button type="button" class="btn btn-info" onClick="window.location.href='traitement_donnes.php?choix=<?=$c1?>&hist=<?=$_GET["hist"]?>';">Choix n°1</button>
                </div>
                <div class="col">
                    <?=$choix2?> <br/>
                    <button type="button" class="btn btn-info" onClick="window.location.href='traitement_donnes.php?choix=<?=$c2?>&hist=<?=$_GET["hist"]?>';">Choix n°2</button>
                </div>
                <div class="col">
                    <?=$choix3?> <br/>
                    <button type="button" class="btn btn-info" onClick="window.location.href='traitement_donnes.php?choix=<?=$c3?>&hist=<?=$_GET["hist"]?>';">Choix n°3</button>
                </div>
            </div>

        <?php 
        }
        else
        {
            $res = $BDD->prepare('UPDATE partie SET etat_fin =1 WHERE id_utilisateur = :id and id_hist=:hist'); 
            $res->execute(array(
                "hist" => $_GET["hist"],
                "id" => $_SESSION["login"],
            ));
            ?>
            <button type="button" class="btn btn-info" onClick="window.location.href='finhistoire.php?perdu=<?=$fin?>&hist=<?=$_GET["hist"]?>';">Recapitulatif histoire</button>
            <?php 
        }
        ?>
        
        </div>

        
        
    </div>
    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>