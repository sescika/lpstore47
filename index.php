<?php
session_start();
ob_start(); 
include "config/connection.php";
include "models/functions.php";
include "models/utilities.php";
include "views/fixed/head.php";
upisLogFajl("view");
include "views/fixed/nav.php";
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'home':
            include "views/pages/home.php";
            break;
        case 'proizvodi':
            include "views/pages/proizvodi.php";
            break;
        case 'registracija':
            include "views/pages/registracija.php";
            break;
        case 'kontakt':
            include "views/pages/kontakt.php";
            break;
        case 'autor':
            include "views/pages/autor.php";
            break;
        case 'profil':
            include "views/pages/profil.php";
            break;
        case 'korpa':
            include "views/pages/korpa.php";
            break;
        case 'admin':
            include "views/pages/admin.php";
            break;
        case 'unos-proizvoda':
            include "views/pages/unos-proizvoda.php";
            break;
        case 'tiketi':
            include "views/pages/tiketi.php";
            break;
        case 'log':
            include "views/pages/log.php";
            break;
        case 'porudzbine':
            include "views/pages/prikaz-porudzbina.php";
            break;
        case 'login':
            include "views/pages/login.php";
            break;
        case 'logout':
            include "views/pages/logout.php";
            break;
    }
} else {

    header("Location: index.php?page=home");
    ob_end_flush();
}

include "views/fixed/footer.php";

?>

