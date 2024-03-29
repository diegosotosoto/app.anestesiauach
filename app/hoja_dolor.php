<?php 

//Validador login
require("valida_pag.php");

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

//Saca a los internos y otros becados del area de dolor
	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `intern_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['intern_']==1 or $usuario['becad_otro']==1){
	  	header('Location: login.php');
	  }


//Variables sin conexion
	$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
	$titulo_navbar="<div class='text-white'>Pacientes Dolor HBV</div>";
	$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>";


//Carga Head de la página
require("head.php");

?>
<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->
<ul class="list-group">


	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'> Manejo de Dolor Agudo</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO
		echo "<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<a class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='width:50px; height:40px; --bs-border-opacity: .1;' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>
		</div>
		</span>";

		//SUBTITULO
		echo "<div class='mb-1'>HBV</div>";
		echo "<div class='mb-1'></div></li>";
	?>



		<div class="list-group py-3" id="link_wrapper">
		<!-  CARGA CONTENIDO DE PACIENTES  ->
		</div>


		<div class="pt-3 ps-3 me-3 d-flex justify-content-end">
		<a class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg pe-2' style='color:white' aria-hidden='true'></i>Nuevo Paciente</a>
		</div>

</ul>
</div>






	<?php 
		//Cierre Conexión
		$conexion->close();
	?>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

		<!-  SCRIPT PARA CARGAR CONTENIDO DE PACIENTES  ->	
<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "server.php", true);
  xhttp.send();
}
setInterval(function(){
	loadXMLDoc();
	// 1sec
},1000);

window.onload = loadXMLDoc;
</script>

