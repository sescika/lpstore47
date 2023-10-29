<?php
include "../config/connection.php";
include "functions.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $arrIdProizvoda = $_POST['arrValueIdProizvoda'];
    $arrKolicinaProizvoda = $_POST['arrValueKolicinaProizvoda'];
    $konacnaCena = $_POST['valueKonacnaCena'];
    $userId = $_SESSION['korisnik']->id;

    $response = [];
    $statusniKod = "";

    $rez = unosPorudzbine($konacnaCena, $userId, $arrIdProizvoda, $arrKolicinaProizvoda);

    if($rez) {
        $response = ["poruka" => "Uspešno uneta porudžbina."];
        $statusniKod = 201;
    } else {
        $response = ["poruka" => "Došlo je do greške pri unosu."];
        $statusniKod = 500;

    }

    echo json_encode($response);
    http_response_code($statusniKod);

} else {
    header("Location: ../index.php?page=home");
}

?>
