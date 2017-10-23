/*
MySQL Data Transfer
Source Host: localhost
Source Database: sistemadecontrol
Target Host: localhost
Target Database: sistemadecontrol
Date: 25/10/2016 08:00:48 p.m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for ano_entrega
-- ----------------------------
DROP TABLE IF EXISTS `ano_entrega`;
CREATE TABLE `ano_entrega` (
  `Id_Ano` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Ano`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for atencion_equipos
-- ----------------------------
DROP TABLE IF EXISTS `atencion_equipos`;
CREATE TABLE `atencion_equipos` (
  `Id_Atencion` int(11) NOT NULL auto_increment,
  `NroSerie` varchar(30) NOT NULL,
  `Fecha_Entrada` date default NULL,
  `Id_Prioridad` int(11) NOT NULL,
  `Usuario` varchar(100) default NULL,
  `Dni` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Atencion`,`NroSerie`),
  KEY `RefTipo_Prioridad_Atencion54` (`Id_Prioridad`),
  KEY `RefEquipos55` (`NroSerie`),
  KEY `RefPersonas109` (`Dni`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for atencion_para_st
-- ----------------------------
DROP TABLE IF EXISTS `atencion_para_st`;
CREATE TABLE `atencion_para_st` (
  `Nro_Tiket` varchar(50) default NULL,
  `Fecha_Retiro` date default NULL,
  `Observacion` varchar(300) default NULL,
  `Id_Tipo_Retiro` int(11) NOT NULL,
  `Referencia_Tipo_Retiro` varchar(50) default NULL,
  `Fecha_Devolucion` date default NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  PRIMARY KEY  (`Id_Atencion`,`NroSerie`),
  KEY `RefTipo_Retiro_Atencion_ST65` (`Id_Tipo_Retiro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for audittrail
-- ----------------------------
DROP TABLE IF EXISTS `audittrail`;
CREATE TABLE `audittrail` (
  `id` int(11) NOT NULL auto_increment,
  `datetime` datetime NOT NULL,
  `script` varchar(255) default NULL,
  `user` varchar(255) default NULL,
  `action` varchar(255) default NULL,
  `table` varchar(255) default NULL,
  `field` varchar(255) default NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7517 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for autoridades_escolares
-- ----------------------------
DROP TABLE IF EXISTS `autoridades_escolares`;
CREATE TABLE `autoridades_escolares` (
  `Id_Autoridad` int(11) NOT NULL auto_increment,
  `Apellido_Nombre` varchar(200) default NULL,
  `Id_Cargo` int(11) NOT NULL,
  `Cuil` varchar(100) default NULL,
  `Telefono` int(11) default NULL,
  `Celular` int(11) default NULL,
  `Maill` varchar(100) default NULL,
  `Id_Turno` int(11) NOT NULL,
  `Cue` varchar(100) NOT NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Autoridad`),
  KEY `RefCargo_Autoridad84` (`Id_Cargo`),
  KEY `RefTurno85` (`Id_Turno`),
  KEY `RefDato_Establecimiento105` (`Cue`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cargo_autoridad
-- ----------------------------
DROP TABLE IF EXISTS `cargo_autoridad`;
CREATE TABLE `cargo_autoridad` (
  `Id_Cargo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Cargo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cargo_persona
-- ----------------------------
DROP TABLE IF EXISTS `cargo_persona`;
CREATE TABLE `cargo_persona` (
  `Id_Cargo` int(10) NOT NULL auto_increment,
  `Nombre` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Cargo`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for chat
-- ----------------------------
DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `Orden` int(11) NOT NULL auto_increment,
  `Usuario` varchar(160) default NULL,
  `Texto_Chat` varchar(500) default NULL,
  `Hora` time default NULL,
  `Estado` varchar(100) default NULL,
  `Nro_Conversacion` int(11) NOT NULL,
  PRIMARY KEY  (`Orden`),
  KEY `RefConversaciones138` (`Nro_Conversacion`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for conversaciones
-- ----------------------------
DROP TABLE IF EXISTS `conversaciones`;
CREATE TABLE `conversaciones` (
  `Nro_Conversacion` int(11) NOT NULL auto_increment,
  `Usuario_1` varchar(160) default NULL,
  `Usuario_2` varchar(200) default NULL,
  `Fecha_Hora` datetime default NULL,
  PRIMARY KEY  (`Nro_Conversacion`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for cursos
-- ----------------------------
DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `Id_Curso` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Curso`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for dato_establecimiento
-- ----------------------------
DROP TABLE IF EXISTS `dato_establecimiento`;
CREATE TABLE `dato_establecimiento` (
  `Cue` varchar(100) NOT NULL,
  `Nombre_Establecimiento` varchar(100) default NULL,
  `Domicilio` varchar(200) default NULL,
  `Mail_Escuela` varchar(200) default NULL,
  `Telefono_Escuela` int(11) default NULL,
  `Matricula_Actual` int(11) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Cantidad_Aulas` int(11) NOT NULL,
  `Comparte_Edificio` varchar(50) NOT NULL,
  PRIMARY KEY  (`Cue`),
  KEY `RefDepartamento117` (`Id_Departamento`),
  KEY `RefLocalidades118` (`Id_Localidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for datos_extras_escuela
-- ----------------------------
DROP TABLE IF EXISTS `datos_extras_escuela`;
CREATE TABLE `datos_extras_escuela` (
  `Id_Dato` int(11) NOT NULL auto_increment,
  `Cue` varchar(100) NOT NULL,
  `Usuario_Conig` varchar(200) default NULL,
  `Password_Conig` varchar(200) default NULL,
  `Tiene_Internet` varchar(100) default NULL,
  `Servicio_Internet` varchar(100) default NULL,
  `Estado_Internet` varchar(100) default NULL,
  `Quien_Paga` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Dato`),
  KEY `RefDato_Establecimiento137` (`Cue`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for denuncia_robo_equipo
-- ----------------------------
DROP TABLE IF EXISTS `denuncia_robo_equipo`;
CREATE TABLE `denuncia_robo_equipo` (
  `IdDenuncia` int(11) NOT NULL auto_increment,
  `NroSerie` varchar(30) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `Quien_Denuncia` varchar(40) default NULL,
  `DetalleDenuncia` varchar(400) default NULL,
  `Fecha_Denuncia` date default NULL,
  `Id_Estado_Den` int(11) NOT NULL,
  `Ruta_Archivo` varchar(500) default NULL,
  PRIMARY KEY  (`IdDenuncia`),
  KEY `RefEstado_Deuncia25` (`Id_Estado_Den`),
  KEY `RefPersonas26` (`Dni`),
  KEY `RefTutores27` (`Dni_Tutor`),
  KEY `RefEquipos28` (`NroSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for departamento
-- ----------------------------
DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `Id_Departamento` int(11) NOT NULL auto_increment,
  `Nombre` varchar(200) default NULL,
  `Id_Provincia` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Departamento`),
  KEY `RefProvincias112` (`Id_Provincia`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for detalle_atencion
-- ----------------------------
DROP TABLE IF EXISTS `detalle_atencion`;
CREATE TABLE `detalle_atencion` (
  `Id_Detalle_Atencion` int(11) NOT NULL auto_increment,
  `Id_Tipo_Falla` int(11) NOT NULL,
  `Id_Problema` int(11) NOT NULL,
  `Descripcion_Problema` varchar(500) default NULL,
  `Id_Tipo_Sol_Problem` int(11) NOT NULL,
  `Id_Estado_Atenc` int(11) NOT NULL,
  `Fecha_Actualizacion` varchar(60) default NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  PRIMARY KEY  (`Id_Detalle_Atencion`,`Id_Atencion`,`NroSerie`),
  KEY `RefTipo_Falla59` (`Id_Tipo_Falla`),
  KEY `RefProblema60` (`Id_Problema`),
  KEY `RefTipo_Solucion_Problema61` (`Id_Tipo_Sol_Problem`),
  KEY `RefEstado_Actual_Solucion_Problema62` (`Id_Estado_Atenc`),
  KEY `RefAtencion_Equipos63` (`Id_Atencion`,`NroSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for devolucion_equipo
-- ----------------------------
DROP TABLE IF EXISTS `devolucion_equipo`;
CREATE TABLE `devolucion_equipo` (
  `Admin_Que_Recibe` varchar(60) default NULL,
  `Fecha_Devolucion` varchar(100) default NULL,
  `Observacion` varchar(300) default NULL,
  `Devuelve_Cargador` varchar(20) default NULL,
  `Id_Estado_Devol` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Id_Autoridad` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `Id_Motivo` int(11) NOT NULL,
  PRIMARY KEY  (`NroSerie`),
  KEY `RefEstado_Equipo_Devuleto29` (`Id_Estado_Devol`),
  KEY `RefAutoridades_Escolares43` (`Id_Autoridad`),
  KEY `RefPersonas120` (`Dni`),
  KEY `RefTutores121` (`Dni_Tutor`),
  KEY `RefMotivo_Devolucion122` (`Id_Motivo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for division
-- ----------------------------
DROP TABLE IF EXISTS `division`;
CREATE TABLE `division` (
  `Id_Division` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Division`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for equipos
-- ----------------------------
DROP TABLE IF EXISTS `equipos`;
CREATE TABLE `equipos` (
  `NroSerie` varchar(30) NOT NULL,
  `NroMac` varchar(30) default NULL,
  `Id_Ubicacion` int(11) NOT NULL,
  `Id_Modelo` int(11) NOT NULL,
  `Id_Estado` int(11) NOT NULL,
  `Id_Sit_Estado` int(11) NOT NULL,
  `Id_Marca` int(11) NOT NULL,
  `Id_Ano` int(11) NOT NULL,
  `User_Actualiz` varchar(60) default NULL,
  `Ultima_Actualiz` varchar(30) default NULL,
  `SpecialNumber` varchar(30) default NULL,
  PRIMARY KEY  (`NroSerie`),
  KEY `RefUbicacion_Equipo74` (`Id_Ubicacion`),
  KEY `RefModelo75` (`Id_Modelo`),
  KEY `RefEstado_Equipo76` (`Id_Estado`),
  KEY `RefSituacion_Estado77` (`Id_Sit_Estado`),
  KEY `RefMarca78` (`Id_Marca`),
  KEY `RefAno_Entrega79` (`Id_Ano`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for establecimientos_educativos_pase
-- ----------------------------
DROP TABLE IF EXISTS `establecimientos_educativos_pase`;
CREATE TABLE `establecimientos_educativos_pase` (
  `Cue_Establecimiento` int(50) NOT NULL,
  `Nombre_Establecimiento` varchar(200) default NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Domicilio_Escuela` varchar(10) default NULL,
  `Nombre_Directivo` varchar(200) default NULL,
  `Cuil_Directivo` varchar(50) default NULL,
  `Nombre_Rte` varchar(200) default NULL,
  `Tel_Rte` varchar(100) default NULL,
  `Email_Rte` varchar(200) default NULL,
  `Nro_Serie_Server_Escolar` varchar(200) default NULL,
  `Contacto_Establecimiento` varchar(100) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  PRIMARY KEY  (`Cue_Establecimiento`),
  KEY `RefDepartamento115` (`Id_Departamento`),
  KEY `RefLocalidades44` (`Id_Localidad`),
  KEY `RefProvincias45` (`Id_Provincia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_actual_legajo_persona
-- ----------------------------
DROP TABLE IF EXISTS `estado_actual_legajo_persona`;
CREATE TABLE `estado_actual_legajo_persona` (
  `Dni` int(11) NOT NULL,
  `Matricula` varchar(100) default NULL,
  `Certificado_Pase` varchar(100) default NULL,
  `Tiene_DNI` varchar(100) default NULL,
  `Certificado_Medico` varchar(100) default NULL,
  `Posee_Autorizacion` varchar(100) default NULL,
  `Cooperadora` varchar(100) default NULL,
  PRIMARY KEY  (`Dni`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_actual_solucion_problema
-- ----------------------------
DROP TABLE IF EXISTS `estado_actual_solucion_problema`;
CREATE TABLE `estado_actual_solucion_problema` (
  `Id_Estado_Atenc` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Atenc`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_civil
-- ----------------------------
DROP TABLE IF EXISTS `estado_civil`;
CREATE TABLE `estado_civil` (
  `Id_Estado_Civil` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Estado_Civil`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_denuncia
-- ----------------------------
DROP TABLE IF EXISTS `estado_denuncia`;
CREATE TABLE `estado_denuncia` (
  `Id_Estado_Den` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Den`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_devolucion_prestamo
-- ----------------------------
DROP TABLE IF EXISTS `estado_devolucion_prestamo`;
CREATE TABLE `estado_devolucion_prestamo` (
  `Id_Estado_Devol` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Devol`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_equipo
-- ----------------------------
DROP TABLE IF EXISTS `estado_equipo`;
CREATE TABLE `estado_equipo` (
  `Id_Estado` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Estado`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_equipo_devuelto
-- ----------------------------
DROP TABLE IF EXISTS `estado_equipo_devuelto`;
CREATE TABLE `estado_equipo_devuelto` (
  `Id_Estado_Devol` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Devol`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_equipos_piso
-- ----------------------------
DROP TABLE IF EXISTS `estado_equipos_piso`;
CREATE TABLE `estado_equipos_piso` (
  `Id_Estado_Equipo_piso` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Equipo_piso`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_espera_prestamo
-- ----------------------------
DROP TABLE IF EXISTS `estado_espera_prestamo`;
CREATE TABLE `estado_espera_prestamo` (
  `Id_Estado_Espera` int(11) NOT NULL auto_increment,
  `Detalle` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Estado_Espera`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_paquete
-- ----------------------------
DROP TABLE IF EXISTS `estado_paquete`;
CREATE TABLE `estado_paquete` (
  `Id_Estado_Paquete` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Paquete`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_pase
-- ----------------------------
DROP TABLE IF EXISTS `estado_pase`;
CREATE TABLE `estado_pase` (
  `Id_Estado_Pase` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Pase`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_persona
-- ----------------------------
DROP TABLE IF EXISTS `estado_persona`;
CREATE TABLE `estado_persona` (
  `Id_Estado` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_prestamo_equipo
-- ----------------------------
DROP TABLE IF EXISTS `estado_prestamo_equipo`;
CREATE TABLE `estado_prestamo_equipo` (
  `Id_Estado_Prestamo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado_Prestamo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for estado_server
-- ----------------------------
DROP TABLE IF EXISTS `estado_server`;
CREATE TABLE `estado_server` (
  `Id_Estado` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Estado`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for historial_atencion
-- ----------------------------
DROP TABLE IF EXISTS `historial_atencion`;
CREATE TABLE `historial_atencion` (
  `Id_Historial` int(11) NOT NULL auto_increment,
  `Detalle` varchar(500) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(200) default NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  PRIMARY KEY  (`Id_Historial`),
  KEY `RefAtencion_Equipos136` (`Id_Atencion`,`NroSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for liberacion_equipo
-- ----------------------------
DROP TABLE IF EXISTS `liberacion_equipo`;
CREATE TABLE `liberacion_equipo` (
  `Fecha_Finalizacion` varchar(100) default NULL,
  `Observacion` varchar(300) default NULL,
  `Id_Modalidad` int(11) NOT NULL,
  `Id_Nivel` int(11) NOT NULL,
  `Id_Autoridad` int(11) NOT NULL,
  `Fecha_Liberacion` varchar(100) default NULL,
  `Ruta_Archivo_Copia_Titulo` varchar(200) default NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  PRIMARY KEY  (`Dni`),
  KEY `RefModalidad_Establecimiento39` (`Id_Modalidad`),
  KEY `RefNivel_educativo40` (`Id_Nivel`),
  KEY `RefAutoridades_Escolares41` (`Id_Autoridad`),
  KEY `RefTutores83` (`Dni_Tutor`),
  KEY `RefEquipos87` (`NroSerie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for lista_espera_prestamo
-- ----------------------------
DROP TABLE IF EXISTS `lista_espera_prestamo`;
CREATE TABLE `lista_espera_prestamo` (
  `Dni` int(11) NOT NULL,
  `Apellidos_Nombres` varchar(200) default NULL,
  `Id_Motivo_Prestamo` int(11) NOT NULL,
  `Observacion` varchar(400) default NULL,
  `Id_Curso` int(11) NOT NULL,
  `Id_Division` int(11) NOT NULL,
  `Id_Estado_Espera` int(11) NOT NULL default '1',
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  PRIMARY KEY  (`Dni`),
  KEY `RefMotivo_Prestamo_Equipo131` (`Id_Motivo_Prestamo`),
  KEY `RefCursos132` (`Id_Curso`),
  KEY `RefDivision133` (`Id_Division`),
  KEY `RefEstado_Espera_Prestamo134` (`Id_Estado_Espera`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for localidades
-- ----------------------------
DROP TABLE IF EXISTS `localidades`;
CREATE TABLE `localidades` (
  `Id_Localidad` int(11) NOT NULL auto_increment,
  `Nombre` varchar(200) default NULL,
  `Id_Departamento` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Localidad`),
  KEY `RefDepartamento113` (`Id_Departamento`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for marca
-- ----------------------------
DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `Id_Marca` int(11) NOT NULL auto_increment,
  `Nombre` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Marca`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for marca_server
-- ----------------------------
DROP TABLE IF EXISTS `marca_server`;
CREATE TABLE `marca_server` (
  `Id_Marca` int(11) NOT NULL auto_increment,
  `Nombre` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Marca`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for materias_adeudadas
-- ----------------------------
DROP TABLE IF EXISTS `materias_adeudadas`;
CREATE TABLE `materias_adeudadas` (
  `Id_Mat_Adeuda` int(11) NOT NULL auto_increment,
  `Dni` int(11) NOT NULL,
  `Id_Materia` int(11) NOT NULL,
  `Observacion` varchar(400) default NULL,
  `Fecha_Actualizacion` varchar(60) default NULL,
  `User_Actualiz` varchar(60) default NULL,
  PRIMARY KEY  (`Id_Mat_Adeuda`),
  KEY `RefPersonas11` (`Dni`),
  KEY `RefMaterias_Anuales14` (`Id_Materia`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for materias_anuales
-- ----------------------------
DROP TABLE IF EXISTS `materias_anuales`;
CREATE TABLE `materias_anuales` (
  `Id_Materia` int(11) NOT NULL auto_increment,
  `Nombre` varchar(300) default NULL,
  `Id_Curso` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Materia`),
  KEY `RefCursos12` (`Id_Curso`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modalidad_establecimiento
-- ----------------------------
DROP TABLE IF EXISTS `modalidad_establecimiento`;
CREATE TABLE `modalidad_establecimiento` (
  `Id_Modalidad` int(11) NOT NULL auto_increment,
  `Nombre` varchar(300) default NULL,
  PRIMARY KEY  (`Id_Modalidad`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelo
-- ----------------------------
DROP TABLE IF EXISTS `modelo`;
CREATE TABLE `modelo` (
  `Id_Modelo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  `Id_Marca` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Modelo`),
  KEY `RefMarca111` (`Id_Marca`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for modelo_server
-- ----------------------------
DROP TABLE IF EXISTS `modelo_server`;
CREATE TABLE `modelo_server` (
  `Id_Modelo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Modelo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for motivo_devolucion
-- ----------------------------
DROP TABLE IF EXISTS `motivo_devolucion`;
CREATE TABLE `motivo_devolucion` (
  `Id_Motivo` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Motivo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for motivo_pedido_paquetes
-- ----------------------------
DROP TABLE IF EXISTS `motivo_pedido_paquetes`;
CREATE TABLE `motivo_pedido_paquetes` (
  `Id_Motivo` int(11) NOT NULL auto_increment,
  `Detalle` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Motivo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for motivo_prestamo_equipo
-- ----------------------------
DROP TABLE IF EXISTS `motivo_prestamo_equipo`;
CREATE TABLE `motivo_prestamo_equipo` (
  `Id_Motivo_Prestamo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Motivo_Prestamo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for motivo_reasignacion
-- ----------------------------
DROP TABLE IF EXISTS `motivo_reasignacion`;
CREATE TABLE `motivo_reasignacion` (
  `Id_Motivo_Reasig` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Motivo_Reasig`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for nivel_educativo
-- ----------------------------
DROP TABLE IF EXISTS `nivel_educativo`;
CREATE TABLE `nivel_educativo` (
  `Id_Nivel` int(11) NOT NULL auto_increment,
  `Detalle` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Nivel`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for observacion_equipo
-- ----------------------------
DROP TABLE IF EXISTS `observacion_equipo`;
CREATE TABLE `observacion_equipo` (
  `Id_Observacion` int(11) NOT NULL auto_increment,
  `Detalle` varchar(500) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `NroSerie` varchar(30) NOT NULL,
  PRIMARY KEY  (`Id_Observacion`),
  KEY `RefEquipos32` (`NroSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for observacion_persona
-- ----------------------------
DROP TABLE IF EXISTS `observacion_persona`;
CREATE TABLE `observacion_persona` (
  `Id_Observacion` int(11) NOT NULL auto_increment,
  `Dni` int(11) NOT NULL,
  `Detalle` varchar(500) default NULL,
  `Fecha_Actualizacion` date default NULL,
  PRIMARY KEY  (`Id_Observacion`),
  KEY `RefPersonas16` (`Dni`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for observacion_tutor
-- ----------------------------
DROP TABLE IF EXISTS `observacion_tutor`;
CREATE TABLE `observacion_tutor` (
  `Id_Observacion` int(11) NOT NULL auto_increment,
  `Detalle` varchar(500) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `Dni_Tutor` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Observacion`),
  KEY `RefTutores33` (`Dni_Tutor`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ocupacion_tutor
-- ----------------------------
DROP TABLE IF EXISTS `ocupacion_tutor`;
CREATE TABLE `ocupacion_tutor` (
  `Id_Ocupacion` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Ocupacion`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for paises
-- ----------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `Id_Pais` int(11) NOT NULL auto_increment,
  `Nombre` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Pais`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for paquetes_provision
-- ----------------------------
DROP TABLE IF EXISTS `paquetes_provision`;
CREATE TABLE `paquetes_provision` (
  `NroPedido` int(10) NOT NULL auto_increment,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `SN` varchar(20) default NULL,
  `Id_Hardware` varchar(20) default NULL,
  `Marca_Arranque` varchar(18) default NULL,
  `Id_Tipo_Extraccion` int(11) NOT NULL,
  `Id_Estado_Paquete` int(11) NOT NULL,
  `Id_Motivo` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Email_Solicitante` varchar(200) default 'PENDIENTE',
  PRIMARY KEY  (`NroPedido`),
  KEY `RefTipo_Extraccion126` (`Id_Tipo_Extraccion`),
  KEY `RefEstado_Paquete127` (`Id_Estado_Paquete`),
  KEY `RefMotivo_Pedido_Paquetes128` (`Id_Motivo`),
  KEY `RefEquipos129` (`NroSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pase_establecimiento
-- ----------------------------
DROP TABLE IF EXISTS `pase_establecimiento`;
CREATE TABLE `pase_establecimiento` (
  `Id_Pase` int(11) NOT NULL auto_increment,
  `Serie_Equipo` varchar(50) default NULL,
  `Id_Hardware` varchar(50) default NULL,
  `SN` varchar(40) default NULL,
  `Modelo_Net` varchar(100) default NULL,
  `Nombre_Titular` varchar(200) default NULL,
  `Dni_Titular` int(11) default NULL,
  `Cuil_Titular` varchar(40) default NULL,
  `Nombre_Tutor` varchar(200) default NULL,
  `DniTutor` int(11) default NULL,
  `Domicilio` varchar(200) default NULL,
  `Tel_Tutor` varchar(50) default NULL,
  `CelTutor` varchar(50) default NULL,
  `Cue_Establecimiento_Alta` varchar(100) default NULL,
  `Escuela_Alta` varchar(200) default NULL,
  `Directivo_Alta` varchar(200) default NULL,
  `Cuil_Directivo_Alta` varchar(30) default NULL,
  `Dpto_Esc_alta` varchar(50) default NULL,
  `Localidad_Esc_Alta` varchar(50) default NULL,
  `Domicilio_Esc_Alta` varchar(200) default NULL,
  `Rte_Alta` varchar(200) default NULL,
  `Tel_Rte_Alta` varchar(100) default NULL,
  `Email_Rte_Alta` varchar(200) default NULL,
  `Serie_Server_Alta` varchar(100) default NULL,
  `Cue_Establecimiento_Baja` varchar(100) default NULL,
  `Escuela_Baja` varchar(200) default NULL,
  `Directivo_Baja` varchar(200) default NULL,
  `Cuil_Directivo_Baja` varchar(30) default NULL,
  `Dpto_Esc_Baja` varchar(50) default NULL,
  `Localidad_Esc_Baja` varchar(50) default NULL,
  `Domicilio_Esc_Baja` varchar(200) default NULL,
  `Rte_Baja` varchar(200) default NULL,
  `Tel_Rte_Baja` varchar(100) default NULL,
  `Email_Rte_Baja` varchar(200) default NULL,
  `Serie_Server_Baja` varchar(100) default NULL,
  `Fecha_Pase` date default NULL,
  `Id_Estado_Pase` int(11) NOT NULL,
  `Marca_Arranque` varchar(20) default NULL,
  `Ruta_Archivo` varchar(500) default NULL,
  PRIMARY KEY  (`Id_Pase`),
  KEY `RefEstado_Pase48` (`Id_Estado_Pase`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for personas
-- ----------------------------
DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `Dni` int(11) NOT NULL,
  `Apellidos_Nombres` varchar(400) default NULL,
  `Edad` varchar(5) default NULL,
  `Domicilio` varchar(40) default NULL,
  `Tel_Contacto` varchar(20) default NULL,
  `Fecha_Nac` varchar(18) default NULL,
  `Cuil` varchar(30) default NULL,
  `Lugar_Nacimiento` varchar(200) default NULL,
  `Fecha_Actualizacion` varchar(100) default NULL,
  `User_Actualiz` varchar(18) default NULL,
  `Cod_Postal` varchar(8) default NULL,
  `Repitente` varchar(60) default NULL,
  `Id_Sexo` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Id_Estado` int(11) NOT NULL,
  `Id_Curso` int(11) NOT NULL,
  `Id_Division` int(11) NOT NULL,
  `Id_Turno` int(11) NOT NULL,
  `Id_Estado_Civil` int(11) NOT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `NroSerie` varchar(30) default NULL,
  `Id_Cargo` int(11) NOT NULL,
  PRIMARY KEY  (`Dni`),
  KEY `RefSexo_Personas2` (`Id_Sexo`),
  KEY `RefProvincias5` (`Id_Provincia`),
  KEY `RefLocalidades6` (`Id_Localidad`),
  KEY `RefEstado_Persona7` (`Id_Estado`),
  KEY `RefCursos8` (`Id_Curso`),
  KEY `RefDivision9` (`Id_Division`),
  KEY `RefTurno10` (`Id_Turno`),
  KEY `RefEstado_Civil38` (`Id_Estado_Civil`),
  KEY `RefTutores80` (`Dni_Tutor`),
  KEY `RefEquipos81` (`NroSerie`),
  KEY `RefCargo_Persona92` (`Id_Cargo`),
  KEY `RefDepartamento116` (`Id_Departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for piso_tecnologico
-- ----------------------------
DROP TABLE IF EXISTS `piso_tecnologico`;
CREATE TABLE `piso_tecnologico` (
  `Id_Piso` int(11) NOT NULL auto_increment,
  `Switch` varchar(100) default NULL,
  `Estado_Switch` int(11) default NULL,
  `Cantidad_Ap` int(11) default NULL,
  `Estado_Ap` int(11) default NULL,
  `Cantidad_Ap_Func` int(11) default NULL,
  `Ups` varchar(100) default NULL,
  `Estado_Ups` int(11) default NULL,
  `Cableado` varchar(100) default NULL,
  `Estado_Cableado` int(11) default NULL,
  `Porcent_Estado_Cab` int(11) default NULL,
  `Plano_Escuela` varchar(200) default NULL,
  `Ultima_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `Cue` varchar(100) NOT NULL,
  `Porcent_Func_Piso` int(12) default NULL,
  `Marca_Modelo_Serie_Ups` varchar(300) default NULL,
  `Cantidad_Swich` int(12) default NULL,
  PRIMARY KEY  (`Id_Piso`),
  KEY `RefDato_Establecimiento104` (`Cue`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for prestamo_equipo
-- ----------------------------
DROP TABLE IF EXISTS `prestamo_equipo`;
CREATE TABLE `prestamo_equipo` (
  `Id_Prestamo` int(11) NOT NULL auto_increment,
  `Dni` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Fecha_Prestamo` date default NULL,
  `Observacion` varchar(400) default NULL,
  `Prestamo_Cargador` varchar(18) default NULL,
  `Id_Estado_Prestamo` int(11) NOT NULL,
  `Id_Motivo_Prestamo` int(11) NOT NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `Devuelve_Cargador` varchar(20) default NULL,
  `Id_Estado_Devol` int(11) NOT NULL default '3',
  `Apellidos_Nombres_Beneficiario` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Prestamo`),
  KEY `RefEstado_Prestamo_Equipo49` (`Id_Estado_Prestamo`),
  KEY `RefMotivo_Prestamo_Equipo50` (`Id_Motivo_Prestamo`),
  KEY `RefEquipos108` (`NroSerie`),
  KEY `RefEstado_Devolucion_Prestamo123` (`Id_Estado_Devol`),
  KEY `RefLista_Espera_Prestamo135` (`Dni`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for problema
-- ----------------------------
DROP TABLE IF EXISTS `problema`;
CREATE TABLE `problema` (
  `Id_Problema` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Problema`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for provincias
-- ----------------------------
DROP TABLE IF EXISTS `provincias`;
CREATE TABLE `provincias` (
  `Id_Provincia` int(11) NOT NULL auto_increment,
  `Nombre` varchar(200) default NULL,
  `Id_Pais` int(11) NOT NULL,
  PRIMARY KEY  (`Id_Provincia`),
  KEY `RefPaises114` (`Id_Pais`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for reasignacion_equipo
-- ----------------------------
DROP TABLE IF EXISTS `reasignacion_equipo`;
CREATE TABLE `reasignacion_equipo` (
  `Id_Reasignacion` int(10) NOT NULL auto_increment,
  `NroSerie` varchar(30) NOT NULL,
  `Titular_Original` varchar(200) default NULL,
  `Observacion` varchar(300) default NULL,
  `Fecha_Reasignacion` date default NULL,
  `Dni` int(11) NOT NULL,
  `Id_Motivo_Reasig` int(11) NOT NULL,
  `Nuevo_Titular` varchar(200) default NULL,
  `Dni_Nuevo_Tit` int(11) default NULL,
  PRIMARY KEY  (`Id_Reasignacion`),
  KEY `RefMotivo_Reasignacion51` (`Id_Motivo_Reasig`),
  KEY `RefEquipos53` (`NroSerie`),
  KEY `RefPersonas102` (`Dni`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for referente_tecnico
-- ----------------------------
DROP TABLE IF EXISTS `referente_tecnico`;
CREATE TABLE `referente_tecnico` (
  `DniRte` int(11) NOT NULL,
  `Apelldio_Nombre` varchar(100) default NULL,
  `Id_Turno` int(11) NOT NULL,
  `Domicilio` varchar(200) default NULL,
  `Telefono` int(11) default NULL,
  `Celular` int(11) default NULL,
  `Mail` varchar(200) default NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `Cue` varchar(100) NOT NULL,
  `Fecha_Ingreso` date default NULL,
  `Titulo` varchar(200) default NULL,
  PRIMARY KEY  (`DniRte`),
  KEY `RefTurno_Rte88` (`Id_Turno`),
  KEY `RefDato_Establecimiento103` (`Cue`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for servidor_escolar
-- ----------------------------
DROP TABLE IF EXISTS `servidor_escolar`;
CREATE TABLE `servidor_escolar` (
  `Nro_Serie` varchar(100) NOT NULL,
  `SN` varchar(200) default NULL,
  `Cant_Net_Asoc` int(11) default NULL,
  `Id_Marca` int(11) NOT NULL,
  `Id_SO` int(11) NOT NULL,
  `Id_Estado` int(11) NOT NULL,
  `Id_Modelo` int(11) NOT NULL,
  `Cue` varchar(100) NOT NULL,
  `Fecha_Actualizacion` date default NULL,
  `Usuario` varchar(100) default NULL,
  `Pass_Server` varchar(200) default NULL,
  `Pass_TdServer` varchar(200) default NULL,
  `User_Server` varchar(100) default NULL,
  `User_TdServer` varchar(100) default NULL,
  PRIMARY KEY  (`Nro_Serie`),
  KEY `RefMarca_Server94` (`Id_Marca`),
  KEY `RefSO_Server95` (`Id_SO`),
  KEY `RefEstado_Server96` (`Id_Estado`),
  KEY `RefModelo_Server97` (`Id_Modelo`),
  KEY `RefDato_Establecimiento106` (`Cue`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for sexo_personas
-- ----------------------------
DROP TABLE IF EXISTS `sexo_personas`;
CREATE TABLE `sexo_personas` (
  `Id_Sexo` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Sexo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for situacion_estado
-- ----------------------------
DROP TABLE IF EXISTS `situacion_estado`;
CREATE TABLE `situacion_estado` (
  `Id_Sit_Estado` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Sit_Estado`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for so_server
-- ----------------------------
DROP TABLE IF EXISTS `so_server`;
CREATE TABLE `so_server` (
  `Id_SO` int(11) NOT NULL auto_increment,
  `Nombre` varchar(100) default NULL,
  PRIMARY KEY  (`Id_SO`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_extraccion
-- ----------------------------
DROP TABLE IF EXISTS `tipo_extraccion`;
CREATE TABLE `tipo_extraccion` (
  `Id_Tipo_Extraccion` int(11) NOT NULL auto_increment,
  `Detalle` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Tipo_Extraccion`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_falla
-- ----------------------------
DROP TABLE IF EXISTS `tipo_falla`;
CREATE TABLE `tipo_falla` (
  `Id_Tipo_Falla` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Tipo_Falla`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_prioridad_atencion
-- ----------------------------
DROP TABLE IF EXISTS `tipo_prioridad_atencion`;
CREATE TABLE `tipo_prioridad_atencion` (
  `Id_Prioridad` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Prioridad`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_relacion_alumno_tutor
-- ----------------------------
DROP TABLE IF EXISTS `tipo_relacion_alumno_tutor`;
CREATE TABLE `tipo_relacion_alumno_tutor` (
  `Id_Relacion` int(11) NOT NULL auto_increment,
  `Desripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Relacion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_retiro_atencion_st
-- ----------------------------
DROP TABLE IF EXISTS `tipo_retiro_atencion_st`;
CREATE TABLE `tipo_retiro_atencion_st` (
  `Id_Tipo_Retiro` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Tipo_Retiro`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tipo_solucion_problema
-- ----------------------------
DROP TABLE IF EXISTS `tipo_solucion_problema`;
CREATE TABLE `tipo_solucion_problema` (
  `Id_Tipo_Sol_Problem` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Tipo_Sol_Problem`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for turno
-- ----------------------------
DROP TABLE IF EXISTS `turno`;
CREATE TABLE `turno` (
  `Id_Turno` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Turno`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for turno_rte
-- ----------------------------
DROP TABLE IF EXISTS `turno_rte`;
CREATE TABLE `turno_rte` (
  `Id_Turno` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`Id_Turno`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for tutores
-- ----------------------------
DROP TABLE IF EXISTS `tutores`;
CREATE TABLE `tutores` (
  `Dni_Tutor` int(11) NOT NULL default '0',
  `Apellidos_Nombres` varchar(400) default NULL,
  `Edad` varchar(5) default NULL,
  `Domicilio` varchar(40) default NULL,
  `Tel_Contacto` varchar(20) default NULL,
  `Fecha_Nac` date default NULL,
  `Cuil` varchar(25) default NULL,
  `Lugar_Nacimiento` varchar(100) default NULL,
  `MasHijos` varchar(60) default NULL,
  `Fecha_Actualizacion` varchar(60) default NULL,
  `User_Actualiz` varchar(60) default NULL,
  `Id_Estado_Civil` int(11) NOT NULL,
  `Id_Sexo` int(11) NOT NULL,
  `Id_Relacion` int(11) NOT NULL,
  `Id_Ocupacion` int(11) NOT NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL,
  PRIMARY KEY  (`Dni_Tutor`),
  KEY `RefEstado_Civil36` (`Id_Estado_Civil`),
  KEY `RefSexo_Personas67` (`Id_Sexo`),
  KEY `RefTipo_Relacion_Alumno_Tutor68` (`Id_Relacion`),
  KEY `RefOcupacion_Tutor69` (`Id_Ocupacion`),
  KEY `RefProvincias71` (`Id_Provincia`),
  KEY `RefLocalidades73` (`Id_Localidad`),
  KEY `RefDepartamento119` (`Id_Departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for ubicacion_equipo
-- ----------------------------
DROP TABLE IF EXISTS `ubicacion_equipo`;
CREATE TABLE `ubicacion_equipo` (
  `Id_Ubicacion` int(11) NOT NULL auto_increment,
  `Descripcion` varchar(200) default NULL,
  PRIMARY KEY  (`Id_Ubicacion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for userlevelpermissions
-- ----------------------------
DROP TABLE IF EXISTS `userlevelpermissions`;
CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL,
  PRIMARY KEY  (`userlevelid`,`tablename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for userlevels
-- ----------------------------
DROP TABLE IF EXISTS `userlevels`;
CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL,
  PRIMARY KEY  (`userlevelid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `Nombre` varchar(100) NOT NULL,
  `Password` varchar(100) default NULL,
  `Nivel_Usuario` int(11) default NULL,
  `NombreTitular` varchar(200) default NULL,
  `Dni` int(20) default NULL,
  `Curso` int(11) default NULL,
  `Turno` int(11) default NULL,
  `Division` int(11) default NULL,
  PRIMARY KEY  (`Nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- View structure for alumnos_porcurso
-- ----------------------------
DROP VIEW IF EXISTS `alumnos_porcurso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alumnos_porcurso` AS select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`cursos`.`Descripcion` AS `curso`,`division`.`Descripcion` AS `division`,`turno`.`Descripcion` AS `turno` from (((`personas` join `cursos` on((`personas`.`Id_Curso` = `cursos`.`Id_Curso`))) join `division` on((`personas`.`Id_Division` = `division`.`Id_Division`))) join `turno` on((`personas`.`Id_Turno` = `turno`.`Id_Turno`)));

-- ----------------------------
-- View structure for datosdirectivos
-- ----------------------------
DROP VIEW IF EXISTS `datosdirectivos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosdirectivos` AS select `autoridades_escolares`.`Cue` AS `Cue`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Nombre_Establecimiento`,`departamento`.`Nombre` AS `Nombre`,`localidades`.`Nombre` AS `Nombre1`,`autoridades_escolares`.`Apellido_Nombre` AS `Apellido_Nombre`,`autoridades_escolares`.`Cuil` AS `Cuil`,`autoridades_escolares`.`Telefono` AS `Telefono`,`autoridades_escolares`.`Celular` AS `Celular`,`autoridades_escolares`.`Maill` AS `Maill`,`autoridades_escolares`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`cargo_autoridad`.`Descripcion` AS `Descripcion`,`turno`.`Descripcion` AS `Descripcion1` from (((((`autoridades_escolares` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `autoridades_escolares`.`Cue`))) join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`))) join `cargo_autoridad` on((`autoridades_escolares`.`Id_Cargo` = `cargo_autoridad`.`Id_Cargo`))) join `turno` on((`autoridades_escolares`.`Id_Turno` = `turno`.`Id_Turno`)));

-- ----------------------------
-- View structure for datosestablecimiento
-- ----------------------------
DROP VIEW IF EXISTS `datosestablecimiento`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosestablecimiento` AS select `dato_establecimiento`.`Cue` AS `CUE`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Establecimiento`,`departamento`.`Nombre` AS `Departamento`,`localidades`.`Nombre` AS `Localidad`,`dato_establecimiento`.`Domicilio` AS `Domicilio`,`dato_establecimiento`.`Telefono_Escuela` AS `Telefono`,`dato_establecimiento`.`Mail_Escuela` AS `Mail`,`dato_establecimiento`.`Matricula_Actual` AS `Nro Matricula`,`dato_establecimiento`.`Cantidad_Aulas` AS `Cantidad Aulas`,`dato_establecimiento`.`Comparte_Edificio` AS `Comparte Edificio`,`dato_establecimiento`.`Fecha_Actualizacion` AS `Ultima Actualizacion` from ((`dato_establecimiento` join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`)));

-- ----------------------------
-- View structure for datosextrasescuela
-- ----------------------------
DROP VIEW IF EXISTS `datosextrasescuela`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosextrasescuela` AS select `datos_extras_escuela`.`Cue` AS `Cue`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Nombre_Establecimiento`,`departamento`.`Nombre` AS `Departamento`,`localidades`.`Nombre` AS `Localidad`,`datos_extras_escuela`.`Usuario_Conig` AS `Usuario_Conig`,`datos_extras_escuela`.`Password_Conig` AS `Password_Conig`,`datos_extras_escuela`.`Tiene_Internet` AS `Tiene_Internet`,`datos_extras_escuela`.`Servicio_Internet` AS `Servicio_Internet`,`datos_extras_escuela`.`Estado_Internet` AS `Estado_Internet`,`datos_extras_escuela`.`Quien_Paga` AS `Quien_Paga` from (((`datos_extras_escuela` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `datos_extras_escuela`.`Cue`))) join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`)));

-- ----------------------------
-- View structure for datosrte
-- ----------------------------
DROP VIEW IF EXISTS `datosrte`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosrte` AS select `referente_tecnico`.`Cue` AS `CUE`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Establecimiento`,`departamento`.`Nombre` AS `Departamento`,`localidades`.`Nombre` AS `Localidad`,`referente_tecnico`.`Apelldio_Nombre` AS `Apelldio y Nombre`,`referente_tecnico`.`DniRte` AS `Dni`,`referente_tecnico`.`Domicilio` AS `Domicilio`,`referente_tecnico`.`Telefono` AS `Telefono`,`referente_tecnico`.`Celular` AS `Celular`,`referente_tecnico`.`Mail` AS `Email`,`turno_rte`.`Descripcion` AS `Turno`,`referente_tecnico`.`Fecha_Ingreso` AS `Fecha_Ingreso`,`referente_tecnico`.`Titulo` AS `Titulo`,`referente_tecnico`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from ((((`referente_tecnico` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `referente_tecnico`.`Cue`))) join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`))) join `turno_rte` on((`referente_tecnico`.`Id_Turno` = `turno_rte`.`Id_Turno`)));

-- ----------------------------
-- View structure for datosservidor
-- ----------------------------
DROP VIEW IF EXISTS `datosservidor`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosservidor` AS select `servidor_escolar`.`Cue` AS `Cue`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Nombre_Establecimiento`,`departamento`.`Nombre` AS `Departamento`,`localidades`.`Nombre` AS `Localidad`,`servidor_escolar`.`Nro_Serie` AS `Nro_Serie`,`servidor_escolar`.`SN` AS `SN`,`servidor_escolar`.`Cant_Net_Asoc` AS `Cant_Net_Asoc`,`marca_server`.`Nombre` AS `Marca`,`so_server`.`Nombre` AS `S.O`,`estado_server`.`Descripcion` AS `Estado`,`modelo_server`.`Descripcion` AS `Modelo`,`servidor_escolar`.`User_Server` AS `User_Server`,`servidor_escolar`.`Pass_Server` AS `Pass_Server`,`servidor_escolar`.`User_TdServer` AS `User_TdServer`,`servidor_escolar`.`Pass_TdServer` AS `Pass_TdServer`,`servidor_escolar`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from (((((((`servidor_escolar` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `servidor_escolar`.`Cue`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`))) join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `marca_server` on((`servidor_escolar`.`Id_Marca` = `marca_server`.`Id_Marca`))) join `so_server` on((`servidor_escolar`.`Id_SO` = `so_server`.`Id_SO`))) join `estado_server` on((`servidor_escolar`.`Id_Estado` = `estado_server`.`Id_Estado`))) join `modelo_server` on((`servidor_escolar`.`Id_Modelo` = `modelo_server`.`Id_Modelo`)));

-- ----------------------------
-- View structure for estado_documentacion_personas
-- ----------------------------
DROP VIEW IF EXISTS `estado_documentacion_personas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_documentacion_personas` AS select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`cursos`.`Descripcion` AS `curso`,`division`.`Descripcion` AS `division`,`turno`.`Descripcion` AS `turno`,`estado_actual_legajo_persona`.`Matricula` AS `Matricula`,`estado_actual_legajo_persona`.`Certificado_Pase` AS `Certificado_Pase`,`estado_actual_legajo_persona`.`Tiene_DNI` AS `Tiene_DNI`,`estado_actual_legajo_persona`.`Certificado_Medico` AS `Certificado_Medico`,`estado_actual_legajo_persona`.`Posee_Autorizacion` AS `Posee_Autorizacion`,`estado_actual_legajo_persona`.`Cooperadora` AS `Cooperadora` from ((((`personas` join `estado_actual_legajo_persona` on((`personas`.`Dni` = `estado_actual_legajo_persona`.`Dni`))) join `cursos` on((`personas`.`Id_Curso` = `cursos`.`Id_Curso`))) join `division` on((`personas`.`Id_Division` = `division`.`Id_Division`))) join `turno` on((`personas`.`Id_Turno` = `turno`.`Id_Turno`)));

-- ----------------------------
-- View structure for estado_equipos_porcurso
-- ----------------------------
DROP VIEW IF EXISTS `estado_equipos_porcurso`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_equipos_porcurso` AS select `personas`.`Apellidos_Nombres` AS `Nombre Titular`,`personas`.`Dni` AS `Dni`,`cursos`.`Descripcion` AS `curso`,`division`.`Descripcion` AS `division`,`turno`.`Descripcion` AS `turno`,`equipos`.`NroSerie` AS `Equipo`,`situacion_estado`.`Descripcion` AS `Estado`,`equipos`.`Ultima_Actualiz` AS `ultima actualiz.` from (((((`personas` join `equipos` on((`personas`.`NroSerie` = `equipos`.`NroSerie`))) join `cursos` on((`personas`.`Id_Curso` = `cursos`.`Id_Curso`))) join `division` on((`personas`.`Id_Division` = `division`.`Id_Division`))) join `turno` on((`personas`.`Id_Turno` = `turno`.`Id_Turno`))) join `situacion_estado` on((`equipos`.`Id_Sit_Estado` = `situacion_estado`.`Id_Sit_Estado`)));

-- ----------------------------
-- View structure for estado_titulares_cursos
-- ----------------------------
DROP VIEW IF EXISTS `estado_titulares_cursos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_titulares_cursos` AS select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`cursos`.`Descripcion` AS `curso`,`division`.`Descripcion` AS `division`,`turno`.`Descripcion` AS `turno`,`cargo_persona`.`Nombre` AS `cargo`,`estado_persona`.`Descripcion` AS `estado` from (((((`personas` join `cursos` on((`personas`.`Id_Curso` = `cursos`.`Id_Curso`))) join `division` on((`personas`.`Id_Division` = `division`.`Id_Division`))) join `turno` on((`personas`.`Id_Turno` = `turno`.`Id_Turno`))) join `cargo_persona` on((`personas`.`Id_Cargo` = `cargo_persona`.`Id_Cargo`))) join `estado_persona` on((`personas`.`Id_Estado` = `estado_persona`.`Id_Estado`)));

-- ----------------------------
-- View structure for historial_atenciones
-- ----------------------------
DROP VIEW IF EXISTS `historial_atenciones`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `historial_atenciones` AS select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`historial_atencion`.`Id_Atencion` AS `Id_Atencion`,`historial_atencion`.`Detalle` AS `Detalle`,`historial_atencion`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`historial_atencion`.`Usuario` AS `Usuario` from (`personas` join `historial_atencion` on((`personas`.`NroSerie` = `historial_atencion`.`NroSerie`)));

-- ----------------------------
-- View structure for pedido_paquetes
-- ----------------------------
DROP VIEW IF EXISTS `pedido_paquetes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedido_paquetes` AS select `dato_establecimiento`.`Cue` AS `Cue`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Establecimiento`,`departamento`.`Nombre` AS `Departamento`,`localidades`.`Nombre` AS `Localidad`,`motivo_pedido_paquetes`.`Detalle` AS `Motivo Pedido`,`servidor_escolar`.`Nro_Serie` AS `N° de Serie`,`paquetes_provision`.`SN` AS `SPECIAL NUMBER o NUMERO ESPECIAL`,`paquetes_provision`.`Id_Hardware` AS `ID HARDWARE`,`tipo_extraccion`.`Detalle` AS `EXTRACCIÓN DE DATOS`,`paquetes_provision`.`Marca_Arranque` AS `MARCA DE ARRANQUE`,`paquetes_provision`.`Email_Solicitante` AS `CORREO ELECTRONICO/EMAIL`,`personas`.`Apellidos_Nombres` AS `TITULAR`,`paquetes_provision`.`NroSerie` AS `SERIE NETBOOK`,`paquetes_provision`.`Id_Estado_Paquete` AS `Id_Estado_Paquete` from ((((`paquetes_provision` join `motivo_pedido_paquetes` on((`paquetes_provision`.`Id_Motivo` = `motivo_pedido_paquetes`.`Id_Motivo`))) join `tipo_extraccion` on((`paquetes_provision`.`Id_Tipo_Extraccion` = `tipo_extraccion`.`Id_Tipo_Extraccion`))) join `personas` on((`paquetes_provision`.`NroSerie` = `personas`.`NroSerie`))) join (((`dato_establecimiento` join `servidor_escolar` on((`dato_establecimiento`.`Cue` = `servidor_escolar`.`Cue`))) join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`)))) where (`paquetes_provision`.`Id_Estado_Paquete` = 1);

-- ----------------------------
-- View structure for pedido_st
-- ----------------------------
DROP VIEW IF EXISTS `pedido_st`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedido_st` AS select `dato_establecimiento`.`Cue` AS `CUE`,`dato_establecimiento`.`Nombre_Establecimiento` AS `ESCUELA`,`departamento`.`Nombre` AS `DEPARTAMENTO`,`localidades`.`Nombre` AS `LOCALIDAD`,`atencion_para_st`.`NroSerie` AS `SERIE NETBOOK`,`atencion_para_st`.`Nro_Tiket` AS `N° TIKET`,`problema`.`Descripcion` AS `PROBLEMA`,`atencion_para_st`.`Id_Tipo_Retiro` AS `Id_Tipo_Retiro` from (((`dato_establecimiento` join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`))) join ((`atencion_para_st` join `detalle_atencion` on(((`atencion_para_st`.`Id_Atencion` = `detalle_atencion`.`Id_Atencion`) and (`atencion_para_st`.`NroSerie` = `detalle_atencion`.`NroSerie`)))) join `problema` on((`detalle_atencion`.`Id_Problema` = `problema`.`Id_Problema`)))) where (`atencion_para_st`.`Id_Tipo_Retiro` = 1);

-- ----------------------------
-- View structure for titulares-equipos-tutores
-- ----------------------------
DROP VIEW IF EXISTS `titulares-equipos-tutores`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titulares-equipos-tutores` AS select `personas`.`Apellidos_Nombres` AS `Apelldio y Nombre Titular`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`personas`.`NroSerie` AS `Equipo Asignado`,`tutores`.`Apellidos_Nombres` AS `Apellido y Nombre Tutor`,`tutores`.`Dni_Tutor` AS `Dni Tutor`,`tutores`.`Cuil` AS `Cuil Tutor` from (`personas` join `tutores` on((`personas`.`Dni_Tutor` = `tutores`.`Dni_Tutor`)));

-- ----------------------------
-- View structure for titularidad-equipos
-- ----------------------------
DROP VIEW IF EXISTS `titularidad-equipos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titularidad-equipos` AS select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`personas`.`NroSerie` AS `NroSerie` from `personas`;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `ano_entrega` VALUES ('1', '2010');
INSERT INTO `ano_entrega` VALUES ('2', '2011');
INSERT INTO `ano_entrega` VALUES ('3', '2012');
INSERT INTO `ano_entrega` VALUES ('4', '2013');
INSERT INTO `ano_entrega` VALUES ('5', '2014');
INSERT INTO `ano_entrega` VALUES ('6', '2015');
INSERT INTO `ano_entrega` VALUES ('7', '2016');
INSERT INTO `ano_entrega` VALUES ('8', '2017');

INSERT INTO `cargo_autoridad` VALUES ('1', 'Director/a');
INSERT INTO `cargo_autoridad` VALUES ('2', 'Vice Director/a');
INSERT INTO `cargo_autoridad` VALUES ('3', 'Secretario');
INSERT INTO `cargo_persona` VALUES ('1', 'ALUMNO');
INSERT INTO `cargo_persona` VALUES ('2', 'DOCENTE');
INSERT INTO `cargo_persona` VALUES ('3', 'DIRECTIVO');
INSERT INTO `cargo_persona` VALUES ('4', 'PRECEPTOR');
INSERT INTO `cargo_persona` VALUES ('5', 'ADMINISTRATIVO/A');

INSERT INTO `cursos` VALUES ('1', '1');
INSERT INTO `cursos` VALUES ('2', '2');
INSERT INTO `cursos` VALUES ('3', '3');
INSERT INTO `cursos` VALUES ('4', '4');
INSERT INTO `cursos` VALUES ('5', '5');
INSERT INTO `cursos` VALUES ('6', '6');
INSERT INTO `cursos` VALUES ('13', 'EGRESOS');
INSERT INTO `cursos` VALUES ('12', 'ABANDONOS');
INSERT INTO `cursos` VALUES ('14', 'PASES');
INSERT INTO `cursos` VALUES ('15', 'PERSONAL ');

INSERT INTO `departamento` VALUES ('1', '25 de Mayo', '1');
INSERT INTO `departamento` VALUES ('2', 'Apóstoles', '1');
INSERT INTO `departamento` VALUES ('3', 'Cainguás', '1');
INSERT INTO `departamento` VALUES ('4', 'Candelaria', '1');
INSERT INTO `departamento` VALUES ('5', 'Capital', '1');
INSERT INTO `departamento` VALUES ('6', 'Concepción', '1');
INSERT INTO `departamento` VALUES ('7', 'Eldorado', '1');
INSERT INTO `departamento` VALUES ('8', 'Gral. Manuel Belgrano', '1');
INSERT INTO `departamento` VALUES ('9', 'Guaraní', '1');
INSERT INTO `departamento` VALUES ('10', 'Iguazú', '1');
INSERT INTO `departamento` VALUES ('11', 'Leandro N. Alem', '1');
INSERT INTO `departamento` VALUES ('12', 'Libertador General San Martín', '1');
INSERT INTO `departamento` VALUES ('13', 'Montecarlo', '1');
INSERT INTO `departamento` VALUES ('14', 'Oberá', '1');
INSERT INTO `departamento` VALUES ('15', 'San Ignacio', '1');
INSERT INTO `departamento` VALUES ('16', 'San Javier', '1');
INSERT INTO `departamento` VALUES ('17', 'San Pedro', '1');

INSERT INTO `division` VALUES ('1', 'A');
INSERT INTO `division` VALUES ('2', 'B');
INSERT INTO `division` VALUES ('3', 'C');
INSERT INTO `division` VALUES ('4', 'D');
INSERT INTO `division` VALUES ('5', 'E');
INSERT INTO `division` VALUES ('6', 'F');
INSERT INTO `division` VALUES ('7', 'G');
INSERT INTO `division` VALUES ('8', 'H');
INSERT INTO `division` VALUES ('9', 'I');
INSERT INTO `division` VALUES ('10', 'J');


INSERT INTO `estado_actual_solucion_problema` VALUES ('1', 'ESPERANDO RETIRO P/SERVICIO TECNICO');
INSERT INTO `estado_actual_solucion_problema` VALUES ('2', 'EN SERVICIO TECNICO EXTERNO');
INSERT INTO `estado_actual_solucion_problema` VALUES ('3', 'SOLUCIONADO, ESPERANDO RETIRO DEL TITULAR');
INSERT INTO `estado_actual_solucion_problema` VALUES ('4', 'EN ESPERA DE SOLUCION');
INSERT INTO `estado_actual_solucion_problema` VALUES ('5', 'ESPERANDO PAQUETE DE PROVISION');
INSERT INTO `estado_actual_solucion_problema` VALUES ('6', 'ESPERANDO CARGADOR/BATERIA');
INSERT INTO `estado_actual_solucion_problema` VALUES ('7', 'RETIRADA POR EL TITULAR');
INSERT INTO `estado_actual_solucion_problema` VALUES ('8', 'OTRO');
INSERT INTO `estado_civil` VALUES ('1', 'SOLTERO');
INSERT INTO `estado_civil` VALUES ('2', 'CASADO');
INSERT INTO `estado_civil` VALUES ('3', 'DIVORSIADO');
INSERT INTO `estado_civil` VALUES ('4', 'OTRO');
INSERT INTO `estado_denuncia` VALUES ('1', 'PRESENTADA');
INSERT INTO `estado_denuncia` VALUES ('2', 'ACEPTADA');
INSERT INTO `estado_denuncia` VALUES ('3', 'RECHAZADA');
INSERT INTO `estado_devolucion_prestamo` VALUES ('1', 'FUNCIONANDO');
INSERT INTO `estado_devolucion_prestamo` VALUES ('2', 'DAÑADO');
INSERT INTO `estado_devolucion_prestamo` VALUES ('3', 'PENDIENTE');
INSERT INTO `estado_equipo` VALUES ('1', 'ACTIVO');
INSERT INTO `estado_equipo` VALUES ('2', 'INACTIVO');
INSERT INTO `estado_equipo_devuelto` VALUES ('1', 'FUNCIONANDO');
INSERT INTO `estado_equipo_devuelto` VALUES ('2', 'DAÑADO');
INSERT INTO `estado_equipo_devuelto` VALUES ('3', 'OTRO');
INSERT INTO `estado_equipos_piso` VALUES ('1', 'FUNCIONANDO');
INSERT INTO `estado_equipos_piso` VALUES ('2', 'NO FUNCIONA');
INSERT INTO `estado_equipos_piso` VALUES ('3', 'EN REPARACION');
INSERT INTO `estado_equipos_piso` VALUES ('4', 'OTRO');
INSERT INTO `estado_espera_prestamo` VALUES ('1', 'SOLICITADO');
INSERT INTO `estado_espera_prestamo` VALUES ('2', 'APROBADO');
INSERT INTO `estado_espera_prestamo` VALUES ('3', 'RECHAZADO');
INSERT INTO `estado_espera_prestamo` VALUES ('4', 'PENDIENTE');
INSERT INTO `estado_espera_prestamo` VALUES ('5', 'OTRO');
INSERT INTO `estado_paquete` VALUES ('6', 'SOLICITADO');
INSERT INTO `estado_paquete` VALUES ('2', 'RECIBIDO');
INSERT INTO `estado_paquete` VALUES ('3', 'PENDIENTE');
INSERT INTO `estado_paquete` VALUES ('4', 'FUNCIONO');
INSERT INTO `estado_paquete` VALUES ('5', 'NO FUNCIONO');
INSERT INTO `estado_paquete` VALUES ('1', 'NUEVO');
INSERT INTO `estado_pase` VALUES ('1', 'PENDIENTE');
INSERT INTO `estado_pase` VALUES ('2', 'EN CURSO');
INSERT INTO `estado_pase` VALUES ('3', 'FINALIZADO');
INSERT INTO `estado_persona` VALUES ('1', 'REGULAR');
INSERT INTO `estado_persona` VALUES ('2', 'ABANDONO CON EQUIPO');
INSERT INTO `estado_persona` VALUES ('3', 'ABANDONO SIN EQUIPO');
INSERT INTO `estado_persona` VALUES ('4', 'EGRESO CON EQUIPO');
INSERT INTO `estado_persona` VALUES ('5', 'EGRESO SIN EQUIPO');
INSERT INTO `estado_persona` VALUES ('6', 'ACTIVO/A');
INSERT INTO `estado_persona` VALUES ('7', 'LICENCIA');
INSERT INTO `estado_persona` VALUES ('8', 'OTRO');
INSERT INTO `estado_persona` VALUES ('9', 'PASE CON EQUIPO');
INSERT INTO `estado_persona` VALUES ('10', 'PASE SIN EQUIPO');
INSERT INTO `estado_prestamo_equipo` VALUES ('1', 'EN CURSO');
INSERT INTO `estado_prestamo_equipo` VALUES ('2', 'FINALIZADO');
INSERT INTO `estado_server` VALUES ('1', 'FUNCIONA');
INSERT INTO `estado_server` VALUES ('2', 'NO FUNCIONA');
INSERT INTO `estado_server` VALUES ('3', 'EN REPARACION');
INSERT INTO `estado_server` VALUES ('4', 'ESPERANDO REPARACION');

INSERT INTO `localidades` VALUES ('1', 'Alba Posse', '1');
INSERT INTO `localidades` VALUES ('2', 'Colonia Aurora', '1');
INSERT INTO `localidades` VALUES ('3', '25 de Mayo', '1');
INSERT INTO `localidades` VALUES ('4', 'Apóstoles', '2');
INSERT INTO `localidades` VALUES ('5', 'Azara', '2');
INSERT INTO `localidades` VALUES ('6', 'San José', '2');
INSERT INTO `localidades` VALUES ('7', 'Tres Capones', '2');
INSERT INTO `localidades` VALUES ('8', 'Campo Grande', '3');
INSERT INTO `localidades` VALUES ('9', 'Aristóbulo del Valle', '3');
INSERT INTO `localidades` VALUES ('10', 'Dos de Mayo', '3');
INSERT INTO `localidades` VALUES ('11', 'Santa Ana', '4');
INSERT INTO `localidades` VALUES ('12', 'Bonpland', '4');
INSERT INTO `localidades` VALUES ('13', 'Candelaria', '4');
INSERT INTO `localidades` VALUES ('14', 'Cerro Corá', '4');
INSERT INTO `localidades` VALUES ('15', 'Loreto', '4');
INSERT INTO `localidades` VALUES ('16', 'Mártires', '4');
INSERT INTO `localidades` VALUES ('17', 'Profundidad', '4');
INSERT INTO `localidades` VALUES ('18', 'Fachinal', '4');
INSERT INTO `localidades` VALUES ('19', 'Posadas', '5');
INSERT INTO `localidades` VALUES ('20', 'Garupá', '5');
INSERT INTO `localidades` VALUES ('21', 'Concepción de La Sierra', '6');
INSERT INTO `localidades` VALUES ('22', 'Santa María', '6');
INSERT INTO `localidades` VALUES ('23', 'Eldorado', '7');
INSERT INTO `localidades` VALUES ('24', '9 de Julio', '7');
INSERT INTO `localidades` VALUES ('25', 'Colonia Delicia', '7');
INSERT INTO `localidades` VALUES ('26', 'Colonia Victoria', '7');
INSERT INTO `localidades` VALUES ('27', 'Santiago de Liniers', '7');
INSERT INTO `localidades` VALUES ('28', 'Bernardo de Irigoyen', '8');
INSERT INTO `localidades` VALUES ('29', 'Comandante Andrés Guacurari', '8');
INSERT INTO `localidades` VALUES ('30', 'San Antonio', '8');
INSERT INTO `localidades` VALUES ('31', 'El Soberbio', '9');
INSERT INTO `localidades` VALUES ('32', 'San Vicente', '9');
INSERT INTO `localidades` VALUES ('33', 'Puerto Esperanza', '10');
INSERT INTO `localidades` VALUES ('34', 'Colonia Wanda', '10');
INSERT INTO `localidades` VALUES ('35', 'Puerto Iguazú', '10');
INSERT INTO `localidades` VALUES ('36', 'Puerto Libertad', '10');
INSERT INTO `localidades` VALUES ('37', 'Leandro N. Alem', '11');
INSERT INTO `localidades` VALUES ('38', 'Almafuerte', '11');
INSERT INTO `localidades` VALUES ('39', 'Arroyo del Medio', '11');
INSERT INTO `localidades` VALUES ('40', 'Caá Yari', '11');
INSERT INTO `localidades` VALUES ('41', 'Cerro Azul', '11');
INSERT INTO `localidades` VALUES ('42', 'Dos Arroyos', '11');
INSERT INTO `localidades` VALUES ('43', 'Gobernador López', '11');
INSERT INTO `localidades` VALUES ('44', 'Olegario Víctor Andrade', '11');
INSERT INTO `localidades` VALUES ('45', 'Puerto Rico', '12');
INSERT INTO `localidades` VALUES ('46', 'Capioví', '12');
INSERT INTO `localidades` VALUES ('47', 'El Alcázar', '12');
INSERT INTO `localidades` VALUES ('48', 'Garuhapé', '12');
INSERT INTO `localidades` VALUES ('49', 'Puerto Leoni', '12');
INSERT INTO `localidades` VALUES ('50', 'Ruiz de Montoya', '12');
INSERT INTO `localidades` VALUES ('51', 'Montecarlo', '13');
INSERT INTO `localidades` VALUES ('52', 'Caraguatay', '13');
INSERT INTO `localidades` VALUES ('53', 'Puerto Piray', '13');
INSERT INTO `localidades` VALUES ('54', 'Oberá', '14');
INSERT INTO `localidades` VALUES ('55', 'Campo Ramón', '14');
INSERT INTO `localidades` VALUES ('56', 'Campo Viera', '14');
INSERT INTO `localidades` VALUES ('57', 'Colonia Alberdi', '14');
INSERT INTO `localidades` VALUES ('58', 'General Alvear', '14');
INSERT INTO `localidades` VALUES ('59', 'Guaraní', '14');
INSERT INTO `localidades` VALUES ('60', 'Los Helechos', '14');
INSERT INTO `localidades` VALUES ('61', 'Panambí', '14');
INSERT INTO `localidades` VALUES ('62', 'San Martín', '14');
INSERT INTO `localidades` VALUES ('63', 'San Ignacio', '15');
INSERT INTO `localidades` VALUES ('64', 'Colonia Polana', '15');
INSERT INTO `localidades` VALUES ('65', 'Corpus', '15');
INSERT INTO `localidades` VALUES ('66', 'General Urquiza', '15');
INSERT INTO `localidades` VALUES ('67', 'Gobernador Roca', '15');
INSERT INTO `localidades` VALUES ('68', 'Hipólito Yrigoyen', '15');
INSERT INTO `localidades` VALUES ('69', 'Jardín América', '15');
INSERT INTO `localidades` VALUES ('70', 'Santo Pipó', '15');
INSERT INTO `localidades` VALUES ('71', 'San Javier', '16');
INSERT INTO `localidades` VALUES ('72', 'Florentino Ameghino', '16');
INSERT INTO `localidades` VALUES ('73', 'Itacaruaré', '16');
INSERT INTO `localidades` VALUES ('74', 'Mojón Grande', '16');
INSERT INTO `localidades` VALUES ('75', 'San Pedro', '17');
INSERT INTO `localidades` VALUES ('76', 'Cruce Caballero', '17');
INSERT INTO `localidades` VALUES ('77', 'Piñalito Sur', '17');
INSERT INTO `localidades` VALUES ('78', 'Paraiso', '17');
INSERT INTO `localidades` VALUES ('79', 'Tobuna', '17');
INSERT INTO `marca` VALUES ('1', 'NOVATECH');
INSERT INTO `marca` VALUES ('2', 'BANGHO');
INSERT INTO `marca` VALUES ('3', 'POSITIVO BGH');
INSERT INTO `marca` VALUES ('4', 'NOBLEX');
INSERT INTO `marca` VALUES ('5', 'EXO');
INSERT INTO `marca_server` VALUES ('1', 'EXO');
INSERT INTO `marca_server` VALUES ('2', 'OTRO');

INSERT INTO `materias_anuales` VALUES ('1', 'MATEMATICA I', '1');
INSERT INTO `materias_anuales` VALUES ('2', 'MATEMATICA II', '2');
INSERT INTO `materias_anuales` VALUES ('3', 'LENGUA III', '3');
INSERT INTO `materias_anuales` VALUES ('4', 'HISTORIA IV', '4');
INSERT INTO `materias_anuales` VALUES ('5', 'LENGUA I', '5');
INSERT INTO `modalidad_establecimiento` VALUES ('1', 'ECONOMIA Y GESTION');
INSERT INTO `modalidad_establecimiento` VALUES ('2', 'HUMANIDADES Y CS. SOC.');
INSERT INTO `modelo` VALUES ('1', 'NZS1001', '1');
INSERT INTO `modelo` VALUES ('2', 'SCHOOLMATE', '3');
INSERT INTO `modelo` VALUES ('3', 'X352', '5');
INSERT INTO `modelo` VALUES ('4', 'X355', '5');
INSERT INTO `modelo_server` VALUES ('1', 'RAQUEABLE');
INSERT INTO `modelo_server` VALUES ('2', 'NET SERVER');
INSERT INTO `modelo_server` VALUES ('3', 'OTRO');
INSERT INTO `motivo_devolucion` VALUES ('1', 'ABANDÓNO');
INSERT INTO `motivo_devolucion` VALUES ('9', 'OTRO');
INSERT INTO `motivo_devolucion` VALUES ('5', 'PASE A ESCUELA QUE NO CORRESPONDA');
INSERT INTO `motivo_devolucion` VALUES ('6', 'FINALIZO FUERA DE TERMINO');
INSERT INTO `motivo_devolucion` VALUES ('7', 'PERDIDA DE REGULARIDAD');
INSERT INTO `motivo_pedido_paquetes` VALUES ('1', 'VOLVIO DE ST CON OTRO S/N');
INSERT INTO `motivo_pedido_paquetes` VALUES ('2', 'PASE DE ESCUELA');
INSERT INTO `motivo_pedido_paquetes` VALUES ('3', 'NO TOMA CODIGO DE DESBLOQUEO');
INSERT INTO `motivo_pedido_paquetes` VALUES ('4', 'OTRO');
INSERT INTO `motivo_prestamo_equipo` VALUES ('1', 'EQUIPO EN/PARA SERVICIO TECNICO');
INSERT INTO `motivo_prestamo_equipo` VALUES ('2', 'SIN EQUIPO POR ROBO/PERDIDA');
INSERT INTO `motivo_prestamo_equipo` VALUES ('3', 'EQUIPO EN ESPERA EN EL LABORATORIO');
INSERT INTO `motivo_prestamo_equipo` VALUES ('4', 'SIN EQUIPO POR PASE PENDIENTE');
INSERT INTO `motivo_prestamo_equipo` VALUES ('5', 'OTRO');
INSERT INTO `motivo_reasignacion` VALUES ('1', 'SIN EQUIPO POR PASE DESDE UN PRIVADO');
INSERT INTO `motivo_reasignacion` VALUES ('2', 'PASE DESDE OTRA PROVINCIA');
INSERT INTO `motivo_reasignacion` VALUES ('3', 'NUNCA RECIBIO');
INSERT INTO `motivo_reasignacion` VALUES ('4', 'EQUIPO ORIGINAL CON FALLAS');
INSERT INTO `motivo_reasignacion` VALUES ('5', 'EQUIPO EN REPARACIÓN EXCEDIDO DE TIEMPO');
INSERT INTO `motivo_reasignacion` VALUES ('6', 'OTRO');
INSERT INTO `nivel_educativo` VALUES ('1', 'BASICO');
INSERT INTO `nivel_educativo` VALUES ('2', 'MEDIO');
INSERT INTO `nivel_educativo` VALUES ('3', 'SUPERIOR');

INSERT INTO `ocupacion_tutor` VALUES ('1', 'DOCENTE');
INSERT INTO `ocupacion_tutor` VALUES ('2', 'ALBAÑIL');
INSERT INTO `ocupacion_tutor` VALUES ('3', 'CHOFER');
INSERT INTO `ocupacion_tutor` VALUES ('4', 'ADMINISTRATIVO');
INSERT INTO `ocupacion_tutor` VALUES ('5', 'EMPLEADO/EMPLEADA');
INSERT INTO `ocupacion_tutor` VALUES ('6', 'OTRA');
INSERT INTO `paises` VALUES ('1', 'ARGENTINA');
INSERT INTO `paises` VALUES ('2', 'PARAGUAY');

INSERT INTO `problema` VALUES ('1', 'BATERIA');
INSERT INTO `problema` VALUES ('2', 'BLOQUEADA');
INSERT INTO `problema` VALUES ('3', 'BOTON ENCENDIDO');
INSERT INTO `problema` VALUES ('4', 'CARGADOR');
INSERT INTO `problema` VALUES ('5', 'CONFIGURACIONES INCORRECTAS');
INSERT INTO `problema` VALUES ('6', 'CONTRASEÑA WINDOWS');
INSERT INTO `problema` VALUES ('7', 'CONTRASEÑA BIOS');
INSERT INTO `problema` VALUES ('8', 'DISCO');
INSERT INTO `problema` VALUES ('9', 'FLEX DE DISCO');
INSERT INTO `problema` VALUES ('10', 'FLEX PANTALLA');
INSERT INTO `problema` VALUES ('11', 'GRUB');
INSERT INTO `problema` VALUES ('12', 'IMAGEN S.O');
INSERT INTO `problema` VALUES ('13', 'LINUX');
INSERT INTO `problema` VALUES ('14', 'NO TOMA DESBLOQUEO/CERTIF');
INSERT INTO `problema` VALUES ('15', 'NO ENCIENDE');
INSERT INTO `problema` VALUES ('16', 'NO INICIA');
INSERT INTO `problema` VALUES ('17', 'OTRO');
INSERT INTO `problema` VALUES ('18', 'FALLA APLICACIONES');
INSERT INTO `problema` VALUES ('19', 'OFFICE');
INSERT INTO `problema` VALUES ('20', 'PANTALLA ');
INSERT INTO `problema` VALUES ('21', 'PARLANTE');
INSERT INTO `problema` VALUES ('22', 'PIN DE CARGA');
INSERT INTO `problema` VALUES ('23', 'PLACA MADRE');
INSERT INTO `problema` VALUES ('24', 'PLACA WIFI');
INSERT INTO `problema` VALUES ('25', 'TECLADO ');
INSERT INTO `problema` VALUES ('26', 'TOUCHPAD');
INSERT INTO `problema` VALUES ('27', 'TV DIGITAL');
INSERT INTO `problema` VALUES ('28', 'VIRUS');
INSERT INTO `problema` VALUES ('29', 'WINDOWS');
INSERT INTO `provincias` VALUES ('1', 'MISIONES', '1');
INSERT INTO `provincias` VALUES ('2', 'CORRIENTES', '1');
INSERT INTO `provincias` VALUES ('3', 'ASUNCION', '2');

INSERT INTO `sexo_personas` VALUES ('1', 'MASCULINO');
INSERT INTO `sexo_personas` VALUES ('2', 'FEMENINO');
INSERT INTO `sexo_personas` VALUES ('3', 'OTRO');
INSERT INTO `situacion_estado` VALUES ('1', 'FUNCIONANDO');
INSERT INTO `situacion_estado` VALUES ('2', 'EN/PARA SERVICIO TECNICO');
INSERT INTO `situacion_estado` VALUES ('3', 'REMANENTE FUNCIONANDO');
INSERT INTO `situacion_estado` VALUES ('4', 'REMANENTE DAÑADO');
INSERT INTO `situacion_estado` VALUES ('14', 'OTRO');
INSERT INTO `situacion_estado` VALUES ('7', 'ROBADO/PERDIDO');
INSERT INTO `situacion_estado` VALUES ('8', 'TRANSFERENCIA PENDIENTE');
INSERT INTO `situacion_estado` VALUES ('9', 'TRANSFERENCIA COMPLETA');
INSERT INTO `situacion_estado` VALUES ('10', 'LIBERACIÓN PENDIENTE');
INSERT INTO `situacion_estado` VALUES ('11', 'LIBERACIÓN COMPLETA');
INSERT INTO `situacion_estado` VALUES ('12', 'EN REPARACIÓN');
INSERT INTO `situacion_estado` VALUES ('13', 'PRESTAMO ESCOLAR');
INSERT INTO `so_server` VALUES ('1', 'DEBIAN');
INSERT INTO `so_server` VALUES ('2', 'UBUNTU');
INSERT INTO `so_server` VALUES ('3', 'HUAYRA');
INSERT INTO `so_server` VALUES ('4', 'OTRO');
INSERT INTO `tipo_extraccion` VALUES ('1', 'NETBOOK');
INSERT INTO `tipo_extraccion` VALUES ('2', 'TPMDATA');
INSERT INTO `tipo_extraccion` VALUES ('3', 'OTRO');
INSERT INTO `tipo_falla` VALUES ('1', 'HARDWARE');
INSERT INTO `tipo_falla` VALUES ('2', 'SOFTWARE');
INSERT INTO `tipo_falla` VALUES ('3', 'OTRA');
INSERT INTO `tipo_prioridad_atencion` VALUES ('1', 'NORMAL');
INSERT INTO `tipo_prioridad_atencion` VALUES ('2', 'ALTA');
INSERT INTO `tipo_prioridad_atencion` VALUES ('3', 'MAXIMA');
INSERT INTO `tipo_relacion_alumno_tutor` VALUES ('1', 'PADRE');
INSERT INTO `tipo_relacion_alumno_tutor` VALUES ('2', 'MADRE');
INSERT INTO `tipo_relacion_alumno_tutor` VALUES ('3', 'TUTOR');
INSERT INTO `tipo_relacion_alumno_tutor` VALUES ('4', 'OTRO');
INSERT INTO `tipo_retiro_atencion_st` VALUES ('3', 'OPERATIVO ST');
INSERT INTO `tipo_retiro_atencion_st` VALUES ('2', 'CORREO');
INSERT INTO `tipo_retiro_atencion_st` VALUES ('1', 'PENDIENTE');
INSERT INTO `tipo_solucion_problema` VALUES ('1', 'DESBLOQUEAR');
INSERT INTO `tipo_solucion_problema` VALUES ('2', 'REINSTALAR');
INSERT INTO `tipo_solucion_problema` VALUES ('3', 'ACTIVAR');
INSERT INTO `tipo_solucion_problema` VALUES ('4', 'SOLICITUD DE CARGADOR/BATERIA');
INSERT INTO `tipo_solucion_problema` VALUES ('5', 'FORMATEAR');
INSERT INTO `tipo_solucion_problema` VALUES ('6', 'RESTAURAR');
INSERT INTO `tipo_solucion_problema` VALUES ('7', 'SERVICIO TECNICO');
INSERT INTO `tipo_solucion_problema` VALUES ('8', 'SINCRONIZAR LLAVE');
INSERT INTO `tipo_solucion_problema` VALUES ('9', 'SOLICITAR CARGADOR/BATERIA');
INSERT INTO `tipo_solucion_problema` VALUES ('10', 'SOLICITAR PAQUETE PROVISION');
INSERT INTO `tipo_solucion_problema` VALUES ('11', 'QUITAR CONTRASEÑA');
INSERT INTO `tipo_solucion_problema` VALUES ('12', 'OTRA');
INSERT INTO `turno` VALUES ('1', 'MAÑANA');
INSERT INTO `turno` VALUES ('2', 'TARDE');
INSERT INTO `turno` VALUES ('3', 'NOCHE');
INSERT INTO `turno_rte` VALUES ('1', 'MAÑANA');
INSERT INTO `turno_rte` VALUES ('2', 'TARDE');
INSERT INTO `turno_rte` VALUES ('3', 'NOCHE');
INSERT INTO `turno_rte` VALUES ('4', 'DOBLE TURNO');
INSERT INTO `ubicacion_equipo` VALUES ('1', 'DENTRO DE LA ESCUELA');
INSERT INTO `ubicacion_equipo` VALUES ('2', 'FUERA DE LA ESCUELA');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '109');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '40');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}view1', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Report1', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', '111');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', '111');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '105');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', '111');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '104');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '104');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '104');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_porcurso', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '104');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '104');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '104');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', '111');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '0');
INSERT INTO `userlevelpermissions` VALUES ('-2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosrte', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '0');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datospiso', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '109');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', '111');
INSERT INTO `userlevelpermissions` VALUES ('0', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('1', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('2', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '109');
INSERT INTO `userlevelpermissions` VALUES ('3', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '0');
INSERT INTO `userlevelpermissions` VALUES ('4', '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', '111');
INSERT INTO `userlevels` VALUES ('-2', 'Anonymous');
INSERT INTO `userlevels` VALUES ('-1', 'Administrator');
INSERT INTO `userlevels` VALUES ('0', 'Default');
INSERT INTO `userlevels` VALUES ('1', 'Anonymous');
INSERT INTO `userlevels` VALUES ('2', 'Alumnos');
INSERT INTO `userlevels` VALUES ('3', 'Preceptores');
INSERT INTO `userlevels` VALUES ('4', 'Rte');
INSERT INTO `usuarios` VALUES ('admin', 'Sistema.123', '-1', 'administrador', null, null, null, null);
