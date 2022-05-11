
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



let div_message = document.getElementById('message');

let bouton=document.getElementById("submit");

let contenu =document.getElementById('mdp')
bouton.addEventListener("click",(e)=>
{
    e.preventDefault() //éviter le comportement par défault qui est de recharger la page
    let [message,erreurs]=tester_mot_de_passe(contenu.value);
    div_message.innerHTML=message;


    const laListe=document.createElement('ul');
    
    for (let i=0;i<erreurs.length;i++)
    {
        const unePuce=document.createElement('li');
        unePuce.textContent=erreurs[i]
        laListe.appendChild(unePuce);
    }
    
    div_message.appendChild(laListe);
})
