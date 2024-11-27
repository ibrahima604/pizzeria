<?php
  include("header.php");
if (isset($_SESSION['user_id']) && !empty(trim($_SESSION['user_id']))) {
    if (isset($_SESSION["user_nom"]) && !empty($_SESSION["user_nom"])) { ?>
        <div id=info>
            <h3><?php echo "Bienvenue Dans le monde des PIZZAS Monsieur " . $_SESSION["user_nom"] ?></h3>

        </div>
<?php 
}
    include("menu.php");
    //include("commandes.php");
    include("contact.php");
    include("footer.php");
    //include('script.php');
} else {
    echo "Utilisateur non authentifié. Veuillez vous connecter.";
    exit();
} ?>
