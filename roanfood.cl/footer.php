<footer class="bd-footer py-2 py-md-5 mt-2 bg-secondary text-start" style=' --bs-bg-opacity: 0.1;'>
  <div class="container py-2 py-md-5 px-4 px-md-3" style="font-size: min(max(14px, 1.5vw), 18px)">
    <div class="row">



    <div class="col-lg-3 mb-3">
        <a class="d-inline-flex align-items-center mb-2 link-dark text-decoration-none" href="/" aria-label="Bootstrap">
          <span class="fs-5"><img class="pe-2" src="images/icon.png" style="width: 48px" />Roanfood</span>
        </a>
        <hr class="ms-0 mt-1 mb-2 me-0">
        <ul class="list-unstyled small text-muted">
          <li class="mb-2">Cocinamos cada plato con amor, manteniendo el sabor casero que te encanta!</li>
          <li class="mb-2 mt-2 pt-2">Diseñado por Diego Soto S.</li>
        </ul>
    </div>
    <div class="col-6 col-lg-2 offset-lg-1 mb-3">
      <h5>Locales</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="https://goo.gl/maps/tFHaapDS4ZXTAnWy6" target="_blank"><i class="fa-solid fa-location-dot pe-2"></i>Sta. Elena 2645, San Joaquín</a></li>
        <li class="mb-2"><a href="https://goo.gl/maps/7Kk2xF5zBWwMe5W76" target="_blank"><i class="fa-solid fa-location-dot pe-2"></i>Nva. Los Leones 0148, Providencia</a></li>
      </ul>
    </div>

    <div class="col-6 col-lg-2 mb-3">
      <h5>Contacto</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="tel:+569 59819413"><i class="fa-solid fa-phone pe-2"></i>9 59819413</a></li>
        <li class="mb-2"><a href="https://wa.me/+56959819413" target="_blank"><i class="fa-brands fa-whatsapp pe-2"></i>9 59819413</a></li>
      </ul>
    </div>

    <div class="col-6 col-lg-2 mb-3">
      <h5>Redes</h5>
      <ul class="list-unstyled">
        <li class="mb-2"><a href="https://www.facebook.com/people/RoanFood-Sabor-Casero/100054229671685/" target="_blank"><i class="fa-brands fa-facebook pe-2"></i>Facebook</a></li>
        <li class="mb-2"><a href="https://www.instagram.com/roanfood20/" target="_blank"><i class="fa-brands fa-instagram pe-2"></i>Instagram</a></li>
      </ul>
    </div>



      <div class="col-6 col-lg-2 mb-3">


            <!-- Button trigger modal -->
            <h5>Transferencia</h5>
            <button type='button' class='btn btn-link' onclick="copyContent()" data-bs-toggle='modal' data-bs-target='#dataModal' >
              <p class="d-none" id="myText">Ana Maria Pino&#10;10014397-6&#10;Cta Corriente Banco de Chile&#10;1711266307</p>
              <i class="fa-solid fa-copy pe-2"></i>Copiar Datos
            </button>

            <!-- Modal -->
            <div class='modal fade' id='dataModal' tabindex='-1' aria-labelledby='modalLabel' aria-hidden='true'>
              <div class='modal-dialog'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h1 class='modal-title fs-5' id='modalLabel'>Datos de Transferencia</h1>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                  </div>
                  <div class='modal-body'>
                    Nombre: Ana Maria Pino<br>
                    Rut: 10014397-6<br>
                    Cta Corriente<br>
                    Banco de Chile<br>
                    1711266307<br>
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Aceptar</button>
                  </div>
                </div>
              </div>
            </div>



          <script>
            let text = document.getElementById('myText').innerHTML;
            const copyContent = async () => {
              try {
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
              } catch (err) {
                console.error('Failed to copy: ', err);
              }
            }
          </script>



</div><!- DIV DE LA COLUMNA DE COPIAR DATOS ->

</div><!- DIV DEL ROW ->  

</div><!- DIV CONTAINER ->
</footer>

<script src="js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="index.js"></script>