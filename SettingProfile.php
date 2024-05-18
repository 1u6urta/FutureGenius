<?php
    session_start();
    //    echo md5("jugurta1u6urta");
    $border = 'style="border: #FF0000 2px solid ;"';
    include('back/database.php');
    if (empty($_GET['id'])) {
        header("Location: SettingProfile.php?id=".$_SESSION['id']."&key=".$_GET['key']);
    }
        elseif ( $_SESSION['id'] != $_GET['id']) {
            header("Location: index.php");
        }
        elseif (empty($_GET['key']) )  {
            header("Location: SettingProfile.php?id=".$_SESSION['id']."&key=Profil");
        } else {
            $myreseaux = $datebase->prepare("SELECT * FROM employeur e , reseauxsociaux r WHERE e.idCandidat = r.idEmployeur AND e.idCandidat = :id AND estProfil	= 1 ");
            $myreseaux-> setFetchMode(PDO::FETCH_ASSOC);
            $myreseaux->bindParam("id",$_GET['id']);
            $myreseaux->execute();
            ///////////////////////////////////////////////////////////
            $mypic = $datebase -> prepare("SELECT * FROM images WHERE idEmployeur = :id AND estProfil = 1 ");
            $mypic ->bindParam("id",$_GET['id']);
            $mypic ->execute();
            foreach ( $mypic AS $pic ) {}
            /////////////////////////////////////////////
            $myinfo = $datebase -> prepare("SELECT * FROM employeur WHERE idCandidat = :id ");
            $myinfo ->bindParam("id",$_GET['id']);
            $myinfo ->execute();
            //foreach($myinfo AS $info) {}
            foreach($myinfo AS $info) {
                if ($info['verifieNum'] == 0 ) {
                    $mssgNum  = "Vérifiez Votre Numero";
                }
                if ($info['verifieEmail'] == 0 ) {
                    $mssgEmail  = "Vérifiez Votre Email";
                }
            } 
            ////////////////////////////////
            $mytags = $datebase -> prepare("SELECT * FROM tags WHERE idEmployeur = :id ");
            $mytags ->bindParam("id",$_GET['id']);
            $mytags ->execute();
            if (isset($_POST['ajoute'])) {
                if ( ! empty($_POST['newtag'])) {
                    $insert = $datebase->prepare("INSERT INTO tags (nameTag, idEmployeur) VALUES (:tag, :id)");
                    $insert->bindParam(":id", $_GET['id']);
                    $insert->bindParam(":tag", $_POST['newtag']);
                    $insert->execute();
                    header("Location: SettingProfile.php?id=" . $_GET['id'] . "&key=" . $_GET['key']);
                }
            }
            if ( isset($_POST['deletag'])) {
                $dele = $datebase -> prepare("DELETE FROM tags WHERE idTag = :id");
                $dele -> bindParam(":id",$_POST['deletag']);
                $dele -> execute();
                header("Location: SettingProfile.php?id=" . $_GET['id'] . "&key=" . $_GET['key']);
            }
            if ( isset($_POST['ajoutedip'])) {
                $description = $_POST['description'];
                @$file_size = $_FILES['file']['size'];
                @$file_tmp = $_FILES['file']['tmp_name'];
                @$file_type = $_FILES['file']['type'];
                @$file_name = $description.$_GET['id'].$file_type; 
                $path = "file/Diplomes/";
                $file_path = "file/Diplomes/".$file_name;
                
                if($file_type != "application/pdf" && $file_type != "application/msword" && $file_type != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                    $messgpdf = "Le fichier doit être de type PDF";
                    exit();
                }
                if($file_size > 5242880) {
                    $messgpdf = "Le fichier ne doit pas dépasser 5 Mo";
                    exit();
                }
                if ( ! move_uploaded_file($file_tmp, $file_path)) {
                    echo  "Le fichier";
                    exit();
                }
                $stmt = $datebase->prepare("INSERT INTO files (descriptionFile, nameFile	, pathFile	, typeFile, idEmployeur	) VALUES (:description, :file_name, :file_path, :file_type , :id)");
                $stmt->execute(array(':description' => $description, ':file_name' => $file_name, ':file_path' => $path , ':file_type' => $file_type , ':id' => $_GET['id']));
                header("Location: SettingProfile.php?id=" . $_GET['id'] . "&key=" . $_GET['key']);
            }
            if ( isset( $_POST['dele'])) {
                $removeUrl = $datebase->prepare("DELETE FROM reseauxsociaux WHERE idReseauxsociaux = :id  ");
                $removeUrl->bindParam("id",$_POST['dele']);
                $removeUrl -> execute();
                header("Location: SettingProfile.php?id=".$_GET['id']."&key=".$_GET['key']);
            }
            if ( isset( $_POST['updateres'])) {   
                $update = $datebase->prepare("UPDATE reseauxsociaux SET urlReseauxsociaux = :urll  WHERE idReseauxsociaux = :id");
                $update->bindParam("id",$_POST['updateres']);
                $update->bindParam("urll",$_POST['url']);
                //$update->bindParam("typeurl",$_POST['typeurl']);
                $update -> execute();
                header("Location: SettingProfile.php?id=".$_GET['id']."&key=".$_GET['key']);
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
                $insert -> bindParam("idEnt",$ident);
                $insert -> bindParam("idEmp",$_GET['id']);
                $insert -> execute();
                header("Location: SettingProfile.php?id=".$_GET['id']."&key=".$_GET['key']);
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
                                elseif (md5($mdp) != $info['mdpCandidat']) {
                                    $mssgmdp = "Mot de passe incorrect ";
                                } 
                                    else {
                                        $update = $datebase->prepare("UPDATE employeur SET mdpCandidat = :mdp WHERE idCandidat= :id ");
                                        $update->bindParam("id",$_GET['id']);
                                        $update->bindParam("mdp",md5($nvmdp));
                                        $update->execute();
                                        header("Location: SettingProfile.php?id=".$_SESSION['id']."&key=".$_GET['key']);
                                    }
            }
            if (isset($_POST['updateprofil'])) {
                $rech = $datebase->prepare("SELECT * FROM entreprise en,employeur em WHERE en.emailEntreprise = :email OR em.emailCandidat = :email ");
                $rech ->bindParam("email",$_POST['emailCandidat']);
                $rech ->execute();
                if ( empty($_POST['nomCandidat']) ) {
                    $mssgNom = "Veuillez remplir ce champ";
                } 
                    elseif ( empty($_POST['emailCandidat']) ) {
                        $mssgEmail = "Veuillez remplir ce champ";
                    }
                        elseif ( empty($_POST['numCandidat'])  ) {
                            $mssgNum = "Veuillez remplir ce champ";
                        } elseif ( $info['emailCandidat'] != $_POST['emailCandidat'] & $rech->rowCount() > 0) {
                            $mssgEmail = "Email deja exsite";
                        }else {
                            if ($info['verifieEmail'] == 1 ) {
                                if ($info['emailCandidat'] == $_POST['emailCandidat']) $verEamil = 1; else $verEamil = 0;
                            } else {
                                $verEamil = 0;
                            }
                            if ($info['verifieNum'] == 1 ) {
                                if ($info['numCandidat'] == $_POST['numCandidat']) $verNum = 1; else $verNum = 0;         
                            } else {
                                $verNum = 0;
                            }
                            if (! isset($_FILES['img'])) {
                                $file_name = $_GET['id'].$_FILES['img']['name'];
                                $file_size = $_FILES['img']['size'];
                                $file_tmp = $_FILES['img']['tmp_name'];
                                $file_type = $_FILES['img']['type'];
                                $path = "imgs/Profile/";
                                $file_path = "imgs/Profile/". $file_name ;
                                //echo $file_type;
                                if($file_type != "image/png" && $file_type != "image/jpg"&& $file_type != "image/jpeg") {
                                    echo "Le fichier doit être de type image";
                                    exit();
                                }
        
                                if($file_size > 5242880) {
                                    echo "Le fichier ne doit pas dépasser 5 Mo";
                                    exit();
                                } 
                                if ( !move_uploaded_file($file_tmp, $file_path)) {
                                    echo "Le fichier";
                                }
                                $updateimg = $datebase-> prepare("INSERT INTO images (nomImage, cheminImage, typeImage, estProfil, estActive, idEmployeur, idEntreprise) VALUES (:nom,:path, :type,1,1,:idEmp,0)");
        
                                $updateimg -> bindParam(":nom",$file_name);
                                $updateimg -> bindParam(":path",$path);
                                $updateimg -> bindParam(":type",$file_type);
                                $updateimg -> bindParam(":idEmp",$_GET['id']);
                                $updateimg -> execute();
                            }
                            $update = $datebase->prepare("UPDATE employeur SET 
                            nomCandidat = :Nom,
                            prenomCandidat = :Prenom,
                            siteCandidat = :Site,
                            emailCandidat = :Email,
                            verifieEmail = :VEmail,
                            dateNaissanceCandidat = :Date,
                            numPays = :Paysnum,
                            numCandidat = :Num,
                            verifieNum = :VNum,
                            addressCandidat = :Address,
                            paysCandidat = :Pays,
                            villeCandidat = :Ville,
                            proffession = :pro,
                            biographie = :Bio
                            WHERE idCandidat = :id ");
        
        
                            $update->bindParam("id",$_GET['id']);
                            $update->bindParam("Nom",$_POST['nomCandidat']);
                            $update->bindParam("Prenom",$_POST['prenomCandidat']);
                            $update->bindParam("Site",$_POST['siteCandidat']);
                            $update->bindParam("Email",$_POST['emailCandidat']);
                            $update->bindParam("Date",$_POST['dateNaissanceCandidat']);
                            $update->bindParam("Paysnum",$_POST['numPays']);
                            $update->bindParam("Num",$_POST['numCandidat']);
                            $update->bindParam("Address",$_POST['addressCandidat']);
                            $update->bindParam("Pays",$_POST['paysCandidat']);
                            $update->bindParam("Ville",$_POST['villeCandidat']);
                            $update->bindParam("pro",$_POST['proffession']);
                            $update->bindParam("Bio",$_POST['biographie']);
                            $update->bindParam("VEmail",$verEamil);
                            $update->bindParam("VNum",$verNum);
                            $update->execute();
                            header("Location: SettingProfile.php?id=".$_GET["id"]."&key=".$_GET['key']);
                        }
            }
        }
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
    <title>FutureGenius</title>
</header>

<body>
    <?php
        include("navbar.php");
    ?>
    <div class="hors flex">
        <div class="Menu">
            <div class="img"><img id="imgp" src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" /></div>
            <div class="nom"></div>
            <div class="Parametres">
                <h2><i class="fa-solid fa-gear"></i> Parametres</h2>
                </h2>
            </div>
            <div class="par">
                <ul>
                    <form method="get">
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Profil") echo "active" ?>" name="key" value="Profil" id="mp"><i class="fa-solid fa-user"></i>
                                <p>Mon Profile</p>
                            </button></li>
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Mot De Passe") echo "active"; ?>" name="key" value="Mot De Passe" id="mdp"><i class="fa-solid fa-lock"></i>
                                <p>Mot de Passe</p>
                            </button></li>
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Reseaux Sociaux") echo "active" ?>" name="key" value="Reseaux Sociaux" id="rs"><i class="fa-brands fa-facebook"></i>
                                <p>Reseaux sociaux</p>
                            </button></li>
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Mes Diplomes") echo "active" ?>" name="key" value="Mes Diplomes" id="dip"><i class="fa-brands fa-facebook"></i>
                                <p>Mes Diplomes</p>
                            </button></li>
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Tags") echo "active" ?>" name="key" value="Tags" id="tags"><i class="fa-brands fa-facebook"></i>
                                <p>Tags</p>
                            </button></li>
                        <li class="items"><button class="btn <?php if ($_GET['key'] == "Votre Abonnment Premuim") echo "active" ?>" name="key" value="Votre Abonnment Premuim" id="ap"><i class="fa-solid fa-star"></i>
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

                <div class="<?php if ($_GET['key'] != "Profil") echo "hidden" ?>" id="MonProfil">
                    <form method="post" enctype="multipart/form-data">
                        <div class="imgsetting flex">
                            <div class="img"><img id="imgp" src="<?php echo $pic['cheminImage'].$pic['nomImage']; ?>" /></div>
                            <label for="ImagePro" class="primarybtn">
                                <p>Nouvelle Image</p>
                                <input type="file" id="ImagePro" name="img" accept=".png,.jpg,.jpeg"/>
                            </label>

                            <button class="secondbtn">Supprimer</button>
                        </div>
                        <div class="itmsflex">
                            <div class="form1 flex">
                                <div class="itsform">
                                    <p class="label">Nom :</p>
                                    <input class="piinput"  name="nomCandidat" value="<?php echo $info['nomCandidat'];?>">
                                </div>
                                <div class="itsform">
                                    <p class="label">Prenom:</p>
                                    <input class="piinput" name="prenomCandidat" value="<?php  echo $info['prenomCandidat'] ?>">
                                </div>
                            </div>
                            <div class="form">
                                <p class="label">Proffession :</p>
                                <input class="input" name="proffession" value="<?php echo $info['proffession']; ?>">
                            </div>
                        </div>
                        <div class="itmsflex">
                            <div class="form">
                                <p class="label">Email :</p>
                                <input class="input" <?php if ( ! empty($mssgEmail)  ) {echo $border; }  ?> name="emailCandidat" value="<?php  echo $info['emailCandidat'];?>">
                            </div>
    
                            <div class="form">
                                <p class="label">Site Web :</p>
                                <input class="input" name="siteCandidat" value="<?php  echo $info['siteCandidat']?>">
                            </div>
                        </div>
                        <?php 
                                    if ( ! empty($mssgEmail )  ) {
                                        echo '<a href="verification.php?email='.$info['emailCandidat'].'&name='.$info['nomCandidat'].'&id='.$_GET['id'].'&verifie=email" style ="color:#FF0000;font-size: 10pt;margin-left :55px;">'.$mssgEmail.'</a><br><br>';
                                    }
                                ?>
                        <div class="itsform ml">
                            <div class="form">
                                <p class="label">Date De Naissance:</p>
                                <input class="input" type="date" name="dateNaissanceCandidat" value="<?php echo $info['dateNaissanceCandidat']; ?>">
                            </div>
                        </div>
                        <div>
                            <div class="itsform ml">
                                <p class="label">Numéro de télèphone :</p>
                                <select class="num" name="numPays">
                                    <option><?php $info['numPays']?></option>
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
                                <input class="input" type="number" <?php if ( ! empty($mssgNum)  ) {echo $border; }  ?> name="numCandidat" value="<?php  echo  $info['numCandidat']?>">
                            </div>
                            <?php 
                                    if ( ! empty($mssgNum )  ) { 
                                        echo '<br><a  href="verification.php" style ="color:#FF0000;font-size: 10pt; margin-left:105px;">'.$mssgNum.'</a><br><br>';
                                    }
                                ?>
                            <div class="itmsflex">
                                <div class="form">
                                    <p class="label">Address :</p>
                                    <input class="input" name="addressCandidat" value="<?php  echo $info['addressCandidat']?>">
                                </div>
                                <div class="form1 flex">
                                    <div class="itsform">
                                        <p class="label">Pays :</p>
                                        <select id="pays" class="selec" name="paysCandidat" onchange="updateVilles()">
                                            <option value=""><?php echo $info['paysCandidat'] ?></option>
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
                                                foreach ($pays as $p) {
                                                    echo "<option value='$p'>$p</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="itsform">
                                        <p class="label">Ville :</p>
                                        <select id="ville" class="selec" name="VilleEntrepris">
                                            <option value=""><?php echo $info['villeCandidat']?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="cvDownload" class="cv-download">
                            <i class="fa-solid fa-download"></i>
                            <p class="download">Télécharger votre CV</p>
                            <input type="file" id="cvDownload" accept=".pdf" class="cv-downloa"></input>
                        </label>
                        <div class="form ml">
                            <p class="label">Biographie</p>
                            <textarea name="biographie">
                            <?php
                                echo $info['biographie'];
                            ?>
                            </textarea>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="updateprofil" class="primarybtn ">Confirmer</button>
                            <button type="reset" name="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>

                <div class="<?php if ($_GET['key'] != "Mot De Passe") echo "hidden" ?>" id="MotPasse">
                    <form method="post">
                        <h2 class="tete mt">Renouveler le mot de passe</h2>
                        <div class="form ml mt">
                            <p class="label">Mot De Passe acuel :</p>
                            <input type="password" class="input" name="mdp" <?php if (!empty($mssgmdp)) { echo $border;} ?> value="<?php if (!empty($mdp)) {echo $mdp;} ?>" placeholder="Saisissez votre mot de passe" />
                            <?php
                            if (!empty($mssgmdp)) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">' . $mssgmdp . '</p>';
                            }
                            ?>
                        </div>
                        <div class="form ml mt">
                            <p class="label">Nouveau Mot De Passe :</p>
                            <input type="password" name="nvmdp" <?php if (!empty($mssgnvmdp)) {echo $border;} ?> value="<?php if (!empty($nvmdp)) {echo $nvmdp;} ?>" placeholder="Saisissez le Nouveau mot de passe" class="input" />
                            <?php
                            if (!empty($mssgnvmdp)) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">' . $mssgnvmdp . '</p>';
                            }
                            ?>
                        </div>
                        <div class="form ml mt">
                            <p class="label">Confirmer le Mot De Passe :</p>
                            <input type="password" name="cmdp" <?php if (!empty($mssgcmdp)) {echo $border;} ?> value="<?php if (!empty($cmdp)) {echo $cmdp;} ?>" placeholder="Confirmez le Nouveau mot de passe" class="input" />
                            <?php
                            if (!empty($mssgcmdp)) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">' . $mssgcmdp . '</p>';
                            }
                            ?>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="updatemotdepasse" id="mdp1" class="primarybtn">Confirmer</button>
                            <button type="reset" name="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>

                <div class="<?php if ($_GET['key'] != "Reseaux Sociaux") echo "hidden" ?>" id="ReseauxSociaux">
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
                            <button class="btnaj" id="btnLien">+ Ajouter un lien </button>
                        </div>
                        <div class="Buttons ml flex">
                            <button type="submit" name="inserres" class="primarybtn ">Confirmer</button>
                            <button type="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>

                <div class="flex mt <?php if ($_GET['key'] != "Votre Abonnment Premuim") echo "hidden" ?>" id="Abonnement">
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
                <div class="<?php if ($_GET['key'] != "Mes Diplomes") echo "hidden" ?>" id="dips">
                    <form method="post">
                        <h2 class="tete mt">Les Diplomes</h2>
                        <div class="form ml mt ">
                                <p class="label">Diplome </p>
                                <div class="Res ">
                                        <input type="text" class="input" name="description"/>
                                        <label class="cv-download">
                                            <i class="fa-solid fa-download"></i>
                                            <p class="download">Votre Diplome</p>
                                            <input type="file" name="file" id="file" class="inputnone"></input>
                                        </label>
                                        <button class="primarybtn" name="ajoutedip" value="" >Ajoute</button>
                                        <button class="secondbtn" name="dele" value="" >Supprimer</button>
                                </div>
                            </div>                    
                        <div class="Buttons ml flex">
                            <button type="submit" name="inserres" class="primarybtn ">Confirmer</button>
                            <button type="reset" class="secondbtn">Annuler</button>
                        </div>
                    </form>
                </div>
                <div class="<?php if ($_GET['key'] != "Tags") echo "hidden" ?>" id="tags">
                    <form method="post">
                        <h2 class="tete mt">Les Tags</h2>                    
                        <div class="tag">
                            <?php
                                foreach ( $mytags AS $tag ) {
                            ?>
                            <div class="tg flex">
                                <?php echo '<p>'.$tag['nameTag'].'</p>'; ?>
                                <form method="post">
                                    <button name="deletag" class="close" value="<?php echo $tag['idTag'] ?>"><i class="fa-solid fa-xmark" style="color: #d40c0c;"></i></button>
                                </form>                            
                                </div>
                            <?php } ?>
                        </div>
                        <div id="yourTags"></div>
                        <div>
                            <button class="btnaj" id="btntag">+ Ajouter un Tag </button>
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
</script>
<script>
    document.getElementById('btnLien').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        var container = document.createElement('div');
        container.className = 'form ml mt';

        var label = document.createElement('p');
        label.className = 'label';
        label.textContent = 'Reseau ';

        var index =<?php echo $myreseaux->rowCount() + 1?> ;//document.querySelectorAll('.form.ml.mt').length + 1;
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

    document.getElementById('btndis').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('btndis').classList.add("hidden")
        
        var container = document.createElement('div');
        container.className = 'form ml mt';

        var label = document.createElement('p');
        label.className = 'label';
        var index = document.querySelectorAll('.form.ml.mt').length + 1;
        label.textContent = 'Diplome ' + index;

        var flexDiv = document.createElement('div');
        //    flexDiv.classList.add('flex');
        flexDiv.classList.add('Res');

        

        var form = document.createElement('form');
        form.method = 'post';

        var inputDescription = document.createElement('input');
        inputDescription.type = 'text';
        inputDescription.className = 'input';
        inputDescription.name = 'description';

        var labelDownload = document.createElement('label');
        labelDownload.className = 'cv-download';

        var iconDownload = document.createElement('i');
        iconDownload.className = 'fa-solid fa-download';

        var pDownload = document.createElement('p');
        pDownload.className = 'download';
        pDownload.textContent = 'Votre Diplome';

        var inputDownload = document.createElement('input');
        inputDownload.type = 'file';
        inputDownload.accept = '.pdf';
        inputDownload.name = 'file'
        inputDownload.style.display = 'none';


        var buttonEdit = document.createElement('button');
        buttonEdit.className = 'primarybtn';
        buttonEdit.name = 'ajoutedip';
        buttonEdit.value = '';
        buttonEdit.textContent = 'Ajoute';

        var buttonDelete = document.createElement('button');
        buttonDelete.className = 'secondbtn';
        buttonDelete.name = 'dele';
        buttonDelete.value = '';
        buttonDelete.textContent = 'Supprimer';

        labelDownload.appendChild(iconDownload);
        labelDownload.appendChild(pDownload);

        form.appendChild(inputDescription);
        form.appendChild(labelDownload);
        form.appendChild(inputDownload);
        form.appendChild(buttonEdit);
        form.appendChild(buttonDelete);

        flexDiv.appendChild(form);

        container.appendChild(label);
        container.appendChild(flexDiv);

        document.getElementById('yourDips').appendChild(container);
    });
    document.getElementById('btntag').addEventListener('click', function(event) {
        event.preventDefault();
        //document.getElementById('btntag').classList.add("hidden")
        var container = document.createElement('div');
        container.className = 'form ml mt';

        var label = document.createElement('p');
        label.className = 'label';
        var index = <?php echo $mytags->rowCount() + 1 ?>;//document.querySelectorAll('.form.ml.mt').length + 1;
        label.textContent = 'Tag ' + index;

        var flexDiv = document.createElement('div');
        flexDiv.className = 'flex Res';

        var form = document.createElement('form');
        form.method = 'post';

        var inputTag = document.createElement('input');
        inputTag.type = 'text';
        inputTag.className = 'input';
        inputTag.name = 'newtag';

        var buttonEdit = document.createElement('button');
        buttonEdit.className = 'primarybtn';
        buttonEdit.style.marginLeft = '10px'; // Ajoutez la valeur de marge souhaitée
        buttonEdit.name = 'ajoute';
        buttonEdit.value = '';
        buttonEdit.textContent = 'Ajoute';

        var buttonDelete = document.createElement('button');
        buttonDelete.className = 'secondbtn';
        buttonDelete.name = 'deltag';
        buttonDelete.value = '';
        buttonDelete.textContent = 'Supprimer';

        form.appendChild(inputTag);
        form.appendChild(buttonEdit);
        form.appendChild(buttonDelete);

        flexDiv.appendChild(form);

        container.appendChild(label);
        container.appendChild(flexDiv);

        document.getElementById('yourTags').appendChild(container);
    });


</script>
</html>