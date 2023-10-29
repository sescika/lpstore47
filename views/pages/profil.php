<?php
if (!isset($_SESSION['korisnik'])) {
    redirect("404.php");
    die;
}
?>
<div id="prikazProfila" class="wrapper fakeHeight my-3 p-3">
    <div class="container-fluid">
        <div class="row">
            <div id="alertsProfil"></div>
        </div>
        <div class="row">

            <div class="col-12">
                <div id="prikazProfil" class="border rounded ">

                </div>
            </div>
        </div>
    </div>
</div>