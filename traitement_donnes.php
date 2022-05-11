<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<!doctype html>
<html>

<?php 
$id_chap = $_GET["ch"];
$texte = NULL;
$id_choix = NULL;

$req = "SELECT * FROM chapitre WHERE id_ch_hors_hist=:ch";
$reponse = $BDD -> prepare($req);
$reponse ->execute(array(
    "ch" => $id_chap   
));
$tuple = $reponse -> fetch();
if($_GET["choix"]==1)
{
    $texte = $tuple["choix1"];
    $id_choix =$tuple["id_ch_choix1"];
}
else if($_GET["choix"]==2)
{
    $texte = $tuple["choix2"];
    $id_choix =$tuple["id_ch_choix2"];
}
else if($_GET["choix"]==3)
{
    $texte = $tuple["choix3"];
    $id_choix =$tuple["id_ch_choix3"];
}
else
{
    redirect('index.php');
}
$res = $BDD->prepare('UPDATE historique_partie SET text_choix_fait =:txt WHERE id_joueur = :id and id_hist=:hist and id_chap=:ch'); 
$res->execute(array(
    'txt' => $texte,
    "hist" => $_GET["hist"],
    "id" => $_SESSION["login"],
    "ch" => $id_chap,
)); 

$req = "SELECT * FROM chapitre WHERE id_chapitre=:id and id_hist=:hist";
$reponse = $BDD -> prepare($req);
$reponse ->execute(array(
    "id" => $id_choix,
    "hist" => $_GET["hist"]
));
$tuple = $reponse->fetch();

redirect('lecturehistoire.php?hist='.$_GET["hist"].'&ch='.$tuple['id_ch_hors_hist']);
?>

</html>