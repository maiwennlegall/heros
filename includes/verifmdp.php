<?php
function testmdp($mdp)
{
    $contient_un_chiffre = false;
    $contient_une_majuscule = false;
    $contient_une_minuscule = false;

    
    for ($i=0;$i<strlen($mdp);$i++){
    if (!isNaN(parseInt($mdp[i])))
        $contient_un_chiffre = true;
    else if ($mdp[i] == $mdp[i].toUpperCase())
        $contient_une_majuscule = true;
    else if ($mdp[i] == $mdp[i].toLowerCase())
        $contient_une_minuscule = true;
    }

    $erreurs = [];
    $message = "";
    if (!$contient_un_chiffre)
        $erreurs.push("Le mot de passe doit contenir un chiffre");
    if (!$contient_une_majuscule)
        $erreurs.push("Le mot de passe doit contenir une majuscule");
    if (!$contient_une_minuscule)
        $erreurs.push("Le mot de passe doit contenir une minuscule");
    if ($mdp.length < 8)
        $erreurs.push("Le mot de passe doit faire plus de 8 caractères");
    
    if ($erreurs.length > 0)
        $message = "Ce mot de passe est incorrect"
    else
        $message = "Ce mot de passe est valide";
    
    return [$message, $erreurs]


}


?>