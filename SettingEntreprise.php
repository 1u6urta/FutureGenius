<?php
    session_start();
    include('back/database.php');
    if (empty($_GET['id'])) {
        header("Location: SettingEntreprise.php?id=".$_SESSION['id']."&key=".$_GET['key']);
    }
        elseif ( $_SESSION['id'] != $_GET['id']) {
            header("Location: index.php");
        }
        elseif (empty($_GET['key']) )  {
            header("Location: SettingEntreprise.php?id=".$_SESSION['id']."&key=Profil");
        } else {
            $border = 'style="border: #FF0000 2px solid ;"';
                $mydate = $datebase->prepare("SELECT * FROM entreprise WHERE idEntreprise = :id ");
                $mydate->bindParam("id",$_GET['id']);
                $mydate->execute();
                ///////////////////////////////////////
                $myreseaux = $datebase->prepare("SELECT idReseauxsociaux,urlReseauxsociaux,typeReseauxsociaux FROM entreprise e , reseauxsociaux r WHERE e.idEntreprise = r.idEntreprise AND e.idEntreprise = :id AND estProfil	= 0 ");
                $myreseaux-> setFetchMode(PDO::FETCH_ASSOC);
                $myreseaux->bindParam("id",$_GET['id']);
                $myreseaux->execute();
                //////////////////////////////////
                $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEntreprise = :id AND estProfil = 0 AND estActive = 1 ");
                $mypic ->bindParam("id",$_GET['id']);
                $mypic ->execute();
                foreach ( $mypic AS $pic ) {}
                /////////////////////////////////
                foreach($mydate AS $info) {
                    if ($info['verifieNum'] == 0 ) {
                        $mssgNum  = "Vérifiez Votre Numero";
                    }
                    if ($info['verifieEmail'] == 0 ) {
                        $mssgEmail  = "Vérifiez Votre Email";
                    }
                } 
        }

    
    
    if (isset($_POST['updatemotdepasse'])) {
        @$mdp = $_POST['mdp'];
        @$nvmdp = $_POST['nvmdp'];
        @$cmdp = $_POST['cmdp'];
        $border = 'style="border: #FF0000 2px solid ;"';
        if ( empty($mdp) ) {
            $mssgmdp = "Veuillez remplir ce champ ";

        }
        elseif ( empty($nvmdp) ) {
                $mssgnvmdp = "Veuillez remplir ce champ";
            } 
        elseif ( empty($cmdp)) {
                    $mssgcmdp = "Veuillez remplir ce champ";
                } 
                    elseif ($cmdp != $nvmdp) {
                        $mssgcmdp = "Verifier votre nouveau mot de passe ";
                    }
                        elseif (md5($mdp) != $info['mdpEntreprise']) {
                            $mssgmdp = "Mot de passe incorrect ";
                        } 
                            else {
                                $update = $datebase->prepare("UPDATE entreprise SET mdpEntreprise = :mdp WHERE idEntreprise = :id ");
                                $update->bindParam("id",$_GET['id']);
                                $update->bindParam("mdp",md5($nvmdp));
                                $update->execute();
                                header("Location: SettingEntreprise.php?id=".$_SESSION['id']."&key=".$_GET['key']);
                            }
    }
    if (isset($_POST['updateprofil'])) {
        $border = 'style="border: #FF0000 2px solid ;"';
        $rech = $datebase->prepare("SELECT * FROM entreprise en,employeur em WHERE en.emailEntreprise = :email OR em.emailCandidat = :email ");
        $rech ->bindParam("email",$_POST['EmailEntrepris']);
        $rech ->execute();
        if ( empty($_POST['NomEntrepris']) ) {
            $mssgNom = "Veuillez remplir ce champ";
        } 
            elseif ( empty($_POST['EmailEntrepris']) ) {
                $mssgEmail = "Veuillez remplir ce champ";
            }
                elseif ( empty($_POST['TeleEntrepris'])  ) {
                    $mssgNum = "Veuillez remplir ce champ";
                } elseif ( $info['emailEntreprise'] != $_POST['EmailEntrepris'] & $rech->rowCount() > 0) {
                    $mssgEmail = "Email deja exsite";
                }else {
                    if ($info['verifieEmail'] == 1 ) {
                        if ($info['emailEntreprise'] == $_POST['EmailEntrepris']) $verEamil = 1; else $verEamil = 0;
                    } else {
                        $verEamil = 0;
                    }
                    if ($info['verifieNum'] == 1 ) {
                        if ($info['numEntreprise'] == $_POST['TeleEntrepris']) $verNum = 1; else $verNum = 0;         
                    } else {
                        $verNum = 0;
                    }
                    if (! isset($_FILES['img'])) {
                        $file_name = $_GET['id'].$_FILES['img']['name'];
                        @$file_size = $_FILES['img']['size'];
                        @$file_tmp = $_FILES['img']['tmp_name'];
                        @$file_type = $_FILES['img']['type'];
                        $path = "imgs/Entreprise/";
                        $file_path = "imgs/Entreprise/".$file_name ;
                        echo "le type est " .$file_type;
                        if($file_type != "image/png" && $file_type != "image/jpg" && $file_type != "image/jpeg") {
                            echo "Le fichier doit être de type image";
                            exit();
                        }

                        if($file_size > 5242880) {
                            echo "Le fichier ne doit pas dépasser 5 Mo";
                            exit();
                        } 
                        if ( ! move_uploaded_file($file_tmp, $file_path)) {
                            echo "Le fichier";
                        }
                        $updateimg = $datebase-> prepare("INSERT INTO images (nomImage, cheminImage, typeImage, estProfil, estActive, idEmployeur, idEntreprise) VALUES (:nom,:path, :type,0,1,0,:idEmp)");

                        $updateimg -> bindParam(":nom",$file_name);
                        $updateimg -> bindParam(":path",$path);
                        $updateimg -> bindParam(":type",$file_type);
                        $updateimg -> bindParam(":idEmp",$_GET['id']);
                        $updateimg -> execute();
                    }
                    $update = $datebase->prepare("UPDATE entreprise SET 
                    nomEntreprise = :Nom,
                    siteEntreprise = :Site,
                    emailEntreprise = :Email,
                    verifieEmail = :VEmail,
                    dateCEntreprise = :Date,
                    paysNumEntreprise = :Paysnum,
                    numEntreprise = :Num,
                    verifieNum = :VNum,
                    addressEntreprise = :Address,
                    paysEntreprise = :Pays,
                    villeEntreprise = :Ville,
                    codeZipEntreprise = :Code,
                    etatEntreprise = :Etat,
                    coordonneLocEntreprise = :C,
                    bioEntreprise = :Bio
                    WHERE idEntreprise = :id ");


                    $update->bindParam("id",$_GET['id']);
                    $update->bindParam("Nom",$_POST['NomEntrepris']);
                    $update->bindParam("Site",$_POST['SiteEntrepris']);
                    $update->bindParam("Email",$_POST['EmailEntrepris']);
                    $update->bindParam("Date",$_POST['DateEntrepris']);
                    $update->bindParam("Paysnum",$_POST['PaysteleEntrepris']);
                    $update->bindParam("Num",$_POST['TeleEntrepris']);
                    $update->bindParam("Address",$_POST['AddressEntrepris']);
                    $update->bindParam("Pays",$_POST['PaysEntrepris']);
                    $update->bindParam("Ville",$_POST['VilleEntrepris']);
                    $update->bindParam("Code",$_POST['CodezipEntrepis']);
                    $update->bindParam("Etat",$_POST['EtatEntrepris']);
                    $update->bindParam("C",$_POST['CLEntrepris']);
                    $update->bindParam("Bio",$_POST['BioEntrepris']);
                    $update->bindParam("VEmail",$verEamil);
                    $update->bindParam("VNum",$verNum);
                    $update->execute();
                    header("Location: SettingEntreprise.php?id=".$_GET["id"]."&key=".$_GET['key']);
                }
    }

    
    if ( isset( $_POST['dele'])) {
        $removeUrl = $datebase->prepare("DELETE FROM reseauxsociaux WHERE idReseauxsociaux = :id  ");
        $removeUrl->bindParam("id",$_POST['dele']);
        $removeUrl -> execute();
        header("Location: SettingEntreprise.php?id=".$_GET['id']."&key=".$_GET['key']);
    }
    if ( isset( $_POST['updateres'])) {   
        $update = $datebase->prepare("UPDATE reseauxsociaux SET urlReseauxsociaux = :urll  WHERE idReseauxsociaux = :id");
        $update->bindParam("id",$_POST['updateres']);
        $update->bindParam("urll",$_POST['url']);
        //$update->bindParam("typeurl",$_POST['typeurl']);
        $update -> execute();
        header("Location: SettingEntreprise.php?id=".$_GET['id']."&key=".$_GET['key']);
    }
    if ( isset($_POST['inserres'])) {
        /*INSERT INTO `reseauxsociaux` (`idReseauxsociaux`,`urlReseauxsociaux`,`typeReseauxsociaux`,`estProfil`,`idEntreprise`,`idEmployeur`) VALUES (NULL,' www.facebook.com','Facebook','0','2','0');*/
        $insert = $datebase -> prepare("INSERT INTO reseauxsociaux (urlReseauxsociaux,typeReseauxsociaux,estProfil,idEntreprise,idEmployeur) VALUES (:url,:typeRes,:ispro,:idEnt,:idEmp)");
        //$_POST['url'] = "facc";
        $insert -> bindParam("url",$_POST['url']);
        //$_POST['typeurl'] = "Facebook";
        $insert -> bindParam("typeRes",$_POST['typeurl']);
        $ispro = 1;
        $ident = 0;
        $insert -> bindParam("ispro",$ispro);
        $insert -> bindParam("idEnt",$_GET['id']);
        $insert -> bindParam("idEmp",$ident);
        $insert -> execute();
        header("Location: SettingEntreprise.php?id=".$_GET['id']."&key=".$_GET['key']);
        
    }
    //echo md5("abc@123");
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/SettingEntreprise.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>>
</header>

<body>
    <?php
        include("navbar.php");
    ?>
    <div class="hors flex">
        <div class="Menu ">
            <div class="img"><img id="imgp" src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" /></div>
            <div class="nom"><?php echo $info['nomEntreprise'] ?></div>
            <div class="Parametres">
                <h2><i class="fa-solid fa-gear"></i> Parametres</h2>
                </h2>
            </div>
            <div class="par">
                <ul>
                    <form method="get" >
                    <li class="items"><button class="btn <?php if($_GET['key'] == "Profil" ) echo "active" ?>" name="key" value="Profil" id="mp"><i class="fa-solid fa-user"></i>
                            <p>Mon Profile</p>
                        </button></li>
                    <li class="items"><button class="btn <?php if($_GET['key'] == "Mot De Passe" ) echo "active"; ?>" name="key" value="Mot De Passe" id="mdp"><i class="fa-solid fa-lock"></i>
                            <p>Mot de Passe</p>
                        </button></li>
                    <li class="items"><button class="btn <?php if($_GET['key'] == "Reseaux Sociaux" ) echo "active" ?>" name="key" value="Reseaux Sociaux" id="rs"><i class="fa-brands fa-facebook"></i>
                            <p>Reseaux sociaux</p>
                        </button></li>
                    <li class="items"><button class="btn <?php if($_GET['key'] == "Votre Abonnment Premuim" ) echo "active" ?>" name="key" value="Votre Abonnment Premuim" id="ap"><i class="fa-solid fa-star"></i>
                            <p>Abonnment premuim</p>
                        </button>
                    </li>
                    </form>
                </ul>
            </div>
        </div>
        <div>

            <h1 class="title" id="title"><?php echo $_GET['key']?></h1>
            <div class="Inputs">
                <div class="<?php if($_GET['key'] != "Profil" ) echo "hidden" ?>" id="MonProfil">
                    <form method="post" enctype="multipart/form-data">
                        <div class="imgsetting flex">
                            <div class="img"><img id="imgp" src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" /></div>
                            <label for="file" class="primarybtn">
                                <p>Nouvelle Image</p>
                                <input type="file" name="img" id="file" accept=".png,.jpg,.jpeg" class="primarybtn " />
                            </label>
                            <button class="secondbtn" value="<?php echo $pic['idImage'] ?>">Supprimer</button>
                        </div>
                        <div class="itmsflex">
                            <div class="form">
                                <p class="label">Nom de l'entrepris :</p>
                                <input class="input" name="NomEntrepris" <?php if ( ! empty($mssgNom )  ) {echo $border; }  ?> value="<?php echo $info['nomEntreprise'] ?>">
                                <?php
                                if (! empty($mssgNom) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgNom.'</p>';
                                }
                            ?>
                            </div>
                            <div class="form">
                                <p class="label">Site Web :</p>
                                <input class="input" name="SiteEntrepris" value="<?php echo $info['siteEntreprise'] ?>">
                            </div>
                        </div>
                        <div class="itmsflex">
                            <div class="form">
                                <p class="label">E-mail :</p>
                                <input class="input" type="email" <?php if ( ! empty($mssgEmail)  ) {echo $border; }  ?> name="EmailEntrepris" value="<?php echo $info['emailEntreprise'] ?>">
                            </div>
                            <div class="form">
                                <p class="label">Date De Creation :</p>
                                <input class="input" type="date" name="DateEntrepris" value="<?php echo $info['dateCEntreprise'] ?>">
                            </div>
                        </div>
                        <?php 
                                    if ( ! empty($mssgEmail )  ) {
                                        echo '<a href="verification.php?email='.$info['emailEntreprise'].'&id='.$_GET['id'].'&verifie=email " style ="color:#FF0000;font-size: 10pt;margin-left :55px;">'.$mssgEmail.'</a><br><br>';
                                    }
                                ?>
                        <div>
                            <div class="itsform ml">
                                <p class="label">Numéro de télèphone :</p>
                                <select class="num" name="PaysteleEntrepris">
                                    <option><?php echo $info['paysNumEntreprise'] ?></option>
                                    <?php
                                        $pays_codes_telephone = array(
                                            "France" => "+33",
                                            "Espagne" => "+34",
                                            "Italie" => "+39",
                                            "Allemagne" => "+49",
                                            "Algérie" => "+213",
                                            "Maroc" => "+212",
                                            "Tunisie" => "+216",
                                            "Égypte" => "+20",
                                            "États-Unis" => "+1",
                                            "Canada" => "+1"
                                        );
                                        foreach ($pays_codes_telephone as $pct) {
                                            echo "<option value='$pct'>$pct</option>";
                                        }                                    
                                    ?>
                                </select>

                                <input class="input" type="number" <?php if ( ! empty($mssgNum)  ) {echo $border; }  ?> name="TeleEntrepris" value="<?php echo $info['numEntreprise'] ?>">
                                
                                <?php 
                                    if ( ! empty($mssgNum )  ) { 
                                        echo '<br><a  href="verification.php" style ="color:#FF0000;font-size: 10pt; margin-left:105px;">'.$mssgNum.'</a><br><br>';
                                    }
                                ?>
                            </div>
                            <div class="itmsflex">
                                <div class="form">
                                    <p class="label">Address :</p>
                                    <input class="input" name="AddressEntrepris" value="<?php echo $info['addressEntreprise'] ?>">
                                </div>
                                <div class="form1 flex">
                                    <div class="itsform">
                                        <p class="label">Pays :</p>
                                        <select id="pays" class="selec" name="PaysEntrepris" onchange="updateVilles();updateEtat()">
                                            <option value=""><?php echo $info['paysEntreprise'] ?></option>
                                            <?php
                                                $pays = array("France", "Espagne", "Italie", "Allemagne", "Algérie", "Maroc", "Tunisie", "Égypte", "États-Unis", "Canada");

                                                $villes = array(
                                                    "France" => array("Paris", "Marseille", "Lyon", "Bordeaux", "Toulouse"),
                                                    "Espagne" => array("Madrid", "Barcelone", "Valence", "Séville", "Malaga"),
                                                    "Italie" => array("Rome", "Milan", "Venise", "Naples", "Florence"),
                                                    "Allemagne" => array("Berlin", "Munich", "Hambourg", "Francfort", "Cologne"),
                                                    "Algérie" => array("Alger", "Oran", "Constantine", "Annaba", "Tlemcen"),
                                                    "Maroc" => array("Casablanca", "Rabat", "Marrakech", "Fès", "Tanger"),
                                                    "Tunisie" => array("Tunis", "Sfax", "Sousse", "Bizerte", "Gabès"),
                                                    "Égypte" => array("Le Caire", "Alexandrie", "Louxor", "Gizeh", "Sharm el-Sheikh"),
                                                    "États-Unis" => array("New York", "Los Angeles", "Chicago", "Miami", "San Francisco"),
                                                    "Canada" => array("Toronto", "Montréal", "Vancouver", "Calgary", "Ottawa")
                                                );  
                                                $pays_etats = array(
                                                    "France" => array(
                                                        "Île-de-France",
                                                        "Provence-Alpes-Côte d'Azur",
                                                        "Auvergne-Rhône-Alpes"
                                                    ),
                                                    "Espagne" => array(
                                                        "Communauté de Madrid",
                                                        "Catalogne",
                                                        "Communauté valencienne"
                                                    ),
                                                    "Italie" => array(
                                                        "Latium",
                                                        "Lombardie",
                                                        "Vénétie"
                                                    ),
                                                    "Allemagne" => array(
                                                        "Berlin",
                                                        "Bavière",
                                                        "Hambourg"
                                                    ),
                                                    "Algérie" => array(
                                                        "Alger",
                                                        "Oran",
                                                        "Constantine"
                                                    ),
                                                    "Maroc" => array(
                                                        "Casablanca-Settat",
                                                        "Rabat-Salé-Kénitra",
                                                        "Marrakech-Safi"
                                                    ),
                                                    "Tunisie" => array(
                                                        "Tunis",
                                                        "Sfax",
                                                        "Sousse"
                                                    ),
                                                    "Égypte" => array(
                                                        "Le Caire",
                                                        "Alexandrie",
                                                        "Louxor"
                                                    ),
                                                    "États-Unis" => array(
                                                        "New York",
                                                        "Californie",
                                                        "Texas"
                                                    ),
                                                    "Canada" => array(
                                                        "Ontario",
                                                        "Québec",
                                                        "Colombie-Britannique"
                                                    )
                                                );                                                                                              
                                                foreach ($pays as $p) {
                                                    echo "<option value='$p'>$p</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="itsform">
                                        <p class="label">Ville :</p>
                                        <select id="ville" class="selec" name="VilleEntrepris">
                                            <option value=""><?php echo $info['villeEntreprise'] ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="itmsflex">
                                <div class="form1 flex">
                                    <div class="itsform">
                                        <p class="label">Code Zip :</p>
                                        <input class="selec" type="number" name="CodezipEntrepis" value="<?php echo $info['codeZipEntreprise'] ?>">
                                    </div>
                                    <div class="itsform">
                                        <p class="label">Etat :</p>
                                        <select class="selec" id="Etat" name="EtatEntrepris" >
                                            <option><?php echo $info['etatEntreprise'] ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form">
                                    <p class="label">Coordonnes de localisation :</p>
                                    <input class="input" name="CLEntrepris" value="<?php echo $info['coordonneLocEntreprise'] ?>">
                                </div>
                            </div>

                        </div>
                        <div class="form ml">
                            <p class="label">Biographie</p>
                            <textarea name="BioEntrepris"><?php echo $info['bioEntreprise'] ?></textarea>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="updateprofil" class="primarybtn ">Confirmer</button>
                            <button type="reset"  name="reset"class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>
                <div class="<?php if($_GET['key'] != "Mot De Passe" ) echo "hidden" ?>" id="MotPasse">
                    <form method="post">
                        <h2 class="tete mt">Renouveler le mot de passe</h2>
                        <div class="form ml mt">
                            <p class="label">Mot De Passe acuel :</p>
                            <input type="password" class="input" name="mdp" <?php  if (! empty($mssgmdp) ) {echo $border;} ?> value="<?php if(!empty($mdp)) { echo $mdp;}?>"  placeholder="Saisissez votre mot de passe" />
                            <?php
                                if (! empty($mssgmdp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgmdp.'</p>';
                                }
                            ?>
                        </div>
                        <div class="form ml mt">
                            <p class="label">Nouveau Mot De Passe :</p>
                            <input type="password" name="nvmdp" <?php  if (! empty($mssgnvmdp) ) {echo $border;} ?> value="<?php if(!empty($nvmdp)) { echo $nvmdp;}?>" placeholder="Saisissez le Nouveau mot de passe" class="input" />
                            <?php
                                if (! empty($mssgnvmdp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgnvmdp.'</p>';
                                }
                            ?>
                        </div>
                        <div class="form ml mt">
                            <p class="label">Confirmer le Mot De Passe :</p>
                            <input type="password" name="cmdp" <?php  if (! empty($mssgcmdp) ) {echo $border;} ?> value="<?php if(!empty($cmdp)) { echo $cmdp;}?>" placeholder="Confirmez le Nouveau mot de passe" class="input" />
                            <?php
                                if (! empty($mssgcmdp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgcmdp.'</p>';
                                }
                            ?>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="updatemotdepasse" id="mdp1" class="primarybtn">Confirmer</button>
                            <button type="reset" name="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>

                <div class="<?php if($_GET['key'] != "Reseaux Sociaux" ) echo "hidden" ?>" id="ReseauxSociaux">
                    <form method="post">
                        <h2 class="tete mt">Reseaux Sociaux</h2>
                        <div id="yourContainer">
                            <?php 
                                if ( $myreseaux->rowCount() == 0 ) {
                                    echo '<p  style="margin: 50px; color :#DDDDDD">Il n\'y aucun de site de reseau social </p>';
                                } else  {
                                    $i = 1;
                                    foreach($myreseaux AS $reseaux) {
                            ?>
                            <div class="form ml mt ">
                                <p class="label">Reseau <?php echo $i;?> </p>
                                <div class="flex Res ">
                                <form method="post">
                                    <input type="text" class="input" name="url" value="<?php echo $reseaux['urlReseauxsociaux'];?>" />
                                    <select class="selec" name="typeurl">
                                        <option><?php echo $reseaux['typeReseauxsociaux'];?></option>
                                        <option>Facebook</option>
                                    </select>
                                        <button class="primarybtn" name="updateres" value="<?php echo $reseaux['idReseauxsociaux'];?>" >Edit</button>
                                        <button class="secondbtn" name="dele" value="<?php echo $reseaux['idReseauxsociaux'];?>" >Supprimer</button>
                                    </form>
                                </div>
                            </div>
                            <?php $i++; } }
                            ?>
                        </div>
                        <div>
                            <button class="btnaj " id="btnLien">+ Ajouter un lien </button>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="inserres" class="primarybtn ">Confirmer</button>
                            <button type="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>                
                <div class="flex mt <?php if($_GET['key'] != "Votre Abonnment Premuim" ) echo "hidden" ?>" id="Abonnement">
                    <form method="post">
                        <div class="flex mt">
                        <div class="Abonn">
                            <div class="prixmois flex">
                                <div class="prix">
                                    <h2>$50</h2>
                                </div>
                                <div class="mois">
                                    <h3>/mois</h3>
                                </div>
                            </div>
                            <div class="cont mt">
                                <div class="tet">
                                    <h2>Base</h2>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                </div>
                                <div class="items mt">
                                    <div class="item flex">
                                        <i class="fa-solid fa-gear"></i>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                    </div>
                                    <div class="item flex">
                                        <i class="fa-solid fa-gear"></i>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                    </div>
                                    <div class="item flex">
                                        <i class="fa-solid fa-gear"></i>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                    </div>
                                    <div class="item flex">
                                        <i class="fa-solid fa-gear"></i>
                                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tmpsres">
                            <h2>Temps restant </h2>
                            <h1>13 jours 11 heurs et 23 minutes </h1>
                            <button>Renouveler ou changer d'offre </button>
                        </div>
                    </div>
                    <div class="Buttons ml flex">
                        <button type="submit" class="primarybtn ">Confirmer</button>
                        <button type="reset" class="secondbtn">Annuler</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function updateVilles() {
            var pays = document.getElementById("pays").value;
            var villes = <?php echo json_encode($villes); ?>;

            var selectVille = document.getElementById("ville");
            selectVille.innerHTML = "";

            if (pays !== "") {
                for (var i = 0; i < villes[pays].length; i++) {
                    var option = document.createElement("option");
                    option.value = villes[pays][i];
                    option.text = villes[pays][i];
                    selectVille.appendChild(option);
                }
            } else {
                var option = document.createElement("option");
                option.value = "";
                option.text = "Sélectionnez d'abord un pays";
                selectVille.appendChild(option);
            }
    }
    function updateEtat() {
            var pays = document.getElementById("pays").value;
            var etats = <?php echo json_encode($pays_etats); ?>;

            var selectEtat = document.getElementById("Etat");
            selectEtat.innerHTML = "";

            if (pays !== "") {
                for (var i = 0; i < etats[pays].length; i++) {
                    var option = document.createElement("option");
                    option.value = etats[pays][i];
                    option.text = etats[pays][i];
                    selectEtat.appendChild(option);
                }
            } else {
                var option = document.createElement("option");
                option.value = "";
                option.text = "Sélectionnez d'abord un pays";
                selectEtat.appendChild(option);
            }
    }
</script>
<script>
    document.getElementById('btnLien').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    var container = document.createElement('div');
    container.className = 'form ml mt';

    var label = document.createElement('p');
    label.className = 'label';
    label.textContent = 'Reseau ';

    var index = <?php echo $myreseaux->rowCount() + 1?>;
    label.textContent += index;

    var flexDiv = document.createElement('div');
    flexDiv.className = 'flex Res';

    var form = document.createElement('form');
    form.method = 'post';

    var inputUrl = document.createElement('input');
    inputUrl.type = 'text';
    inputUrl.className = 'input';
    inputUrl.name = 'url';
    inputUrl.value = '';

    var selectTypeUrl = document.createElement('select');
    selectTypeUrl.className = 'selec';
    selectTypeUrl.name = 'typeurl';

    var optionTypeUrl = document.createElement('option');
    optionTypeUrl.textContent = '';

    var optionFacebook = document.createElement('option');
    optionFacebook.textContent = 'Facebook';

    selectTypeUrl.appendChild(optionTypeUrl);
    selectTypeUrl.appendChild(optionFacebook);

    var buttonEdit = document.createElement('button');
    buttonEdit.className = 'primarybtn';
    buttonEdit.name = 'inserres';
    buttonEdit.value = '';
    buttonEdit.textContent = 'Ajoute';

    var buttonDelete = document.createElement('button');
    buttonDelete.className = 'secondbtn';
    buttonDelete.name = 'dele';
    buttonDelete.value = '';
    buttonDelete.textContent = 'Supprimer';

    form.appendChild(inputUrl);
    form.appendChild(selectTypeUrl);
    form.appendChild(buttonEdit);
    form.appendChild(buttonDelete);

    flexDiv.appendChild(form);

    container.appendChild(label);
    container.appendChild(flexDiv);

    document.getElementById('yourContainer').appendChild(container);
    document.getElementById('btnLien').classList.add("hidden")
    });

</script>
<?php
    // Vérifier si le formulaire a été soumis
    if (isset($_POST['inserres'])) {
        // Récupérer les valeurs des champs du formulaire
        $url = $_POST['url'];
        $type = $_POST['typeurl'];

        // Effectuer les validations et les opérations de stockage dans la base de données ici
        // ...
        $inserUrl = $datebase->prepare("INSERT INTO reseauxsociaux ( urlReseauxsociaux, typeReseauxsociaux, idEntreprise ) VALUES (:url, :typeurl, :id);");
        $inserUrl->bindParam("id",$_GET['id']);
        $inserUrl->bindParam("url",$url);
        $inserUrl->bindParam("typeurl",$type);

        $inserUrl -> execute();
        // Redirection vers une autre page après la soumission du formulaire
        header("Location: SettingEntreprise.php?id=".$_GET['id']."&key=".$_GET['key']); // Remplacez "confirmation.php" par le nom de votre page de confirmation
        exit();
    }
?>

</html>