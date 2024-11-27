<?php
session_start();

// Inclure l'autoload de Composer
require_once __DIR__ . '/vendor/autoload.php';
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
    die("Veuillez vous connecter pour accéder à la facture.");
}

// Vérifier si un ID de commande est passé
if (!isset($_GET['commande_id'])) {
    die("Aucune commande spécifiée.");
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
        die("Commande introuvable.");
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
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}

// Créer un nouveau document PDF
$pdf = new TCPDF();

// Configurer le document
$pdf->SetCreator('Pizzeria');
$pdf->SetAuthor('Pizzeria Delicioso');
$pdf->SetTitle('Facture');
$pdf->SetSubject('Facture de commande');

// Ajouter une page
$pdf->AddPage();

// Contenu du PDF
$html = '
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        line-height: 1.6;
        color: #333;
    }
    h1 {
        font-size: 24px;
        text-align: center;
        color: #5C8A8A;
        margin-bottom: 20px;
    }
    h2 {
        font-size: 18px;
        color: #5C8A8A;
        margin-bottom: 10px;
    }
    p {
        font-size: 12px;
        margin: 5px 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    table th, table td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
        color: #333;
    }
    table td {
        color: #555;
    }
    table tfoot tr td {
        font-weight: bold;
    }
    .total {
        text-align: right;
        padding-right: 20px;
    }
   
</style>
<img src="image/logo.webp" alt="Logo de Ma Pizzeria" style="width: 40px; height: 40px; border-radius: 20px;">
<span style="color: #000; font-size: 16px;">La Pizzeria Delicioso</span>
<h1>Facture</h1>

<h2>Détails de la commande</h2>
<p><strong>Numéro de commande :</strong> ' . htmlspecialchars($commande['numero_COMMANDE']) . '</p>
<p><strong>Date :</strong> ' . htmlspecialchars($commande['date_COMMANDE']) . '</p>
<p><strong>Statut :</strong> ' . htmlspecialchars($commande['statut_COMMANDE']) . '</p>

<h2>Informations sur le client</h2>
<p><strong>Nom :</strong> ' . htmlspecialchars($commande['nom_CLIENT']) . '</p>
<p><strong>Téléphone :</strong> ' . htmlspecialchars($commande['telephone_CLIENT']) . '</p>
<p><strong>Email :</strong> ' . htmlspecialchars($commande['mail_CLIENT']) . '</p>

<h2>Informations sur le livreur</h2>
<p><strong>Nom :</strong> ' . htmlspecialchars($commande['nom_LIVREUR']) . '</p>
<p><strong>Téléphone :</strong> ' . htmlspecialchars($commande['telephone_LIVREUR']) . '</p>

<h2>Détails des produits</h2>
<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Prix Unitaire (€)</th>
            <th>Quantité</th>
            <th>Total (€)</th>
        </tr>
    </thead>
    <tbody>';

// Calculer le total
$totalCommande = 0;
foreach ($produits as $produit) {
    $totalProduit = $produit['prix_unitaire_PRODUIT'] * $produit['quantite_LIGNE_DE_COMMANDE'];
    $totalCommande += $totalProduit;
    $html .= '
        <tr>
            <td>' . htmlspecialchars($produit['designation_PRODUIT']) . '</td>
            <td>' . number_format($produit['prix_unitaire_PRODUIT'], 2) . '</td>
            <td>' . htmlspecialchars($produit['quantite_LIGNE_DE_COMMANDE']) . '</td>
            <td>' . number_format($totalProduit, 2) . '</td>
        </tr>';
}

$html .= '
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="total">Total :</td>
            <td>' . number_format($totalCommande, 2) . ' €</td>
        </tr>
    </tfoot>
</table>';

$html .= '</body>';

// Ajouter le contenu HTML au PDF
$pdf->writeHTML($html);

// Générer et télécharger le fichier PDF
$pdf->Output('Facture_' . $commande['numero_COMMANDE'] . '.pdf', 'D');
