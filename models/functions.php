<?php

function registracija($username, $password, $email)
{
    global $conn;

    $upit = "INSERT INTO users(username, password, email) VALUES(:username, :password, :email)";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":username", $username);
    $iskaz->bindParam(":password", $password);
    $iskaz->bindParam(":email", $email);

    $rez = $iskaz->execute();

    return $rez;
}

function proveraUser($username)
{
    global $conn;

    $upit = "SELECT username FROM users WHERE username = :username";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":username", $username);

    $iskaz->execute();

    $rez = $iskaz->fetchAll();
    return $rez;
}

function proveraEmail($email)
{
    global $conn;

    $upit = "SELECT email FROM users WHERE email = :email";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":email", $email);

    $iskaz->execute();

    $rez = $iskaz->fetchAll();

    return $rez;
}

function logovanje($username, $password)
{

    global $conn;

    $upit = "SELECT * FROM users u JOIN roles r 
                 ON u.roleId = r.roleId 
                 WHERE u.username = :username AND u.password = :pass";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":username", $username);
    $iskaz->bindParam(":pass", $password);

    $iskaz->execute();

    $rez = $iskaz->fetch();

    return $rez;
}

function updateLastLoginUser($id)
{
    global $conn;

    $upit = "UPDATE users SET poslednjeLogovanje = CURRENT_TIMESTAMP WHERE id = :id";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":id", $id);

    $rez = $iskaz->execute();

    return $rez;
}

function ispisNavMenija()
{
    global $conn;

    $upit1 = "SELECT * FROM navigacija WHERE nivoPristupa IN('1') ORDER BY redosled";
    $upit2 = "SELECT * FROM navigacija WHERE nivoPristupa IN('1', '2') ORDER BY redosled";
    $upit3 = "SELECT * FROM navigacija WHERE nivoPristupa IN('1', '2', '3') ORDER BY redosled";

    //ispis

    $html = "<ul class='navbar-nav ms-auto'>";

    if (!isset($_SESSION['korisnik'])) {
        $iskaz = $conn->prepare($upit1);
        $iskaz->execute();
        $rez = $iskaz->fetchAll();

        foreach ($rez as $r) {
            $html .= "<li class='nav-link'>
                                <a href='?page=" . $r->nav_page . "' class='nav-link'>" . $r->naziv . "</a>
                            </li>";
        }
    } else if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->roleId == 1) {
        $iskaz = $conn->prepare($upit2);
        $iskaz->execute();
        $rez = $iskaz->fetchAll();

        foreach ($rez as $r) {
            if ($r->naziv == "Logovanje") {
                continue;
            }
            if ($r->naziv == "Profil") {
                $html .= "<li class='nav-link'>
                        <a href='?page=" . $r->nav_page . "&id=" . $_SESSION['korisnik']->id . "' class='nav-link text-success'>" . $_SESSION['korisnik']->username . "(" . $_SESSION['korisnik']->nazivRole . ")" . "</a>
                        </li>";
            } else {
                $html .= "<li class='nav-link'>
                        <a href='?page=" . $r->nav_page . "' class='nav-link'>" . $r->naziv . "</a>
                                </li>";
            }
        }
    } else if (isset($_SESSION['korisnik']) && $_SESSION['korisnik']->roleId == 2) {

        $iskaz = $conn->prepare($upit3);
        $iskaz->execute();
        $rez = $iskaz->fetchAll();

        foreach ($rez as $r) {
            if ($r->naziv == "Logovanje") {
                continue;
            }
            if ($r->naziv == "Profil") {
                $html .= "<li class='nav-link'>
                        <a href='?page=" . $r->nav_page . "&id=" . $_SESSION['korisnik']->id . "' class='nav-link text-danger'>" . $_SESSION['korisnik']->username . "(" . $_SESSION['korisnik']->nazivRole . ")" . "</a>
                        </li>";
            } else {
                $html .= "<li class='nav-link'>
                        <a href='?page=" . $r->nav_page . "' class='nav-link'>" . $r->naziv . "</a>
                                </li>";
            }
        }
    }


    $html .= "</ul>";

    return $html;
}

