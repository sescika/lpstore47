<?php
    if(isset($_SESSION['korisnik'])) {
        session_destroy();

        redirect("index.php?page=login");
    } else {
        redirect("index.php?page=login");
        $_SESSION['nije-ulogovan'] = "Niste ulogovani.";
    }


?>