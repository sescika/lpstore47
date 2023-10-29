<?php   
        include "../config/connection.php";
        
        if($_SERVER['REQUEST_METHOD'] == "GET") {
                global $conn;
                $upit = "SELECT * FROM tiketi t   
                JOIN status_tiket st ON t.statusId = st.statusId
                JOIN users u ON t.korisnikId = u.id";

                $iskaz = $conn->prepare($upit);
                $iskaz->execute();
                $rezultat = $iskaz->fetchAll();

                header("Content-Type: application/json");
                echo json_encode($rezultat);
        }


?>