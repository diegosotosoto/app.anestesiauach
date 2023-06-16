<?php
//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
  //redirección segun nivel de usuario
  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
  $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
  $users_b=$conexion->query($con_users_b);
  $usuario=$users_b->fetch_assoc();
  if($usuario['admin']==1){

    } elseif ($usuario['staff_']==1) {

    } elseif ($usuario['intern_']==1) {
      header('Location: bitacora_estad_i.php');
    } elseif ($usuario['becad_']==1) {
      //CONTINUA EN LA PAGINA
    }
//*********MOSTRAR ESTADISTICA SEGUN SOLICITUD DE STAFF********


 

//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<a></a>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

  <?php if($usuario['admin']==1 or $usuario['staff_']==1){

echo "
<ul class='nav nav-tabs pt-1'>
  <li class='nav-item'>
    <a class='nav-link' href='bitacora_autoriza.php'>Validación</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link active' aria-current='page' href='bitacora_revision.php'>Revisión</a>
  </li>  
</ul>";


}elseif ($usuario['becad_']==1) {
  
echo "<ul class='nav nav-tabs pt-1'>
  <li class='nav-item'>
    <a class='nav-link' href='bitacora_ingreso.php'>Ingreso</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link active' aria-current='page' href='#'>Estadística</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link' href='bitacora_rechazos.php'>Rechazos</a>
  </li> 
</ul>";

}



if ($_POST['revision']) {

$autor_b=$_POST['revision'];

}else{

$autor_b=$_COOKIE['hkjh41lu4l1k23jhlkj13'];

}


  $select_name="SELECT `nombre_usuario`  FROM `usuarios_dolor` WHERE `email_usuario` = '$autor_b' ";
  $name_query=$conexion->query($select_name);
  $name_row=$name_query->fetch_assoc();


?>



	<ul class="list-group">
	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-3'>Estadística de <?php  echo $name_row['nombre_usuario']; ?></h4>
	</li>
	</ul>


