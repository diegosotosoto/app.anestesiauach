<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>


<?php
		require("app/conectar.php");
	$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
	$conexion->set_charset("utf8");

	$consulta_bec="SELECT `becad_` FROM `usuarios_dolor` WHERE `nombre_usuario` = 'Diego Soto'";
	$confirma_bec=$conexion->query($consulta_bec); 
	$bec=$confirma_bec->fetch_assoc();


	if($bec['becad_']==1){

		echo "Es becado";
		//$pdf->Cell(150,10,"Anestesiólogo(a)",0,0,'R');

	}else {

		echo "no es becado";
		//$pdf->Cell(150,10,"Becado(a) Anestesiología",0,0,'R');

	}

?>


</body>
</html>

		