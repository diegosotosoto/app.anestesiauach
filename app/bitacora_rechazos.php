<?php
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
			header('Location: login.php');
		}

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");


	//redirección segun nivel de usuario: BECADO
	$check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	$con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro`   FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	$users_b=$conexion->query($con_users_b);
	$usuario=$users_b->fetch_assoc();
	if($usuario['admin']==1){
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['staff_']==1) {
			header('Location: bitacora_autoriza.php');
		} elseif ($usuario['intern_']==1 or $usuario['becad_otro']==1) {
 			header('Location: bitacora_internos.php');
		} elseif ($usuario['becad_']==1) {
			//CONTINUA EN LA PAGINA
		}


	  //Variables

		$boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='; --bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link" href="bitacora_ingreso.php">Ingreso</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="bitacora_estadistica.php">Estadística</a>
  </li>
   <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Rechazos</a>
  </li> 
</ul>


<ul class="list-group">


 
	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'> Rechazos Bitácoras</h5>";


		//BOTON A LA IZQUIERDA DEL TITULO
		echo "<div class='pt-1 ps-3 me-3 d-flex float-start'>
		<a class='btn pull-left btn-primary shadow-sm border-light d-none d-sm-block' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>
		</div>";

		//BOTÓN A LA DERECHA DEL TITULO
		echo "<span class='float-end'>
		<div class='pt-1 ps-3 me-3 d-flex justify-content-end'>
		<a class='pe-5'></a>
		</div>
		</span>";

		//SUBTITULO
		echo "<div class='mb-1'></div>";
		echo "<div class='mb-1'></div></li>";
	?>


		<!– TABLA DE REGISTROS –>
<div class='container text-center pt-3'>
		


<?php 
	$autor_b=$_COOKIE['hkjh41lu4l1k23jhlkj13'];

	$con_users="SELECT `autor_b`,`staff_b`, COUNT(`staff_b`) AS `cantidad` FROM `bitacora_proced` WHERE `autor_b` = '$autor_b' AND `aprobado_staff_b` = 3 GROUP BY `staff_b`";

	$tab_users=$conexion->query($con_users);

if ($tab_users->num_rows > 0) {
	echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Staff</div><div> Cantidad Rechazada</div></div></li>";
$i=0;
    // Imprimir los resultados
    while ($row = $tab_users->fetch_assoc()) {
        echo "<form id='gest".$i."' action='bitacora_rechazos_detalle.php' method='post'><a href='#' onclick='envioForm".$i."()' class='list-group-item list-group-item-action'>
        <input type='hidden' name='nombre_staff' value='".$row["staff_b"]."'/>
        <div class='d-flex justify-content-between'><div>" . $row["staff_b"] . "</div><div> " . $row["cantidad"] . "</div></div></a></form>
        <script>function envioForm".$i."() {document.getElementById('gest".$i."').submit(); }</script>
        ";

        $i++;
    }
} else {
    echo "<li class='list-group-item'>No se encontraron resultados</li>";
}
					

?>




			</ul>
					</div>







	





<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>
