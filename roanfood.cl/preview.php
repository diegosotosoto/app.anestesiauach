<?php
//variables
		$boton_toggler="<a class='btn pt-2 pb-2 navbar-toggler border-secondary btn-seconday d-xs-block d-sm-none' style='; --bs-border-opacity: .1;' type='button' href='index.php'><div><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='fs-5'><img class='pe-2' src='images/icon.png' style='width: 48px' /></span>Menú <small class='ps-5 opacity-50' style='font-size: 10px'>&nbsp;</small>";


	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41laa8u4l1k23jhlkj1387s76d8as76a9sd8'])){
		header('Location: login.php');
	}
	//Conexión
	require("conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");
	
	//Carga Head de la página
	require("head.php");

?>
   <div class="col col-sm-8 col-xl-8">

	<form class="needs-validation" name="form_ingreso" id="form_ingreso" method="post" action="preview.php" novalidate>
<!-  NAVBAR  ->	

			<ul class="list-group pt-3">
			<li class='list-group-item pb-4'><br><h5 class='mb-1 fw-bold'>PREVIEW</h5></li>
			</ul>


		<!– TABLA DE REGISTROS –>
				<div class='container'>
				<div class='row'>	

				<div class='col'>
<?php
	//confirma que la cookie existe para hacer la operación
	if(isset($_COOKIE['hkjh41laa8u4l1k23jhlkj1387s76d8as76a9sd8'])){


				if($_POST['opcion_1']){
							$fecha_menu=htmlentities(addslashes($_POST['fecha_menu']));
							$opcion_1=htmlentities(addslashes($_POST['opcion_1']));
							$opcion_2=htmlentities(addslashes($_POST['opcion_2']));
							$opcion_3=htmlentities(addslashes($_POST['opcion_3']));
							$opcion_4=htmlentities(addslashes($_POST['opcion_4']));


							$consulta_fecha="SELECT * FROM `menu_diario_rf` WHERE `fecha` = '$fecha_menu'";
							$confirma_fecha=$conexion->query($consulta_fecha); 

							if(mysqli_num_rows($confirma_fecha)==0){//AL NO ENCONRAR REGISTROS DE FECHA
										//REUNE LA INFORMACION DE LA BASE DE DATOS Y CONSTRUYE LAS VARIABLES
										$consulta_inventario_1="SELECT * FROM `fondo_rf` WHERE `id_fondo` = '$opcion_1'";
										$confirma_inventario_1=$conexion->query($consulta_inventario_1); 
										$fila_1=$confirma_inventario_1->fetch_assoc();
										$id1=$fila_1['id_fondo'];
										$nombre1=$fila_1['nombre_plato_fon'];
										$descrip1=$fila_1['descripcion_plato_fon'];
										$precio1=$fila_1['precio_plato_fon'];
										$foto1=$fila_1['nombre_foto_fon'];

										$consulta_inventario_2="SELECT * FROM `fondo_rf` WHERE `id_fondo` = '$opcion_2'";
										$confirma_inventario_2=$conexion->query($consulta_inventario_2); 
										$fila_2=$confirma_inventario_2->fetch_assoc();
										$id2=$fila_2['id_fondo'];
										$nombre2=$fila_2['nombre_plato_fon'];
										$descrip2=$fila_2['descripcion_plato_fon'];
										$precio2=$fila_2['precio_plato_fon'];
										$foto2=$fila_2['nombre_foto_fon'];

										$consulta_inventario_3="SELECT * FROM `fondo_rf` WHERE `id_fondo` = '$opcion_3'";
										$confirma_inventario_3=$conexion->query($consulta_inventario_3); 
										$fila_3=$confirma_inventario_3->fetch_assoc();
										$id3=$fila_3['id_fondo'];
										$nombre3=$fila_3['nombre_plato_fon'];
										$descrip3=$fila_3['descripcion_plato_fon'];
										$precio3=$fila_3['precio_plato_fon'];
										$foto3=$fila_3['nombre_foto_fon'];

										$consulta_inventario_4="SELECT * FROM `fondo_rf` WHERE `id_fondo` = '$opcion_4'";
										$confirma_inventario_4=$conexion->query($consulta_inventario_4); 
										$fila_4=$confirma_inventario_4->fetch_assoc();
										$id4=$fila_4['id_fondo'];
										$nombre4=$fila_4['nombre_plato_fon'];
										$descrip4=$fila_4['descripcion_plato_fon'];
										$precio4=$fila_4['precio_plato_fon'];
										$foto4=$fila_4['nombre_foto_fon'];

								    //AGREGA REGISTRO NUEVO
										$consulta_n="INSERT INTO `menu_diario_rf` (`fecha`, `opcion_1`, `descripcion_1`, `precio_1`, `foto_1`, `opcion_2`, `descripcion_2`, `precio_2`, `foto_2`, `opcion_3`, `descripcion_3`, `precio_3`, `foto_3`, `opcion_4`, `descripcion_4`, `precio_4`, `foto_4`) VALUES ('$fecha_menu', '$nombre1', '$descrip1', '$precio1', '$foto1', '$nombre2', '$descrip2', '$precio2', '$foto2', '$nombre3', '$descrip3', '$precio3', '$foto3', '$nombre4', '$descrip4', '$precio4', '$foto4') ";

										$escribir=$conexion->query($consulta_n);

										echo "El registro se ha escrito con éxito";

										if($escribir==false){
											echo "Error en la consulta";

										}

							}else {//ya existe registro con esa fecha

								echo "ya existe un registro para esta fecha";


							}

							//ACCEDE AL REGISTRO RECIEN GUARDADO;
							$consulta_menu_rf="SELECT * FROM `menu_diario_rf` WHERE `fecha` = '$fecha_menu'";
										$confirma_menu_rf=$conexion->query($consulta_menu_rf); 
										$menu_g=$confirma_menu_rf->fetch_assoc();




				}

	}
