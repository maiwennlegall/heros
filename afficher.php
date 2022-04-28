<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";
    $newvalue=0;
    if(isset($_GET['id'])) 
    {
        $requete = $BDD->prepare('UPDATE histoire SET cache=:valeur WHERE identifiant=:idhistoire');
        $requete->execute(array('valeur' => $newvalue, 'idhistoire'=>$_GET['id']));

    }

    redirect("administrateur.php");
?>