<?php
//Validador login


//  require("valida_pag.php");   ****   PERMITE QUE LA PÁGINA SEA PÚBLICA   *****

//Variables sin conexion
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='../apuntes.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Apuntes</span>";
$boton_navbar="<button class='navbar-toggler text-white shadow-sm border-light' onclick='toggleInfo()'
 style='width:50px; height:40px; --bs-border-opacity: .1;' type='button' data-bs-toggle='collapse' data-bs-target='#metaApunte' aria-controls='metaApunte' aria-expanded='false' aria-label='Toggle navigation'> <i class='fa-solid fa-circle-info'></i> </button>";


//Carga Head de la página
require("head.php");
?>


<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
<div class="apunte-surface">
  <div class="container-fluid px-0 px-md-2">
    <div class="apuntes-shell">


<!-- TOPBAR -->
<div class="topbar">  
  <div class="small opacity-75">APP clínica • fármacos de uso habitual</div>
  <h1 class="h3 mb-1">Dilución de Drogas</h1>
  <div class="subtle text-white-50">Estandarización de concentraciones y codificación por color para uso seguro en pabellón.</div>
</div>

      <!-- TOGGLE INFO -->
<div class="info-box">
  <div class="info-box-header">
    <div>Información</div>
    <button onclick="toggleInfo()" class="btn btn-sm btn-secondary">Mostrar / ocultar</button>
  </div>

  <div id="infoContent" class="info-box-content">




<p style="line-height:1.6;">
  Esta tabla resume la <strong>estandarización de diluciones y concentraciones de drogas de uso habitual en anestesia</strong>, junto con su correspondiente <strong>código de color</strong>, utilizado para identificar rápidamente cada grupo farmacológico en el entorno clínico.
</p>

<p style="line-height:1.6;">
  El objetivo principal es <strong>disminuir errores de medicación</strong>, especialmente en situaciones de alta carga cognitiva (inducción, emergencia, crisis intraoperatoria), donde la identificación visual rápida puede ser más eficiente que la lectura detallada de la etiqueta.
</p>

<p style="line-height:1.6;">
  La tabla integra tres elementos fundamentales que todo residente debe dominar:
</p>

<ul style="line-height:1.6;">
  <li><strong>Presentación</strong>: concentración original de la ampolla o vial.</li>
  <li><strong>Dilución</strong>: procedimiento práctico que se realiza en pabellón.</li>
  <li><strong>Concentración final</strong>: lo que realmente se administra al paciente.</li>
</ul>

<hr>

<p style="line-height:1.6;">
  El <strong>código de colores</strong> se basa en estándares internacionales ampliamente adoptados en anestesia, donde cada grupo farmacológico tiene un color específico:
</p>

<ul style="line-height:1.6;">
  <li><strong>Amarillo</strong>: Inductores anestésicos (ej: Propofol)</li>
  <li><strong>Azul</strong>: Opioides (ej: Fentanilo, Remifentanilo)</li>
  <li><strong>Rojo</strong>: Relajantes musculares (ej: Rocuronio, Succinilcolina)</li>
  <li><strong>Naranjo</strong>: Benzodiazepinas (ej: Midazolam)</li>
  <li><strong>Verde</strong>: Anticolinérgicos (ej: Atropina)</li>
  <li><strong>Morado / Lila</strong>: Vasopresores (ej: Efedrina)</li>
  <li><strong>Gris</strong>: Anestésicos locales (ej: Lidocaína)</li>
  <li><strong>Rayado</strong>: Antagonistas (ej: Naloxona, Flumazenilo, Neostigmina)</li>
</ul>

<p style="line-height:1.6;">
  Este sistema permite que, incluso antes de leer la etiqueta, el anestesiólogo pueda <strong>anticipar el tipo de droga</strong>, reduciendo errores por confusión de jeringas.
</p>

<hr>

<p style="line-height:1.6;">
  Es importante destacar que, aunque el color ayuda a la identificación, <strong>nunca reemplaza la verificación completa</strong> de la droga, dosis y concentración antes de su administración.
