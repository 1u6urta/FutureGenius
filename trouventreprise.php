<?php
  session_start();
  if ( isset($_POST['Trouver'])) {
    if ( empty($_POST['nom']) && empty($_POST['Pays']) && empty($_POST['ville']) && empty($_POST['code']) && empty($_POST['etat']) ) {
      $mssg = "Veuillez remplir on moins un champ";
    }
    else {
        include("back/database.php");
        $res = $datebase -> prepare("SELECT idEntreprise,nomEntreprise,siteEntreprise,addressEntreprise,bioEntreprise FROM entreprise WHERE nomEntreprise LIKE :nom OR paysEntreprise LIKE :pays OR villeEntreprise LIKE :ville OR  codeZipEntreprise LIKE :code OR etatEntreprise LIKE :etat  ");
        $res -> bindParam(":nom",$_POST['nom']);
        $res -> bindParam(":pays",$_POST['Pays']);
        $res -> bindParam(":ville",$_POST['ville']);
        $res -> bindParam(":code",$_POST['code']);
        $res -> bindParam(":etat",$_POST['etat']);
        $res -> execute();
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trouventreprise.css">
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
        <div href="#" class="input">
          <h1>Nom entreprise:</h1>
          <input type="text" name="nom" placeholder="Nom">
        </div>
        <div class="input">
          <h1>Pays:</h1>
          <input type="text" name="Pays" placeholder="Pays.">
        </div>
        <div class="infoo"> 
            <h1>Ville:</h1>
            <select name="ville">
              <option disabled selected>Ville.</option>
              <option value="marseille">Marseille</option>
              <option value="lyon">Lyon</option>
              <option value="lille">Lille</option>
            </select>

        </div>
      <div  class="input">
        <label for="code-zip">Code zip:</label>
        <input type="text" name="code" id="code-zip" placeholder="Code zip.">
      </div>
      <div  class="input">
        <label for="etat">Etat:</label>
        <input type="text" name="etat" id="etat" placeholder="Etat.">
      </div>
      <div>
      <?php
          if (! empty($mssg) ) {
            echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssg.'</p>';
          }
        ?>
          <button type="submit " name="Trouver">Trouver</button>
      </div>
    </form>
</section>
<section class="offres" id="offres" >
    <div class="offre">
      <h1 class="section_title2"> Tout,<span><?php if ( isset($_POST['Trouver']))  echo $res->rowCount(); else echo 0; ?></span> entreprises trouvés.</h1>
    </div>

    <div class="derniere">
    <?php
      if ( isset($_POST['Trouver'])) {
      foreach(@$res AS $info) {
      ?>
      <div class="boxes ">
        <div class="boxe">
        <?php
            $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEntreprise = :id AND estProfil = 0 AND estActive = 1 ");
            $mypic ->bindParam("id",$info['idEntreprise']);
            $mypic ->execute();
            foreach ( $mypic AS $pic ) {
          ?>
          <img src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" alt="">
          <?php } ?>
        </div>  
        <div class="contenuGoogle">  
          <h1><?php echo $info['nomEntreprise'] ?></h1>
          <i class="fa-solid fa-share-from-square"></i>
          
        </div>
        <div  class="metier">
          <p><?php echo $info['bioEntreprise'] ?></p>
        </div>
        <div class="tiret">
            <i class="fa-solid fa-earth-americas"></i>
            <p><?php echo $info['siteEntreprise'] ?></p>
            <i class="fa-sharp fa-solid fa-share-from-square"></i>
        </div>
       
        <div  class="lieu">
            <i class="fa-solid fa-location-dot"></i>
            <p><?php echo $info['addressEntreprise'] ?></p>
        </div>
        <div class="consulter">
            <a href="Entreprise.php?id=<?php echo $info['idEntreprise'] ?>"> Consulter</a>
        </div>
      </div>
      <?php }} 
    ?>

  </section> 
</body>
</html>