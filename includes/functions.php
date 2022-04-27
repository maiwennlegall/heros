<?php

include("connect.php");
// Connect to the database. Returns a PDO object
function getDb() {
    // Local deployment
    /* $server = "localhost";
    $username = "mymovies_user";
    $password = "secret";
    $db = "mymovies"; */
    
    // Deployment on Heroku with ClearDB for MySQL
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);
    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

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

//regarder quelle la suite à faire, le texte du choix et 
/*function premier_ch_non_fini() {
    $maReq = "SELECT * FROM chapitre";
    $reponse = $BDD -> query($maReq);
    while($tuple = $res->fetch()) {
        
        $maNewReq = "SELECT * FROM chapitre";
        $newReponse = $BDD -> query($maNewReq);
        $test = false;
        $valeur = $tuple['id_ch_choix1'];
        $text_choix = $tuple['choix1'];
        if($tuple['id_ch_choix1']==null) //signie que le chapitre est fini pas la peine de parcourir
            $test=true;
        else
        {
            while($newtuple = $res->fetch()){ 
                if($tuple['id_ch_choix1']==$newtuple['identifiant'])
                {
                    $valeur = $tuple['id_ch_choix2'];
                    $text_choix = $tuple['choix2'];
                }
                if($tuple['id_ch_choix2']==$newtuple['identifiant'])
                {
                    $valeur = $tuple['id_ch_choix3'];
                    $text_choix = $tuple['choix3'];
                }
                if($tuple['id_ch_choix3']==$newtuple['identifiant'])
                     $test = true;
            }            
        }
        if($test == false)
        {
            return [$valeur, $tuple['texte'], $text_choix]; //permet de savoir le chapitre à remplir mais aussi
                                                    // les textes du ch d'où ça provient et de la reponse choisie !
        }
    }
    return [null, null, null];
}*/