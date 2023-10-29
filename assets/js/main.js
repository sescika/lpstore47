const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

window.onload = function () {
  if (params.page == "registracija") {
    function proveraRegistracija(e) {
      e.preventDefault();
      let greske = [];

      let regUser = $("#tbUserR").val();
      let regPass = $("#tbPasswordR").val();
      let regRePass = $("#tbRePasswordR").val();
      let regEmail = $("#tbUserEmailR").val();

      let regUserError = document.getElementById("tbUserErrorR");
      let regPassError = document.getElementById("tbPasswordErrorR");
      let regRePassError = document.getElementById("tbRePasswordErrorR");
      let regEmailError = document.getElementById("tbEmailErrorR");

      let userRegex =
        /^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;
      let passRegex =
        /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
      let emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

      if (!userRegex.test(regUser)) {
        regUserError.classList.add("text-danger");
        regUserError.innerHTML =
          "Pogrešno korisničko ime. Mora da sadrži barem 8 karaktera.";
        greske.push("greska user");
      } else {
        regUserError.innerHTML = "";
      }

      if (!passRegex.test(regPass)) {
        regPassError.classList.add("text-danger");
        regPassError.innerHTML =
          "Nevalidna lozinka. Mora da sadrži barem 8 karaktera, minimum jedno slovo, jedan broj i jedan specijalni karatker";
        greske.push("greska password");
      } else {
        regPassError.innerHTML = "";
      }

      if (!(regPass === regRePass)) {
        regRePassError.classList.add("text-danger");
        regRePassError.innerHTML = "Lozinke se ne poklapaju";
        greske.push("greska re password");
      } else if (regRePass === "") {
        regRePassError.classList.add("text-danger");
        regRePassError.innerHTML = "Ponovo unesite lozinku  ";
        greske.push("greska re password 1");
      } else {
        regRePassError.innerHTML = "";
      }

      if (!emailRegex.test(regEmail)) {
        regEmailError.classList.add("text-danger");
        regEmailError.innerHTML = "Pogrešan format. pr: peraperic@gmail.com";
        greske.push("greska user");
      } else {
        regEmailError.innerHTML = "";
      }

      if (greske.length == 0) {
        data = {
          tbUserR: regUser,
          tbPasswordR: regPass,
          tbUserEmailR: regEmail,
        };

        ajaxCallback(
          "obrada-registracija.php",
          "POST",
          data,
          "0",
          function (result) {
            if (result) {
              document.getElementById("registracijaPoruke").innerHTML =
                result.poruka;
              document.getElementById("registracijaPoruke").className = "";
              document
                .getElementById("registracijaPoruke")
                .classList.add("alert-success", "alert", "p-3", "rounded");
              document.getElementById("formaRegistracija").reset();
            }
          }
        );
      }
    }

    document
      .getElementById("formaRegistracija")
      .addEventListener("submit", proveraRegistracija);
  }
  if (params.page == "kontakt") {
    function proveraKontakt(e) {
      e.preventDefault();

      let greske = [];

      let formaEmail = $("#tbUserEmail").val();
      let formaDdlProizvodjaciVal = $("#ddlProizvodjaci").val();
      let formaDdlProizvodjaci =
        document.getElementById("ddlProizvodjaci").options[
          document.getElementById("ddlProizvodjaci").selectedIndex
        ].text;
      let formaTextArea = $("#taOpis").val();

      let tbEmailErrorSpan = document.getElementById("tbEmailError");
      let ddlProizvodjaciErrorSpan = document.getElementById(
        "ddlProizvodjaciError"
      );
      let textAreaErrorSpan = document.getElementById("taError");

      let emailRegex =
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

      if (!emailRegex.test(formaEmail)) {
        tbEmailErrorSpan.classList.add("text-danger");
        tbEmailErrorSpan.innerHTML = "Pogrešan email.";
        greske.push("greska email");
      } else {
        tbEmailErrorSpan.innerHTML = "";
      }

      if (formaDdlProizvodjaciVal == 0) {
        ddlProizvodjaciErrorSpan.classList.add("text-danger");
        ddlProizvodjaciErrorSpan.innerHTML = "Izaberite proizvođača.";
        greske.push("greska proizvodjaci");
      } else {
        ddlProizvodjaciErrorSpan.innerHTML = "";
      }

      if (formaTextArea.length < 15) {
        textAreaErrorSpan.classList.add("text-danger");
        textAreaErrorSpan.innerHTML = "Dajte malo detaljniji opis.";
        greske.push("greska ta");
      } else {
        textAreaErrorSpan.innerHTML = "";
      }

      if (greske.length == 0) {
        data = {
          formaEmail: formaEmail,
          formaDdlProizvodjaci: formaDdlProizvodjaci,
          formaTextArea: formaTextArea,
        };

        ajaxCallback(
          "obrada-kontakt.php",
          "POST",
          data,
          "0",
          function (result) {
            document.getElementById("kontaktPoruke").innerHTML = result.poruka;
            document.getElementById("formaRegistracija").reset();
            document
              .getElementById("kontaktPoruke")
              .classList.add("alert-success", "alert", "p-3", "rounded");

            if (!result) {
              document
                .getElementById("kontaktPoruke")
                .classList.add("alert-danger", "alert", "p-3", "rounded");
            }
          }
        );
      }
    }
    document
      .querySelector("#formaKontakt")
      .addEventListener("submit", proveraKontakt);
  }
  if (params.page == "admin") {
    prikazProizvoda();
    $(document).on("click", ".btn-edit", prikazModalaSaPodacima);
    $(document).on("click", ".btn-delete", brisanjeProizvoda);
    $(document).on("click", "#sacuvajPromene", editProizvod);
    document
      .getElementById("modalClose")
      .addEventListener("click", prikazProizvoda);
    document
      .querySelector(".closeButton")
      .addEventListener("click", prikazProizvoda);
  }
  if (params.page == "unos-proizvoda") {
    document
      .getElementById("unosProizvoda")
      .addEventListener("click", unosProizvoda);
  }
  if (params.page == "tiketi") {
    prikazTiketa();
  }
  if (params.page == "porudzbine") {
    ajaxCallback("dohvati-porudzbine.php", "GET", 0, "0", function (result) {
      ispisPorudzbina(result);
    });
  }
  if (params.page == "profil") {
    $(document).on("click", "#btnSaveProfil", editProfil);
    prikazProfila();
  }
  if (params.page == "proizvodi") {
    ajaxCallback("dohvati-proizvode.php", "GET", 0, "0", function (result) {
      lsSet("proizvodi", result);
    });
    ajaxCallback("dohvati-filtere.php", "GET", 0, "0", function (result) {
      ispisFiltera(result);
    });
    prikazProizvodaP(1);
    document
      .getElementById("btnSearchProizvodi")
      .addEventListener("click", pretragaProizvoda);
    document
      .getElementById("tbSearchProizvod")
      .addEventListener("input", pretragaProizvoda);

    $(document).on("input", ".form-check-input", filtriranjeProizvoda);

    $(".btnPaginacija").on("click", function () {
      let strana = $(this).attr("data-strana");
      let data;

      data = {
        strana: strana,
      };
      ajaxCallback(
        "dohvati-proizvode.php",
        "GET",
        data,
        "0",
        function (result) {
          ispisProizvodaP(result);
        }
      );
    });
  }
  if (params.page == "korpa") {
    prikazKorpe();

    $(document).on("click", "#btnPoruci", unosPorudzbine);
  }
};


