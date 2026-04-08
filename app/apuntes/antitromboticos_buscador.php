<?php
$titulo_info = "Utilidad Clínica";
$descripcion_info = "Buscador rápido de antitrombóticos para consulta perioperatoria y manejo alrededor de procedimientos y retiro de catéter. La información debe interpretarse siempre según riesgo trombótico, riesgo hemorrágico y contexto anestésico.";
$formula = "";
$referencias = array(
  "1.- ASRA/ESRA guidelines on regional anesthesia in the patient receiving antithrombotic or thrombolytic therapy.",
  "2.- ESAIC/ESRA joint European guidelines on regional anaesthesia in patients on antithrombotic drugs.",
  "3.- Protocolos locales de manejo perioperatorio de antitrombóticos y neuroeje."
);

$icono_apunte = "<i class='fa-solid fa-pills pe-3 pt-2'></i>";
$titulo_apunte = "Buscador de Antitrombóticos";

require("../conectar.php");
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button'><i class='fa-solid fa-circle-info'></i></button>";

require("head.php");
?>

<style>
:root{
  --brand:#27458f;
  --brand2:#3559b7;
  --bg:#f4f7fb;
  --soft:#f8fafc;
  --line:#dfe7f2;
  --text:#1f2a37;
  --muted:#667085;
}
.search-shell{max-width:980px;margin:0 auto;}
.apunte-card{
  border:0;
  border-radius:1.25rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  background:#fff;
  overflow:hidden;
}
.apunte-hero{
  background:linear-gradient(135deg,var(--brand),var(--brand2));
  color:#fff;
  padding:1.15rem 1.25rem;
}
.apunte-title{
  font-size:1.85rem;
  font-weight:800;
  line-height:1.15;
  display:flex;
  align-items:center;
}
.search-body{background:#fff;}
.sticky-search{
  position:sticky;
  top:0;
  z-index:20;
  background:rgba(255,255,255,.96);
  backdrop-filter:blur(8px);
  border-bottom:1px solid #e9eef5;
}
.search-input{
  border-radius:1rem 0 0 1rem !important;
  min-height:60px;
  font-size:1rem;
}
.search-clear{
  border-radius:0 1rem 1rem 0 !important;
  min-width:120px;
  font-weight:700;
}
.result-row{
  border:1px solid #e6e9ef !important;
  border-radius:1rem !important;
  background:#fff !important;
  padding:1rem !important;
}
.small-label{
  font-size:.8rem;
  text-transform:uppercase;
  letter-spacing:.08em;
  color:var(--muted);
  margin-bottom:.25rem;
}
.brand-pill{
  color:#1f2a37 !important;
  background:#f8fafc !important;
}
.hint-card{
  border:1px dashed #cbd5e1;
  border-radius:1rem;
  background:#f8fafc;
  padding:1rem;
  color:#64748b;
}
.info-box{
  background:#fff;
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  margin:1rem;
  overflow:hidden;
}
.info-box-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:1rem;
  padding:1rem;
}
.info-box-title{
  font-size:.8rem;
  text-transform:uppercase;
  color:#667085;
  letter-spacing:.08em;
}
.info-toggle-btn{
  border-radius:.6rem;
  font-size:.85rem;
  padding:.35rem .7rem;
  white-space:nowrap;
  background:#6c757d;
  border:none;
  color:white;
  transition:.2s;
}
.info-toggle-btn:hover{background:#5a6268;color:white;}
.info-box-content{
  padding:1rem;
  display:none;
  animation:fadeIn .2s ease-in-out;
  border-top:1px solid #e9eef5;
}
@keyframes fadeIn{
  from{opacity:0; transform:translateY(-5px);}
  to{opacity:1; transform:translateY(0);}
}

.drug-detail-card{
  border:1px solid var(--line);
  border-radius:1rem;
  background:var(--soft);
  overflow:hidden;
}
.desktop-table-wrap{display:block;}
.mobile-detail-list{display:none;}

.teaching-wrap{
  border:1px solid var(--line);
  border-radius:1.4rem;
  background:var(--soft);
  padding:1.25rem;
}
.teaching-title{
  font-size:1rem;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#64748b;
  text-align:center;
  margin-bottom:1rem;
}
.teaching-main{
  font-size:1.7rem;
  font-weight:800;
  text-align:center;
  color:#1f2a37;
  line-height:1.15;
  margin-bottom:1.2rem;
}
.teaching-grid{
  display:grid;
  grid-template-columns:1fr;
  gap:1rem;
}
.teaching-card{
  background:#fff;
  border-radius:1.25rem;
  padding:1.1rem 1rem;
  border:1px solid #e6e9ef;
  text-align:center;
}
.teaching-label{
  font-size:.78rem;
  letter-spacing:.08em;
  text-transform:uppercase;
  color:#667085;
  margin-bottom:.55rem;
}
.teaching-text{
  font-size:1rem;
  line-height:1.45;
  color:#1f2a37;
  font-weight:600;
}
.teaching-soft{
  font-size:.95rem;
  line-height:1.5;
  color:#667085;
  font-weight:500;
  margin-top:.35rem;
}
.mobile-card{
  display:none;
}
.mobile-card-item{
  border:1px solid #e6e9ef;
  border-radius:1rem;
  padding:1rem;
  background:#fff;
  margin-bottom:.85rem;
}
.mobile-card-item:last-child{margin-bottom:0;}
.mobile-row{
  display:flex;
  justify-content:space-between;
  gap:1rem;
  padding:.45rem 0;
  border-bottom:1px solid #eef2f6;
}
.mobile-row:last-child{border-bottom:none;}
.mobile-label{
  color:#667085;
  font-size:.86rem;
  font-weight:700;
  max-width:48%;
}
.mobile-value{
  color:#1f2a37;
  font-size:.92rem;
  text-align:right;
  font-weight:600;
  max-width:52%;
}
.footer-note{font-size:.82rem;color:#6c757d;}

@media (max-width:768px){
  .desktop-table-wrap{display:none;}
  .mobile-detail-list{display:block;}
  .search-clear{min-width:96px;}
  .apunte-title{font-size:1.5rem;}
  .teaching-main{font-size:1.35rem;}
}
@media (max-width:576px){
  .info-box{margin:1rem .75rem;}
  .info-box-header{flex-direction:row;}
  .info-toggle-btn{margin-left:auto;}
  .sticky-search{padding:.9rem !important;}
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="container-fluid px-0 px-md-2">
    <div class="search-shell">
      <div class="apunte-card mb-3">
        <div class="apunte-hero d-flex justify-content-between align-items-start gap-3">
          <div>
            <div class="small opacity-75 mb-1">APP clínica • utilidad interactiva</div>
            <div class="apunte-title">
              <?php echo $icono_apunte; ?>
              <span><?php echo $titulo_apunte; ?></span>
            </div>
          </div>
          <span class="badge rounded-pill text-bg-light text-dark fs-6">Apunte</span>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">
              Mostrar / ocultar
            </button>
          </div>

          <div id="infoContent" class="info-box-content">
            <?php echo $descripcion_info; ?>
            <?php if(!empty($formula)){ ?>
              <hr>
              <b>Fórmula:</b><br>
              <?php echo $formula; ?>
            <?php } ?>
            <?php if(!empty($referencias)){ ?>
              <hr>
              <b>Referencias:</b>
              <ul class="mt-2 mb-0">
                <?php foreach($referencias as $ref){ ?>
                  <li><?php echo $ref; ?></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </div>
        </div>

        <div class="search-body">
          <div class="sticky-search p-3">
            <div class="mb-2">
              <div class="text-muted small">Busca por principio activo o nombre comercial.</div>
            </div>
            <div class="input-group">
              <input id="searchInput" type="search" class="form-control search-input" placeholder="Ej: xarelto, eliquis, clopidogrel, clexane" list="drugSuggestions" autocomplete="off">
              <button class="btn btn-primary search-clear" id="clearBtn" type="button">Limpiar</button>
            </div>
            <datalist id="drugSuggestions"></datalist>
          </div>

          <div class="p-3">
            <div id="hintBox" class="hint-card">
              Escribe un fármaco o una marca registrada para ver la información de tu tabla.
            </div>

            <div id="resultsList" class="d-grid gap-2 mb-3"></div>
            <div id="drugDetail"></div>

            <div class="mt-4">
              <div class="teaching-wrap">
                <div class="teaching-title">Tips clínicos en anestesia</div>
                <div class="teaching-main">En antitrombóticos, la fecha de suspensión sola nunca basta</div>

                <div class="teaching-grid">
                  <div class="teaching-card">
                    <div class="teaching-label">Idea central</div>
                    <div class="teaching-text">Balancea riesgo trombótico y riesgo hemorrágico</div>
                    <div class="teaching-soft">No es lo mismo suspender un anticoagulante en fibrilación auricular estable que en trombosis reciente, prótesis valvular o síndrome coronario reciente.</div>
                  </div>

                  <div class="teaching-card">
                    <div class="teaching-label">Neuroeje</div>
                    <div class="teaching-text">Sé más conservador con catéteres y procedimientos neuroaxiales</div>
                    <div class="teaching-soft">El riesgo de hematoma epidural obliga a revisar con especial cuidado intervalos pre y post retiro de catéter.</div>
                  </div>

                  <div class="teaching-card">
                    <div class="teaching-label">Función renal</div>
                    <div class="teaching-text">La insuficiencia renal cambia los tiempos</div>
                    <div class="teaching-soft">Especialmente con DOACs y algunos inhibidores de trombina. Si el paciente es renal, sospecha acumulación y revisa clearance o eGFR.</div>
                  </div>

                  <div class="teaching-card">
                    <div class="teaching-label">No mirar solo el nombre</div>
                    <div class="teaching-text">Verifica dosis, indicación y momento real de última toma</div>
                    <div class="teaching-soft">Una misma droga puede tener conducta distinta si es dosis baja, alta, profiláctica o terapéutica.</div>
                  </div>

                  <div class="teaching-card">
                    <div class="teaching-label">Perla práctica</div>
                    <div class="teaching-text">Si el contexto es gris, piensa como si el riesgo fuera mayor</div>
                    <div class="teaching-soft">Cuando no tienes certeza sobre hora de última dosis, función renal o nivel de anticoagulación, conviene actuar con margen de seguridad.</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="footer-note mt-3">
              Herramienta docente y de apoyo clínico. La conducta definitiva debe individualizarse según procedimiento, riesgo trombótico, sangrado esperado y contexto del paciente.
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const rawRecords = [{"grupo":"Antiagregantes","farmaco":"Aspirina","condicion":"-","suspension_pre_procedimiento":"No requiere","reinicio_post_procedimiento":"No requiere","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["ácido acetilsalicílico","aspirina","cardioaspirina"]},{"grupo":"Antiagregantes","farmaco":"Clopidogrel","condicion":"-","suspension_pre_procedimiento":"5-7 días","reinicio_post_procedimiento":"Inmediata, excepto con dosis de carga: 6hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["clopidogrel","clopidogrel b","eurogrel","clopivitae","plavix"]},{"grupo":"Antiagregantes","farmaco":"Prasugrel","condicion":"-","suspension_pre_procedimiento":"7-10 días","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["prasugrel","efient"]},{"grupo":"Antiagregantes","farmaco":"Ticagrelor","condicion":"-","suspension_pre_procedimiento":"5 días","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["ticagrelor","brilinta"]},{"grupo":"Antiagregantes","farmaco":"Dipiridamol","condicion":"-","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["dipiridamol","persantin"]},{"grupo":"Antiagregantes","farmaco":"Cangrelor","condicion":"-","suspension_pre_procedimiento":"3 hrs","reinicio_post_procedimiento":"8 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"8 hrs","aliases":["cangrelor","kengrexal"]},{"grupo":"Antiagregantes","farmaco":"Tirofiban","condicion":"-","suspension_pre_procedimiento":"4-8 hrs","reinicio_post_procedimiento":"NO","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["tirofiban","aggrastat"]},{"grupo":"Antiagregantes","farmaco":"Cilostazol","condicion":"-","suspension_pre_procedimiento":"2 días","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"8 hrs","aliases":["cilostazol","cilosvitae","clauter","ilostal","pletal"]},{"grupo":"Cumarínicos","farmaco":"Acenocumarol","condicion":"-","suspension_pre_procedimiento":"3 días + INR <1.5","reinicio_post_procedimiento":"Post retiro","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["acenocumarol","isquelium","acebron","neosintrom"]},{"grupo":"Cumarínicos","farmaco":"Warfarina","condicion":"-","suspension_pre_procedimiento":"5 días + INR <1.5","reinicio_post_procedimiento":"Post retiro","suspension_pre_retiro_cateter":"No requiere susp. en 1ras 12-24 hrs. De lo contrario 5 días + INR <1.5","reinicio_post_retiro_cateter":"-","aliases":["warfarina","cavamed","coumadin"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"dosis baja sc 5000 c/12-8 hrs","suspension_pre_procedimiento":"4-6 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"4-6 hrs","reinicio_post_retiro_cateter":"1 hr","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"dosis sc 7500-1000","suspension_pre_procedimiento":"12 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"NO","reinicio_post_retiro_cateter":"-","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"Dosis alta SC","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"12 hrs","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"HNF","condicion":"Dosis alta ev","suspension_pre_procedimiento":"4-6 hrs","reinicio_post_procedimiento":"1 hora","suspension_pre_retiro_cateter":"4-6 hrs","reinicio_post_retiro_cateter":"1 hr","aliases":["hnf","heparina no fraccionada","heparina sodica","heparina sódica","heparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Heparina Bajo Peso Molecular","condicion":"Dosis baja","suspension_pre_procedimiento":"12 hrs","reinicio_post_procedimiento":"12 hrs (monodosis)","suspension_pre_retiro_cateter":"12 hrs","reinicio_post_retiro_cateter":"4 hrs","aliases":["hbpm","heparina de bajo peso molecular","enoxaparina","clexane","dalteparina","fragmin","nadroparina","fraxiparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Heparina Bajo Peso Molecular","condicion":"Dosis alta","suspension_pre_procedimiento":"24 hrs","reinicio_post_procedimiento":"24 o 48-72 hrs*","suspension_pre_retiro_cateter":"NO","reinicio_post_retiro_cateter":"4 hrs","aliases":["hbpm","heparina de bajo peso molecular","enoxaparina","clexane","dalteparina","fragmin","nadroparina","fraxiparina"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis Baja (2.5 mg) jovenes","suspension_pre_procedimiento":"36 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":"6 hrs","aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis Baja Ancianos","suspension_pre_procedimiento":"48 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis Baja ERC moderada","suspension_pre_procedimiento":"58 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis alta (5-10 mg) jovenes","suspension_pre_procedimiento":"70 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"Heparinas (Nivel plasmático de DOAC <30 ng/mL o una actividad anti-Xa <=0.1 IU/mL)","farmaco":"Fondaparinux","condicion":"Dosis alta ancianos","suspension_pre_procedimiento":"105 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":null,"aliases":["fondaparinux","arixtra"]},{"grupo":"NOACs","farmaco":"Rivaroxaban","condicion":"Dosis baja","suspension_pre_procedimiento":"24h (30h Clcr <30)","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"24 - 30 hrs","reinicio_post_retiro_cateter":null,"aliases":["rivaroxaban","rivaroxabán","xarelto","rixovitae","cotrien","ribex","rivoxa","xaroban"]},{"grupo":"NOACs","farmaco":"Rivaroxaban","condicion":"Dosis alta","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":"-","aliases":["rivaroxaban","rivaroxabán","xarelto","rixovitae","cotrien","ribex","rivoxa","xaroban"]},{"grupo":"NOACs","farmaco":"Apixaban","condicion":"Dosis baja","suspension_pre_procedimiento":"36 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["apixaban","eliquis","alix","corax","apitena"]},{"grupo":"NOACs","farmaco":"Apixaban","condicion":"Dosis alta","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":"72 hrs","reinicio_post_retiro_cateter":"24 hrs","aliases":["apixaban","eliquis","alix","corax","apitena"]},{"grupo":"NOACs","farmaco":"Edoxaban","condicion":"Dosis baja","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":"24hrs","suspension_pre_retiro_cateter":"20-28 hrs","reinicio_post_retiro_cateter":"-","aliases":["edoxaban","lixiana"]},{"grupo":"I. Trombina","farmaco":"Desirudin, Bivalirudin, Argatroban","condicion":"-","suspension_pre_procedimiento":"NO","reinicio_post_procedimiento":"-","suspension_pre_retiro_cateter":"-","reinicio_post_retiro_cateter":"-","aliases":["desirudin","bivalirudin","bivalirudina","argatroban","angiomax","angiox","novastan"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"Dosis Baja","suspension_pre_procedimiento":"48 hrs","reinicio_post_procedimiento":"6 hrs","suspension_pre_retiro_cateter":"48 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"Dosis Alta","suspension_pre_procedimiento":"120 hrs (5d)","reinicio_post_procedimiento":"24 hrs","suspension_pre_retiro_cateter":null,"reinicio_post_retiro_cateter":"24 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr >=50","suspension_pre_procedimiento":"72 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr 30-49","suspension_pre_procedimiento":"120 hrs","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]},{"grupo":"I. Trombina","farmaco":"Dabigatran","condicion":"ClCr <30","suspension_pre_procedimiento":"NO (niveles <30ng/ml)","reinicio_post_procedimiento":null,"suspension_pre_retiro_cateter":"34-36 hrs","reinicio_post_retiro_cateter":"6 hrs","aliases":["dabigatran","dabigatrán","dabigatran etexilato","pradaxa"]}];

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

function rowToMobileCard(row){
  return '<div class="mobile-card-item">' +
    '<div class="mobile-row"><div class="mobile-label">Condición</div><div class="mobile-value">' + escapeHtml(row.condicion || '-') + '</div></div>' +
    '<div class="mobile-row"><div class="mobile-label">Suspensión pre procedimiento</div><div class="mobile-value">' + escapeHtml(row.suspension_pre_procedimiento || '-') + '</div></div>' +
    '<div class="mobile-row"><div class="mobile-label">Reinicio post procedimiento</div><div class="mobile-value">' + escapeHtml(row.reinicio_post_procedimiento || '-') + '</div></div>' +
    '<div class="mobile-row"><div class="mobile-label">Suspensión pre retiro catéter</div><div class="mobile-value">' + escapeHtml(row.suspension_pre_retiro_cateter || '-') + '</div></div>' +
    '<div class="mobile-row"><div class="mobile-label">Reinicio post retiro catéter</div><div class="mobile-value">' + escapeHtml(row.reinicio_post_retiro_cateter || '-') + '</div></div>' +
  '</div>';
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

  const mobileCards = drug.rows.map(rowToMobileCard).join("");

  drugDetail.innerHTML =
    '<div class="drug-detail-card">' +
      '<div class="card-body p-3 p-md-4">' +
        '<div class="d-flex justify-content-between align-items-start gap-2 mb-2 flex-wrap">' +
          '<div>' +
            '<div class="small-label">Grupo</div>' +
            '<div class="fw-semibold">' + escapeHtml(drug.grupo) + '</div>' +
          '</div>' +
          '<button class="btn btn-sm btn-outline-secondary" type="button" id="newSearchBtn">Nueva búsqueda</button>' +
        '</div>' +
        '<h2 class="h4 mb-2">' + escapeHtml(drug.farmaco) + '</h2>' +
        '<div class="small-label mb-1">Principio activo / nombres buscables</div>' +
        '<div class="d-flex flex-wrap gap-1 mb-3">' + aliasPills + '</div>' +
        '<div class="desktop-table-wrap table-responsive">' +
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
        '<div class="mobile-detail-list">' + mobileCards + '</div>' +
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
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "none" || box.style.display === "") ? "block" : "none";
}
</script>

<?php
$conexion->close();
require("footer.php");
?>
