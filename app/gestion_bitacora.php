<?php
if(!isset($_COOKIE['hkjh41lu4l1k23jhlkj13'])){
	header('Location: login.php');
	exit;
}

// Conexión
require("conectar.php");
$conexion = new mysqli($db_host, $db_usuario, $db_contra, $db_nombre);
$conexion->set_charset("utf8mb4");

// chequea privilegios de administrador
$check_usuario = $_COOKIE['hkjh41lu4l1k23jhlkj13'];
$con_users_b = "SELECT `ID`, `admin`, `nombre_usuario`, `email_usuario`
				FROM `usuarios_dolor`
				WHERE `email_usuario` = '$check_usuario'
				LIMIT 1";
$users_b = $conexion->query($con_users_b);
$usuario = $users_b ? $users_b->fetch_assoc() : null;

if(!$usuario || (int)$usuario['admin'] !== 1){
	header('Location: login.php');
	exit;
}

// Variables navbar
$boton_toggler="<a class='btn btn-lg shadow-sm border-light d-sm-block d-sm-none' style='--bs-border-opacity: .1;' href='index.php'><div class='text-white'><i class='fa fa-chevron-left'></i>Atrás</div></a>";
$titulo_navbar="<span class='text-white d-sm-block d-sm-none'>Gestión</span>";
$boton_navbar="<a></a><a></a>";

// Carga Head
require("head.php");

