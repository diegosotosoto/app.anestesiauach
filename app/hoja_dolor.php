<?php 

//Validador login
require("valida_pag.php");


//Variables sin conexion
	$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
	$titulo_navbar="<div class='text-white'>Pacientes Dolor HBV</div>";
	$boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>";


//Carga Head de la página
require("head.php");

?>
<div class="col col-sm-8 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


		<div class="list-group py-3" id="link_wrapper">
		<!-  CARGA CONTENIDO DE PACIENTES  ->
		</div>


		<div class="pt-3 ps-3 me-3 d-flex justify-content-end">
		<a class='btn pull-right btn-primary shadow-sm border-light d-none d-sm-block' style='; --bs-border-opacity: .1;' href='nuevo_paciente.php'><i class='fa fa-plus fa-lg pe-2' style='color:white' aria-hidden='true'></i>Nuevo Paciente</a>
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

