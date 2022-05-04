<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";

if(isset($_GET['id'])&&isset($_GET['idchap'])) 
{ 
    if(!empty($_POST["texte"])&&!empty($_POST["choix1"])&&!empty($_POST["choix2"])&&!empty($_POST["choix3"]))
    {
        $requete1 = $BDD->prepare('UPDATE chapitre SET textes=:newtext WHERE identifiant=:idchap');
        $requete1->execute(array('newtext' => $_POST["texte"],'idchap'=>$_GET['idchap']));
        
        $requete2 = $BDD->prepare('UPDATE chapitre SET choix1=:newchoix1 WHERE identifiant=:idchap');
        $requete2->execute(array('newchoix1'=> $_POST["choix1"],'idchap'=>$_GET['idchap']));
        
        $requete3 = $BDD->prepare('UPDATE chapitre SET choix2=:newchoix2  WHERE identifiant=:idchap');
        $requete3->execute(array('newchoix2'=> $_POST["choix2"],'idchap'=>$_GET['idchap']));
        
        $requete4 = $BDD->prepare('UPDATE chapitre SET choix3=:newchoix3 WHERE identifiant=:idchap');
        $requete4->execute(array('newchoix3'=> $_POST["choix3"],'idchap'=>$_GET['idchap']));
       
    }
    redirect("modification.php?id=".$_GET['id']);
}
?>