function dohvatiSvePodatke($nazivTabele)
{
    global $conn;

    $upit = "SELECT * FROM $nazivTabele";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();
    $rezultat = $iskaz->fetchAll();

    return $rezultat;
}

function unosProizvoda($proizvodjacId, $nazivProizvod, $trenutnaCena, $procesorId, $grafickaId, $storage, $dijagonala, $imgId)
{
    global $conn;

    $upit = "INSERT INTO proizvodi(proizvodjacId, nazivProizvod, trenutnaCena, procesorId, grafickaId, ssd, dijagonala, slikaId)
                 VALUES(:proizvodjacId, :nazivProizvod, :cena, :procesorId, :grafickaId, :ssd, :dijagonala, :slikaId)";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":proizvodjacId", $proizvodjacId);
    $iskaz->bindParam(":nazivProizvod", $nazivProizvod);
    $iskaz->bindParam(":cena", $trenutnaCena);
    $iskaz->bindParam(":procesorId", $procesorId);
    $iskaz->bindParam(":grafickaId", $grafickaId);
    $iskaz->bindParam(":ssd", $storage);
    $iskaz->bindParam(":dijagonala", $dijagonala);
    $iskaz->bindParam(":slikaId", $imgId);

    $rez = $iskaz->execute();

    return $rez;
}

function dohvatiUploadovanuSliku()
{
    global $conn;

    $upit = "SELECT slikaId FROM slike
                 WHERE slikaId =    (
                 SELECT MAX(slikaId) FROM slike)";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();;

    $rez = $iskaz->fetch();

    return $rez;
}

function unosSlike($putanaja, $naziv)
{
    global $conn;

    $upit = "INSERT INTO slike(nazivSlika, lokacija) VALUES(:naziv, :lokacija)";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":naziv", $naziv);
    $iskaz->bindParam(":lokacija", $putanaja);

    $rez = $iskaz->execute();

    return $rez;
}

function dohvatiProizvod($id)
{
    global $conn;
    $upit = "SELECT * FROM proizvodi p 
        JOIN slike s ON p.slikaId = s.slikaId
        JOIN proizvodjaci pr ON p.proizvodjacId = pr.proizvodjacId
        JOIN procesor_specifikacije ps ON p.procesorId = ps.procesoriSpecifikacijeId
        JOIN graficke_specifikacije gs ON p.grafickaId = gs.grafickeSpecifikacijaId
        WHERE p.proizvodId = :id";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":id", $id);
    $iskaz->execute();
    $rezultat = $iskaz->fetch();

    return $rezultat;
}

function dohvatiSveProizvode()
{
    global $conn;


    $upit = "SELECT * FROM proizvodi p 
        JOIN slike s ON p.slikaId = s.slikaId
        JOIN proizvodjaci pr ON p.proizvodjacId = pr.proizvodjacId
        JOIN procesor_specifikacije ps ON p.procesorId = ps.procesoriSpecifikacijeId
        JOIN graficke_specifikacije gs ON p.grafickaId = gs.grafickeSpecifikacijaId
        ORDER BY p.proizvodId ";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();
    $rezultat = $iskaz->fetchAll();

    return $rezultat;
}
function dohvatiSveProizvodePaginacija($stranica)
{
    global $conn;
    $perPage = 6;
    $firstPage = ($stranica - 1) * $perPage;

    $upit = "SELECT * FROM proizvodi p 
        JOIN slike s ON p.slikaId = s.slikaId
        JOIN proizvodjaci pr ON p.proizvodjacId = pr.proizvodjacId
        JOIN procesor_specifikacije ps ON p.procesorId = ps.procesoriSpecifikacijeId
        JOIN graficke_specifikacije gs ON p.grafickaId = gs.grafickeSpecifikacijaId
        ORDER BY p.proizvodId
        LIMIT $firstPage, $perPage";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();
    $rezultat = $iskaz->fetchAll();

    return $rezultat;
}

