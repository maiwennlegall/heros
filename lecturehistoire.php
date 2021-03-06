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

            //On ajoute 1 au nombre de parties jouées
            $req = "SELECT nb_joue FROM histoire WHERE hist_id=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $nbjouer = $reponse -> fetch();
            $newnbjoue = $nbjouer["nb_joue"]+1;

            $requete = $BDD->prepare('UPDATE histoire SET nb_joue=:newnb_joue WHERE hist_id=:idhistoire');
            $requete->execute(array(
                'newnb_joue' => $newnbjoue,
                'idhistoire'=> $_GET["hist"]
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

            //On ajoute 1 au nombre de parties jouées
            $req = "SELECT nb_joue FROM histoire WHERE hist_id=:histoire";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "histoire" => $_GET["hist"],
            ));
            $nbjouer = $reponse -> fetch();
            $newnbjoue = $nbjouer["nb_joue"]+1;

            $requete = $BDD->prepare('UPDATE histoire SET nb_joue=:newnb_joue WHERE hist_id=:idhistoire');
            $requete->execute(array(
                'newnb_joue' => $newnbjoue,
                'idhistoire'=> $_GET["hist"]
            ));
        }
        //on vérifie qu'on vient bien sur ce chapitre pour la première fois dans cette partie 
        //ce n'est pas un retour depuis la page d'accueil pour reprendre l'histoire
        else if(!isset($_GET["retour"]))
        {
            $premReq = "SELECT point_de_vie FROM partie WHERE id_utilisateur=:id and id_hist=:hist";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
                "id" => $_SESSION["login"],
            ));
            $line = $repp -> fetch();
            $vie = $line['point_de_vie'];

            $premReq = "SELECT modif_vie FROM chapitre WHERE id_hist=:hist and id_ch_hors_hist=:chap";
            $repp = $BDD -> prepare($premReq);
            $repp -> execute(array(
                "hist" => $_GET["hist"],
                "chap" => $_GET["ch"]
                
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
                redirect('finhistoire.php?perdu=1&vie=false&hist='.$_GET["hist"]);
            }
           
        }
        //vérifie qu'on est pas de retour sur la page pour reprendre la partie commencé avant
        if(!isset($_GET["retour"]) || isset($_GET["debut"]))
        {
            //récupère les information pour créer les lignes dans la table historique partie pour avoir la trame complète
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
        //prend les informations utiles pour afficher l'histoire et les choix au joueur 
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
        $fin = $ligne["type_fin"];
    ?>
    <div class="container" id="corps">
        
        <h1 id="bleu"><?=$title ?></h1>

        <div class="container" id="chapitre">
            <?=$text?> 
        </div>

        <?php 
        //différencie une fin d'un chapitre à choix, ici pas une fin
        if($choix1!=NULL)
        {
            ?>
        <div class="container">
        <div class="row">
                <div class="separation col-sm box">
                    <p class="choice"> <?=$choix1?> </p>
                </div>
                <div class="separation col-sm box">
                <p class="choice"> <?=$choix2?> </p>
                </div>
                <div class="separation col-sm box">
                <p class="choice"> <?=$choix3?> </p>
                </div>
        </div>
        <div class="row">
            <div class="text-center col-sm">
                <button type="button" class="btn btn-info " onClick="window.location.href='traitement_donnes.php?choix=1&ch=<?=$_GET["ch"]?>&hist=<?=$_GET["hist"]?>';">Choix n°1</button>
            </div>
            <div class="text-center col-sm">
                <button type="button" class="btn btn-info " onClick="window.location.href='traitement_donnes.php?choix=2&ch=<?=$_GET["ch"]?>&hist=<?=$_GET["hist"]?>';">Choix n°2</button>
            </div>
            <div class="text-center col-sm">
                <button type="button" class="btn btn-info " onClick="window.location.href='traitement_donnes.php?choix=3&ch=<?=$_GET["ch"]?>&hist=<?=$_GET["hist"]?>';">Choix n°3</button>
            </div>
        </div>

        <?php 
        }
        //fin d'histoire
        else
        {
            //on update la bdd de partie pour annoncer qu'on est sur une fin de partie
            $res = $BDD->prepare('UPDATE partie SET etat_fin =1 WHERE id_utilisateur = :id and id_hist=:hist'); 
            $res->execute(array(
                "hist" => $_GET["hist"],
                "id" => $_SESSION["login"],
            ));
            ?>
            <div class="mt-3 text-center">
            <button type="button" class="btn btn-info" onClick="window.location.href='finhistoire.php?perdu=<?=$fin?>&hist=<?=$_GET["hist"]?>';">Recapitulatif histoire</button>
            </div>
            <?php 
        }
        ?>
        
        </div>

    </div>

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>