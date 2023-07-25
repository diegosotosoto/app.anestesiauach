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
		$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='nueva_epa.php'><i class='fa-solid fa-plus'></i></a>";

	//Carga Head de la página
	require("head.php");

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
		
			<ul class="list-group">

	<!– TABLA DE REGISTROS –>
	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold opacity-75'>Evaluación Preanestésica</h5>";

		//BOTON A LA IZQUIERDA DEL TITULO class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block'
		echo "<div class='pt-1 ps-3 me-3 d-flex float-end'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:100px; height:40px; --bs-border-opacity: .1;' href='nueva_epa.php'><i class='fa-solid fa-plus pe-2'></i>Nueva</a>
		</div>";

		//SUBTITULO
		echo "<div class='mb-1'></div>";
		echo "<div class='mb-1'></div></li>";
	?>

<?php
//Guarda la EPA

			//GUARDAR EDICIÓN DE USUARIO
		if($_POST['mail_user_epa'] or $_POST['ID_epa']){
			//si existe registro enviado mediante post

			$nombre_paciente=htmlentities(addslashes($_POST['nombre_paciente']));
			$rut=htmlentities(addslashes(strtoupper($_POST['rut'])));

			$ficha=htmlentities(addslashes($_POST['ficha']));
			$edad=htmlentities(addslashes($_POST['edad']));
			$sexo=htmlentities(addslashes($_POST['sexo']));

			//FUNCIÓN PARA ASIGNAR NULL DENTRO DEL ARRAY DE IMPLODE
			$nullToValue = function ($value) {
					if(isset($value) && $value !== ''){
						$value = htmlentities(addslashes($value));
					} else {
						$value = 'NULL';
					}
			    return $value;
			};

			//VARIABLES ANTROPOMETRICO
			$peso = $_POST['peso'];
			$talla = $_POST['talla'];

			if ($_POST['peso'] and $_POST['talla']){
					$operacion = ($peso/$talla)/$talla;
					$imc=round($operacion, 2);
			} else {
				$imc='';
			}

			$arr_antropometrico = array($peso, $talla, $imc);
			$arr_antropometrico = array_map($nullToValue, $arr_antropometrico);
			$antropometrico = implode("@", $arr_antropometrico);

			//VARIABLES SIGNOS VITALES
			$pas = $_POST['pas'];
			$pad = $_POST['pad'];
			$fc = $_POST['fc'];
			$sao2 = $_POST['sao2'];
			$fio2 = $_POST['fio2'];
			$temp = $_POST['temp'];

			$arr_signos_vitales = array($pas, $pad, $fc, $sao2, $fio2, $temp);
			$arr_signos_vitales = array_map($nullToValue, $arr_signos_vitales);
			$signos_vitales = implode("@", $arr_signos_vitales);

			$diagnostico=htmlentities(addslashes($_POST['diagnostico']));
			$intervencion=htmlentities(addslashes($_POST['intervencion']));
			$fecha_int=htmlentities(addslashes($_POST['fecha_int']));
			$cirujano=htmlentities(addslashes($_POST['cirujano']));
			$riesgo=htmlentities(addslashes($_POST['riesgo']));

			//VARIABLES CARDIO
			$cf_cf = $_POST['cf_cf'];
			$ant_hta = $_POST['ant_hta'];
			$ant_icc = $_POST['ant_icc'];
			$ant_iam = $_POST['ant_iam'];
			$ant_valv = $_POST['ant_valv'];
			$ant_coronaria = $_POST['ant_coronaria'];
			$ant_arr = $_POST['ant_arr'];

			$arr_antec_cardio = array($cf_cf,$ant_hta,$ant_icc,$ant_iam,$ant_valv,$ant_coronaria,$ant_arr);
			$arr_antec_cardio = array_map($nullToValue, $arr_antec_cardio);
			$antec_cardio = implode("@", $arr_antec_cardio);

			$otro_cardio = htmlentities(addslashes($_POST['otro_cardio']));

			//VARIABLES RESPIRATORIO
			$ant_asma = $_POST['ant_asma'];
			$ant_sahos = $_POST['ant_sahos'];
			$ant_epoc = $_POST['ant_epoc'];
			$ant_o2 = $_POST['ant_o2'];
			$ant_nac = $_POST['ant_nac'];
			$ant_tos = $_POST['ant_tos'];

			$arr_antec_respirat = array($ant_asma,$ant_sahos,$ant_epoc,$ant_o2,$ant_nac,$ant_tos);
			$arr_antec_respirat = array_map($nullToValue, $arr_antec_respirat);
			$antec_respirat = implode("@", $arr_antec_respirat);

			$otro_respirat = htmlentities(addslashes($_POST['otro_respirat']));

			//VARIABLES NEURO
			$ant_convuls = $_POST['ant_convuls'];
			$ant_acv = $_POST['ant_acv'];
			$ant_pic = $_POST['ant_pic'];
			$ant_cefalea = $_POST['ant_cefalea'];
			$ant_vertigo = $_POST['ant_vertigo'];
			$ant_medula = $_POST['ant_medula'];

			$arr_antec_neuro = array($ant_convuls,$ant_acv,$ant_pic,$ant_cefalea,$ant_vertigo,$ant_medula);
			$arr_antec_neuro = array_map($nullToValue, $arr_antec_neuro);
			$antec_neuro = implode("@", $arr_antec_neuro);

			$otro_neuro = htmlentities(addslashes($_POST['otro_neuro']));

			//VARIABLES HEPÁTICO
			$ant_hepatitis = $_POST['ant_hepatitis'];
			$ant_cirrosis = $_POST['ant_cirrosis'];
			$ant_ictericia = $_POST['ant_ictericia'];
			$ant_ascitis = $_POST['ant_ascitis'];

			$arr_antec_hepatico = array($ant_hepatitis,$ant_cirrosis,$ant_ictericia,$ant_ascitis);
			$arr_antec_hepatico = array_map($nullToValue, $arr_antec_hepatico);
			$antec_hepatico = implode("@", $arr_antec_hepatico);

			$otro_hepatico = htmlentities(addslashes($_POST['otro_hepatico']));

			//VARIABLES RENAL
			$ant_erc = $_POST['ant_erc'];
			$ant_aki = $_POST['ant_aki'];
			$chk_hd = $_POST['chk_hd'];
			$ultima_hd = $_POST['ultima_hd'];

			$arr_antec_renal = array($ant_erc,$ant_aki,$chk_hd,$ultima_hd);
			$arr_antec_renal = array_map($nullToValue, $arr_antec_renal);
			$antec_renal = implode("@", $arr_antec_renal);

			$otro_renal = htmlentities(addslashes($_POST['otro_renal']));

			//VARIABLES GASTRO
			$ant_rge = $_POST['ant_rge'];
			$ant_hiatal = $_POST['ant_hiatal'];
			$ant_ugd = $_POST['ant_ugd'];	
			$ant_obstr = $_POST['ant_obstr'];
			$ant_gastritis = $_POST['ant_gastritis'];
			$ant_vomito = $_POST['ant_vomito'];

			$arr_antec_gastro = array($ant_rge,$ant_hiatal,$ant_ugd,$ant_obstr,$ant_gastritis,$ant_vomito);
			$arr_antec_gastro = array_map($nullToValue, $arr_antec_gastro);
			$antec_gastro = implode("@", $arr_antec_gastro);

			$otro_gastro = htmlentities(addslashes($_POST['otro_gastro']));

			//VARIABLES HEMATOLOGIA
			$ant_anemia = $_POST['ant_anemia'];
			$ant_tx = $_POST['ant_tx'];
			$ant_coagulop = $_POST['ant_coagulop'];	
			$ant_reactx = $_POST['ant_reactx'];
			$ant_trombocit = $_POST['ant_trombocit'];
			$ant_aceptatx = $_POST['ant_aceptatx'];

			$arr_antec_hemato = array($ant_anemia,$ant_tx,$ant_coagulop,$ant_reactx,$ant_trombocit,$ant_aceptatx);
			$arr_antec_hemato = array_map($nullToValue, $arr_antec_hemato);
			$antec_hemato = implode("@", $arr_antec_hemato);

			$otro_hemato = htmlentities(addslashes($_POST['otro_hemato']));

			//VARIABLES ENDOCRINO
			$ant_hipot = $_POST['ant_hipot'];
			$ant_dm = $_POST['ant_dm'];
			$ant_hipert = $_POST['ant_hipert'];	
			$ant_corticoid = $_POST['ant_corticoid'];

			$arr_antec_endocrino = array($ant_hipot,$ant_dm,$ant_hipert,$ant_corticoid);
			$arr_antec_endocrino = array_map($nullToValue, $arr_antec_endocrino);
			$antec_endocrino = implode("@", $arr_antec_endocrino);

			$otro_endocrino = htmlentities(addslashes($_POST['otro_endocrino']));

			//VARIABLES MUSCULOESQUELETICO
			$ant_dlumbar = $_POST['ant_dlumbar'];
			$ant_artritis = $_POST['ant_artritis'];
			$ant_distrofia = $_POST['ant_distrofia'];	
			$ant_escoliosis = $_POST['ant_escoliosis'];

			$arr_antec_musculo = array($ant_dlumbar,$ant_artritis,$ant_distrofia,$ant_escoliosis);
			$arr_antec_musculo = array_map($nullToValue, $arr_antec_musculo);
			$antec_musculo = implode("@", $arr_antec_musculo);

			$otro_musculo = htmlentities(addslashes($_POST['otro_musculo']));

			//VARIABLES SALUD MENTAL
			$ant_depresion = $_POST['ant_depresion'];
			$ant_eqz = $_POST['ant_eqz'];
			$ant_ansiedad = $_POST['ant_ansiedad'];	
			$ant_psicofarmacos = $_POST['ant_psicofarmacos'];

			$arr_antec_mental = array($ant_depresion,$ant_eqz,$ant_ansiedad,$ant_psicofarmacos);
			$arr_antec_mental = array_map($nullToValue, $arr_antec_mental);
			$antec_mental = implode("@", $arr_antec_mental);

			$otro_mental = htmlentities(addslashes($_POST['otro_mental']));

			//VARIABLES GINECOOBSTETRICOS
			$ant_aco = $_POST['ant_aco'];
			$ant_meno = $_POST['ant_meno'];
			$ant_formulaob = $_POST['ant_formulaob'];
			$ant_fur = $_POST['ant_fur'];

			$arr_antec_gine = array($ant_aco,$ant_meno,$ant_formulaob,$ant_fur);
			$arr_antec_gine = array_map($nullToValue, $arr_antec_gine);
			$antec_gine = implode("@", $arr_antec_gine);

			$otro_gine = htmlentities(addslashes($_POST['otro_gine']));

			//CIRUGÍAS PREVIAS
			$nvpo = $_POST['nvpo'];
			$hipertermia = $_POST['hipertermia'];
			//ANTEC FAMILIARES
			$arr_nvpo_hm = array($nvpo,$hipertermia);
			$arr_nvpo_hm = array_map($nullToValue, $arr_nvpo_hm);
			$nvpo_hm = implode("@", $arr_nvpo_hm);

			$antec_familiares = htmlentities(addslashes($_POST['antec_familiares']));
			$cirugias_prev = htmlentities(addslashes($_POST['cirugias_prev']));

			//ESTADO ACTUAL
			$chk_emb = $_POST['chk_emb'];
			$e_gestacional = $_POST['e_gestacional'];

			$arr_embarazo= array($chk_emb,$e_gestacional);
			$arr_embarazo = array_map($nullToValue, $arr_embarazo);
			$embarazo = implode("@", $arr_embarazo);

			$chk_oh = $_POST['chk_oh'];
			$frecuencia_oh = $_POST['frecuencia_oh'];

			$arr_oh= array($chk_oh,$frecuencia_oh);
			$arr_oh = array_map($nullToValue, $arr_oh);
			$oh = implode("@", $arr_oh);

			$chk_tabaco = $_POST['chk_tabaco'];
			$cig_dia = $_POST['cig_dia'];

			$arr_tabaco= array($chk_tabaco,$cig_dia);
			$arr_tabaco = array_map($nullToValue, $arr_tabaco);
			$tabaco = implode("@", $arr_tabaco);

			$chk_drogas = $_POST['chk_drogas'];
			$detalle_drogas = $_POST['detalle_drogas'];

			$arr_drogas= array($chk_drogas,$detalle_drogas);
			$arr_drogas = array_map($nullToValue, $arr_drogas);
			$drogas = implode("@", $arr_drogas);

			//VARIABLES INDICACIONES
			$anticoagulante = htmlentities(addslashes($_POST['anticoagulante']));
			$indic1 = htmlentities(addslashes($_POST['indic1']));
			$indic2 = htmlentities(addslashes($_POST['indic2']));	
			$indic3 = htmlentities(addslashes($_POST['indic3']));
			$indic4 = htmlentities(addslashes($_POST['indic4']));
			$indic5 = htmlentities(addslashes($_POST['indic5']));
			$indic6 = htmlentities(addslashes($_POST['indic6']));

			//ALERGIAS
			$chk_alerg = $_POST['chk_alerg'];
			$chk_alerg_no = $_POST['chk_alerg_no'];			
			$chk_alerg_med = $_POST['chk_alerg_med'];
			$chk_alerg_alim = $_POST['chk_alerg_alim'];
			$chk_alerg_latex = $_POST['chk_alerg_latex'];
			$alerg = $_POST['alerg'];

			$arr_alergias= array($chk_alerg,$chk_alerg_no,$chk_alerg_med,$chk_alerg_alim,$chk_alerg_latex,$alerg);
			$arr_alergias = array_map($nullToValue, $arr_alergias);
			$alergias = implode("@", $arr_alergias);

			//VARIABLES EXAMEN FISICO
			$cardiaco = htmlentities(addslashes($_POST['cardiaco']));
			$pulmonar = htmlentities(addslashes($_POST['pulmonar']));
			$neurologico = htmlentities(addslashes($_POST['neurologico']));	
			$puncion = htmlentities(addslashes($_POST['puncion']));
			$ef_otro = htmlentities(addslashes($_POST['ef_otro']));
			$eva = htmlentities(addslashes($_POST['eva']));

			//VARIABLES VÍA AÉREA
			$antec_vad = $_POST['antec_vad'];
			$mallampati = $_POST['mallampati'];
			$dtm = $_POST['dtm'];	
			$cervical = $_POST['cervical'];
			$ap_bucal = $_POST['ap_bucal'];
			$prognar = $_POST['prognar'];
			$dentadura = $_POST['dentadura'];

			$arr_via_aerea = array($antec_vad,$mallampati,$dtm,$cervical,$ap_bucal,$prognar,$dentadura);
			$arr_via_aerea = array_map($nullToValue, $arr_via_aerea);
			$via_aerea = implode("@", $arr_via_aerea);

			//VARIABLES EXAMENES
			$fecha_exs = $_POST['fecha_exs'];
			$hcto = $_POST['hcto'];
			$hb = $_POST['hb'];	
			$leuc = $_POST['leuc'];
			$plaq = $_POST['plaq'];
			$crea = $_POST['crea'];
			$glic = $_POST['glic'];
			$e_na = $_POST['e_na'];
			$e_k = $_POST['e_k'];
			$e_cl = $_POST['e_cl'];	
			$tp = $_POST['tp'];
			$inr = $_POST['inr'];
			$ttpa = $_POST['ttpa'];

			$arr_examenes = array($fecha_exs,$hcto,$hb,$leuc,$plaq,$crea,$glic,$e_na,$e_k,$e_cl,$tp,$inr,$ttpa);
			$arr_examenes = array_map($nullToValue, $arr_examenes);
			$examenes = implode("@", $arr_examenes);

			$otros_exs = htmlentities(addslashes($_POST['otros_exs']));

			//ASA
			$asa = $_POST['asa'];
			$asa_e = $_POST['asa_e'];

			$arr_ev_asa= array($asa,$asa_e);
			$arr_ev_asa = array_map($nullToValue, $arr_ev_asa);
			$ev_asa = implode("@", $arr_ev_asa);

			//PLAN INDICACIONES
			$ayuno = $_POST['ayuno'];
			$farmacos = $_POST['farmacos'];
			$monitorizacion = $_POST['monitorizacion'];		

			$arr_solicitudes= array($ayuno,$farmacos,$monitorizacion);
			$arr_solicitudes = array_map($nullToValue, $arr_solicitudes);
			$solicitudes = implode("@", $arr_solicitudes);

			$hemoc = $_POST['hemoc'];
			$analgesia_po = $_POST['analgesia_po'];					
			$upc = $_POST['upc'];
			$consent = $_POST['consent'];

			$arr_solicitudes2 = array($hemoc,$analgesia_po,$upc,$consent);
			$arr_solicitudes2 = array_map($nullToValue, $arr_solicitudes2);
			$solicitudes2 = implode("@", $arr_solicitudes2);

			$otro_plan = htmlentities(addslashes($_POST['otro_plan']));			

			$comentarios = htmlentities(addslashes($_POST['comentarios']));			
			$autor_epa=stripslashes(html_entity_decode($usuario['nombre_usuario'])); //segun cookie confirmada en base de datos
			$fecha_aut=date("m-d-Y H:i",strtotime('-4 hour'));

//Primero confirma si el registro ya fue ingresado previamente

if($_POST['mail_user_epa']){

	$confirma_eva_b="SELECT *  FROM `eval_preanestesica` WHERE `rut` = '$rut' AND `ficha` = '$ficha' AND `edad` = '$edad' AND `antropometrico` = '$antropometrico' AND `alergias` = '$alergias' AND `via_aerea` = '$via_aerea' AND `ev_asa` = '$ev_asa' AND `fecha_aut` = '$fecha_aut' AND `diagnostico` = '$diagnostico' AND `intervencion` = '$intervencion' AND `examenes` = '$examenes' AND `solicitudes` = '$solicitudes' AND `cirujano` = '$cirujano' AND `solicitudes` = '$solicitudes' AND `solicitudes2` = '$solicitudes2'";

	$consulta_eva=$conexion->query($confirma_eva_b);

	$respuesta_eva=mysqli_num_rows($consulta_eva);

	if($respuesta_eva>=1){ //ya existe ese registro en la base de datos

				echo "
					<div class='alert alert-danger alert-dismissible fade show'>
				    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
				    <strong>Info!</strong> Ya existe un registro ingresado por ".$autor_epa." con fecha ".$fecha_aut." , para el paciente Rut :".$rut.". <strong>No se ha ingresado el nuevo registro</strong>
				  	</div>
				";
	}else{ 	

		//guarda el nuevo registro en la base de datos

	$consulta_beva="INSERT INTO `eval_preanestesica` (`nombre_paciente`, `rut`, `ficha`, `edad`, `sexo`, `antropometrico`, `signos_vitales`, `diagnostico`, `intervencion`, `fecha_int`, `cirujano`, `riesgo`, `antec_cardio`, `otro_cardio`, `antec_respirat`, `otro_respirat`, `antec_neuro`, `otro_neuro`, `antec_hepatico`, `otro_hepatico`, `antec_renal`, `otro_renal`, `antec_gastro`, `otro_gastro`, `antec_hemato`, `otro_hemato`, `antec_endocrino`, `otro_endocrino`, `antec_musculo`, `otro_musculo`, `antec_mental`, `otro_mental`, `antec_gine`, `otro_gine`, `nvpo_hm`, `antec_familiares`, `cirugias_prev`, `embarazo`, `oh`, `tabaco`, `drogas`, `anticoagulante`, `indic1`, `indic2`, `indic3`, `indic4`, `indic5`, `indic6`, `alergias`, `cardiaco`, `pulmonar`, `neurologico`, `puncion`, `ef_otro`, `eva`, `via_aerea`, `examenes`, `otros_exs`, `ev_asa`, `solicitudes`, `solicitudes2`, `otro_plan`, `comentarios`, `autor_epa`, `fecha_aut`) VALUES ('$nombre_paciente', '$rut', '$ficha', '$edad', '$sexo', '$antropometrico', '$signos_vitales', '$diagnostico', '$intervencion', '$fecha_int', '$cirujano', '$riesgo', '$antec_cardio', '$otro_cardio', '$antec_respirat', '$otro_respirat', '$antec_neuro', '$otro_neuro', '$antec_hepatico', '$otro_hepatico', '$antec_renal', '$otro_renal', '$antec_gastro', '$otro_gastro', '$antec_hemato', '$otro_hemato', '$antec_endocrino', '$otro_endocrino', '$antec_musculo', '$otro_musculo', '$antec_mental', '$otro_mental', '$antec_gine', '$otro_gine', '$nvpo_hm', '$antec_familiares', '$cirugias_prev', '$embarazo', '$oh', '$tabaco', '$drogas', '$anticoagulante', '$indic1', '$indic2', '$indic3', '$indic4', '$indic5', '$indic6', '$alergias', '$cardiaco', '$pulmonar', '$neurologico', '$puncion', '$ef_otro', '$eva', '$via_aerea', '$examenes', '$otros_exs', '$ev_asa', '$solicitudes', '$solicitudes2', '$otro_plan', '$comentarios', '$autor_epa', '$fecha_aut');";
			
			$escribir_beva=$conexion->query($consulta_beva);

			if($escribir_beva==false){
				echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
						  	</div>
				";

			}else{

				echo "
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Registro Guardado.
						  	</div>
				";
			} 
		}

	}else if($_POST['ID_epa']){

		$ID_epa_edit = $_POST['ID_epa'];
		$consulta_beva = "UPDATE `eval_preanestesica`
SET 
  `nombre_paciente` = '$nombre_paciente',
  `edad` = '$edad',
  `sexo` = '$sexo',
  `antropometrico` = '$antropometrico',
  `signos_vitales` = '$signos_vitales',
  `diagnostico` = '$diagnostico',
  `intervencion` = '$intervencion',
  `fecha_int` = '$fecha_int',
  `cirujano` = '$cirujano',
  `riesgo` = '$riesgo',
  `antec_cardio` = '$antec_cardio',
  `otro_cardio` = '$otro_cardio',
  `antec_respirat` = '$antec_respirat',
  `otro_respirat` = '$otro_respirat',
  `antec_neuro` = '$antec_neuro',
  `otro_neuro` = '$otro_neuro',
  `antec_hepatico` = '$antec_hepatico',
  `otro_hepatico` = '$otro_hepatico',
  `antec_renal` = '$antec_renal',
  `otro_renal` = '$otro_renal',
  `antec_gastro` = '$antec_gastro',
  `otro_gastro` = '$otro_gastro',
  `antec_hemato` = '$antec_hemato',
  `otro_hemato` = '$otro_hemato',
  `antec_endocrino` = '$antec_endocrino',
  `otro_endocrino` = '$otro_endocrino',
  `antec_musculo` = '$antec_musculo',
  `otro_musculo` = '$otro_musculo',
  `antec_mental` = '$antec_mental',
  `otro_mental` = '$otro_mental',
  `antec_gine` = '$antec_gine',
  `otro_gine` = '$otro_gine',
  `nvpo_hm` = '$nvpo_hm',
  `antec_familiares` = '$antec_familiares',
  `cirugias_prev` = '$cirugias_prev',
  `embarazo` = '$embarazo',
  `oh` = '$oh',
  `tabaco` = '$tabaco',
  `drogas` = '$drogas',
  `anticoagulante` = '$anticoagulante',
  `indic1` = '$indic1',
  `indic2` = '$indic2',
  `indic3` = '$indic3',
  `indic4` = '$indic4',
  `indic5` = '$indic5',
  `indic6` = '$indic6',
  `alergias` = '$alergias',
  `cardiaco` = '$cardiaco',
  `pulmonar` = '$pulmonar',
  `neurologico` = '$neurologico',
  `puncion` = '$puncion',
  `ef_otro` = '$ef_otro',
  `eva` = '$eva',
  `via_aerea` = '$via_aerea',
  `examenes` = '$examenes',
  `otros_exs` = '$otros_exs',
  `ev_asa` = '$ev_asa',
  `solicitudes` = '$solicitudes',
  `solicitudes2` = '$solicitudes2',
  `otro_plan` = '$otro_plan',
  `comentarios` = '$comentarios',
  `autor_epa` = '$autor_epa',
  `fecha_aut` = '$fecha_aut'
 WHERE `eval_preanestesica`.`ID_epa` = '$ID_epa_edit'";

			$escribir_beva=$conexion->query($consulta_beva);

			if($escribir_beva==false){
				echo "
							<div class='alert alert-danger alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Error en el Guardado. Contacta al Administrador
						  	</div>
				";

			}else{

				echo "
							<div class='alert alert-success alert-dismissible fade show'>
						    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
						    <strong>Info!</strong> Se han guardado los cambios.
						  	</div>
				";
			} 


	}




	}

