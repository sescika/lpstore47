<?php
    session_start();
    header("Content-type: application/json");
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include "utilities.php";
        include "../config/connection.php";
        include "functions.php";

        $nazivProizvoda = $_POST['nazivProizvoda'];
        $proizvodjacId = $_POST['proizvodjacId'];
        $cenaProizvoda = $_POST['cenaProizvoda'];
        $graficka = $_POST['grafickaId'];
        $procesor = $_POST['procesorId'];
        $storage = $_POST['storage'];
        $dijagonala = $_POST['dijagonala'];
        $fajl = $_FILES['slika'];

        $nazivFajla = $fajl['name'];
        $tmpFajl = $fajl['tmp_name'];
        $velicinaFajla = $fajl['size'];
        $tipFajla = $fajl['type'];
        $greskeFajl = $fajl['error'];

        $nizGresaka = [];
        $odgovor = "";
        $statusniKod = "";
    


        $dozvoljeniTipovi = ["image/png", "image/jpeg", "image/jpg"];

        if(!in_array($tipFajla, $dozvoljeniTipovi)){
            $nizGresaka[] = "Greška prilikom upload-a fajla. Dozvoljeni tipovi: jpg, jpeg, png.";
        }

        if($velicinaFajla > 400000){
            $nizGresaka[] = "Greška prilikom upload-a fajla. Dozvoljeno je ....KB, MB";
        }


        if(count($nizGresaka) == 0){
            $noviNazivFajla = time(). "_" . $_SESSION['korisnik']->username . "_" .$nazivFajla;
            $putanja = "../uploads/" . $noviNazivFajla;

            if(move_uploaded_file($tmpFajl, $putanja)){
                
                $unosSlike = unosSlike($putanja, $noviNazivFajla);

                if($unosSlike) {

                    $idUploadovaneSlike = dohvatiUploadovanuSliku();
        
                    $unosProizvoda = unosProizvoda($proizvodjacId, $nazivProizvoda, $cenaProizvoda, $procesor, $graficka, $storage, $dijagonala, $idUploadovaneSlike->slikaId);

                    if($unosProizvoda){
                        $odgovor = ["poruka" => "Uspešno unet proizvod  ."];
                        $statusniKod = 201;
                    }
                    else{
                        $odgovor = ["poruka" => "Greška prilikom unosa."];
                        $statusniKod = 500;
                    }
                } else {
                    $odgovor = ["poruka" => "Greška prilikom uploadovanja slike."];
                    $statusniKod = 500;
                }
            }
        }
        else{
            $odgovor = ["poruka" => $nizGresaka];
            $statusniKod = 422;
        }
        
        echo json_encode($odgovor);
        http_response_code($statusniKod);
        
    }
    else{
        http_response_code(404);
    }
?>