function unosPorudzbine() {
  let arrIdProizvoda = document.querySelectorAll(".idProizvod");
  let arrKolicinaProizvoda = document.querySelectorAll(".kolicinaProizvod");

  let arrValueIdProizvoda = [];
  let arrValueKolicinaProizvoda = [];
  let valueKonacnaCena = document.querySelector("#cenaUkupnoKorpa ").value;

  arrIdProizvoda.forEach((p) => {
    arrValueIdProizvoda.push(p.value);
  });

  arrKolicinaProizvoda.forEach((p) => {
    arrValueKolicinaProizvoda.push(p.value);
  });

  let data = {};

  data = {
    arrValueIdProizvoda: arrValueIdProizvoda,
    arrValueKolicinaProizvoda: arrValueKolicinaProizvoda,
    valueKonacnaCena: valueKonacnaCena,
  };
  // data.append("arrValueIdProizvoda", arrValueIdProizvoda);
  // data.append("arrValueKolicinaProizvoda", arrValueKolicinaProizvoda);
  // data.append("valueKonacnaCena", valueKonacnaCena);

  ajaxCallback("unos-porudzbine.php", "POST", data, "0", function (result) {
    document.getElementById("korpaPoruke").innerHTML = result.poruka;
    document
      .getElementById("korpaPoruke")
      .classList.add("alert", "alert-success");
    isprazniKorpu();
  });
}

function ispisPorudzbina(data) {
  let porudzbine = data.porudzbine;
  let username = data.user;

  let html = `
        <table class="table table-striped align-center d-block d-lg-table border overflow-x-auto">
            <thead class="table-header text-light bg-dark">
                <th>Porudzbina Id</th>
                <th>Korisnik</th>
                <th>Proizvod</th>
                <th>Kolicina</th>   
            </thead>
            <tbody>`;
  porudzbine.forEach((d) => {
    html += `
        <tr>
            <td>
                ${d.porudzbinaId}
            </td>
            <td>
                ${username}
            </td>
            <td>
                ${d.nazivProizvod}
            </td>
            <td>
                ${d.kolicinaProizvoda} 
            </td>
        </tr>`;
  });

  html += `</tbody></table>`;

  document.getElementById("tabelaPorudzbina").innerHTML = html;
}

function lsSet(key, value) {
  localStorage.setItem(key, JSON.stringify(value));
}

function lsGet(key) {
  return JSON.parse(localStorage.getItem(key));
}

function isprazniKorpu() {
  localStorage.removeItem("korpa");
  prikazPrazneKorpe();
}

const alertPlaceholder = document.getElementById("liveAlertPlaceholder");

