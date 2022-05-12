<?php

include("connect.php");


// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['login']);
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}

function premier_ch_non_fini() {
    global $BDD;
    $requete = "SELECT * FROM chapitre WHERE id_hist=?";
    $response = $BDD->prepare($requete);
    $response->execute(array($_GET['histoire']));
        
    while($tuple = $response->fetch()) {
        

        $test = false;
        $valeur = $tuple['id_ch_choix1'];
        $text_choix = $tuple['choix1'];
        if($tuple['id_ch_choix1']==NULL) 
            $test=true;
        else
        {
            $newRequete = "SELECT * FROM chapitre WHERE id_hist=:hist";
            $res = $BDD->prepare($newRequete);
            $res->execute(array(
                'hist' => $_GET['histoire']));
            $pasun = false;
            $pasundeux = false;
            while($newtuple = $res->fetch()){ 
                    if($tuple['id_ch_choix1']==$newtuple['id_chapitre'] && !$pasun && !$pasundeux)
                    {
                        $valeur = $tuple['id_ch_choix2'];
                        $text_choix = $tuple['choix2'];
                    }
                    if($tuple['id_ch_choix2']==$newtuple['id_chapitre'] && !$pasundeux)
                    {
                        $valeur = $tuple['id_ch_choix3'];
                        $text_choix = $tuple['choix3'];
                        $pasun = true;
                    }
                    if($tuple['id_ch_choix3']==$newtuple['id_chapitre'])
                    {
                        $test = true;
                        $pasundeux = true;
                    }
            }            
        }
        if($test == false)
        {
            return [$valeur, $tuple['textes'], $text_choix]; 
        }
    }
    return [null, null, null];
}