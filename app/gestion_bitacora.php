<?php
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
			header('Location: login.php');
		}

	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	//chequea privilegios de administrador

	  $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
	  $con_users_b="SELECT `admin`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
	  $users_b=$conexion->query($con_users_b);
	  $usuario=$users_b->fetch_assoc();
	  if($usuario['admin']!=1){
		header('Location: login.php');
	  }


	  //Variables

		$boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='; --bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
		$boton_navbar="<a></a><a></a>";

	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->
<ul class="list-group">


	<?php
		//TITULO DE LA PAGINA
		echo "<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);'><br><h5 class='mb-1 fw-bold'> Gestión Bitácoras</h5>";


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

<li class='list-group-item text-center' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'>
	Bitácoras de Becados
</li>

<?php 

	$con_users="SELECT `staff_b`, COUNT(`staff_b`) AS `cantidad` FROM `bitacora_proced` WHERE `aprobado_staff_b` = 0 GROUP BY `staff_b`";

	$tab_users=$conexion->query($con_users);

if ($tab_users->num_rows > 0) {
	echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Staff</div><div> Cantidad sin validar</div></div></li>";

    // Imprimir los resultados
    while ($row = $tab_users->fetch_assoc()) {
        echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>" . $row["staff_b"] . "</div><div> " . $row["cantidad"] . "</div></div></li>";
    }
} else {
    echo "<li class='list-group-item'>No se encontraron resultados</li>";
}
					

?>

<li class='list-group-item text-center' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'>
	Bitácoras de Internos
</li>


<?php 

	$con_users_i="SELECT `staff_i`, COUNT(`staff_i`) AS `cantidad_i` FROM `bitacora_internos` WHERE `aprobado_staff_i` = 0 GROUP BY `staff_i`";

	$tab_users_i=$conexion->query($con_users_i);

if ($tab_users_i->num_rows > 0) {

	echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>Staff</div><div> Cantidad sin validar</div></div></li>";
    // Imprimir los resultados
    while ($row_i = $tab_users_i->fetch_assoc()) {
        echo "<li class='list-group-item'><div class='d-flex justify-content-between'><div>" . $row_i["staff_i"] . "</div><div> " . $row_i["cantidad_i"] . "</div></div></li>";
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
