function tester_mot_de_passe(mdp){
let contient_un_chiffre = false;
let contient_une_majuscule = false;
let contient_une_minuscule = false;

let mdp_array = mdp.split('');
for (const c of mdp_array){
if (!isNaN(parseInt(c)))
contient_un_chiffre = true;
else if (c == c.toUpperCase())
contient_une_majuscule = true;
else if (c == c.toLowerCase())
contient_une_minuscule = true;
}

let erreurs = [];
let message = "";
if (!contient_un_chiffre)
erreurs.push("Le mot de passe doit contenir un chiffre");
if (!contient_une_majuscule)
erreurs.push("Le mot de passe doit contenir une majuscule");
if (!contient_une_minuscule)
erreurs.push("Le mot de passe doit contenir une minuscule");
if (mdp.length < 8)
erreurs.push("Le mot de passe doit faire plus de 8 caractères");

if (erreurs.length > 0)
message = "Ce mot de passe est incorrect"
else
message = "Ce mot de passe est valide";

return [message, erreurs]
}