<?php



      //busca los datos segun auntor, que estén validados
        $consulta_est="SELECT * FROM `bitacora_proced` WHERE `autor_b` = '$autor_b' AND `aprobado_staff_b` = '1' ";
        $busqueda_est=$conexion->query($consulta_est);


          $edad_1='RNPT';
          $edad_2='Neonato';
          $edad_3='Menor de 6 meses';
          $edad_4='6 meses a 1 año';
          $edad_5='1 Año a 15 años';
          $edad_6='Adulto';
          $edad_7='Adulto de 70 años y mayor';


          $procedimiento_1='Cirugía General';
          $procedimiento_2='Cirugía Pediátrica';
          $procedimiento_3='Gineco-Obstetricia';
          $procedimiento_4='Cirugía de Tórax/Vascular';
          $procedimiento_5='Neurocirugía';
          $procedimiento_6='Cirugía Cardiovascular';
          $procedimiento_7='Cirugía Ambulatoria';
          $procedimiento_8='Turno/Urgencias';
          $procedimiento_9='Cirugía Urológica';
          $procedimiento_10='Traumatología y Regional';
          $procedimiento_11='Dolor';
          $procedimiento_12='Electivo';
          $procedimiento_13='UCI/UTI';


          $via_aerea_1='Tubo Orotraqueal';
          $via_aerea_2='Máscara Laríngea';
          $via_aerea_3='Tubo Nasotraqueal';
          $via_aerea_4='Tubo Doble Lumen';
          $via_aerea_5='Otra Via Aérea Supraglótica';

          
          $vad_1='Bougie';
          $vad_2='Guía o Conductor';
          $vad_3='Videolaringoscopio';
          $vad_4='Dispositivo Supraglótico';
          $vad_5='Fibrobroncoscopio';
          $vad_6='Fastrack';
          $vad_7='Bonfils';
          $vad_8='Ventilación en Jet';
          $vad_9='Via Aérea Quirúrgica';
         
          $acceso_vascular_1='Vía Venosa Periférica';
          $acceso_vascular_2='Midline';
          $acceso_vascular_3='PICC';

          $invasivo_eco_1='1';


          $cvc_1='CVC';
          $cvc_2='Cateter de Arteria Pulmonar';
          $cvc_3='CVC con reparos anatómicos';
          $cvc_4='Cateter Pulmonar por anatomía';
       
          $invasivo_1='Línea Arterial';
          $invasivo_2='Línea Arterial con Eco';
  

          $neuroaxial_1='Anestesia Espinal';
          $neuroaxial_2='Combinada Espinal-Epidural';
          $neuroaxial_3='Analgesia Epidural Lumbar';
          $neuroaxial_4='nalgesia Epidural Torácica';
          $neuroaxial_5='Anestesia Caudal';
          $neuroaxial_6='Otro';


          $regional_1='Bloqueo de Plexo Braquial';
          $regional_2='Bloqueo de EEII';
          $regional_3='Bloqueo de Pared/Interfascial';
          $regional_4='Bloqueo Nervio Dorsal del Pene';
          $regional_5='Bloqueo Paravertebral';
          $regional_6='Bloqueo Plexo Lumbar';
          $regional_7='Bloqueo Nervio Periférico';
          $regional_8='Regional Ev';
          $regional_9='Otro';


          $dolor_1='PCA Endovenosa';
          $dolor_2='PCA Peridural';
          $dolor_3='PCA Plexo/Elastomérica';
          $dolor_4='Dolor Crónico';
          $dolor_5='Otro';

        $edad_b_1=0;
        $edad_b_2=0;
        $edad_b_3=0;
        $edad_b_4=0;
        $edad_b_5=0;
        $edad_b_6=0;
        $edad_b_7=0;  

        $procedimiento_b_1=0;
        $procedimiento_b_2=0;
        $procedimiento_b_3=0;
        $procedimiento_b_4=0;
        $procedimiento_b_5=0;
        $procedimiento_b_6=0;
        $procedimiento_b_7=0;
        $procedimiento_b_8=0;
        $procedimiento_b_9=0;
        $procedimiento_b_10=0;
        $procedimiento_b_11=0;
        $procedimiento_b_12=0;
        $procedimiento_b_13=0;

        
        $via_aerea_b_1=0;
        $via_aerea_b_2=0;
        $via_aerea_b_3=0;
        $via_aerea_b_4=0;
        $via_aerea_b_5=0;

        $vad_b_1=0;
        $vad_b_2=0;
        $vad_b_3=0;
        $vad_b_4=0;
        $vad_b_5=0;
        $vad_b_6=0;
        $vad_b_7=0;
        $vad_b_8=0;
        $vad_b_9=0;
        
        $acceso_vascular_b_1=0;
        $acceso_vascular_b_2=0;
        $acceso_vascular_b_3=0;
        $invasivo_eco_b_1=0;        

        $invasivo_b_1=0;
        $invasivo_b_2=0;
        $invasivo_b_3=0;        
        $invasivo_b_4=0;


        $cvc_b_1=0;
        $cvc_b_2=0;
        $cvc_b_3=0;        
        $cvc_b_4=0;


        $neuroaxial_b_1=0;
        $neuroaxial_b_2=0;
        $neuroaxial_b_3=0;
        $neuroaxial_b_4=0;
        $neuroaxial_b_5=0;
        $neuroaxial_b_6=0;
        
        $regional_b_1=0;
        $regional_b_2=0;
        $regional_b_3=0;
        $regional_b_4=0;
        $regional_b_5=0;
        $regional_b_6=0;
        $regional_b_7=0;
        $regional_b_8=0;
        $regional_b_9=0;

        $dolor_b_1=0;
        $dolor_b_2=0;
        $dolor_b_3=0;
        $dolor_b_4=0;
        $dolor_b_5=0;


        while($estad=$busqueda_est->fetch_assoc()){

          if ($estad['edad_b']==htmlentities(addslashes($edad_1))){
            $edad_b_1++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_2))){
            $edad_b_2++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_3))){
            $edad_b_3++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_4))){
            $edad_b_4++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_5))){
            $edad_b_5++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_6))){
            $edad_b_6++;
          }
          if ($estad['edad_b']==htmlentities(addslashes($edad_7))){
            $edad_b_7++;
          }


          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_1))){
            $procedimiento_b_1++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_2))){
            $procedimiento_b_2++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_3))){
            $procedimiento_b_3++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_4))){
            $procedimiento_b_4++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_5))){
            $procedimiento_b_5++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_6))){
            $procedimiento_b_6++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_7))){
            $procedimiento_b_7++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_8))){
            $procedimiento_b_8++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_9))){
            $procedimiento_b_9++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_10))){
            $procedimiento_b_10++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_11))){
            $procedimiento_b_11++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_12))){
            $procedimiento_b_12++;
          }
          if ($estad['procedimiento_b']==htmlentities(addslashes($procedimiento_13))){
            $procedimiento_b_13++;
          }


          if ($estad['via_aerea_b']==htmlentities(addslashes($via_aerea_1))){
            $via_aerea_b_1++;
          }
          if ($estad['via_aerea_b']==htmlentities(addslashes($via_aerea_2))){
            $via_aerea_b_2++;
          }
          if ($estad['via_aerea_b']==htmlentities(addslashes($via_aerea_3))){
            $via_aerea_b_3++;
          }
          if ($estad['via_aerea_b']==htmlentities(addslashes($via_aerea_4))){
            $via_aerea_b_4++;
          }
          if ($estad['via_aerea_b']==htmlentities(addslashes($via_aerea_5))){
            $via_aerea_b_5++;
          }



          if ($estad['vad_b']==htmlentities(addslashes($vad_1))){
            $vad_b_1++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_2))){
            $vad_b_2++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_3))){
            $vad_b_3++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_4))){
            $vad_b_4++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_5))){
            $vad_b_5++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_6))){
            $vad_b_6++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_7))){
            $vad_b_7++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_8))){
            $vad_b_8++;
          }
          if ($estad['vad_b']==htmlentities(addslashes($vad_9))){
            $vad_b_9++;
          }



          if ($estad['acceso_vascular_b']==htmlentities(addslashes($acceso_vascular_1))){
            $acceso_vascular_b_1++;
          }
          if ($estad['acceso_vascular_b']==htmlentities(addslashes($acceso_vascular_2))){
            $acceso_vascular_b_2++;
          }
          if ($estad['acceso_vascular_b']==htmlentities(addslashes($acceso_vascular_3))){
            $acceso_vascular_b_3++;
          }
          if ($estad['invasivo_eco_b']==htmlentities(addslashes($invasivo_eco_1))){
            $invasivo_eco_b_1++;
          }



          if ($estad['invasivo_b']==htmlentities(addslashes($invasivo_1))){
            $invasivo_b_1++;
          }
          if ($estad['invasivo_b']==htmlentities(addslashes($invasivo_2))){
            $invasivo_b_2++;
          }

  
          if ($estad['cvc_b']==htmlentities(addslashes($cvc_1))){
            $cvc_b_1++;
          }
          if ($estad['cvc_b']==htmlentities(addslashes($cvc_2))){
            $cvc_b_2++;
          }
          if ($estad['cvc_b']==htmlentities(addslashes($cvc_3))){
            $cvc_b_3++;
          }
          if ($estad['cvc_b']==htmlentities(addslashes($cvc_4))){
            $cvc_b_4++;
          }



          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_1))){
            $neuroaxial_b_1++;
          }
          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_2))){
            $neuroaxial_b_2++;
          }
          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_3))){
            $neuroaxial_b_3++;
          }
          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_4))){
            $neuroaxial_b_4++;
          }
          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_5))){
            $neuroaxial_b_5++;
          }
          if ($estad['neuroaxial_b']==htmlentities(addslashes($neuroaxial_6))){
            $neuroaxial_b_6++;
          }




          if ($estad['regional_b']==htmlentities(addslashes($regional_1))){
            $regional_b_1++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_2))){
            $regional_b_2++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_3))){
            $regional_b_3++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_4))){
            $regional_b_4++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_5))){
            $regional_b_5++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_6))){
            $regional_b_6++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_7))){
            $regional_b_7++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_8))){
            $regional_b_8++;
          }
          if ($estad['regional_b']==htmlentities(addslashes($regional_9))){
            $regional_b_9++;
          }


        if ($estad['dolor_b']==htmlentities(addslashes($dolor_1))){
            $dolor_b_1++;
          }
          if ($estad['dolor_b']==htmlentities(addslashes($dolor_2))){
            $dolor_b_2++;
          }
          if ($estad['dolor_b']==htmlentities(addslashes($dolor_3))){
            $dolor_b_3++;
          }
          if ($estad['dolor_b']==htmlentities(addslashes($dolor_4))){
            $dolor_b_4++;
          }
          if ($estad['dolor_b']==htmlentities(addslashes($dolor_5))){
            $dolor_b_5++;
          }


        }

