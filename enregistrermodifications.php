<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";

if(isset($_GET['id'])&&isset($_GET['idchap'])) 
{ 
    if(!empty($_POST["texte"])&&!empty($_POST["choix1"])&&!empty($_POST["choix2"])&&!empty($_POST["choix3"])&&!empty($_POST["vie"]))
    {
        $requete1 = $BDD->prepare('UPDATE chapitre SET textes=:newtext WHERE id_chapitre=:idchap');
        $requete1->execute(array('newtext' => escape($_POST["texte"]),'idchap'=>$_GET['idchap']));
        
        $requete2 = $BDD->prepare('UPDATE chapitre SET choix1=:newchoix1 WHERE id_chapitre=:idchap');
        $requete2->execute(array('newchoix1'=> escape($_POST["choix1"]),'idchap'=>$_GET['idchap']));
        
        $requete3 = $BDD->prepare('UPDATE chapitre SET choix2=:newchoix2  WHERE id_chapitre=:idchap');
        $requete3->execute(array('newchoix2'=> escape($_POST["choix2"]),'idchap'=>$_GET['idchap']));
        
        $requete4 = $BDD->prepare('UPDATE chapitre SET choix3=:newchoix3 WHERE id_chapitre=:idchap');
        $requete4->execute(array('newchoix3'=> escape($_POST["choix3"]),'idchap'=>$_GET['idchap']));
       
        $requete4 = $BDD->prepare('UPDATE chapitre SET modif_vie=:newvie WHERE id_chapitre=:idchap');
        $requete4->execute(array('newvie'=> $_POST["vie"],'idchap'=>$_GET['idchap']));
    }
    redirect("modification.php?id=".$_GET['id']);
}
?>