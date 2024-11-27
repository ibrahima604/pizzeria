<?php
session_start();    
// Configuration de la base de données
$host = 'localhost'; // Nom du serveur
$dbname = 'gestion_pizzeria'; // Nom de votre base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Création de la connexion avec PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer PDO pour afficher les erreurs sous forme d'exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gérer les erreurs de connexion
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour voir vos commandes.";
    exit();
}

$CLIENT_numero_CLIENT = $_SESSION['user_id'];

try {
    // Préparer la requête pour récupérer les commandes de l'utilisateur
    $stmt = $db->prepare("
        SELECT c.numero_COMMANDE, c.date_COMMANDE, c.statut_COMMANDE, 
               GROUP_CONCAT(p.designation_PRODUIT SEPARATOR ', ') AS produits,
               SUM(l.quantite_LIGNE_DE_COMMANDE * p.prix_unitaire_PRODUIT) AS total
        FROM commande c
        LEFT JOIN ligne_de_commande l ON c.numero_COMMANDE = l.COMMANDE_numero_COMMANDE
        LEFT JOIN produit p ON l.PRODUIT_reference_PRODUIT = p.reference_PRODUIT
        WHERE c.CLIENT_numero_CLIENT = ?
        GROUP BY c.numero_COMMANDE
        ORDER BY c.date_COMMANDE DESC
    ");
    $stmt->execute([$CLIENT_numero_CLIENT]);

    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>
    <link rel="stylesheet" href="commandes.css"> <!-- Inclure vos CSS -->
</head>
<body>
    <header>
        <!-- Inclure la barre de navigation ici -->
    </header>

    <main>
        <h1>Mes Commandes</h1>
        <?php if (empty($commandes)): ?>
            <p>Vous n'avez pas encore passé de commande.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Produits</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($commande['numero_COMMANDE']); ?></td>
                            <td><?php echo htmlspecialchars($commande['date_COMMANDE']); ?></td>
                            <td><?php echo htmlspecialchars($commande['statut_COMMANDE']); ?></td>
                            <td><?php echo htmlspecialchars($commande['produits']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($commande['total'], 2)); ?> €</td>
                            <td>
                                <!-- Lien pour afficher la facture -->
                                <a href="facture.php?commande_id=<?php echo $commande['numero_COMMANDE']; ?>">Voir la facture</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>
