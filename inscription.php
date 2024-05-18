<?php
    session_start();
    //$_SESSION['id'] = 1;
    include('back/database.php');
    @$Email = $_GET['Email'];
    @$PaysNum = $_GET['Paystele'];
    @$Num = $_GET['Number'];
    @$Sele = $_GET['sele'];
    $rech = $datebase->prepare("SELECT * FROM entreprise en,employeur em WHERE en.emailEntreprise = :email OR em.emailCandidat = :email ");
    $rech ->bindParam("email",$Email);
    $rech ->execute();
    $border = 'style="border: #FF0000 2px solid ;"';
    if ( isset($_GET['login']) && $_GET['login'] == 'Suivant') {
        if (empty($Email)) {
            $mssgEmail = "Veuillez remplir ce champ";
        } elseif ( empty($Num)) {
            $mssgNum ="Veuillez remplir ce champ";
        } elseif ( empty($Sele)) {
            $mssgsele = "Veuillez remplir ce champ";
        } elseif($rech -> rowCount() > 0 ) { 
            $mssgEmail = "Email deja exsite";
        }
            else {    
            if ($Sele == "Entreprise") {
                $SuivEn = true;
                $hidden ="hidden";
                @$NomEn = $_POST['NomEn'];
                @$DateEn = $_POST['DateEn'];
                @$MdpEn = $_POST['MdpEn'];
                @$CmdpEn = $_POST['cmdpEn'];
                if ( isset($_POST['login']) ) {
                        if (empty($NomEn)) {
                            $mssgNomEn = "Veuillez remplir ce champ";
                        } 
                            elseif (empty($MdpEn)) {
                                $mssgmdp = "Veuillez remplir ce champ";
                            } 
                                elseif (empty($CmdpEn)) {
                                    $mssgcmdp = "Veuillez remplir ce champ";
                                } elseif ( $CmdpEn != $MdpEn) {
                                    $mssgcmdp = "Verifier votre nouveau mot de passe ";
                                }else {
                                    $insertinfo = $datebase->prepare("INSERT INTO
                                            entreprise (
                                                nomEntreprise,
                                                emailEntreprise,
                                                verifieEmail,
                                                mdpEntreprise,
                                                dateCEntreprise,
                                                paysNumEntreprise,
                                                numEntreprise,
                                                verifieNum
                                            )
                                        VALUES (
                                                :nom,
                                                :email,
                                                0,
                                                :mpd,
                                                :date,
                                                :numpays,
                                                :num,
                                                0);"
                                    ); 
                                    $insertinfo ->bindParam("nom",$NomEn);
                                    $insertinfo ->bindParam("email",$Email);
                                    $insertinfo ->bindParam("mpd",md5($MdpEn));
                                    $insertinfo ->bindParam("date",$DateEn);
                                    $insertinfo ->bindParam("numpays",$PaysNum);
                                    $insertinfo ->bindParam("num",$Num);
                                    $insertinfo -> execute(); 
                                    header("Location: connexion.php");
                                }
                }
            }
            else {
                $SuivEp = true;
                $hidden ="hidden";
                @$NomEp = $_POST['NomEp'];
                @$MdpEp = $_POST['MdpEp'];
                @$CmdpEp = $_POST['cmdpEp'];
                @$DateEp =$_POST['DateEp'];
                @$PreEp = $_POST['PreEp'];
                @$ProEp = $_POST['Pro'];
                if ( isset($_POST['login']) ) {
                        if (empty($NomEp)) {
                            $mssgNomEp = "Veuillez remplir ce champ";
                        } 
                            elseif (empty($MdpEp)) {
                                $mssgmdp = "Veuillez remplir ce champ";
                            } 
                                elseif (empty($CmdpEp)) {
                                    $mssgcmdp = "Veuillez remplir ce champ";
                                } elseif ( $CmdpEp != $MdpEp) {
                                    $mssgcmdp = "Verifier votre nouveau mot de passe ";
                                }
                                elseif (empty($PreEp)) {
                                    $mssgPreEp = "Veuillez remplir ce champ";
                                }
                                else {
                                    $insertinfo = $datebase -> prepare("INSERT INTO employeur (nomCandidat,prenomCandidat,emailCandidat,verifieEmail,mdpCandidat,dateNaissanceCandidat, numPays, numCandidat, verifieNum, proffession) 
                                    VALUES (:nom,:prenom,:email,0,:mdp,:date,:nump,:num, 0, :pro)");
                                    $insertinfo ->bindParam("nom",$NomEp);
                                    $insertinfo ->bindParam("prenom",$PreEp);
                                    $insertinfo ->bindParam("email",$Email);
                                    $md5 = md5($MdpEp);
                                    $insertinfo ->bindParam("mdp",$md5);
                                    $insertinfo ->bindParam("date",$DateEp);
                                    $insertinfo ->bindParam("nump",$PaysNum);
                                    $insertinfo ->bindParam("num",$Num);
                                    $insertinfo ->bindParam("pro",$ProEp);
                                    $insertinfo -> execute(); 
                                    
                                    $rech = $datebase -> prepare("SELECT idCandidat FROM employeur WHERE emailCandidat = :email");
                                    $rech -> bindParam("email",$Email);
                                    $rech -> execute();
                                    foreach ($rech as $r154513) {
                                    }
                                    $pis = $datebase ->prepare("INSERT INTO `images` (`nomImage`, `cheminImage`, `typeImage`, `estProfil`, `estActive`, `idEmployeur`, `idEntreprise`) VALUES ('user.jpg', 'imgs/Profile/', 'image/jpg', '1', '1', :id, '0')");
                                    $pis ->bindParam("id",$r154513["idCandidat"]);
                                    header("Location: connexion.php");
                                }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/connexion.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>
    <script type="text/javascript">
    </script>
</head>
<body>
    <?php
        include("navbar.php");
    ?>
    <div  class="sec">
        <div class ="imgBox"><img src="imgs/JobConn.png"></div>
        <div class ="contentBox">
            <div class="<?php if ($SuivEn || $SuivEp) echo "hidden" ?> formBox">
                <h1>Bienvenue a FutureGenius</h1>
                <h2>Inscrivez-vous</h2>
                <div class="google">     
                    <button  value=""><i class="fa-brands fa-google fa-xl" style="margin-right: 5px;"></i> Connectez-vous avec google</button>
                    <i class="lin fa-brands fa-linkedin fa-2xl" style="color: #0b59e0;"></i>
                    <i class="lin fa-brands fa-square-facebook" style="color: #0b59e0;"></i>
                </div>

                <form  method="get" class="" >
                    <div class="form mt">
                        <p class="label">Email :</p>
                        <input type="email" class="input" name="Email" <?php  if (! empty($mssgEmail) ) {echo $border;} ?> value="<?php if(!empty($Email)) { echo $Email;}?>"  placeholder="Saisissez votre Email" required />
                        <?php  
                            if (! empty($mssgEmail) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgEmail.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="itsform">
                        <p class="label">Numéro de télèphone :</p>
                        <select class="num" name="Paystele">
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
                        <input class="input" type="number" placeholder="Saisissez votre Numéro de télèphone " <?php if ( ! empty($mssgNum)  ) {echo $border; }  ?> name="Number" value="<?php if(!empty($Num)) { echo $Num;}?>">
                        <?php  
                            if (! empty($mssgNum) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgNum.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="form">
                        <p class="label">Type de compte:</p>
                        <select name="sele" class="input" <?php  if (! empty($mssgsele) ) {echo $border;} ?> value="<?php if(!empty($Sele)) { echo $Sele;}?>">
                            <option disabled selected>--non selectionée--</option>
                            <option value="Entreprise">Entreprise</option>
                            <option value="Employe">Employe</option>
                        </select>
                        <?php  
                            if (! empty($mssgsele) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgsele.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="inputBox">
                        <button type="submit" class="primarybtn" name="login" value="Suivant">Suivant</button>
                    </div>
                    <div class="inputBx">
                        <p>Vous avez déja un compte ?<a href="connexion.php">Connectez-vous</a></p>
                    </div>
                </form>


            </div>
            <div class="formBox <?php if (!$SuivEn) echo "hidden" ?>">
                <h1>Bienvenue a FutureGenius</h1>
                <h2>Inscrivez-vous</h2>
                <form method="post">
                    <div class="form mt">
                        <p class="label">Nom de l'entreprise :</p>
                        <input type="text" class="input" name="NomEn" <?php  if (! empty($mssgNomEn) ) {echo $border;} ?> value="<?php if(!empty($NomEn)) { echo $NomEn;}?>"  placeholder="Saisissez nom de l'entreprise" />
                        <?php  
                            if (! empty($mssgNomEn) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgNomEn.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="form">
                        <p class="label">Date de Creation :</p>
                        <input type="date" class="input" name="DateEn" value="<?php if(!empty($DateEn)) { echo $DateEn;}?>" />
                    </div>
                    <div class="form">
                        <p class="label">Mot de passe :</p>
                        <input type="password" class="input" name="MdpEn" <?php  if (! empty($mssgmdp) ) {echo $border;} ?> placeholder="Saisissez Le Mot de passe" />
                        <?php  
                            if (! empty($mssgmdp) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgmdp.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="form">
                        <p class="label">Confirmer Mot de passe :</p>
                        <input type="password" class="input" name="cmdpEn" <?php  if (! empty($mssgcmdp) ) {echo $border;} ?> placeholder="Confirmer Le Mot de passe" />
                        <?php  
                            if (! empty($mssgcmdp) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgcmdp.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="inputBox">
                        <button type="submit" class="primarybtn" name="login" value="Confirmer">Confirmer</button>
                    </div>
                    <div class="inputBx">
                        <p>Vous avez déja un compte ?<a href="connexion.php">Connectez-vous</a></p>
                    </div>
                </form>
            </div>
            <div class="formBox <?php if (!$SuivEp) echo "hidden" ?>">
                <h1>Bienvenue a FutureGenius</h1>
                <h2>Inscrivez-vous</h2>
                <form method="post">
                    <div class="form  flex mt">
                        <div class="formsec">
                            <p class="label">Nom :</p>
                            <input type="text" class="input" name="NomEp" <?php  if (! empty($mssgNomEp) ) {echo $border;} ?> value="<?php if(!empty($NomEp)) { echo $NomEp;}?>"  placeholder="Saisissez votre nom" />
                            <?php  
                                if (! empty($mssgNomEp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgNomEp.'</p>';
                                } 
                            ?>
                        </div>
                        <div class="formsec">
                            <p class="label">Prénom :</p>
                            <input type="text" class="input" name="PreEp" <?php  if (! empty($mssgPreEp) ) {echo $border;} ?> value="<?php if(!empty($PreEp)) { echo $NPreEp;}?>"  placeholder="Saisissez votre Prénom" />
                            <?php  
                                if (! empty($mssgPreEp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgPreEp.'</p>';
                                } 
                            ?>
                        </div>
                    </div>
                    <div class="form  flex mt">
                        <div class="formsec">
                            <p class="label">Date de Naissance :</p>
                            <input type="date" class="input" name="DateEp" value="<?php if(!empty($DateEp)) { echo $DateEp;}?>" />
                        </div>
                        <div class="formsec">
                            <p class="label">Profession :</p>

                            <select type="text" class="input" name="Pro" <?php  if (! empty($mssgProEp) ) {echo $border;} ?> value="<?php if(!empty($ProEp)) { echo $ProEp;}?>">
                                <?php
                                    $professions = array(
                                        "Développeur",
                                        "Responsable des ventes",
                                        "Comptable",
                                        "Designer",
                                    );
                                    foreach ($professions as $profession) {
                                        echo "<option>" . $profession . "</option>";
                                    } 
                                ?>
                            </select>
                            <?php  
                                if (! empty($mssgProEp) ) {
                                    echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgProEp.'</p>';
                                } 
                            ?>
                        </div>
                    </div>
                    <div class="form mt">
                        <p class="label">Mot de passe :</p>
                        <input type="password" class="input" name="MdpEp" <?php  if (! empty($mssgmdp) ) {echo $border;} ?> placeholder="Saisissez Le Mot de passe" />
                        <?php  
                            if (! empty($mssgmdp) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgmdp.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="form mt">
                        <p class="label">Confirmer Mot de passe :</p>
                        <input type="password" class="input" name="cmdpEp" <?php  if (! empty($mssgcmdp) ) {echo $border;} ?> placeholder="Confirmer Le Mot de passe" />
                        <?php  
                            if (! empty($mssgcmdp) ) {
                                echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgcmdp.'</p>';
                            } 
                        ?>
                    </div>
                    <div class="inputBox">
                        <button type="submit" class="primarybtn" name="login" value="Confirmer">Confirmer</button>
                    </div>
                    <div class="inputBx">
                        <p>Vous avez déja un compte ?<a href="connexion.php">Connectez-vous</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>