<?php
    session_start();
    if ( $_SESSION['type'] == "Entreprise") {
        header("Location: ../SettingEntreprise.php?id=".$_SESSION['id']."&key=");
    }
    else {
        header("Location: ../SettingProfile.php?id=".$_SESSION['id']);
    }
?>