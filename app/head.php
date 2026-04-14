<?php  //Conexión
  require("conectar.php");
  $conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
  $conexion->set_charset("utf8");
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#27458f">
	<meta http-equiv="Cache-control" content="no-cache">
	<title>App Anestesia UACH</title>
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="manifest" href="manifest.json"/>
	<link rel="apple-touch-icon" href="images/logo192.png"/>	
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="css/all.css"/>
	<link rel="stylesheet" href="style.css"/>
	<link rel="stylesheet" href="css/overlay.css"/>
	<script src="js/jquery-3.6.1.min.js"></script>

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
    padding-top:32px !important;
    padding-bottom:32px !important;
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

  .offcanvas .list-group-item-action:active{
    transform:translateY(0);
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

  .app-logo-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:8px 14px;
    border-radius:18px;
    background:rgba(255,255,255,.12);
    backdrop-filter:blur(4px);
  }

  .dashboard-tile{
    width:100%;
    aspect-ratio:1 / 1;
    border:0 !important;
    border-radius:26px !important;
    box-shadow:0 16px 28px rgba(17, 24, 39, .12) !important;
    display:flex !important;
    flex-direction:column;
    justify-content:center !important;
    align-items:center !important;
    gap:12px;
    text-align:center !important;
    padding:18px 14px !important;
    color:#ffffff !important;
    transition:transform .16s ease, box-shadow .16s ease;
  }

  .dashboard-tile:hover{
    transform:translateY(-3px);
    box-shadow:0 20px 34px rgba(17, 24, 39, .16) !important;
  }

  .dashboard-tile i{
    display:block;
    color:inherit !important;
    margin:0 !important;
    line-height:1 !important;
    flex:0 0 auto;
  }

  .dashboard-tile .tile-label{
    width:100%;
    display:block;
    text-align:center !important;
    line-height:1.18;
    margin:0 !important;
    flex:0 0 auto;
    font-size:1rem;
  }

  .dashboard-tile.tile-gold{
    color:#4b3b1f !important;
  }

  .tile-green{
    background:linear-gradient(145deg,#0a7d3d 0%,#18b565 55%,#7fe0b0 100%) !important;
    color:#f6fbff !important;
  }

  .tile-blue{
    background:linear-gradient(145deg,#0f63d8 0%,#2d7fe0 55%,#7fb3f2 100%) !important;
    color:#f4f8ff !important;
  }

  .tile-gold{
    background:linear-gradient(145deg,#e69500 0%,#f2b632 55%,#f5e3a3 100%) !important;
    color:#4b3b1f !important;
  }

  .tile-red{
    background:linear-gradient(145deg,#c82333 0%,#e03a48 55%,#f29aa2 100%) !important;
    color:#fff8f8 !important;
  }

  .tile-orange{
    background:linear-gradient(145deg,#d94c00 0%,#f57a2a 55%,#ffd3b0 100%) !important;
    color:#fff8f2 !important;
  }

  .tile-purple{
    background:linear-gradient(145deg,#5b00b3 0%,#7d2ae8 55%,#c3a5f5 100%) !important;
    color:#faf7ff !important;
  }

  .tile-teal{
    background:linear-gradient(145deg,#1f8a8c 0%,#4fb3b5 55%,#bfe4e5 100%) !important;
    color:#f5ffff !important;
  }

  .tile-magenta{
    background:linear-gradient(145deg,#9e0059 0%,#c2187a 55%,#e5a3c6 100%) !important;
    color:#fff7fb !important;
  }

  .tile-green i,
  .tile-blue i,
  .tile-red i,
  .tile-orange i,
  .tile-purple i,
  .tile-teal i,
  .tile-magenta i{
    color:rgba(255,255,255,.93) !important;
  }

  .tile-gold i{
    color:rgba(71,57,27,.85) !important;
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

  @media (min-width: 768px){
    .dashboard-grid{
      grid-template-columns:repeat(2, minmax(155px, 180px));
      gap:34px 40px;
    }

    .dashboard-tile .tile-label{
      font-size:1rem;
    }
  }

  @media (min-width: 992px){
    .dashboard-grid{
      grid-template-columns:repeat(4, minmax(150px, 185px));
      max-width:980px;
      gap:40px 44px;
    }

    .dashboard-tile{
      border-radius:30px !important;
      gap:10px;
      padding:16px 12px !important;
    }

    .dashboard-tile i{
      font-size:2rem !important;
    }

    .dashboard-tile .tile-label{
      font-size:.92rem;
      line-height:1.15;
    }
  }

  @media (min-width: 1400px){
    .dashboard-grid{
      max-width:1080px;
      gap:46px 52px;
    }

    .dashboard-tile{
      border-radius:32px !important;
    }

    .dashboard-tile .tile-label{
      font-size:.96rem;
    }
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


  @media (max-width: 549px){
    .app-main-col{
      padding-top:18px !important;
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

    .dashboard-surface{
      min-height:auto;
      padding:20px 10px 28px 10px;
      border-radius:0;
      box-shadow:none;
      border:0;
      background:transparent;
      backdrop-filter:none;
    }

    .dashboard-grid{
      max-width:100%;
      grid-template-columns:repeat(2, minmax(135px, 170px));
      gap:26px 26px;
    }

    .dashboard-tile{
      border-radius:22px !important;
    }

    .dashboard-tile .tile-label{
      font-size:1rem;
    }

    .offcanvas-start{
      background:var(--app-gradient-vertical) !important;
      max-height:100vh;
    }

    .offcanvas-body{
      overflow-y:auto;
      max-height:calc(100vh - 70px);
      -webkit-overflow-scrolling:touch;
      padding-bottom:2rem;
    }
  }

  @media (max-width: 350px){
    .dashboard-grid{
      grid-template-columns:repeat(2, minmax(125px, 150px));
      gap:20px 20px;
    }

    .offcanvas-start{
      background:linear-gradient(180deg, #27458f 0%, #2453c6 45%, #4fb6ff 100%) !important;
    }
  }
</style>
<body>

<div class="container-xxl text-center px-0">
  <div class="row px-0 mx-0" style="min-height:100vh;">
    <div class="col-sm col-sm-3 col-xl-3 px-0 app-shell-left">
      <nav class="navbar navbar-expand-sm">

    <div class="container-fluid pt-3 flex-sm-column align-items-stretch">          
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
                  <div class="row ps-1 pt-3 pb-3 d-xs-none d-none d-sm-block">
                    <div class="navbar-brand"><img src="images/austral_b.png" style="width: 30% ;"></div>
                  </div>


                  <div class='list-group' id='offcanvasExampleLabel'>
                    <?php
                      if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                        echo "
                          <div class='list-group-item list-group-item-action fs-5'>
                            <h6><i class='fs-2 fa-solid fa-user-doctor ps-2 pe-3 text-success'></i>".urldecode($_COOKIE['hkjh41lu4l1k23jhlkj14'])."</h6>
                            <div class='text-black-50 text-break' style='font-size: 12px'>
                              ".$_COOKIE['hkjh41lu4l1k23jhlkj13']."
                            </div>
                          </div>
                        ";
                      } else {
                        echo "<div class='list-group'>
                          <a href='login.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-right-to-bracket ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Login</a>
                        </div>";
                      }
                    ?>

                    <hr class='pt-0'>

                    <ul class='list-group pt-2'>
                      <div class='list-group'>
                        <a href='index.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-house ps-2 pe-3 fs-3' style='color: #44B2FF'></i>Inicio</a>
                      </div>

                      <?php
                        if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                          $check_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
                          $nombre_usuario=$_COOKIE['hkjh41lu4l1k23jhlkj14'];
                          $con_users_b="SELECT `admin`, `staff_`, `intern_`, `becad_`, `becad_otro` FROM `usuarios_dolor` WHERE `email_usuario` = '$check_usuario'";
                          $users_b=$conexion->query($con_users_b);
                          $usuario=$users_b ? $users_b->fetch_assoc() : null;
                          $escribe_badge = 0;

                          if($usuario && ($usuario['admin']==1 || $usuario['staff_']==1)){
                            $query_badge="SELECT `staff_b` FROM `bitacora_proced` WHERE `staff_b` = '$nombre_usuario' AND `aprobado_staff_b` = '0'";
                            $consutal_badge=$conexion->query($query_badge);
                            $badge = $consutal_badge ? mysqli_num_rows($consutal_badge) : 0;

                            $query_badge2="SELECT `staff_i` FROM `bitacora_internos` WHERE `staff_i` = '$nombre_usuario' AND `aprobado_staff_i` = '0'";
                            $consutal_badge2=$conexion->query($query_badge2);
                            $badge2 = $consutal_badge2 ? mysqli_num_rows($consutal_badge2) : 0;

                            $escribe_badge=$badge+$badge2;
                          }

                          echo "<div class='list-group'>
                            <a href='bitacora.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' style='color: #CE2E2E'></i>Bitácora &nbsp;<span class='badge text-bg-danger'>".$escribe_badge."</span></a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='apuntes.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-calculator ps-2 pe-3 fs-3' style='color: #FFD700'></i>Cálculos y Apuntes</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='vista_epa.php' class='list-group-item list-group-item-action fs-6 text-break'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3' style='color: #FF5A00'></i>E. Preanestésica</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='telefonos.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-phone ps-2 pe-3 fs-3' style='color: #6405d0'></i>Teléfonos Frecuentes</a>
                          </div>";

                          echo "<div class='list-group'>
                            <a href='correos.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-envelope ps-2 pe-3 fs-3' style='color: #29A09B'></i>Directorio Correos</a>
                          </div>";
                        }
                      ?>

                      <div class="row">
                        <?php
                          if(isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
                            $email_user=$_COOKIE['hkjh41lu4l1k23jhlkj13'];
                            $consulta_user="SELECT * FROM `usuarios_dolor` WHERE `email_usuario` = '$email_user' AND `admin` = '1'";
                            $confirma_user=$conexion->query($consulta_user);

                            if($confirma_user && mysqli_num_rows($confirma_user)>0){
                              $query_badge3="SELECT `verified` FROM `usuarios_dolor` WHERE `verified` = '0'";
                              $consutal_badge3=$conexion->query($query_badge3);
                              $badge3 = $consutal_badge3 ? mysqli_num_rows($consutal_badge3) : 0;
                              $escribe_badge3="<span class='badge text-bg-danger'>".$badge3."</span>";

                              echo "
                                <form id='gest_users' action='gestion_usuarios.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm1()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-users ps-2 pe-3 fs-3 text-primary'></i>Gestión Usuarios &nbsp;$escribe_badge3</a>
                                  </div>
                                </form>
                                <script>function envioForm1(){document.getElementById('gest_users').submit();}</script>
                              ";

                              echo "
                                <form id='gest_pacientes' action='gestion_pacientes.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm2()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-bed ps-2 pe-3 fs-3 text-primary'></i>Gestión Pacientes</a>
                                  </div>
                                </form>
                                <script>function envioForm2(){document.getElementById('gest_pacientes').submit();}</script>
                              ";

                              echo "
                                <form id='gest_bitacora' action='gestion_bitacora.php' method='post'><input type='hidden' name='email_user_ad' value='$email_user'/>
                                  <div class='list-group'>
                                    <a href='#' onclick='envioForm3()' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-clipboard ps-2 pe-3 fs-3 text-primary'></i>Gestión Bitácora</a>
                                  </div>
                                </form>
                                <script>function envioForm3(){document.getElementById('gest_bitacora').submit();}</script>
                              ";
                            }
                          }
                        ?>
                      </div>

                      <div class='list-group'>
                        <a href='https://uachcl-my.sharepoint.com/:f:/r/personal/docentes_anestesia_uach_cl/Documents/Reuniones%20Clinicas?e=5%3a1d4a50a99f8747659eaf40e9bd942188&sharingv2=true&fromShare=true&at=9' target='_blank' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-chalkboard-user ps-2 pe-3 fs-3' style="color: #D9027D;"></i>Reuniones Clínicas</a>
                      </div>

                      <div class='list-group'>
                        <a href='acerca_de.php' class='list-group-item list-group-item-action fs-6'><i class='fa-solid fa-circle-question ps-2 pe-3 fs-3' style="color: #FF6347;"></i>Acerca de</a>
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

                    <div class="mb-0 px-0 pt-4 text-center text-black-50"><hr></div>
                    <div class="mb-0 px-0 py-4 text-center text-black-50"></div>
                  </div>
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
