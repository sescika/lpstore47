<?php
    session_start();
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "utilities.php";
        include "../config/connection.php";
        include "functions.php";

        $response = "";
        $statusniKod = "";
        $nizGresaka = [];
        

        if(isset($_SESSION['korisnik'])) {

            if(isset($_SESSION['korisnik']->email)) {
                $formaEmail = $_SESSION['korisnik']->email;
            } else {
                $formaEmail = $_POST['formaEmail'];
            }
            $korisnikId = $_SESSION['korisnik']->id;
            $formaDdlProizvodjaci = $_POST['formaDdlProizvodjaci'];
            $formaTextArea = $_POST['formaTextArea'];

            if(!filter_var($formaEmail, FILTER_VALIDATE_EMAIL)) {
                $nizGresaka = "Pogrešan format emaila";
            }
            
            if(strlen($formaTextArea) < 15) {
                $nizGresaka = "Kratak opis.";
            }

            if($formaDdlProizvodjaci == 0) {
                $nizGresaka = "Izaberite proizvodjača.";
            }

            if(count($nizGresaka) == 0) {
                $uspeh = unosTiketa($korisnikId, $formaTextArea, $formaDdlProizvodjaci);

                if($uspeh) {
                    $response = ['poruka' => "Uspešno unet tiket."];
                    $statusniKod = 200;
                } else {
                    $response = ['poruka' => $nizGresaka];
                    $statusniKod = 500;
                }
            } else {
                $response = ["poruka" => $nizGresaka];
                $statusniKod = 422;
            }

        } else {
            $response = ['poruka' => "Ulogujte se da bi ste poslali tiket."];
            $statusniKod = 401;
        }

        echo json_encode($response);
        http_response_code($statusniKod);
    }
    else{
        http_response_code(404);
    }

?>