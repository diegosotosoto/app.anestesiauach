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
	<?php


		$boton_toggler="<a class='btn btn-lg shadow-sm border-light' style='; --bs-border-opacity: .1;'  href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="Acerca de";
		$boton_navbar="<a class='navbar-brand mr-auto ms-5' href='#'' role='button'></a>";


		require("navbar.php");
	?>
	
<br>
<br>

<div class="container text-center mt-4">
		<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'>
	<div class="row">
		<div class="col pt-2">
			<img style="width: 80px; height: 80px;" src='images/logo192.png'/>
		</div>
	</div>
	<div class="row">
		<div class="col pb-2">
			<h1 class="pt-3">App Anestesiología UACH</h1>
		</div>
	</div>
	</li>
	</ul>
	<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div>Autor</div><div>Diego Soto Soto</div></div></li>
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div>email</div><div>diegosoto@anestesiauach.cl</div></div></li>
	</ul>
	<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div>app.anestesiauach.cl</div>
			
    <button class="btn btn-primary">Compartir!</button>

    <script>
      let shareData = {
        title: 'App Uach',
        text: 'Aplicación Anestesiología UACH',
        url: 'https://app.anestesiauach.cl/',
      }

      const btn = document.querySelector('button');
      const resultPara = document.querySelector('.result');

      btn.addEventListener('click', () => {
        navigator.share(shareData)
          .then(() =>
            resultPara.textContent = 'MDN shared successfully'
          )
          .catch((e) =>
            resultPara.textContent = 'Error: ' + e
          )
      });
    </script>

		</li>
		
		<li class='list-group-item'><div class='text-center'>
			<img src="images/IMG0001.jpeg" style="width:300px" class="rounded mx-auto d-block">
		</div></li>
		
	</ul>
</div>
<div class="pt-5 mb-2 text-center">
	  <p class="text-muted pb-2">Anestesia<small class='fw-bold'>  UACH &nbsp;<img src='images/austral.png' style='height: 36px; width: 36px; filter: invert(60%);'/></small></p>
</div>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

</body>
</html>