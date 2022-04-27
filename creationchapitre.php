<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>


<!doctype html>
<html>


<!-- CA VA PAS ! IL FAUT COMME INFOS : 
le chapitre d'avant et le choix fait pour en arriver là ==> l'écrire pour aider à la nouvelle écriture
savoir où écrire après : si on est pas aux choix 3 passer au suivant
si on est au choix 3 savoir à quelle chapitre on passe après ! MAIS faut s'assurer que ce chapitre 
ne soit pas une fin ! -->
<!doctype html>
<html>
    

<?php require_once "includes/head.php"; ?>

<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <br/><br/><br/><br/><br/><br/><br/>
    <?php
    

    if(!empty($_POST["resumer"]))
            {   
                $res = $BDD->query('SELECT count(*) as nb from chapitre');
                $data = $res->fetch();
                $nb = $data['nb'];                      
                $nb_chapitres_faits = $data['nb'];

                $res = $BDD->query('SELECT count(id_ch_choix1) as nbr from chapitre WHERE id_ch_choix1!="NULL"');
                $data = $res->fetch();
                $nb = $data['nbr'];                      
                $nb_chapitres_pas_fin = $data['nbr'];
                
                if(isset($_POST['fin']))
                {
                    $maReq = $BDD -> prepare("INSERT INTO chapitre (identifiant, id_hist, textes) VALUES (:id, :hist, :ecriture)");
                        $maReq -> execute(array(
                            'id' => $nb_chapitres_faits+1,
                            'hist' => $_GET['histoire'],
                            'ecriture' => $_POST["resumer"],
                        ));
                        redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=0");
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
                        $maReq = $BDD -> prepare("INSERT INTO chapitre (identifiant, id_hist, id_ch_choix1, id_ch_choix2, id_ch_choix3, choix1, choix2, choix3, textes) VALUES (:id, :hist, :id1, :id2, :id3, :t1, :t2, :t3, :ecriture)");
                        $maReq -> execute(array(
                            'id' => $nb_chapitres_faits+1,
                            'hist' => $_GET['histoire'],
                            
                            'id1' => ($nb_chapitres_pas_fin*3)+2,
                            'id2' => ($nb_chapitres_pas_fin*3)+3,
                            'id3' => ($nb_chapitres_pas_fin*3)+4,
                            't1' => $_POST["ch1"],
                            't2' => $_POST['ch2'],
                            't3' => $_POST["ch3"],

                            'ecriture' => $_POST["resumer"],
                            ));
                        
                        redirect("creationchapitre.php?histoire=".$_GET['histoire']."&debut=0");
                    }
                }
            }
    


        ?>

    
    <div class="container" id="trophaut">
        
        <h1>Creation d'un chapitre</h1>

        <?php 

        if($_GET["debut"]==1) {   

            ?> 
            <div class="container">
                <h2> Ecrivez votre premier chapitre </h2>
            
            <div>
                <?php //redirect("creationchapitre.php?histoire=".$_GET['histoire']);
        }
        else {
            //vérifier le empty de POST
            function premier_ch_non_fini() {
                global $BDD;
                $requete = "SELECT * FROM chapitre WHERE id_hist=?";
                $response = $BDD->prepare($requete);
                $response->execute(array($_GET['histoire']));
                    /*
                $res = $BDD->query('SELECT * FROM chapitre WHERE id_hist=:hist');
                $res -> execute(array(
                    'hist' => $_GET['histoire'],
                ));*/
                while($tuple = $response->fetch()) {
                    
                    /*
                    $maNewReq = "SELECT * FROM chapitre WHERE id_hist=:hist";
                    $res -> execute(array(
                        'hist' => $_GET['histoire'],
                    ));*/
                    $newRequete = "SELECT * FROM chapitre WHERE id_hist=?";
                    $res = $BDD->prepare($newRequete);
                    $res->execute(array($_GET['histoire']));

                    $test = false;
                    $valeur = $tuple['id_ch_choix1'];
                    $text_choix = $tuple['choix1'];
                    if($tuple['id_ch_choix1']==null) //signie que le chapitre est fini pas la peine de parcourir
                        $test=true;
                    else
                    {
                        while($newtuple = $res->fetch()){ 
                            if($tuple['id_ch_choix1']==$newtuple['identifiant'])
                            {
                                $valeur = $tuple['id_ch_choix2'];
                                $text_choix = $tuple['choix2'];
                            }
                            if($tuple['id_ch_choix2']==$newtuple['identifiant'])
                            {
                                $valeur = $tuple['id_ch_choix3'];
                                $text_choix = $tuple['choix3'];
                            }
                            if($tuple['id_ch_choix3']==$newtuple['identifiant'])
                                 $test = true;
                        }            
                    }
                    if($test == false)
                    {
                        return [$valeur, $tuple['textes'], $text_choix]; //permet de savoir le chapitre à remplir mais aussi
                                                                // les textes du ch d'où ça provient et de la reponse choisie !
                    }
                }
                return [null, null, null];
            }
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
                //insert les nouvelles valeurs ! mais pas ici ?
            }
            else {
                $res = $BDD->prepare('UPDATE histoire SET cache = 0 WHERE identifiant = :id'); 
                $res->execute(array('id' => $_GET['histoire']));  
                redirect('accueil.php'); //A changer pour une page de confirmation qui rend l'histoire non caché aussi !
            }
            //changer ça de place ! c'est quand on submit ça !
            
        }
        ?>

<br/><br/>
        <div class="formulaire">
            <form method="POST" action="creationchapitre.php?histoire=<?=$_GET['histoire']?>&debut=0"> <!--changer le fichier dans action-->

            <textarea name="resumer" cols="50" rows="7">Texte de votre chapitre</textarea> <br/><br/>

            <label for="ch1">Choix n°1</label>
            <input type="text"  name="ch1"> <br/><br/>

            <label for="ch2">Choix n°2</label>
            <input type="text"  name="ch2"> <br/><br/>

            <label for="ch3">Choix n°3</label>
            <input type="text"  name="ch3"> <br/><br/>

            <label for="fin"> Cochez si cela constitue une fin </label>
            <input type="radio" name="fin"> </br>

            <!-- faut mettre un bouton pour dire si c'est la fin et donc pas de choix : null -->
            
            <button type="submit" class="btn btn-default btn-primary"> Chapitre fait ! </button>  
            <br/><br/><br/><br/>          
        </div>
    </div>
    </div>
    </div></div>
    

    

    <?php require_once "includes/scripts.php"; ?>
</body>

    </html>