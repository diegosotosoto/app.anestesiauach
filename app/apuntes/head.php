<?php  //Conexión

require("../conectar.php");

$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);

$conexion->set_charset("utf8mb4");

/*

  MARCAR NOTA COMO VISTA

  - Usa cookie hkjh41lu4l1k23jhlkj13 = email del usuario

  - Busca usuario en usuarios_dolor

  - Busca nota por ruta en tabla notas

  - Inserta/actualiza usuario_notas

*/

$archivo_actual = basename($_SERVER['PHP_SELF']);

/*

  Excluir archivos PHP auxiliares que NO son notas.

  No hace falta excluir imágenes ni carpetas:

  basename($_SERVER['PHP_SELF']) solo devolverá el archivo PHP ejecutado.

*/

$archivos_excluidos = [

    'apuntes.php',

    'head.php',

    'head_apuntes.php',

    'footer.php',

    'dosis_ped_pdf.php'

];

if (!in_array($archivo_actual, $archivos_excluidos, true)) {

    $usuario_id = 0;

    // Cookie 13 guarda el email del usuario

    if (isset($_COOKIE['hkjh41lu4l1k23jhlkj13']) && $_COOKIE['hkjh41lu4l1k23jhlkj13'] !== '') {

        $email_usuario_cookie = trim($_COOKIE['hkjh41lu4l1k23jhlkj13']);

        $sql_usuario = "SELECT ID

                        FROM anestes1_hoja_dolor.usuarios_dolor

                        WHERE email_usuario = ?

                          AND verified = 1

                        LIMIT 1";

        $stmt_usuario = $conexion->prepare($sql_usuario);

        if ($stmt_usuario) {

            $stmt_usuario->bind_param("s", $email_usuario_cookie);

            $stmt_usuario->execute();

            $res_usuario = $stmt_usuario->get_result();

            if ($fila_usuario = $res_usuario->fetch_assoc()) {

                $usuario_id = (int)$fila_usuario['ID'];

            }

            $stmt_usuario->close();

        }

    }

    if ($usuario_id > 0) {

        $ruta_actual = 'apuntes/' . $archivo_actual;

        $sql_nota = "SELECT id

                     FROM anestes1_hoja_dolor.notas

                     WHERE ruta = ?

                       AND estado = 'publicada'

                     LIMIT 1";

        $stmt_nota = $conexion->prepare($sql_nota);

        if ($stmt_nota) {

            $stmt_nota->bind_param("s", $ruta_actual);

            $stmt_nota->execute();

            $res_nota = $stmt_nota->get_result();

            if ($fila_nota = $res_nota->fetch_assoc()) {

                $nota_id = (int)$fila_nota['id'];

                $sql_vista = "INSERT INTO anestes1_hoja_dolor.usuario_notas (

                                usuario_id,

                                nota_id,

                                vista_at,

                                ultima_visita_at

                              )

                              VALUES (?, ?, NOW(), NOW())

                              ON DUPLICATE KEY UPDATE

                                vista_at = COALESCE(vista_at, NOW()),

                                ultima_visita_at = NOW(),

                                updated_at = NOW()";

                $stmt_vista = $conexion->prepare($sql_vista);

                if ($stmt_vista) {

                    $stmt_vista->bind_param("ii", $usuario_id, $nota_id);

                    $stmt_vista->execute();

                    $stmt_vista->close();

                }

            }

            $stmt_nota->close();

        }

    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#27458f">
  <meta http-equiv="Cache-control" content="no-cache">
  <title>App Anestesia UACH</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
  <link rel="manifest" href="../manifest.json"/>
  <link rel="apple-touch-icon" href="../images/logo192.png"/>
  <link href="../css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/all.css"/>
  <link rel="stylesheet" href="../style.css"/>
  <link rel="stylesheet" href="../css/overlay.css"/>
  <script src="../js/jquery-3.6.1.min.js"></script>
 

  <style>
  :root{
    --app-navy:#27458f;
    --app-blue:#3587ff;
    --app-cyan:#6ab8ff;
    --app-bg:#edf2f8;
    --app-surface:#ffffff;
    --app-surface-soft:#f7f9fc;
    --app-border:#dfe7f2;
    --app-shadow:0 18px 40px rgba(33, 55, 98, .10);
    --app-shadow-soft:0 10px 25px rgba(33, 55, 98, .08);
    --app-radius:22px;

    --app-gradient:linear-gradient(135deg, #2a3f8f 0%, #3a57c4 55%, #4f7de8 100%);
    --app-gradient-vertical:linear-gradient(180deg, #2a3f8f 0%, #3a57c4 55%, #4f7de8 100%);
    --app-primary:#3f5bd1;
    --app-primary-dark:#2c3e91;
    --app-primary-light:#6faeff;

  }

    html, body{
      background:var(--app-bg) !important;
    }

    body{
      color:#1b2430;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

.app-shell-left{
  background:var(--app-gradient-vertical) !important;
  box-shadow:inset -1px 0 0 rgba(255,255,255,.18);
}


    .app-main-col{
      background:transparent !important;
      padding-top:22px !important;
      padding-bottom:28px !important;
    }

    .apunte-surface{
      background:rgba(255,255,255,.72);
      backdrop-filter:blur(10px);
      border:1px solid rgba(255,255,255,.65);
      box-shadow:var(--app-shadow);
      border-radius:28px;
      padding:20px 12px 28px 12px;
      min-height:calc(100vh - 80px);
    }



  .dashboard-surface{
    background:rgba(255,255,255,.72);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.65);
    box-shadow:var(--app-shadow);
    border-radius:28px;
    padding:28px 16px 36px 16px;
    min-height:calc(100vh - 80px);
  }

  .dashboard-grid{
    max-width:1100px;
    margin:0 auto;
    display:grid;
    grid-template-columns:repeat(2, minmax(140px, 170px));
    justify-content:center;
    gap:28px 28px;
  }

.navbar{
  padding-top:0 !important;
  background:var(--app-gradient) !important;
}


  .offcanvas,
  .bg-sidebar{
    background:transparent !important;
  }

.offcanvas-body{
  color:#172132;
}

.offcanvas-start{
  max-height:100vh;
}

.offcanvas-start .offcanvas-body{
  padding-bottom:2rem;
}

    .offcanvas .list-group-item,
    .offcanvas .list-group-item-action{
      background:rgba(255,255,255,.88) !important;
      color:#1f2a37 !important;
      border:1px solid rgba(255,255,255,.52) !important;
      border-radius:16px !important;
      margin-bottom:10px;
      box-shadow:0 8px 20px rgba(20, 35, 68, .10);
      transition:transform .15s ease, box-shadow .15s ease, background-color .15s ease;
    }

    .offcanvas .list-group-item-action:hover{
      transform:translateY(-1px);
      box-shadow:0 12px 24px rgba(20, 35, 68, .14);
      background:#fff !important;
    }

    .offcanvas .list-group-item h6,
    .offcanvas .list-group-item,
    .offcanvas .list-group-item a{
      color:#1f2a37 !important;
    }

    .offcanvas .text-black-50{
      color:#667085 !important;
    }

    .offcanvas hr{
      opacity:.15;
      border-color:#10234d;
    }

  .navbar-brand,
  .navbar-brand small{
    color:#fff !important;
  }

.btn-icon-topbar{
  border-radius:14px !important;
  border:1px solid rgba(255,255,255,.12) !important;
  background:rgba(255,255,255,.10) !important;
  box-shadow:0 8px 20px rgba(18,30,60,.12);
}

.btn-icon-topbar i{
  display:block !important;
  line-height:1 !important;
  margin:0 !important;
}

.navbar .btn,
.navbar-toggler{
  min-height:40px;
}

    .btn-primary{
      background:var(--app-gradient) !important;
      border:none !important;
      box-shadow:0 8px 20px rgba(18,30,60,.12);
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active{
      background:var(--app-gradient) !important;
      border:none !important;
      filter:brightness(1.04);
    }


    .apunte-card{
      border:0;
      border-radius:1.1rem;
      box-shadow:0 8px 24px rgba(0,0,0,.06);
      background:#fff;
      overflow:hidden;
    }

    .apunte-hero{
      background:linear-gradient(135deg,var(--app-navy),#3559b7);
      color:#fff;
      padding:1.1rem 1.2rem;
    }

    .apunte-title{
      font-size:1.05rem;
      font-weight:700;
      line-height:1.2;
      display:flex;
      align-items:center;
      gap:.75rem;
    }

    .apunte-title i{
      font-size:1.25rem;
    }

    .apunte-body{
      padding:1.1rem 1rem 1.25rem 1rem;
    }

    .section-card{
      border:0;
      border-radius:1rem;
      box-shadow:0 8px 24px rgba(0,0,0,.06);
    }

    .section-title{
      font-size:.78rem;
      letter-spacing:.06em;
      text-transform:uppercase;
      color:#6c757d;
    }

    .info-card{
      background:#fff;
      border:1px solid #e7edf5;
      border-radius:1rem;
    }

    .info-card .list-group-item{
      border-left:0;
      border-right:0;
      padding:1rem 1.05rem;
    }

    .info-card .list-group-item:first-child{
      border-top:0;
    }

    .info-card .list-group-item:last-child{
      border-bottom:0;
    }

    .calc-row{
      padding:.95rem 0;
      border-bottom:1px solid #e9eef5;
    }

    .calc-row:last-child{
      border-bottom:0;
    }

    .calc-label{
      font-weight:500;
      color:#28303d;
    }

    .calc-input,
    .calc-select,
    .calc-result-input{
      border-radius:.85rem !important;
      min-height:48px;
    }

    .calc-result{
      border:1px solid #dfe7f2;
      border-radius:.9rem;
      background:#f8fafc;
      padding:.1rem .35rem;
    }

    .btn-calc-main{
      border-radius:1rem;
      padding:.8rem 1.15rem;
      font-weight:600;
      box-shadow:0 8px 24px rgba(0,0,0,.06);
    }

    .toggle-pill{
      border-radius:999px;
    }

    .sticky-tools{
      position:sticky;
      top:0;
      z-index:1000;
      background:rgba(255,255,255,.95);
      backdrop-filter:blur(8px);
      border-bottom:1px solid #e9ecef;
    }

    .footer-note{
      font-size:.82rem;
      color:#6c757d;
    }

   .beta-pill{
    display:inline-block;
    margin-top:6px;
    padding:.16rem .42rem;
    font-size:.78rem;
    border-radius:999px;
    background:rgba(90, 20, 24, .78);
    color:#fff;
  }

  .input-group-text.bg-primary{
  background:var(--app-gradient) !important;
  border:none !important;
  color:#fff !important;
}

.login-pill,
.pill{
  background:rgba(255,255,255,.16);
}   

    footer.bd-footer{
      background:rgba(255,255,255,.55) !important;
      border-top:1px solid var(--app-border);
      backdrop-filter:blur(6px);
    }

    footer.bd-footer h5{
      color:#1f2a37;
      font-weight:700;
    }

    footer.bd-footer a{
      color:#2453c6;
      text-decoration:none;
    }

    footer.bd-footer a:hover{
      text-decoration:underline;
    }

    @media (max-width: 549px){
      .app-main-col{
        padding-top:16px !important;
        padding-bottom:18px !important;
      }

      .row[style*="min-height:100vh"]{
        min-height:auto !important;
      }

      .app-shell-left{
        min-height:auto !important;
        height:auto !important;
      }

      .navbar{
        height:auto !important;
        min-height:unset !important;
      }

      .navbar .container-fluid{
        min-height:auto !important;
        height:auto !important;
        padding-top:12px !important;
        padding-bottom:10px !important;
      }


      .apunte-surface{
        min-height:auto;
        padding:10px 0 20px 0;
        border-radius:0;
        box-shadow:none;
        border:0;
        background:transparent;
        backdrop-filter:none;
      }

      .apunte-card{
        border-radius:1rem;
      }

      .apunte-hero{
        padding:1rem 1rem;
      }

      .apunte-title{
        font-size:.98rem;
      }

      .apunte-body{
        padding:1rem;
      }

      .offcanvas-start{
        background:linear-gradient(180deg, #27458f 0%, #2453c6 45%, #4fb6ff 100%) !important;
      }
    }

    @media (max-width: 350px){
      .offcanvas-start{
        background:linear-gradient(180deg, #27458f 0%, #2453c6 45%, #4fb6ff 100%) !important;
      }
    }

   @media (max-width: 549px){
  .offcanvas-start{
    max-height:100vh;
  }
  
@media (max-width: 767.98px){
  .navbar-toggler{
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    line-height:1 !important;
    padding:0 !important;
  }

  .navbar-toggler i{
    display:block !important;
    line-height:1 !important;
    margin:0 !important;
    transform:translateY(1px);
  }
}
  .offcanvas-body{
    overflow-y:auto;
    max-height:calc(100vh - 70px);
    -webkit-overflow-scrolling:touch;
    padding-bottom:2rem;
  }
} 
  </style>



  
</head>


<body>
<div class="container-xxl text-center px-0">
<div class="row px-0 mx-0 min-vh-100 align-items-stretch">
<div class="col-sm col-sm-3 col-xl-3 px-0 app-shell-left d-flex flex-column">
      <nav class="navbar navbar-expand-sm">

    <div class="container-fluid pt-3 flex-sm-column align-items-stretch">          
 <!-- Margen superior de Navbar -->
          <span class="ps-1"><?php if($boton_toggler){echo $boton_toggler;} ?></span>

          <a class="navbar-brand d-sm-block d-sm-none" href="#">
            <?php if($titulo_navbar){echo $titulo_navbar;} ?>
          </a>

          <a class="d-sm-block d-sm-none pe-1" href="#">
            <?php if($boton_navbar){echo $boton_navbar;} ?>
          </a>

    <div class="offcanvas offcanvas-start px-0 mx-0 bg-sidebar" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
<div class="h-100 d-flex flex-column">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title ps-4" id="offcanvasNavbarLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

    <div class="offcanvas-body">
      <div class="container text-center pb-5">
              <div class="row ps-1 pt-3 pb-3  d-xs-none d-none d-sm-block">
                  <div class="navbar-brand" ><img src="../images/austral_b.png" style="width: 30% ;"></div>
              </div>


<div class='list-group' id='offcanvasExampleLabel'>
 

                  <?php

                      if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                             echo "

                                <div class='list-group-item list-group-item-action fs-5'>
                                  <h6><i class='fs-2 fa-solid fa-user-doctor ps-2 pe-3 text-success'></i>".urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])."</h6>


                                  <div class='text-black-50 text-break' style='font-size: 12px'>
                                      ".$_COOKIE['hkjh41lu4l1k23jhlkj13']." 
                                  </div></div>
                              ";} else {
/*

                                echo "<div class='list-group'>
                                  <a href='login.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-right-to-bracket ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Login</a>
                        </div>";
 */                                     }
                  ?>

<hr class='pt-0'>

          <ul class='list-group pt-2'>

            <div class='list-group'>
              <a href='../index.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-house ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Inicio</a> 
            </div>

        <?php
        //BUSCA SI EL USUARIO ESTÁ REGISTRADO Y AGREGA MENÚ DE REGISTRADOS
        if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){


          //Genera las badges si es staff o admin
          $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
          $nombre_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj14'];
          $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro`  FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario' ";
          $users_b=$conexion->query($con_users_b);
          $usuario=$users_b->fetch_assoc();
          if($usuario['admin']==1 or $usuario['staff_']==1){
              
                      $query_badge="SELECT `staff_b` FROM `bitacora_proced` WHERE `staff_b` = '$nombre_usuario' AND `aprobado_staff_b` = '0' ";
                          $consutal_badge=$conexion->query($query_badge);
                          $badge = mysqli_num_rows($consutal_badge);


                      $query_badge2="SELECT `staff_i` FROM `bitacora_internos` WHERE `staff_i` = '$nombre_usuario' AND `aprobado_staff_i` = '0' ";
                          $consutal_badge2=$conexion->query($query_badge2);
                          $badge2 = mysqli_num_rows($consutal_badge2);


                          $escribe_badge=$badge+$badge2;


            } 



        echo "<div class='list-group'>
          <a href='../bitacora.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' style='color: #CE2E2E'></i>Bitácora &nbsp;<span class='badge text-bg-danger'>".$escribe_badge."</span></a> 
              </div>";

        echo "<div class='list-group'>
                  <a href='../apuntes.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calculator ps-2 pe-3 fs-3' style='color: #FFD700'></i>Cálculos y Apuntes</a> 
              </div>";

        echo "<div class='list-group'>
          <a href='../vista_epa.php' class='list-group-item list-group-item-action fs-6 text-break'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' style='color: #FF5A00'></i>E. Preanestésica</a> 
              </div>";

        echo "<div class='list-group'>
          <a href='../telefonos.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-phone ps-2 pe-3 fs-3' style='color: #6405d0'></i>Teléfonos Frecuentes</a> 
              </div>";



        echo "<div class='list-group'>
          <a href='../correos.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-envelope ps-2 pe-3 fs-3' style='color: #29A09B'></i>Directorio Correos</a> 
              </div>";

        }

        ?>

            <div class="row">

        <?php 

                    //BUSCA SI EL USUARIO ES ADMIN Y AGREGA MENÚ DE ADMIN
                    $email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
                    $consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";
                    $confirma_user=$conexion->query($consulta_user); 

                    if(mysqli_num_rows($confirma_user)==0){//AL NO ENCONRAR REGISTROS DE ADMIN NO AGREGA NADA

                    }else{ 
                

                          $query_badge3="SELECT `verified` FROM `usuarios_dolor` WHERE `verified` = '0'";
                          $consutal_badge3=$conexion->query($query_badge3);
                          $badge3 = mysqli_num_rows($consutal_badge3);


                          $escribe_badge3="<span class='badge text-bg-danger'>".$badge3."</span>";

                              echo "
                            <form id='gest_users' action='../gestion_usuarios.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                            <div class='list-group'>
                              <a href='#' onclick='envioForm1()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-users ps-2 pe-3 fs-3 text-primary'></i>Gestión Usuarios &nbsp;$escribe_badge3</a> 
                            </div></form>
                              <script>function envioForm1() {document.getElementById('gest_users').submit(); }</script>
                              ";

                              echo "<form id='gest_pacientes' action='../gestion_pacientes.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                            <div class='list-group'>
                              <a href='#' onclick='envioForm2()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-bed ps-2 pe-3 fs-3 text-primary'></i>Gestión Pacientes</a> 
                            </div></form>
                              <script>function envioForm2() {document.getElementById('gest_pacientes').submit(); }</script>
                              ";

                              echo "<form id='gest_bitacora' action='../gestion_bitacora.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                            <div class='list-group'>
                              <a href='#' onclick='envioForm3()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3 text-primary'></i>Gestión Bitácora</a> 
                            </div></form>
                              <script>function envioForm3() {document.getElementById('gest_bitacora').submit(); }</script>
                              ";

                    }

              ?>        
          </div>
            <div class='list-group'>
              <a href='https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9' target='_blank' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-chalkboard-user ps-2 pe-3 fs-3' style="color: #D9027D;"></i>Reuniones Clínicas</a> 
            </div>

            <div class='list-group'>
              <a href='../acerca_de.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-circle-question ps-2 pe-3 fs-3' style="color: #FF6347;"></i>Acerca de</a> 
            </div>

          </ul>

<?php
if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
      echo "<ul class='list-group pt-5'>
          <div class='list-group'>
            <a href='cierra_sesion.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-door-open ps-2 pe-3 fs-3 text-success'></i>Cerrar sesión</a> 
          </div>
              </ul>";
    }

?>


          <!- FOOTER DEl navbar ->
                  <div class="mb-0 px-0 pt-4 text-center text-black-50">
                  <hr>
                  </div>
                  <div class="mb-0 px-0 py-4 text-center text-black-50">
                  </div>
                  <!- FOOTER DEl navbar ->





</div>


              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>



    <!-- Overlay global -->
<div id="globalSavingOverlay" class="saving-overlay d-none">
  <div class="saving-box">
    <div class="saving-spinner"></div>
    <div class="saving-text">Guardando...</div>
  </div>
</div>


