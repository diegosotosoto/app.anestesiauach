<?php
	//No requiere validador de página

	//Variables sin conexion
		$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px; --bs-border-opacity: .1;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
		$titulo_navbar="<div class='text-white'>Acerca de</div>";
		$boton_navbar="<span class='navbar-brand mr-auto ms-5' href='#'' role='button'></span>";


	//Carga Head de la página
	require("head.php");
?>

<div class="col col-sm-9 col-xl-9"><!- Columna principal (derecha) responsive->

<div class="container text-center mt-2">

		<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'>
	<div class="row">
		<div class="col pt-2">
			<img style="width: 80px; height: 80px;" src='images/logo192.png'/>
		</div>
	</div>
	<div class="row">
		<div class="col pb-2">
			<h3 class="pt-3">App Anestesia <span class="opacity-50">UACH</span></h3>
		</div>
	</div>
	</li>
	</ul>


	<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div><a class='text-dark text-decoration-none' href='https://app.anestesiauach.cl/'>app.anestesiauach.cl</a></div>
			
    <button id="button-compartir" class="btn btn-primary not-overlay">Compartir!</button>

    <script>
      let shareData = {
        title: 'Anest UACh',
        text: 'App Anestesia UACh',
        url: 'https://app.anestesiauach.cl/',
      }

      const btn = document.querySelector('#button-compartir');
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


	<ul class="list-group pt-3">
		<li class='list-group-item bg-light bg-gradient'><div class='text-center fw-bold'><div>¡Bienvenido a la Aplicación Web de los Residentes de Anestesiología de la UACh!</div></div></li>
		<li class='list-group-item bg-white bg-gradient'><div class='d-flex justify-content-between text-start text-black-75 ps-2 pe-2'><div>&nbsp;&nbsp;
			Nuestra aplicación es el lugar perfecto para que los Residentes e Internos de anestesiología encuentren recursos valiosos para mejorar conocimientos y habilidades. Aquí encontrarás contenido exclusivo, herramientas de cálculo, estudio y casos clínicos.<br>
			&nbsp;&nbsp;
			Además, nuestra aplicación te permitirá conectar con Residentes de Anestesiología y Especialistas de la UACh, lo que te brindará una valiosa oportunidad para aprender y compartir experiencia.<br>
			&nbsp;&nbsp;
			Estamos emocionados de tenerte a bordo y esperamos que disfrutes al máximo tu experiencia en nuestra app.<br> ¡Comienza a explorar ahora mismo!<br>
		</div></div></li>
	</ul>



	<ul class="list-group py-3">
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div class="fw-bold">Autor</div><div>Diego Soto Soto</div></div></li>
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div class="fw-bold">email</div><a class='text-dark text-decoration-none' href='mailto:diego.soto02@uach.cl'>diego.soto02@uach.cl</a></a></div></li>
		<li class='list-group-item bg-light bg-gradient'><div class='d-flex justify-content-between'><div class="fw-bold">íconos</div><a class='text-dark text-decoration-none' href='https://www.flaticon.com/authors/freepik' target="_blank">Freepik en flaticon.com</a></a></div></li>		
	</ul>



</div>
</div>

<!-  FOOTER  ->

	<?php
		//Conexión
		require("footer.php");

	?>

