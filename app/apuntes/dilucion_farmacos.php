<?php
$titulo_pagina = "Dilución de Fármacos";
$navbar_titulo = "Apuntes";
$boton_toggler = "<a class='d-sm-block d-sm-none admin-back-btn' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar = "<span class='text-white'>Apuntes</span>";
$boton_navbar = "<button class='app-nav-action' onclick='toggleInfo()' type='button' aria-label='Información'><i class='fa-solid fa-circle-info'></i></button>";

$titulo_info = "Utilidad clínica";
$descripcion_info = "Referencia de diluciones y concentraciones habituales en anestesia, organizada por categorías para revisión rápida en pabellón.";

$referencias = array(
  "ISO 26825:2020. Anaesthetic and respiratory equipment — User-applied labels for syringes containing drugs used during anaesthesia — Colours, design and performance.",
  "Miller RD, Cohen NH, Eriksson LI, et al. Miller's Anesthesia. 9th ed. Elsevier.",
  "Difficult Airway Society / recomendaciones generales de seguridad en anestesia y estandarización visual de fármacos."
);

$drugRows = array(
  "Opioides" => array(
    array("droga"=>"Fentanilo", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"2 mL", "dilucion"=>"No se diluye", "final"=>"50 µg/mL"),
    array("droga"=>"Fentanilo", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"10 mL", "dilucion"=>"No se diluye", "final"=>"50 µg/mL"),
    array("droga"=>"Remifentanilo", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"Polvo 1 mg", "dilucion"=>"Llevar a 20 mL", "final"=>"50 µg/mL"),
    array("droga"=>"Remifentanilo", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"Polvo 2 mg", "dilucion"=>"Llevar a 40 mL", "final"=>"50 µg/mL"),
    array("droga"=>"Remifentanilo", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"Polvo 5 mg", "dilucion"=>"Llevar a 100 mL", "final"=>"50 µg/mL"),
    array("droga"=>"Morfina", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"10 mg / 1 mL", "dilucion"=>"Llevar a 10 mL", "final"=>"1 mg/mL"),
    array("droga"=>"Metadona", "clase"=>"opioid", "etiqueta"=>"Opioide", "presentacion"=>"10 mg / 2 mL", "dilucion"=>"Llevar a 10 mL", "final"=>"1 mg/mL"),
    array("droga"=>"Naloxona", "clase"=>"reversal-opioid", "etiqueta"=>"Antagonista opioide", "presentacion"=>"0,4 mg / mL", "dilucion"=>"Llevar a 10 mL", "final"=>"40 µg/mL")
  ),
  "Inductores y sedantes" => array(
    array("droga"=>"Propofol 1%", "clase"=>"inductor", "etiqueta"=>"Inductor", "presentacion"=>"Ampolla 20 mL", "dilucion"=>"No se diluye", "final"=>"10 mg/mL"),
    array("droga"=>"Propofol 2%", "clase"=>"inductor", "etiqueta"=>"Inductor", "presentacion"=>"Ampolla 50 mL", "dilucion"=>"No se diluye", "final"=>"20 mg/mL"),
    array("droga"=>"Propofol 2%", "clase"=>"inductor", "etiqueta"=>"Inductor", "presentacion"=>"Ampolla 100 mL", "dilucion"=>"No se diluye", "final"=>"20 mg/mL"),
    array("droga"=>"Etomidato", "clase"=>"inductor", "etiqueta"=>"Inductor", "presentacion"=>"20 mg / 10 mL", "dilucion"=>"No se diluye", "final"=>"2 mg/mL"),
    array("droga"=>"Ketamina", "clase"=>"inductor", "etiqueta"=>"Inductor / adjunto", "presentacion"=>"500 mg / 10 mL", "dilucion"=>"1 cc (50 mg) a 5 mL", "final"=>"10 mg/mL"),
    array("droga"=>"Midazolam", "clase"=>"benzo", "etiqueta"=>"Benzodiazepina", "presentacion"=>"1 mg / 1 mL", "dilucion"=>"Llevar a 5 mL", "final"=>"1 mg/mL"),
    array("droga"=>"Midazolam", "clase"=>"benzo", "etiqueta"=>"Benzodiazepina", "presentacion"=>"15 mg / 3 mL", "dilucion"=>"Llevar a 15 mL", "final"=>"1 mg/mL"),
    array("droga"=>"Flumazenilo", "clase"=>"reversal-benzo", "etiqueta"=>"Antagonista BZD", "presentacion"=>"0,5 mg / 5 mL", "dilucion"=>"No se diluye", "final"=>"0,1 mg/mL")
  ),
  "Bloqueantes neuromusculares" => array(
    array("droga"=>"Succinilcolina", "clase"=>"neuromuscular", "etiqueta"=>"Bloqueante neuromuscular", "presentacion"=>"100 mg / 5 mL", "dilucion"=>"No se diluye", "final"=>"20 mg/mL"),
    array("droga"=>"Atracurio", "clase"=>"neuromuscular", "etiqueta"=>"Bloqueante neuromuscular", "presentacion"=>"25 mg / 2,5 mL", "dilucion"=>"2 ampollas llevar a 10 mL", "final"=>"5 mg/mL"),
    array("droga"=>"Rocuronio", "clase"=>"neuromuscular", "etiqueta"=>"Bloqueante neuromuscular", "presentacion"=>"50 mg / 5 mL", "dilucion"=>"Llevar a 10 mL", "final"=>"5 mg/mL"),
    array("droga"=>"Vecuronio", "clase"=>"neuromuscular", "etiqueta"=>"Bloqueante neuromuscular", "presentacion"=>"Polvo 10 mg", "dilucion"=>"Llevar a 10 mL", "final"=>"1 mg/mL"),
    array("droga"=>"Neostigmina", "clase"=>"reversal-neuromuscular", "etiqueta"=>"Reversor", "presentacion"=>"0,5 mg / 1 mL", "dilucion"=>"No se diluye", "final"=>"0,5 mg/mL")
  ),
  "Vasoactivos y otros" => array(
    array("droga"=>"Efedrina", "clase"=>"vasoactive", "etiqueta"=>"Vasoactivo", "presentacion"=>"60 mg / 1 mL", "dilucion"=>"Llevar a 10 mL", "final"=>"6 mg/mL"),
    array("droga"=>"Fenilefrina", "clase"=>"vasoactive", "etiqueta"=>"Vasoactivo", "presentacion"=>"10 mg / 1 mL", "dilucion"=>"Jeringa madre llevar a 20 mL. Hija: 1 mL de madre a 10 mL", "final"=>"50 µg/mL"),
    array("droga"=>"Lidocaína", "clase"=>"local", "etiqueta"=>"Anestésico local", "presentacion"=>"2% (100 mg / 5 mL)", "dilucion"=>"No se diluye", "final"=>"20 mg/mL"),
    array("droga"=>"Atropina", "clase"=>"atropine", "etiqueta"=>"Anticolinérgico", "presentacion"=>"1 mg / 1 mL", "dilucion"=>"Llevar a 10 mL", "final"=>"0,1 mg/mL")
  )
);

