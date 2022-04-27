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
    <div class="container" id="corps">
    <br/> <br/> <br/> <br/>
    <h1> Histoires </h1>
    <?php
            $maReq = "SELECT * FROM histoire";
            $res = $BDD->query($maReq);
            while($tuple = $res->fetch()) {
            if($tuple["cache"]==0) //l'histoire n'est pas caché !
            {
                //En commentaire tant que la session n'est pas crée
                /*if($_SESSION["usr_login"])
                {
                    ?> <h2> <a href="histoire.php?name=<?= $tuple["identifiant"] ?>&ch=0" class="histoire"><?= $tuple["titre"] ?></a></h2> <?php
                }
                else
                {*/
                    ?> <h2> <?= $tuple["titre"] ?></a></h2> <?php
                //}
                ?>

                
                <div class="container"> <?= $tuple["resumer"] ?> </div>
                <br/>
                <?php
            }
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>