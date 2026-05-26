<?php
// Contenido de tabs para admin_calendarios.php
// Incluir dentro de <div class="tab-content"> en admin_calendarios.php
?>
    
    <!-- TAB 1: Calendarios fuente -->
    <div class="tab-pane fade show active" id="tab-calendarios" role="tabpanel" aria-labelledby="calendarios-tab">
        
        <!-- Formulario: Agregar calendario -->
        <section class="card admin-filter-card mb-3">
            <div class="card-body">
                <h5 class="admin-section-title"><i class="fa-regular fa-calendar-plus"></i>Agregar calendario fuente</h5>
                <form method="post">
                    <input type="hidden" name="accion" value="guardar_calendario">
                    <div class="admin-source-grid">
                        <div>
                            <label class="admin-form-label">Nombre</label>
                            <input class="form-control admin-input" name="nombre" placeholder="Classroom Pediatr&iacute;a, R1, Turnos..." required>
                        </div>
                        <div>
                            <label class="admin-form-label">Calendar ID</label>
                            <input class="form-control admin-input" name="calendar_id" placeholder="xxxx@group.calendar.google.com" required>
                        </div>
                        <div>
                            <label class="admin-form-label">Tipo (grupo objetivo)</label>
                            <select class="form-select admin-select" name="tipo" required>
                                <?php foreach ($tiposValidos as $tipo) { ?>
                                    <option value="<?= h($tipo) ?>"><?= tipo_label($tipo) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label">Activo</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" checked>
                            </div>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label"><i class="fa-regular fa-bell me-1"></i>1ra notif.</label>
                            <select class="form-select admin-select" name="notif_dias" style="min-width: 120px;">
                                <option value="0">No notificar</option>
                                <?php foreach ($dias_notif_opciones as $dias => $label) { ?>
                                    <option value="<?= $dias ?>"><?= h($label) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label"><i class="fa-regular fa-bell me-1"></i>Mismo d&iacute;a</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notif_same_day" checked>
                            </div>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label"><i class="fa-regular fa-envelope me-1"></i>Email</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notif_email">
                            </div>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label" title="Solo Lunes a Viernes"><i class="fa-solid fa-briefcase me-1"></i>L-V</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="notif_weekdays" checked>
                            </div>
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label"><i class="fa-regular fa-clock me-1"></i>Hora env&iacute;o</label>
                            <select class="form-select admin-select" name="notif_hora" style="min-width: 90px;">
                                <?php foreach ($horas_email_opciones as $hora => $label) { ?>
                                    <option value="<?= $hora ?>" <?= $hora === '08:00' ? 'selected' : '' ?>><?= h($label) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="admin-action-cell d-grid">
                            <button class="btn btn-admin-primary">Agregar</button>
                        </div>
                    </div>
                </form>
                <div class="admin-help-text small mt-2">
                    <strong>Importante:</strong> comparte cada calendario en Google con el email de la cuenta de servicio y permiso &quot;Ver todos los detalles&quot;.
                </div>
            </div>
        </section>

        <hr class="my-4">
        <h6 class="text-muted mb-3"><i class="fa-regular fa-calendar me-1"></i>Calendarios registrados</h6>

        <?php if (count($calendarios) === 0) { ?>
            <div class="card admin-item-card mb-3">
                <div class="admin-empty-state">
                    <div class="mb-2"><i class="fa-regular fa-calendar"></i></div>
                    <strong>No hay calendarios registrados.</strong>
                    <div class="small mt-1">Agrega el calendario general y luego los de nivel, Classroom o rotaciones.</div>
                </div>
            </div>
        <?php } ?>

        <?php foreach ($calendarios as $cal) { ?>
            <div class="card admin-item-card mb-3">
                <div class="card-body">
                    <div class="admin-item-header">
                        <div>
                            <div class="admin-item-title"><?= h($cal['nombre']) ?></div>
                            <div class="admin-item-meta"><?= h($cal['calendar_id']) ?></div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            <span class="admin-badge admin-badge-primary"><?= tipo_label($cal['tipo']) ?></span>
                            <span class="admin-badge <?= (int)$cal['activo'] === 1 ? 'admin-badge-success' : 'admin-badge-muted' ?>">
                                <?= (int)$cal['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </div>
                    </div>

                    <form method="post">
                        <input type="hidden" name="accion" value="guardar_calendario">
                        <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                        <div class="admin-source-grid">
                            <div>
                                <label class="admin-form-label">Nombre</label>
                                <input class="form-control admin-input" name="nombre" value="<?= h($cal['nombre']) ?>" required>
                            </div>
                            <div>
                                <label class="admin-form-label">Calendar ID</label>
                                <input class="form-control admin-input" name="calendar_id" value="<?= h($cal['calendar_id']) ?>" required>
                            </div>
                            <div>
                                <label class="admin-form-label">Tipo</label>
                                <select class="form-select admin-select" name="tipo" required>
                                    <?php foreach ($tiposValidos as $tipo) { ?>
                                        <option value="<?= h($tipo) ?>" <?= $cal['tipo'] === $tipo ? 'selected' : '' ?>><?= tipo_label($tipo) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label">Activo</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="activo" <?= (int)$cal['activo'] === 1 ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label"><i class="fa-regular fa-bell me-1"></i>1ra notif.</label>
                                <select class="form-select admin-select" name="notif_dias" style="min-width: 120px;">
                                    <option value="0">No notificar</option>
                                    <?php foreach ($dias_notif_opciones as $dias => $label) { ?>
                                        <option value="<?= $dias ?>" <?= (int)($cal['notif_dias'] ?? 0) === $dias ? 'selected' : '' ?>><?= h($label) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label"><i class="fa-regular fa-bell me-1"></i>Mismo d&iacute;a</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="notif_same_day" <?= (int)($cal['notif_same_day'] ?? 0) === 1 ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label"><i class="fa-regular fa-envelope me-1"></i>Email</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="notif_email" <?= (int)($cal['notif_email'] ?? 0) === 1 ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label" title="Solo Lunes a Viernes"><i class="fa-solid fa-briefcase me-1"></i>L-V</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="notif_weekdays" <?= (int)($cal['notif_weekdays'] ?? 0) === 1 ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label"><i class="fa-regular fa-clock me-1"></i>Hora env&iacute;o</label>
                                <select class="form-select admin-select" name="notif_hora" style="min-width: 90px;">
                                    <?php 
                                    $hora_actual = ($cal['notif_hora'] ?? '08:00');
                                    foreach ($horas_email_opciones as $hora => $label) { 
                                    ?>
                                        <option value="<?= $hora ?>" <?= $hora === $hora_actual ? 'selected' : '' ?>><?= h($label) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="admin-action-cell d-grid">
                                <button class="btn btn-admin-primary">Guardar</button>
                            </div>
                        </div>
                    </form>

                    <form method="post" class="mt-2 text-end">
                        <input type="hidden" name="accion" value="eliminar_calendario">
                        <input type="hidden" name="id" value="<?= (int)$cal['id'] ?>">
                        <button class="btn btn-sm btn-admin-danger" data-confirm="&iquest;Confirmas eliminar este calendario de la app? Tambi&eacute;n se eliminar&aacute;n sus asignaciones. No borra el calendario en Google.">Eliminar</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <!-- TAB 2: Asignaciones temporales -->
    <div class="tab-pane fade" id="tab-asignaciones" role="tabpanel" aria-labelledby="asignaciones-tab">
        
        <!-- Formulario: Asignar calendario temporal -->
        <section class="card admin-filter-card mb-3">
            <div class="card-body">
                <h5 class="admin-section-title"><i class="fa-solid fa-user-clock"></i>Asignar calendario temporal</h5>
                <form method="post">
                    <input type="hidden" name="accion" value="guardar_asignacion">
                    <input type="hidden" name="grupo_seleccionado" id="asignar_grupo_seleccionado" value="">
                    <div class="admin-assignment-grid">
                        <div class="admin-user-picker admin-grid-full">
                            <input type="hidden" name="usuario_id" id="asignar_usuario_id">
                            <div class="admin-user-picker-grid">
                                <div>
                                    <label class="admin-form-label">Filtrar usuarios por grupo</label>
                                    <select class="form-select admin-select" id="asignar_grupo_usuario">
                                        <option value="r1">R1 - 1&deg; a&ntilde;o</option>
                                        <option value="r2">R2 - 2&deg; a&ntilde;o</option>
                                        <option value="r3">R3 - 3&deg; a&ntilde;o</option>
                                        <option value="staff">Staff (todos)</option>
                                        <option value="docente">Docentes</option>
                                        <option value="becados">Becados Anestesia (todos)</option>
                                        <option value="becados_pasantes">Becados/Pasantes Otros</option>
                                        <option value="todos">Todos</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="admin-form-label">Buscar por nombre o correo</label>
                                    <input class="form-control admin-input" type="search" id="asignar_buscar_usuario" placeholder="Escribe para filtrar usuarios...">
                                </div>
                            </div>
                            <small class="form-text text-muted d-block mt-1 mb-2">Filtro de b&uacute;squeda. El grupo objetivo se define en "Agregar calendario fuente"</small>
                            <div class="admin-user-list" id="asignar_lista_usuarios">
                                <?php foreach ($usuarios as $usr) {
                                    $usrTexto = html_entity_decode((string)$usr['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . ' ' . (string)$usr['email_usuario'];
                                ?>
                                    <button type="button"
                                            class="admin-user-option"
                                            data-user-id="<?= (int)$usr['ID'] ?>"
                                            data-user-group="<?= h($usr['grupo_usuario']) ?>"
                                            data-user-text="<?= h(app_lower_text($usrTexto, 'UTF-8')) ?>"
                                            data-user-label="<?= h_nombre($usr['nombre_usuario']) ?> &middot; <?= h($usr['email_usuario']) ?>">
                                        <div class="admin-user-name"><?= h_nombre($usr['nombre_usuario']) ?></div>
                                        <div class="admin-user-email"><?= h($usr['email_usuario']) ?><?= (int)$usr['becad_'] === 1 && $usr['anio_residencia'] ? ' &middot; R' . (int)$usr['anio_residencia'] : '' ?></div>
                                        <span class="admin-user-group-badge"><?= h(usuario_grupo_label($usr['grupo_usuario'])) ?></span>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="admin-selected-user" id="asignar_usuario_seleccionado">Selecciona un usuario de la lista.</div>
                        </div>
                        <div>
                            <label class="admin-form-label">Calendario</label>
                            <select class="form-select admin-select" name="calendario_id" required>
                                <option value="">Seleccionar...</option>
                                <?php foreach ($calendarios as $cal) { ?>
                                    <option value="<?= (int)$cal['id'] ?>"><?= h($cal['nombre']) ?> &middot; <?= tipo_label($cal['tipo']) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div>
                            <label class="admin-form-label">Inicio</label>
                            <input class="form-control admin-input" type="date" name="fecha_inicio" required>
                        </div>
                        <div>
                            <label class="admin-form-label">Fin</label>
                            <input class="form-control admin-input" type="date" name="fecha_fin">
                        </div>
                        <div class="admin-active-cell">
                            <label class="admin-form-label">Activo</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="activo" checked>
                            </div>
                        </div>
                        <div class="admin-action-cell d-grid">
                            <button class="btn btn-admin-primary">Asignar</button>
                        </div>
                    </div>
                </form>
                <div class="admin-help-text small mt-2">
                    Para Classroom por rotaci&oacute;n, registra primero el calendario como tipo <strong>Classroom</strong> o <strong>Rotaciones</strong>, luego as&iacute;gnalo al residente con fechas.
                </div>
            </div>
        </section>

        <hr class="my-4">
        
        <!-- Filtro de asignaciones -->
        <section class="card admin-filter-card mb-3">
            <div class="card-body">
                <h6 class="admin-section-title"><i class="fa-solid fa-filter"></i>Filtrar asignaciones existentes</h6>
                <div class="admin-assignment-filters">
                    <div>
                        <label class="admin-form-label">Grupo</label>
                        <select class="form-select admin-select" id="filtro_asignaciones_grupo">
                            <option value="todos">Todos</option>
                            <option value="r1">R1</option>
                            <option value="r2">R2</option>
                            <option value="r3">R3</option>
                            <option value="becados">Becados (sin nivel)</option>
                            <option value="becados_pasantes">Becados Pasantes</option>
                            <option value="docente">Docentes</option>
                            <option value="staff">Staff (no docente)</option>
                            <option value="individual">Individual</option>
                        </select>
                    </div>
                    <div>
                        <label class="admin-form-label">Individuo / texto</label>
                        <input class="form-control admin-input" type="search" id="filtro_asignaciones_texto" placeholder="Filtrar por nombre, correo o calendario...">
                    </div>
                </div>
                <div class="admin-filter-summary" id="resumen_filtro_asignaciones"></div>
            </div>
        </section>

        <h6 class="text-muted mb-3"><i class="fa-solid fa-list me-1"></i>Asignaciones registradas</h6>

        <?php if (count($asignaciones) === 0) { ?>
            <div class="card admin-item-card mb-3">
                <div class="admin-empty-state">
                    <div class="mb-2"><i class="fa-solid fa-user-clock"></i></div>
                    <strong>No hay asignaciones temporales.</strong>
                    <div class="small mt-1">Los calendarios tipo general/R1/R2/R3 se muestran por perfil. Classroom, rotaciones y personales deben asignarse aqu&iacute;.</div>
                </div>
            </div>
        <?php } ?>

        <?php foreach ($asignaciones as $asig) { ?>
            <div class="card admin-item-card admin-assignment-card mb-3" data-user-group="<?= h($asig['grupo_usuario']) ?>" data-user-text="<?= h(app_lower_text(html_entity_decode((string)$asig['nombre_usuario'], ENT_QUOTES | ENT_HTML5, 'UTF-8') . ' ' . (string)$asig['email_usuario'] . ' ' . (string)$asig['calendario_nombre'], 'UTF-8')) ?>">
                <div class="card-body">
                    <div class="admin-item-header">
                        <div>
                            <div class="admin-item-title"><?= h_nombre($asig['nombre_usuario']) ?></div>
                            <div class="admin-item-meta">
                                <?= h($asig['email_usuario']) ?> &middot; <?= h($asig['calendario_nombre']) ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap justify-content-end">
                            <span class="admin-badge admin-badge-primary"><?= h($asig['grupo_usuario_label']) ?></span>
                            <span class="admin-badge admin-badge-purple"><?= tipo_label($asig['calendario_tipo']) ?></span>
                            <span class="admin-badge admin-badge-warning"><?= h($asig['fecha_inicio']) ?> a <?= h($asig['fecha_fin'] ?: 'sin fin') ?></span>
                            <span class="admin-badge <?= (int)$asig['activo'] === 1 ? 'admin-badge-success' : 'admin-badge-muted' ?>">
                                <?= (int)$asig['activo'] === 1 ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </div>
                    </div>

                    <form method="post">
                        <input type="hidden" name="accion" value="guardar_asignacion">
                        <input type="hidden" name="id" value="<?= (int)$asig['id'] ?>">
                        <div class="admin-assignment-grid">
                            <div>
                                <label class="admin-form-label">Usuario</label>
                                <select class="form-select admin-select" name="usuario_id" required>
                                    <?php foreach ($usuarios as $usr) { ?>
                                        <option value="<?= (int)$usr['ID'] ?>" <?= (int)$asig['usuario_id'] === (int)$usr['ID'] ? 'selected' : '' ?>>
                                            <?= h_nombre($usr['nombre_usuario']) ?> &middot; <?= h($usr['email_usuario']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <label class="admin-form-label">Calendario</label>
                                <select class="form-select admin-select" name="calendario_id" required>
                                    <?php foreach ($calendarios as $cal) { ?>
                                        <option value="<?= (int)$cal['id'] ?>" <?= (int)$asig['calendario_id'] === (int)$cal['id'] ? 'selected' : '' ?>><?= h($cal['nombre']) ?> &middot; <?= tipo_label($cal['tipo']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div>
                                <label class="admin-form-label">Inicio</label>
                                <input class="form-control admin-input" type="date" name="fecha_inicio" value="<?= h($asig['fecha_inicio']) ?>" required>
                            </div>
                            <div>
                                <label class="admin-form-label">Fin</label>
                                <input class="form-control admin-input" type="date" name="fecha_fin" value="<?= h($asig['fecha_fin']) ?>">
                            </div>
                            <div class="admin-active-cell">
                                <label class="admin-form-label">Activo</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="activo" <?= (int)$asig['activo'] === 1 ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <div class="admin-action-cell d-grid">
                                <button class="btn btn-admin-primary">Guardar</button>
                            </div>
                        </div>
                    </form>

                    <form method="post" class="mt-2 text-end">
                        <input type="hidden" name="accion" value="eliminar_asignacion">
                        <input type="hidden" name="id" value="<?= (int)$asig['id'] ?>">
                        <button class="btn btn-sm btn-admin-danger" data-confirm="&iquest;Confirmas eliminar esta asignaci&oacute;n temporal?">Eliminar</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (event) {
            const msg = btn.getAttribute('data-confirm');
            if (msg && !confirm(msg)) {
                event.preventDefault();
            }
        });
    });

    function normalizarTexto(txt) {
        return (txt || '').toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    const grupoSelect = document.getElementById('asignar_grupo_usuario');
    const buscarInput = document.getElementById('asignar_buscar_usuario');
    const usuarioHidden = document.getElementById('asignar_usuario_id');
    const grupoHidden = document.getElementById('asignar_grupo_seleccionado');
    const seleccionado = document.getElementById('asignar_usuario_seleccionado');
    const userButtons = Array.from(document.querySelectorAll('#asignar_lista_usuarios .admin-user-option'));

    function filtrarUsuariosAsignacion() {
        if (!grupoSelect || !buscarInput) return;
        const grupo = grupoSelect.value;
        const q = normalizarTexto(buscarInput.value);
        let visibles = 0;

        userButtons.forEach(function (btn) {
            const grupos = (btn.getAttribute('data-groups') || '').split(' ');
            const texto = btn.getAttribute('data-search') || '';
            const matchGrupo = grupo === 'todos' || grupos.indexOf(grupo) !== -1;
            const matchTexto = q === '' || texto.indexOf(q) !== -1;
            if (matchGrupo && matchTexto) {
                btn.style.display = '';
                visibles++;
            } else {
                btn.style.display = 'none';
            }
        });

        // Actualizar campo oculto de grupo
        if (grupoHidden && grupoSelect.value !== 'individual' && grupoSelect.value !== 'todos') {
            grupoHidden.value = grupoSelect.value;
        } else {
            grupoHidden.value = '';
        }
    }

    if (grupoSelect) grupoSelect.addEventListener('change', function () {
        if (usuarioHidden) usuarioHidden.value = '';
        userButtons.forEach(function (b) { b.classList.remove('is-selected'); });
        filtrarUsuariosAsignacion();
    });
    if (buscarInput) buscarInput.addEventListener('input', filtrarUsuariosAsignacion);
    filtrarUsuariosAsignacion();

    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const accion = form.querySelector('input[name="accion"]');
            if (accion && accion.value === 'guardar_asignacion' && form.querySelector('#asignar_usuario_id')) {
                // Validar: se requiere usuario_id O grupo_seleccionado
                const tieneUsuario = usuarioHidden && usuarioHidden.value !== '';
                const tieneGrupo = grupoHidden && grupoHidden.value !== '';
                
                if (!tieneUsuario && !tieneGrupo) {
                    event.preventDefault();
                    alert('Selecciona un usuario o un grupo antes de asignar el calendario.');
                }
            }
        });
    });

    const filtroGrupo = document.getElementById('filtro_asignaciones_grupo');
    const filtroTexto = document.getElementById('filtro_asignaciones_texto');
    const resumenFiltro = document.getElementById('resumen_filtro_asignaciones');
    const assignmentCards = Array.from(document.querySelectorAll('.admin-assignment-card'));

    function filtrarAsignaciones() {
        const grupo = filtroGrupo ? filtroGrupo.value : 'todos';
        const q = filtroTexto ? normalizarTexto(filtroTexto.value) : '';
        let visibles = 0;

        assignmentCards.forEach(function (card) {
            const group = card.getAttribute('data-user-group') || 'individual';
            const text = normalizarTexto(card.getAttribute('data-user-text') || '');
            const matchGrupo = grupo === 'todos' || group === grupo;
            const matchTexto = q === '' || text.includes(q);
            const mostrar = matchGrupo && matchTexto;
            card.style.display = mostrar ? '' : 'none';
            if (mostrar) visibles++;
        });

        if (resumenFiltro) {
            resumenFiltro.textContent = visibles + ' asignaci&oacute;n(es) visible(s) de ' + assignmentCards.length + '.';
        }
    }

    if (filtroGrupo) filtroGrupo.addEventListener('change', filtrarAsignaciones);
    if (filtroTexto) filtroTexto.addEventListener('input', filtrarAsignaciones);
    filtrarAsignaciones();
});
</script>
