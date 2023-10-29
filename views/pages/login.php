<section>
    <div id="login" class="container-fluid wrapper my-5 fakeHeight">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <?php
                if (isset($_SESSION['greska-logovanje'])) :
                ?>
                    <p class="alert alert-danger"><?= $_SESSION['greska-logovanje']; ?></p>
                <?php
                    unset($_SESSION['greska-logovanje']);
                endif;
                ?>
                <?php
                if (isset($_SESSION['vec-ulogovan'])) :
                ?>
                    <p class="alert alert-danger"><?= $_SESSION['vec-ulogovan']; ?></p>
                <?php
                    unset($_SESSION['vec-ulogovan']);
                endif;
                ?>
                <div id="formaLogin" class=" p-4 bg-dark rounded text-light ">
                    <h3>Logovanje:</h3>
                    <form action="models/logovanje.php" method="post">
                        <div class="form-group">
                            <label class="form-label" for="tbUserL">Korisničko ime:</label>
                            <input class='form-control' type="text" name="tbUserL" id="tbUserL" />
                        </div>
                        <span id="tbUserErrorL"></span>

                        <div class="form-group">
                            <label class="form-label" for="tbPasswordL">Lozinka:</label>
                            <input class='form-control' type="password" name="tbPasswordL" id="tbPasswordL" />
                        </div>
                        <span id="tbPasswordError:"></span>

                        <div class="d-flex justify-content-center mt-4">
                            <input class="btn btn-success" type="submit" name="btnLogovanje" value="Log in" id="btnLogovanje" />
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>