?>

	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><div><img class='btn-imagen' src='/images/IMG_3987.PNG'/>Nueva Evaluación Preanestésica</div></li>
		<li class='list-group-item  bg-light'>

		<div class='py-3 ps-3 me-3 d-flex mx-auto'>
		<a class='btn mx-auto btn-primary shadow-sm border-light' style='width:150px; height:65px; --bs-border-opacity: .1;' href='nueva_epa.php'><i class='fa-solid fa-plus pe-2'></i>Nueva Evaluación</a>
		</div>

		</li>	

	<form class="needs-validation" name="form_busq_epa" id="form_busq_epa" method="post" action="vista_epa.php" novalidate>

	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><div><img class='btn-imagen' src='/images/IMG_3987.PNG'/>Búscar Evaluaciones Guardadas</div></li>
	<li class='list-group-item  bg-light'>
		<div class="row pb-3">
			<div class="col py-2">
					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Rut (sin puntos ej: 12345678-9)</div><div class='fw-lighter text-muted'><small>Requerido(*)</small></div></div>
					<div class="input-group">
					<input type="text" class="form-control" oninput='checkRut(this)' name="rut_busc" id="rut_busc">
					<span class='input-group-text p-0' id='basic-addon2'><button class="btn btn-primary btn-md" type="submit">Buscar</button></span>
				</div>
			</div>
		</div>
	</li>
		</form>

	<form class="needs-validation" name="form_busqficha_epa" id="form_busqficha_epa" method="post" action="vista_epa.php" novalidate>

	<li class='list-group-item  bg-light'>
		<div class="row pb-3">
			<div class="col py-2">
					<div class='d-flex justify-content-between pt-3'><div class='text-muted'>Ficha</div><div class='fw-lighter text-muted'><small>Requerido(*)</small></div></div>
					<div class="input-group">
					<input type="text" class="form-control" name="ficha_busc" id="ficha_busc">
					<span class='input-group-text p-0' id='basic-addon2'><button class="btn btn-primary btn-md" type="submit">Buscar</button></span>
				</div>
			</div>
		</div>
	</li>
		</form>

