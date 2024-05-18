<?php
    /*
        <?php if ( $_SESSION['id'] == $_GET['id']) {
        echo '<a href="SettingEntreprise.php?id='.$_GET['id'].'&key=Profil">SettingEntreprise</a>';
        }
        ?>
    */
    session_start();
    include('back/database.php');
    if (empty($_GET['id'])) {
        header("Location: index.php");
    }

    $mydate = $datebase->prepare("SELECT * FROM entreprise WHERE idEntreprise = :id ");
    $mydate->bindParam("id",$_GET['id']);
    $mydate->execute();
    foreach ($mydate AS $info ) {}
    $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEntreprise = :id AND estProfil = 0 AND estActive = 1");
    $mypic ->bindParam("id",$_GET['id']);
    $mypic ->execute();
    foreach ( $mypic AS $pic) {}
    $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEntreprise = :id AND estProfil = 0 AND estActive = 0");
    $mypic ->bindParam("id",$_GET['id']);
    $mypic ->execute();
    foreach ( $mypic AS $pic1) {}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>

    <link rel="stylesheet" href="css/Entreprise.css">
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div class="countair mt ">
        <?php //foreach ( $mypic AS $pic ) { if ( $pic['estActive'] == 0 ) { ?>
            <img class="couv" src="<?php echo $pic1['cheminImage'].$pic1['nomImage'] ;?>">
                <label for="ImagePro" class="primarybtn <?php if ($_GET['id'] != $_SESSION['id'] || $_SESSION['type'] != "Entreprise" ) { echo "hidden"; } ?>">
                    <p>Nouvelle Image</p>
                    <input type="file" id="ImagePro" accept=".png,.jpg,.jpeg"/>
                </label>
            </img>
        <?php //}} ?>
        <div class="imgprofil">
                <img  src="<?php echo $pic['cheminImage'].$pic['nomImage'] ;?>"/>
            <p class="nom "><?php echo $info['nomEntreprise'] ?></p>
        </div>
        <div class="info ">
            <div class="infos">
                <p class="nom"><?php echo $info['nomEntreprise'] ?></p>
                <div class="div">
                    <i class="fa-solid fa-clock"></i>
                    <p>Depuis le <?php echo $info['dateCEntreprise'] ?></p>
                </div>
                <div class="div">
                    <i class="fa-solid fa-globe"></i>
                    <a href="<?php echo $info['siteEntreprise'] ?>"><?php echo $info['siteEntreprise'] ?></a>
                </div>
                <div class="div">
                    <i class="fa-solid fa-envelope"></i>
                    <p> <?php echo $info['emailEntreprise'] ?></p>
                </div>
                <div class="div">
                    <i class="fa-solid fa-phone"></i>
                    <p> <?php echo $info['paysNumEntreprise']."  ".$info['numEntreprise'] ?></p>
                </div>
                <div class="div">
                    <i class="fa-solid fa-location-dot"></i>
                    <p> <?php echo $info['addressEntreprise']?></p>
                </div>
            </div>
            <div class="bio">
                <div class="header">
                    <p class="titlebio">Qui Sommes-Nous </p>
                    <div class="<?php if ($_GET['id'] != $_SESSION['id'] || $_SESSION['type'] != "Entreprise" ) { echo "hidden"; } ?>">
                        <a href="<?php  echo 'SettingEntreprise.php?id='.$_SESSION['id'].'&key='?>">
                            <i class="fa-regular fa-pen-to-square"></i>
                            <p class="edit">Modifier</p>
                        </a>
                    </div>
                </div>
                <p class="bioEntreprise"><?php echo $info['bioEntreprise'] ?></p>
            </div>
        </div>
    </div>
</body>
</html>