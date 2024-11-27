<?php
session_start();
// Configuration de la base de données
$host = 'localhost';
$dbname = 'gestion_pizzeria';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour accéder à la facture.";
    exit();
}

// Vérifier si un ID de commande est passé
if (!isset($_GET['commande_id'])) {
    echo "Aucune commande spécifiée.";
    exit();
}

$commande_id = $_GET['commande_id'];

try {
    // Récupérer les détails de la commande
    $stmtCommande = $db->prepare("
        SELECT c.numero_COMMANDE, c.date_COMMANDE, c.statut_COMMANDE, 
               cl.nom_CLIENT, cl.telephone_CLIENT, cl.mail_CLIENT,
               l.nom_LIVREUR, l.telephone_LIVREUR
        FROM commande c
        JOIN client cl ON c.CLIENT_numero_CLIENT = cl.numero_CLIENT
        JOIN livreur l ON c.LIVREUR_numero_LIVREUR = l.numero_LIVREUR
        WHERE c.numero_COMMANDE = ?
    ");
    $stmtCommande->execute([$commande_id]);
    $commande = $stmtCommande->fetch(PDO::FETCH_ASSOC);

    if (!$commande) {
        echo "Commande introuvable.";
        exit();
    }

    // Récupérer les produits de la commande
    $stmtProduits = $db->prepare("
        SELECT p.designation_PRODUIT, p.prix_unitaire_PRODUIT, l.quantite_LIGNE_DE_COMMANDE
        FROM ligne_de_commande l
        JOIN produit p ON l.PRODUIT_reference_PRODUIT = p.reference_PRODUIT
        WHERE l.COMMANDE_numero_COMMANDE = ?
    ");
    $stmtProduits->execute([$commande_id]);
    $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Erreur lors de la récupération des données : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="facture.css"> <!-- Lien vers le fichier CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

        .facture-container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        h1,
        h2 {
            text-align: center;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }

        .btn-print {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            width: fit-content;
        }

        .btn-print:hover {
            background-color: #45a049;
        }

        .logo-image {
            width: 40px;
            height: 40px;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="facture-container">
        <img src="image/logo.webp" alt="Logo de Ma Pizzeria" class="logo-image">
        <span class="logo-text">La Pizzeria Delicioso</span>
        <h1>Facture</h1>
        <div class="section">
            <h2>Détails de la commande</h2>
            <p><strong>Numéro de commande :</strong> <?php echo htmlspecialchars($commande['numero_COMMANDE']); ?></p>
            <p><strong>Date de commande :</strong> <?php echo htmlspecialchars($commande['date_COMMANDE']); ?></p>
            <p><strong>Statut :</strong> <?php echo htmlspecialchars($commande['statut_COMMANDE']); ?></p>
        </div>

        <div class="section">
            <h2>Informations sur le client</h2>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($commande['nom_CLIENT']); ?></p>
            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($commande['telephone_CLIENT']); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($commande['mail_CLIENT']); ?></p>
        </div>

        <div class="section">
            <h2>Informations sur le livreur</h2>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($commande['nom_LIVREUR']); ?></p>
            <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($commande['telephone_LIVREUR']); ?></p>
        </div>

        <div class="section">
            <h2>Détails des produits</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCommande = 0;
                    foreach ($produits as $produit):
                        $totalProduit = $produit['prix_unitaire_PRODUIT'] * $produit['quantite_LIGNE_DE_COMMANDE'];
                        $totalCommande += $totalProduit;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($produit['designation_PRODUIT']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($produit['prix_unitaire_PRODUIT'], 2)); ?> €</td>
                            <td><?php echo htmlspecialchars($produit['quantite_LIGNE_DE_COMMANDE']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($totalProduit, 2)); ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="total">Total :</td>
                        <td><?php echo htmlspecialchars(number_format($totalCommande, 2)); ?> €</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <a href="#" class="btn-print" onclick="window.print(); return false;">Imprimer la facture</a>
        <a href="telecharger_facture.php?commande_id=<?php echo $commande_id; ?>" class="btn-print">Télécharger la facture</a>

    </div>
</body>

</html>