function brojStranicaPaginacija($poStranici)
{
    global $conn;

    $upit = "SELECT * FROM proizvodi";
    $iskaz = $conn->prepare($upit);
    $iskaz->execute();
    $rezultat = $iskaz->fetchAll();

    return ceil(count($rezultat) / $poStranici);
}

function dohvatiSlikuId($id)
{
    global $conn;

    $upit = "SELECT p.slikaId FROM proizvodi p
                 JOIN slike s ON p.slikaId = s.slikaId
                 WHERE p.proizvodId = :proizvodId";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":proizvodId", $id);
    $iskaz->execute();

    $rez = $iskaz->fetchAll();

    return $rez;
}

function dohvatiUploadovanuPfp()
{
    global $conn;

    $upit = "SELECT userFileId FROM user_files
                 WHERE userFileId =    (
                 SELECT MAX(userFileId) FROM user_files)";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();;

    $rez = $iskaz->fetch();

    return $rez;
}

function editProizvoda($proizvodId, $proizvodjacId, $nazivProizvod, $trenutnaCena, $procesorId, $grafickaId, $storage, $dijagonala, $imgId = 0)
{
    global $conn;
    $upit = "UPDATE proizvodi SET proizvodjacId = :proizvodjacId, nazivProizvod = :nazivProizvod, trenutnaCena = :trenutnaCena, procesorId = :procesorId, grafickaId = :grafickaId, ssd = :ssd, dijagonala = :dijagonala";
    if ($imgId != 0) {
        $upit .= ", slikaId = :slikaId ";
    } else {
        $slika = dohvatiSlikuId($proizvodId);
        $slika = $slika[0]->slikaId;
        $upit .= ", slikaId = $slika ";
    }

    $upit .= " WHERE proizvodId = $proizvodId";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":proizvodjacId", $proizvodjacId);
    $iskaz->bindParam(":nazivProizvod", $nazivProizvod);
    $iskaz->bindParam(":trenutnaCena", $trenutnaCena);
    $iskaz->bindParam(":procesorId", $procesorId);
    $iskaz->bindParam(":grafickaId", $grafickaId);
    $iskaz->bindParam(":ssd", $storage);
    $iskaz->bindParam(":dijagonala", $dijagonala);
    if ($imgId != 0) {
        $iskaz->bindParam("slikaId", $imgId);
    }

    $rez = $iskaz->execute();

    return $rez;
}

function unosTiketa($korisnikId, $opisProblema, $proizvodjacLaptopa)
{
    global $conn;

    $upit = "INSERT INTO tiketi(korisnikId, opisProblema, proizvodjacLaptopa, datumSlanjaTiketa) VALUES(:korisnikId, :opisProblema, :proizvodjacLaptopa, CURRENT_TIMESTAMP)";

    $iskaz = $conn->prepare($upit);

    $iskaz->bindParam(":korisnikId", $korisnikId);
    $iskaz->bindParam(":opisProblema", $opisProblema);
    $iskaz->bindParam(":proizvodjacLaptopa", $proizvodjacLaptopa);

    $rezultat = $iskaz->execute();

    return $rezultat;
}

function dohvatiProfil($id)
{
    global $conn;

    $upit = "SELECT * FROM users u
                 JOIN user_files uf ON u.profileImgId = uf.userFileId
                 JOIN roles r ON u.roleId = r.roleId
                 WHERE u.id = :id";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":id", $id);
    $iskaz->execute();

    $rez = $iskaz->fetch();

    return $rez;
}

function obrisiProizvod($id)
{
    global $conn;

    $upit = 'DELETE FROM proizvodi WHERE proizvodId = :id';

    $iskaz = $conn->prepare($upit);

    $iskaz->bindParam(":id", $id);

    $rez = $iskaz->execute();

    return $rez;
}

function obrisiTiket($id)
{
    global $conn;

    $upit = 'DELETE FROM proizvodi WHERE proizvodId = :id';

    $iskaz = $conn->prepare($upit);

    $iskaz->bindParam(":id", $id);

    $rez = $iskaz->execute();

    return $rez;
}

