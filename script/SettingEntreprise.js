const mp = document.querySelector("#mp");
const mdp = document.querySelector("#mdp");
const rs = document.querySelector("#rs");
const ap = document.querySelector("#ap");
const dip = document.querySelector("#dip");
const tags = document.querySelector("#tags");

const MonProfil = document.querySelector("#MonProfil");
const MotPasse = document.querySelector("#MotPasse");
const ReseauxSociaux = document.querySelector("#ReseauxSociaux");
const Abonnement = document.querySelector("#Abonnement");

const title = document.querySelector("#title");

mp.addEventListener("click", function(event) {
    event.preventDefault();
    title.innerHTML="Profile"; 
});

rs.addEventListener("click", function(event) {
    event.preventDefault();
    rs.classList.toggle("active");
    title.innerHTML="Reseaux Sociaux";
    MonProfil.classList.add("hidden");
    MotPasse.classList.add("hidden");
    ReseauxSociaux.classList.remove("hidden");
    Abonnement.classList.add("hidden");
    mdp.classList.remove("active");
    ap.classList.remove("active");
    mp.classList.remove("active"); 
});

mdp.addEventListener("click", function(event) {
    event.preventDefault();
    title.innerHTML="Mot de Passe";
    MonProfil.classList.add("hidden");
    MotPasse.classList.remove("hidden");
    ReseauxSociaux.classList.add("hidden");
    Abonnement.classList.add("hidden");
    mp.classList.remove("active");
    ap.classList.remove("active");
    rs.classList.remove("active"); 
});

ap.addEventListener("click", function(event) {
    event.preventDefault();
    ap.classList.toggle("active");
    title.innerHTML="Votre abonnement";
    MonProfil.classList.add("hidden");
    MotPasse.classList.add("hidden");
    ReseauxSociaux.classList.add("hidden");
    Abonnement.classList.remove("hidden");
    mdp.classList.remove("active");
    mp.classList.remove("active");
    rs.classList.remove("active"); 
});
