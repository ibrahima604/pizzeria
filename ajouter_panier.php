<?php
session_start();

// Vérifier si le panier existe, sinon l'initialiser
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Récupérer l'ID de la pizza
if (isset($_GET['pizza_id'])) {
    $pizza_id = intval($_GET['pizza_id']);

    // Ajouter ou incrémenter la quantité dans le panier
    if (isset($_SESSION['panier'][$pizza_id])) {
        $_SESSION['panier'][$pizza_id]++;
    } else {
        $_SESSION['panier'][$pizza_id] = 1;
    }

    header('Location: Accueil.php#menu');
    exit();
} else {
    echo "Erreur : Aucune pizza sélectionnée.";
}