function editProfila($id, $imgId)
{
    global $conn;

    $upit = "UPDATE users SET profileImgId = :imgId WHERE id = :id";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":imgId", $imgId);
    $iskaz->bindParam(":id", $id);

    $rez = $iskaz->execute();

    return $rez;
}

function unosProfilneSlike($putanaja, $naziv)
{
    global $conn;

    $upit = "INSERT INTO user_files(file_location, file_name) VALUES(:putanja, :naziv)";

    $iskaz = $conn->prepare($upit);
    $iskaz->bindParam(":putanja", $putanaja);
    $iskaz->bindParam(":naziv", $naziv);

    $rez = $iskaz->execute();

    return $rez;
}

function searchProizvode($nazivProizvod)
{
    global $conn;

    $upit = "SELECT * FROM proizvodi p 
        JOIN slike s ON p.slikaId = s.slikaId
        JOIN proizvodjaci pr ON p.proizvodjacId = pr.proizvodjacId
        JOIN procesor_specifikacije ps ON p.procesorId = ps.procesoriSpecifikacijeId
        JOIN graficke_specifikacije gs ON p.grafickaId = gs.grafickeSpecifikacijaId
        WHERE LOWER(p.nazivProizvod) LIKE LOWER('%" . $nazivProizvod . "%')";


    $iskaz = $conn->prepare($upit);

    $iskaz->execute();

    $rezultat = $iskaz->fetchAll();

    return $rezultat;
}

function upisLogFajl($akcija, $uspeh = 0)
{

    if (isset($_SESSION['korisnik'])) {
        $korisnik = $_SESSION['korisnik']->username;
    } else {
        $korisnik = "null";
    }

    $stranica = $_GET['page'];
    $datumVreme = time();
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($akcija == "view") {

        $formatZaUpis = $datumVreme . "__" . $ip . "__" . $stranica . "__" . $akcija . "__" . $korisnik . "__" . "1" . "\n";

        $fajl = fopen("data/log.txt", 'a');
        $upis = fwrite($fajl, $formatZaUpis);

        if ($upis) {
            $zatvaranje = fclose($fajl);
            if ($zatvaranje) {
                return true;
            }
        }
    }

    if ($akcija = "login") {
        $stranica = "login";
        $formatZaUpisl = $datumVreme . "__" . $ip . "__" . $stranica . "__" . $akcija . "__" . $korisnik . "__" . $uspeh .  "\n";

        $fajl = fopen("../data/log.txt", 'a');
        $upis = fwrite($fajl, $formatZaUpisl);

        if ($upis) {
            $zatvaranje = fclose($fajl);
            if ($zatvaranje) {
                return true;
            }
        }
    }

    if ($akcija = "logout") {
        $stranica = "logout";
        $formatZaUpisl = $datumVreme . "__" . $ip . "__" . $stranica . "__" . $akcija . "__" . $korisnik . "__" . $uspeh .  "\n";

        $fajl = fopen("../../data/log.txt", 'a');
        $upis = fwrite($fajl, $formatZaUpisl);

        if ($upis) {
            $zatvaranje = fclose($fajl);
            if ($zatvaranje) {
                return true;
            }
        }
    }
}

function prikazLogFajla($poslednjihXSati)
{
    $logFajl = fopen("data/log.txt", "r");
    $podaciIzFajla = fread($logFajl, filesize("data/log.txt"));
    $podaciIzFajla = trim($podaciIzFajla);
    $niz = explode("\n", $podaciIzFajla);

    $now = time();
    $past = strtotime("-$poslednjihXSati day");

    $html = "";
    foreach ($niz as $value) {
        list($datum, $ipAdd, $page, $akcija, $user, $uspeh) = explode("__", $value);
        if ($datum >= $past && $datum <= $now) {
            $html .= "<tr>
                    <td>" . $user . "</td>
                    <td>" . $page . "</td>
                    <td>" . $akcija . "(" . $uspeh . ")" . "</td>
                    <td>" . date("D, d.m.Y. H:i:s", $datum) . "</td>
                    <td>" .  $ipAdd . "</td>
                </tr>";
        }
    }

    return $html;
}

