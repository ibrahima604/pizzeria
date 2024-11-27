<?php
// Définir un tableau avec les données des offres
$offres = [
  [
    'titre' => 'Pizza Margherita',
    'description' => 'Une pizza classique avec sauce tomate, mozzarella et basilic frais.',
    'prix' => 8.99,
    'image_url' => 'image/margherita.jpg',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'margherita',
  ],
  [
    'titre' => 'Pizza Végétarienne',
    'description' => 'Une pizza végétarienne avec des légumes frais et mozzarella.',
    'prix' => 10.99,
    'image_url' => 'image/vegetarienne.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'vegetarienne',
  ],
  [
    'titre' => 'Pizza Quattro Formaggi',
    'description' => 'Une pizza avec quatre types de fromages pour les amateurs de fromage.',
    'prix' => 12.99,
    'image_url' => 'image/formaggi.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'formaggi',
  ],
  [
    'titre' => 'Pizza Pepperoni',
    'description' => 'Une pizza classique avec du pepperoni épicé et du fromage fondu.',
    'prix' => 9.99,
    'image_url' => 'image/pepperoni.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'pepperoni',
  ],
  [
    'titre' => 'Pizza Hawaïenne',
    'description' => 'Une pizza avec du jambon, de l\'ananas et de la mozzarella.',
    'prix' => 11.99,
    'image_url' => 'image/hawaienne.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'hawaienne',
  ],
  [
    'titre' => 'Pizza 4 Saisons',
    'description' => 'Une pizza avec artichauts, jambon, champignons et olives.',
    'prix' => 13.49,
    'image_url' => 'image/4saison.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => '4saisons',
  ],
  [
    'titre' => 'Pizza Mexicaine',
    'description' => 'Une pizza épicée avec viande hachée, poivrons, oignons et sauce salsa.',
    'prix' => 14.99,
    'image_url' => 'image/mexicaine.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'mexicaine',
  ],
  [
    'titre' => 'Pizza Bianco',
    'description' => 'Une pizza sans sauce tomate avec ricotta, mozzarella, parmesan et épinards.',
    'prix' => 12.49,
    'image_url' => 'image/bianco.png',
    'date_debut' => '2024-11-01 00:00:00',
    'date_fin' => '2024-11-30 23:59:59',
    'slug' => 'bianco',
  ],
];

?>
<main>
  <h1>Nos Offres Spéciales</h1>
  <div class="offres-container" id="offresspeciale">
    <?php foreach ($offres as $offre): ?>
      <div class="offre">
        <img src="<?php echo htmlspecialchars($offre['image_url']); ?>" alt="<?php echo htmlspecialchars($offre['titre']); ?>" class="offre-image">
        <h2><?php echo htmlspecialchars($offre['titre']); ?></h2>
        <p><?php echo htmlspecialchars($offre['description']); ?></p>
        <p><strong>Prix : </strong><?php echo number_format($offre['prix'], 2, ',', ' ') . ' €'; ?></p>
        <p><strong>Période : </strong><?php echo date('d/m/Y', strtotime($offre['date_debut'])) . ' - ' . date('d/m/Y', strtotime($offre['date_fin'])); ?></p>
        <a href="verif_connexion.php?offre=<?php echo urlencode($offre['slug']); ?>"  id="profiterdeloffre">Profiter de l'offre</a>
      </div>
    <?php endforeach; ?>
  </div>
  <?php
  include('script.php');
  ?>
</main>