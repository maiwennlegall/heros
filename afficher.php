<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";
    $newvalue=0; 
    //Passage à 0 du champ cache de la table histoire , signifiant que l'histoire ne doit pas être cachée
    if(isset($_GET['id'])) 
    {
        $requete = $BDD->prepare('UPDATE histoire SET cache=:valeur WHERE hist_id=:idhistoire');
        $requete->execute(array('valeur' => $newvalue, 'idhistoire'=>$_GET['id']));

    }

    redirect("administrateur.php");
?>