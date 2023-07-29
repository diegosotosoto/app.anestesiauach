<?php  

//1 Validador login
	require("valida_pag.php");


	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	//Saca a los internos y otros becados del area de vpa
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`, `nombre_usuario` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }


//VARIABLES
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'></span>";
		$boton_navbar="<span class='float-end'>
					<button class=' d-sm-block d-sm-nonebtn btn-primary shadow-sm border-light' style='; --bs-border-opacity: .1;' type='button' form='epa_guardar' data-bs-toggle='modal' data-bs-target='#confirmarModal'><div class='text-white'><i class='fa-solid fa-floppy-disk pe-2'></i></div></button>
		</span>";
		
	//Carga Head de la página
	require("head.php");

echo "
  <!-- Modal de confirmación -->
  <div class='modal fade' id='confirmarModal' tabindex='-1' aria-labelledby='confirmarModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='confirmarModalLabel'>Confirmar Edición</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div> 
        <div class='modal-body'>
          ¿Estás seguro de que deseas guardar los cambios?
        </div>
        <div class='modal-footer'>
          <button type='submit' form='epa_guardar' value='Submit' class='btn btn-danger'>Sí, Guardar</button>
        </div>
      </div>
    </div>
  </div>
		";

?>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
               -webkit-appearance: none;
                margin: 0;
        }
 
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

<form class="needs-validation" name='epa_guardar' id='epa_guardar' action='vista_epa.php' method='post' novalidate>
			<ul class="list-group">

	<!– TABLA DE REGISTROS –>
	<?php

	$ID_epa = $_POST['ID_epa'];

		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold text-danger'>EDITAR  Evaluación</h5>";

		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<span class='float-end'>
        	<input type='hidden' name='ID_epa' value='".$ID_epa."'/>
			<button class='btn btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' type='button' form='epa_guardar' data-bs-toggle='modal' data-bs-target='#confirmarModal'><div class='text-white'><i class='fa-solid fa-floppy-disk pe-2'></i>Guardar</div></button>
			</span>";

		//SUBTITULO
		echo "<div class='mb-1'></div>";
		echo "<div class='mb-1'></div></li>";


// CAMPOS DEL FORMULARIO DESHABILITADOS
$is_disabled = false ; // desabilita select, inputs y checkbox //   true / false
$is_disabled_html = "";// desabilita objetos escritos en html //  disabled / ""
$is_disabled_html_ta = ""; // desabilita los objetos textarea html // readonly disabled/ ""
$is_disabled_dp = ""; //desabilita los datepickers //  1 / ""
$is_required = ""; //alergias requeridas** // required / ""
//******** desabilita lo botones de guardado?

$boton_final = "<span class='float-end pe-3 pb-5'>
						<button class='btn btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' type='button' form='epa_guardar' data-bs-toggle='modal' data-bs-target='#confirmarModal'><div class='text-white'><i class='fa-solid fa-floppy-disk pe-2'></i>Guardar Cambios</div></button>
		</span>";

	$leer_eva_c="SELECT *  FROM `eval_preanestesica` WHERE `ID_epa` = '$ID_epa'";
	$consulta_epa=$conexion->query($leer_eva_c);
	$row_eva=$consulta_epa->fetch_assoc();
	if($row_eva){ // existe ese registro en la base de datos

$nombre_paciente = $row_eva['nombre_paciente'];
$rut = $row_eva['rut'];
$ficha = $row_eva['ficha'];
$edad = $row_eva['edad'];
$sexo = $row_eva['sexo'];
$diagnostico = $row_eva['diagnostico'];
$intervencion = $row_eva['intervencion'];
$fecha_int = $row_eva['fecha_int'];
$cirujano = $row_eva['cirujano'];
$riesgo = $row_eva['riesgo'];
$otro_cardio = $row_eva['otro_cardio'];
$otro_respirat = $row_eva['otro_respirat'];
$otro_neuro = $row_eva['otro_neuro'];
$otro_hepatico = $row_eva['otro_hepatico'];
$otro_renal = $row_eva['otro_renal'];
$otro_gastro = $row_eva['otro_gastro'];
$otro_hemato = $row_eva['otro_hemato'];
$otro_musculo = $row_eva['otro_musculo'];
$otro_mental = $row_eva['otro_mental'];
$otro_gine = $row_eva['otro_gine'];
$antec_familiares = $row_eva['antec_familiares'];
$cirugias_prev = $row_eva['cirugias_prev'];
$anticoagulante = $row_eva['anticoagulante'];
$indic1 = $row_eva['indic1'];
$indic2 = $row_eva['indic2'];
$indic3 = $row_eva['indic3'];
$indic4 = $row_eva['indic4'];
$indic5 = $row_eva['indic5'];
$indic6 = $row_eva['indic6'];
$cardiaco = $row_eva['cardiaco'];
$pulmonar = $row_eva['pulmonar'];
$neurologico = $row_eva['neurologico'];
$puncion = $row_eva['puncion'];
$ef_otro = $row_eva['ef_otro'];
$eva = $row_eva['eva'];
$otros_exs = $row_eva['otros_exs'];
$otro_plan = $row_eva['otro_plan'];
$comentarios = $row_eva['comentarios'];
$autor_epa = $row_eva['autor_epa'];
$fecha_aut = $row_eva['fecha_aut'];

$nombre_paciente_original = stripslashes(html_entity_decode($nombre_paciente));
$rut_original = strtoupper(stripslashes(html_entity_decode($rut)));
$ficha_original = stripslashes(html_entity_decode($ficha));
$edad_original = stripslashes(html_entity_decode($edad));

$sexo_original = stripslashes(html_entity_decode($sexo));

$diagnostico_original = stripslashes(html_entity_decode($diagnostico));
$intervencion_original = stripslashes(html_entity_decode($intervencion));
$fecha_int_original = stripslashes(html_entity_decode($fecha_int));
$cirujano_original = stripslashes(html_entity_decode($cirujano));
$riesgo_original = stripslashes(html_entity_decode($riesgo));

$otro_cardio_original = stripslashes(html_entity_decode($otro_cardio));
$otro_respirat_original = stripslashes(html_entity_decode($otro_respirat));
$otro_neuro_original = stripslashes(html_entity_decode($otro_neuro));
$otro_hepatico_original = stripslashes(html_entity_decode($otro_hepatico));
$otro_renal_original = stripslashes(html_entity_decode($otro_renal));
$otro_gastro_original = stripslashes(html_entity_decode($otro_gastro));
$otro_hemato_original = stripslashes(html_entity_decode($otro_hemato));
$otro_endrocrino_original = stripslashes(html_entity_decode($otro_endocrino));
$otro_musculo_original = stripslashes(html_entity_decode($otro_musculo));
$otro_mental_original = stripslashes(html_entity_decode($otro_mental));
$otro_gine_original = stripslashes(html_entity_decode($otro_gine));

$antec_familiares_original = stripslashes(html_entity_decode($antec_familiares));
$cirugias_prev_original = stripslashes(html_entity_decode($cirugias_prev));

$anticoagulante_original = stripslashes(html_entity_decode($anticoagulante));
$indic1_original = stripslashes(html_entity_decode($indic1));
$indic2_original = stripslashes(html_entity_decode($indic2));
$indic3_original = stripslashes(html_entity_decode($indic3));
$indic4_original = stripslashes(html_entity_decode($indic4));
$indic5_original = stripslashes(html_entity_decode($indic5));
$indic6_original = stripslashes(html_entity_decode($indic6));

$cardiaco_original = stripslashes(html_entity_decode($cardiaco));
$pulmonar_original = stripslashes(html_entity_decode($pulmonar));
$neurologico_original = stripslashes(html_entity_decode($neurologico));
$puncion_original = stripslashes(html_entity_decode($puncion));
$ef_otro_original = stripslashes(html_entity_decode($ef_otro));

$eva_original = stripslashes(html_entity_decode($eva));
$otros_exs_original = stripslashes(html_entity_decode($otros_exs));

$otro_plan_original = stripslashes(html_entity_decode($otro_plan));
$comentarios_original = stripslashes(html_entity_decode($comentarios));
$autor_epa_original = stripslashes(html_entity_decode($usuario['nombre_usuario']));
$fecha_aut_original = date("m-d-Y H:i", strtotime('-4 hour', strtotime($fecha_aut)));

$antropometrico = $row_eva['antropometrico'];
$signos_vitales = $row_eva['signos_vitales'];
$antec_cardio = $row_eva['antec_cardio'];
$antec_respirat = $row_eva['antec_respirat'];
$antec_neuro = $row_eva['antec_neuro'];
$antec_hepatico = $row_eva['antec_hepatico'];
$antec_renal = $row_eva['antec_renal'];
$antec_gastro = $row_eva['antec_gastro'];
$antec_hemato = $row_eva['antec_hemato'];
$antec_endocrino = $row_eva['antec_endocrino'];
$antec_musculo = $row_eva['antec_musculo'];
$antec_mental = $row_eva['antec_mental'];
$antec_gine = $row_eva['antec_gine'];
$nvpo_hm = $row_eva['nvpo_hm'];
$embarazo = $row_eva['embarazo'];
$oh = $row_eva['oh'];
$tabaco = $row_eva['tabaco'];
$drogas = $row_eva['drogas'];
$alergias = $row_eva['alergias'];
$via_aerea = $row_eva['via_aerea'];
$examenes = $row_eva['examenes'];
$ev_asa = $row_eva['ev_asa'];
$solicitudes = $row_eva['solicitudes'];
$solicitudes2 = $row_eva['solicitudes2'];


$arr_antropometrico = explode("@", $antropometrico);
list($peso, $talla, $imc)=$arr_antropometrico;

$arr_signos_vitales = explode("@", $signos_vitales);
list($pas, $pad, $fc, $sao2, $fio2, $temp)=$arr_signos_vitales;

$arr_antec_cardio = explode("@", $antec_cardio);
list($cf_cf,$ant_hta,$ant_icc,$ant_iam,$ant_valv,$ant_coronaria,$ant_arr)=$arr_antec_cardio;

$arr_antec_respirat = explode("@", $antec_respirat);
list($ant_asma,$ant_sahos,$ant_epoc,$ant_o2,$ant_nac,$ant_tos)=$arr_antec_respirat;

$arr_antec_neuro = explode("@", $antec_neuro);
list($ant_convuls,$ant_acv,$ant_pic,$ant_cefalea,$ant_vertigo,$ant_medula)=$arr_antec_neuro;

$arr_antec_hepatico = explode("@", $antec_hepatico);
list($ant_hepatitis,$ant_cirrosis,$ant_ictericia,$ant_ascitis)=$arr_antec_hepatico;

$arr_antec_renal = explode("@", $antec_renal);
list($ant_erc,$ant_aki,$chk_hd,$ultima_hd)=$arr_antec_renal;

$arr_antec_gastro = explode("@", $antec_gastro);
list($ant_rge,$ant_hiatal,$ant_ugd,$ant_obstr,$ant_gastritis,$ant_vomito)=$arr_antec_gastro;

$arr_antec_hemato = explode("@", $antec_hemato);
list($ant_anemia,$ant_tx,$ant_coagulop,$ant_reactx,$ant_trombocit,$ant_aceptatx)=$arr_antec_hemato;

$arr_antec_endocrino = explode("@", $antec_endocrino);
list($ant_hipot,$ant_dm,$ant_hipert,$ant_corticoid)=$arr_antec_endocrino;

$arr_antec_musculo = explode("@", $antec_musculo);
list($ant_dlumbar,$ant_artritis,$ant_distrofia,$ant_escoliosis)=$arr_antec_musculo;

$arr_antec_mental = explode("@", $antec_mental);
list($ant_depresion,$ant_eqz,$ant_ansiedad,$ant_psicofarmacos)=$arr_antec_mental;

$arr_antec_gine = explode("@", $antec_gine);
list($ant_aco,$ant_meno,$ant_formulaob,$ant_fur)=$arr_antec_gine;

$arr_nvpo_hm = explode("@", $nvpo_hm);
list($nvpo,$hipertermia)=$arr_nvpo_hm;


$arr_embarazo = explode("@", $embarazo);
list($chk_emb,$e_gestacional)=$arr_embarazo;

$arr_oh = explode("@", $oh);
list($chk_oh,$frecuencia_oh)=$arr_oh;

$arr_tabaco = explode("@", $tabaco);
list($chk_tabaco,$cig_dia)=$arr_tabaco;

$arr_drogas = explode("@", $drogas);
list($chk_drogas,$detalle_drogas)=$arr_drogas;

$arr_alergias = explode("@", $alergias);
list($chk_alerg,$chk_alerg_no,$chk_alerg_med,$chk_alerg_alim,$chk_alerg_latex,$alerg)=$arr_alergias;

$arr_via_aerea = explode("@", $via_aerea);
list($antec_vad,$mallampati,$dtm,$cervical,$ap_bucal,$prognar,$dentadura)=$arr_via_aerea;

$arr_examenes = explode("@", $examenes);
list($fecha_exs,$hcto,$hb,$leuc,$plaq,$crea,$glic,$e_na,$e_k,$e_cl,$tp,$inr,$ttpa)=$arr_examenes;

$arr_ev_asa = explode("@", $ev_asa);
list($asa,$asa_e)=$arr_ev_asa;

$arr_solicitudes = explode("@", $solicitudes);
list($ayuno,$farmacos,$monitorizacion)=$arr_solicitudes;

$arr_solicitudes2 = explode("@", $solicitudes2);
list($hemoc,$analgesia_po,$upc,$consent)=$arr_solicitudes2;


	}else {

				echo "
					<div class='alert alert-danger alert-dismissible fade show'>
				    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
				    <strong>Info!</strong> Error en el registro. Contacta al Administrador
				  	</div>
				";

	}

		require("formulario_epa.php");



	?>







	<?php 

		$conexion->close();
	?>


<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