function prikazUlogovanihKorisnika($poslednjihXSati)
{
    $logFajl = fopen("data/log.txt", "r");
    $podaciIzFajla = fread($logFajl, filesize("data/log.txt"));
    $podaciIzFajla = trim($podaciIzFajla);
    $niz = explode("\n", $podaciIzFajla);

    $now = time();
    $past = strtotime("-$poslednjihXSati day");

    $html = "<table class='table table-striped d-block d-lg-table border overflow-x-auto'>
    <thead class='table-header text-light bg-dark'>
        <tr>
            <th>Korisnik</th>
            <th>Akcija</th>
            <th>Vreme</th>
            <th>Ip</th>
        </tr>
    </thead>
    <tbody>";

    foreach ($niz as $value) {
        list($datum, $ipAdd, $page, $akcija, $user, $uspeh) = explode("__", $value);
        if ($datum >= $past && $datum <= $now && $akcija == "login") {
            $html .= "<tr>
                    <td>" . $user . "</td>
                    <td>" . $akcija . "(" . $uspeh . ")" . "</td>
                    <td>" . date("D, d.m.Y. H:i:s", $datum) . "</td>
                    <td>" .  $ipAdd . "</td>
                </tr>";
        }
    }

    $html .= "</tbody></table>";

    return $html;
}

function prikazStatistike()
{
    $logFajl = fopen("data/log.txt", "r");
    $podaciIzFajla = fread($logFajl, filesize("data/log.txt"));
    $podaciIzFajla = trim($podaciIzFajla);
    $niz = explode("\n", $podaciIzFajla);

    $brHome = 0;
    $brProizvodi = 0;
    $brRegistracija = 0;
    $brKontakt = 0;
    $brAutor = 0;
    $brLogin = 0;
    $brKorpa = 0;
    $brProfil = 0;
    $brOstaleStranice = 0;
    $brUkupno = 0;
    

    foreach ($niz as $n) {
        list($datum, $ipAdd, $page, $akcija, $user, $uspeh) = explode("__", $n);
        $brUkupno++;
        if ($page == "home") {
            $brHome++;
        } else if ($page == "proizvodi") {
            $brProizvodi++;
        } else if ($page == "registracija") {
            $brRegistracija++;
        } else if ($page == "kontakt") {
            $brKontakt++;
        } else if ($page == "autor") {
            $brAutor++;
        } else if ($page == "profil") {
            $brProfil++;
        } else if ($page == "login") {
            $brLogin++;
        } else if ($page == "korpa") {
            $brKorpa++;
        } else {
            $brOstaleStranice++;
        }
    }


    //$brukupno - $ostale

    $percHome = round(($brHome / ($brUkupno - $brOstaleStranice)) * 100);
    $percProizvodi = round(($brProizvodi / ($brUkupno - $brOstaleStranice)) * 100);
    $percRegistracija = round(($brRegistracija / ($brUkupno - $brOstaleStranice)) * 100);
    $percLogin = round(($brLogin / ($brUkupno - $brOstaleStranice)) * 100);
    $percKontakt = round(($brKontakt / ($brUkupno - $brOstaleStranice)) * 100);
    $percAutor = round(($brAutor / ($brUkupno - $brOstaleStranice)) * 100);
    $percProfil = round(($brProfil / ($brUkupno - $brOstaleStranice)) * 100);
    $percKorpa = round(($brKorpa / ($brUkupno - $brOstaleStranice)) * 100);



    $html = "
    <table class='table table-striped d-block d-lg-table border overflow-x-auto'>
        <thead class='table-header text-light bg-dark'>
            <tr>
                <th>Home</th>
                <th>Proizvodi</th>
                <th>Registracja</th>
                <th>Kontakt</th>
                <th>Profil</th>
                <th>Autor</th>
                <th>Login</th>
                <th>Korpa</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>$percHome %</td>
                <td>$percProizvodi %</td>
                <td>$percRegistracija %</td>
                <td>$percKontakt %</td>
                <td>$percProfil %</td>
                <td>$percAutor %</td>
                <td>$percLogin %</td>
                <td>$percKorpa %</td>
            </tr>
        </tbody>
    </table>";

    return $html;
}