?>



  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div py-3"></div>



<div class="container text-center">



  <div class="row">

    <div class="col-xl-4 col-md-6">
 <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Edad", "Valor", { role: "style" } ],
        ["RNPT", <?php echo $edad_b_1;?>, "#009044"],
        ["Neonato", <?php echo $edad_b_2;?>, "026edd"],
        ["1-6m", <?php echo $edad_b_3;?>, "9b4df1"],        
        ["6m-1a", <?php echo $edad_b_4;?>, "f7de68"],
        ["1a-15a", <?php echo $edad_b_5;?>, "f73f3f"],
        ["Adulto", <?php echo $edad_b_6;?>, "7BD3CE"],
        [">70a", <?php echo $edad_b_7;?>, "#F8BBD0"]    
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Rango Etáreo",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values"></div>
<div class="py-2"></div>


    </div>

    <div class="col-xl-4 col-md-6 mx-0 px-0">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Cirugía", "Valor", { role: "style" } ],
        ["Gral", <?php echo $procedimiento_b_1;?>, "#009044"],
        ["Ped", <?php echo $procedimiento_b_2;?>, "#026edd"],
        ["Gine", <?php echo $procedimiento_b_3;?>, "#9b4df1"],        
        ["Tx/Vasc", <?php echo $procedimiento_b_4;?>, "#f7de68"],
        ["Neuro", <?php echo $procedimiento_b_5;?>, "#f73f3f"],
        ["Cardio", <?php echo $procedimiento_b_6;?>, "#7BD3CE"],
        ["Amb.", <?php echo $procedimiento_b_7;?>, "#F8BBD0"],
        ["Turno", <?php echo $procedimiento_b_8;?>, "#009044"],
        ["Uro", <?php echo $procedimiento_b_9;?>, "#026edd"],
        ["Trauma", <?php echo $procedimiento_b_10;?>, "#9b4df1"],        
        ["Dolor", <?php echo $procedimiento_b_11;?>, "#f7de68"],
        ["Electivo", <?php echo $procedimiento_b_12;?>, "#f73f3f"],
        ["UCI", <?php echo $procedimiento_b_13;?>, "#7BD3CE"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Tipo de Procedimiento",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
    hAxis: {
      slantedText: true,        // Texto en ángulo
      slantedTextAngle: 60,     // Ángulo de rotación (-90 para vertical)
    },
  };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values2"></div>
