<!-- FORMULAIRE D'INSCRIPTION-->
<div class="signup-container" id="inscription">
  <h2>Créer un compte</h2>
  <form id="signupForm" method="post" action="register.php">
    <div class="forme_groupe">
      <label for="nom_CLIENT">Nom</label>
      <input type="text" id="nom_CLIENT" name="nom_CLIENT" placeholder="Entrez votre nom complet" required>
    </div>
    <div class="forme_groupe">
      <label for="mail_CLIENT">Adresse Email</label>
      <input type="email" id="mail_CLIENT" name="mail_CLIENT" placeholder="Entrez votre email" required>
    </div>
    <div class="forme_groupe">
      <label for="telephone_CLIENT">Téléphone</label>
      <input type="tel" id="telephone_CLIENT" name="telephone_CLIENT" placeholder="Entrez votre numéro de téléphone" required>
    </div>
    <div class="forme_groupe">
      <label for="adresse_CLIENT">Adresse</label>
      <textarea id="adresse_CLIENT" name="adresse_CLIENT" placeholder="Entrez votre adresse" required></textarea>
    </div>
    <div class="forme_groupe">
      <label for="password_CLIENT">Mot de Passe</label>
      <input type="password" id="password_CLIENT" name="password_CLIENT" placeholder="Créez un mot de passe" required>
    </div>
    <div class="forme_groupe">
      <label for="confirm_password">Confirmer Mot de Passe</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
    </div>
    <button type="submit" class="btn-signup">S'inscrire</button>
  </form>
</div>
