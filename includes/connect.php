<?php
    $host = "localhost";
    $dbname = "storyofyourlife";
    $username = "storyofyourlife";
    $password = "herooflife";

    try 
    {
        $BDD = new PDO( "mysql:host=".$host.";dbname=".$dbname.";charset=utf8",
        $username,$password);
    }
    catch (Exception $e) 
    {
        die('Erreur fatale : ' . $e->getMessage());
    }

#,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION)
?>

