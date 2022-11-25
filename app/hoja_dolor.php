<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//Carga Head de la página
	require("head.php");

?>

</head>
<body>

<!-  NAVBAR  ->	

	<?php
		//Botones del Toggle NAVBAR


		$boton_toggler="<a class='btn btn-lg shadow-sm' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Ficha Dolor HBV";
		$boton_navbar="<a class='btn btn-lg shadow-sm' href='nuevo_paciente.php' role='button'><i class='fa fa-plus fa-lg' style='color:white' aria-hidden='true'></i></a>";
		//Conexión
		require("navbar.php");
	?>




<br>
<br>



		<div class="list-group py-3" id="link_wrapper">
		<!-  CARGA CONTENIDO DE PACIENTES  ->


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
</body>
</html>

