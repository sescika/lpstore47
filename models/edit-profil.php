<?php
    session_start();
    header("Content-type: application/json");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "utilities.php";
        include "../config/connection.php";
        include "functions.php";

        $userId = $_POST['userId'];
        $slikaId = $_POST['idSlike'];

        $nizGresaka = [];
        $odgovor = "";
        $statusniKod = "";
 
        if(isset($_FILES['slika'])) {

            $fajl = $_FILES['slika'];

            $nazivFajla = $fajl['name'];
            $tmpFajl = $fajl['tmp_name'];
            $velicinaFajla = $fajl['size'];
            $tipFajla = $fajl['type'];
            $greskeFajl = $fajl['error'];
    
            $dozvoljeniTipovi = ["image/png", "image/jpeg", "image/jpg"];

            if(!in_array($tipFajla, $dozvoljeniTipovi)){
                $nizGresaka[] = "Greška prilikom upload-a fajla. Dozvoljeni tipovi: jpg, jpeg, png.";
            }
    
            if($velicinaFajla > 400000){
                $nizGresaka[] = "Greška prilikom upload-a fajla. Dozvoljeno je ....KB, MB";
            }
    

            $noviNazivFajla = time(). "_" . $_SESSION['korisnik']->username . "_pfp_" .$nazivFajla;
            $putanja = "../uploads/" . $noviNazivFajla;

            $profil = dohvatiProfil($userId);

            if($slikaId != "1") {
                unlink($profil->file_location);
            }

            if(move_uploaded_file($tmpFajl, $putanja)){
                unosProfilneSlike($putanja, $noviNazivFajla);
                $slika = dohvatiUploadovanuPfp();
                $slika = $slika->userFileId;
                $edit = editProfila($userId, $slika);
            } 
                
            if($edit) {
                $profil = dohvatiProfil($userId);

                $response = [
                        "profil" => $profil,
                        "poruka" => "Uspešno promenjena slika." 
                ];
                $statusniKod = 200;

            } else {
                $response = ["poruka" => "Greška prilikom editovanja profila."];
                $statusniKod = 500;
            }
        }
        else{
            $response = ["poruka" => "Greska."];
            $statusniKod = 422;
        }
        
        echo json_encode($response);
        http_response_code($statusniKod);
        
    }
    else{
        http_response_code(404);
    }
?>
