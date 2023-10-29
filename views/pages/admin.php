<?php
if (!isset($_SESSION['korisnik']) && !($_SESSION['korisnik']->roleId == 2)) {
    redirect("404.php");
    die;
}
?>


<div class="container-fluid  my-3 fakeHeight">
    <div class="row">
        <div class="col-12">
            <div id="zaPoruke">
            </div>

            <?php include "views/fixed/nav-admin.php"; ?>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="tabelaProizvoda">

            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" id="modalClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p class='text-center' id="modalNotification"></p>
            <div class="modal-body">

                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeButton" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sacuvajPromene">Save changes</button>
            </div>
        </div>
    </div>
</div>