$colorCards = array(
  array('titulo'=>'Propofol','sub'=>'Inductores anestésicos','clase'=>'drug-inductor-propofol'),
  array('titulo'=>'Midazolam','sub'=>'Benzodiazepinas','clase'=>'drug-benzo'),
  array('titulo'=>'Flumazenilo','sub'=>'Antagonista BZD','clase'=>'drug-reversal-benzo'),
  array('titulo'=>'Succinilcolina','sub'=>'Despolarizante','clase'=>'drug-neuromuscular'),
  array('titulo'=>'Fentanilo','sub'=>'Opioides','clase'=>'drug-opioid'),
  array('titulo'=>'Naloxona','sub'=>'Antagonista opioide','clase'=>'drug-reversal-opioid'),
  array('titulo'=>'Atropina','sub'=>'Anticolinérgicos','clase'=>'drug-atropine'),
  array('titulo'=>'Lidocaína','sub'=>'Anestésicos locales','clase'=>'drug-local'),
  array('titulo'=>'Efedrina','sub'=>'Vasoactivos','clase'=>'drug-vasoactive')
);

require("../head.php");
?>
<link rel="stylesheet" href="css/clinical-note-system.css?v=<?= @filemtime($app_root_dir . '/apuntes/css/clinical-note-system.css') ?: time() ?>">
<script src="js/clinical-note-system.js?v=1"></script>

