<?php
  session_start();
  if ( isset($_POST['trouver'])) {
    if ( empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['emploi']) && empty($_POST['tag']) ) {
      $mssg = "Veuillez remplir on moins un champ";
    }
      else {
        include("back/database.php");
        $res = $datebase -> prepare("SELECT idCandidat,nomCandidat,prenomCandidat,proffession FROM employeur WHERE nomCandidat LIKE :nom OR prenomCandidat LIKE :prenom OR prenomCandidat LIKE :emploi");
        $res -> bindParam(":nom",$_POST['nom']);
        $res -> bindParam(":prenom",$_POST['prenom']);
        $res -> bindParam(":emploi",$_POST['emploi']);
        $res -> execute();
        $mytags = $datebase -> prepare("SELECT e.idCandidat, e.nomCandidat, e.prenomCandidat, e.proffession FROM employeur e INNER JOIN tags t ON e.idCandidat = t.idEmployeur WHERE t.nameTag LIKE :tag");
        $mytags ->bindParam("tag",$_POST['tag']);
        $mytags -> execute();
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trouveprofil.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>
    
</head>
<body>
<?php 
      include('navbar.php')
    ?>
<section class="infos" id="infos">
  <form method="post" class="info">  
        <div  class="input">
          <h1>Nom:</h1>
          <input type="text" name="nom" placeholder="Nom">
        </div>
        <div class="input">
          <h1>Prénom:</h1>
          <input type="text" name="prenom" placeholder="Prénom."> 
        </div>
        <div class="infoo"> 
            <h1>Emploi:</h1>
            <select name="emploi">
              <option disabled selected>Emploi</option>
              <option value="developpeur">Développeur web</option>
              <option value="designer">Designer</option>
              <option value="programmeur">Programmeur</option>
            </select>  
        </div>
        <div class="input">
          <h1>Tags:</h1>
          <input type="text" name="tag" placeholder="Tags.">
        </div>
        <?php
          if (! empty($mssg) ) {
            echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssg.'</p>';
          }
        ?>
        <button type="submit" name="trouver">Trouver</button></a>
  </form> 
</section>

<section class="profils" id="profils" >
    <div class="titre">
      <h1 class="section_title">Tout,<span> <?php if ( isset($_POST['trouver']))  echo $res->rowCount() + $mytags->rowCount(); else echo 0; ?> </span> employés trouvés. </h1>
    </div>
    <div class="meilleur">
    <?php
      if ( isset($_POST['trouver'])) {
      foreach(@$res AS $info) {
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
    <?php
      foreach($mytags AS $info) {
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
                    } } 
      ?>  
    </div>
</section>


    

</body>
</html>