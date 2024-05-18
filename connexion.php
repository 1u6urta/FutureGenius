<?php
    session_start();
    include('back/database.php');
    if ( isset($_POST['conn'])) {
        $Mdp = $_POST['mdp'];
        $Email = $_POST['Email'];
        $border = 'style="border: #FF0000 2px solid ;"';
        if ( empty($Email)) {
            $mssgEmail = "Veuillez remplir ce champ";
        }
        elseif(empty($Mdp))  {
        } 
            else {
                $mssgmdp = "Veuillez remplir ce champ";
                $rech1 = $datebase->prepare("SELECT * FROM employeur WHERE emailCandidat = :email ");
                $rech1 ->bindParam("email",$Email);
                $rech1 ->execute();
                $rech = $datebase->prepare("SELECT * FROM entreprise  WHERE emailEntreprise = :email ");
                $rech ->bindParam("email",$Email);
                $rech ->execute();
                foreach ($rech1 AS $r  ) {}
                foreach ($rech AS $r2  ) {}
                if ($rech1->rowCount() > 0 ) { 
                    if (md5($Mdp) != $r['mdpCandidat']) {
                        $mssgmdp = "Mot de passe incorrect ";
                    } 
                        else {
                            $_SESSION['id'] = $r['idCandidat'];
                            $_SESSION['type'] = "Candidat";
                            header("Location: index.php");
                        }
                } 
                    elseif ($rech->rowCount() > 0 ) {
                        if (md5($Mdp) != $r2['mdpEntreprise'] ) {
                            $mssgmdp = "Mot de passe incorrect ";
                        } 
                        else {
                            $_SESSION['id'] = $r2['idEntreprise'];
                            $_SESSION['type'] = "Entreprise";
                            header("Location: index.php");
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
            <div class="formBox">
                <h1>Bienvenue a FutureGenius</h1>
                <h2>Connectez-vous</h2>
                <div class="google">     
                    <button  value=""><i class="fa-brands fa-google fa-xl" style="margin-right: 5px;"></i> Connectez-vous avec google</button>
                    <i class="lin fa-brands fa-linkedin fa-2xl" style="color: #0b59e0;"></i>
                    <i class="lin fa-brands fa-square-facebook" style="color: #0b59e0;"></i>
                </div>
                <form method="post" id="myForm">
                    <div class="form mt">
                        <p class="label">Email :</p>
                        <input type="text" class="input" name="Email" <?php  if (! empty($mssgEmail) ) {echo $border;} ?> value="<?php if(!empty($Email)) { echo $Email;}?>"  placeholder="Saisissez votre Email" />
                    </div>
                    <?php  
                        if (! empty($mssgEmail) ) {
                            echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgEmail.'</p>';
                        } 
                    ?>
                    <div class="form mt">
                        <p class="label">Mot de passe :</p>
                        <input type="password" class="input" name="mdp" <?php  if (! empty($mssgmdp) ) {echo $border;} ?> value="<?php if(!empty($mdp)) { echo $mdp;}?>"  placeholder="Saisissez votre Mot de passe " />
                    </div>
                    <?php  
                        if (! empty($mssgmdp) ) {
                            echo '<p style ="color: #FF0000;font-size: 11pt;margin: 5px;">'.$mssgmdp.'</p>';
                        } 
                    ?>
                    <div class="oublie">
                        <p>Mot de passe oublié</p>
                    </div>
                    <div class="inputBox">
                        <input type="submit" name="conn" class="primarybtn" value="Connexion.">
                    </div>
                    <div class="inputBx ml-40">
                        <p>Pas de compte ?<a href="inscription.php"> Inscrivez-vous</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>