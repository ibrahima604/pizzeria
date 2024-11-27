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

// Vérifier si le panier est vide
if (empty($_SESSION['panier'])) {
    echo "Votre panier est vide.";
    exit();
}

// Récupérer l'ID du client depuis la session
if (!isset($_SESSION['user_id'])) {
    echo "Utilisateur non authentifié. Veuillez vous connecter.";
    exit();
}

$CLIENT_numero_CLIENT = $_SESSION['user_id'];
$LIVREUR_numero_LIVREUR = 1; // Vous pouvez implémenter une logique pour assigner un livreur dynamique

try {
    $db->beginTransaction(); // Démarrer une transaction

    // Insérer une nouvelle commande
    $stmtCommande = $db->prepare(
        "INSERT INTO commande (date_COMMANDE, statut_COMMANDE, CLIENT_numero_CLIENT, LIVREUR_numero_LIVREUR)
         VALUES (NOW(), :statut, :client_id, :livreur_id)"
    );
    $statut = 'en cours'; // Statut initial de la commande
    $stmtCommande->execute([
        ':statut' => $statut,
        ':client_id' => $CLIENT_numero_CLIENT,
        ':livreur_id' => $LIVREUR_numero_LIVREUR
    ]);

    // Récupérer l'ID de la commande nouvellement créée
    $COMMANDE_numero_COMMANDE = $db->lastInsertId();

    // Insérer les lignes de commande
    $stmtLigneCommande = $db->prepare(
        "INSERT INTO ligne_de_commande (quantite_LIGNE_DE_COMMANDE, COMMANDE_numero_COMMANDE, PRODUIT_reference_PRODUIT)
         VALUES (:quantite, :commande_numero, :produit_reference)"
    );

    foreach ($_SESSION['panier'] as $produit_reference => $quantite) {
        $stmtLigneCommande->execute([
            ':quantite' => $quantite,
            ':commande_numero' => $COMMANDE_numero_COMMANDE,
            ':produit_reference' => $produit_reference
        ]);
    }

    $db->commit(); // Valider la transaction

    // Vider le panier après validation
    unset($_SESSION['panier']);

    echo "Commande validée avec succès ! Votre numéro de commande est : " . $COMMANDE_numero_COMMANDE;
} catch (Exception $e) {
    $db->rollBack(); // Annuler la transaction en cas d'erreur
    echo "Erreur lors de la validation de la commande : " . $e->getMessage();
}
?>
