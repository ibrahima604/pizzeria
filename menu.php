<?php
if (isset($_SESSION['user_id']) && !empty(trim($_SESSION['user_id']))) {
    // Tableau des pizzas
$pizzas = [
    1 => ['nom' => 'Pizza Margherita', 'prix' => 8.99, 'image_url' => 'image/margherita.jpg'],
    2 => ['nom' => 'Pizza Végétarienne', 'prix' => 10.99, 'image_url' => 'image/vegetarienne.png'],
    3 => ['nom' => 'Pizza Quattro Formaggi', 'prix' => 12.99, 'image_url' => 'image/formaggi.png'],
    4 => ['nom' => 'Pizza Pepperoni', 'prix' => 9.99, 'image_url' => 'image/pepperoni.png'],
    5 => ['nom' => 'Pizza Hawaïenne', 'prix' => 11.99, 'image_url' => 'image/hawaienne.png'],
    6 => ['nom' => 'Pizza 4 Saisons', 'prix' => 13.49, 'image_url' => 'image/4saison.png'],
    7 => ['nom' => 'Pizza Mexicaine', 'prix' => 14.99, 'image_url' => 'image/mexicaine.png'],
    8 => ['nom' => 'Pizza Bianco', 'prix' => 12.49, 'image_url' => 'image/bianco.png'],
];
?>
    <main id="menu">
        <h2>Nos Pizzas</h2>
        <div class="menu-container">
            <?php foreach ($pizzas as $id => $pizza): ?>
          <div class="pizza-item">
                    <img src="<?php echo htmlspecialchars($pizza['image_url']); ?>" alt="<?php echo htmlspecialchars($pizza['nom']); ?>" class="pizza-image">
                    <h3><?php echo htmlspecialchars($pizza['nom']); ?></h3>
                    <p><strong>Prix : </strong><?php echo number_format($pizza['prix'], 2, ',', ' ') . ' €'; ?></p>
                    <a href="ajouter_panier.php?pizza_id=<?php echo $id; ?>" class="btnp">Ajouter au panier</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php }
else{
echo "Utilisateur non authentifié. Veuillez vous connecter.";
exit();
}

 ?>
