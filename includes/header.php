<?php session_start() ?>
<?php require_once "includes/scripts.php"; ?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="test">
    <img src="includes/crown.png" id="logo" alt="logo du site représentant une couronne dorée">
    <a class="navbar-brand" href=".../../heros/index.php" id="test2">Story of your life</a>
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
            <a class="nav-link" href="../../heros/creationhistoire.php">Création histoire</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../../heros/administrateur.php">Administrateur</a>
            </li>
            <?php
          }
        }
        ?>
        <li class="nav-item">
          
          <?php if(isset($_SESSION["login"]))
          { 
            
            ?> <a class="nav-link" href="../deconnexion.php"> Deconnexion de <?php echo $_SESSION["login"];
          }
          else
          {
            ?> <a class="nav-link" href="../heros/connexion.php"> Connexion <?php
          }
          ?>
          </a>
        </li>
        
      </ul>
    </div>
  </nav>
