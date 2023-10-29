<?php

if (!isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivRole != "admin") {
    redirect("404.php");
    die;
}

?>
<div class="container-fluid  my-3 fakeHeight">
    <div class="row">
        <div class="col-12">
            <?php include "views/fixed/nav-admin.php"; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Statistika:</h2>
            <p class='text-center'>(prikaz oduvek %)</p>
            <?= prikazStatistike(1); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Statistika (pristup po stranicama):</h2>
            <p class='text-center'>(prikaz poslednja 24h)</p>
            <?= prikazStatistikeKlikNaStranice(1); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Ulogovani korisnici:</h2>
            <p class='text-center'>(prikaz poslednja 24h)</p>
            <?= prikazUlogovanihKorisnika(1); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <h2 class='text-center'>Log fajl:</h2>
        <p class='text-center'>(prikaz poslednja 24h)</p>
            <table class="table table-striped d-block d-lg-table border overflow-x-auto ">
                <thead class="table-header text-light bg-dark">
                    <tr>
                        <th>Korisnik</th>
                        <th>Stranica</th>
                        <th>Akcija (uspeh)</th>
                        <th>Datum</th>
                        <th>Ip Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?= prikazLogFajla(1, "view") ?>
                </tbody>
            </table>
        </div>
    </div>
</div>