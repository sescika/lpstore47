<?php   
        session_start();
        include "../config/connection.php";
        include "functions.php";
        include "utilities.php";
        header("Content-Type: application/json");

        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && $_SESSION['korisnik']->id == $_GET['id']) {

                $profil = dohvatiProfil($_GET['id']);

                $response = ['profil' => $profil];
                
                echo json_encode($response);
        } else {
                
                $response = ['poruka' => "Došlo je do greške."];

                echo json_encode($response);

                redirect("../404.php");
        }
?>