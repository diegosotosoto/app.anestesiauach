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
      //CONTINUA EN LA PAGINA
    } elseif ($usuario['becad_']==1) {
      header('Location: bitacora_estadistica.php');
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


}elseif ($usuario['intern_']==1) {
  
echo "<ul class='nav nav-tabs pt-1'>
  <li class='nav-item'>
    <a class='nav-link' href='bitacora_ingreso.php'>Ingreso</a>
  </li>
  <li class='nav-item'>
    <a class='nav-link active' aria-current='page' href='#'>Estadística</a>
  </li>
</ul>";

}



if ($_POST['revision_i']) {

$autor_i=$_POST['revision_i'];

}else{

$autor_i=$_COOKIE['hkjh41lu4l1k23jhlkj13'];

}


  $select_name="SELECT `nombre_usuario`  FROM `usuarios_dolor` WHERE `email_usuario` = '$autor_i' ";
  $name_query=$conexion->query($select_name);
  $name_row=$name_query->fetch_assoc();


?>





	<ul class="list-group">
	<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-3'>Estadística de <?php  echo $name_row['nombre_usuario']; ?></h4>
	</li>
	</ul>

<?php


      //busca los datos segun auntor, que estén validados
        $consulta_est="SELECT * FROM `bitacora_internos` WHERE `autor_i` = '$autor_i' AND `aprobado_staff_i` = '1' ";
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
          $procedimiento_3='Cesárea';
          $procedimiento_4='Cirugía Vascular';
          $procedimiento_5='Cirugía de Tórax';
          $procedimiento_6='Neurocirugía';
          $procedimiento_7='Otra';


          $edad_i_1=0;
          $edad_i_2=0;
          $edad_i_3=0;
          $edad_i_4=0;
          $edad_i_5=0;
          $edad_i_6=0;
          $edad_i_7=0;

          $procedimiento_i_1=0;
          $procedimiento_i_2=0;
          $procedimiento_i_3=0;
          $procedimiento_i_4=0;
          $procedimiento_i_5=0;
          $procedimiento_i_6=0;
          $procedimiento_i_7=0;


          $evaluacion_i_1=0;
          $evaluacion_i_2=0;
          $evaluacion_i_3=0;

          $ventilacion_i_1=0;
          $ventilacion_i_2=0;
          $ventilacion_i_3=0;

          $intubacion_i_1=0;
          $intubacion_i_2=0;
          $intubacion_i_3=0;
          
          $lma_i_1=0;
          $lma_i_2=0;
          $lma_i_3=0;

          $ayudas_i_1=0;
          $ayudas_i_2=0;
          $ayudas_i_3=0;

          $vvp_i_1=0;
          $vvp_i_2=0;
          $vvp_i_3=0;
         
          $espinal_i_1=0;
          $espinal_i_2=0;
          $espinal_i_3=0;

          $seminario_i_1=0;
          $seminario_i_2=0;
          $seminario_i_3=0;
          $seminario_i_4=0;
          $seminario_i_5=0;


        while($estad=$busqueda_est->fetch_assoc()){
          if ($estad['edad_i']==htmlentities(addslashes($edad_1))){
            $edad_i_1++;
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_2))){
            $edad_i_2++;
            
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_3))){
            $edad_i_3++;
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_4))){
            $edad_i_4++;
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_5))){
            $edad_i_5++;
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_6))){
            $edad_i_6++;
          }
          if ($estad['edad_i']==htmlentities(addslashes($edad_7))){
            $edad_i_7++;
          }





          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_1))){
            $procedimiento_i_1++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_2))){
            $procedimiento_i_2++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_3))){
            $procedimiento_i_3++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_4))){
            $procedimiento_i_4++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_5))){
            $procedimiento_i_5++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_6))){
            $procedimiento_i_6++;
          }
          if ($estad['procedimiento_i']==htmlentities(addslashes($procedimiento_7))){
            $procedimiento_i_7++;
          }



          if ($estad['evaluacion_i']=='1'){
            $evaluacion_i_1++;
          }
          if ($estad['evaluacion_i']=='2'){
            $evaluacion_i_2++;
          }
          if ($estad['evaluacion_i']=='3'){
            $evaluacion_i_3++;
          }


          if ($estad['ventilacion_i']=='1'){
            $ventilacion_i_1++;
          }
          if ($estad['ventilacion_i']=='2'){
            $ventilacion_i_2++;
          }
          if ($estad['ventilacion_i']=='3'){
            $ventilacion_i_3++;
          }



          if ($estad['intubacion_i']=='1'){
            $intubacion_i_1++;
          }
          if ($estad['intubacion_i']=='2'){
            $intubacion_i_2++;
          }
          if ($estad['intubacion_i']=='3'){
            $intubacion_i_3++;
          }


          if ($estad['lma_i']=='1'){
            $lma_i_1++;
          }
          if ($estad['lma_i']=='2'){
            $lma_i_2++;
          }
          if ($estad['lma_i']=='3'){
            $lma_i_3++;
          }


          if ($estad['ayudas_i']=='1'){
            $ayudas_i_1++;
          }
          if ($estad['ayudas_i']=='2'){
            $ayudas_i_2++;
          }
          if ($estad['ayudas_i']=='3'){
            $ayudas_i_3++;
          }

          if ($estad['vvp_i']=='1'){
            $vvp_i_1++;
          }
          if ($estad['vvp_i']=='2'){
            $vvp_i_2++;
          }
          if ($estad['vvp_i']=='3'){
            $vvp_i_3++;
          }


          if ($estad['espinal_i']=='1'){
            $espinal_i_1++;
          }
          if ($estad['espinal_i']=='2'){
            $espinal_i_2++;
          }
          if ($estad['espinal_i']=='3'){
            $espinal_i_3++;
          }


          if ($estad['seminario_i']=='1'){
            $seminario_i_1++;
          }
          if ($estad['seminario_i']=='2'){
            $seminario_i_2++;
          }
          if ($estad['seminario_i']=='3'){
            $seminario_i_3++;
          }
          if ($estad['seminario_i']=='4'){
            $seminario_i_4++;
          }
          if ($estad['seminario_i']=='5'){
            $seminario_i_5++;
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
        ["RNPT", <?php echo $edad_i_1;?>, "#009044"],
        ["Neonato", <?php echo $edad_i_2;?>, "026edd"],
        ["1-6m", <?php echo $edad_i_3;?>, "9b4df1"],        
        ["6m-1a", <?php echo $edad_i_4;?>, "f7de68"],
        ["1a-15a", <?php echo $edad_i_5;?>, "f73f3f"],
        ["Adulto", <?php echo $edad_i_6;?>, "7BD3CE"],
        [">70a", <?php echo $edad_i_7;?>, "#F8BBD0"]    
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


 <div class="col-xl-4 col-md-6">
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Cirugía", "Valor", { role: "style" } ],
        ["C.General", <?php echo $procedimiento_i_1;?>, "#009044"],
        ["C.Pediátrica", <?php echo $procedimiento_i_2;?>, "#026edd"],
        ["Cesárea", <?php echo $procedimiento_i_3;?>, "#9b4df1"],        
        ["Vascular", <?php echo $procedimiento_i_4;?>, "#f7de68"],
        ["Tórax", <?php echo $procedimiento_i_5;?>, "#f73f3f"],
        ["Neuro", <?php echo $procedimiento_i_6;?>, "#7BD3CE"],
        ["Otro", <?php echo $procedimiento_i_7;?>, "#F8BBD0"]    
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
        ["E.P.A.", "Valor", { role: "style" } ],
        ["Completa", <?php echo $evaluacion_i_1;?>, "#009044"],
        ["Incompleta", <?php echo $evaluacion_i_2;?>, "#026edd"],
        ["No Realizada", <?php echo $evaluacion_i_3;?>, "#9b4df1"]   
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Evaluacion Preanestésica",
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
        ["Ventilacion", "Valor", { role: "style" } ],
        ["Solo", <?php echo $ventilacion_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $ventilacion_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $ventilacion_i_2;?>, "#9b4df1"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Ventilación con Máscara Facial",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
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
        ["Intubacion", "Valor", { role: "style" } ],
        ["Solo", <?php echo $intubacion_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $intubacion_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $intubacion_i_3;?>, "#9b4df1"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Intubación Orotraqueal",
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
        ["Ayudas", "Valor", { role: "style" } ],
        ["Solo", <?php echo $ayudas_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $ayudas_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $ayudas_i_3;?>, "#9b4df1"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Uso de Conductor/Bougie",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values5a"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values5a"></div>
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
        ["LMA", "Valor", { role: "style" } ],
        ["Solo", <?php echo $lma_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $lma_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $lma_i_3;?>, "#9b4df1"]   
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Máscara Laríngea",
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



  <div class="col-xl-4 col-md-6">
 <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["VVP", "Valor", { role: "style" } ],
        ["Solo", <?php echo $vvp_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $vvp_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $vvp_i_3;?>, "#9b4df1"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Vía Venosa Periférica",
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
        ["Espinal", "Valor", { role: "style" } ],
        ["Solo", <?php echo $espinal_i_1;?>, "#009044"],
        ["C/Ayuda", <?php echo $espinal_i_2;?>, "#026edd"],
        ["Fallida", <?php echo $espinal_i_3;?>, "#9b4df1"] 
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Anestesia Espinal/Raquidea",
        width: 350,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values8"));
      chart.draw(view, options);
  }
  </script>
<div id="columnchart_values8"></div>
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
        ["Seminario", "Valor", { role: "style" } ],
        ["Vía Aérea", <?php echo $seminario_i_1;?>, "#009044"],
        ["A.Neuroaxial", <?php echo $seminario_i_2;?>, "#026edd"],
        ["RCP", <?php echo $seminario_i_3;?>, "#9b4df1"],        
        ["Transfusiones", <?php echo $seminario_i_4;?>, "#f7de68"],
        ["Dolor", <?php echo $seminario_i_5;?>, "#f73f3f"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Seminarios",
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
