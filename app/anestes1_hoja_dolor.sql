-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-05-2026 a las 17:10:12
-- Versión del servidor: 8.4.6-cll-lve
-- Versión de PHP: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `anestes1_hoja_dolor`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_auth_sessions`
--

CREATE TABLE `app_auth_sessions` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `token_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime NOT NULL,
  `revoked_at` datetime DEFAULT NULL,
  `last_seen_at` datetime DEFAULT NULL,
  `user_agent_hash` char(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_hash` char(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_internos`
--

CREATE TABLE `bitacora_internos` (
  `id_i` int NOT NULL,
  `autor_i` varchar(250) DEFAULT NULL,
  `rut_i` varchar(100) DEFAULT NULL,
  `ficha_i` varchar(30) DEFAULT NULL,
  `edad_i` varchar(250) DEFAULT NULL,
  `procedimiento_i` varchar(250) DEFAULT NULL,
  `fecha_i` varchar(100) DEFAULT NULL,
  `evaluacion_i` varchar(10) NOT NULL DEFAULT '0',
  `ventilacion_i` varchar(10) NOT NULL DEFAULT '0',
  `intubacion_i` varchar(10) NOT NULL DEFAULT '0',
  `lma_i` varchar(10) NOT NULL DEFAULT '0',
  `ayudas_i` varchar(10) NOT NULL DEFAULT '0',
  `vvp_i` varchar(10) NOT NULL DEFAULT '0',
  `espinal_i` varchar(10) NOT NULL DEFAULT '0',
  `seminario_i` varchar(10) NOT NULL DEFAULT '0',
  `staff_i` varchar(250) DEFAULT NULL,
  `aprobado_staff_i` tinyint(1) NOT NULL DEFAULT '0',
  `comentarios_i` varchar(500) DEFAULT NULL,
  `feedback_i` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_internos_backup_staff`
--

CREATE TABLE `bitacora_internos_backup_staff` (
  `id_i` int NOT NULL DEFAULT '0',
  `staff_i` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_proced`
--

CREATE TABLE `bitacora_proced` (
  `id_b` int NOT NULL,
  `autor_b` varchar(250) DEFAULT NULL,
  `rut_b` varchar(100) DEFAULT NULL,
  `ficha_b` varchar(30) DEFAULT NULL,
  `edad_b` varchar(250) DEFAULT NULL,
  `procedimiento_b` varchar(250) DEFAULT NULL,
  `fecha_b` varchar(100) DEFAULT NULL,
  `via_aerea_b` varchar(250) DEFAULT NULL,
  `vad_b` varchar(250) DEFAULT NULL,
  `acceso_vascular_b` varchar(250) DEFAULT NULL,
  `invasivo_b` varchar(250) DEFAULT NULL,
  `invasivo_eco_b` tinyint(1) NOT NULL DEFAULT '0',
  `cvc_b` varchar(250) DEFAULT NULL,
  `neuroaxial_b` varchar(250) DEFAULT NULL,
  `regional_b` varchar(250) DEFAULT NULL,
  `dolor_b` varchar(250) DEFAULT NULL,
  `staff_b` varchar(250) DEFAULT NULL,
  `aprobado_staff_b` tinyint(1) NOT NULL DEFAULT '0',
  `comentarios_b` varchar(500) DEFAULT NULL,
  `feedback_b` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora_proced_backup_staff`
--

CREATE TABLE `bitacora_proced_backup_staff` (
  `id_b` int NOT NULL DEFAULT '0',
  `staff_b` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendarios_app`
--

CREATE TABLE `calendarios_app` (
  `id` int NOT NULL,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calendar_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('general','r1','r2','r3','staff','turnos','examenes','rotaciones','classroom','personal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#3b82f6',
  `notif_dias` int NOT NULL DEFAULT '0' COMMENT 'Días para primera notificación (2-7), 0 = desactivado',
  `notif_same_day` tinyint(1) NOT NULL DEFAULT '1',
  `notif_email` tinyint(1) NOT NULL DEFAULT '0',
  `notif_hora` time NOT NULL DEFAULT '08:00:00',
  `notif_weekdays` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario_asignaciones`
--

CREATE TABLE `calendario_asignaciones` (
  `id` int NOT NULL,
  `calendario_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `creado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_notas`
--

CREATE TABLE `categorias_notas` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int UNSIGNED NOT NULL DEFAULT '0',
  `es_emergencia` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eval_preanestesica`
--

CREATE TABLE `eval_preanestesica` (
  `ID_epa` int NOT NULL,
  `nombre_paciente` varchar(250) DEFAULT NULL,
  `rut` varchar(50) DEFAULT NULL,
  `ficha` varchar(50) DEFAULT NULL,
  `edad` varchar(10) DEFAULT NULL,
  `sexo` varchar(50) DEFAULT NULL,
  `antropometrico` varchar(250) DEFAULT NULL,
  `signos_vitales` varchar(250) DEFAULT NULL,
  `diagnostico` varchar(250) DEFAULT NULL,
  `intervencion` varchar(250) DEFAULT NULL,
  `fecha_int` varchar(150) DEFAULT NULL,
  `cirujano` varchar(250) DEFAULT NULL,
  `riesgo` varchar(100) DEFAULT NULL,
  `antec_cardio` varchar(250) DEFAULT NULL,
  `otro_cardio` varchar(250) DEFAULT NULL,
  `antec_respirat` varchar(250) DEFAULT NULL,
  `otro_respirat` varchar(250) DEFAULT NULL,
  `antec_neuro` varchar(250) DEFAULT NULL,
  `otro_neuro` varchar(250) DEFAULT NULL,
  `antec_hepatico` varchar(250) DEFAULT NULL,
  `otro_hepatico` varchar(250) DEFAULT NULL,
  `antec_renal` varchar(250) DEFAULT NULL,
  `otro_renal` varchar(250) DEFAULT NULL,
  `antec_gastro` varchar(250) DEFAULT NULL,
  `otro_gastro` varchar(250) DEFAULT NULL,
  `antec_hemato` varchar(250) DEFAULT NULL,
  `otro_hemato` varchar(250) DEFAULT NULL,
  `antec_endocrino` varchar(250) DEFAULT NULL,
  `otro_endocrino` varchar(250) DEFAULT NULL,
  `antec_musculo` varchar(250) DEFAULT NULL,
  `otro_musculo` varchar(250) DEFAULT NULL,
  `antec_mental` varchar(250) DEFAULT NULL,
  `otro_mental` varchar(250) DEFAULT NULL,
  `antec_gine` varchar(250) DEFAULT NULL,
  `otro_gine` varchar(250) DEFAULT NULL,
  `cirugias_prev` varchar(250) DEFAULT NULL,
  `antec_familiares` varchar(250) DEFAULT NULL,
  `nvpo_hm` varchar(250) DEFAULT NULL,
  `embarazo` varchar(250) DEFAULT NULL,
  `oh` varchar(250) DEFAULT NULL,
  `tabaco` varchar(250) DEFAULT NULL,
  `drogas` varchar(250) DEFAULT NULL,
  `anticoagulante` varchar(250) DEFAULT NULL,
  `indic1` varchar(250) DEFAULT NULL,
  `indic2` varchar(250) DEFAULT NULL,
  `indic3` varchar(250) DEFAULT NULL,
  `indic4` varchar(250) DEFAULT NULL,
  `indic5` varchar(250) DEFAULT NULL,
  `indic6` varchar(250) DEFAULT NULL,
  `alergias` varchar(250) DEFAULT NULL,
  `cardiaco` varchar(250) DEFAULT NULL,
  `pulmonar` varchar(250) DEFAULT NULL,
  `neurologico` varchar(250) DEFAULT NULL,
  `puncion` varchar(250) DEFAULT NULL,
  `ef_otro` varchar(250) DEFAULT NULL,
  `eva` varchar(250) DEFAULT NULL,
  `via_aerea` varchar(250) DEFAULT NULL,
  `examenes` varchar(250) DEFAULT NULL,
  `otros_exs` mediumtext,
  `ev_asa` varchar(250) DEFAULT NULL,
  `solicitudes` varchar(250) DEFAULT NULL,
  `solicitudes2` varchar(250) DEFAULT NULL,
  `otro_plan` varchar(250) DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `fecha_aut` varchar(250) DEFAULT NULL,
  `fecha_ed` varchar(250) DEFAULT NULL,
  `autor_epa` varchar(250) DEFAULT NULL,
  `editor_epa` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resumen` text COLLATE utf8mb4_unicode_ci,
  `contenido` mediumtext COLLATE utf8mb4_unicode_ci,
  `estado` enum('borrador','publicada','archivada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'borrador',
  `version` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_categorias`
--

CREATE TABLE `nota_categorias` (
  `nota_id` int UNSIGNED NOT NULL,
  `categoria_id` int UNSIGNED NOT NULL,
  `orden` int UNSIGNED NOT NULL DEFAULT '0',
  `titulo_en_categoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono_fa` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int UNSIGNED NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('info','warning','success','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `alcance` enum('individual','grupo','global') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'global',
  `grupo_destino` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_destino` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creada_por` int DEFAULT NULL,
  `publicada` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_inicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_fin` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones_calendario_eventos`
--

CREATE TABLE `notificaciones_calendario_eventos` (
  `id` int NOT NULL,
  `calendar_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_notif` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_evento` date DEFAULT NULL,
  `notificacion_id` int NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `email_enviado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_destinatarios`
--

CREATE TABLE `notificacion_destinatarios` (
  `id` int UNSIGNED NOT NULL,
  `notificacion_id` int UNSIGNED NOT NULL,
  `usuario_id` int NOT NULL,
  `leida` tinyint(1) NOT NULL DEFAULT '0',
  `leida_at` datetime DEFAULT NULL,
  `archivada` tinyint(1) NOT NULL DEFAULT '0',
  `archivada_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `nombre_paciente` varchar(100) DEFAULT NULL,
  `rut` varchar(30) NOT NULL,
  `ficha` int DEFAULT NULL,
  `edad` varchar(30) DEFAULT NULL,
  `unidad_cama` varchar(200) DEFAULT NULL,
  `procedimiento` varchar(100) DEFAULT NULL,
  `analgesia` varchar(100) DEFAULT NULL,
  `nivel` varchar(30) DEFAULT NULL,
  `espacio` varchar(30) DEFAULT NULL,
  `distancia` varchar(30) DEFAULT NULL,
  `solucion` varchar(30) DEFAULT NULL,
  `infusion` varchar(30) DEFAULT NULL,
  `bolo` varchar(30) DEFAULT NULL,
  `lockout` varchar(30) DEFAULT NULL,
  `peso` varchar(30) DEFAULT NULL,
  `comentarios` varchar(250) DEFAULT NULL,
  `de_alta` tinyint(1) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `creador` varchar(50) DEFAULT NULL,
  `fecha_edicion` datetime DEFAULT NULL,
  `editor` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_dolor`
--

CREATE TABLE `usuarios_dolor` (
  `ID` int NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `verified_email` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `becad_` tinyint(1) NOT NULL DEFAULT '0',
  `nivel_residencia` enum('r1','r2','r3') DEFAULT NULL COMMENT 'Nivel de residencia para becados',
  `becad_otro` tinyint(1) NOT NULL DEFAULT '0',
  `external_` int DEFAULT '0',
  `staff_` tinyint(1) NOT NULL DEFAULT '0',
  `docente_` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Docente de la beca (1=docente, 0=no docente)',
  `intern_` tinyint(1) NOT NULL DEFAULT '0',
  `link_minicex` varchar(500) DEFAULT NULL,
  `anio_residencia` tinyint DEFAULT NULL,
  `token_rec` varchar(50) DEFAULT NULL,
  `token_activ` tinyint(1) NOT NULL DEFAULT '0',
  `token_hr` varchar(100) DEFAULT NULL,
  `ui_modo` varchar(20) NOT NULL DEFAULT 'normal',
  `ui_nav_posicion` enum('left','right') NOT NULL DEFAULT 'left',
  `ui_icono` varchar(40) NOT NULL DEFAULT 'fa-user-doctor',
  `ui_icono_color` enum('blue','green','red','yellow','orange','purple','teal','pink','cyan','indigo','slate','black') NOT NULL DEFAULT 'blue'
) ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_notas`
--

CREATE TABLE `usuario_notas` (
  `id` int UNSIGNED NOT NULL,
  `usuario_id` int NOT NULL,
  `nota_id` int UNSIGNED NOT NULL,
  `es_favorita` tinyint(1) NOT NULL DEFAULT '0',
  `vista_at` datetime DEFAULT NULL,
  `ultima_visita_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita_diaria`
--

CREATE TABLE `visita_diaria` (
  `ID` int NOT NULL,
  `nombre_paciente_v` varchar(100) DEFAULT NULL,
  `rut_v` varchar(30) DEFAULT NULL,
  `fecha_v` datetime DEFAULT NULL,
  `eva_estatico` varchar(2) DEFAULT NULL,
  `eva_dinamico` varchar(2) DEFAULT NULL,
  `sedacion` varchar(100) DEFAULT NULL,
  `motor` varchar(100) DEFAULT NULL,
  `bolos` varchar(20) DEFAULT NULL,
  `pas` varchar(30) DEFAULT NULL,
  `pad` varchar(30) DEFAULT NULL,
  `fc` varchar(30) DEFAULT NULL,
  `sao2` varchar(30) DEFAULT NULL,
  `fio2` varchar(30) DEFAULT NULL,
  `fecha_exs` varchar(30) DEFAULT NULL,
  `inr` varchar(30) DEFAULT NULL,
  `ttpa` varchar(30) DEFAULT NULL,
  `plaq` varchar(30) DEFAULT NULL,
  `crea` varchar(30) DEFAULT NULL,
  `anticoagulante` varchar(100) DEFAULT NULL,
  `indic1` varchar(100) DEFAULT NULL,
  `indic2` varchar(100) DEFAULT NULL,
  `indic3` varchar(100) DEFAULT NULL,
  `indic4` varchar(100) DEFAULT NULL,
  `indic5` varchar(100) DEFAULT NULL,
  `indic6` varchar(100) DEFAULT NULL,
  `comentarios_v` varchar(250) DEFAULT NULL,
  `editor_v` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `app_auth_sessions`
--
ALTER TABLE `app_auth_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_hash` (`token_hash`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Indices de la tabla `bitacora_internos`
--
ALTER TABLE `bitacora_internos`
  ADD PRIMARY KEY (`id_i`),
  ADD KEY `FK_staff_i_email` (`staff_i`);

--
-- Indices de la tabla `bitacora_proced`
--
ALTER TABLE `bitacora_proced`
  ADD PRIMARY KEY (`id_b`),
  ADD KEY `FK_staff_b_email` (`staff_b`);

--
-- Indices de la tabla `calendarios_app`
--
ALTER TABLE `calendarios_app`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendario_asignaciones`
--
ALTER TABLE `calendario_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_fechas` (`usuario_id`,`fecha_inicio`,`fecha_fin`),
  ADD KEY `idx_calendario` (`calendario_id`);

--
-- Indices de la tabla `categorias_notas`
--
ALTER TABLE `categorias_notas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_categorias_orden` (`orden`);

--
-- Indices de la tabla `eval_preanestesica`
--
ALTER TABLE `eval_preanestesica`
  ADD PRIMARY KEY (`ID_epa`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `ruta` (`ruta`),
  ADD KEY `idx_notas_estado` (`estado`),
  ADD KEY `idx_notas_slug` (`slug`),
  ADD KEY `idx_notas_ruta` (`ruta`),
  ADD KEY `idx_notas_published_at` (`published_at`);

--
-- Indices de la tabla `nota_categorias`
--
ALTER TABLE `nota_categorias`
  ADD PRIMARY KEY (`nota_id`,`categoria_id`),
  ADD KEY `idx_categoria_orden` (`categoria_id`,`orden`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_publicada` (`publicada`),
  ADD KEY `idx_notif_fecha_inicio` (`fecha_inicio`),
  ADD KEY `idx_notif_fecha_fin` (`fecha_fin`),
  ADD KEY `idx_notif_tipo` (`tipo`),
  ADD KEY `idx_notif_alcance` (`alcance`),
  ADD KEY `idx_notif_grupo_destino` (`grupo_destino`),
  ADD KEY `idx_notif_creada_por` (`creada_por`);

--
-- Indices de la tabla `notificaciones_calendario_eventos`
--
ALTER TABLE `notificaciones_calendario_eventos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_event_notif` (`calendar_id`,`event_id`,`tipo_notif`);

--
-- Indices de la tabla `notificacion_destinatarios`
--
ALTER TABLE `notificacion_destinatarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_notificacion_usuario` (`notificacion_id`,`usuario_id`),
  ADD KEY `idx_usuario_leida` (`usuario_id`,`leida`),
  ADD KEY `idx_usuario_archivada` (`usuario_id`,`archivada`),
  ADD KEY `idx_notificacion_id` (`notificacion_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`rut`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `usuarios_dolor`
--
ALTER TABLE `usuarios_dolor`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `uq_email_usuario` (`email_usuario`);

--
-- Indices de la tabla `usuario_notas`
--
ALTER TABLE `usuario_notas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario_nota` (`usuario_id`,`nota_id`),
  ADD KEY `idx_usuario_favoritas` (`usuario_id`,`es_favorita`),
  ADD KEY `idx_usuario_vistas` (`usuario_id`,`vista_at`),
  ADD KEY `idx_nota_id` (`nota_id`);

--
-- Indices de la tabla `visita_diaria`
--
ALTER TABLE `visita_diaria`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_rut_v` (`rut_v`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `app_auth_sessions`
--
ALTER TABLE `app_auth_sessions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora_internos`
--
ALTER TABLE `bitacora_internos`
  MODIFY `id_i` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacora_proced`
--
ALTER TABLE `bitacora_proced`
  MODIFY `id_b` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendarios_app`
--
ALTER TABLE `calendarios_app`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendario_asignaciones`
--
ALTER TABLE `calendario_asignaciones`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_notas`
--
ALTER TABLE `categorias_notas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eval_preanestesica`
--
ALTER TABLE `eval_preanestesica`
  MODIFY `ID_epa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones_calendario_eventos`
--
ALTER TABLE `notificaciones_calendario_eventos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion_destinatarios`
--
ALTER TABLE `notificacion_destinatarios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_dolor`
--
ALTER TABLE `usuarios_dolor`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_notas`
--
ALTER TABLE `usuario_notas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `visita_diaria`
--
ALTER TABLE `visita_diaria`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora_internos`
--
ALTER TABLE `bitacora_internos`
  ADD CONSTRAINT `FK_staff_i_email` FOREIGN KEY (`staff_i`) REFERENCES `usuarios_dolor` (`email_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora_proced`
--
ALTER TABLE `bitacora_proced`
  ADD CONSTRAINT `FK_staff_b_email` FOREIGN KEY (`staff_b`) REFERENCES `usuarios_dolor` (`email_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `calendario_asignaciones`
--
ALTER TABLE `calendario_asignaciones`
  ADD CONSTRAINT `fk_cal_asig_calendario` FOREIGN KEY (`calendario_id`) REFERENCES `calendarios_app` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nota_categorias`
--
ALTER TABLE `nota_categorias`
  ADD CONSTRAINT `fk_nota_categorias_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_notas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nota_categorias_nota` FOREIGN KEY (`nota_id`) REFERENCES `notas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificacion_destinatarios`
--
ALTER TABLE `notificacion_destinatarios`
  ADD CONSTRAINT `fk_notif_dest_notificacion` FOREIGN KEY (`notificacion_id`) REFERENCES `notificaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_notas`
--
ALTER TABLE `usuario_notas`
  ADD CONSTRAINT `fk_usuario_notas_nota` FOREIGN KEY (`nota_id`) REFERENCES `notas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `visita_diaria`
--
ALTER TABLE `visita_diaria`
  ADD CONSTRAINT `FK_rut_v` FOREIGN KEY (`rut_v`) REFERENCES `pacientes` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
