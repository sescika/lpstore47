<div class='container-fluid my-3 wrapper fakeHeight'>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div id='searchBar'>
                <div class="input-group mb-3">
                    <input type="text" id='tbSearchProizvod' name='tbSearchProizvod' class="form-control" placeholder="Pretraga" aria-label="Pretraga" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button id='btnSearchProizvodi' class="btn btn-outline-secondary" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pagination" class="col-12 col-lg-6">
            <?php
            $poStranici = 6;
            $brojStranica = brojStranicaPaginacija($poStranici);
            for ($i = 1; $i <= $brojStranica; $i++) :
            ?>
                <button class="btn btn-primary btnPaginacija" data-strana="<?= $i; ?>"><?= $i; ?></button>
            <?php
            endfor;
            ?>

        </div>
    </div>
    <div class='row'>
        <div class="col-12 col-lg-2">
            <div id="filteriP">
            </div>
        </div>
        <div class="col-12 col-lg-10">
            <div class="container" id="proizvodiP">

            </div>
        </div>
    </div>
</div>

<div class="position-relative">
    <div class="position-fixed bottom-0 rounded end-0" id="liveAlertPlaceholder"></div>
</div>