
<?php

  //Variables
    $boton_toggler="<button class='navbar-toggler shadow-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasNavbar' aria-controls='offcanvasNavbar' style='width:50px; height:40px; --bs-border-opacity: .1;'><i class='fa-solid fa-bars' style='color:white'></i></button>";

      $titulo_navbar="<span class='fs-5 ms-3 ps-1 pe-1 me-3' style='color:white'><img class='pe-2' src='images/austral.png' style='width: 48px' />Anestesia <small class='ps-0 opacity-50' style='font-size: 16px'> UACH</small></span>";

    $boton_navbar="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:50px; height:40px; --bs-border-opacity: .1;' href='acerca_de.php'><i class='fa-solid fa-question'></i></a>";

  //Carga Head de la página
    require("head.php");

?>
<script type="text/javascript" src="js/not_reload.js"></script>
<style type="text/css">
  input.texto-seguro{
  -webkit-text-security: disc;
  -moz-text-security: disc;
  text-security: disc;
  }
</style>

<div class="col col-sm-9 col-xl-9 pb-5"><!- Columna principal (derecha) responsive->

<?php


if ($_POST['email_usuario_rec']){
  $email_usuario_final=htmlentities(addslashes($_POST['email_usuario_rec']));
  $pass_usuario_final=htmlentities(addslashes($_POST['pass_usuario']));
  $pass_cifrado_final=password_hash($pass_usuario_final, PASSWORD_DEFAULT);

            $consulta_final="UPDATE `usuarios_dolor` SET `password`='$pass_cifrado_final', `token_rec`='',  `token_activ`='0', `token_hr`='' WHERE `email_usuario`='$email_usuario_final'";
            
            $escribir_pass=$conexion->query($consulta_final);

        echo "
              <div class='alert alert-success alert-dismissible fade show'>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              <strong>Info!</strong> Se ha cambiado la Contraseña <br>
              </div>

              <div class='row py-5'>
              <div class='col'>
              </div>
              </div>

              <div class='row py-5'>
              <div class='col'>
                <a class='btn btn-primary btn-lg shadow' href='login.php'><i class='fa-solid fa-right-to-bracket pe-2'></i>Ir al Login</a>
              </div>
              </div>
        ";
        header('Location: login.php'); //página login
        exit();

}else {


//recibe los token enviado mediante GET
$token_rec=$_GET['962eb831a0df54562eb40fed6bf13b'];
$token_activ=$_GET['89cd7e5e18f25d8e1214f1d8f273da'];
$email_usuario_rec=$_GET['a52f7597ca4d6c24937711a66fd058'];

if($_GET['962eb831a0df54562eb40fed6bf13b']){


//Chequea si el token existe antes de generar la pagina
	$chequea_tokens1="SELECT `token_rec`,`token_activ`,`token_hr` FROM `usuarios_dolor` WHERE `email_usuario`= '$email_usuario_rec' AND `verified`= '1'";

	$result_chk=$conexion->query($chequea_tokens1);

	$cheqtok=$result_chk->fetch_assoc();


  $chk_token_rec=$cheqtok['token_rec'];
  $chk_token_activ=$cheqtok['token_activ'];
  $chk_token_hr=$cheqtok['token_hr'];

      if($cheqtok['token_hr']){
      $hora_limite=$cheqtok['token_hr']+300;
      }

  $hora_actual=time();

            if($chk_token_rec==$token_rec AND $chk_token_activ==1 AND $hora_limite>$hora_actual){
                echo "

                  <div class='row justify-content-md-center'>


                          <div class='container text-center mt-4 pt-4'>
                            <a href='#' class='btn shadow bg-primary me-2 rounded-3 text-white border-0 py-2' style='height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);'>
                            <div class='row pt-4'>
                              <h2>Nueva Contraseña</h2>
                            </div>
                              <div class='row py-2'>        
                                <h1><i class='fa-solid fa-key ps-3'></i></h1>
                            </div>
                          </a>

                    </div>
                  </div>


                ";

                echo "
                <form class='needs-validation' action='password_reset.php' method='post' novalidate autocomplete='nope' oninput='pass_usuario2.setCustomValidity(pass_usuario2.value != pass_usuario.value ? 'Passwords do not match.' : '')'>
                	<input type='hidden' name='email_usuario_rec' value='".$email_usuario_rec."'>
                    <div class='row pt-3'>
                      <div class='col'>
                        <div class='text-muted pt-3'>Contraseña</div>
                        <div class='input-group mb-2'>
                        <input type='password' name='pass_usuario' id='pass_usuario' class='form-control' required pattern='^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_=+\-?]).{8,12}$' aria-describedby='button-addon2'>
                        <button class='btn btn-outline-secondary border-secondary border-opacity-25' type='button' id='button-addon2' onclick='mostrar()'><i id='icono' class='fa-solid fa-eye'></i></button>
                        <span class='input-group-text bg-primary text-white' id='basic-addon2'><i class='fa fa-key'></i></span>
                        </div>
                        <script type='text/javascript'>
                        function mostrar() {
                          var tipo = document.getElementById('pass_usuario');
                          var icono = document.getElementById('icono'); // obtén el elemento del icono
                          if(tipo.type == 'password') {
                            tipo.type = 'text';
                            icono.className = 'fa-solid fa-eye-slash'; // actualiza la clase del icono
                            icono.innerHTML = ''; // elimina el contenido HTML del icono
                          } else {
                            tipo.type = 'password';
                            icono.className = 'fa-solid fa-eye'; // actualiza la clase del icono
                            icono.innerHTML = ''; // elimina el contenido HTML del icono
                          }
                        }
                        </script>
                      </div>
                    </div> 
 

                    <div class='row pt-3'>
                      <div class='col'>
                        <div class='text-muted pt-3'>Repetir Contraseña</div>
                        <div class='input-group mb-2'>

                        <input type='password' name='pass_usuario2' id='pass_usuario2' class='form-control' required aria-describedby='button-addon'>
                        <button class='btn btn-outline-secondary border-secondary border-opacity-25' type='button' id='button-addon' onclick='mostrar2()'><i id='icono2' class='fa-solid fa-eye'></i></button>
                        <span class='input-group-text bg-primary text-white' id='basic-addon'><i class='fa fa-key'></i></span>
                          <div class='invalid-feedback pt-0'>
                                Las contraseñas deben coincidir...
                          </div>
                        </div>
                        <div class='pt-3'>
                        <small class='text-muted'>Contraseña de 8 a 12 caracteres, incluyendo una Mayúscula, un Número y un símbolo (!@#$%^&*_=+-)</small>
                          </div>
                                <script type='text/javascript'>
                        function mostrar2() {
                          var tipo2 = document.getElementById('pass_usuario2');
                          var icono2 = document.getElementById('icono2'); // obtén el elemento del icono
                          if(tipo2.type == 'password') {
                            tipo2.type = 'text';
                            icono2.className = 'fa-solid fa-eye-slash'; // actualiza la clase del icono
                            icono2.innerHTML = ''; // elimina el contenido HTML del icono
                          } else {
                            tipo2.type = 'password';
                            icono2.className = 'fa-solid fa-eye'; // actualiza la clase del icono
                            icono2.innerHTML = ''; // elimina el contenido HTML del icono
                          }
                        }
                                </script>
                      </div>
                    </div> 
                    <div class='row pt-4 pb-5'>  
                    	<div class='col'>
                    		<button type='submit' name='registro' class='btn btn-primary btn-lg shadow' ><i class='fa-solid fa-check-to-slot pe-2 pb-'></i>Enviar</button>
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
                ";
            }else{
               //no coinciden el token o no aparece activo
          echo "
          <div class='row justify-content-md-center'>


                  <div class='container text-center mt-4 pt-4'>
                    <a href='#' class='btn shadow bg-primary me-2 rounded-3 text-white border-0 py-2' style='height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);'>
                    <div class='row pt-4'>
                      <h2>Enlace Expirado</h2>
                    </div>
                      <div class='row py-2'>        
                        <h1><i class='fa-regular fa-face-dizzy ps-3'></i></h1>
                    </div>
                  </a>
                            <div class='row py-4'>
                      <div class='col py-4'>
                        En enlace para restablecer la contraseña ha expirado, por favor intentalo nuevamente.
                      </div>
                    </div>

            </div>
          </div>";



            }

}else {
  //no hay GET
echo "
<div class='row justify-content-md-center'>


        <div class='container text-center mt-4 pt-4'>
          <a href='#' class='btn shadow bg-primary me-2 rounded-3 text-white border-0 py-2' style='height: 150px;width: 320px; background-color: #0050ff;background-image: linear-gradient(45deg, #0050ff 0%, #44B2FF 100%);'>
          <div class='row pt-4'>
            <h2>Enlace Expirado</h2>
          </div>
            <div class='row py-2'>        
              <h1><i class='fa-regular fa-face-dizzy ps-3'></i></h1>
          </div>
        </a>
                  <div class='row py-4'>
            <div class='col py-4'>
              En enlace para restablecer la contraseña ha expirado, por favor intentalo nuevamente.
            </div>
          </div>

  </div>
</div>";


}

}


		//Conexión
		require("footer.php");

	?>


