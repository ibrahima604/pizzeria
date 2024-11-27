<!--FORMULAIRE DE CONNEXION-->
<div class="login-container" id="connexion">
    <h2>Connexion</h2>
    <form id="loginForm" method="POST">
  <div class="form-group">
    <label for="email">Adresse Email</label>
    <input type="email" id="email" name="email" placeholder="Votre email" required>
</div>
  <div class="form-group">
    <label for="password">Mot de Passe</label>
    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
  </div>
  <button type="submit" class="btn-login">Se Connecter</button>
</form>


    <div class="or-divider">OU</div>

  <a class="btn-google" id="googleSignIn" 
   href="https://accounts.google.com/o/oauth2/v2/auth?
   response_type=code&
   scope=email&
   access_type=online&
   redirect_uri=<?php echo urlencode('https://1234-5678.ngrok.io/Accueil.php'); ?>&
   client_id=<?php echo GOOGLE_ID; ?>">
   Se Connecter avec Google
</a>
    <p class="signup-link">
      Pas de compte ? <a href="#inscription" id="createAccount">Créer un compte</a>
    </p>
  </div>