<?php session_start() ?>
<?php include("includes/connect.php"); ?>
<?php
require_once "includes/functions.php";
?>

<!doctype html>
<html>

<?php 
$id_chap = NULL;
$texte = NULL;
$test = true;
            $req = "SELECT * FROM chapitre WHERE (id_ch_choix1=:choix or id_ch_choix2=:choix or id_ch_choix3=:choix) and id_hist=:hist";
            $reponse = $BDD -> prepare($req);
            $reponse ->execute(array(
                "hist" => $_GET["hist"],
                "choix" => $_GET["choix"]
               
            ));
            while($tuple = $reponse->fetch()){
                if($tuple["id_ch_choix1"]==$_GET["choix"] && $test)
                {
                    $texte = $tuple["choix1"];
                    $id_chap = $tuple["id_ch_hors_hist"];
                    $test = false;
                }
                else if($tuple["id_ch_choix2"]==$_GET["choix"] && $test)
                {
                    $texte = $tuple["choix2"];
                    $id_chap = $tuple["id_ch_hors_hist"];
                    $test = false;
                }
                else if($tuple["id_ch_choix3"]==$_GET["choix"] && $test)
                {
                    $texte = $tuple["choix3"];
                    $id_chap = $tuple["id_ch_hors_hist"];
                    $test = false;
                }
            }
            if($id_chap!=NULL)
            {
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
                    "id" => $_GET["choix"],
                    "hist" => $_GET["hist"]
                 ));
                $tuple = $reponse->fetch();

                redirect('lecturehistoire.php?hist='.$_GET["hist"].'&ch='.$tuple['id_ch_hors_hist']);
            }
        ?>

</html>