<?php
include("header.php");

// Tableau des pizzas (doit correspondre à celui de menu.php)
$pizzas = [
    1 => ['nom' => 'Pizza Margherita', 'prix' => 8.99],
    2 => ['nom' => 'Pizza Végétarienne', 'prix' => 10.99],
    3 => ['nom' => 'Pizza Quattro Formaggi', 'prix' => 12.99],
    4 => ['nom' => 'Pizza Pepperoni', 'prix' => 9.99],
    5 => ['nom' => 'Pizza Hawaïenne', 'prix' => 11.99],
    6 => ['nom' => 'Pizza 4 Saisons', 'prix' => 13.49],
    7 => ['nom' => 'Pizza Mexicaine', 'prix' => 14.99],
    8 => ['nom' => 'Pizza Bianco', 'prix' => 12.49],
];

// Récupérer le panier
$panier = $_SESSION['panier'] ?? [];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Ma Pizzeria</title>
    <link rel="stylesheet" href="panier.css">
</head>

    <main id="panier">
        <?php if (empty($panier)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Pizza</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($panier as $id => $quantite): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pizzas[$id]['nom']); ?></td>
                            <td><?php echo $quantite; ?></td>
                            <td><?php echo number_format($pizzas[$id]['prix'], 2, ',', ' ') . ' €'; ?></td>
                            <td><?php echo number_format($quantite * $pizzas[$id]['prix'], 2, ',', ' ') . ' €'; ?></td>
                        </tr>
                        <?php $total += $quantite * $pizzas[$id]['prix']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?php echo number_format($total, 2, ',', ' ') . ' €'; ?></td>
                    </tr>
                </tfoot>
            </table>
            <a href="valider_commande.php" class="btnV">Valider la commande</a>
        <?php endif; ?>
    </main>
</body>
</html>