<?php

if($_POST['rut_busc']){ //si existe registro enviado mediante post
	
	$rut_busc = $_POST['rut_busc'];

	$busca_rut_epa="SELECT `ID_epa`,`nombre_paciente`,`ficha`,`fecha_aut` FROM `eval_preanestesica` WHERE `rut`= '$rut_busc'";
	$consulta_busca_epa=$conexion->query($busca_rut_epa);
	$respuesta_busca_epa=mysqli_num_rows($consulta_busca_epa);

	if($respuesta_busca_epa>0){ 
		echo "<div class='row py-2'><div class='col'>Nombre Paciente</div><div class='col'>Ficha</div><div class='col'>Fecha Evaluación</div></div>";
		$i=0;
		while($row_epa=$consulta_busca_epa->fetch_assoc()){
        echo "
        	<form id='epa".$i."' action='vista_epa_detalle.php' method='post'><a href='#' onclick='envioForm".$i."()' class='list-group-item list-group-item-action'>
        <input type='hidden' name='ID_epa' value='".$row_epa['ID_epa']."'/>
        <div class='row'><div class='col'>" . $row_epa["nombre_paciente"] . "</div><div class='col'>" . $row_epa["ficha"] . "</div><div class='col'> " . $row_epa["fecha_aut"] . "</div></div></a></form>
        <script>function envioForm".$i."() {document.getElementById('epa".$i."').submit(); }</script>
        ";

        $i++;
    	}
    	echo "<div class='py-5 my-5'></div>";
	} else {
	    echo "<li class='list-group-item'>No se encontraron resultados</li>";
	     echo "<div class='py-5 my-5'></div>";
	}
	
} else {


if($_POST['ficha_busc']){ //si existe registro enviado mediante post
	
	$ficha_busc = $_POST['ficha_busc'];
	$busca_ficha_epa="SELECT `ID_epa`,`nombre_paciente`,`ficha`,`fecha_aut` FROM `eval_preanestesica` WHERE `ficha`= '$ficha_busc'";
	$consulta_busca_epa=$conexion->query($busca_ficha_epa);
	$respuesta_busca_epa2=mysqli_num_rows($consulta_busca_epa);

	if($respuesta_busca_epa2>0){ 
		echo "<div class='row py-2'><div class='col'>Nombre Paciente</div><div class='col'>Ficha</div><div class='col'>Fecha Evaluación</div></div>";
		$i=0;
		while($row_epa=$consulta_busca_epa->fetch_assoc()){
        echo "
        	<form id='epa".$i."' action='vista_epa_detalle.php' method='post'><a href='#' onclick='envioForm".$i."()' class='list-group-item list-group-item-action'>
        <input type='hidden' name='ID_epa' value='".$row_epa['ID_epa']."'/>
        <div class='row'><div class='col'>" . $row_epa["nombre_paciente"] . "</div><div class='col'>" . $row_epa["ficha"] . "</div><div class='col'> " . $row_epa["fecha_aut"] . "</div></div></a></form>
        <script>function envioForm".$i."() {document.getElementById('epa".$i."').submit(); }</script>
        ";

        $i++;
    	}
    	echo "<div class='py-5 my-5'></div>";
	} else {
	    echo "<li class='list-group-item'>No se encontraron resultados</li>";
	    echo "<div class='py-5 my-5'></div>";
	}
	
} else {
	echo "<div class='py-5 my-5'></div>";
}
	
}

?>

</div>
<script>
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
</script>

<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>

<script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
	<?php 

		$conexion->close();
		require("footer.php");

	?>


<!-  FOOTER  ->