const alert = (message, type) => {
  const wrapper = document.createElement("div");
  wrapper.innerHTML = [
    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
    `   <div>${message}</div>`,
    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
    "</div>",
  ].join("");

  alertPlaceholder.append(wrapper);
};

function dodajuKorpu(id) {
  if (!lsGet("korpa")) {
    dodajPrvi(id);
  } else {
    let korpa = lsGet("korpa");
    let isKorpi = korpa.find((x) => x.id == id);
    if (!isKorpi) {
      dodajNovi(id);
    } else {
      alert("Proizvod je već u korpi.", "danger");
    }
  }

  function dodajPrvi(id) {
    let data = {
      id: id,
      kolicina: 1,
    };
    let zaKorpu = [];
    zaKorpu.push(data);
    lsSet("korpa", zaKorpu);
    alert("Proizvod dodat u korpu.", "success");
  }

  function dodajNovi(id) {
    let trenutnoKorpa = lsGet("korpa");
    let data = {
      id: id,
      kolicina: 1,
    };
    trenutnoKorpa.push(data);
    lsSet("korpa", trenutnoKorpa);
    alert("Proizvod dodat u korpu.", "success");
  }
}

function ukloniItemIzKorpe(id) {
  let proizvodi = lsGet("korpa");
  let filtrirani = proizvodi.filter((p) => p.id != id);
  lsSet("korpa", filtrirani);

  if (filtrirani.length == 0) {
    prikazPrazneKorpe();
  } else {
    prikazKorpe();
  }
}

function povecajKolicinuProizvodaUKorpi(id) {
  let korpa = lsGet("korpa");

  korpa.forEach((p) => {
    if (p.id == id) {
      p.kolicina++;
      lsSet("korpa", korpa);
    }
  });

  prikazKorpe();
}

function smanjiKolicinuProizvodaUKorpi(id) {
  let korpa = lsGet("korpa");

  korpa.forEach((p) => {
    if (p.id == id) {
      if (p.kolicina === 1) {
        p.kolicina = 1;
      } else {
        p.kolicina--;
        lsSet("korpa", korpa);
      }
    }
  });

  prikazKorpe();
}

function prikazKorpe() {
  let items = lsGet("korpa");
  let proizvodi = lsGet("proizvodi");

  if (!items || items.length == 0) {
    prikazPrazneKorpe();
  } else {
    html = `
    <table class="table table-striped d-block d-lg-table border overflow-x-auto ">
        <thead class="table-header text-light bg-dark">
            <tr>
                <th>Rb proizvoda</th>
                <th>Naziv Proizvoda</th>
                <th>Cena</th>
                <th>Količina</th>
                <th>Končna cena</th>
                <th></th>
            </tr>
        </thead>
        <tbody>`;
    let rb = 1;
    let ukupno = 0;
    items.forEach((p) => {
      proizvodi.forEach((pr) => {
        if (p.id == pr.proizvodId) {
          html += `
            <tr>
              <td>${rb}</td>
              <input type='hidden' class='idProizvod' name='idProizvod${rb}' value="${
            p.id
          }" />
              <td>${pr.nazivProizvod}</td>
              <input type='hidden' name='nazivProizvod' value="${
                pr.nazivProizvod
              }" />
              <td>${obradaCene(pr.trenutnaCena)}</td>
              <input type='hidden' class='cenaProizvod' name='cenaProizvod${rb}' value="${Number(
            pr.trenutnaCena
          )}" />
              <td>
                <button onclick='smanjiKolicinuProizvodaUKorpi(${
                  p.id
                })' class='btn btnMinus border'>-</button>
                  ${p.kolicina}
                  <input type='hidden' class='kolicinaProizvod' name='kolicinaProizvod${rb}' value="${
            p.kolicina
          }" />
                <button onclick='povecajKolicinuProizvodaUKorpi(${
                  p.id
                })' class='btn btnPlus border'>+</button>
              </td>
              <td><p class='fw-bold'>${obradaCene(
                p.kolicina * pr.trenutnaCena
              )}</p></td>
              <input type='hidden' name='ukupnoCenaRed${rb}' value="${Number(
            p.kolicina * pr.trenutnaCena
          )}" />
              <td><button class='btn btn-danger' onclick="ukloniItemIzKorpe(${
                p.id
              })">Izbaci</button></td>
            </tr>
            `;
          ukupno += p.kolicina * pr.trenutnaCena;
        }
      });
      rb++;
    });

    html += `
      </tbody>
      </table>
      <div class='row d-flex justify-content-end'>
        <div id="divfinalno" class="col-12 col-md-6 col-lg-3 border p-3 rounded bg-light my-3 ">
          <h2>Ukupno:</h2>
          <p><span class='fw-bold fs-4'>${obradaCene(ukupno)}</span></p>
          <input id="cenaUkupnoKorpa" type='hidden' name='cenaUkupno' value='${Number(
            ukupno
          )}' />
          <button class='btn btn-secondary' id="btnPoruci">Poručite</button>
        </div>
      </div>
    `;
  }

  document.getElementById("korpa").innerHTML = html;
}