function h($v){
	return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function h_nombre($v){
	return htmlspecialchars(
		html_entity_decode((string)$v, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
		ENT_QUOTES,
		'UTF-8'
	);
}

$mensaje = "";
$error = "";

/*
|--------------------------------------------------------------------------
| Acciones
|--------------------------------------------------------------------------
*/
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion_bitacora'])){
	$accion = trim($_POST['accion_bitacora']);

	try{
		if($accion === 'aprobar_individual'){
			$tabla = trim($_POST['tabla'] ?? '');
			$id = (int)($_POST['id'] ?? 0);

			if($id <= 0){
				throw new Exception("Registro inválido.");
			}

			if($tabla === 'bitacora_proced'){
				$sql = "UPDATE `bitacora_proced` SET `aprobado_staff_b` = 1 WHERE `id_b` = $id";
			}elseif($tabla === 'bitacora_internos'){
				$sql = "UPDATE `bitacora_internos` SET `aprobado_staff_i` = 1 WHERE `id_i` = $id";
			}else{
				throw new Exception("Tabla inválida.");
			}

			if(!$conexion->query($sql)){
				throw new Exception("No se pudo aprobar el registro.");
			}

			$mensaje = "Registro aprobado correctamente.";
		}

		if($accion === 'aprobar_staff'){
			$tabla = trim($_POST['tabla'] ?? '');
			$staff_email = trim($_POST['staff_email'] ?? '');
			$staff_email = $conexion->real_escape_string($staff_email);

			if($staff_email === ''){
				throw new Exception("Staff inválido.");
			}

			if($tabla === 'bitacora_proced'){
				$sql = "UPDATE `bitacora_proced`
						SET `aprobado_staff_b` = 1
						WHERE `staff_b` = '$staff_email'
						  AND `aprobado_staff_b` = 0";
			}elseif($tabla === 'bitacora_internos'){
				$sql = "UPDATE `bitacora_internos`
						SET `aprobado_staff_i` = 1
						WHERE `staff_i` = '$staff_email'
						  AND `aprobado_staff_i` = 0";
			}else{
				throw new Exception("Tabla inválida.");
			}

			if(!$conexion->query($sql)){
				throw new Exception("No se pudieron aprobar las bitácoras del staff.");
			}

			$mensaje = "Bitácoras aprobadas para el staff seleccionado.";
		}

		if($accion === 'aprobar_grupo'){
			$grupo = trim($_POST['grupo'] ?? '');

			if($grupo === 'becados_residentes'){
				$sql = "UPDATE `bitacora_proced`
						SET `aprobado_staff_b` = 1
						WHERE `aprobado_staff_b` = 0";
			}elseif($grupo === 'internos'){
				$sql = "UPDATE `bitacora_internos` bi
						INNER JOIN `usuarios_dolor` u
							ON u.`email_usuario` = bi.`autor_i`
						SET bi.`aprobado_staff_i` = 1
						WHERE bi.`aprobado_staff_i` = 0
						  AND u.`intern_` = 1";
			}elseif($grupo === 'becados_pasantes'){
				$sql = "UPDATE `bitacora_internos` bi
						INNER JOIN `usuarios_dolor` u
							ON u.`email_usuario` = bi.`autor_i`
						SET bi.`aprobado_staff_i` = 1
						WHERE bi.`aprobado_staff_i` = 0
						  AND u.`becad_otro` = 1";
			}else{
				throw new Exception("Grupo inválido.");
			}

			if(!$conexion->query($sql)){
				throw new Exception("No se pudo aprobar el grupo.");
			}

			$mensaje = "Bitácoras aprobadas para el grupo seleccionado.";
		}

		if($accion === 'aprobar_todo'){
			$conexion->begin_transaction();

			$sql1 = "UPDATE `bitacora_proced` SET `aprobado_staff_b` = 1 WHERE `aprobado_staff_b` = 0";
			$sql2 = "UPDATE `bitacora_internos` SET `aprobado_staff_i` = 1 WHERE `aprobado_staff_i` = 0";

			if(!$conexion->query($sql1) || !$conexion->query($sql2)){
				throw new Exception("No se pudo aprobar todo.");
			}

			$conexion->commit();
			$mensaje = "Se aprobaron todas las bitácoras pendientes.";
		}

	}catch(Throwable $e){
		if($conexion->errno){
			$conexion->rollback();
		}
		$error = $e->getMessage();
	}
}

/*
|--------------------------------------------------------------------------
| Resúmenes
|--------------------------------------------------------------------------
*/
$resumen = [
	'becados_residentes' => 0,
	'internos' => 0,
	'becados_pasantes' => 0
];

$q1 = $conexion->query("SELECT COUNT(*) AS total FROM `bitacora_proced` WHERE `aprobado_staff_b` = 0");
if($q1 && $r = $q1->fetch_assoc()){
	$resumen['becados_residentes'] = (int)$r['total'];
}

$q2 = $conexion->query("
	SELECT COUNT(*) AS total
	FROM `bitacora_internos` bi
	INNER JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bi.`autor_i`
	WHERE bi.`aprobado_staff_i` = 0
	  AND u.`intern_` = 1
");
if($q2 && $r = $q2->fetch_assoc()){
	$resumen['internos'] = (int)$r['total'];
}

$q3 = $conexion->query("
	SELECT COUNT(*) AS total
	FROM `bitacora_internos` bi
	INNER JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bi.`autor_i`
	WHERE bi.`aprobado_staff_i` = 0
	  AND u.`becad_otro` = 1
");
if($q3 && $r = $q3->fetch_assoc()){
	$resumen['becados_pasantes'] = (int)$r['total'];
}

/*
|--------------------------------------------------------------------------
| Pendientes por staff
|--------------------------------------------------------------------------
*/
$pendientes_staff_b = [];
$rsb = $conexion->query("
	SELECT
		bp.`staff_b` AS staff_email,
		MAX(u.`nombre_usuario`) AS staff_nombre,
		COUNT(*) AS cantidad
	FROM `bitacora_proced` bp
	LEFT JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bp.`staff_b`
	WHERE bp.`aprobado_staff_b` = 0
	  AND bp.`staff_b` IS NOT NULL
	  AND bp.`staff_b` <> ''
	GROUP BY bp.`staff_b`
	ORDER BY bp.`staff_b` ASC
");
if($rsb){
	while($row = $rsb->fetch_assoc()){
		$pendientes_staff_b[] = $row;
	}
}

$pendientes_staff_i = [];
$rsi = $conexion->query("
	SELECT
		bi.`staff_i` AS staff_email,
		MAX(u.`nombre_usuario`) AS staff_nombre,
		COUNT(*) AS cantidad
	FROM `bitacora_internos` bi
	LEFT JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bi.`staff_i`
	WHERE bi.`aprobado_staff_i` = 0
	  AND bi.`staff_i` IS NOT NULL
	  AND bi.`staff_i` <> ''
	GROUP BY bi.`staff_i`
	ORDER BY bi.`staff_i` ASC
");
if($rsi){
	while($row = $rsi->fetch_assoc()){
		$pendientes_staff_i[] = $row;
	}
}

/*
|--------------------------------------------------------------------------
| Pendientes individuales
|--------------------------------------------------------------------------
*/
$pendientes_residentes = [];
$q_residentes = $conexion->query("
	SELECT
		bp.`id_b` AS id,
		bp.`autor_b` AS autor_email,
		u.`nombre_usuario`,
		bp.`procedimiento_b` AS procedimiento,
		bp.`fecha_b` AS fecha,
		bp.`staff_b` AS staff_email,
		us.`nombre_usuario` AS staff_nombre,
		'bitacora_proced' AS tabla
	FROM `bitacora_proced` bp
	LEFT JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bp.`autor_b`
	LEFT JOIN `usuarios_dolor` us
		ON us.`email_usuario` = bp.`staff_b`
	WHERE bp.`aprobado_staff_b` = 0
	ORDER BY bp.`fecha_b` DESC, bp.`id_b` DESC
");
if($q_residentes){
	while($row = $q_residentes->fetch_assoc()){
		$pendientes_residentes[] = $row;
	}
}

$pendientes_internos = [];
$q_internos = $conexion->query("
	SELECT
		bi.`id_i` AS id,
		bi.`autor_i` AS autor_email,
		u.`nombre_usuario`,
		bi.`procedimiento_i` AS procedimiento,
		bi.`fecha_i` AS fecha,
		bi.`staff_i` AS staff_email,
		us.`nombre_usuario` AS staff_nombre,
		'bitacora_internos' AS tabla
	FROM `bitacora_internos` bi
	INNER JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bi.`autor_i`
	LEFT JOIN `usuarios_dolor` us
		ON us.`email_usuario` = bi.`staff_i`
	WHERE bi.`aprobado_staff_i` = 0
	  AND u.`intern_` = 1
	ORDER BY bi.`fecha_i` DESC, bi.`id_i` DESC
");
if($q_internos){
	while($row = $q_internos->fetch_assoc()){
		$pendientes_internos[] = $row;
	}
}

$pendientes_pasantes = [];
$q_pasantes = $conexion->query("
	SELECT
		bi.`id_i` AS id,
		bi.`autor_i` AS autor_email,
		u.`nombre_usuario`,
		bi.`procedimiento_i` AS procedimiento,
		bi.`fecha_i` AS fecha,
		bi.`staff_i` AS staff_email,
		us.`nombre_usuario` AS staff_nombre,
		'bitacora_internos' AS tabla
	FROM `bitacora_internos` bi
	INNER JOIN `usuarios_dolor` u
		ON u.`email_usuario` = bi.`autor_i`
	LEFT JOIN `usuarios_dolor` us
		ON us.`email_usuario` = bi.`staff_i`
	WHERE bi.`aprobado_staff_i` = 0
	  AND u.`becad_otro` = 1
	ORDER BY bi.`fecha_i` DESC, bi.`id_i` DESC
");
if($q_pasantes){
	while($row = $q_pasantes->fetch_assoc()){
		$pendientes_pasantes[] = $row;
	}
}
?>

<style>
.gestion-shell{
	max-width:1100px;
	margin:0 auto;
}

.gestion-card{
	background:#fff;
	border:1px solid #dfe7f2;
	border-radius:18px;
	box-shadow:0 8px 24px rgba(0,0,0,.06);
	padding:1rem 1.1rem;
	margin-bottom:1rem;
}

.gestion-title{
	font-size:1.25rem;
	font-weight:700;
	color:#1f2a37;
}

.gestion-subtle{
	color:#6b7280;
	font-size:.92rem;
}

.gestion-grid{
	display:grid;
	grid-template-columns:repeat(3, 1fr);
	gap:12px;
}

.gestion-stat{
	background:linear-gradient(0deg, #e9effb 0%, #ffffff 40%, #ffffff 100%);
	border:1px solid #dfe7f2;
	border-radius:16px;
	padding:1rem;
}

.gestion-stat-num{
	font-size:1.6rem;
	font-weight:800;
	color:#244aa5;
}

.gestion-stat-label{
	color:#4b5563;
	font-weight:600;
}

.gestion-table{
	width:100%;
	border-collapse:separate;
	border-spacing:0;
}

.gestion-table th,
.gestion-table td{
	padding:.8rem .9rem;
	border-bottom:1px solid #e5e7eb;
	vertical-align:middle;
}

.gestion-table th{
	color:#1f2a37;
	font-weight:700;
	background:#f8fafc;
}

.gestion-table tr:last-child td{
	border-bottom:0;
}

.gestion-badge{
	display:inline-block;
	padding:.22rem .55rem;
	border-radius:999px;
	font-size:.78rem;
	font-weight:700;
	background:#dbeafe;
	color:#1d4ed8;
}

.gestion-block-title{
	font-size:1.05rem;
	font-weight:700;
	color:#1f2a37;
	margin-bottom:.75rem;
}

.gestion-empty{
	color:#6b7280;
	padding:.6rem 0;
}

@media (max-width: 900px){
	.gestion-grid{
		grid-template-columns:1fr;
	}

	.gestion-table{
		display:block;
		overflow-x:auto;
		white-space:nowrap;
	}
}
</style>

<div class="col col-sm-9 col-xl-9 pb-5">
	<div class="container-fluid gestion-shell">

		<?php if($mensaje !== ""){ ?>
			<div class='alert alert-success alert-dismissible fade show'>
				<button type='button' class='btn-close' data-bs-dismiss='alert'></button>
				<strong>Info:</strong> <?= h($mensaje) ?>
			</div>
		<?php } ?>

		<?php if($error !== ""){ ?>
			<div class='alert alert-danger alert-dismissible fade show'>
				<button type='button' class='btn-close' data-bs-dismiss='alert'></button>
				<strong>Error:</strong> <?= h($error) ?>
			</div>
		<?php } ?>

		<div class="gestion-card">
			<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
				<div>
					<div class="gestion-title">Gestión Bitácoras</div>
					<div class="gestion-subtle">Aprobación administrativa de registros pendientes</div>
				</div>

				<form method="post" onsubmit="return confirm('¿Aprobar absolutamente todas las bitácoras pendientes?');">
					<input type="hidden" name="accion_bitacora" value="aprobar_todo">
					<button type="submit" class="btn btn-danger">Aprobar todo</button>
				</form>
			</div>
		</div>

		<div class="gestion-grid mb-3">
			<div class="gestion-stat">
				<div class="gestion-stat-num"><?= (int)$resumen['becados_residentes'] ?></div>
				<div class="gestion-stat-label">Becados / residentes</div>
				<form method="post" class="mt-3" onsubmit="return confirm('¿Aprobar todas las bitácoras pendientes de becados/residentes?');">
					<input type="hidden" name="accion_bitacora" value="aprobar_grupo">
					<input type="hidden" name="grupo" value="becados_residentes">
					<button type="submit" class="btn btn-outline-primary btn-sm">Aprobar grupo</button>
				</form>
			</div>

			<div class="gestion-stat">
				<div class="gestion-stat-num"><?= (int)$resumen['internos'] ?></div>
				<div class="gestion-stat-label">Internos</div>
				<form method="post" class="mt-3" onsubmit="return confirm('¿Aprobar todas las bitácoras pendientes de internos?');">
					<input type="hidden" name="accion_bitacora" value="aprobar_grupo">
					<input type="hidden" name="grupo" value="internos">
					<button type="submit" class="btn btn-outline-primary btn-sm">Aprobar grupo</button>
				</form>
			</div>

			<div class="gestion-stat">
				<div class="gestion-stat-num"><?= (int)$resumen['becados_pasantes'] ?></div>
				<div class="gestion-stat-label">Becados pasantes</div>
				<form method="post" class="mt-3" onsubmit="return confirm('¿Aprobar todas las bitácoras pendientes de becados pasantes?');">
					<input type="hidden" name="accion_bitacora" value="aprobar_grupo">
					<input type="hidden" name="grupo" value="becados_pasantes">
					<button type="submit" class="btn btn-outline-primary btn-sm">Aprobar grupo</button>
				</form>
			</div>
		</div>

		<div class="gestion-card">
			<div class="gestion-block-title">Pendientes por staff · Becados / residentes</div>

			<?php if(empty($pendientes_staff_b)){ ?>
				<div class="gestion-empty">No hay pendientes en bitácora de becados/residentes.</div>
			<?php } else { ?>
				<table class="gestion-table">
					<thead>
						<tr>
							<th>Staff</th>
							<th>Cantidad</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pendientes_staff_b as $row){ ?>
							<tr>
								<td>
									<?= !empty($row['staff_nombre']) ? h_nombre($row['staff_nombre']) : h($row['staff_email']) ?>
									<div class="gestion-subtle"><?= h($row['staff_email']) ?></div>
								</td>
								<td><span class="gestion-badge"><?= (int)$row['cantidad'] ?></span></td>
								<td>
									<form method="post" onsubmit="return confirm('¿Aprobar todas las bitácoras pendientes de este staff?');">
										<input type="hidden" name="accion_bitacora" value="aprobar_staff">
										<input type="hidden" name="tabla" value="bitacora_proced">
										<input type="hidden" name="staff_email" value="<?= h($row['staff_email']) ?>">
										<button type="submit" class="btn btn-outline-success btn-sm">Aprobar staff</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

		<div class="gestion-card">
			<div class="gestion-block-title">Pendientes por staff · Internos / becados pasantes</div>

			<?php if(empty($pendientes_staff_i)){ ?>
				<div class="gestion-empty">No hay pendientes en bitácora de internos/pasantes.</div>
			<?php } else { ?>
				<table class="gestion-table">
					<thead>
						<tr>
							<th>Staff</th>
							<th>Cantidad</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pendientes_staff_i as $row){ ?>
							<tr>
								<td>
									<?= !empty($row['staff_nombre']) ? h_nombre($row['staff_nombre']) : h($row['staff_email']) ?>
									<div class="gestion-subtle"><?= h($row['staff_email']) ?></div>
								</td>
								<td><span class="gestion-badge"><?= (int)$row['cantidad'] ?></span></td>
								<td>
									<form method="post" onsubmit="return confirm('¿Aprobar todas las bitácoras pendientes de este staff?');">
										<input type="hidden" name="accion_bitacora" value="aprobar_staff">
										<input type="hidden" name="tabla" value="bitacora_internos">
										<input type="hidden" name="staff_email" value="<?= h($row['staff_email']) ?>">
										<button type="submit" class="btn btn-outline-success btn-sm">Aprobar staff</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

		<div class="gestion-card">
			<div class="gestion-block-title">Registros individuales · Becados / residentes</div>

			<?php if(empty($pendientes_residentes)){ ?>
				<div class="gestion-empty">No hay registros pendientes.</div>
			<?php } else { ?>
				<table class="gestion-table">
					<thead>
						<tr>
							<th>Autor</th>
							<th>Procedimiento</th>
							<th>Fecha</th>
							<th>Staff</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pendientes_residentes as $row){ ?>
							<tr>
								<td>
									<?= !empty($row['nombre_usuario']) ? h_nombre($row['nombre_usuario']) : h($row['autor_email']) ?>
									<div class="gestion-subtle"><?= h($row['autor_email']) ?></div>
								</td>
								<td><?= h_nombre($row['procedimiento']) ?></td>
								<td><?= h($row['fecha']) ?></td>
								<td>
									<?= !empty($row['staff_nombre']) ? h_nombre($row['staff_nombre']) : h($row['staff_email']) ?>
									<div class="gestion-subtle"><?= h($row['staff_email']) ?></div>
								</td>
								<td>
									<form method="post" onsubmit="return confirm('¿Aprobar este registro individual?');">
										<input type="hidden" name="accion_bitacora" value="aprobar_individual">
										<input type="hidden" name="tabla" value="bitacora_proced">
										<input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
										<button type="submit" class="btn btn-primary btn-sm">Aprobar</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

		<div class="gestion-card">
			<div class="gestion-block-title">Registros individuales · Internos</div>

			<?php if(empty($pendientes_internos)){ ?>
				<div class="gestion-empty">No hay registros pendientes.</div>
			<?php } else { ?>
				<table class="gestion-table">
					<thead>
						<tr>
							<th>Autor</th>
							<th>Procedimiento</th>
							<th>Fecha</th>
							<th>Staff</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pendientes_internos as $row){ ?>
							<tr>
								<td>
									<?= !empty($row['nombre_usuario']) ? h_nombre($row['nombre_usuario']) : h($row['autor_email']) ?>
									<div class="gestion-subtle"><?= h($row['autor_email']) ?></div>
								</td>
								<td><?= h_nombre($row['procedimiento']) ?></td>
								<td><?= h($row['fecha']) ?></td>
								<td>
									<?= !empty($row['staff_nombre']) ? h_nombre($row['staff_nombre']) : h($row['staff_email']) ?>
									<div class="gestion-subtle"><?= h($row['staff_email']) ?></div>
								</td>
								<td>
									<form method="post" onsubmit="return confirm('¿Aprobar este registro individual?');">
										<input type="hidden" name="accion_bitacora" value="aprobar_individual">
										<input type="hidden" name="tabla" value="bitacora_internos">
										<input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
										<button type="submit" class="btn btn-primary btn-sm">Aprobar</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

		<div class="gestion-card">
			<div class="gestion-block-title">Registros individuales · Becados pasantes</div>

			<?php if(empty($pendientes_pasantes)){ ?>
				<div class="gestion-empty">No hay registros pendientes.</div>
			<?php } else { ?>
				<table class="gestion-table">
					<thead>
						<tr>
							<th>Autor</th>
							<th>Procedimiento</th>
							<th>Fecha</th>
							<th>Staff</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($pendientes_pasantes as $row){ ?>
							<tr>
								<td>
									<?= !empty($row['nombre_usuario']) ? h_nombre($row['nombre_usuario']) : h($row['autor_email']) ?>
									<div class="gestion-subtle"><?= h($row['autor_email']) ?></div>
								</td>
								<td><?= h_nombre($row['procedimiento']) ?></td>
								<td><?= h($row['fecha']) ?></td>
								<td>
									<?= !empty($row['staff_nombre']) ? h_nombre($row['staff_nombre']) : h($row['staff_email']) ?>
									<div class="gestion-subtle"><?= h($row['staff_email']) ?></div>
								</td>
								<td>
									<form method="post" onsubmit="return confirm('¿Aprobar este registro individual?');">
										<input type="hidden" name="accion_bitacora" value="aprobar_individual">
										<input type="hidden" name="tabla" value="bitacora_internos">
										<input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
										<button type="submit" class="btn btn-primary btn-sm">Aprobar</button>
									</form>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>

	</div>
</div>

<?php require("footer.php"); ?>