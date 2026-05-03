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
		$boton_toggler="<a class='d-sm-block d-sm-none admin-back-btn' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<div>Pacientes Dolor HBV</div>";
		$boton_navbar="<a class='d-sm-block d-sm-none app-nav-action' href='nuevo_paciente.php' aria-label='Nuevo paciente'><i class='fa fa-plus fa-lg' aria-hidden='true'></i></a>";


//Carga Head de la página
require("head.php");

?>
	<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">
		<div class="apunte-surface">
			<div class="container-fluid px-0 px-md-2">
				<div class="pain-shell">


		<section class="app-hero app-hero-blue">
			<div class="app-hero-row">
				<div class="app-hero-body">
					<div class="app-hero-kicker">APP clínica • dolor agudo</div>
					<h2>Manejo de Dolor Agudo</h2>
					<p>Pacientes activos para seguimiento clínico y registro diario.</p>
				</div>
			</div>
		</section>

		<div class="pain-actions d-none d-sm-flex justify-content-between">
			<a class="admin-back-btn" href="index.php"><i class="fa fa-chevron-left"></i>Atrás</a>
			<a class="btn btn-app-primary pain-action-btn" href="nuevo_paciente.php" aria-label="Nuevo paciente"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></a>
		</div>



			<div class="pain-list-host py-3" id="link_wrapper">
			<!-  CARGA CONTENIDO DE PACIENTES  ->
			</div>


			<div class="pain-actions">
			<a class='btn btn-app-primary pain-action-btn' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg' aria-hidden='true'></i>Nuevo Paciente</a>
			</div>

				</div>
			</div>
		</div>
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