function prikazPrazneKorpe() {
  let html = `<h2 class='alert alert-light'>Trenutno nema proizvoda u korpi.</h2>
              <a href="index.php?page=proizvodi">Dodajte proizvode u korpu!</a>`;

  document.getElementById("korpa").innerHTML = html;
}

function ispisGresaka(errors, divZaIspis) {
  divZaIspis = document.getElementById("registracijaPoruke");
  divZaIspis.className = "";
  divZaIspis.classList.add("alert-danger", "alert", "p-3", "rounded");

  let html = "";

  for (let e of errors) {
    html += e + " \n";
  }

  divZaIspis.innerHTML = html;
}

function ajaxCallback(url, method, data, withFile, result) {
  data = data == 0 ? "" : data;

  var ajaxObj = {
    url: "models/" + url,
    method: method,
    data: data,
    dataType: "json",
    success: result,
    error: function (xhr) {
      if (xhr.status == 422) {
        let errors = xhr.responseJSON.poruka;
        ispisGresaka(errors, "registracijaPoruke");
        for (let error of errors) {
          console.log(error);
        }
      }
      if (xhr.status == 500) {
        console.log(xhr.responseJSON.poruka);
      }
      if (xhr.status == 404) {
        console.log("Stranica nije pronadjena.");
      }
    },
  };
  if (withFile != "0") {
    ajaxObj.contentType = false;
    ajaxObj.processData = false;
  }
  $.ajax(ajaxObj);
}

function printAlert(message, element) {
  if ($(element).next().length) {
    $(element).next().remove();
  }
  $(element)
    .parent()
    .append(`<p class="alert alert-danger mt-1">${message}</p>`);
}

function removeAlert(element) {
  if ($(element).next().length) {
    $(element).next().remove();
  }
}

function brisanjeProizvoda() {
  let idProizvod = $(this).data("id");
  let data;

  if (confirm("Da li ste sigurni da želite da obrišete proizvod?")) {
    data = {
      id: idProizvod,
    };

    ajaxCallback("brisanje-proizvoda.php", "POST", data, "0", function (reset) {
      prikazProizvoda();
    });
  }
}

function prikazProizvoda() {
    
  let data = {
    stranica: "admin"
  }
  ajaxCallback("dohvati-proizvode.php", "GET", data, "0", function (result) {
    ispisProizvoda(result);
  });
}

function ispisProizvoda(data) {
  let html = `
    <table class="table table-striped align-center d-block d-lg-table border overflow-x-auto" id="tabelaProizvodi">
        <thead class="table-header text-light bg-dark">
            <th>id</th>
            <th>Naziv proizvoda</th>
            <th>Proizvođač</th>
            <th>Cena</th>
            <th>Grafička kartica</th>
            <th>Procesor</th>
            <th>Storage</th>
            <th>Dijagonala</th>
            <th>Foto</th>
            <th>Izmeni</th>
            <th>Obriši</th>
        </thead>
        <tbody>`;
  data.forEach((d) => {
    html += `
        <tr>
            <td>
                ${d.proizvodId}
            </td>
            <td>
                ${d.nazivProizvod}
            </td>
            <td>
                ${d.nazivProizvodjac}
            </td>
            <td>
                ${d.trenutnaCena} RSD
            </td>
            <td>
                ${d.nazivGraficke} 
            </td>
            <td>
                ${d.nazivProcesora} 
            </td>
            <td>
                ${d.ssd} GB
            </td>
            <td>
                ${d.dijagonala} "
            </td>
            <td>
                <img width="150px" src=`;

    if (d.lokacija.includes("uploads")) {
      let nova = d.lokacija;
      nova = nova.substring(d.lokacija.lastIndexOf("/"));
      html += `uploads/${nova}`;
    } else {
      html += `${d.lokacija}`;
    }

    html += ` alt="${d.nazivSlika}" />   
            </td>
            <td>
                <button class='btn btn-warning btn-edit' data-id="${d.proizvodId}"'>Edit</button>
            </td>
            <td>
                <button class='btn btn-danger btn-delete'data-id="${d.proizvodId}">Delete</button>
            </td>
        </tr>`;
  });

  html += `</tbody></table>`;

  document.getElementById("tabelaProizvoda").innerHTML = html;
}

