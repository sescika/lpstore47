<?php

if (!isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivRole != "admin") {
    redirect("404.php");
    die;
}

?>


<div class="container-fluid my-3 fakeHeight">
    <div class="row">
        <div class="col-12">
            <?php include "views/fixed/nav-admin.php"; ?>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <div id="tabelaPorudzbina">

            </div>
        </div>
    </div>
</div>