</p>

<hr>

<b>Referencias:</b>
<ul class="mt-2 mb-0" style="line-height:1.6;">
  <li>1. ISO 26825:2020. Anaesthetic and respiratory equipment — User-applied labels for syringes containing drugs used during anaesthesia.</li>
  <li>2. American Society of Anesthesiologists (ASA). Statement on labeling of pharmaceuticals for use in anesthesiology.</li>
  <li>3. Association of Anaesthetists of Great Britain and Ireland. Recommendations for standards of monitoring and drug labelling.</li>
  <li>4. Merry AF, Anderson BJ. Medication errors in anaesthesia: a review. Br J Anaesth.</li>
  <li>5. Webster CS, Merry AF. The role of labeling in safe medication administration in anesthesia. Curr Opin Anaesthesiol.</li>
</ul>





  </div>
</div>

      <div id="infoDrugs" style="display:none;">
        <div class="alert alert-light border mb-3">
          <strong>Objetivo:</strong> reducir errores de medicación mediante identificación visual rápida y preparación estandarizada de las drogas más usadas en anestesia.
        </div>

        <div class="alert alert-primary mb-0">
          <strong>Perla para R1:</strong> antes de administrar cualquier droga, confirma siempre tres cosas:
          <br>1. presentación de la ampolla,
          <br>2. dilución realizada,
          <br>3. concentración final que quedó en la jeringa.
        </div>
      </div>

      <!-- TABLA DOCENTE PRINCIPAL -->
      <div class="section-box mt-4">
        <div class="section-title-ui">Diluciones y concentraciones habituales</div>

        <!-- OPIOIDES E INDUCTORES -->
        <div class="table-block-title">Opioides</div>
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle dilution-table mb-0">
            <thead>
              <tr>
                <th>Droga</th>
                <th>Etiqueta</th>
                <th>Presentación</th>
                <th>Dilución</th>
                <th>Concentración final</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Fentanilo</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>2 mL</td>
                <td>No se diluye</td>
                <td>50 µg/mL</td>
              </tr>
              <tr>
                <td>Fentanilo</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>10 mL</td>
                <td>No se diluye</td>
                <td>50 µg/mL</td>
              </tr>

              <tr>
                <td>Remifentanilo</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>Polvo 1 mg</td>
                <td>Llevar a 20 mL</td>
                <td>50 µg/mL</td>
              </tr>
              <tr>
                <td>Remifentanilo</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>Polvo 2 mg</td>
                <td>Llevar a 40 mL</td>
                <td>50 µg/mL</td>
              </tr>
              <tr>
                <td>Remifentanilo</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>Polvo 5 mg</td>
                <td>Llevar a 100 mL</td>
                <td>50 µg/mL</td>
              </tr>

              <tr>
                <td>Morfina</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>10 mg / 1 mL</td>
                <td>Llevar a 10 mL</td>
                <td>1 mg/mL</td>
              </tr>
              <tr>
                <td>Metadona</td>
                <td><span class="label-chip bg-blue-mini"></span></td>
                <td>10 mg / 2 mL</td>
                <td>Llevar a 10 mL</td>
                <td>1 mg/mL</td>
              </tr>
              <tr>
                <td>Naloxona</td>
                <td><span class="label-chip striped-blue-mini"></span></td>
                <td>0,4 mg / mL</td>
                <td>Llevar a 10 mL</td>
                <td>40 µg/mL</td>
              </tr>
           </tbody>
          </table>
        </div>


        <!-- RELAJANTES Y VASOACTIVOS -->
        <div class="table-block-title">Inductores</div>
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle dilution-table mb-0">
            <thead>
              <tr>
                <th>Droga</th>
                <th>Etiqueta</th>
                <th>Presentación</th>
                <th>Dilución</th>
                <th>Concentración final</th>
              </tr>
            </thead>
            <tbody>

              <tr>
                <td>Propofol 1%</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>Ampolla 20 mL</td>
                <td>No se diluye</td>
                <td>10 mg/mL</td>
              </tr>
              <tr>
                <td>Propofol 2%</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>Ampolla 50 mL</td>
                <td>No se diluye</td>
                <td>20 mg/mL</td>
              </tr>
              <tr>
                <td>Propofol 2%</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>Ampolla 100 mL</td>
                <td>No se diluye</td>
                <td>20 mg/mL</td>
              </tr>
              <tr>
                <td>Etomidato</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>20 mg / 10 mL</td>
                <td>No se diluye</td>
                <td>2 mg/mL</td>
              </tr>
              <tr>
                <td>Ketamina</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>500 mg / 10 mL</td>
                <td>1 cc (50 mg) a 5 mL</td>
                <td>10 mg/mL</td>
              </tr>
              <tr>
                <td>Midazolam</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>1 mg / 1 mL</td>
                <td>Llevar a 5 mL</td>
                <td>1 mg/mL</td>
              </tr>
              <tr>
                <td>Midazolam</td>
                <td><span class="label-chip bg-yellow-mini"></span></td>
                <td>15 mg / 3 mL</td>
                <td>Llevar a 15 mL</td>
                <td>1 mg/mL</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- RELAJANTES Y VASOACTIVOS -->
        <div class="table-block-title">Bloqueantes Neuromusculares</div>
        <div class="table-responsive mb-4">
          <table class="table table-bordered align-middle dilution-table mb-0">
            <thead>
              <tr>
                <th>Droga</th>
                <th>Etiqueta</th>
                <th>Presentación</th>
                <th>Dilución</th>
                <th>Concentración final</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Succinilcolina</td>
                <td><span class="label-chip bg-red-mini"></span></td>
                <td>100 mg / 5 mL</td>
                <td>No se diluye</td>
                <td>20 mg/mL</td>
              </tr>
              <tr>
                <td>Atracurio</td>
                <td><span class="label-chip bg-red-mini"></span></td>
                <td>25 mg / 2,5 mL</td>
                <td>2 ampollas llevar a 10 mL</td>
                <td>5 mg/mL</td>
              </tr>
              <tr>
                <td>Rocuronio</td>
                <td><span class="label-chip bg-red-mini"></span></td>
                <td>50 mg / 5 mL</td>
                <td>Llevar a 10 mL</td>
                <td>5 mg/mL</td>
              </tr>
              <tr>
                <td>Vecuronio</td>
                <td><span class="label-chip bg-red-mini"></span></td>
                <td>Polvo 10 mg</td>
                <td>Llevar a 10 mL</td>
                <td>1 mg/mL</td>
              </tr>
              <tr>
                <td>Neostigmina</td>
                <td><span class="label-chip striped-red-mini"></span></td>
                <td>0,5 mg / 1 mL</td>
                <td>No se diluye</td>
                <td>0,5 mg/mL</td>
              </tr>
           </tbody>
          </table>
        </div>


        <!-- RELAJANTES Y VASOACTIVOS -->
        <div class="table-block-title">Vasoactivos y otros</div>
        <div class="table-responsive">
          <table class="table table-bordered align-middle dilution-table mb-0">
            <thead>
              <tr>
                <th>Droga</th>
                <th>Etiqueta</th>
                <th>Presentación</th>
                <th>Dilución</th>
                <th>Concentración final</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Efedrina</td>
                <td><span class="label-chip bg-purple-mini"></span></td>
                <td>60 mg / 1 mL</td>
                <td>Llevar a 10 mL</td>
                <td>6 mg/mL</td>
              </tr>
              <tr>
                <td>Fenilefrina</td>
                <td><span class="label-chip bg-purple-mini"></span></td>
                <td>10 mg / 1 mL</td>
                <td>
                  Jeringa madre llevar a 20 mL<br>
                  Hija: 1 mL de madre a 10 mL
                </td>
                <td>50 µg/mL</td>
              </tr>
              <tr>
                <td>Lidocaína</td>
                <td><span class="label-chip bg-gray-mini"></span></td>
                <td>2% (100 mg / 5 mL)</td>
                <td>No se diluye</td>
                <td>20 mg/mL</td>
              </tr>
              <tr>
                <td>Atropina</td>
                <td><span class="label-chip bg-green-mini"></span></td>
                <td>1 mg / 1 mL</td>
                <td>Llevar a 10 mL</td>
                <td>0,1 mg/mL</td>
              </tr>
           </tbody>
          </table>
          
        </div>





            </tbody>
          </table>
        </div>
      </div>


      <!-- TARJETAS DE COLOR -->
      <div class="section-box mt-4">
        <div class="section-title-ui">Referencia visual rápida por color</div>

        <div class="drug-grid">
          <div class="drug-card bg-yellow">
            <div class="drug-title">Propofol</div>
            <div class="drug-sub">Inductores anestésicos</div>
          </div>

          <div class="drug-card bg-orange">
            <div class="drug-title">Midazolam</div>
            <div class="drug-sub">Benzodiazepinas</div>
          </div>

          <div class="drug-card striped-orange">
            <div class="drug-title">Flumazenilo</div>
            <div class="drug-sub">Antagonista BZD</div>
          </div>

          <div class="drug-card bg-red">
            <div class="drug-title">Succinilcolina</div>
            <div class="drug-sub">Despolarizante</div>
          </div>

          <div class="drug-card bg-red">
            <div class="drug-title">Rocuronio</div>
            <div class="drug-sub">No despolarizante</div>
          </div>

          <div class="drug-card striped-red">
            <div class="drug-title">Neostigmina</div>
            <div class="drug-sub">Antagonista relajante</div>
          </div>

          <div class="drug-card bg-gray">
            <div class="drug-title">Lidocaína</div>
            <div class="drug-sub">Anestésicos locales</div>
          </div>

          <div class="drug-card bg-blue">
            <div class="drug-title">Fentanilo</div>
            <div class="drug-sub">Opioides</div>
          </div>

          <div class="drug-card striped-blue">
            <div class="drug-title">Naloxona</div>
            <div class="drug-sub">Antagonista opioides</div>
          </div>

          <div class="drug-card bg-adrenalina">
            <div class="drug-title text-white">Adrenalina</div>
            <div class="drug-sub text-white">Vasoactivo</div>
          </div>

          <div class="drug-card bg-purple">
            <div class="drug-title">Efedrina</div>
            <div class="drug-sub">Vasopresores</div>
          </div>

          <div class="drug-card striped-purple">
            <div class="drug-title">Nitroglicerina</div>
            <div class="drug-sub">Hipotensores</div>
          </div>

          <div class="drug-card bg-green">
            <div class="drug-title">Atropina</div>
            <div class="drug-sub">Anticolinérgicos</div>
          </div>

          <div class="drug-card bg-beige">
            <div class="drug-title">Droperidol</div>
            <div class="drug-sub">Antieméticos</div>
          </div>

          <div class="drug-card bg-white">
            <div class="drug-title">Heparina</div>
            <div class="drug-sub">Miscelánea</div>
          </div>

          <div class="drug-card bg-white">
            <div class="drug-title">Cefazolina</div>
            <div class="drug-sub">Miscelánea</div>
          </div>
        </div>
      </div>


      <!-- DOCENCIA -->
      <div class="alert alert-primary mt-4 mb-0" style="line-height:1.6;">
        <strong>Perla docente para residentes:</strong><br>
        No memorices solo la droga: memoriza la <strong>presentación habitual</strong>, la <strong>dilución que haces realmente en pabellón</strong> y la <strong>concentración final</strong>.  
        Ese trípode es lo que evita errores. Si no puedes decir en voz alta “qué había en la ampolla, cuánto agregué y en qué concentración quedó”, todavía no deberías administrarla.
      </div>

    </div>
  </div>
