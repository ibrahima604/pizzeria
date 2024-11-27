<?php
session_start();

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données envoyées
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'gestion_pizzeria';
    $username = 'root';
    $password = '';

    try {
        // Établir la connexion avec PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recherche de l'utilisateur par email
        $stmt = $conn->prepare("SELECT * FROM client WHERE mail_CLIENT = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Vérification si l'utilisateur existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $user['numero_CLIENT'];
                $_SESSION['user_mail'] = $user['mail_CLIENT'];
                echo'Connexion reussie avec succes';

                // Rediriger l'utilisateur après la connexion réussie
                header("Location: Accueil.php");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>
