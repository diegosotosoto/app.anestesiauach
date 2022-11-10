<?php

  //si existe la cookie se salta el area de login y va al index
  if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){

  }else{
        header('Location: index.php');
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
<style type="text/css">
  body {
  background-color: #CCEAFF;
  }
  input.texto-seguro{
  -webkit-text-security: disc;
  -moz-text-security: disc;
  text-security: disc;
  }
</style>

<form class="needs-validation" action="login.php" method="post" novalidate autocomplete="nope" oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? "Passwords do not match." : "")'>
<div class="container text-center mt-3">
  <div class="row pt-4">
  	<h1>¡Hola!</h1>
  </div>
  <div class="row pt-3">
    <div class="col">
      Por favor, crea una nueva cuenta
    </div>
  </div>

  <div class="row pt-3">
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
      <div class="pt-4">
<small class="text-muted">Contraseña de 8 a 12 caracteres, incluyendo una Mayúscula, un Número y un símbolo (!@#$%^&*_=+-)</small>
  </div>
    </div>
  </div> 


  <div class="row pt-4">
  	<div class="col">
  		<input type="submit" name="registro" class="btn btn-primary btn-lg" value="Registrar"/>
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
</form>
	<?php
		//Conexión
		require("footer.php");

	?>

</body>
</html>