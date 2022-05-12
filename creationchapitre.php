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
        <br/><br/><br/>
    </div>
    <?php


    //on compte le nombre de chapitre déjà créé pour cette histoire dans la table chapitre
    $reqq = 'SELECT count(*) as nb from chapitre WHERE id_hist=:hist'; 
    $resp = $BDD->prepare($reqq);
    $resp -> execute(array(
        "hist" => $_GET["histoire"]
    ));
    $data = $resp->fetch();                  
    $nb_chapitres_faits = $data['nb'];

    //compte le nombre de ligne dans chapitre ayant des choix et donc n'étant pas une fin
    $reqq = 'SELECT count(id_ch_choix1) as nbr from chapitre WHERE id_ch_choix1!=:choix and id_hist=:hist'; 
    $resp = $BDD->prepare($reqq);
    $resp -> execute(array(
        "hist" => $_GET["histoire"],
        "choix" => "NULL",
    ));
    $data = $resp->fetch();                             
    $nb_chapitres_pas_fin = $data['nbr'];

    //regarde si dans le formulaire il a été choisi de reprendre un chapitre précedemment choisi
    if(isset($_POST["chapitre_precedent"]) && $_POST["chapitre_precedent"]!="Fais ton choix")
        {
            //permet de connaitre l'identifiant qu'à actuellement le choix dont on veut changer la direction
            $factice = $nb_chapitres_faits+1;
            //récupère dans une variable l'identifiant du chapitre choisi précédemment
            $resultat = $_POST['chapitre_precedent'];

            /*$maReq = "SELECT id_chapitre FROM chapitre WHERE id_chapitre=:title";
            $repp = $BDD -> prepare($maReq);
            $repp -> execute(array(
                "title" => $resultat
            ));
            $data = $repp->fetch();
            $ch_prec = $data["id_chapitre"];*/

            //on retrouve la ligne contenant ce choix à changer
            $maReq = "SELECT * FROM chapitre WHERE (id_ch_choix1= :ch or id_ch_choix2 =:ch or id_ch_choix3 = :ch) and id_hist=:hist";
            $repp = $BDD -> prepare($maReq);
            $repp -> execute(array(
                "ch" => $factice,
                "hist" => $_GET["histoire"],
            ));
            
            $tuple = $repp->fetch();
            //on détermine si c'est le choix 1, 2 ou 3 et on update différemment les autres choix en fonction
            if($factice==$tuple["id_ch_choix1"])
            {
                $res = $BDD->prepare('UPDATE chapitre SET id_ch_choix1 =:suivant, id_ch_choix3 =:trois, id_ch_choix2 =:deux  WHERE id_ch_choix1= :ch and id_hist=:hist'); 
                $res->execute(array(
                'suivant' => $resultat,
                "trois" => $tuple["id_ch_choix2"],
                'deux' => $tuple["id_ch_choix1"],
                "ch" => $factice,
                "hist" => $_GET["histoire"],
                )); 
            }
            else if($factice==$tuple["id_ch_choix2"])
            {
                $res = $BDD->prepare('UPDATE chapitre SET id_ch_choix3 =:trois, id_ch_choix2 =:suivant WHERE id_ch_choix2= :ch and id_hist=:hist'); 
                $res->execute(array(
                    "trois" => $tuple["id_ch_choix2"],
                    'suivant' => $resultat,
                    "ch" => $factice,
                    "hist" => $_GET["histoire"],
                )); 
            }
            else if($factice==$tuple["id_ch_choix3"])
            {
                $res = $BDD->prepare('UPDATE chapitre SET id_ch_choix3 =:suivant WHERE id_ch_choix3= :ch and id_hist=:hist'); 
                $res->execute(array(
                    'suivant' => $resultat,
                    "ch" => $factice,
                    "hist" => $_GET["histoire"],
                )); 
            }
            //redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=".$_GET['debut']);
        }
    //on vérifie que le formulaire est bien rempli, $_GET["debut]==0 signie que ce n'est pas le premier chapitre qu'on écrit
    else if(!empty($_POST["resumer"]) && !empty($_POST["titre"]) &&$_GET["debut"]==0)
    {   
        //sécurisation des données
        $resumer=escape($_POST["resumer"]);
        $titre=escape($_POST["titre"]);

        //permet de savoir si le chapitre est une fin de branche
        if(isset($_POST['fin']))
            {
                //on regarde si la fin est positive ou négative
                if($_POST['fin']=="fin_positive")
                {
                    $fin=0;
                }
                else
                {
                    $fin=1;
                }
                $maReq = $BDD -> prepare("INSERT INTO chapitre (id_chapitre, titre, id_hist, modif_vie, type_fin, textes) VALUES (:id, :title, :hist, :modif, :fin, :ecriture)");
                $maReq -> execute(array(
                        'id' => $nb_chapitres_faits+1,
                        'title' => $titre,
                        'hist' => $_GET['histoire'],
                        'fin' => $fin,
                        'modif' => $_POST['vie'],
                        'ecriture' => $resumer,
                    ));
            }
        else
        {       //Si l'un des choix n'a pas été rempli alors qu'on est pas sur une fin, on redirige sur la page pour refaire tout remplir
                if(empty($_POST['ch1'])||empty($_POST['ch2'])||empty($_POST['ch3']))
                {
                    redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=".$_GET['debut']);
                }
                else //tou est bien rempli
                {
                    $ch1=escape($_POST['ch1']);
                    $ch2=escape($_POST['ch2']);
                    $ch3=escape($_POST['ch3']);

                    $maReq = $BDD -> prepare("INSERT INTO chapitre (id_chapitre, titre, id_hist, modif_vie, id_ch_choix1, id_ch_choix2, id_ch_choix3, choix1, choix2, choix3, textes) VALUES (:id, :title, :hist, :vie, :id1, :id2, :id3, :t1, :t2, :t3, :ecriture)");
                    $maReq -> execute(array( 
                                'id' => $nb_chapitres_faits+1,
                                'title' => $titre,
                                'hist' => $_GET['histoire'],
                                'vie' => $_POST['vie'],
                                'id1' => (($nb_chapitres_pas_fin+1)*3)-1,
                                'id2' => (($nb_chapitres_pas_fin+1)*3),
                                'id3' => (($nb_chapitres_pas_fin+1)*3)+1,
                                't1' => $ch1,
                                't2' => $ch2,
                                't3' => $ch3,

                                'ecriture' => $resumer,
                                ));    
                }
        }
    }
    ?>

    <!-- page html -->
    <div class="container text-center" id="corps">
        
        <h1>Creation d'un chapitre</h1>

        <?php 

        if($_GET["debut"]==1) {   

            ?> 
            <div class="container">
                <h2> Ecrivez votre premier chapitre </h2>
            
            </div>
                <?php 
        }
        else {
            [$valeur, $text_chap, $text_choix] = premier_ch_non_fini();
            ?> 
            <div class="container">
            <div class="row"> <?php
            if($valeur != null) {
                ?> <div class="col"><h3> Texte du chapitre d'avant </h3> 
                <br/>
                    <div class="container">
                        <?= $text_chap ?>
                    </div>
                    
                <br/>
                    <h3> Choix fait pour en arriver ici </h3>
                <br/>
                    <div class="container">
                        <?= $text_choix ?>
                    </div>
            </div>

            <div class="col">
                    <h2> Ecrivez votre chapitre suivant ce choix :  </h2>
                    <?php
            }
            else { //cela signifie que toutes les branches ont une fin, ainsi l'histoire est finie, on redirige vers l'accueil et on rend visible l'histoire
                $res = $BDD->prepare('UPDATE histoire SET cache = 0 WHERE hist_id = :id'); 
                $res->execute(array('id' => $_GET['histoire']));  
                redirect('index.php'); 
            }
            
        }
        ?>

