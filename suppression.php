<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";
    
    if(isset($_GET['id'])) 
    {
        $requete = "DELETE FROM histoire WHERE hist_id=:idhistoire"; #suppression de l'histoire
        $response = $BDD->prepare($requete);
        $response->execute(array('idhistoire' => $_GET['id']));           
    }

    redirect("administrateur.php");
?>