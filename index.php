<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/Profile.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <section class="glo">
        <div class="banniere" id="banniere"> 
            <div class = "row"> 
                <div class="contenu">
                    <h1>Trouvez <span> l'Emploi </span>que vous méritez et engagez<span> les meilleures compétances.</span></h1>
                    <p>79 jobs et 410 candidats inscrits.</p>
                </div>
                <form method="get">
                    <ul class="gauche" id="gauche"> 
                        <li>
                            <a href="#" class="input-icon">
                                <input type="text" name="Post" placeholder="Post, compétence.">
                                <i class="fa-sharp fa-solid fa-magnifying-glass Post"></i>
                            </a>
                        </li>
                        <li> 
                            <a href="#" class="input-icon">
                                <i class="fa-solid fa-location-dot Region"></i>
                                <input type="text" name="Region" placeholder="Region.">
                                <i class="fa-solid fa-angle-down  down" ></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <button id="myButton" type="submit" name="Trouver">Trouver</button>
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="lll">
                <img src="images/JOBS.avif" alt="image">
            </div>
        </div>
        <div class="profils" id="profils" >
            <div class="titre">
                <h1 class="section_title"> Meilleurs profils de la semaine. </h1>
            </div>
            <div class="meilleur">
                <?php
                    foreach($myinfo AS $info) {
                ?>
                <div class="box ">
                    <div class="inbox">
                        <?php
                            $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEmployeur = :id AND estProfil = 1 ");
                            $mypic ->bindParam("id",$info['idCandidat']);
                            $mypic ->execute();
                            foreach ( $mypic AS $pic ) {
                        ?>
                        <img src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" alt="">
                        <?php } ?>
                    </div>  
                    <div class="text">  
                        <h1><?php echo $info['prenomCandidat'] ?></h1>
                        <p><?php echo $info['proffession']; ?></p> 
                    </div>
                    <div  class="reaction">
                        <?php 
                            $mytags = $datebase -> prepare("SELECT * FROM tags WHERE idEmployeur = :id ");
                            $mytags ->bindParam("id",$info['idCandidat']);
                            $mytags ->execute();
                            $i = 0;
                            foreach ( $mytags AS $tag ) {
                                echo '<button>'.$tag['nameTag'].'</button>';
                                $i= $i +1 ;
                                if ( $i > 2 ) {
                                    break;
                                }
                            }
                        ?>
                        <button>..</button>
                    </div>
                    <div class="Contact">
                        <button>Contacter</button>
                        <img src="./images/Sauvegarder.png" alt="">
                    </div>
                    <div  class="etoiles">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-sharp fa-regular fa-star"></i>
                    </div>
                    <div class="bouton">
                        <a href="profile.php?id=<?php echo $info['idCandidat'];?>">Voir plus</a>
                    </div>
                </div>  
                <?php
                    } 
                ?>
        </div>
        <div class="offres" id="offres" >
            <div class="offre">
                <h1 class="section_title2"> Dernières offres </h1>
            </div>
            <div class="derniere">
                <div class="boxes ">
                    <div class="boxe">
                        <img src="./images/google.png" alt="">
                    </div>  
                    <div class="contenuGoogle">  
                        <h1>Google Inc</h1>
                        <i class="fa-solid fa-share-from-square"></i>
                        <div class="boutton">
                        <button style="background-color: #C3FFCD; border-color:#C3FFCD; color: #30B77F;">plein temps</button>
                        </div>
                    </div>
                    <div  class="metier">
                        <h1>Développeur Front-end expert </h1>
                        <p>$300-$400<span>/semaine</span></p>
                    </div>
                    <div class="tiret">
                        <p> _________________________</p>
                    </div>
                
                    <div  class="lieu">
                        <h1>Alger, El-Harrache</h1>
                        <button>Postuler</button>
                        <img src="./images/Sauvegarder2.png" alt="">
                        <i class="fa-solid fa-share"></i>
                    </div>
                </div>
                <div class="boxes ">
                    <div class="boxe">
                        <img src="./images/google.png" alt="">
                    </div>  
                    <div class="contenuGoogle">  
                        <h1>Google Inc</h1>
                        <i class="fa-solid fa-share-from-square"></i>
                        <div class="boutton">
                        <button style="background-color: #C3FFCD; border-color:#C3FFCD; color: #30B77F;">plein temps</button>
                        </div>
                    </div>
                    <div  class="metier">
                        <h1>Développeur Front-end expert </h1>
                        <p>$300-$400<span>/semaine</span></p>
                    </div>
                    <div class="tiret">
                        <p> _________________________</p>
                    </div>
                
                    <div  class="lieu">
                        <h1>Alger, El-Harrache</h1>
                        <button>Postuler</button>
                        <img src="./images/Sauvegarder2.png" alt="">
                        <i class="fa-solid fa-share"></i>
                    </div>
                </div>
                <div class="boxes ">
                    <div class="boxe">
                        <img src="./images/google.png" alt="">
                    </div>  
                    <div class="contenuGoogle">  
                        <h1>Google Inc</h1>
                        <i class="fa-solid fa-share-from-square"></i>
                        <div class="boutton">
                        <button style="background-color: #C3FFCD; border-color:#C3FFCD; color: #30B77F;">plein temps</button>
                        </div>
                    </div>
                    <div  class="metier">
                        <h1>Développeur Front-end expert </h1>
                        <p>$300-$400<span>/semaine</span></p>
                    </div>
                    <div class="tiret">
                        <p> _________________________</p>
                    </div>
                
                    <div  class="lieu">
                        <h1>Alger, El-Harrache</h1>
                        <button>Postuler</button>
                        <img src="./images/Sauvegarder2.png" alt="">
                        <i class="fa-solid fa-share"></i>
                    </div>
                </div>
                <div class="boxes ">
                    <div class="boxe">
                        <img src="./images/google.png" alt="">
                    </div>  
                    <div class="contenuGoogle">  
                        <h1>Google Inc</h1>
                        <i class="fa-solid fa-share-from-square"></i>
                        <div class="boutton">
                        <button style="background-color: #C3FFCD; border-color:#C3FFCD; color: #30B77F;">plein temps</button>
                        </div>
                    </div>
                    <div  class="metier">
                        <h1>Développeur Front-end expert </h1>
                        <p>$300-$400<span>/semaine</span></p>
                    </div>
                    <div class="tiret">
                        <p> _________________________</p>
                    </div>
                
                    <div  class="lieu">
                        <h1>Alger, El-Harrache</h1>
                        <button>Postuler</button>
                        <img src="./images/Sauvegarder2.png" alt="">
                        <i class="fa-solid fa-share"></i>
                    </div>
                </div> 
            </div>
        </div> 
        <div class="questions" id="questions">
            <div class="faq">
                <h2 class="section_title3">FOIRE AUX QUESTIONS (FAQ)</h2>
                <div class="image_div">
                    <img src="./images/commentaire.png" alt="">
                </div>
            </div>
            <div class="jobs">
                <div class="job">  
                    <h2>Comment je peux avoir un job</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, set do <br> eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim<br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
                    <h1> Voir plus de détails --&gt;</h1>
                </div>    
                <div class="job">  
                    <h2>Comment je peux avoir un job</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, set do <br> eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim<br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
                    <h1> Voir plus de détails --&gt; </h1>
                </div>
            </div>

            <div class="jobs2">
                <div class="job2">  
                    <h2>Comment je peux avoir un job</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, set do <br> eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim<br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
                    <h1> Voir plus de détails --&gt; </h1>
                </div>
                <div class="job3">  
                    <h2>Comment je peux avoir un job</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, set do <br> eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim<br> ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <br> aliquip ex ea commodo consequat. Duis aute irure dolor in</p>
                    <h1> Voir plus de détails --&gt; </h1>
                </div>
            </div>
            <div class="fin">
            <h1>Poser votre questions --&gt;</h1>
            </div>
        </div>
        <div class="plans" id="plans">
            <div class="plan">
                <h2 class="section_title4">Choisissez un plan<br>qui vous convient</h2>
                <h1>Par mois <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label> Par ans</h1>
                
            </div>
            <div class="choixs">
                <div class="choix">
                    <div class="intro">  
                        <h2>$20<span> <p>/mois </p></span></h2>
                        <h1>Intro</h1>
                        <p>Lorem ipsum dolor sit amt, conectur<br> adipiscing</p>
                    </div>
                    <div class="Lorem"> 
                        <p>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor. sit amt, <br>
                            <i class="fa-regular fa-circle-check"></i>consectetur adipiscing<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt.
                        </p>
                    </div>
                    <div class="choix_buton">
                        <button> Choisir ce plan.</button>
                    </div>
                </div>
                <div class="choix">
                    <div class="intro">  
                        <h2>$50<span><p>/mois</p></span></h2>
                        <h1>base</h1>
                        <p>Lorem ipsum dolor sit amt, conectur <br>adipiscing</p>
                    </div>
                    <div class="Lorem"> 
                        <p>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor. sit amt, <br>
                            <i class="fa-regular fa-circle-check"></i>consectetur adipiscing<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt.
                        </p>
                    </div>
                    <div class="choix_buton">
                        <button> Choisir ce plan.</button>
                    </div>
                </div>
                <div class="choix">
                    <div class="intro">  
                        <h2>$100<span><p>/mois</p></span></h2>
                        <h1>pro</h1>
                        <p>Lorem ipsum dolor sit amt, conectur<br> adipiscing</p>
                    </div>
                    <div class="Lorem"> 
                        <p>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor. sit amt, <br>
                            <i class="fa-regular fa-circle-check"></i>consectetur adipiscing<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt.
                        </p>
                    </div>
                    <div class="choix_buton">
                        <button> Choisir ce plan.</button>
                    </div>
                </div>
                <div class="choix">
                    <div class="intro">  
                        <h2>$200<span><p>/mois</p></span></h2>
                        <h1>entreprise</h1>
                        <p>Lorem ipsum dolor sit amt, conectur <br> adipiscing</p>
                    </div>
                    <div class="Lorem"> 
                        <p>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor. sit amt, <br>
                            <i class="fa-regular fa-circle-check"></i>consectetur adipiscing<br>
                            <i class="fa-regular fa-circle-check"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt,<br>
                            <i class="fa-regular fa-circle-xmark"></i>Lorem ipsum dolor sit amt.
                        </p>
                    </div>
                    <div class="choix_buton">
                        <button> Choisir ce plan.</button>
                    </div>  
                </div>
            </div>
        </div>
    </section> 
</body>
</html>