function unosProizvoda() {
  let proizvodjacId,
    nazivProizvoda,
    cenaProizvoda,
    procesorId,
    grafickaId,
    storageVrednost,
    dijagonalaVrednost,
    slika,
    errors = 0,
    data;

  nazivProizvoda = $("#tbNaziv").val();
  proizvodjacId = $("#ddlProizvodjaci").val();
  cenaProizvoda = $("#tbCena").val();
  slika = $("#slika")[0].files[0];
  grafickaId = $("#ddlNazivGraficke").val();
  procesorId = $("#ddlNazivProcesora").val();
  storageVrednost = $("#tbStorage").val();
  dijagonalaVrednost = $("#tbDijagonala").val();

  if (nazivProizvoda == "") {
    errors++;
    printAlert("Unesite naziv proizvoda.", $("#tbNaziv"));
  } else {
    removeAlert($("#tbNaziv"));
  }

  if (proizvodjacId == "0") {
    errors++;
    printAlert("Izaberite proizvođača.", $("#ddlProizvodjaci"));
  } else {
    removeAlert($("#ddlProizvodjaci"));
  }

  if (cenaProizvoda == "") {
    errors++;
    printAlert("Unesite cenu proizvoda.", $("#tbCena"));
  } else {
    removeAlert($("#tbCena"));
  }

  if (slika == undefined) {
    errors++;
    printAlert("Unesite sliku proizvoda.", $("#slika"));
  } else {
    removeAlert($("#slika"));
  }

  if (grafickaId == "0") {
    errors++;
    printAlert("Izaberite grafičku.", $("#ddlNazivGraficke"));
  } else {
    removeAlert($("#ddlNazivGraficke"));
  }

  if (procesorId == "0") {
    errors++;
    printAlert("Izaberite procesor.", $("#ddlNazivProcesora"));
  } else {
    removeAlert($("#ddlNazivProcesora"));
  }

  if (dijagonalaVrednost == "") {
    errors++;
    printAlert("Unesite dijagonalu.", $("#tbDijagonala"));
  } else {
    removeAlert($("#tbDijagonala"));
  }

  if (storageVrednost == "") {
    errors++;
    printAlert("Unesite storage.", $("#tbStorage"));
  } else {
    removeAlert($("#tbStorage"));
  }

  if (errors == 0) {
    data = new FormData();
    data.append("nazivProizvoda", nazivProizvoda);
    data.append("proizvodjacId", proizvodjacId);
    data.append("cenaProizvoda", cenaProizvoda);
    data.append("grafickaId", grafickaId);
    data.append("procesorId", procesorId);
    data.append("dijagonala", dijagonalaVrednost);
    data.append("storage", storageVrednost);
    data.append("slika", slika);

    ajaxCallback(
      "obrada-unos-proizvoda.php",
      "POST",
      data,
      "1",
      function (result) {
        $("#unosProizvodaPoruka").html("Uspešno unet proizvod.");
        $("#unosProizvodaPoruka").addClass("alert alert-info my-2");
        document.getElementById("formaUnosProizvoda").reset();
      }
    );
  }
}

function editProizvod() {
  let proizvodId,
    proizvodjacId,
    nazivProizvoda,
    cenaProizvoda,
    procesorId,
    grafickaId,
    storageVrednost,
    dijagonalaVrednost,
    slika,
    errors = 0,
    data;

  proizvodId = $("#idPrizvod").val();
  nazivProizvoda = $("#nazivProizvodaEdit").val();
  proizvodjacId = $("#ddlProizvodjacEdit").val();
  cenaProizvoda = $("#cenaProizvodaEdit").val();
  slika = $("#slikaProizvodaEdit")[0].files[0];
  grafickaId = $("#ddlGrafickeEdit").val();
  procesorId = $("#ddlProcesoriEdit").val();
  storageVrednost = $("#storageEdit").val();
  dijagonalaVrednost = $("#dijagonalaEdit").val();

  if (nazivProizvoda == "") {
    errors++;
    printAlert("Unesite naziv proizvoda.", $("#nazivProizvodaEdit"));
  } else {
    removeAlert($("#nazivProizvodaEdit"));
  }

  if (proizvodjacId == "0") {
    errors++;
    printAlert("Izaberite proizvođača.", $("#ddlProizvodjacEdit"));
  } else {
    removeAlert($("#ddlProizvodjacEdit"));
  }

  if (cenaProizvoda == "") {
    errors++;
    printAlert("Unesite cenu proizvoda.", $("#cenaProizvodaEdit"));
  } else {
    removeAlert($("#cenaProizvodaEdit"));
  }

  if (grafickaId == "0") {
    errors++;
    printAlert("Izaberite grafičku.", $("#ddlGrafickeEdit"));
  } else {
    removeAlert($("#ddlGrafickeEdit"));
  }

  if (procesorId == "0") {
    errors++;
    printAlert("Izaberite procesor.", $("#ddlProcesoriEdit"));
  } else {
    removeAlert($("#ddlProcesoriEdit"));
  }

  if (dijagonalaVrednost == "") {
    errors++;
    printAlert("Unesite dijagonalu.", $("#dijagonalaEdit"));
  } else {
    removeAlert($("#dijagonalaEdit"));
  }

  if (storageVrednost == "") {
    errors++;
    printAlert("Unesite storage.", $("#storageEdit"));
  } else {
    removeAlert($("#storageEdit"));
  }
  let slika1 = "0";
  if (errors == 0) {
    if (slika != undefined) {
      data = new FormData();
      data.append("proizvodId", proizvodId);
      data.append("nazivProizvoda", nazivProizvoda);
      data.append("proizvodjacId", proizvodjacId);
      data.append("cenaProizvoda", cenaProizvoda);
      data.append("grafickaId", grafickaId);
      data.append("procesorId", procesorId);
      data.append("dijagonala", dijagonalaVrednost);
      data.append("storage", storageVrednost);
      data.append("slika", slika);
      slika1 = "1";
    } else {
      data = {
        proizvodId: proizvodId,
        nazivProizvoda: nazivProizvoda,
        proizvodjacId: proizvodjacId,
        cenaProizvoda: cenaProizvoda,
        grafickaId: grafickaId,
        procesorId: procesorId,
        dijagonala: dijagonalaVrednost,
        storage: storageVrednost,
      };
    }

    ajaxCallback("edit.php", "POST", data, slika1, function (result) {
      unosPodatakaUModal(result);
      document.getElementById("modalNotification").innerHTML = result.poruka;
      document
        .getElementById("modalNotification")
        .classList.add("alert", "alert-success", "p-2");
    });
  }
}

