<?php

if (!isset($_SESSION['korisnik'])) {
    redirect("404.php");
    die;
}


function ispisDDL($ddlId)
{
    global $conn;
    $upit = "SELECT * FROM proizvodjaci";

    $rez = $conn->query($upit);

    $html = "<select name='" . $ddlId . "'id='" . $ddlId . "' class='form-select'>
                            <option value='0'>Izaberite proizvođača</option>";

    foreach ($rez as $r) {
        $html .= "<option value='" . $r->proizvodjacId . "'>" . $r->nazivProizvodjac . "</option>";
    }

    $html .= "</select>";

    return $html;
}

?>

<section>
    <div id="contact" class="container-fluid wrapper my-5 fakeHeight">
        <div class="row">
            <div class="col-12">
                <p id="kontaktPoruke"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 rounded bg-secondary-subtle mb-3 mb-lg-0">
                <div id="contactinfo" class="p-4">
                    <h3>Dobrodošli na stranicu za slanje tiketa. (Morate biti ulogovani)</h3>
                    <hr />
                    <p class='ms-3'>Ovo je stranica gde možete poslati informacije o Vašem uređaju.</p>
                    <hr />
                </div>
            </div>
            <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
                <div id="forma" class=" p-4 bg-dark rounded text-light w-100">
                    <h3>Forma za prijavu</h3>
                    <form id="formaKontakt" name="formaKontakt" action="logic/obrada-kontakt.php" method="post">

                        <div class="form-group">
                            <label class="form-label" for="tbUserEmail">Email:</label>
                            <?php
                            if (isset($_SESSION['korisnik'])) :
                                $emailUlogovanogKorisnika = $_SESSION['korisnik']->email;

                            ?>
                                <input class='form-control' type="text" name="tbUserEmail" id="tbUserEmail" value="<?= $emailUlogovanogKorisnika ?>" />

                            <?php
                            elseif (!isset($_SESSION['korisnik'])) :
                            ?>
                                <input class='form-control' type="text" name="tbUserEmail" id="tbUserEmail" placeholder="email" />
                            <?php

                            endif;
                            ?>
                        </div>
                        <span id="tbEmailError"></span>
                        <div class="form-group" id="ddlProizvodjaciDiv">
                            <label class="form-label" for="ddlProizvodjaci">Proizvodjač laptopa:</label>
                            <?= ispisDDL("ddlProizvodjaci"); ?>
                        </div>
                        <span id="ddlProizvodjaciError"></span>

                        <div class="form-group">
                            <label for="taOpis">Opis: </label>
                            <textarea rows="15" class="form-control" placeholder="Opis problema..." name="taOpis" id="taOpis"></textarea>
                        </div>
                        <span id="taError"></span>


                        <div class="d-flex justify-content-center mt-4">
                            <input class="btn btn-success" type="submit" value="Pošaljite" name="btnSubmitKontakt" id="btnSubmitKontakt" />
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>