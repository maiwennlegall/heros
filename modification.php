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
    <br/> <br/> <br/> <br/>
   
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
        <p class="text-center">Modifier le chapitre: <?= $tuple["titre"] ?></p>
        <form method="POST" action="enregistrermodifications.php?id=<?=$_GET['id']?>&idchap=<?=$tuple['identifiant']?>" class="text-center">
            
            <p>Modifier le texte</p>
            <textarea name="texte" cols="50" rows="7"><?= $tuple["textes"] ?></textarea> <br/><br/>
            <p>Modifier les choix</p>
            <label for="nom">Choix 1 : </label>  <br/><br/>
            <textarea name="choix1" cols="40" rows="7"><?= $tuple["choix1"] ?></textarea> <br/><br/>
            <label for="nom">Choix 2 : </label>  <br/><br/>
            <textarea name="choix2" cols="40" rows="7"><?= $tuple["choix2"] ?></textarea> <br/><br/>
            <label for="nom">Choix 3 : </label>  <br/><br/>
            <textarea name="choix3" cols="40" rows="7"><?= $tuple["choix3"] ?></textarea> <br/><br/>
            
           
            
            
            <input type="submit" name="enregistrer" id="enregistrer" value="Enregistrer les modifications"/> <br/><br/>
        </form> 
<?php
    }}

    ?>
    </div>
    

    

</div> 

    <?php require_once "includes/scripts.php"; ?>
</body>

</html>