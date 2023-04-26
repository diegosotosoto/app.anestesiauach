<?php

  //Variables
    $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";

      $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";

    $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
    require("head.php");

?>


<style type="text/css">
  input.texto-seguro{
  -webkit-text-security: disc;
  -moz-text-security: disc;
  text-security: disc;
  }
</style>

<div class="col col-sm-8 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->


<form class="needs-validation" action="login.php" method="post" novalidate autocomplete="nope" oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? "Passwords do not match." : "")'>
<div class="container text-center mt-4 pt-4">
    <a href="#" class="btn shadow bg-primary me-2 rounded-3 text-white border-0 pt-2" style="height: 220px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);">
    <div class="row pt-4">
      <h1>Eres Nuev@?<br><i class="fa-solid fa-crow ps-3"></i></h1>
    </div>
    <div class="row pt-3">
      <div class="col">
        Por favor, regístrate!
      </div>
    </div>
  </a>

    <div class="row pt-4">
      <div class="col">
        <div class='text-muted pt-3'>Nombre y Apellido</div>
        <div class="input-group mb-2">
      	<input type="text" name="nombre_usuario" class="form-control" pattern='[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{2,}' required/>
        <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-user"></i></span>
      </div>
    </div>
  </div>



    <div class="row pt-3">
      <div class="col">
        <div class='text-muted pt-3'>E-Mail</div>
        <div class="input-group mb-2">
      	<input type="email" name="email_usuario" class="form-control" required/>
        <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-envelope"></i></span>
      </div>
    </div>
  </div>


    <div class="row pt-3">
      <div class="col">
        <div class='text-muted pt-3'>Contraseña</div>
        <div class="input-group mb-2">
        <input type="text" name="pass_usuario" class="texto-seguro form-control" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$"/>
        <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-key"></i></span>
        </div>
      </div>
    </div> 


    <div class="row pt-3">
      <div class="col">
        <div class='text-muted pt-3'>Repetir Contraseña</div>
        <div class="input-group mb-2">
        <input type="text" name="pass_usuario2" class="texto-seguro form-control" required/>
        <span class="input-group-text bg-primary text-white" id="basic-addon2"><i class="fa fa-key"></i></span>
          <div class="invalid-feedback pt-0">
                Las contraseñas deben coincidir...
          </div>
        </div>
        <div class="pt-3">
        <small class="text-muted">Contraseña de 8 a 12 caracteres, incluyendo una Mayúscula, un Número y un símbolo (!@#$%^&*_=+-)</small>
          </div>
      </div>
    </div> 

    <div class="row pt-3 pb-4">
      <div class="col">
        <div class='text-muted pt-3'>Términos y Condiciones:</div>
        <textarea class="form-control opacity-50" id="terms_conditions" rows="5" readonly style="resize: none;">
Al utilizar nuestra aplicación web progresiva "Anestesia UACh", aceptas los siguientes términos y condiciones:

1. Al registrarte en nuestra aplicación, autorizas al Administrador a recopilar y utilizar tu información personal, incluyendo tu nombre y dirección de correo electrónico, para fines de manejo interno del sitio y para conocimiento exclusivo de los internos, residentes y staff de Anestesia de la Universidad Austral de Chile.

2. Tu información personal no será compartida con terceros sin tu consentimiento previo.

3. Nos comprometemos a mantener la privacidad y seguridad de tu información personal, y a utilizarla únicamente para fines relacionados con la administración de la aplicación web progresiva.

4. En cualquier momento, tienes derecho a solicitar el acceso a tu información personal, así como a solicitar la modificación o eliminación de dicha información.

5. Cualquier cambio en estos términos y condiciones será comunicado previamente, siendo efectivo inmediatamente después de su publicación en la aplicación.

6. Al utilizar nuestra aplicación, aceptas estos términos y condiciones y te comprometes a cumplir con todas las leyes y regulaciones aplicables.

Si tienes alguna pregunta o inquietud con respecto a estos términos y condiciones, no dudes en contactarnos.
</textarea></div></div>

    <div class="row pt-4 pb-5">  
    	<div class="col">
    		<button type="submit" name="registro" class="btn btn-primary btn-lg shadow" ><i class="fa-solid fa-check-to-slot pe-2 pb-"></i>Registrar</button>
    	</div>
    </div>

    </form>
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

	<?php
		//Conexión
		require("footer.php");

	?>