</div>



</div>
</div>

</div>
</div>
</div>


<style>
.section-box{
  background:#fff;
  border:1px solid #e5e9f2;
  border-radius:18px;
  padding:16px;
  box-shadow:0 8px 20px rgba(0,0,0,.05);
}

.section-title-ui{
  font-weight:700;
  font-size:1.02rem;
  color:#27458f;
  margin-bottom:14px;
}

.table-block-title{
  font-weight:700;
  color:#1f2a37;
  margin-bottom:10px;
  margin-top:2px;
}

.drug-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:12px;
}

@media(min-width:768px){
  .drug-grid{
    grid-template-columns:repeat(3,1fr);
  }
}

.drug-card{
  border-radius:14px;
  padding:12px;
  text-align:center;
  font-weight:600;
  border:1px solid #dee2e6;
}

.drug-title{
  font-size:1rem;
}

.drug-sub{
  font-size:.85rem;
  opacity:.8;
}

.bg-yellow{background:#f2e94e;}
.bg-orange{background:#f39c34;}
.bg-red{background:#ef3b2d;color:white;}
.bg-blue{background:#48b7de;color:white;}
.bg-gray{background:#dfe4ea;}
.bg-green{background:#5dbb63;color:white;}
.bg-purple{background:#dab6cf;}
.bg-beige{background:#efc996;}
.bg-adrenalina{
  background: linear-gradient(
    to bottom,
    #000000 0%,
    #000000 45%,
    #d8b4c8 45%,
    #d8b4c8 100%
  );
  color: #fff;
}
.bg-white{background:#fff;}

.striped-orange{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 8px,
    #f39c34 8px,
    #f39c34 16px
  );
}

.striped-red{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 8px,
    #ef3b2d 8px,
    #ef3b2d 16px
  );
}

.striped-blue{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 8px,
    #48b7de 8px,
    #48b7de 16px
  );
}

.striped-purple{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 8px,
    #dab6cf 8px,
    #dab6cf 16px
  );
}

.dilution-table{
  font-size:.92rem;
}

.dilution-table th{
  background:#f8fafc;
  white-space:nowrap;
}

.dilution-table td,
.dilution-table th{
  vertical-align:middle;
}

.label-chip{
  display:inline-block;
  width:54px;
  height:24px;
  border-radius:7px;
  border:1px solid rgba(0,0,0,.15);
}

.bg-yellow-mini{background:#f2e94e;}
.bg-red-mini{background:#ef3b2d;}
.bg-blue-mini{background:#9eb9d9;}
.bg-gray-mini{background:#e7eaef;}
.bg-green-mini{background:#9cca62;}
.bg-purple-mini{background:#dab6cf;}

.striped-red-mini{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 5px,
    #ef3b2d 5px,
    #ef3b2d 10px
  );
}

.striped-blue-mini{
  background: repeating-linear-gradient(
    45deg,
    #fff,
    #fff 5px,
    #48b7de 5px,
    #48b7de 10px
  );
}

@media(max-width:576px){
  .drug-grid{
    grid-template-columns:1fr 1fr;
    gap:10px;
  }

  .drug-card{
    padding:10px;
  }

  .drug-title{
    font-size:.95rem;
  }

  .drug-sub{
    font-size:.78rem;
  }

  .dilution-table{
    font-size:.84rem;
  }

  .label-chip{
    width:40px;
    height:18px;
  }
}
.topbar{
  background:linear-gradient(135deg,#27458f,#3559b7);
  color:#fff;
  border-radius:1.25rem;
  padding:1.2rem;
  margin-bottom:1rem;
}
.info-box{
  background:#fff;
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  margin-bottom:1rem;
}

.info-box-header{
  display:flex;
  justify-content:space-between;
  padding:1rem;
}

.info-box-content{
  display:none;
  padding:1rem;
  border-top:1px solid #e5e7eb;
}

</style>
<script>
function toggleInfo(){
  let box = document.getElementById("infoContent");
  box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>
<?php
  $conexion->close();
  require("footer.php");
?>