function prikazTiketa() {
  ajaxCallback("dohvati-tikete.php", "GET", 0, "0", function (result) {
    ispisTiketa(result);
  });
}

function ispisTiketa(data) {
  let rb = 1;
  let html = `
        <table class="table table-striped align-center d-block d-lg-table border overflow-x-auto">
            <thead class="table-header text-light bg-dark">
                <th>rb</th>
                <th>Korisnik</th>
                <th>Opis problema</th>
                <th>Datum slanja</th>   
                <th>Status</th>
            </thead>
            <tbody>`;
  data.forEach((d) => {
    html += `
        <tr>
            <td>
                ${rb}
            </td>
            <td>
                ${d.username} (${d.email})
            </td>
            <td>
                ${d.opisProblema}
            </td>
            <td>
                ${d.datumSlanjaTiketa} 
            </td>
            <td>
                ${d.fazaResavanja}   
            </td>
        </tr>`;
    rb++;
  });

  html += `</tbody></table>`;

  document.getElementById("tabelaTiketa").innerHTML = html;
}

function prikazModal() {
  var modal = document.querySelector(".modal");

  if (modal.style.display === "none" || modal.style.display === "") {
    modal.style.display = "block";
  } else {
    modal.style.display = "none";
  }

  modal.classList.toggle("show");

  if (document.body.querySelector(".modal-backdrop")) {
    document.body.querySelector(".modal-backdrop").remove();
  } else {
    const node = document.createElement("div");
    node.setAttribute("class", "modal-backdrop fade show");
    document.body.appendChild(node);
  }

  document.querySelector(".close").addEventListener("click", prikazModal);
  document.querySelector(".closeButton").addEventListener("click", prikazModal);
}

function prikazModalaSaPodacima() {
  let idProizvod = $(this).data("id");

  let data = {
    id: idProizvod,
  };

  ajaxCallback("dohvati-proizvode.php", "GET", data, "0", function (result) {
    prikazModal();
    unosPodatakaUModal(result);
  });
}

function unosPodatakaUModal(data) {
  let proizvod = data.proizvod;
  let graficke = data.graficke;
  let proizvodjaci = data.proizvodjaci;
  let procesori = data.procesori;

  let ddlProizvodjac = `
        <select class="form-select" id="ddlProizvodjacEdit">
            <option value="0">Izaberite</option>`;
  for (let p of proizvodjaci) {
    if (proizvod.proizvodjacId == p.proizvodjacId) {
      ddlProizvodjac += `<option value="${p.proizvodjacId}" selected="selected">${p.nazivProizvodjac}</option>`;
    } else {
      ddlProizvodjac += `<option value="${p.proizvodjacId}">${p.nazivProizvodjac}</option>`;
    }
  }
  ddlProizvodjac += `</select>`;

  let ddlProcesori = `
        <select class="form-select" id="ddlProcesoriEdit">
            <option value="0">Izaberite</option>`;
  for (let p of procesori) {
    if (p.procesoriSpecifikacijeId == proizvod.procesorId) {
      ddlProcesori += `<option value="${p.procesoriSpecifikacijeId}" selected="selected">${p.nazivProcesora}</option>`;
    } else {
      ddlProcesori += `<option value="${p.procesoriSpecifikacijeId}">${p.nazivProcesora}</option>`;
    }
  }
  ddlProcesori += `</select>`;

  let ddlGraficke = `
        <select class="form-select" id="ddlGrafickeEdit">
            <option value="0">Izaberite</option>`;
  for (let p of graficke) {
    if (p.grafickeSpecifikacijaId == proizvod.grafickaId) {
      ddlGraficke += `<option value="${p.grafickeSpecifikacijaId}" selected="selected">${p.nazivGraficke}</option>`;
    } else {
      ddlGraficke += `<option value="${p.grafickeSpecifikacijaId}">${p.nazivGraficke}</option>`;
    }
  }
  ddlGraficke += `</select>`;

  let modalContent = ``;

  modalContent += `
        <form>
            <div class="form-group">
                <label for="nazivProizvodaEdit">Naziv proizvoda</label>
                <input id="nazivProizvodaEdit" name="nazivProizvodaEdit" type="text" class="form-control" value="${proizvod.nazivProizvod}" />
            </div>
            <div class="form-group">
                <label for="ddlProizvodjacEdit">Proizvodjač</label>
                ${ddlProizvodjac}
            </div>
            <div class="form-group">
                <label for="cenaProizvodaEdit">Cena</label>
                <input id="cenaProizvodaEdit" name="cenaProizvodaEdit" type="number" class="form-control" value="${proizvod.trenutnaCena}" />
            </div>
            <div class="form-group">
                <label for="ddlProcesoriEdit">Procesor</label>
                ${ddlProcesori}
            </div>  
            <div class="form-group">
                <label for="ddlGrafickeEdit">Grafička</label>
                ${ddlGraficke}  
            </div>
            <div class="form-group">
                <label for="storageEdit">Storage</label>
                <input id="storageEdit" name="storageEdit" type="number" class="form-control" value="${proizvod.ssd}" />
            </div>
            <div class="form-group">
                <label for="dijagonalaEdit">Dijagonala proizvoda</label>
                <input id="dijagonalaEdit" name="dijagonalaEdit" type="number" class="form-control" step ="0.1"value="${proizvod.dijagonala}" />
            </div>
            <div class="form-group w-100">
                <label>Promeni sliku</label><br/>
                <input id="slikaProizvodaEdit" type="file" />
                <img width="75px" src="`;

  if (proizvod.lokacija.includes("uploads")) {
    let nova = proizvod.lokacija;
    nova = nova.substring(proizvod.lokacija.lastIndexOf("/"));
    modalContent += `uploads/${nova}`;
  } else {
    modalContent += `${proizvod.lokacija}`;
  }

  modalContent += `" alt="${proizvod.nazivSlika}"/>
            </div>

            <input type="hidden" value="${proizvod.proizvodId}" id="idPrizvod"/>
        </form>
    `;

  document.querySelector(".modal .modal-body").innerHTML = modalContent;
}

