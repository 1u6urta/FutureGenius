<?php
    //session_start();
    //$_SESSION['type'] = "Candidat";
?>
<nav class="navbar">
        <a href="index.php" class="logo">
            <img src="imgs/logo.png" style="width: 50px;">
            <p>FutureGenius</p>
        </a>
        <div class="nav-links">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li>
                    <div class="search-menu">
                        <div class="search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <p>Rechercher</p>
                        </div>
                        <ul class="search-submenu">
                            <li><a href="offre.php">Trouver un Emploi</a></li>
                            <li><a href="trouveprofil.php">Trouver un Profile</a></li>
                            <li><a href="trouventreprise.php">Trouver une Entreprise</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="index.php#plans">Abonnement payant</a></li>
                <li><a href="index.php#questions">A propos</a></li>
                <li>
                    <?php if (!empty($_SESSION['id']) ) {
                            if ($_SESSION['type'] == "Candidat") {
                            echo '
                        <div class="user-menu">
                            <i class="fa-solid fa-user"></i>
                            <ul class="user-submenu">
                                <li><a href="back/Profil.php">Mon profile</a></li>
                                <li><a href="offresauvgarder.php">Offres sauvgardées</a></li>
                                <li><a href="mescandidatures.php">Mes condidatures</a></li>
                                <li><a href="back/Parametres.php">Parametres</a></li>
                                <li><a href="back/deconnexion.php">Deconnexion</a></li>
                            </ul>
                        </div>
                    ';
                    } else {
                        echo '
                        <div class="user-menu">
                            <i class="fa-solid fa-users"></i>
                            <ul class="user-submenu">
                                <li><a href="back/Profil.php">Mon profile</a></li>
                                <li><a href="offresauvgarder.php">Offres sauvgardées</a></li>
                                <li><a href="mescandidatures.php">Mes Offres</a></li>
                                <li><a href="">Creer Un Emploie</a></li>
                                <li><a href="back/Parametres.php">Parametres</a></li>
                                <li><a href="back/deconnexion.php">Deconnexion</a></li>
                            </ul>
                        </div>'; 
                    }
                    } else {
                        echo '
                    <div class="navb" >
                        <a class="primarybtn" href="connexion.php"> Connexion </a>
                        <a class="secondbtn" href="inscription.php">Inscription</a>
                    </div>';
                    } ?>

                </li>
            </ul>
        </div>
    </nav>
<?php 
if (!empty($_SESSION['id'] )){ 
        if($_SESSION['type'] == "Candidat" ) {
            echo '
            <script>
                const usermenu = document.querySelector(".fa-solid.fa-user");
                const usersubmenu = document.querySelector(".user-submenu");
                const searchmenu = document.querySelector(".search");
                const searchsubmenu = document.querySelector(".search-submenu");
                function cacherMenus() {
                    usersubmenu.classList.remove("active");
                    searchsubmenu.classList.remove("active");
                }
                document.addEventListener("click", function(event) {
                    if (event.target !== usermenu && event.target !== usersubmenu && !searchmenu.contains(event.target) && !searchsubmenu.contains(event.target)) {
                        cacherMenus();
                    }
                });
                usermenu.addEventListener("click", function() {
                    usersubmenu.classList.toggle("active");
                    searchsubmenu.classList.remove("active"); 
                });
                searchmenu.addEventListener("click", function() {
                    searchsubmenu.classList.toggle("active");
                    usersubmenu.classList.remove("active"); 
                });

            </script>';
        } else { 
            echo '
            <script>
                const usermenu2 = document.querySelector(".fa-solid.fa-users");
                const usersubmenu2 = document.querySelector(".user-submenu");
                const searchmenu2 = document.querySelector(".search");
                const searchsubmenu2 = document.querySelector(".search-submenu");
                function cacherMenus() {
                    usersubmenu2.classList.remove("active");
                    searchsubmenu2.classList.remove("active");
                }
                document.addEventListener("click", function(event) {
                    if (event.target !== usermenu2 && event.target !== usersubmenu2 && !searchmenu2.contains(event.target) && !searchsubmenu2.contains(event.target)) {
                        cacherMenus();
                    }
                });
                usermenu2.addEventListener("click", function() {
                    usersubmenu2.classList.toggle("active");
                    searchsubmenu2.classList.remove("active"); 
                });
                searchmenu2.addEventListener("click", function() {
                    searchsubmenu2.classList.toggle("active");
                    usersubmenu2.classList.remove("active"); 
                });

            </script>';
        } 
}  
else {
    echo '
    <script>
        const searchmenu1 = document.querySelector(".search");
        const searchsubmenu1 = document.querySelector(".search-submenu");
        function cacherMenus() {
            searchsubmenu1.classList.remove("active");
        }
        document.addEventListener("click", function(event) {
            if (!searchmenu1.contains(event.target) && !searchsubmenu1.contains(event.target)) {
                cacherMenus();
            }
        });
        searchmenu1.addEventListener("click", function() {
            searchsubmenu1.classList.toggle("active"); 
        });

    </script>'; 
};