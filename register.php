<?php
session_start();
// Connexion à la base de données (assurez-vous d'utiliser vos propres informations de connexion)
$host = 'localhost';
$dbname = 'gestion_pizzeria';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Récupérer les données du formulaire
        $nom_CLIENT = $_POST['nom_CLIENT'];
        $mail_CLIENT = $_POST['mail_CLIENT'];
        $telephone_CLIENT = $_POST['telephone_CLIENT'];
        $adresse_CLIENT = $_POST['adresse_CLIENT'];
        $password_CLIENT = $_POST['password_CLIENT'];
        $confirm_password = $_POST['confirm_password'];

        // Vérifier si l'email est déjà utilisé
        $stmt = $pdo->prepare("SELECT * FROM client WHERE mail_CLIENT = ?");
        $stmt->execute([$mail_CLIENT]);

        if ($stmt->rowCount() > 0) {
            echo "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        } elseif ($password_CLIENT !== $confirm_password) {
            $_SESSION["ConflitMDP"]="Les mots de passe ne correspondent pas.";
            header('Location: session.php#inscription'); 
            exit();
        } else {
            // Insérer le nouveau client dans la base de données
            $hashedPassword = password_hash($password_CLIENT, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO client (nom_CLIENT, mail_CLIENT, telephone_CLIENT, adresse_CLIENT, password_CLIENT)
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom_CLIENT, $mail_CLIENT, $telephone_CLIENT, $adresse_CLIENT, $hashedPassword]);

            echo "Inscription réussie !";
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
