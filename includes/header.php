<?php session_start() ?>
<?php require_once "includes/scripts.php"; ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="test">
    <img src="includes/crown.png" id="logo">
    <a class="navbar-brand" href="../../heros/accueil.php" id="test2">Story of your life</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION["login"]))
        {
          $premReq = "SELECT administrateur FROM utilisateur WHERE id_joueur=:id";
          $repp = $BDD -> prepare($premReq);
          $repp -> execute(array("id" => $_SESSION["login"] ));
          $line = $repp -> fetch();
          if($line['administrateur']!=0)
          {
            ?> <li class="nav-item">
            <a class="nav-link" href="../../heros/creationhistoire.php" id="test4">Création histoire</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../../heros/administrateur.php" id="test4">Administrateur</a>
            </li>
            <?php
          }
        }
        ?>
        <li class="nav-item active">
          
          <?php if(isset($_SESSION["login"]))
          { 
            
            ?> <a class="nav-link" href="../../heros/deconnexion.php" id="test3" > Deconnexion de <?php echo $_SESSION["login"];
          }
          else
          {
            ?> <a class="nav-link" href="../../heros/connexion.php" id="test3" > Connexion <?php
          }
          ?>
          </a>
        </li>
        
      </ul>
    </div>
  </nav>
