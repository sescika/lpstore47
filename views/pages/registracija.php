<section>
    <div id="registracija" class="container-fluid wrapper my-5 fakeHeight">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <p id="registracijaPoruke"></p>
                <div id="forma" class=" p-4 bg-dark rounded text-light w-100">
                    <h3>Forma za registraciju</h3>
                    <form name="formaRegistracija" id="formaRegistracija">
                        <div class="form-group">
                            <label class="form-label" for="tbUserR">Korisničko ime:</label>
                            <input class='form-control' type="text" name="tbUserR" id="tbUserR" placeholder="username" />
                        </div>
                        <span id="tbUserErrorR"></span>

                        <div class="form-group">
                            <label class="form-label" for="tbPasswordR">Lozinka:</label>
                            <input class='form-control' type="password" name="tbPasswordR" id="tbPasswordR" placeholder="******" />
                        </div>
                        <span id="tbPasswordErrorR"></span>
                        <div class="form-group">
                            <label class="form-label" for="tbRePasswordR">Ponovo unesite lozinku:</label>
                            <input class='form-control' type="password" name="tbRePasswordR" id="tbRePasswordR" placeholder="******" />
                        </div>
                        <span id="tbRePasswordErrorR"></span>

                        <div class="form-group">
                            <label class="form-label" for="tbUserEmailR">Email:</label>
                            <input class='form-control' type="text" name="tbUserEmailR" id="tbUserEmailR" placeholder="korisnik@gmail.com" />
                        </div>
                        <span id="tbEmailErrorR"></span>

                        <div class="d-flex justify-content-center mt-4">
                            <input class="btn btn-success" type="submit" name="btnSubmitRegistracija" value="Registracija" id="btnSubmitRegistracija" />
                        </div>
                    </form>
                    <?php
                    if (isset($_SESSION['salji-mail'])) :
                    ?>
                        <a href="logic/aktivacija.php" class="btn btn-success">Link za aktivaciju</a>
                    <?php
                        unset($_SESSION['salji-mail']);
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>