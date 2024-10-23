-- Crear la tabla `usuarios`

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `documento` bigint(20) NOT NULL,
  `nick_name` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `estado` enum('activo','inhabilitado') DEFAULT 'activo',
  `foto_perfil` varchar(255) DEFAULT NULL,
  `rol` enum('aprendiz','administrador') DEFAULT 'aprendiz'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`),
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;




-- Crear la tabla `actividad`

CREATE TABLE `actividad` (
  `id_actividad` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `codigo_actividad` bigint(20) NOT NULL,
  `nivel` tinyint(4) NOT NULL,
  `preguntas_correctas` tinyint(4) NOT NULL,
  `preguntas_incorrectas` tinyint(4) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `avance_actividad` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_user` (`id_user`),
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;




-- Crear la tabla `ludica`

CREATE TABLE `ludica` (
  `id_ludica` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `especies_transladadasC` int(11) DEFAULT 0,
  `especies_transladadasI` int(11) DEFAULT 0,
  `puntaje` int(11) DEFAULT 0,
  `animales_muertos` int(11) DEFAULT 0,
  `basuraT1correctas` int(11) DEFAULT 0,
  `basuraT2correctas` int(11) DEFAULT 0,
  `basuraT3correctas` int(11) DEFAULT 0,
  `arbolesP` int(11) DEFAULT 0,
  `guardian_veces` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `ludica`
  ADD PRIMARY KEY (`id_ludica`),
  ADD KEY `id_user` (`id_user`),
  MODIFY `id_ludica` int(11) NOT NULL AUTO_INCREMENT;




-- Establecer las claves foráneas
ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE;

ALTER TABLE `ludica`
  ADD CONSTRAINT `ludica_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuarios` (`id_user`) ON DELETE CASCADE;
