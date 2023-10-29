<?php
header("content-type: application/json");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include '../config/connection.php';
    include "functions.php";

    $user = $_SESSION['korisnik']->username;

    $response = [];

    $poruzbine = dovhatiPorudzbine();

    $response = [
        'porudzbine' => $poruzbine,
        'user' => $user
    ];

    echo json_encode($response);
} else {
    header("Location: ../index.php?page=home");
}
