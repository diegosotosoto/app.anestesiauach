<?php
$titulo_info = "Utilidad Clínica";//texto obligatorio
$descripcion_info = "Anticoagulantes / Antiagregantes 
              ";//texto obligatorio

$formula = "";//texto opcional en formato html
$referencias = array("Kopp, S. L., Vandermeulen, E., McBane, R. D., Perlas, A., Leffert, L., & Horlocker, T. (2025). Regional anesthesia in the patient receiving antithrombotic or thrombolytic therapy: American Society of Regional Anesthesia and Pain Medicine Evidence-Based Guidelines (fifth edition). Regional Anesthesia and Pain Medicine. https://doi.org/10.1136/rapm-2024-105766"); //array opcional ordenada por números

$icono_apunte = "<i class='fa-solid fa-pills pe-3 pt-2'></i>";//formato obligatorio fontawesome pe-3 pt-2
$titulo_apunte = "Anticoagulantes / Antiagregantes";//texto obligatorio
	?>



<?php

  // Ve si está activa la cookie o redirige al login
  // if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  //  header('Location: ../login.php');
  // }

  //Conexión
  require("../conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");

  //Variables
    $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
    $titulo_navbar="<span class='text-white'>Apuntes</span>";
    $boton_navbar="<button class='navbar-toggler text-white shadow-sm' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>";

  //Carga Head de la página
  require("head.php");
 

  ?>




<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->



    <div class="pt-2 collapse navbar-collapse" id="navbarSupportedContent" style="background-color: #42A5FF;">
      <div class="pt-4 container ms-auto">

      <ul class="list-group pb-3">

        <li class="list-group-item list-group-item-secondary">
          <div class="text-center text-capitalize fw-normal fs-5">

            <h6>
                    <!-   ****** TÍTULO INFORMATIVO ******  ->  
                    <?php  echo $titulo_info;  ?>
            </h6>
          <div>
        </li>
        <li class="list-group-item">
                    <!-   ****** DESCRIPCIÓN ******  ->  
                  <div class="pt-2">
                  <?php  echo $descripcion_info;  ?>
                  </div>
        </li>

            <?php
              //GENERA LA FÓRMULA SI EXISTE     
              if($formula){   
                echo "<li class='list-group-item'>
                      <!-   ****** TÍTULO FORMULA ******  ->  
                      <div class='pt-2'>
                      Fórmula:
                      </div>
                      <div class='pt-2'>
                      <!-   ****** FORMULA ******  ->                 
                      $formula
                      </div>
                      </li>
                    ";
              }

              //GENERA LAS REFERENCIAS SI EXISTE EL ARRAY
              if($referencias){
                echo "
                <li class='list-group-item'>
                <!-   ****** TÍTULO FÓRMULA ******  ->  
                <div class='pt-2'>
                Referencias:
                </div>
                <div class='pt-2'><small>
                  <!-   ****** REFERENCIAS ******  ->
                  ";                  
                foreach ($referencias as $valor) {
                  echo "$valor </br>";
                }
                echo "
                </small></div>
                </li>
                ";
              }
            ?>

          <!-   ****** FOOTER DE LA INFO ******  ->  
      </ul>
    </div>
    </div>
<ul class="pt-4 list-group">
<div class="container text-center">

  <div class="row">

      <li class="list-group-item active shadow-sm bg-primary rounded-top text-white pt-2" style="background-image: var(--bs-gradient);">
        
    <span class='float-end'>
        <div class='pt-0 pb-1 ps-3 me-3 d-flex justify-content-end'>
          <button class='btn btn-primary shadow-sm border-light d-none d-sm-block' style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'> ? </button>
        </div>
    </span>

            <!-   ****** ICONO CON FORMATO PE-3 PT-2 ******  -> <!-   ****** TITULO ******  ->      

                        <?php

              echo $icono_apunte;
              echo $titulo_apunte;

            ?>

    </li>

    </div>
   </div>

<div class="phone-frame">
  <div class="sticky-search p-3">
    <div class="mb-2">
      <div class="text-muted small">Busca por principio activo o nombre comercial.</div>
    </div>
    <div class="input-group">
      <input id="searchInput" type="search" class="form-control form-control-lg" placeholder="Ej: xarelto, eliquis, clopidogrel, clexane" list="drugSuggestions" autocomplete="off">
      <button class="btn btn-primary" id="clearBtn" type="button">Limpiar</button>
    </div>
    <datalist id="drugSuggestions"></datalist>
  </div>

  <div class="p-3">
    <div id="hintBox" class="alert alert-secondary rounded-4">
      Escribe un fármaco o una marca registrada para ver la información de tu tabla.
    </div>

    <div id="resultsList" class="d-grid gap-2 mb-3"></div>
    <div id="drugDetail"></div>
  </div>
