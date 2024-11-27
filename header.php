<?php 
 session_start(); // S'assurer que la session est démarrée
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Pizzeria</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="Accueilstyle.css">
  <link rel="stylesheet" href="offrestyle.css">
  <link rel="stylesheet" href="menu.css">
  <link rel="stylesheet" href="panier.css">
  <script src="script.js" defer ></script>
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="#">
          <img src="image/logo.webp" alt="Logo de Ma Pizzeria" class="logo-image">
          <span class="logo-text">Ma Pizzeria</span>
        </a>
      </div>
      <ul class="nav-links">
        <?php
        if (isset($_SESSION['user_id'], $_SESSION['user_mail'])): ?>
          <li><a href="Accueil.php#menu">Menu</a></li>
          <li><a href="commandes.php" >Commandes</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="panier.php" id="VoirPanier">Voir le Panier</a></li>
          <li><a href="Deconnexion.php" class="btn">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="#accueil">Accueil</a></li>
          <li><a href="#offresspeciale">Offres</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="#connexion" class="btn">Connexion</a></li>
        <?php endif; ?>
      </ul>
      <div class="burger">
        <div class="ligne"></div>
        <div class="ligne"></div>
        <div class="ligne"></div>
      </div>
    </nav>
  </header>
</body>
</html>