function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function prikazProfila() {
  let idGet = getParameterByName("id");

  ajaxCallback(
    "dohvati-profil.php?id=" + idGet,
    "GET",
    0,
    "0",
    function (result) {
      ispisProfila(result);
    }
  );
}

function ispisProfila(data) {
  let profil = data.profil;

  let html = `
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-6 col-12'>
                        <img src='`;

  if (profil.file_location.includes("../")) {
    html += "uploads/" + profil.file_location;
  } else {
    html += profil.file_location;
  }
  html += `' data-id="${profil.profileImgId}" class='profile-img' alt='${profil.file_name}' />
                    </div>
                    <div class='col-lg-6 col-12'>   
                        <div class='mb-3'>
                            <label for='tbUsernameP'>Username:</label>
                            <input type='text' readonly="readonly" name='tbUsernameP' id='tbUsernameP' class='form-control' value='${profil.username}' />
                        </div>
                        <div class='mb-3'>
                            <label for='tbEmailP'>Email:</label>
                            <input type='text' readonly="readonly" name='tbEmailP' id='tbEmailP' class='form-control' value='${profil.email}' />
                        </div>
                        <div class='border p-1 rounded'>
                            <div class='mb-3'>
                                <label for='fajlProfil'>Promenite sliku:</label>
                                <input type='file' id='fajlProfil' name='fajlProfil' />
                            </div>
                            <div class='mb-3 d-flex justify-content-center'>
                                <button class='btn btn-secondary' id='btnSaveProfil'>Sačuvaj</button>
                            </div>
                        </div>
                    <input type="hidden" id="userId" name="userId" value="${profil.id}"/>
                    </div>
                </div>
            </div>
                `;
  document.getElementById("prikazProfil").innerHTML = html;
}

function editProfil() {
  let slika = $("#fajlProfil")[0].files[0];
  let idSlike = $(".profile-img").data("id");
  let userId = $("#userId").val();

  if (slika == undefined) {
    document.getElementById("alertsProfil").innerHTML = "Nema promena.";
    document
      .getElementById("alertsProfil")
      .classList.add("alert", "alert-secondary");
  } else {
    let data = new FormData();
    data.append("userId", userId);
    data.append("slika", slika);
    data.append("idSlike", idSlike);

    ajaxCallback("edit-profil.php", "POST", data, "1", function (result) {
      document.getElementById("alertsProfil").innerHTML = result.poruka;
      document
        .getElementById("alertsProfil")
        .classList.add("alert", "alert-success", "p-3", "rounded");
      prikazProfila(result);
    });
  }
}

function prikazProizvodaP(strana) {
  ajaxCallback(
    "dohvati-proizvode.php?strana=" + strana,
    "GET",
    0,
    "0",
    function (result) {
      ispisProizvodaP(result);
    }
  );
}

