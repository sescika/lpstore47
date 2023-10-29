<?php
session_start();
include "../config/connection.php";
include "functions.php";
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {

        $proizvod = dohvatiProizvod($_GET['id']);
        $proizvodjaci = dohvatiSvePodatke("proizvodjaci");
        $graficke = dohvatiSvePodatke("graficke_specifikacije");
        $procesori = dohvatiSvePodatke("procesor_specifikacije");

        $response = [
                "proizvod" => $proizvod,
                "proizvodjaci" => $proizvodjaci,
                "graficke" => $graficke,
                "procesori" => $procesori
        ];

        echo json_encode($response);
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['nazivProizvod']))) {

        $nazivProizvod = $_GET['nazivProizvod'];

        $proizvodi = searchProizvode($nazivProizvod);

        echo json_encode($proizvodi);
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['strana']))) {

        $proizvodi = dohvatiSveProizvodePaginacija($_GET['strana']);

        echo json_encode($proizvodi);
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['filteri']))) {

        if (isset($_GET['filteri']['arrValueGraficke'])) {
                $arrIdGraficke = $_GET['filteri']['arrValueGraficke'];
        } else {
                $arrIdGraficke = [];
        }

        if (isset($_GET['filteri']['arrValueProcesori'])) {
                $arrIdProcesori = $_GET['filteri']['arrValueProcesori'];
        } else {
                $arrIdProcesori = [];
        }

        if (isset($_GET['filteri']['arrValueProizvodjaci'])) {
                $arrIdProizvodjaci = $_GET['filteri']['arrValueProizvodjaci'];
        } else {
                $arrIdProizvodjaci = [];
        }

        $proizvodi = filterProizvoda($arrIdGraficke, $arrIdProcesori, $arrIdProizvodjaci);

        echo json_encode($proizvodi);
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

        echo json_encode(dohvatiSveProizvode());
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['stranica']))) {

        echo json_encode(dohvatiSveProizvodePaginacija($_GET['stranica']));
}
