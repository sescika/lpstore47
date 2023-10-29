<?php
session_start();
if (isset($_POST['btnLogovanje'])) {
    include "../config/connection.php";
    include "functions.php";
    include "utilities.php";
    try {
        $username = $_POST['tbUserL'];
        $lozinka = $_POST['tbPasswordL'];

        $ulogovanKorisnik = logovanje($username, md5($lozinka));

        if (!isset($_SESSION['korisnik'])) {
            if ($ulogovanKorisnik) {
                //set session
                $_SESSION['korisnik'] = $ulogovanKorisnik;
                $id = $ulogovanKorisnik->id;
                upisLogFajl("login", 1);
                //update last login
                updateLastLoginUser($id);

                if ($ulogovanKorisnik->nazivRole == "korisnik") {
                    redirect("../index.php?page=home");
                }
                if ($ulogovanKorisnik->nazivRole == "admin") {
                    redirect("../index.php?page=admin");
                }
            } else {
                upisLogFajl("login", 0);
                $_SESSION['greska-logovanje'] = "Greška prilikom logovanja.";
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $_SESSION['vec-ulogovan'] = "Već ste ulogovani";
            redirect("../logovanje.php");
        }
    } catch (PDOException $exception) {
        http_response_code(500);
        echo $exception->getMessage();
    }
} else {
    header("Location: ../index.php");
}
