<?php

if (!isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivRole != "admin") {
    redirect("404.php");
    die;
}

$proizvodjaci = dohvatiSvePodatke("proizvodjaci");
$procesori = dohvatiSvePodatke("procesor_specifikacije");
$proizvodjaciProcesori = dohvatiSvePodatke("procesor_proizvodjaci");
$graficke = dohvatiSvePodatke("graficke_specifikacije");
$proizvodjaciGraficke = dohvatiSvePodatke("graficke_proizvodjaci");
?>
<div class="container-fluid my-3 fakeHeight">
    <div class="row">
        <div class="col-12">
            <?php include "views/fixed/nav-admin.php"; ?>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <p id="unosProizvodaPoruka"></p>
            <div id="formaUnos">
                <form id="formaUnosProizvoda">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tbNaziv">Naziv proizvoda:</label>
                                    <input type="text" name="tbNaziv" id="tbNaziv" class="form-control" />
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="ddlProizvodjaci">Proizvodjač:</label>
                                    <select name="ddlProizvodjaci" id="ddlProizvodjaci" class="form-select">
                                        <option value="0">Izaberite</option>
                                        <?php
                                        foreach ($proizvodjaci as $pr) :
                                        ?>
                                            <option value="<?= $pr->proizvodjacId ?>"><?= $pr->nazivProizvodjac ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tbCena">Cena proizvoda:</label>
                                    <input type="number" name="tbCena" id="tbCena" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="slika">Slika:</label>
                                    <input type="file" name="slika" id="slika" class="form-control" />
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="ddlNazivGraficke">Grafička:</label>
                                    <select name="ddlNazivGraficke" id="ddlNazivGraficke" class="form-select">
                                        <option value="0">Izaberite</option>
                                        <?php
                                        foreach ($graficke as $pr) :
                                        ?>
                                            <option value="<?= $pr->grafickeSpecifikacijaId ?>"><?= $pr->nazivGraficke ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="ddlNazivProcesora">Procesor:</label>
                                    <select name="ddlNazivProcesora" id="ddlNazivProcesora" class="form-select">
                                        <option value="0">Izaberite</option>
                                        <?php
                                        foreach ($procesori as $pr) :
                                        ?>
                                            <option value="<?= $pr->procesoriSpecifikacijeId ?>"><?= $pr->nazivProcesora ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tbStorage">Storage (GB):</label>
                                    <input class="form-control" type="number" name="tbStorage" id="tbStorage" />
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tbDijagonala">Dijagonala:</label>
                                    <input class="form-control" type="number" name="tbDijagonala" id="tbDijagonala" step="0.01" />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success form-control p-2" name="unosProizvoda" id="unosProizvoda">Unos proizvoda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>