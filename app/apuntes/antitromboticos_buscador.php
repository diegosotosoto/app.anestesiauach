<?php
$titulo_info = "Utilidad Clínica";
$descripcion_info = "Buscador rápido de antitrombóticos para consulta perioperatoria y manejo alrededor de procedimientos y retiro de catéter. La información debe interpretarse siempre según riesgo trombótico, riesgo hemorrágico, función renal y contexto anestésico.";
$formula = "";
$referencias = array(
  "1.- ASRA/ESRA guidelines on regional anesthesia in the patient receiving antithrombotic or thrombolytic therapy.",
  "2.- ESAIC/ESRA joint European guidelines on regional anaesthesia in patients on antithrombotic drugs.",
  "3.- Protocolos locales de manejo perioperatorio de antitrombóticos y neuroeje."
);

$icono_apunte = "<i class='fa-solid fa-pills pe-3 pt-2'></i>";
$titulo_apunte = "Buscador de Antitrombóticos";

require("../conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8");

$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">

<style>
.antitrombo-search-card{
  background:var(--note-card);
  border-radius:var(--note-radius-lg);
  box-shadow:var(--note-shadow);
  overflow:hidden;
  margin-bottom:1rem;
}

.antitrombo-search-head{
  padding:1rem;
  border-bottom:1px solid #e9eef5;
}

.antitrombo-input-row{
  display:flex;
  align-items:stretch;
  width:100%;
  gap:0;
}

.antitrombo-search-input{
  min-width:0;
  flex:1 1 auto;
  min-height:46px;
  border:1px solid #d0d5dd;
  border-right:none;
  border-radius:.9rem 0 0 .9rem;
  padding:.65rem .85rem;
  font-size:.95rem;
  color:#101828;
  background:#fff;
}

.antitrombo-search-input:focus{
  outline:none;
  border-color:#2b6dd6;
  box-shadow:0 0 0 3px rgba(43,109,214,.12);
  position:relative;
  z-index:1;
}

.antitrombo-clear-btn{
  flex:0 0 auto;
  min-width:86px;
  border-radius:0 .9rem .9rem 0 !important;
  font-weight:700;
}

.antitrombo-hint{
  border:1px dashed #cbd5e1;
  border-radius:1rem;
  background:#f8fafc;
  padding:.9rem 1rem;
  color:#64748b;
}

.antitrombo-result-btn{
  display:block;
  width:100%;
  border:0;
  text-align:left;
  padding:0;
  background:transparent;
}

.antitrombo-result-btn .result-row{
  margin-bottom:0;
  width:100%;
  min-width:0;
}

.antitrombo-result-btn:focus-visible .result-row,
.antitrombo-result-btn:hover .result-row{
  border-color:#bfd4f8;
  box-shadow:0 0 0 3px rgba(47,128,237,.12);
}

.antitrombo-detail-card{
  background:var(--note-card);
  border-radius:var(--note-radius-lg);
  box-shadow:var(--note-shadow);
  overflow:hidden;
  border:1px solid var(--note-line);
  max-width:100%;
}

.antitrombo-detail-head{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:1rem;
  flex-wrap:wrap;
}

.antitrombo-detail-list{
  display:grid;
  gap:.9rem;
}

.antitrombo-mobile-item{
  border:1px solid var(--note-line-strong);
  border-radius:1rem;
  background:#fff;
  padding:.85rem;
  min-width:0;
  box-shadow:0 3px 10px rgba(15,23,42,.035);
}

.antitrombo-mobile-row{
  display:grid;
  grid-template-columns:1fr;
  gap:.42rem;
  padding:.68rem 0;
  border-bottom:1px solid #eef2f6;
  align-items:center;
  text-align:center;
}

.antitrombo-mobile-row:first-child{
  padding-top:0;
}

.antitrombo-mobile-row:last-child{
  border-bottom:none;
  padding-bottom:0;
}

.antitrombo-mobile-label{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:.42rem;
  width:fit-content;
  max-width:100%;
  margin:0 auto;
  padding:.28rem .62rem;
  border-radius:999px;
  background:#eef3ff;
  color:#1f2a37;
  font-size:.82rem;
  font-weight:800;
  line-height:1.15;
  min-width:0;
  overflow-wrap:anywhere;
}