</div>

<script>
const rawRecords = [{"grupo": "Antiagregantes", "farmaco": "Aspirina", "condicion": "-", "suspension_pre_procedimiento": "No requiere", "reinicio_post_procedimiento": "No requiere", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["ácido acetilsalicílico", "aspirina", "cardioaspirina"]}, {"grupo": "Antiagregantes", "farmaco": "Clopidogrel", "condicion": "-", "suspension_pre_procedimiento": "5-7 días", "reinicio_post_procedimiento": "Inmediata, excepto con dosis de carga: 6hrs", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["clopidogrel", "clopidogrel b", "eurogrel", "clopivitae", "plavix"]}, {"grupo": "Antiagregantes", "farmaco": "Prasugrel", "condicion": "-", "suspension_pre_procedimiento": "7-10 días", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["prasugrel", "efient"]}, {"grupo": "Antiagregantes", "farmaco": "Ticagrelor", "condicion": "-", "suspension_pre_procedimiento": "5 días", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["ticagrelor", "brilinta"]}, {"grupo": "Antiagregantes", "farmaco": "Dipiridamol", "condicion": "-", "suspension_pre_procedimiento": "24 hrs", "reinicio_post_procedimiento": "6 hrs", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["dipiridamol", "persantin"]}, {"grupo": "Antiagregantes", "farmaco": "Cangrelor", "condicion": "-", "suspension_pre_procedimiento": "3 hrs", "reinicio_post_procedimiento": "8 hrs", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "8 hrs", "aliases": ["cangrelor", "kengrexal"]}, {"grupo": "Antiagregantes", "farmaco": "Tirofiban", "condicion": "-", "suspension_pre_procedimiento": "4-8 hrs", "reinicio_post_procedimiento": "NO", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["tirofiban", "aggrastat"]}, {"grupo": "Antiagregantes", "farmaco": "Cilostazol", "condicion": "-", "suspension_pre_procedimiento": "2 días", "reinicio_post_procedimiento": "6 hrs", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "8 hrs", "aliases": ["cilostazol", "cilosvitae", "clauter", "ilostal", "pletal"]}, {"grupo": "Cumarínicos", "farmaco": "Acenocumarol", "condicion": "-", "suspension_pre_procedimiento": "3 días + INR <1.5", "reinicio_post_procedimiento": "Post retiro", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["acenocumarol", "isquelium", "acebron", "neosintrom"]}, {"grupo": "Cumarínicos", "farmaco": "Warfarina", "condicion": "-", "suspension_pre_procedimiento": "5 días + INR <1.5", "reinicio_post_procedimiento": "Post retiro", "suspension_pre_retiro_cateter": "No requiere susp. en 1ras 12-24 hrs. De lo contrario 5 días + INR <1.5", "reinicio_post_retiro_cateter": "-", "aliases": ["warfarina", "cavamed", "coumadin"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "HNF", "condicion": "dosis baja sc 5000 c/12-8 hrs", "suspension_pre_procedimiento": "4-6 hrs", "reinicio_post_procedimiento": "1 hora", "suspension_pre_retiro_cateter": "4-6 hrs", "reinicio_post_retiro_cateter": "1 hr", "aliases": ["hnf", "heparina no fraccionada", "heparina sodica", "heparina sódica", "heparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "HNF", "condicion": "dosis sc 7500-1000", "suspension_pre_procedimiento": "12 hrs", "reinicio_post_procedimiento": "1 hora", "suspension_pre_retiro_cateter": "NO", "reinicio_post_retiro_cateter": "-", "aliases": ["hnf", "heparina no fraccionada", "heparina sodica", "heparina sódica", "heparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "HNF", "condicion": "Dosis alta SC", "suspension_pre_procedimiento": "24 hrs", "reinicio_post_procedimiento": "12 hrs", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["hnf", "heparina no fraccionada", "heparina sodica", "heparina sódica", "heparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "HNF", "condicion": "Dosis alta ev", "suspension_pre_procedimiento": "4-6 hrs", "reinicio_post_procedimiento": "1 hora", "suspension_pre_retiro_cateter": "4-6 hrs", "reinicio_post_retiro_cateter": "1 hr", "aliases": ["hnf", "heparina no fraccionada", "heparina sodica", "heparina sódica", "heparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Heparina Bajo Peso Molecular", "condicion": "Dosis baja", "suspension_pre_procedimiento": "12 hrs", "reinicio_post_procedimiento": "12 hrs (monodosis)", "suspension_pre_retiro_cateter": "12 hrs", "reinicio_post_retiro_cateter": "4 hrs", "aliases": ["hbpm", "heparina de bajo peso molecular", "enoxaparina", "clexane", "dalteparina", "fragmin", "nadroparina", "fraxiparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Heparina Bajo Peso Molecular", "condicion": "Dosis alta", "suspension_pre_procedimiento": "24 hrs", "reinicio_post_procedimiento": "24 o 48-72 hrs*", "suspension_pre_retiro_cateter": "NO", "reinicio_post_retiro_cateter": "4 hrs", "aliases": ["hbpm", "heparina de bajo peso molecular", "enoxaparina", "clexane", "dalteparina", "fragmin", "nadroparina", "fraxiparina"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Fondaparinux", "condicion": "Dosis Baja (2.5 mg) jóvenes", "suspension_pre_procedimiento": "36 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["fondaparinux", "arixtra"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Fondaparinux", "condicion": "Dosis Baja Ancianos", "suspension_pre_procedimiento": "48 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": null, "aliases": ["fondaparinux", "arixtra"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Fondaparinux", "condicion": "Dosis Baja ERC moderada", "suspension_pre_procedimiento": "58 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": null, "aliases": ["fondaparinux", "arixtra"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Fondaparinux", "condicion": "Dosis alta (5-10 mg) jovenes", "suspension_pre_procedimiento": "70 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": null, "aliases": ["fondaparinux", "arixtra"]}, {"grupo": "Heparinas \n\n(Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa ≤0.1 IU/mL)", "farmaco": "Fondaparinux", "condicion": "Dosis alta ancianos", "suspension_pre_procedimiento": "105 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": null, "aliases": ["fondaparinux", "arixtra"]}, {"grupo": "NOACs", "farmaco": "Rivaroxaban", "condicion": "Dosis baja", "suspension_pre_procedimiento": "24h (30h Clcr <30)", "reinicio_post_procedimiento": "6 hrs", "suspension_pre_retiro_cateter": "24 - 30 hrs", "reinicio_post_retiro_cateter": null, "aliases": ["rivaroxaban", "rivaroxabán", "xarelto", "rixovitae", "cotrien", "ribex", "rivoxa", "xaroban"]}, {"grupo": "NOACs", "farmaco": "Rivaroxaban", "condicion": "Dosis alta", "suspension_pre_procedimiento": "72 hrs", "reinicio_post_procedimiento": "24 hrs", "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": "-", "aliases": ["rivaroxaban", "rivaroxabán", "xarelto", "rixovitae", "cotrien", "ribex", "rivoxa", "xaroban"]}, {"grupo": "NOACs", "farmaco": "Apixaban", "condicion": "Dosis baja", "suspension_pre_procedimiento": "36 hrs", "reinicio_post_procedimiento": "6 hrs", "suspension_pre_retiro_cateter": "36 hrs", "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["apixaban", "eliquis", "alix", "corax", "apitena"]}, {"grupo": "NOACs", "farmaco": "Apixaban", "condicion": "Dosis alta", "suspension_pre_procedimiento": "72 hrs", "reinicio_post_procedimiento": "24 hrs", "suspension_pre_retiro_cateter": "72 hrs", "reinicio_post_retiro_cateter": "24 hrs", "aliases": ["apixaban", "eliquis", "alix", "corax", "apitena"]}, {"grupo": "NOACs", "farmaco": "Edoxaban", "condicion": "Dosis baja", "suspension_pre_procedimiento": "72 hrs", "reinicio_post_procedimiento": "24hrs", "suspension_pre_retiro_cateter": "20-28 hrs", "reinicio_post_retiro_cateter": "-", "aliases": ["edoxaban", "lixiana"]}, {"grupo": "I. Trombina", "farmaco": "Desirudin, Bivalirudin, Argatroban", "condicion": "-", "suspension_pre_procedimiento": "NO", "reinicio_post_procedimiento": "-", "suspension_pre_retiro_cateter": "-", "reinicio_post_retiro_cateter": "-", "aliases": ["desirudin", "bivalirudin", "bivalirudina", "argatroban", "angiomax", "angiox", "novastan"]}, {"grupo": "I. Trombina", "farmaco": "Dabigatran", "condicion": "Dosis Baja", "suspension_pre_procedimiento": "48 hrs", "reinicio_post_procedimiento": "6 hrs", "suspension_pre_retiro_cateter": "48 hrs", "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["dabigatran", "dabigatrán", "dabigatran etexilato", "pradaxa"]}, {"grupo": "I. Trombina", "farmaco": "Dabigatran", "condicion": "Dosis Alta", "suspension_pre_procedimiento": "120 hrs (5d)", "reinicio_post_procedimiento": "24 hrs", "suspension_pre_retiro_cateter": null, "reinicio_post_retiro_cateter": "24 hrs", "aliases": ["dabigatran", "dabigatrán", "dabigatran etexilato", "pradaxa"]}, {"grupo": "I. Trombina", "farmaco": "Dabigatran", "condicion": "ClCr >=50", "suspension_pre_procedimiento": "72 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": "34-36 hrs", "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["dabigatran", "dabigatrán", "dabigatran etexilato", "pradaxa"]}, {"grupo": "I. Trombina", "farmaco": "Dabigatran", "condicion": "ClCr 30-49", "suspension_pre_procedimiento": "120 hrs", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": "34-36 hrs", "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["dabigatran", "dabigatrán", "dabigatran etexilato", "pradaxa"]}, {"grupo": "I. Trombina", "farmaco": "Dabigatran", "condicion": "ClCr <30", "suspension_pre_procedimiento": "NO (niveles <30ng/ml)", "reinicio_post_procedimiento": null, "suspension_pre_retiro_cateter": "34-36 hrs", "reinicio_post_retiro_cateter": "6 hrs", "aliases": ["dabigatran", "dabigatrán", "dabigatran etexilato", "pradaxa"]}];

function normalizeText(value) {
  return (value || "")
    .toString()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .toLowerCase()
    .trim();
}

const grouped = {};
rawRecords.forEach(function(row) {
  const key = row.farmaco;
  if (!grouped[key]) {
    grouped[key] = {
      farmaco: row.farmaco,
      grupo: row.grupo,
      aliases: new Set(),
      rows: []
    };
  }
  (row.aliases || []).forEach(function(a) { grouped[key].aliases.add(a); });
  grouped[key].rows.push(row);
});

const drugs = Object.values(grouped).map(function(item) {
  return Object.assign({}, item, { aliases: Array.from(item.aliases) });
});

const searchableTerms = new Set();
drugs.forEach(function(drug) {
  searchableTerms.add(drug.farmaco);
  drug.aliases.forEach(function(alias) { searchableTerms.add(alias); });
});

const suggestions = document.getElementById("drugSuggestions");
Array.from(searchableTerms).sort(function(a,b) { return a.localeCompare(b, "es"); }).forEach(function(term) {
  const option = document.createElement("option");
  option.value = term;
  suggestions.appendChild(option);
});

const searchInput = document.getElementById("searchInput");
const resultsList = document.getElementById("resultsList");
const drugDetail = document.getElementById("drugDetail");
const hintBox = document.getElementById("hintBox");
const clearBtn = document.getElementById("clearBtn");

function matchDrug(drug, query) {
  const q = normalizeText(query);
  if (!q) return true;
  if (normalizeText(drug.farmaco).indexOf(q) !== -1) return true;
  return drug.aliases.some(function(alias) { return normalizeText(alias).indexOf(q) !== -1; });
}

function renderResults(query) {
  const q = normalizeText(query);
  resultsList.innerHTML = "";
  drugDetail.innerHTML = "";

  if (!q) {
    hintBox.classList.remove("d-none");
    return;
  }

  hintBox.classList.add("d-none");

  const matches = drugs.filter(function(drug) { return matchDrug(drug, q); })
    .sort(function(a,b) { return a.farmaco.localeCompare(b.farmaco, "es"); });

  if (!matches.length) {
    drugDetail.innerHTML = '<div class="alert alert-warning rounded-4">No encontré coincidencias con <strong>' + escapeHtml(query) + '</strong>.</div>';
    return;
  }

  if (matches.length === 1) {
    renderDrug(matches[0]);
    return;
  }

  matches.forEach(function(drug) {
    const btn = document.createElement("button");
    btn.className = "btn text-start result-row";
    btn.innerHTML =
      '<div class="d-flex justify-content-between align-items-start gap-2">' +
        '<div>' +
          '<div class="fw-semibold">' + escapeHtml(drug.farmaco) + '</div>' +
          '<div class="small text-muted">' + escapeHtml(drug.grupo) + '</div>' +
        '</div>' +
        '<span class="badge badge-soft rounded-pill">' + drug.rows.length + ' fila(s)</span>' +
      '</div>' +
      '<div class="mt-2 d-flex flex-wrap gap-1">' +
        drug.aliases.slice(0,6).map(function(alias) { return '<span class="badge text-bg-light brand-pill">' + escapeHtml(alias) + '</span>'; }).join("") +
      '</div>';
    btn.addEventListener("click", function() { renderDrug(drug); });
    resultsList.appendChild(btn);
  });
}

function renderDrug(drug) {
  resultsList.innerHTML = "";
  const aliasPills = drug.aliases
    .sort(function(a,b) { return a.localeCompare(b, "es"); })
    .map(function(alias) { return '<span class="badge text-bg-light border brand-pill">' + escapeHtml(alias) + '</span>'; })
    .join(" ");

  const rowsHtml = drug.rows.map(function(row) {
    return '<tr>' +
      '<td>' + escapeHtml(row.condicion || '-') + '</td>' +
      '<td>' + escapeHtml(row.suspension_pre_procedimiento || '-') + '</td>' +
      '<td>' + escapeHtml(row.reinicio_post_procedimiento || '-') + '</td>' +
      '<td>' + escapeHtml(row.suspension_pre_retiro_cateter || '-') + '</td>' +
      '<td>' + escapeHtml(row.reinicio_post_retiro_cateter || '-') + '</td>' +
    '</tr>';
  }).join("");

  drugDetail.innerHTML =
    '<div class="card drug-card">' +
      '<div class="card-body p-3 p-md-4">' +
        '<div class="d-flex justify-content-between align-items-start gap-2 mb-2">' +
          '<div>' +
            '<div class="small-label">Grupo</div>' +
            '<div class="fw-semibold">' + escapeHtml(drug.grupo) + '</div>' +
          '</div>' +
          '<button class="btn btn-sm btn-outline-secondary" type="button" id="newSearchBtn">Nueva búsqueda</button>' +
        '</div>' +
        '<h2 class="h4 mb-2">' + escapeHtml(drug.farmaco) + '</h2>' +
        '<div class="small-label mb-1">Principio activo / nombres buscables</div>' +
        '<div class="d-flex flex-wrap gap-1 mb-3">' + aliasPills + '</div>' +
        '<div class="table-responsive">' +
          '<table class="table table-sm align-middle small">' +
            '<thead class="table-light">' +
              '<tr>' +
                '<th>Condición</th>' +
                '<th>Suspensión pre procedimiento</th>' +
                '<th>Reinicio post procedimiento</th>' +
                '<th>Suspensión pre retiro de catéter</th>' +
                '<th>Reinicio post retiro de catéter</th>' +
              '</tr>' +
            '</thead>' +
            '<tbody>' + rowsHtml + '</tbody>' +
          '</table>' +
        '</div>' +
      '</div>' +
    '</div>';

  const newSearchBtn = document.getElementById("newSearchBtn");
  if (newSearchBtn) {
    newSearchBtn.addEventListener("click", function() {
      searchInput.focus();
      searchInput.select();
    });
  }
}

function escapeHtml(text) {
  return (text || "")
    .toString()
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

searchInput.addEventListener("input", function(e) { renderResults(e.target.value); });
searchInput.addEventListener("search", function(e) { renderResults(e.target.value); });
clearBtn.addEventListener("click", function() {
  searchInput.value = "";
  resultsList.innerHTML = "";
  drugDetail.innerHTML = "";
  hintBox.classList.remove("d-none");
  searchInput.focus();
});

const params = new URLSearchParams(window.location.search);
const initialQuery = params.get("q");
if (initialQuery) {
  searchInput.value = initialQuery;
  renderResults(initialQuery);
}
</script>


</div>

	<?php 
		//Cierre Conexión
		$conexion->close();
	?>


	<?php
		//Conexión
		require("footer.php");

	?>