function prikazStatistikeKlikNaStranice($poslednjihXSati) {

    $now = time();
    $past = strtotime("-$poslednjihXSati day");

    $logFajl = fopen("data/log.txt", "r");
    $podaciIzFajla = fread($logFajl, filesize("data/log.txt"));
    $podaciIzFajla = trim($podaciIzFajla);
    $niz = explode("\n", $podaciIzFajla);

    $brHome = 0;
    $brProizvodi = 0;
    $brRegistracija = 0;
    $brKontakt = 0;
    $brAutor = 0;
    $brLogin = 0;
    $brKorpa = 0;
    $brProfil = 0;
    $brOstaleStranice = 0;
    $brUkupno = 0;

    foreach ($niz as $n) {
        list($datum, $ipAdd, $page, $akcija, $user, $uspeh) = explode("__", $n);
        $brUkupno++;
        if($akcija == "view") {
            if ($page == "home") {
                $brHome++;
            } else if ($page == "proizvodi") {
                $brProizvodi++;
            } else if ($page == "registracija") {
                $brRegistracija++;
            } else if ($page == "kontakt") {
                $brKontakt++;
            } else if ($page == "autor") {
                $brAutor++;
            } else if ($page == "profil") {
                $brProfil++;
            } else if ($page == "login") {
                $brLogin++;
            } else if ($page == "korpa") {
                $brKorpa++;
            } else {
                $brOstaleStranice++;
            }
        }
    }
    $html = "
    <table class='table table-striped d-block d-lg-table border overflow-x-auto'>
        <thead class='table-header text-light bg-dark'>
            <tr>
                <th>Home</th>
                <th>Proizvodi</th>
                <th>Registracja</th>
                <th>Kontakt</th>
                <th>Profil</th>
                <th>Autor</th>
                <th>Login</th>
                <th>Korpa</th>
            </tr>
        </thead>
        <tbody>           
            <tr>
                <td>$brHome</td>
                <td>$brProizvodi</td>
                <td>$brRegistracija</td>
                <td>$brKontakt</td>
                <td>$brProfil</td>
                <td>$brAutor</td>
                <td>$brLogin</td>
                <td>$brKorpa</td>
            </tr>
        </tbody>
    </table>";

    return $html;
}

