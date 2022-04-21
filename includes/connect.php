<?php
    try 
    {
        $BDD = new PDO( "mysql:host=localhost;dbname=storyofyourlife;charset=utf8",
        "storyofyourlife","herooflife", array(PDO::ATTR_ERRMODE
        =>PDO::ERRMODE_EXCEPTION));
    }
    catch (Exception $e) 
    {
        die('Erreur fatale : ' . $e->getMessage());
    }
?>