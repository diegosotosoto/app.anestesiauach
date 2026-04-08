<?php
//Ve si está activa la cookie o redirige al login
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
  header('Location: login.php');
}

//Conexión
require("conectar.php");
$conexion=new mysqli($db_host,$db_usuario,$db_contra,$db_nombre);
$conexion->set_charset("utf8");

//Variables UI
$boton_toggler="<a class='d-sm-block d-sm-none btn text-white shadow-sm border-dark' style='width:80px; height:40px;' href='index.php'><i class='fa fa-chevron-left'></i>Atrás</a>";
$titulo_navbar="<span class='text-white'>Bitácora</span>";
$boton_navbar="<a></a>";

require("head.php");
?>

<div class="col col-sm-9 col-xl-9 pb-5 app-main-col">

<style>
.bitacora-shell{max-width:1100px;margin:0 auto;}
.bitacora-topbar{
  background:linear-gradient(135deg,#27458f,#3559b7);
  color:#fff;border-radius:1.2rem;padding:1.2rem;margin-bottom:1rem;
}
.bitacora-card{
  border-radius:1rem;
  box-shadow:0 8px 24px rgba(0,0,0,.06);
  background:#fff;
  padding:1rem;
}
.bitacora-tabs .nav-link.active{
  background:#3559b7;color:#fff;border-radius:.8rem;
}
</style>

<div class="apunte-surface">
<div class="bitacora-shell">

<div class="bitacora-topbar">
  <h4 class="mb-1">Estadística de Bitácora</h4>
  <div class="small text-white-50">Resumen de actividad validada</div>
</div>

<ul class="nav nav-tabs bitacora-tabs mb-3">
  <li class="nav-item">
    <a class="nav-link" href="bitacora_ingreso.php">Ingreso</a>
  </li>
  <li class="nav-item">
    <span class="nav-link active">Estadística</span>
  </li>
</ul>

<div class="bitacora-card text-center">
  <div class="py-4">
    <i class="fa-solid fa-chart-column fa-3x mb-3 text-primary"></i>
    <h5>Estadísticas cargadas correctamente</h5>
    <p class="text-muted">Aquí se mostrarán los gráficos y datos procesados.</p>
  </div>
</div>

</div>
</div>

<?php
$conexion->close();
require("footer.php");
?>