.antitrombo-mobile-label i{
  font-size:.82rem;
  color:#1f2a37;
}

body.theme-dark .note-shell .antitrombo-mobile-label,
body.ui-nocturno .note-shell .antitrombo-mobile-label{
  color:#030712 !important;
}

body.theme-dark .note-shell .antitrombo-mobile-label i,
body.ui-nocturno .note-shell .antitrombo-mobile-label i{
  color:#030712 !important;
}

.antitrombo-mobile-value{
  color:var(--note-text);
  font-size:1rem;
  line-height:1.3;
  text-align:center;
  font-weight:800;
  min-width:0;
  overflow-wrap:anywhere;
  word-break:normal;
}

.antitrombo-mobile-value.is-empty{
  color:var(--note-muted);
  font-weight:700;
}

.antitrombo-group-tag{
  background:#eef3ff;
  color:#3559b7;
}

.antitrombo-note-grid{
  display:grid;
  grid-template-columns:minmax(0,1.1fr) minmax(280px,.9fr);
  gap:1rem;
  align-items:start;
}

.antitrombo-note-grid > *{
  min-width:0;
}

.antitrombo-compact-side{
  display:grid;
  gap:1rem;
}

.antitrombo-alias-wrap{
  display:flex;
  flex-wrap:wrap;
  gap:.28rem;
  max-width:100%;
}

.antitrombo-alias-wrap .note-tag{
  max-width:100%;
  overflow-wrap:anywhere;
}

@media (max-width:991px){
  .antitrombo-note-grid{
    grid-template-columns:1fr;
  }
}