function filterProizvoda($nizGraficke = [], $nizProcesori = [], $nizProizvodjaci = []) {
    global $conn;

    // var_dump($nizGraficke);
    // var_dump($nizProcesori);
    // var_dump($nizProizvodjaci);

    $upit = "SELECT * FROM proizvodi p 
        JOIN slike s ON p.slikaId = s.slikaId
        JOIN proizvodjaci pr ON p.proizvodjacId = pr.proizvodjacId
        JOIN procesor_specifikacije ps ON p.procesorId = ps.procesoriSpecifikacijeId
        JOIN graficke_specifikacije gs ON p.grafickaId = gs.grafickeSpecifikacijaId
        WHERE ";

    if($nizGraficke != []) {
        if(!str_contains($upit, "IN(")) {
            $upit .= "gs.proizvodjacGrafickeId IN(";
            for($i = 0; $i < count($nizGraficke); $i++) {
                if($i < count($nizGraficke) - 1) {
                    $upit .= $nizGraficke[$i] . ",";
                } else {
                    $upit .= $nizGraficke[$i];
                }
            }
        } else {
            $upit .= " AND gs.proizvodjacGrafickeId IN(";
            for($i = 0; $i < count($nizGraficke); $i++) {
                if($i < count($nizGraficke) - 1) {
                    $upit .= $nizGraficke[$i] . ",";
                } else {
                    $upit .= $nizGraficke[$i];
                }
            }
        }

        $upit .= ")";
    }

    if($nizProcesori != []) {
        if(!str_contains($upit, "IN(")) {
            $upit .= "ps.proizvodjacProcesoraId IN(";
            for($i = 0; $i < count($nizProcesori); $i++) {
                if($i < count($nizProcesori) - 1) {
                    $upit .= $nizProcesori[$i] . ",";
                } else {
                    $upit .= $nizProcesori[$i];
                }
            }
        } else {
            $upit .= " AND ps.proizvodjacProcesoraId IN(";
            for($i = 0; $i < count($nizProcesori); $i++) {
                if($i < count($nizProcesori) - 1) {
                    $upit .= $nizProcesori[$i] . ",";
                } else {
                    $upit .= $nizProcesori[$i];
                }
            }
        }

        $upit .= ")";
    }

    if($nizProizvodjaci != []) {
        if(!str_contains($upit, "IN(")) {
            $upit .= "p.proizvodjacId IN(";
            for($i = 0; $i < count($nizProizvodjaci); $i++) {
                if($i < count($nizProizvodjaci) - 1) {
                    $upit .= $nizProizvodjaci[$i] . ",";
                } else {
                    $upit .= $nizProizvodjaci[$i];
                }
            }
        } else {
            $upit .= " AND p.proizvodjacId IN(";
            for($i = 0; $i < count($nizProizvodjaci); $i++) {
                if($i < count($nizProizvodjaci) - 1) {
                    $upit .= $nizProizvodjaci[$i] . ",";
                } else {
                    $upit .= $nizProizvodjaci[$i];
                }
            }
        }

        $upit .= ")";
    }


    //var_dump($upit);

    $iskaz = $conn->prepare($upit);

    $iskaz->execute();

    $rezultat = $iskaz->fetchAll();

    return $rezultat;
}

function dohvatiPorudzbinaId()
{
    global $conn;

    $upit = "SELECT porudzbinaId FROM porudzbine
             WHERE porudzbinaId =    (
             SELECT MAX(porudzbinaId) FROM porudzbine)";

    $iskaz = $conn->prepare($upit);
    $iskaz->execute();

    $rez = $iskaz->fetch();

    return $rez;
}

function unosPorudzbine($ukupnaCena, $userId, $proizvodiId = [], $kolicina = [])
{
    global $conn;

    $upit = "INSERT INTO porudzbine(ukupnaCena, userId) VALUES(:ukupnaCena, :userId)";
    $conn->beginTransaction();
    $iskaz = $conn->prepare($upit);


    $iskaz->bindParam(":ukupnaCena", $ukupnaCena);
    $iskaz->bindParam(":userId", $userId);

    $iskaz->execute();

    $porudzbinaId = dohvatiPorudzbinaId();
    $porudzbinaId = $porudzbinaId->porudzbinaId;

    $upit2 = "INSERT INTO porudzbine_proizvodi(porudzbinaId, proizvodId, kolicinaProizvoda) VALUES";

    for ($i = 0; $i < count($proizvodiId); $i++) {
        if ($i != count($proizvodiId) - 1) {
            $upit2 .=  "(" . $porudzbinaId . ", " . $proizvodiId[$i] . ", " . $kolicina[$i] . "),";
        } else {
            $upit2 .=  "(" . $porudzbinaId . ", " . $proizvodiId[$i] . ", " . $kolicina[$i] . ")";
        }
    }


    $iskaz2 = $conn->prepare($upit2);
    $iskaz2->execute();

    return $conn->commit();
}

function dovhatiPorudzbine()
{
    global $conn;

    $upit = "SELECT * FROM porudzbine p
             JOIN porudzbine_proizvodi pp ON p.porudzbinaId = pp.porudzbinaId
             JOIN proizvodi pr ON pp.proizvodId = pr.proizvodId
    ";

    $iskaz = $conn->prepare($upit);

    $iskaz->execute();

    $rez = $iskaz->fetchAll();

    return $rez;
}
