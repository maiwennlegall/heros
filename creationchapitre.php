<?php //session_start() ?>
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
    
    if(!empty($_POST["resumer"]) && !empty($_POST["titre"]))
            {   
                $res = $BDD->query('SELECT count(*) as nb from chapitre');
                $data = $res->fetch();                  
                $nb_chapitres_faits = $data['nb'];

                $res = $BDD->query('SELECT count(id_ch_choix1) as nbr from chapitre WHERE id_ch_choix1!="NULL"');
                $data = $res->fetch();                 
                $nb_chapitres_pas_fin = $data['nbr'];
                
                if(isset($_POST['fin']))
                {
                    $maReq = $BDD -> prepare("INSERT INTO chapitre (id_chapitre, titre, id_hist, textes) VALUES (:id, :title, :hist, :ecriture)");
                        $maReq -> execute(array(
                            'id' => $nb_chapitres_faits+1,
                            'title' => $_POST['titre'],
                            'hist' => $_GET['histoire'],
                            'ecriture' => $_POST["resumer"],
                        ));
                }
                else
                {
                    if(empty($_POST['ch1'])||empty($_POST['ch2'])||empty($_POST['ch3']))
                    {
                        $error = "Vous n'avez pas tout rempli !";
                        redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=".$_GET['debut']);
                    }
                    else
                    {
                        $maReq = $BDD -> prepare("INSERT INTO chapitre (id_chapitre, titre, id_hist, modif_vie, id_ch_choix1, id_ch_choix2, id_ch_choix3, choix1, choix2, choix3, textes) VALUES (:id, :title, :hist, :vie, :id1, :id2, :id3, :t1, :t2, :t3, :ecriture)");
                        $maReq -> execute(array(
                            'id' => $nb_chapitres_faits+1,
                            'title' => $_POST['titre'],
                            'hist' => $_GET['histoire'],
                            'vie' => $_POST['vie'],
                            'id1' => ($nb_chapitres_pas_fin*3)+2,
                            'id2' => ($nb_chapitres_pas_fin*3)+3,
                            'id3' => ($nb_chapitres_pas_fin*3)+4,
                            't1' => $_POST["ch1"],
                            't2' => $_POST['ch2'],
                            't3' => $_POST["ch3"],

                            'ecriture' => $_POST["resumer"],
                            ));
                        
                    }
                }
            }
            else
            {
                ?> <br/><br/><br/> <?php echo "MJHGGYGUVYGV";
            }
    


        ?>

    
    <div class="container" id="trophaut">
        
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
                redirect('index.php'); 
            }
            
        }
        ?>

<br/><br/>
        <div class="formulaire">
            <form method="POST" action="creationchapitre.php?histoire=<?=$_GET['histoire']?>&debut=0">

            <label for="titre">Titre de votre chapitre</label>
            <input type="text" name="titre"> <br/><br/>

            <textarea name="resumer" cols="50" rows="7" placeholder="Texte de votre chapitre"></textarea> <br/><br/>

            <label for="vie">Modification du nombre de vie (+1, -1...)</label>
            <input type="number"  name="vie" value="0"> <br/><br/>

            <label for="ch1">Choix n°1</label>
            <input type="text"  name="ch1"> <br/><br/>

            <label for="ch2">Choix n°2</label>
            <input type="text"  name="ch2"> <br/><br/>

            <label for="ch3">Choix n°3</label>
            <input type="text"  name="ch3"> 
<!--
            <label for="title">Titre de votre chapitre</label>
            <input type="text" name="titre"> <br/><br/>

            <textarea name="resumer" cols="50" rows="7">Texte de votre chapitre</textarea> <br/><br/>
            

            <label for="ch1">Choix n°1</label>
            <input type="text"  name="ch1"> <br/><br/>

            <label for="ch2">Choix n°2</label>
            <input type="text"  name="ch2"> <br/><br/>

            <label for="ch3">Choix n°3</label>
            <input type="text"  name="ch3"> <br/><br/>

            <label for="vie">Modification du nombre de vie (+1, -1...)</label>
            <input type="number"  name="vie"> <br/><br/>

            <label for="fin"> Cochez si cela constitue une fin </label>
            <input type="radio" name="fin"> </br>

            <button type="submit" class="btn btn-default btn-primary"> Chapitre fait ! </button>  -->

            
            <fieldset>
                <legend>Cochez si cela constitue une fin</legend>

                <div>
                <input type="radio" id="positive" name="fin" value="Fin_positive">
                        
                <label for="positive">Fin positive</label>
                </div>

                <div>
                <input type="radio" id="negative" name="fin" value="Fin_negative">
                <label for="negative">Fin negative</label>
                </div>
            </fieldset>
    


            <input type="submit" class="btn btn-default btn-primary"/>
            <br/><br/><br/><br/>          
        </div>
    </div>
    </div>
    </div></div>
    

    

    <?php require_once "includes/scripts.php"; ?>
</body>

    </html>