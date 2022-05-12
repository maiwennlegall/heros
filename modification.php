<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>
<!doctype html>
<html>

<!doctype html>
<html lang="fr">
<?php require_once "includes/head.php"; ?>
<body>
    <div class="container">
        <?php require_once "includes/header.php"; ?>

    </div>
    <div class="container" id="corps">
   
    <?php
        if(isset($_GET['id'])) 
        {
            $identifiant_histoire=$_GET['id'];
            $maReq = "SELECT * FROM histoire WHERE hist_id=:idhistoire";
            $response = $BDD->prepare($maReq);
            $response->execute(array('idhistoire' => $identifiant_histoire));
            while($tuple = $response->fetch())
            { 
            ?>
                <h1> Modification de l'histoire: <?= $tuple["titre"] ?></h1>
                
            <?php        
            } 
            ?>  
            
            <div class="formulaire text-center">
                <!-- choix du chapitre à modifier parmi tout ceux de l'histoire-->
                <form method="POST" action="modification.php?id=<?=$identifiant_histoire?>">  
                    <p>Choisissez le chapitre que vous voulez modifier:</p>
                    <select name="chap">
                        <?php 
                        $maReq = "SELECT * FROM chapitre WHERE id_hist=:idhistoire";
                        $response = $BDD->prepare($maReq);
                        $response->execute(array('idhistoire' => $identifiant_histoire));
                        while($tuple = $response->fetch())
                        { 
                        ?>
                            <option><?=$tuple['titre']?></option>
                            
                        <?php        
                        } 
                        ?>                   
                    </select>  
                    <input type="submit" name="valider" id="valider" value="Valider"/>
                </form> 
            </div> 
            <?php    
        }
        ?>
    
    <div>
    <?php
    

    if(!empty($_POST["chap"]))
    {
        $requete = $BDD->prepare('SELECT * FROM chapitre WHERE titre=:chap');
        $requete->execute(array('chap' => $_POST["chap"]));
        while($tuple = $requete->fetch()) 
        {
        ?>
        <br/>
        <p class="text-center titre" >Modifier le chapitre: <?= $tuple["titre"] ?></p>
        <div class="text-center">
        <form method="POST" action="enregistrermodifications.php?id=<?=$_GET['id']?>&idchap=<?=$tuple["id_chapitre"]?>" >
            <!-- Modification du chapitre, des choix et de l'impact sur le nombre de vie-->
            <textarea name="texte" cols="50" rows="7"><?= $tuple["textes"] ?></textarea> <br/><br/>
            <p>Modifier les choix</p>
            <label for="nom">Choix 1 : </label>  <br/><br/>
            <textarea name="choix1" cols="40" rows="7"><?= $tuple["choix1"] ?></textarea> <br/><br/>
            <label for="nom">Choix 2 : </label>  <br/><br/>
            <textarea name="choix2" cols="40" rows="7"><?= $tuple["choix2"] ?></textarea> <br/><br/>
            <label for="nom">Choix 3 : </label>  <br/><br/>
            <textarea name="choix3" cols="40" rows="7"><?= $tuple["choix3"] ?></textarea> <br/><br/>
            <label for="vie">Modification du nombre de vie (+1, -1...)</label>
            <input type="number"  name="vie" value="<?= $tuple["modif_vie"] ?>"> <br/><br/>
           
            
            
            <input type="submit" name="enregistrer" id="enregistrer" value="Enregistrer les modifications"/> <br/><br/>
        </form>
        </div> 
<?php
    }}

    ?>
    </div>
    

        <button type="button" class="btn btn-info" onClick="window.location.href='index.php';">Revenir à l'accueil</button>
        <button type="button" class="btn btn-info" onClick="window.location.href='administrateur.php';">Revenir à la page administrateur</button>

    </div> 


    <?php require_once "includes/scripts.php"; ?>
</body>

</html>