<?php
    session_start();
    if ( $_SESSION['type'] == "Entreprise") {
        header("Location: ../Entreprise.php?id=".$_SESSION['id']);
    }
    else {
        header("Location: ../profile.php?id=".$_SESSION['id']);
    }
?>