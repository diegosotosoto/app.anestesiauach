<?php

	//Ve si está activa la cookie o redirige al login
	if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
		header('Location: login.php');
	}


    //Variables

    $boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
    $titulo_navbar="<div class='text-white'>Teléfonos</div>";
    $boton_navbar="<a></a><a></a>";

	
	//Carga Head de la página
	require("head.php");

?>
	

	<!- INICIO DEL ITEM ->
<?php

$array_frec = array(
'RECUPERACIÓN CENTRAL'	=> '63 2263491'
,'RECUPERACIÓN H'	=> '63 2263936'
,'RECUPERACIÓN MATERNIDAD'	=> '63 2263604'
,'BANCO SANGRE TECNÓLOGO'	=> '63 2263768'
,'BANCO SANGRE'	=> '63 2263775'
,'UCI 1'	=> '63 2263499'
,'UCI 2'	=> '63 2263554'
,'UCI PEDIÁTRICA'	=> '63 2263654'
,'UCI NEONATOLOGÍA'	=> '63 2263589'
,'UCI PED. RESID. MÉDICA'	=> '63 2263650'
,'UTI QUIRÚRGICA'	=> '63 2263815'
,'UTI MÉDICA'	=> '63 2263517'
,'UTI 3'	=> '63 2263527'
,'RESI BECADOS ANESTESIA'	=> '63 2263511'
,'PARTOS PABELLÓN'	=> '63 2263605'
,'PREPARTO'	=> '63 2263599'
,'EST. MATRONERÍA PARTOS'	=> '63 2263604'
,'SALA ESTAR PERSONAL'	=> '63 2263496'
,'RESI MÉDICA ANESTESIA'	=> '63 2263495'
,'GESTIÓN DE CAMAS'	=> '63 2263847'
,'GESTIÓN DE CAMAS 2'	=> '63 2263916'
,'LABORATORIO CENTRAL RECEPCION'	=> '63 2263309'
,'LABORATORIO CENTRAL SEC.'	=> '63 2263305'
,'RESIDENCIA UCI 1.'	=> '63 2263635'
);