@media (max-width:576px){
  .antitrombo-search-head{
    padding:.85rem;
  }

  .antitrombo-clear-btn{
    min-width:76px;
    padding-left:.55rem;
    padding-right:.55rem;
  }

  .antitrombo-mobile-row{
    grid-template-columns:1fr;
    gap:.18rem;
  }

  .antitrombo-mobile-value{
    font-size:.94rem;
  }

  .antitrombo-detail-head{
    gap:.65rem;
  }
}
</style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="container-fluid px-0 px-md-2">
    <div class="note-shell">
      <div class="note-hero mb-3">
        <div class="note-hero-kicker">APP CLÍNICA · HEMOSTASIA · NEUROEJE</div>
        <h2>Buscador de Antitrombóticos</h2>
        <div class="note-hero-subtitle">Consulta rápida por principio activo o marca para orientar suspensión y reinicio perioperatorio.</div>
      </div>

      <div class="info-box mb-3">
        <div class="info-box-header">
          <div class="info-box-title">Información</div>
          <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
        </div>
        <div id="infoContent" class="info-box-content">
          <p class="mb-2"><?php echo $descripcion_info; ?></p>
          <?php if(!empty($formula)){ ?>
            <hr>
            <b>Fórmula:</b><br>
            <?php echo $formula; ?>
          <?php } ?>
          <hr>
          <div class="small-note mb-2"><strong>Punto crítico:</strong> la conducta depende del fármaco, dosis, indicación, función renal, tipo de procedimiento y presencia de neuroeje/catéter.</div>
          <?php if(!empty($referencias)){ ?>
            <hr>
            <b>Referencias:</b>
            <ul class="mt-2 mb-0 ps-3">
              <?php foreach($referencias as $ref){ ?>
                <li class="mb-1"><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      </div>

      <div class="antitrombo-search-card">
        <div class="antitrombo-search-head">
          <div class="note-section-label mb-2">Búsqueda</div>
          <div class="note-muted mb-2">Busca por principio activo o nombre comercial.</div>
          <div class="antitrombo-input-row">
            <input id="searchInput" type="search" class="antitrombo-search-input" placeholder="Ej: xarelto, eliquis, clopidogrel, clexane" list="drugSuggestions" autocomplete="off">
            <button class="btn btn-app-primary antitrombo-clear-btn" id="clearBtn" type="button">Limpiar</button>
          </div>
          <datalist id="drugSuggestions"></datalist>
        </div>

        <div class="note-card-body p-3 p-md-4">
          <div class="antitrombo-note-grid">
            <div>
              <div id="hintBox" class="antitrombo-hint mb-3">
                Escribe un fármaco o una marca registrada para ver la información de tu tabla.
              </div>

              <div id="summaryCard" class="note-summary-box mb-3 note-hidden">
                <div class="note-summary-box-title">Resumen de búsqueda</div>
                <div class="note-summary-box-text mb-0" id="summaryText">Sin búsqueda activa.</div>
              </div>

              <div id="resultsList" class="d-grid gap-2 mb-3"></div>
              <div id="drugDetail"></div>
            </div>

            <div>
              <div id="warningBox" class="note-warning mb-3">
                <div class="note-card-title mb-2"><i class="fa-solid fa-triangle-exclamation me-2"></i>Advertencia visible</div>
                <div class="small-note mb-0">No tomes la fecha de suspensión como decisión aislada. Verifica riesgo trombótico, riesgo hemorrágico, función renal, indicación, dosis real y presencia de catéter/neuroeje.</div>
              </div>

              <div class="note-interpretation mb-3">
                <div class="note-interpretation-label">Interpretación</div>
                <div class="note-interpretation-main">La misma droga puede tener conductas distintas según dosis y contexto</div>
                <div class="note-interpretation-soft">Una fila encontrada no reemplaza el juicio clínico ni los protocolos locales.</div>
              </div>

              <div class="note-teaching-wrap">
                <div class="note-teaching-title">Tips clínicos en anestesia</div>
                <div class="note-teaching-main">En antitrombóticos, la fecha de suspensión sola nunca basta</div>

                <div class="note-tips">
                  <div class="note-card-title">Qué mirar primero</div>
                  <div class="small-note mb-0">Balancea riesgo trombótico y riesgo hemorrágico. No es lo mismo fibrilación auricular estable que trombosis reciente, prótesis valvular o síndrome coronario reciente.</div>
                </div>

                <div class="note-tips">
                  <div class="note-card-title">Neuroeje y catéter</div>
                  <div class="small-note mb-0">Sé más conservador con procedimientos neuroaxiales y con el retiro de catéter. El riesgo de hematoma epidural exige revisar intervalos pre y post retiro con especial cuidado.</div>
                </div>

                <div class="note-tips">
                  <div class="note-card-title">Función renal</div>
                  <div class="small-note mb-0">La insuficiencia renal cambia los tiempos, sobre todo con DOACs e inhibidores de trombina. Si el paciente es renal, sospecha acumulación y revisa clearance o eGFR.</div>
                </div>

                <div class="note-tips mb-0">
                  <div class="note-card-title">Perla práctica</div>
                  <div class="small-note mb-0">Si no tienes certeza de la última dosis, indicación, nivel anticoagulante o función renal, conviene actuar con margen de seguridad y escalar la discusión.</div>
                </div>
              </div>
            </div>
          </div>

          <div class="note-footer mt-3">
            Herramienta docente y de apoyo clínico. La conducta definitiva debe individualizarse según procedimiento, riesgo trombótico, sangrado esperado y contexto del paciente.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/clinical-note-system.js?v=2"></script>
<script>
const rawRecords = [{"grupo":"Antiagregantes","farmaco":"Aspirina","condicion":"-","suspension_pre_procedimiento":"No requiere","reinicio_post_procedimiento":"No requiere","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["ácido acetilsalicílico","aspirina","cardioaspirina"]},{"grupo":"Antiagregantes","farmaco":"Clopidogrel","condicion":"-","suspension_pre_procedimiento":"5-7 días","reinicio_post_procedimiento":"Inmediata, excepto con dosis de carga: 6hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["clopidogrel","clopidogrel b","eurogrel","clopivitae","plavix"]},{"grupo":"Antiagregantes","farmaco":"Prasugrel","condicion":"-","suspension_pre_procedimiento":"7-10 días","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["prasugrel","efient"]},{"grupo":"Antiagregantes","farmaco":"Ticagrelor","condicion":"-","suspension_pre_procedimiento":"5 días","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["ticagrelor","brilinta"]},{"grupo":"Antiagregantes","farmaco":"Dipiridamol","condicion":"-","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["dipiridamol","persantin"]},{"grupo":"Antiagregantes","farmaco":"Cangrelor","condicion":"-","suspension_pre_procedimiento":"3 hrs","reinicio_post_procedimiento":"8 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"8 hrs","aliases":["cangrelor","kengrexal"]},{"grupo":"Antiagregantes","farmaco":"Tirofiban","condicion":"-","suspension_pre_procedimiento":"4-8 hrs","reinicio_post_procedimiento":"NO","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["tirofiban","aggrastat"]},{"grupo":"Antiagregantes","farmaco":"Cilostazol","condicion":"-","suspension_pre_procedimiento":"2 días","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"8 hrs","aliases":["cilostazol","cilosvitae","clauter","ilostal","pletal"]},{"grupo":"Cumarínicos","farmaco":"Acenocumarol","condicion":"-","suspension_pre_procedimiento":"3 días + INR <1.5","reinicio_post_procedimiento":"Post retiro","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["acenocumarol","isquelium","acebron","neosintrom"]},{"grupo":"Cumarínicos","farmaco":"Warfarina","condicion":"-","suspension_pre_procedimiento":"5 días + INR <1.5","reinicio_post_procedimiento":"Post retiro","suspension_pre_retiro_cateter":"No requiere susp. en 1ras 12-24 hrs. De lo contrario 5 días + INR <1.5","reinicio_post_retiro_cateter":"-","aliases":["warfarina","cavamed","coumadin"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"dosis baja sc 5000 c/12-8 hrs","suspension_pre_procedimiento":"4-6 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"4-6 hrs","reinicio_post_retiro_cateter":"1 hr","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"dosis sc 7500-1000","suspension_pre_procedimiento":"12 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"NO","reinicio_post_retiro_cateter":"-","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"Dosis alta SC","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"12 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"Dosis alta ev","suspension_pre_procedimiento":"4-6 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"4-6 hrs","reinicio_post_retiro_cateter":"1 hr","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Heparina Bajo Peso Molecular","condicion":"Dosis baja","suspension_pre_procedimiento":"12 hrs","reinicio_post_procedimiento":"12 hrs (monodosis)","suspension_pre_retiro_cateter":"12 hrs","reinicio_post_retiro_cateter":"4 hrs","aliases":["hbpm","heparina de bajo peso molecular","enoxaparina","clexane","dalteparina","fragmin","nadroparina","fraxiparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Heparina Bajo Peso Molecular","condicion":"Dosis alta","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"24 o 48-72 hrs*","suspension_pre_retiro_cateter":"24 hrs","reinicio_post_retiro_cateter":"4 hrs","aliases":["hbpm","heparina de bajo peso molecular","enoxaparina","clexane","dalteparina","fragmin","nadroparina","fraxiparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis baja","suspension_pre_procedimiento":"36-42 hrs","reinicio_post_procedimiento":"6-12 hrs","suspension_pre_retiro_cateter":"36-42 hrs","reinicio_post_retiro_cateter":"6-12 hrs","aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis alta","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis alta ancianos","suspension_pre_procedimiento":"105 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"NOACs","farmaco":"Rivaroxaban","condicion":"Dosis baja","suspension_pre_procedimiento":"24h (30h Clcr <30)","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"24 - 30 hrs","reinicio_post_retiro_cateter":null,"aliases":["rivaroxaban","rivaroxabán","xarelto","rixovitae","cotrien","ribex","rivoxa","xaroban"]},{"grupo":"NOACs","farmaco":"Rivaroxaban","condicion":"Dosis alta","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":"-","aliases":["rivaroxaban","rivaroxabán","xarelto","rixovitae","cotrien","ribex","rivoxa","xaroban"]},{"grupo":"NOACs","farmaco":"Apixaban","condicion":"Dosis baja","suspension_pre_procedimiento":"36 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["apixaban","eliquis","alix","corax","apitena"]},{"grupo":"NOACs","farmaco":"Apixaban","condicion":"Dosis alta","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":"72 hrs","reinicio_post_retiro_cateter":"24 hrs","aliases":["apixaban","eliquis","alix","corax","apitena"]},{"grupo":"NOACs","farmaco":"Edoxaban","condicion":"Dosis baja","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24hrs","suspension_pre_retiro_cateter":"20-28 hrs","reinicio_post_retiro_cateter":"-","aliases":["edoxaban","lixiana"]},{"grupo":"I. Trombina","farmaco":"Desirudin, Bivalirudin, Argatroban","condicion":"-","suspension_pre_procedimiento":"NO","reinicio_post_procedimiento":"-","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["desirudin","bivalirudin","bivalirudina","argatroban","angiomax","angiox","novastan"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"Dosis Baja","suspension_pre_procedimiento":"48 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"48 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"Dosis Alta","suspension_pre_procedimiento":"120 hrs (5d)","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":"24 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr >=50","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr 30-49","suspension_pre_procedimiento":"120 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr <30","suspension_pre_procedimiento":"NO (niveles <30ng/ml)","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]}];

function normalizeText(value){
  return (value || '')
    .toString()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .trim();
}

function escapeHtml(text){
  return (text || '')
    .toString()
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

const grouped = {};
rawRecords.forEach(function(row){
  const key = row.farmaco;
  if(!grouped[key]){
    grouped[key] = { farmaco: row.farmaco, grupo: row.grupo, aliases: new Set(), rows: [] };
  }
  (row.aliases || []).forEach(function(alias){ grouped[key].aliases.add(alias); });
  grouped[key].rows.push(row);
});

const drugs = Object.values(grouped).map(function(item){
  return Object.assign({}, item, { aliases: Array.from(item.aliases) });
});

const suggestions = document.getElementById('drugSuggestions');
const searchInput = document.getElementById('searchInput');
const resultsList = document.getElementById('resultsList');
const drugDetail = document.getElementById('drugDetail');
const hintBox = document.getElementById('hintBox');
const clearBtn = document.getElementById('clearBtn');
const summaryCard = document.getElementById('summaryCard');
const summaryText = document.getElementById('summaryText');

(function fillSuggestions(){
  const terms = new Set();
  drugs.forEach(function(drug){
    terms.add(drug.farmaco);
    drug.aliases.forEach(function(alias){ terms.add(alias); });
  });
  Array.from(terms).sort(function(a, b){ return a.localeCompare(b, 'es'); }).forEach(function(term){
    const option = document.createElement('option');
    option.value = term;
    suggestions.appendChild(option);
  });
})();

function matchDrug(drug, query){
  const q = normalizeText(query);
  if(!q) return true;
  if(normalizeText(drug.farmaco).includes(q)) return true;
  return drug.aliases.some(function(alias){ return normalizeText(alias).includes(q); });
}

function updateSummary(query, matches){
  if(!query){
    summaryCard.classList.add('note-hidden');
    summaryText.textContent = 'Sin búsqueda activa.';
    return;
  }
  summaryCard.classList.remove('note-hidden');
  summaryText.textContent = matches.length === 1
    ? '1 coincidencia para "' + query + '"'
    : matches.length + ' coincidencias para "' + query + '"';
}

function renderResults(query){
  const q = normalizeText(query);
  resultsList.innerHTML = '';
  drugDetail.innerHTML = '';

  if(!q){
    hintBox.classList.remove('d-none');
    updateSummary('', []);
    return;
  }

  const matches = drugs
    .filter(function(drug){ return matchDrug(drug, q); })
    .sort(function(a, b){ return a.farmaco.localeCompare(b.farmaco, 'es'); });

  hintBox.classList.add('d-none');
  updateSummary(query, matches);

  if(!matches.length){
    drugDetail.innerHTML = '<div class="note-warning"><div class="note-card-title mb-1">Sin coincidencias</div><div class="small-note mb-0">No encontré coincidencias con <strong>' + escapeHtml(query) + '</strong>.</div></div>';
    return;
  }

  if(matches.length === 1){
    renderDrug(matches[0]);
    return;
  }

  matches.forEach(function(drug){
    const aliasPills = drug.aliases.slice(0, 6).map(function(alias){
      return '<span class="note-tag note-tag-gray">' + escapeHtml(alias) + '</span>';
    }).join(' ');

    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'antitrombo-result-btn';
    button.innerHTML =
      '<div class="result-row">' +
        '<div>' +
          '<div class="result-name">' + escapeHtml(drug.farmaco) + '</div>' +
          '<div class="result-note mt-1">' + escapeHtml(drug.grupo) + '</div>' +
          '<div class="mt-2 d-flex flex-wrap gap-1">' + aliasPills + '</div>' +
        '</div>' +
        '<div class="note-result-value"><span class="note-tag antitrombo-group-tag">' + drug.rows.length + ' fila(s)</span></div>' +
      '</div>';
    button.addEventListener('click', function(){ renderDrug(drug); });
    resultsList.appendChild(button);
  });
}

function detailRow(icon, label, value){
  const cleanValue = value || '-';
  const emptyClass = cleanValue === '-' ? ' is-empty' : '';
  return '<div class="antitrombo-mobile-row">' +
    '<div class="antitrombo-mobile-label"><i class="fa-solid ' + icon + '"></i>' + escapeHtml(label) + '</div>' +
    '<div class="antitrombo-mobile-value' + emptyClass + '">' + escapeHtml(cleanValue) + '</div>' +
  '</div>';
}

function rowToMobileCard(row){
  return '<div class="antitrombo-mobile-item">' +
    detailRow('fa-circle-info', 'Condición', row.condicion || '-') +
    detailRow('fa-pause', 'Suspensión pre procedimiento', row.suspension_pre_procedimiento || '-') +
    detailRow('fa-play', 'Reinicio post procedimiento', row.reinicio_post_procedimiento || '-') +
    detailRow('fa-syringe', 'Suspensión pre retiro catéter', row.suspension_pre_retiro_cateter || '-') +
    detailRow('fa-rotate-right', 'Reinicio post retiro catéter', row.reinicio_post_retiro_cateter || '-') +
  '</div>';
}

function renderDrug(drug){
  resultsList.innerHTML = '';

  const aliasPills = drug.aliases
    .sort(function(a, b){ return a.localeCompare(b, 'es'); })
    .map(function(alias){ return '<span class="note-tag note-tag-gray">' + escapeHtml(alias) + '</span>'; })
    .join('');

  const intervalCards = drug.rows.map(rowToMobileCard).join('');

  drugDetail.innerHTML =
    '<div class="antitrombo-detail-card">' +
      '<div class="note-card-body p-3 p-md-4">' +
        '<div class="antitrombo-detail-head mb-3">' +
          '<div>' +
            '<div class="note-section-label mb-1">Grupo</div>' +
            '<div class="note-card-title mb-1">' + escapeHtml(drug.farmaco) + '</div>' +
            '<div class="d-flex flex-wrap gap-2 align-items-center mb-2">' +
              '<span class="note-tag antitrombo-group-tag">' + escapeHtml(drug.grupo) + '</span>' +
            '</div>' +
            '<div class="note-muted">Principio activo / nombres buscables</div>' +
          '</div>' +
          '<button class="btn btn-sm btn-outline-secondary" type="button" id="newSearchBtn">Nueva búsqueda</button>' +
        '</div>' +
        '<div class="antitrombo-alias-wrap mb-3">' + aliasPills + '</div>' +
        '<div class="note-section-label">Intervalos orientativos</div>' +
        '<div class="antitrombo-detail-list">' + intervalCards + '</div>' +
      '</div>' +
    '</div>';

  const newSearchBtn = document.getElementById('newSearchBtn');
  if(newSearchBtn){
    newSearchBtn.addEventListener('click', function(){
      searchInput.focus();
      searchInput.select();
    });
  }
}

searchInput.addEventListener('input', function(e){ renderResults(e.target.value); });
searchInput.addEventListener('search', function(e){ renderResults(e.target.value); });
clearBtn.addEventListener('click', function(){
  searchInput.value = '';
  resultsList.innerHTML = '';
  drugDetail.innerHTML = '';
  hintBox.classList.remove('d-none');
  updateSummary('', []);
  searchInput.focus();
});

const params = new URLSearchParams(window.location.search);
const initialQuery = params.get('q');
if(initialQuery){
  searchInput.value = initialQuery;
  renderResults(initialQuery);
} else {
  updateSummary('', []);
}
</script>

<?php
$conexion->close();
require("../footer.php");
?>
