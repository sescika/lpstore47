<?php   
        session_start();
        include "../config/connection.php";
        include "functions.php";
        header("Content-Type: application/json");

        if($_SERVER["REQUEST_METHOD"] == "GET") {

                $graficke = dohvatiSvePodatke("graficke_proizvodjaci");
                $procesori = dohvatiSvePodatke("procesor_proizvodjaci");
                $proizvodjaci = dohvatiSvePodatke("proizvodjaci");

                $response = [
                        "proizvodjaciGraficke" => $graficke,
                        "proizvodjaciProcesori" => $procesori,
                        "proizvodjaci" => $proizvodjaci
                ];
                
                echo json_encode($response);

        } else {
                redirect("../proizvodi.php");
        }
?>