<div class="py-2"></div>

    </div>

    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Vía Aérea", "Valor", { role: "style" } ],
        ["T.O.T.", <?php echo $via_aerea_b_1;?>, "#009044"],
        ["M.L.", <?php echo $via_aerea_b_2;?>, "#026edd"],
        ["Nasotraqueal", <?php echo $via_aerea_b_3;?>, "#9b4df1"],        
        ["T.D.L.", <?php echo $via_aerea_b_4;?>, "#f7de68"],
        ["Otra", <?php echo $via_aerea_b_5;?>, "#f73f3f"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Manejo de Vía Aérea",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values3"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values3"></div>
<div class="py-2"></div>

    </div>


  </div>




  
  <div class="row">

    <div class="col-xl-4 col-md-6">

<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["VAD", "Valor", { role: "style" } ],
        ["Bougie", <?php echo $vad_b_1;?>, "#009044"],
        ["Guía", <?php echo $vad_b_2;?>, "#026edd"],
        ["VDL", <?php echo $vad_b_3;?>, "#9b4df1"],        
        ["LMA", <?php echo $vad_b_4;?>, "#f7de68"],
        ["Fibrobro", <?php echo $vad_b_5;?>, "#f73f3f"],    
        ["Fastrack", <?php echo $vad_b_6;?>, "#7BD3CE"],
        ["Bonfils", <?php echo $vad_b_7;?>, "#F8BBD0"],        
        ["V.Jet", <?php echo $vad_b_8;?>, "#DCDCDC"],
        ["V.A.Qx", <?php echo $vad_b_9;?>, "#696969"]    
      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Manejo de Vía Aérea Difícil",
       width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
    hAxis: {
      slantedText: true,        // Texto en ángulo
      slantedTextAngle: 60,     // Ángulo de rotación (-90 para vertical)
    },
  };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values4"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values4"></div>
