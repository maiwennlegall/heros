<!-- jQuery
<script src="includes/lib/jquery-3.4.1.slim.js"></script>
 JavaScript Boostrap plugin 
<script src="includes/lib/bootstrap.js"></script>-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>
        function myFunction(tartiflette, b) {
            b = typeof b !== 'undefined' ?  b : 1;
            let text = "Vous avez déjà commencé cette histoire ! \nVoulez vous la recommencer ? \nCliquer sur OK pour la recommencer, sinon sur Annuler";
            if (confirm(text) == true) {
                window.location.href='lecturehistoire.php?hist='+tartiflette+'&ch='+b+'&debut=true';
            } 
        }
</script>

<script>
    function choix_joueur(tartiflette){
        window.location.href='traitement_donnes.php?choix='.tartiflette;
    }
</script>