$array_tel = array (
'AP ADULTO MÉDICO TURNO'	=> '63 2263765'
,'AP ADULTO OBSERVACIÓN'	=> '63 2263761'
,'AP PEDIÁTRICA RECEPCIÓN'	=> '63 2263754'
,'BOX URGENCIA'	=> '63 2263607'
,'CUIDADOS INTERMEDIOS'	=> '63 2263554'
,'EST. ENF. ARO'	=> '63 2263735'
,'EST. ENF. CIRUGÍA HOMBRE'	=> '63 2263705'
,'EST. ENF. CIRUGÍA MUJER'	=> '63 2263703'
,'EST. ENF. CIRUGÍA DIGESTIVO'	=> '63 2263698'
,'EST. ENF. CIRUGÍA INFANTIL'	=> '63 2263648'
,'EST. ENF. GINECOLOGÍA'	=> '63 2263730'
,'EST. ENF. UCI INFANTIL'	=> '63 2263654'
,'EST. ENF. LACTANTE'	=> '63 2263687'
,'EST. ENF. MEDICINA 2DO P'	=> '63 2263516'
,'EST. ENF. MEDICINA 2DO P 2'	=> '63 2263517'
,'EST. ENF. MEDICINA HOMBRE'	=> '63 2263534'
,'EST. ENF. MEDICINA MUJER'	=> '63 2263527'
,'EST. ENF. MEDICINA'	=> '63 2263530'
,'EST. ENF. MEDICINA INFANTIL'	=> '63 2263687'
,'EST. ENF. HEMATO ADULTO'	=> '63 2263690'
,'EST. ENF. UTI3'	=> '63 2263527'
,'EST. ENF. NEONATOLOGIA'	=> '63 2263596'
,'EST. ENF. NEUROCIRUGÍA 1'	=> '63 2263025'
,'EST. ENF. NEUROCIRUGÍA 2'	=> '63 2263714'
,'EST. ENF. ONCOLOGÍA'	=> '63 2263584'
,'EST. ENF. ONCO INFANTIL'	=> '63 2263690'
,'EST. ENF. PABELLÓN'	=> '63 2263510'
,'EST. ENF. PENSIONADO'	=> '63 2263670'
,'EST. ENF. PUERPERIO'	=> '63 2263733'
,'EST. ENF. TRAUMA ADULTO'	=> '63 2263717'
,'EST. ENF. TRAUMA INFANTIL'	=> '63 2263719'
,'EST. DE ENF. UCI NEO'	=> '63 2263589'
,'EST. ENF. UCI ADULTO'	=> '63 2263499'
,'EST. ENF. UTI'	=> '63 2263554'
,'EST. ENF. UROLOGÍA'	=> '63 2263663'
,'ESTERILIZACION MAT. BLANCO'	=> '63 2263462'
,'ESTERILIZACION MAT. ESTERIL'	=> '63 2263457'
,'ESTERILIZACION MAT. SUCIO'	=> '63 2263463'
,'ESTERILIZACION PREP. MATERIAL'	=> '63 2263458'
,'ESTERILIZACION SEC.'  => '63 2263461'
,'ESTERILIZACION JEFATURA'	=> '63 2263460'
,'FARMACIA MEDICAMENTO'	=> '63 2263616'
,'FARMACIA PREP. SOLUCIONES'	=> '63 2263611'
,'FARMACIA SEC.'	=> '63 2263615'
,'GASES CLINICOS'	=> '63 2263993'
,'TOMA DE MUESTRA'	=> '63 2263336'
,'LABORATORIO HEMATOLOGÍA'	=> '63 2263326'
,'LABORATORIO NEFROLOGÍA'	=> '63 2263323'
,'PABELLON 1'	=> '63 2263500'
,'PABELLON 2'	=> '63 2263501'
,'PABELLON 3'	=> '63 2263502'
,'PABELLON 4'	=> '63 2263503'
,'PABELLON 5'	=> '63 2263504'
,'PABELLON 6'	=> '63 2263505'
,'PABELLON 7'	=> '63 2263506'
,'PABELLON 9'	=> '63 2263508'
,'PABELLON EST. ENF.'	=> '63 2263510'
,'RAYOS PASILLO'	=> '63 2263402'
,'RAYOS SCANNER'	=> '63 2263405'
,'SEC. SERVICIO CIRUGÍA'	=> '63 2263706'
,'SEC. SERVICIO CIRUGIA INFANTIL'	=> '63 2263906'
,'SEC. SERVICIO GINECOLOGIA'	=> '63 2263736'
,'SEC. SERVICIO MEDICINA'	=> '63 2263518'
,'SEC. SERVICIO NEUROCIRUGÍA'	=> '63 2263721'
,'SEC. SERVICIO ONCOLOGÍA'	=> '63 2263989'
,'SEC. SERVICIO PEDIATRÍA'	=> '63 2263683'
,'UGA'	=> '63 2263383'
,'URGENCIA ADULTO SHAP'	=> '63 2263761'
,'URGENCIA PEDRIATRICA'	=> '63 2263548'
,'URGENCIA PROCEDIMIENTO'	=> '63 2263571'
,'URGENCIA REANIMADOR'	=> '63 2263802'
);

?>

<div class="col col-sm-8 col-xl-9"><!- Columna principal (derecha) responsive->

		<div class="form-group text-center ms-3 pt-3 pb-3 mt-2">
		 <input type="text" class="form-control" style="width:90%" id="search" placeholder="Busca un Servicio...">
		</div>
		<div class="pt-2 pb-4" id="mytable">

		<?php

					foreach ($array_frec  as $servicio1 => $telefono1){
					    
		        echo "<ul class='list-group'><div class='list-group'><a href='tel:$telefono1' class='list-group-item list-group-item-action text-primary fs-5'>
		        	<i class='fa-solid fa-star pe-3 ps-2 text-warning'></i>$servicio1</a></div></ul>";
		      
					}

				echo "<ul class='list-group'><div class='list-group ps-5 text-secondary fs-4'> <br>OTROS </div></ul>";

					foreach ($array_tel  as $servicio => $telefono){
					    
		        echo "<ul class='list-group'><div class='list-group'><a href='tel:$telefono' class='list-group-item list-group-item-action text-primary fs-5'>
		        	<i class='fa-solid fa-phone pe-3 ps-2 text-success'></i>$servicio</a></div></ul>";
		      
					}

		?>
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






