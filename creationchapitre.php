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
        <br/><br/><br/>
    </div>
    <?php



    $reqq = 'SELECT count(*) as nb from chapitre WHERE id_hist=:hist'; 
    $resp = $BDD->prepare($reqq);
    $resp -> execute(array(
        "hist" => $_GET["histoire"]
    ));
    $data = $resp->fetch();                  
    $nb_chapitres_faits = $data['nb'];

    $reqq = 'SELECT count(id_ch_choix1) as nbr from chapitre WHERE id_ch_choix1!=:choix and id_hist=:hist'; 
    $resp = $BDD->prepare($reqq);
    $resp -> execute(array(
        "hist" => $_GET["histoire"],
        "choix" => "NULL",
    ));
    $data = $resp->fetch();                             
    $nb_chapitres_pas_fin = $data['nbr'];

    if(isset($_POST["chapitre_precedent"]) && $_POST["chapitre_precedent"]!="Fais ton choix")
        {
            $factice = $nb_chapitres_faits+1;
            $resultat = $_POST['chapitre_precedent'];
            echo $resultat;

            $maReq = "SELECT id_chapitre FROM chapitre WHERE titre =:title";
            $repp = $BDD -> prepare($maReq);
            $repp -> execute(array(
                "title" => $resultat
            ));
            $data = $repp->fetch();
            $ch_prec = $data["id_chapitre"];

            $maReq = "SELECT * FROM chapitre WHERE (id_ch_choix1= :ch or id_ch_choix2 =:ch or id_ch_choix3 = :ch) and id_hist=:hist";
            $repp = $BDD -> prepare($maReq);
            $repp -> execute(array(
                "ch" => $factice,
                "hist" => $_GET["histoire"],
            ));
            
            $tuple = $repp->fetch();
            if($factice==$tuple["id_ch_choix1"])
            {
                $res = $BDD->prepare('UPDATE chapitre SET id_ch_choix1 =:suivant, id_ch_choix3 =:trois, id_ch_choix2 =:deux  WHERE id_ch_choix1= :ch and id_hist=:hist'); 
                $res->execute(array(
                'suivant' => $ch_prec,
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
                    'suivant' => $ch_prec,
                    "ch" => $factice,
                    "hist" => $_GET["histoire"],
                )); 
            }
            else if($factice==$tuple["id_ch_choix3"])
            {
                $res = $BDD->prepare('UPDATE chapitre SET id_ch_choix3 =:suivant WHERE id_ch_choix3= :ch and id_hist=:hist'); 
                $res->execute(array(
                    'suivant' => $ch_prec,
                    "ch" => $factice,
                    "hist" => $_GET["histoire"],
                )); 
            }
            //redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=".$_GET['debut']);
        }
    
    else if(!empty($_POST["resumer"]) && !empty($_POST["titre"]) &&$_GET["debut"]==0)
    {   
        $resumer=escape($_POST["resumer"]);
        $titre=escape($_POST["titre"]);

        if(isset($_POST['fin']))
            {
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
                        'modif' => 0,
                        'ecriture' => $resumer,
                    ));
            }
        else
        {
                if(empty($_POST['ch1'])||empty($_POST['ch2'])||empty($_POST['ch3']))
                {
                    //$error = "Vous n'avez pas tout rempli !";
                    redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=".$_GET['debut']);
                }
                else
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
    else
    {
        ?> <!-- ?? -->
        <?php
    }
    


    ?>

    
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
            else {
                $res = $BDD->prepare('UPDATE histoire SET cache = 0 WHERE hist_id = :id'); 
                $res->execute(array('id' => $_GET['histoire']));  
                //redirect('index.php'); 
            }
            
        }
        ?>

<br/><br/>
        <div class="formulaire">
            <form method="POST" action="creationchapitre.php?histoire=<?=$_GET['histoire']?>&debut=0">

            <?php 
            if($_GET["debut"]==0)
            {
                ?>
                <div class="container">
                <label for="chapitre_deja_cree"> Vous souhaitez que le chapitre à gauche ait pour suite un chapitre déjà créé : </label>
                <select name="chapitre_precedent" id="chapitre_deja_cree">
                    <option selected="">Fais ton choix</option>
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

            <textarea name="resumer" cols="50" rows="7" placeholder="Texte de votre chapitre"></textarea> <br/><br/>

            <label for="vie">Modification du nombre de vie (+1, -1...)</label>
            <input type="number"  name="vie"> <br/><br/>

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
    


            <input type="submit" class="btn btn-default btn-primary btn-lg"/>
            <br/><br/><br/><br/>          
        </div>
    </div>
    </div>
    </div></div>
    

    

    <?php require_once "includes/scripts.php"; ?>
</body>

    </html>