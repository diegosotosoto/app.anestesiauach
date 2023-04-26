<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}


    //Variables

    $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
    $titulo_navbar="<div class='text-white'>Correos</div>";
    $boton_navbar="<a></a><a></a>";

	
	//Carga Head de la página
	require("head.php");


		$consulta_corr="SELECT * FROM `usuarios_dolor` WHERE `verified` = '1'";
		$busqueda_corr=$conexion->query($consulta_corr);
		


 // $fila['nombre_usuario']

?>
	


<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

		<div class="form-group text-center ms-3 pt-3 pb-3 mt-2">
		 <input type="text" class="form-control" style="width:90%" id="search" placeholder="Busca un Correo...">
		</div>
		<div class="pt-2 pb-4" id="mytable">
		<?php

					while($fila=$busqueda_corr->fetch_assoc()){

						if($fila['admin']=='1'){
							$calidad='Administrador';
						} elseif($fila['staff_']=='1'){
							$calidad='Anestesiólog@';
						} elseif($fila['becad_']=='1'){
							$calidad='Becad@';
						} elseif($fila['intern_']=='1'){
							$calidad='Intern@';
						} 
					  
				echo "<ul class='list-group'><div class='list-group-item py-3' style='font-size: min(max(14px, 1.5vw), 16px)'>

					<a class='text-decoration-none' href='mailto:".$fila['email_usuario']."'><p class='fw-bold my-0'>".$fila['nombre_usuario']."</p><p class='my-0'>".$calidad."</p><p class='my-0'>".$fila['email_usuario']."</p></a>

		        	</div></ul>";
		      
					}

		?>
	



		</div>

    <div class="row py-3">
      <div class="col">
        <div class='text-muted pt-3'>Disclaimer</div>
        <textarea class="form-control opacity-50" id="terms_conditions" rows="5" readonly style="resize: none; font-size: min(max(14px, 1.5vw), 16px)">
		La información contenida en esta sección del directorio de correos y usuarios es confidencial y está destinada únicamente para uso interno del programa de formación de Anestesiología de la Universidad Austral de Chile. No se permite la divulgación o distribución de esta información a terceros sin el consentimiento expreso de los responsables del programa. Al acceder a esta sección, aceptas cumplir con estas condiciones y proteger la privacidad de los usuarios del programa.
		</textarea>
		</div>
	</div>


</div>




<script>
 // Write on keyup event of keyword input element
 $(document).ready(function(){
 $("#search").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#mytable ul div"), function() {
 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
 $(this).hide();
 else
 $(this).show();
 });
 });
});
</script>

	<?php
		//Conexión
		require("footer.php");

	?>






