<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>
!doctype html>
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
            $maReq = "SELECT * FROM histoire WHERE identifiant=:idhistoire";
            $response = $BDD->prepare($maReq);
            $response->execute(array('idhistoire' => $_GET['id']));
            while($tuple = $response->fetch())
            { 
            ?>
                <h1> Modification de l'histoire: <?= $tuple["titre"] ?></h1>
                
            <?php        
            }   
               
        }
        ?>
    </div>



    <?php require_once "includes/scripts.php"; ?>
</body>

</html>