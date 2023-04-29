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
			//CONTINUA EN LA PAGINA
		} elseif ($usuario['staff_']==1) {
			//CONTINUA EN LA PAGINA
		} elseif ($usuario['intern_']==1) {
			header('Location: bitacora_internos.php');
		} elseif ($usuario['becad_']==1) {
			header('Location: bitacora_ingreso.php');
		}


//VARIABLES
	
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<span class='text-white'>Bitácora</span>";
		$boton_navbar="<a></a>";

	//Carga Head de la página
	require("head.php");

?>

<div class="col col-sm-8 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

<ul class="nav nav-tabs pt-1">
  <li class="nav-item">
    <a class="nav-link" href="bitacora_autoriza.php">Validación</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Revisión</a>
  </li>  
</ul>

			<ul class="list-group">
			<li class='list-group-item' style='background-color: #e9effb; background-image: linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%'><h4 class='mb-1 fw-bold pt-2'>Revisar Bitácora</h4><div class='text-black-75 pt-1' style='font-size: 14px'> 
			</div>
			</li>
			</ul>


<div class="container text-center">





<div class='row pt-2'>
		<form action='bitacora_estadistica.php' method='post'>
	<ul class='list-group'>

<li class='list-group-item' style='background-color: #e9effb;'><br><h6 class='fw-bold'>Becados: </h6>



<div class='d-flex justify-content-between'>	


							<select class="form-select" id="revision" name="revision" required>
							  <option value=""></option>


						<?php 
							$con_users_b="SELECT `nombre_usuario`,`email_usuario` FROM `usuarios_dolor` WHERE `becad_` = '1' ";
							$users_b=$conexion->query($con_users_b);

							while ($usuari=$users_b->fetch_assoc()) {

								echo "<option value='".$usuari['email_usuario']."'>".$usuari['nombre_usuario']."</option>";

							}

						?>

						</select>



					<button class='btn btn-primary btn-md shadow-sm border-light' type='submit' name='editar'>Revisar</button>		
				</div>

</li>
</ul>
</form>
</div>


<div class='row py-2'>
		<form action='bitacora_estad_i.php' method='post'>
	<ul class='list-group'>

<li class='list-group-item' style='background-color: #e9effb;'><br><h6 class='fw-bold'>Internos: </h6>



<div class='d-flex justify-content-between'>	


							<select class="form-select" id="revision_i" name="revision_i" required>
							  <option value=""></option>


						<?php 
							$con_users_b="SELECT `nombre_usuario`,`email_usuario` FROM `usuarios_dolor` WHERE `intern_` = '1' ";
							$users_b=$conexion->query($con_users_b);

							while ($usuari=$users_b->fetch_assoc()) {

								echo "<option value='".$usuari['email_usuario']."'>".$usuari['nombre_usuario']."</option>";

							}

						?>

						</select>



					<button class='btn btn-primary btn-md shadow-sm border-light' type='submit' name='editar'>Revisar</button>		
				</div>

</li>
</ul>
</form>
</div>







</div>


</ul>

<!- chequear que no haya otro ingresado antes -> 

	<?php 

		$conexion->close();
		require("footer.php");

	?>





<!-  FOOTER  ->
