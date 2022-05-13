<?php session_start() ?>
<?php 
    include("includes/connect.php");
    require_once "includes/functions.php";
    require_once "includes/head.php";

if(isset($_GET['id'])&&isset($_GET['idchap'])) 
{ 
    $texte = escape($_POST["texte"]);
    $choix1 = escape($_POST["choix1"]);
    $choix2 = escape($_POST["choix2"]);
    $choix3= escape($_POST["choix3"]);

    if(!empty($_POST["texte"])&&!empty($_POST["choix1"])&&!empty($_POST["choix2"])&&!empty($_POST["choix3"]))

    {
        //mise à jour des nouvelles données dans les champs de la table chapitre
        
        $requete1 = $BDD->prepare('UPDATE chapitre SET textes=:newtext WHERE id_chapitre=:idchap');
        $requete1->execute(array('newtext' => $texte,'idchap'=>$_GET['idchap']));
        
        $requete2 = $BDD->prepare('UPDATE chapitre SET choix1=:newchoix1 WHERE id_chapitre=:idchap');
        $requete2->execute(array('newchoix1'=> $choix1,'idchap'=>$_GET['idchap']));
        
        $requete3 = $BDD->prepare('UPDATE chapitre SET choix2=:newchoix2  WHERE id_chapitre=:idchap');
        $requete3->execute(array('newchoix2'=> $choix2,'idchap'=>$_GET['idchap']));
        
        $requete4 = $BDD->prepare('UPDATE chapitre SET choix3=:newchoix3 WHERE id_chapitre=:idchap');
        $requete4->execute(array('newchoix3'=> $choix3,'idchap'=>$_GET['idchap']));
    }
    
    
    if($_POST["vie"]==0)
    {
        $requete5 = $BDD->prepare('UPDATE chapitre SET modif_vie=:newvie WHERE id_chapitre=:idchap');
        $requete5->execute(array('newvie'=> $_POST["vie"],'idchap'=>$_GET['idchap']));
    }
    else if(!empty($_POST["vie"])) 
    {    
        $requete5 = $BDD->prepare('UPDATE chapitre SET modif_vie=:newvie WHERE id_chapitre=:idchap');
        $requete5->execute(array('newvie'=> $_POST["vie"],'idchap'=>$_GET['idchap']));
    }
    redirect("modification.php?id=".$_GET['id']);
}
?>