<style>
.dil-shell{max-width:1040px;}
.dil-group-card{background:#fff;border:1px solid var(--note-line);border-radius:1rem;padding:1rem;margin-bottom:1rem;}
.dil-group-head{display:flex;align-items:center;justify-content:space-between;gap:.75rem;margin-bottom:.75rem;}
.dil-group-title{font-size:1rem;font-weight:800;color:var(--note-text);margin:0;}
.dil-chip{display:inline-flex;align-items:center;gap:.4rem;border-radius:999px;padding:.28rem .6rem;background:#f2f4f7;color:#475467;font-size:.78rem;font-weight:700;}
.dil-table-wrap{overflow-x:visible;}
.dil-table{width:100%;border-collapse:separate;border-spacing:0;table-layout:fixed;}
.dil-table th,.dil-table td{padding:.75rem .7rem;border-bottom:1px solid #eef2f6;vertical-align:middle;text-align:left;word-break:break-word;overflow-wrap:anywhere;}
.dil-table th{font-size:.8rem;font-weight:800;color:#475467;background:#f8fafc;}
.dil-table tr:last-child td{border-bottom:none;}
.dil-col-drug{width:28%;}
.dil-col-pres{width:24%;}
.dil-col-dil{width:23%;}
.dil-col-final{width:25%;}
.dil-color-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;}
@media (max-width:768px){
  .dil-table th,.dil-table td{padding:.6rem .45rem;font-size:.88rem;}
  .dil-col-drug{width:36%;}
  .dil-col-pres{width:21%;}
  .dil-col-dil{width:19%;}
  .dil-col-final{width:24%;}
  .dil-color-grid{grid-template-columns:repeat(2,minmax(0,1fr));}
}
@media (max-width:360px){
  .dil-color-grid{grid-template-columns:1fr;}
}
</style>
<link rel="stylesheet" href="../css/module-calculos-apuntes.css?v=<?= @filemtime($app_root_dir . '/css/module-calculos-apuntes.css') ?: time() ?>">

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
  <div class="apunte-surface">
    <div class="container-fluid px-0 px-md-2">
      <div class="dil-shell note-shell px-1 px-md-0 py-0">

        <div class="note-hero">
          <div class="note-hero-kicker">APP CLÍNICA · FÁRMACOS HABITUALES</div>
          <h2>Dilución de fármacos</h2>
          <div class="note-hero-subtitle">Referencia organizada por categorías para revisar presentación, dilución y concentración final de uso habitual en anestesia.</div>
        </div>

        <div class="info-box">
          <div class="info-box-header">
            <div class="info-box-title">Información</div>
            <button type="button" onclick="toggleInfo()" class="btn btn-sm info-toggle-btn">Mostrar / ocultar</button>
          </div>
          <div id="infoContent" class="info-box-content">
            <p class="mb-2"><?php echo $descripcion_info; ?></p>
            <hr>
            <p class="mb-2">La lectura útil de esta tabla siempre sigue la misma secuencia: droga, presentación original, dilución realizada y concentración final resultante.</p>
            <hr>
            <strong>Referencias:</strong>
            <ul class="mt-2 mb-0">
              <?php foreach($referencias as $ref){ ?>
                <li><?php echo $ref; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>

        <div class="note-warning mb-3">
          <div class="note-card-title">Advertencia visible</div>
          <p class="mb-0">El color ayuda a anticipar la clase farmacológica, pero nunca reemplaza la verificación de droga, concentración y dosis antes de administrar.</p>
        </div>

        <?php foreach($drugRows as $categoria => $rows){ ?>
          <div class="dil-group-card">
            <div class="dil-group-head">
              <h3 class="dil-group-title"><?php echo $categoria; ?></h3>
              <span class="dil-chip"><i class="fa-solid fa-table-columns"></i> Referencia rápida</span>
            </div>

            <div class="dil-table-wrap">
              <table class="dil-table">
                <colgroup>
                  <col class="dil-col-drug">
                  <col class="dil-col-pres">
                  <col class="dil-col-dil">
                  <col class="dil-col-final">
                </colgroup>
                <thead>
                  <tr>
                    <th>Droga / etiqueta</th>
                    <th>Presentación</th>
                    <th>Dilución</th>
                    <th>Concentración</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($rows as $row){ ?>
                    <tr>
                      <td>
                        <div class="drug-label drug-<?php echo $row['clase']; ?>">
                          <div class="drug-label-content">
                            <div class="drug-label-title"><?php echo $row['droga']; ?></div>
                            <div class="drug-label-subtitle"><?php echo $row['etiqueta']; ?></div>
                          </div>
                        </div>
                      </td>
                      <td><?php echo $row['presentacion']; ?></td>
                      <td><?php echo $row['dilucion']; ?></td>
                      <td><strong><?php echo $row['final']; ?></strong></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>

        <div class="dil-group-card">
          <div class="dil-group-head">
            <h3 class="dil-group-title">Referencia visual rápida por color</h3>
            <span class="dil-chip"><i class="fa-solid fa-eye"></i> Apoyo visual</span>
          </div>
          <div class="dil-color-grid">
            <?php foreach($colorCards as $card){ ?>
              <div class="drug-card <?php echo $card['clase']; ?>">
                <div class="drug-label-content">
                  <div class="drug-label-title"><?php echo $card['titulo']; ?></div>
                  <div class="drug-label-subtitle"><?php echo $card['sub']; ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <div class="note-teaching-wrap mt-3">
          <div class="note-teaching-title">Perlas docentes</div>
          <div class="note-teaching-main">Leer la concentración final antes de usar la jeringa</div>
          <div class="note-tips"><strong>Qué hacer:</strong> comprobar presentación original, dilución realizada y concentración final como una secuencia fija antes de administrar.</div>
          <div class="note-tips"><strong>Qué evitar:</strong> confiar solo en el color o asumir que todas las preparaciones comerciales comparten la misma concentración.</div>
          <div class="note-tips mb-0"><strong>Error frecuente:</strong> recordar la dilución pero olvidar la concentración final real en la jeringa preparada.</div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php require("../footer.php"); ?>
