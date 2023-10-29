<?php
    header("content-type: application/json");

    if(isset($_POST['id'])) {
        include '../config/connection.php';
        include "functions.php";

        $statusCode = 404;
        $response = "";

        $id = $_POST['id']; 
        $proizvod = dohvatiProizvod($id);

        $rez = obrisiProizvod($id);

        if($rez) {
            $response = ["poruka" => "Uspešno obrisan proizvod."];
            $statusCode = 200;
        } else {
            $response = ["poruka" => "Greška prilikom brisanja proizvoda."];
            $statusCode = 500;
        }

        echo json_encode($response);
        http_response_code($statusCode);

    } else {
        $statusCode = 422;
        $response = ['poruka'=>'Identifikator je neophodan za brisanje.'];
        
        http_response_code(422);
        echo json_encode($response);
    }
?>