<br/><br/>
        <div class="formulaire">
            <form method="POST" action="creationchapitre.php?histoire=<?=$_GET['histoire']?>&debut=0">

            <?php 
            if($_GET["debut"]==0) //si on écrit pas le premier chapitre on aide l'utilisateur à la création en lui indiquant la suite de quoi il écrit
            {
                ?>
                <div class="container">
                <label for="chapitre_deja_cree"> Vous souhaitez que le chapitre à gauche ait pour suite un chapitre déjà créé : </label>
                <select name="chapitre_precedent" id="chapitre_deja_cree">
                    <option>Fais ton choix</option>
                <?php
                $value="";
                $maReq = "SELECT * FROM chapitre WHERE id_hist=:hist_id";
                $repp = $BDD -> prepare($maReq);
                $repp -> execute(array(
                    "hist_id" => $_GET["histoire"] ));
                while($tuple = $repp->fetch()) 
                {
                    ?> <option value="<?=$tuple["id_chapitre"]?>"><?= $tuple["titre"];?></option> <?php
                }
                ?> 
                </select>
                </div> <br/>
                <?php
            }
            ?>
            <label for="titre">Titre de votre chapitre</label>
            <input type="text" name="titre"> <br/><br/>

            <label for="resumer"> Texte de votre chapitre : </label> <br/>
            <textarea name="resumer" cols="50" rows="7"></textarea> <br/><br/>

            <label for="vie">Modification du nombre de vie (+1, -1...)</label>
            <input type="number"  name="vie" value=0> <br/><br/>

            <label for="ch1">Choix n°1</label>
            <input type="text"  name="ch1"> <br/><br/>

            <label for="ch2">Choix n°2</label>
            <input type="text"  name="ch2"> <br/><br/>

            <label for="ch3">Choix n°3</label>
            <input type="text"  name="ch3"> 
            <fieldset>
                <legend>Cochez si cela constitue une fin</legend>

                <div>
                <input type="radio" id="positive" name="fin" value="fin_positive">
                        
                <label for="positive">Fin positive</label>
                </div>

                <div>
                <input type="radio" id="negative" name="fin" value="fin_negative">
                <label for="negative">Fin negative</label>
                </div>
            </fieldset>
    


            <input type="submit" class="btn btn-default btn-primary btn-lg" value="Envoyer"/>
            <br/><br/><br/><br/>          
        </div>
    </div>
    </div>
    </div></div>
    

    

    <?php require_once "includes/scripts.php"; ?>
</body>

    </html>