?>

					</div>
				</div>
				</div>

		</form>




  <div id="container" class="container text-center"  style="background-image: url(images/fondo_menu.jpeg);
 background-size: 100% auto;">
  <div class="row">

    <div class="col col-7 text-light">
    

      <div class="container text-start pt-3">
         <div class="row pt-2">
          <div class="pt-0 pb-0 text-light text-center" style="font-size: min(max(28px, 4vw), 38px)">MENÚ</div>
          <div class="pt-0 pb-2 text-light text-center opacity-75" style="font-size: min(max(12px, 1.5vw), 20px);font-weight: bold;">
           <?php 

						$orgDate = $menu_g['fecha'];
						$date = str_replace('/', '-', $orgDate);
						setlocale(LC_TIME, 'es_CL.UTF-8','esp');
						echo strftime("%A %d de %B", strtotime($date));
						echo $newDate;

           ?>
        	</div>
          <hr class="border-5 opacity-75 text-center" style="width:95%">
        </div>

         <div class="row pt-3">
            <div class="col col-6 ms-0 me-0 ps-0">
              <img src="images/<?php echo $menu_g['foto_1']?>.jpg" class="rounded-circle" style="max-width: 100% ; border: 3px solid #555;" />
            </div>
            <div class="col col-6 ms-0 me-0 ps-0 pt-1">
              <div class="text-start" style="font-size: min(max(12px, 2vw), 22px)"><?php echo $menu_g['opcion_1']?></div>
              <div class="text-start pt-2 opacity-50" style="font-size: min(max(10px, 1.5vw), 18px)"><?php echo $menu_g['descripcion_1']?></div>
              <div><hr class="text-muted mt-1 mb-1"></div>
              <div class="text-end text-warning pt-0" style="font-size: min(max(12px, 2vw), 22px)">$ <?php echo number_format($menu_g['precio_1'], 0, ' ', '.'); ?></div>
            </div>
         </div>

         <div class="row pt-3">
            <div class="col col-6 ms-0 me-0 ps-0">
              <img src="images/<?php echo $menu_g['foto_2']?>.jpg" class="rounded-circle" style="max-width: 100% ; border: 3px solid #555;" />
            </div>
            <div class="col col-6 ms-0 me-0 ps-0 pt-1">
              <div class="text-start" style="font-size: min(max(12px, 2vw), 22px)"><?php echo $menu_g['opcion_2']?></div>
              <div class="text-start pt-2 opacity-50" style="font-size: min(max(10px, 1.5vw), 18px)"><?php echo $menu_g['descripcion_2']?></div>
              <div><hr class="text-muted mt-1 mb-1"></div>
              <div class="text-end text-warning pt-0" style="font-size: min(max(12px, 2vw), 22px)">$ <?php echo number_format($menu_g['precio_2'], 0, ' ', '.'); ?></div>
            </div>
         </div>

         <div class="row pt-3">
            <div class="col col-6 ms-0 me-0 ps-0">
              <img src="images/<?php echo $menu_g['foto_3']?>.jpg" class="rounded-circle" style="max-width: 100% ; border: 3px solid #555;" />
            </div>
            <div class="col col-6 ms-0 me-0 ps-0 pt-1">
              <div class="text-start" style="font-size: min(max(12px, 2vw), 22px)"><?php echo $menu_g['opcion_3']?></div>
              <div class="text-start pt-2 opacity-50" style="font-size: min(max(10px, 1.5vw), 18px)"><?php echo $menu_g['descripcion_3']?></div>
              <div><hr class="text-muted mt-1 mb-1"></div>
              <div class="text-end text-warning pt-0" style="font-size: min(max(12px, 2vw), 22px)">$ <?php echo number_format($menu_g['precio_3'], 0, ' ', '.'); ?></div>
            </div>
         </div>

         <div class="row pt-3 pb-4">
            <div class="col col-6 ms-0 me-0 ps-0">
              <img src="images/<?php echo $menu_g['foto_4']?>.jpg" class="rounded-circle" style="max-width: 100% ; border: 3px solid #555;" />
            </div>
            <div class="col col-6 ms-0 me-0 ps-0 pt-1">
              <div class="text-start" style="font-size: min(max(12px, 2vw), 22px)"><?php echo $menu_g['opcion_4']?></div>
              <div class="text-start pt-2 opacity-50" style="font-size: min(max(10px, 1.5vw), 18px)"><?php echo $menu_g['descripcion_4']?></div>
              <div><hr class="text-muted mt-1 mb-1"></div>
              <div class="text-end text-warning pt-0" style="font-size: min(max(12px, 2vw), 22px)">$ <?php echo number_format($menu_g['precio_4'], 0, ' ', '.'); ?></div>
            </div>
         </div>         



      </div>





    </div>
    <div class="col ps-1 col-5">
         <div class="row ps-1 pt-2 mt-2">

          <div class="pt-2 pb-2 text-secondary text-center" style="font-size: min(max(20px, 3vw), 30px)">Hipocalóricos</div>
          <hr class="border-5 pb-0 opacity-50 text-center" style="width:95%">   

              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Ensalada Cesar</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga, pechuga de pollo grillado, palta, tomate y crutones</div>
              <div><hr class="text-muted mt-1 mb-1"></div>      
         </div>

          <div class="row ps-1 pt-2">
              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Palta reina</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga, zanahoria, choclo, tomate y la palta rellena con pasta de pollo y mayo</div>
              <div><hr class="text-muted mt-1 mb-1"></div>
              
         </div>


          <div class="row ps-1 pt-2">
              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Ensalada Atún</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga, zanahoria, Choclo, palta, lomo atún y aceitunas</div>
              <div><hr class="text-muted mt-1 mb-1"></div>     
         </div>


          <div class="row ps-2 pt-2">
              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Ensalada Quesillo</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga, zanahoria, choclo, huevo duro, palta, tomate, aceitunas y quesillo</div>
              <div><hr class="text-muted mt-1 mb-1"></div>
         </div>          

          <div class="row ps-1 pt-2">
              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Ensalada Palmitos</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga y arroz, palta, Choclo, tomate, jamón de pavo y palmitos</div>
              <div><hr class="text-muted mt-1 mb-1"></div>
         </div>

         <div class="row ps-1 pt-2">
              <li class='list-group-item'><div class='d-flex justify-content-between'>
              <div class="text-start ps-2" style="font-size: min(max(12px, 2vw), 22px)">Tomate Relleno</div>
              <div class="text-end pt-0 pe-2" style="font-size: min(max(12px, 2vw), 22px); color: #D9AD00; font-weight: bold;">$ 4.000</div>
              </li>
              <div class="text-start pt-1 pb-1 opacity-75" style="font-size: min(max(10px, 1.5vw), 18px)">Base lechuga, zanahoria,Choclo, palta y el tomate relleno con pasta de pollo y mayo</div>
              <div><hr class="text-muted mt-1 mb-1"></div>
         </div>

         <div class="row ps-2 pt-2 mt-2">
          <div class="pb-2 text-secondary text-center" style="font-size: min(max(18px, 2.5vw), 26px)">Bebidas</div>
          <hr class="border-5 pb-1 opacity-50 text-center" style="width:95%">  
         </div> 

          <div class="row pt-0 ps-1 pe-1 pb-4">
              <li class='list-group-item'><div class='d-flex justify-content-between'><div class="text-start pt-1 ms-2" style="font-size: min(max(12px, 2vw), 22px)">Lata 350cc</div><div class="text-end pt-0 me-2" style="font-size: min(max(12px, 2vw), 20px); color: #D9AD00; font-weight: bold;">$ 1.200</div></div></li>

              <li class='list-group-item'><div class='d-flex justify-content-between'><div class="text-start pt-1 ms-2" style="font-size: min(max(12px, 2vw), 22px)">Botella 250 cc</div><div class="text-end pt-0 me-2" style="font-size: min(max(12px, 2vw), 20px); color: #D9AD00; font-weight: bold;">$ 1.000</div></div></li>
         </div>     

    </div>

  <hr class="border-0 ms-4 text-light opacity-75 text-center" style="height: 2px; width:90%; background-image: linear-gradient(to right, white, black);">

      <div class="col col-7 text-light">
        


      </div>
  </div>
</div>

















</div>



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
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
					var currentDate = new Date();
					var currentDayOfMonth = currentDate.getDate();
					var dayOfMonthFormatted = (currentDayOfMonth+1).toString().padStart(2, "0");
					var currentMonth = currentDate.getMonth().toString().padStart(1, "0"); // Be careful! January is 0, not 1
					var currentYear = currentDate.getFullYear();
					var dateString = (dayOfMonthFormatted) + "/" + (currentMonth + 1) + "/" + currentYear;

    			today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $(function() {
            $('#datepicker').datepicker({

            	 		uiLibrary: 'bootstrap5',
            	    format: 'dd/mm/yyyy',
            	    weekStartDay: 1,
            	    autoclose: true,
            	    showRightIcon: true,
            	    showOnFocus: true,
            	    value: dateString,
            }

            	);

        });


    </script>

	<?php 

		$conexion->close();
		require("footer.php");

	?>