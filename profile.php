<?php
    session_start();
    include('back/database.php');
    //////////////////////////////
    $myinfo = $datebase -> prepare("SELECT * FROM employeur WHERE idCandidat = :id ");
    $myinfo ->bindParam("id",$_GET['id']);
    $myinfo ->execute();
    
    foreach($myinfo AS $info) {}
    /////////////////////
    $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEmployeur = :id AND estProfil = 1 ");
    $mypic ->bindParam("id",$_GET['id']);
    $mypic ->execute();
    foreach ( $mypic AS $pic ) {}
    ////////////////////////////////////
    $mytags = $datebase -> prepare("SELECT * FROM tags WHERE idEmployeur = :id ");
    $mytags ->bindParam("id",$_GET['id']);
    $mytags ->execute();
    /////////////////////////////////
    $myreseaux = $datebase->prepare("SELECT urlReseauxsociaux FROM employeur e , reseauxsociaux r WHERE e.idCandidat = r.idEmployeur AND e.idCandidat = :id AND estProfil	= 1 ");
    $myreseaux-> setFetchMode(PDO::FETCH_ASSOC);
    $myreseaux->bindParam("id",$_GET['id']);
    $myreseaux->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Profile.css"/>
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>
</head>
<style>
    .pdfContainer {
    width: 150px;
    margin: 40px;
    }
    canvas {
        width: 150px;
    }
</style>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="hors">
        <div class="profile">
            <div class="profile-info">

                <div class="profile-picture">
                    <img src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" alt="profile-picture" class="pdp">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="name">
                        <p class="profile-name"><?php echo $info['nomCandidat']."  ".$info['prenomCandidat'] ?></p>
                        <div class="<?php if ($_GET['id'] != $_SESSION['id'] || $_SESSION['type'] == "Entreprise" ) { echo "hidden" ;}?>">
                            <a href="SettingProfile.php">
                                <i class="fa-regular fa-pen-to-square"></i>
                                <p class="edit">Modifier</p>
                            </a>
                        </div>

                    </div>

                    <div class="info">
                        <i class="fa-solid fa-briefcase"></i>
                        <p class="infos">Type de Job:&nbsp;</p>
                        <p class="details"><?php echo $info['proffession']; ?></p>
                        <i class="fa-solid fa-cake-candles"></i>
                        <p class="infos">Age:&nbsp;</p>
                        <p class="details">
                            <?php 
                                $dateNaissance = new DateTime($info['dateNaissanceCandidat']);
                                $dateActuelle = new DateTime();
                                $diff = $dateActuelle->diff($dateNaissance);
                                $age = $diff->y;
                                echo $age." ans";
                            ?>
                        </p>
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="infos">Adresse:&nbsp;</p>
                        <p class="details"><?php echo $info['addressCandidat'] ?></p>
                    </div>


                    <div class="tags">
                        <p class="tags-details">Tags:</p>
                        <div class="tag">
                            <?php
                                foreach ( $mytags AS $tag ) {
                                    echo '<p>'.$tag['nameTag'].'</p>';
                                }
                            ?>
                        </div>
                    </div>


                    <label for="cvDownload" class="cv-download hidden">
                        <i class="fa-solid fa-download"></i>
                        <p class="download">Télécharger votre CV</p>
                        <input type="file" id="cvDownload" accept=".pdf" class="cv-download"></input>
                    </label>

                </div>
            </div>

            <div class="contact-biographie">


                <div class="contact">
                    <p class="contact-details">Contact : </p>
                    <?php 
                        if ( $myreseaux->rowCount() == 0 ) {
                            echo '<p  style="margin: 50px; color :#DDDDDD">Il n\'y aucun de site de reseau social </p>';
                        } else  {
                            foreach($myreseaux AS $reseaux) {
                    ?>
                    <div class="contact-info">
                        <i class="fa-solid fa-globe"></i>
                        <a href="#"><?php  echo $reseaux['urlReseauxsociaux'] ?></a>
                    </div>
                    <?php }}?>
                    <div class="mail">Envoyer un e-mail</div>
                </div>


                <div class="biographie">
                    <h1 class="biographie-details">Biographie : </h1>
                    <p class="biography">
                        <?php
                            echo $info['biographie']
                        ?>
                    </p>
                    <div class="par">
                        <ul>
                            <li class="items"><button class="btn active" id="dp">
                                    <p>Diplomes</p>
                                </button></li>
                            <li class="items"><button class="btn" id="CV">
                                    <p>CV</p>
                                </button></li>
                            <li class="items"><button class="btn" id="CE">
                                    <p>Certificats en ligne</p>
                                </button></li>
                        </ul>
                    </div>
                    <!--style="display: inline-flex; flex-wrap: wrap; justify-content: space-around;"-->
                    <!--style="margin: 40px;"-->
                    <div class="pdfs" id="Diplomes" >
                        <div class="pdfContainer" id="pdfContainer1"></div>
                        <div class="pdfContainer" id="pdfContainer2"></div>
                        <div class="pdfContainer" id="pdfContainer3"></div>
                    </div>
                    <div class="pdfs hidden" id="CvS">
                        <div class="pdfContainer" id="pdfContainer4"></div>
                    </div>
                    <div class="pdfs hidden" id="CES">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="script/Profil.js"></script>
<script>
    // Tableau des chemins vers les fichiers PDF sur le serveur
    var pdfUrls = [
      "pdf/cv.pdf",
      "pdf/cv.pdf",
      "pdf/cv.pdf"
    ];

    // Fonction pour afficher un fichier PDF dans un conteneur donné
    function afficherPDF(pdfUrl, containerId) {
      var container = document.getElementById(containerId);

      // Chargement du PDF
      pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        // Chargement de la première page
        pdf.getPage(1).then(function(page) {
          var scale = 1.5;
          var viewport = page.getViewport({ scale: scale });

          // Création d'un élément canvas pour afficher la page
          var canvas = document.createElement("canvas");
          var context = canvas.getContext("2d");
          canvas.width = viewport.width;
          canvas.height = viewport.height;
          container.appendChild(canvas);

          // Affichage de la première page
          page.render({
            canvasContext: context,
            viewport: viewport
          });

          // Gestion de l'événement clic pour afficher le PDF en plein écran
          canvas.addEventListener("click", function() {
            var fullScreenUrl = pdfUrl + "#page=1&view=Fit";
            window.open(fullScreenUrl, "_blank");
          });
        });
      });
    }

    // Appel de la fonction pour chaque fichier PDF
    afficherPDF(pdfUrls[0], "pdfContainer1");
    afficherPDF(pdfUrls[1], "pdfContainer2");
    afficherPDF(pdfUrls[2], "pdfContainer3");
    afficherPDF(pdfUrls[2], "pdfContainer4");

</script>
</html>