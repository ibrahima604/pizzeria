let navbar = document.querySelector(".nav-links");
    let burger = document.querySelector(".burger");
    burger.addEventListener("click", () => {
      burger.classList.toggle("toggle");
      navbar.classList.toggle("nav-active");
    });

    function handleResize() {
      if (window.innerWidth > 768) {
        navbar.classList.remove("nav-active");
        burger.classList.remove("toggle");
      } else {
        // Optionnel : Ajouter la classe si la largeur est inférieure à 768px et le menu burger est actif
        // if (navLinks.classList.contains("nav-active") && !burger.classList.contains("toggle")) {
        //     burger.classList.add("toggle");
        // }
      }
    }

    window.addEventListener("resize", handleResize);

    // Exécuter la fonction handleResize lors du chargement pour s'assurer que l'état initial est correct
    handleResize();
let btnconnexion=document.querySelector(".btn")
let formulConnexion=document.querySelector(".login-container")
let profiteroffre=document.getElementById("profiterdeloffre")
btnconnexion.addEventListener("click",()=>{
  if( formulConnexion.style.display==="none"){
    formulConnexion.style.display="block";

  }
  else{
    formulConnexion.style.display="none";}
  
})
    //Pour traiter le lien de l'offre
  profiteroffre.addEventListener("click",()=>{
  if( formulConnexion.style.display==="none"){
    formulConnexion.style.display="block";

  }
  else{
    formulConnexion.style.display="none";}
  
})
 // Fonction pour vérifier si un élément est visible
  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return rect.top <= window.innerHeight && rect.bottom >= 0;
  }

// Simuler une redirection vers la page de création de compte
let formulInscription = document.querySelector(".signup-container");
// Afficher le formulaire d'inscription lorsqu'on clique sur "Créer un compte"
document.getElementById("createAccount").addEventListener("click", () => {
  formulConnexion.style.display = "none";
  formulInscription.style.display = "block";
});

// Fermer le formulaire d'inscription si on clique n'importe où en dehors du formulaire
document.addEventListener("click", (e) => {
  if (!formulInscription.contains(e.target) && !document.getElementById("createAccount").contains(e.target)) {
    formulInscription.style.display = "none";
  }
});

document.getElementById("signupForm").addEventListener("submit", function (e) {
  const password = document.getElementById("password_CLIENT").value;
  const confirmPassword = document.getElementById("confirm_password").value;
});