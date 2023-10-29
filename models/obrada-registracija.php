<?php
    session_start();
    header("Content-type: application/json");
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "utilities.php";
        include "../config/connection.php";
        include "functions.php";

        $username = $_POST['tbUserR'];
        $password = $_POST['tbPasswordR'];
        $email = $_POST['tbUserEmailR'];

        $userRegex = "/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
        $passRegex = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
        $emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";

        $response = "";
        $statusniKod = "";
        $nizGresaka = [];

        //regex provere

        if(!preg_match($userRegex, $username)) {
            $nizGresaka[] = "Greška username";
        }

        if(!preg_match($passRegex, $password)) {
            $nizGresaka[] = "Greška password";
        }

        if(!preg_match($emailRegex, $email)) {
            $nizGresaka[] = "Greška email";
        }

        //provera da li već postoje user i email

        $isExistsUser = proveraUser($username);
        $isExistsEmail = proveraEmail($email);

        if($isExistsUser) {
            $nizGresaka[] = "Username već postoji u bazi.";
        }

        if($isExistsEmail) {
            $nizGresaka[] = "Email već postoji u bazi.";
        }
        
        if(count($nizGresaka) == 0) {

            registracija($username, md5($password), $email);

            $response = ["poruka" => "Uspešna registracija"];
            $statusniKod = 200;
    
        } else {
            $response = ["poruka" => $nizGresaka];
            $statusniKod = 422;
        }

        echo json_encode($response);
        http_response_code($statusniKod);
    }
    else{
        http_response_code(404);
    }

?>