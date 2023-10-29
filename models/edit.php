<?php
    session_start();
    header("Content-type: application/json");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "utilities.php";
        include "../config/connection.php";
        include "functions.php";

        $proizvodId = $_POST['proizvodId'];
        $nazivProizvoda = $_POST['nazivProizvoda'];
        $proizvodjacId = $_POST['proizvodjacId'];
        $cenaProizvoda = $_POST['cenaProizvoda'];
        $graficka = $_POST['grafickaId'];
        $procesor = $_POST['procesorId'];
        $storage = $_POST['storage'];
        $dijagonala = $_POST['dijagonala'];

        $nizGresaka = [];
        $odgovor = "";
        $statusniKod = "";

        if(count($nizGresaka) == 0){
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
        

                $noviNazivFajla = time(). "_" . $_SESSION['korisnik']->username . "_" .$nazivFajla;
                $putanja = "../uploads/" . $noviNazivFajla;

                $proizvod = dohvatiProizvod($proizvodId);
                // unlink($proizvod->lokacija);


                if(move_uploaded_file($tmpFajl, $putanja)){
                    unosSlike($putanja, $noviNazivFajla);
                    $slika = dohvatiUploadovanuSliku();
                    $slika = $slika->slikaId;
                    $edit = 
                    editProizvoda($proizvodId, $proizvodjacId, $nazivProizvoda, $cenaProizvoda, $procesor, $graficka, $storage, $dijagonala, $slika);
                } 
                
            } else {
                $edit = editProizvoda($proizvodId, $proizvodjacId, $nazivProizvoda, $cenaProizvoda, $procesor, $graficka, $storage, $dijagonala);
            }

            if($edit) {
                $proizvod = dohvatiProizvod($proizvodId);
                $proizvodjaci = dohvatiSvePodatke("proizvodjaci");
                $graficke = dohvatiSvePodatke("graficke_specifikacije");
                $procesori = dohvatiSvePodatke("procesor_specifikacije");

                $response = [
                        "poruka" => "Uspešno izmenjen proizvod",
                        "proizvod" => $proizvod, 
                        "proizvodjaci" => $proizvodjaci,
                        "graficke" => $graficke,
                        "procesori" => $procesori
                ];
                $statusniKod = 200;

            } else {
                $response = ["poruka" => "Greška prilikom editovanja proizvoda."];
                $statusniKod = 500;
            }
        }
        else{
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
