<?php
    session_start();
    include('back/database.php');
    if ( ! isset($_GET['verify'])) {
        @$_SESSION['idverifie'] = $_GET['id'];
        @$_SESSION['nameverifie'] = $_GET['name'];
        @$_SESSION['emailverifie'] = $_GET['email'];
        @$_SESSION['verifieverifie'] = $_GET['verifie'];
        $otp = rand(100000,999999);
        $_SESSION['otp'] = $otp;
        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';
        $mail->Username='YOUR EMAIL';
        $mail->Password='PASSWORED';
        $mail->setFrom('DEAR EMAIL', 'Code De Verification');
        $mail->addAddress($_SESSION['emailverifie']);
        $mail->isHTML(true);
        $mail->Subject="Your verify code";
        $mail->Body="<p>Dear".$_SESSION['nameverifie']." , </p> <h3>Your verify OTP code is $otp <br></h3>";
        if(!$mail->send()){
            ?>
            <script>
                alert("<?php echo "Register Failed, Invalid Email "?>");
            </script>
            <?php
            }else{
                ?>
                <script>
                    alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                </script>
                <?php
                }
    } else {
        @$otp_code = $_GET['otp_code'];
        $otp = $_SESSION['otp'];
        if($otp != $otp_code){
            ?>
            <script>
                alert("Invalid OTP code");
            </script>
            <?php
        }else{
            //mysqli_query($connect, "UPDATE login SET status = 1 WHERE email = '$email'");
            ?>
            <script>
                alert("Verfiy account done, you may sign in now");
            </script>
            <?php
                    if ( $_SESSION['type'] == "Candidat") {
                    $update = $datebase->prepare("UPDATE employeur SET verifieEmail = 1 WHERE idCandidat = :id ");
                    $update->bindParam("id",$_SESSION['idverifie']);
                    $update->execute();
                    header("Location: SettingProfile.php?id=".$_SESSION['id']."&key=".$_GET['key']);
                } else {
                    $update = $datebase->prepare("UPDATE entreprise SET verifieEmail = 1 WHERE idEntreprise = :id ");
                    $update->bindParam("id",$_SESSION['idverifie']);
                    $update->execute();
                    header("Location: SettingEntreprise.php?id=".$_SESSION['id']."&key=".$_GET['key']);
                }
        }
    }
    if ( isset($_GET['renvoyer'])) {
        header("Location: verification.php?email=".$_SESSION['emailverifie']."&name=".$_SESSION['nameverifie']."&id=".$_SESSION['idverifie']."&verifie=".$_SESSION['verifieverifie']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/verification.css">
    <link rel="stylesheet" href="css/all.min.css"/>
    <link rel="stylesheet" href="css/fonts.css"/>
    <link rel="stylesheet" href="css/style.css">
    <title>FutureGenius</title>
</head>
<body>
    <nav>
        <div class="container">
            <a class="navbar-brand" href="#">Verification Account</a>
        </div>
    </nav>
    <div class="cont">    
        <main class="login-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Verification Email</div>
                            <div class="card-body">
                                <form action="#" method="GET">
                                    <div class="form-group row">
                                        <div>
                                            <input type="text" id="otp" class="form-control" name="otp_code" placeholder="Veuillez Votre Code"  autofocus>
                                        </div>
                                        <p>Vous l'avez pas reçu?<button class="link" name="renvoyer" value="renvoyerEmail">Renvoyer</button></p>
                                    </div>
                                    <div>
                                        <button  class="primarybtn" type="submit" value="VerifyEmail" name="verify">Verify</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Verification Telephone </div>
                            <div class="card-body">
                                <form action="#" method="GET">
                                    <div class="form-group row">
                                        <div>
                                            <input type="text" id="otp" class="form-control" name="otp_codeTelephone" placeholder="Veuillez Votre Code"   required autofocus>
                                        </div>
                                        <p>Vous l'avez pas reçu?<button class="link" name="renvoyer" value="renvoyerTelephone">Renvoyer</button></p>
                                    </div>
                                    <div>
                                        <button  class="primarybtn" type="submit" value="VerifyTelephone" name="verify">Verify</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
        </main> 
        <img src="imgs/Privacy.png">
    </div>
</body>
</html>
