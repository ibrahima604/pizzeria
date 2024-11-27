
<?php
include("config.php");
// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données envoyées
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'gestion_pizzeria';
    $username = 'root';
    $password_db = '';

    try {
        // Établir la connexion avec PDO
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recherche de l'utilisateur par email
        $stmt = $conn->prepare("SELECT * FROM client WHERE mail_CLIENT = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Vérification si l'utilisateur existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if (password_verify($password, $user['password_CLIENT'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $user['numero_CLIENT'];
                $_SESSION['user_mail'] = $user['mail_CLIENT'];
                $_SESSION['user_nom'] = $user['nom_CLIENT'];
                if (!isset($_SESSION['last_activity'])) {
                  $_SESSION['last_activity'] = time(); // Enregistre l'heure de la dernière activité
              }
          
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
 <section id="home" class="hero scroll-item">
    <img src="image/pizzeria.jpg" alt="Pizzeria Image">
    <h1>Bienvenue à La Pizzeria Delicioso</h1>
    <p>Les meilleures pizzas de la ville, préparées avec passion et des ingrédients frais !</p>
    <a href="#pizzas" class="btn">Découvrez Nos Pizzas</a>
  </section>
<?php 
include("connexion.php");
include('inscription.php');
include('offres.php');
  ?>

  <!-- Section À Propos -->
  <section id="about" class="about scroll-item">
    <h2>À Propos de Nous</h2>
    <div class="about-content">
      <img src="image/pizzeriaint.webp" alt="Intérieur de la pizzeria" class="about-img">
      <div class="about-text">
        <p>
          Depuis 1995, La Pizzeria Delicioso s'est engagée à offrir les meilleures pizzas de la ville.
          Nos chefs passionnés utilisent des ingrédients frais et locaux pour créer des saveurs authentiques
          qui vous transportent directement en Italie.
        </p>
        <p>
          Notre mission est simple : offrir une expérience inoubliable à chaque client, que ce soit sur place
          ou à emporter. Découvrez notre ambiance chaleureuse et notre menu varié conçu pour satisfaire
          toutes les envies.
        </p>
      </div>
    </div>
  </section>
  


  <!-- Section Contact -->
<?php 
include('contact.php');
?>