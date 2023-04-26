<?php
//variables
		$boton_toggler="<a class='btn pt-2 pb-2 navbar-toggler border-secondary btn-seconday d-xs-block d-sm-none' style='; --bs-border-opacity: .1;' type='button' href='index.php'><div><i class='fa fa-chevron-left'></i>Atrás</div></a>";
		$titulo_navbar="<span class='fs-5'><img class='pe-2' src='images/icon.png' style='width: 48px' /></span>Acerca De <small class='ps-5 opacity-50' style='font-size: 10px'>&nbsp;</small>";

  //Carga Head de la p谩gina
  require("head.php");
?>

    <div class="col col-sm-8 col-xl-8">

<div class="container text-center mt-4">
		<ul class="list-group pt-3">
		<li class='list-group-item bg-gradient bg-secondary' style=' --bs-bg-opacity: 0.1;'>
	<div class="row">
		<div class="col pt-2 pb-0">
			<img style="width: 20%" src='images/roanfood256.png'/>
		</div>
	</div>
	<div class="row">
		<div class="col pb-2">
			<h1 class="pt-2 pb-0">Roanfood</h1>
			<div class='pt-0 mt-0 ps-2 opacity-75' style='font-size: 12px'>Sabor Casero</div>
		</div>
	</div>
	</li>
	</ul>
	<ul class="list-group pt-3">
		<li class='list-group-item bg-gradient bg-secondary' style=' --bs-bg-opacity: 0.1;'><div class='d-flex justify-content-between'><div>Autor</div><div>Diego Soto Soto</div></div></li>
		<li class='list-group-item bg-gradient bg-secondary' style=' --bs-bg-opacity: 0.1;'><div class='d-flex justify-content-between'><div>email</div><div>diegosotosoto@gmail.com</div></div></li>
	</ul>
	<ul class="list-group pt-3">
		<li class='list-group-item bg-gradient bg-secondary' style=' --bs-bg-opacity: 0.1;'><div class='d-flex justify-content-between'><div>http://roanfood.cl/</div>
			
    <button id="button" class="btn btn-primary">Compartir!</button>

    <script>
      let shareData = {
        title: 'Roanfood',
        text: 'Roanfood || Sabor Casero',
        url: 'https://roanfood.cl/',
      }

      const btn = document.querySelector('#button');
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
			<img src="images/codigo_qr.jpg" style="width:300px" class="rounded mx-auto d-block">
		</div></li>
		
	</ul>

</div>
</div>
</div>
</div>
<!-  FOOTER  ->

	<?php
		//Conexi贸n
		require("footer.php");

	?>