<div class="py-2"></div>
    </div>

    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Acceso", "Valor", { role: "style" } ],
        ["VVP", <?php echo $acceso_vascular_b_1;?>, "#009044"],
        ["Midline", <?php echo $acceso_vascular_b_2;?>, "#026edd"],
        ["PICC", <?php echo $acceso_vascular_b_3;?>, "#9b4df1"],        
        ["Ecografia", <?php echo $invasivo_eco_b_4;?>, "#f7de68"]
      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Acceso Vascular",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values5"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values5"></div>
<div class="py-2"></div>

    </div>

    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Acceso Invasivo", "Valor", { role: "style" } ],
        ["L.A.", <?php echo $invasivo_b_1;?>, "#009044"],
        ["L.A.Eco", <?php echo $invasivo_b_2;?>, "#026edd"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Acceso Vascular Invasivo",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values6"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values6"></div>
<div class="py-2"></div>

    </div>


  </div>



  

  <div class="row">




    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["A. Venoso Central", "Valor", { role: "style" } ],
        ["CVC", <?php echo $cvc_b_1;?>, "#009044"],
        ["CAP", <?php echo $cvc_b_2;?>, "#026edd"],
        ["CVC Anat", <?php echo $cvc_b_3;?>, "#9b4df1"],        
        ["CAP Anat", <?php echo $cvc_b_4;?>, "#f7de68"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Acceso Venoso Central",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_valuesXX"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_valuesXX"></div>
<div class="py-2"></div>

    </div>






    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["A. Neuroaxial", "Valor", { role: "style" } ],
        ["Espinal", <?php echo $neuroaxial_b_1;?>, "#009044"],
        ["Combinada", <?php echo $neuroaxial_b_2;?>, "#026edd"],
        ["P.Lumbar", <?php echo $neuroaxial_b_3;?>, "#9b4df1"],
        ["P.Torácica", <?php echo $neuroaxial_b_4;?>, "#f7de68"],
        ["Caudal", <?php echo $neuroaxial_b_5;?>, "#f73f3f"],
        ["Otro", <?php echo $neuroaxial_b_6;?>, "#7BD3CE"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Anestesia Neuroaxial",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values7"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values7"></div>
<div class="py-2"></div>

    </div>

    <div class="col-xl-4 col-md-6">

<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Regional", "Valor", { role: "style" } ],
        ["P.Braquial", <?php echo $regional_b_1;?>, "#009044"],
        ["EEII", <?php echo $regional_b_2;?>, "#026edd"],
        ["Pared", <?php echo $regional_b_3;?>, "#9b4df1"],        
        ["NDP", <?php echo $regional_b_4;?>, "#f7de68"],
        ["Paravertebral", <?php echo $regional_b_5;?>, "#f73f3f"],        
        ["P.Lumbar", <?php echo $regional_b_6;?>, "#7BD3CE"],
        ["N.Periférico", <?php echo $regional_b_7;?>, "#F8BBD0"],        
        ["Regional.EV", <?php echo $regional_b_8;?>, "#DCDCDC"],
        ["Otro", <?php echo $regional_b_9;?>, "#696969"]    
      ]);



      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Anestesia Regional",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
    hAxis: {
      slantedText: true,        // Texto en ángulo
      slantedTextAngle: 60,     // Ángulo de rotación (-90 para vertical)
    },
  };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values8"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values8"></div>
<div class="py-2"></div>



    </div>


<div class="row">    

    <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Dolor", "Valor", { role: "style" } ],
        ["PCA-Ev", <?php echo $dolor_b_1;?>, "#009044"],
        ["PCA-Peri", <?php echo $dolor_b_2;?>, "#026edd"],
        ["PCA-Plexo", <?php echo $dolor_b_3;?>, "#9b4df1"],        
        ["Crónico", <?php echo $dolor_b_4;?>, "#f7de68"],
        ["Otro", <?php echo $dolor_b_5;?>, "#f73f3f"]
      ]);


      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Atenciones de Dolor",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values9"));
      chart.draw(view, options);
  }
</script>
  
<div id="columnchart_values9"></div>
<div class="py-2"></div>
    </div>


  </div>




</div>


</div></div></div>




  <?php 

    $conexion->close();
    require("footer.php");

  ?>
