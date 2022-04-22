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
                ?>

                <h2> <a href="histoire.php?name=<?= $tuple["identifiant"] ?>&ch=0" class="histoire"><?= $tuple["titre"] ?></a></h2>
                <!-- résumé d'histoire ?? -->
                <?php
            }
            }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>