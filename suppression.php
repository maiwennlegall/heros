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

        //La construction de la base de données implique la suppression en cascade des données liées à cette histoire dans les autres tables

        /*$requete2 = "DELETE FROM chapitre WHERE id_hist=:idhistoire"; #suppression des chapitres
        $response2 = $BDD->prepare($requete2);
        $response2->execute(array('idhistoire' => $_GET['id']));
        
        $requete3 = "DELETE FROM partie WHERE id_hist=:idhistoire"; #suppression des parties
        $response3 = $BDD->prepare($requete3);
        $response3->execute(array('idhistoire' => $_GET['id']));*/

        
    }

    redirect("administrateur.php");
?>