function ispisProizvodaP(data) {
  let html = `<div class='row'>`;

  data.forEach((d) => {
    html += `            
                <div class='col-12 col-md-6 col-lg-4 product my-3'>
                    <div class='card bg-light border rounded p-3 h-100'>
                        <img src='`;

    if (d.lokacija.includes("../uploads/")) {
      html += "uploads/" + d.lokacija;
    } else {
      html += d.lokacija;
    }

    html += `' alt='${d.nazivSlika}' class='card-img-top' />
                        <div class='card-body'>
                            <h5 class='card-title'>${d.nazivProizvod}</h5> 
                            <hr />
                        </div>
                        <div class='cenaProizvoda'>
                            <p class='fw-bold fs-4'>${obradaCene(
                              d.trenutnaCena
                            )} RSD</p>
                        </div>  
                        <div class='d-flex justify-content-center align-items-center'>
                            <button data-id='${
                              d.proizvodId
                            }' onclick='dodajuKorpu(${
      d.proizvodId
    })' class='btn btn-primary btn-addToCart'><i class='fa-solid fa-cart-plus'></i>    Dodaj u korpu</button>
                        </div>
                    </div>
                </div>`;
  });

  html += `</div>`;

  document.getElementById("proizvodiP").innerHTML = html;
}

function pretragaProizvoda() {
  let queryString = document.getElementById("tbSearchProizvod").value,
    data;

  data = {
    nazivProizvod: queryString,
  };

  ajaxCallback("dohvati-proizvode.php", "GET", data, "0", function (result) {
    if (queryString == "") {
      prikazProizvodaP(1);
    }
    ispisProizvodaP(result);
  });
}

function ispisGrupeFilterCheckboxovaProcesor(data) {
  html = `<div class='border rounded p-2 mb-3'>
                <h5>Proizvođač procesora:</h5>
                    <hr />`;

  for (let d of data) {
    html += `<div class='mb-2'>
                    <input class="form-check-input mt-0 filter-procesori" type="checkbox" value='${d.proizvodjacProcesoraId}' id='${d.proizvodjacProcesoraId}filterP'data-id='${d.proizvodjacProcesoraId}' />
                    <label for='${d.proizvodjacProcesoraId}filterP'>${d.nazivProizvodjacaProcesora}</label>
                </div>`;
  }
  html += "</div>";

  document.getElementById("filteriP").innerHTML += html;
}

function ispisGrupeFilterCheckboxovaGraficka(data) {
  html = `<div class='border rounded p-2 mb-3'>
                <h5>Proizvođač grafičke:</h5>
                    <hr />`;

  for (let d of data) {
    html += `<div class='mb-2'>
                    <input class="form-check-input mt-0 filter-graficke" type="checkbox" value='${d.proizvodjacGrafickeId}' id='${d.proizvodjacGrafickeId}filterG'data-id='${d.proizvodjacGrafickeId}' />
                    <label for='${d.proizvodjacGrafickeId}filterG'>${d.nazivProizvodjacaGraficke}</label>
                </div>`;
  }
  html += "</div>";

  document.getElementById("filteriP").innerHTML += html;
}

function ispisGrupeFIlterCheckboxova(data) {
  let html = `
    <div class='border rounded p-2 mb-3'>
      <h5>Proizvođač laptopa:</h5>
        <hr />`;
  for (let d of data) {
    html += `<div class='mb-2'>
                      <input class="form-check-input mt-0 filter-proizvodjaci" type="checkbox" value='${d.proizvodjacId}' id='${d.proizvodjacId}filterPr'data-id='${d.proizvodjacId}' />
                      <label for='${d.proizvodjacId}filterPr'>${d.nazivProizvodjac}</label>
                  </div>`;
  }

  html += "</div>";

  document.getElementById("filteriP").innerHTML += html;
}

function ispisFiltera(data) {
  let proizvodjaciGraficke = data.proizvodjaciGraficke;
  let proizvodjaciProcesora = data.proizvodjaciProcesori;
  let proizvodjaciLaptopova = data.proizvodjaci;

  ispisGrupeFIlterCheckboxova(proizvodjaciLaptopova);
  ispisGrupeFilterCheckboxovaGraficka(proizvodjaciGraficke);
  ispisGrupeFilterCheckboxovaProcesor(proizvodjaciProcesora);

}

function obradaCene(x) {
  var parts = x.toString().split(".");
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return parts.join(",") + " RSD";
}

function filtriranjeProizvoda() {
  let arrIdGraficke = document.querySelectorAll(".filter-graficke");
  let arrIdProcesori = document.querySelectorAll(".filter-procesori");
  let arrIdProizvodjaci = document.querySelectorAll(".filter-proizvodjaci");

  let arrValueGraficke = [];
  let arrValueProcesori = [];
  let arrValueProizvodjaci = [];

  arrIdGraficke.forEach((p) => {
    if (p.checked) {
      arrValueGraficke.push(p.value);
    }
  });

  arrIdProcesori.forEach((p) => {
    if (p.checked) {
      arrValueProcesori.push(p.value);
    }
  });

  arrIdProizvodjaci.forEach((p) => {
    if (p.checked) {
      arrValueProizvodjaci.push(p.value);
    }
  });

  let data = {};

  data = {
    filteri: {
      arrValueGraficke: arrValueGraficke,
      arrValueProcesori: arrValueProcesori,
      arrValueProizvodjaci: arrValueProizvodjaci,
    },
  };


  ajaxCallback("dohvati-proizvode.php", "GET", data, "0", function (result) {
    ispisProizvodaP(result);
  });
}
