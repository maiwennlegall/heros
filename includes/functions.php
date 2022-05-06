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
function premier_ch_non_fini() {
    global $BDD;
    $requete = "SELECT * FROM chapitre WHERE id_hist=?";
    $response = $BDD->prepare($requete);
    $response->execute(array($_GET['histoire']));
        
    while($tuple = $response->fetch()) {
        $newRequete = "SELECT * FROM chapitre WHERE id_hist=?";
        $res = $BDD->prepare($newRequete);
        $res->execute(array($_GET['histoire']));

        $test = false;
        $valeur = $tuple['id_ch_choix1'];
        $text_choix = $tuple['choix1'];
        if($tuple['id_ch_choix1']==null) 
            $test=true;
        else
        {
            while($newtuple = $res->fetch()){ 
                if($tuple['id_ch_choix1']==$newtuple['id_chapitre'])
                {
                    $valeur = $tuple['id_ch_choix2'];
                    $text_choix = $tuple['choix2'];
                }
                if($tuple['id_ch_choix2']==$newtuple['id_chapitre'])
                {
                    $valeur = $tuple['id_ch_choix3'];
                    $text_choix = $tuple['choix3'];
                }
                if($tuple['id_ch_choix3']==$newtuple['id_chapitre'])
                     $test = true;
            }            
        }
        if($test == false)
        {
            return [$valeur, $tuple['textes'], $text_choix]; 
        }
    }
    return [null, null, null];
}