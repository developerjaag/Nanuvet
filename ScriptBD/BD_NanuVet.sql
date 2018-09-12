CREATE database `BD_NanuVet` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

use BD_NanuVet;


/*Almacena los paises*/
create table if not exists tb_paises(

     idPais         int auto_increment,
     nombre         varchar(100) not null,
     abreviatura    varchar(2),
     urlBandera     varchar(300),
     estado         enum('A','I'),
     
     primary key(idPais)

);
/*---*/

/*tabla para las ciudades*/
create table if not exists tb_ciudades(

     idCiudad       int auto_increment,
     nombre         varchar(100) not null,
     idPais         int,
     estado         enum('A','I'),
     
     primary key (idCiudad),
     
     foreign key (idPais) references tb_paises (idPais)
);
/*---*/


/*Tabla para los barrios*/
create table if not exists tb_barrios(

     idBarrio       int auto_increment,
     nombre         varchar(100) not null,
     idCiudad       int,
     estado         enum('A','I'),
     
     primary key (idBarrio),
     
     foreign key (idCiudad) references tb_ciudades (idCiudad)

);
/*---*/


/*Tabla para la clinica o nombre del establecimiento*/

create table if not exists tb_clinica(

     idClinica              int auto_increment,
     identificativoNit      varchar(50) not null,
     nombre                 varchar(100) not null,
     telefono1              varchar(20) not null,
     telefono2              varchar(20),
     celular                varchar(20) not null,
     direccion              varchar(50) not null,
     email                  varchar(100) not null,
     urlLogo                varchar(300),
     
     primary key (idClinica)

);

/*---*/


/*Tabla para las sucursales*/
create table if not exists tb_sucursales(

     idSucursal                 int auto_increment,
     identificativoNit          varchar(50) not null,
     nombre                     varchar(100) not null,
     telefono1                  varchar(20) not null,
     telefono2                  varchar(20),
     celular                    varchar(20) not null,
     direccion                  varchar(50) not null,
     longitud					varchar(100),
	 latitud					varchar(100),
     email                      varchar(100),
     urlLogo                    varchar(300),
     leyendaencabezado          varchar(300),
     estado                     enum('A','I'),
     idPais                     int,
     idCiudad                   int,
     idBarrio                   int,
     idClinica                  int,
     
     primary key (idSucursal),
     
     foreign key (idPais)       references tb_paises (idPais),
     foreign key (idCiudad)     references tb_ciudades (idCiudad),
     foreign key (idBarrio)     references tb_barrios (idBarrio),
     foreign key (idClinica)    references tb_clinica (idClinica)

);
/*---*/


/*Para almacenar las configuraciones por defecto*/
create table if not exists tb_configuraciones(

     idconfiguracion            int auto_increment,
     paisPorDefecto             int,
     ciudadPorDefecto           int,
     barrioPorDefecto           int,
     alertaPorVacunas           enum('A','I'),
     alertaPorDesparasitante    enum('A','I'),
     alertaPorStock             enum('A','I'),
     idFacturadorPorDefecto     int,
     precioConsulta             varchar(10),
     precioHoraHospitalizacion  varchar(10),
     
     primary key (idconfiguracion)

);
/*---*/


/*Para vincular las configuraciones con una sucursal en particula*/
create table if not exists tb_sucursales_configuraciones(

     idSucursalConfiguracion    int auto_increment,
     estado                     enum('A','I'),
     idSucursal                 int,
     idconfiguracion            int,
     
     primary key (idSucursalConfiguracion),
     
     foreign key (idSucursal)       references tb_sucursales (idSucursal),
     foreign key (idconfiguracion)  references tb_configuraciones(idconfiguracion)

);
/*---*/


/*Para almacenar los idiomas*/
create table if not exists tb_idiomas(

     idIdioma       int auto_increment,
     nombre         varchar(100) not null,
     urlArchivo     varchar(300) not null,
     urlBandera     varchar(300) not null,
     estado         enum('A','I'),
     
     primary key (idIdioma)

);
/*---*/

/*Para almacenar los usuarios*/
create table if not exists tb_usuarios(


      idUsuario               int auto_increment,
      tipoIdentificacion      varchar(5) not null,
      identificacion          varchar(30) not null,
      nombre                  varchar(100) not null,
      apellido                varchar(100) not null,
      pass                    varchar(300) not null,
      telefono                varchar(20),
      celular                 varchar(20),
      direccion               varchar(50),
      email                   varchar(100) not null,
      urlFoto                 varchar(300),
      agenda                  enum('Si','No'),
      idIdioma                int,
      estado                  enum('A','I'),
      idLicencia			  int,
      
      primary key (idUsuario),
      
      foreign key (idIdioma) references tb_idiomas (idIdioma)

);
/*---*/


/*Para almacenar los permisos que se le pueden asignar a un usuario*/
create table if not exists tb_permisos(

      idPermiso          int auto_increment,
      nombre             varchar(100),
      descripcion        varchar(200),
      
      primary key (idPermiso)

);
/*---*/


/*relaciona los permisos con los usuairos*/
create table if not exists tb_permisos_usuarios(

      idPermisoUsuario    int auto_increment,
      idPermiso           int,
      idUsuario           int,
      estado              enum('A','I'),
      
      primary key (idPermisoUsuario),
      
      foreign key (idPermiso) references tb_permisos (idPermiso),
      foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*se almacenan las especialidades*/
create table if not exists tb_especialidades(

 idEspecialidad          int auto_increment,
 nombre                  varchar(50) not null,
 descripcion             varchar(300),
 estado                  enum('A','I'),
 
 primary key (idEspecialidad)

);
/*---*/


/*Se relacionan las especialidades con los usuarios*/
create table if not exists tb_especialidades_usuario(

 idEspecialidadUsuario        int auto_increment, 
 idEspecialidad               int,
 idUsuario                    int,
 
 primary key (idEspecialidadUsuario),
 
 foreign key (idEspecialidad) references tb_especialidades (idEspecialidad),
 foreign key (idUsuario)      references tb_usuarios (idUsuario)


);
/*---*/


/*Se relaciona un usuario con una sucursal*/
create table if not exists tb_usuarios_sucursal(

 idUsuarioSucursal       int auto_increment,
 idSucursal              int,
 idUsuario               int,
 estado                  enum('A','I'),
 porDefecto              enum('Si','No') DEFAULT 'No',
 enUso	                 enum('Si','No') DEFAULT 'No',
 
 primary key (idUsuarioSucursal),
 
 foreign key (idSucursal) references tb_sucursales (idSucursal),
 foreign key (idUsuario)  references tb_usuarios (idUsuario)

);
/*---*/


/*Se almacenana todo s los tutoriales a modo de intro*/
create table if not exists tb_introTutorial(

 idIntroTutorial     int auto_increment,
 nombre              varchar(50) not null,
 
 primary key (idIntroTutorial)

);
/*---*/


/*Se relaciona un usuario con un introTutorial y el estado en que se encuentre*/
create table if not exists tb_usuario_introTutorial(

 idUsuarioIntroTutorial       int auto_increment,
 idIntroTutorial              int,
 idUsuario                    int,
 estado                       enum('A','I'),
 
 primary key (idUsuarioIntroTutorial),
 
 foreign key (idUsuario) references tb_usuarios (idUsuario),
 foreign key (idIntroTutorial) references tb_introTutorial (idIntroTutorial)

);
/*----*/



/*Se alamacenanan los horarios de un usuario*/
create table if not exists tb_agendaHorarioUsuario(

 idAgendaHorarioUsuario       int auto_increment,
 horaInicio                   time,
 horaFin                      time,
 numeroDia                    int not null,
 estado                       enum('A','I'),
 idUsuario                    int,
 
 primary key (idAgendaHorarioUsuario),
 
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Se almacenan los horarios por fehas de un usurio*/
create table if not exists tb_agendaHorarioFechaUsuario(

 idAgendaHorarioFechaUsuario    int auto_increment,
 horaInicio                     time,
 horaFin                        time,
 fecha                          date,
 estado                         enum('A','I'),
 idUsuario                      int,
 
 primary key (idAgendaHorarioFechaUsuario),
 
 foreign key (idUsuario) references tb_usuarios (idUsuario)
 

);
/*---*/


/*Se guardan los recesos de los usuarios*/
create table if not exists tb_agendaRecesosUsuario (

 idAgendaRecesosUsuario     int auto_increment,
 numeroDia                  int not null,
 idUsuario                  int,
 
 primary key (idAgendaRecesosUsuario),
 
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);


/*Se almacenan los horarios de los recesos*/
create table if not exists tb_agendaHorarioReceso(

 idAgendaHorarioReceso          int auto_increment,
 horaInicio                     time,
 horaFin                        time,
 estado                         enum('A','I'),
 idAgendaRecesosUsuario         int,
 
 primary key (idAgendaHorarioReceso),
 
 foreign key (idAgendaRecesosUsuario) references tb_agendaRecesosUsuario (idAgendaRecesosUsuario)

);
/*---*/



/*Se almacena los recesos por fecha */
create table if not exists tb_agendaRecesosFechaUsuario(

 idAgendaRecesosFechaUsuario    int auto_increment,
 fecha                          date,
 idUsuario                      int,
 
 primary key (idAgendaRecesosFechaUsuario)

);
/*---*/



/*Se almacenan los horarios de los recesesos por fecha*/
create table if not exists tb_agendaHorarioRecesoFecha(

 idAgendaHorarioRecesoFecha     int auto_increment,
 horaInicio                     time,
 horaFin                        time,
 estado                         enum('A','I'),
 idAgendaRecesosFechaUsuario    int,
 
 primary key (idAgendaHorarioRecesoFecha),
 
 foreign key (idAgendaRecesosFechaUsuario) references tb_agendaRecesosFechaUsuario (idAgendaRecesosFechaUsuario)

);
/*---*/




/*Para saber que logs se almacenan*/
create table if not exists tb_logs(

 idLog          int auto_increment,
 descripcion    varchar(300) not null,
 
 primary key (idLog)

);
/*---*/



/*Se registran los logs por usuairos*/
create table if not exists tb_logs_usuario(

 idLogUsuario      int auto_increment,
 idElemento        varchar(20) not null,
 fecha             date,
 hora              time,
 idLog             int,
 idUsuario         int,
 
 primary key (idLogUsuario),
 
 foreign key (idLog) references tb_logs (idLog),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Almacena los propietarios*/
create table if not exists tb_propietarios(

 idPropietario          int auto_increment,
 identificacion         varchar(30) not null,
 nombre                 varchar(100) not null,
 apellido               varchar(100) not null,
 telefono               varchar(20) not null,
 celular                varchar(20),
 direccion              varchar(50),
 email                  varchar(100),
 idPais                 int,
 idCiudad               int,
 idBarrio               int,
 estado                 enum('A','I'),
 
 primary key (idPropietario),
 
 foreign key (idPais)       references tb_paises (idPais),
 foreign key (idCiudad)     references tb_ciudades (idCiudad),
 foreign key (idBarrio)     references tb_barrios (idBarrio)

);
/*---*/


/*Almacena las especies de animales*/
create table if not exists tb_especies(

 idEspecie      int auto_increment,
 nombre         varchar(100) not null,
 descripcion    varchar(300),
 estado         enum('A','I'),
 
 primary key (idEspecie)

);
/*---*/


/*Almacena las distintas razas*/
create table if not exists tb_razas(

 idRaza         int auto_increment,
 nombre         varchar(100) not null,
 descripcion    varchar(300),
 estado         enum('A','I'),
 idEspecie      int,
 
 primary key (idRaza),
 
 foreign key (idEspecie) references tb_especies (idEspecie)

);
/*---*/


/*Almacena las mascotas o pacientes*/
create table if not exists tb_mascotas(

 idMascota                  int auto_increment,
 nombre                     varchar(50) not null,
 numeroChip                 varchar(50),
 sexo                       enum('M','H'),
 esterilizado               enum('Si','No'),
 color                      varchar(100),
 fechaNacimiento            date,
 urlFoto                    varchar(300),
 estado                     enum('vivo','muerto'),
 alimento                   varchar(300),
 frecuenciaDiaria           int,
 frecuenciaBanoDias         varchar(30),
 idPropietario              int,
 idRaza                     int,
 idEspecie                  int,
 idReplica				    int DEFAULT 0,
 
 primary key (idMascota),
 
 foreign key (idPropietario) references  tb_propietarios (idPropietario),
 foreign key (idRaza)        references  tb_razas (idRaza),
 foreign key (idEspecie)     references  tb_especies  (idEspecie)
 

);


/*Almacena los tipos de cita*/
create table if not exists tb_tiposCita(

 idTipoCita     int auto_increment,
 nombre         varchar(100) not null,
 estado         enum('A','I'),
 
 primary key (idTipoCita)

);
/*---*/


/*Se registran las citas*/
create table if not exists tb_agendaCitas(

 idAgendaCita           int auto_increment,
 fecha                  date,
 fechaFin               date,
 horaInicio             time,
 horaFin                time, 
 duracionHoras		  	varchar(10),
 duracionMinutos		varchar(10),
 estado                 enum('Asignada','inasistida','Cancelada','Atendida'),
 observaciones          text,
 motivoCancelacion	    varchar(200),
 idUsuarioCancela		int,
 idMascota              int,
 idSucursal             int,
 idTipoCita             int,
 idPropietario		    int,
 
 primary key (idAgendaCita),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idSucursal) references tb_sucursales (idSucursal),
 foreign key (idPropietario) references tb_propietarios (idPropietario)

);
/*---*/




/*Se vincula un usuario con una cita*/
create table if not exists tb_agendaCitas_usuarios(

 idAgendaCitasUsuarios      int auto_increment,
 idAgendaCita               int,
 idUsuario                  int,
 estado                     enum('A','I'),
 
 primary key (idAgendaCitasUsuarios),
 
 foreign key (idAgendaCita) references tb_agendaCitas (idAgendaCita),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Tabla para guardar las formulas*/
create table if not exists tb_formulas(

 idFormula       int auto_increment,
 fecha           date,
 hora            time,
 observaciones   text,
 idMascota       int,
 idUsuario       int,
 idSucursal      int,
 
 primary key (idFormula),
 
 foreign key (idMascota)   references tb_mascotas (idMascota),
 foreign key (idUsuario)   references tb_usuarios (idUsuario),
 foreign key (idSucursal)  references tb_sucursales (idSucursal)

);
/*---*/


/*Se almacena el listado de medicamentos que posteriormente pueden se rutilizados en una formula*/
create table if not exists tb_listadoMedicamentos(

 idMedicamento   int auto_increment,
 nombre          varchar(100) not null,
 codigo          varchar(20),
 observacion     varchar(300),
 estado          enum('A','I'),
 
 primary key (idMedicamento)

);
/*---*/



/*Se relacionan los medicamentos en una formula*/
create table if not exists tb_medicamentosFormula(

 idMedicamentoFormula     int auto_increment,
 via                      varchar(20) not null,
 cantidad                 int not null,
 frecuencia               varchar(20) not null,
 dosificacion             varchar(50) not null,
 observacion              text,
 idFormula                int,
 idMedicamento            int,
 
 primary key (idMedicamentoFormula),
 
 foreign key (idFormula) references  tb_formulas (idFormula),
 foreign key (idMedicamento) references tb_listadoMedicamentos (idMedicamento)

);
/*---*/



/*Se almacenan las cosnultas*/
create table if not exists tb_consultas (

 idConsulta            int auto_increment,
 fecha                 date,
 hora                  time,
 motivo                text,
 observaciones         text,
 planASeguir           text,
 edadActualMascota     varchar(50),
 idMascota             int,
 idUsuario             int,
 idSucursal            int,
 
 primary key (idConsulta),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idUsuario) references tb_usuarios (idUsuario),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/




/*Encabezado de paneles para los diagnosticos de las consultas*/
create table if not exists tb_panelesConsulta(

 idPanelConsulta    int auto_increment,
 nombre             varchar(100) not null,
 observacion        varchar(300),
 estado             enum('A','I'),
 
 primary key (idPanelConsulta)

);
/*---*/



/*Se almacenan los diagnosticos por paneles*/
create table if not exists tb_panelDiagnosticoConsulta(

 idPanelDiagnosticoConsulta   int auto_increment,
 nombre                       varchar(100) not null,
 codigo                       varchar(10) not null,
 observacion                  varchar(300),
 estado                       enum('A','I'),
 idPanelConsulta              int,

 primary key (idPanelDiagnosticoConsulta),

 foreign key (idPanelConsulta) references tb_panelesConsulta (idPanelConsulta)

);
/*---*/



/*se almacenan los diagnosticos que se vinulan con una consulta*/
create table if not exists tb_consultas_diagnosticos(

 idConsultaDiagnostico             int auto_increment,
 observacion                       varchar(200),
 idConsulta                        int,
 idPanelDiagnosticoConsulta        int,

 primary key (idConsultaDiagnostico),
 
 foreign key (idConsulta) references tb_consultas (idConsulta),
 foreign key (idPanelDiagnosticoConsulta) references tb_panelDiagnosticoConsulta(idPanelDiagnosticoConsulta)

);
/*---*/



/*Se almacena el examen fisico que se realice en una consulta*/
create table if not exists tb_examenFisico(

 idExamenFisico      int auto_increment,
 peso                varchar(20),
 medidaCm            varchar(20),
 temperatura         varchar(10),
 observaciones       text,
 idConsulta          int,
 
 primary key (idExamenFisico),
 
 foreign key (idConsulta) references tb_consultas (idConsulta)

);
/*---*


/*Se vinculan algunos items con el examen fisico*/
create table if not exists tb_itemsExamenFisico(

 idItiemExamenFisico     int auto_increment,
 nombre                  varchar(50) not null,
 observacion             text,
 estadoRevision          enum('B','R','M','NA'),
 idExamenFisico          int,
 
 primary key (idItiemExamenFisico),
 
 foreign key (idExamenFisico) references tb_examenFisico (idExamenFisico)

);
/*---*/


/*Se almacenan las notas aclaratorias de una consulta*/

create table if not exists tb_consultasNotasAclaratorias(

 idConsultaNotaAclaratoria		int auto_increment,
 texto							varchar(200) not null,
 fecha							date,
 hora							time,
 idConsulta						int,
 idUsuario						int,
 
 primary key (idConsultaNotaAclaratoria),
 
 foreign key (idConsulta) references tb_consultas (idConsulta),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Se almacenan las vacunas para aplicar a los pacientes*/
create table if not exists tb_vacunas(

 idVacuna       int auto_increment,
 nombre         varchar(100) not null,
 descripcion    varchar(200),
 estado         enum('A','I'),
 
 primary key (idVacuna)

);
/*---*/



/*Se registran las vacunas que se le aplican a los pacientes*/
create table if not exists tb_mascotas_vacunas(

 idMascotaVacunas         int auto_increment,
 fecha                    date,
 hora					  time,
 fechaProximaVacuna       date,
 observaciones            text,
 estado                   enum('A','I'),
 idMascota                int,
 idVacuna                 int,
 idSucursal               int,
 
 primary key (idMascotaVacunas),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idVacuna)  references tb_vacunas  (idVacuna),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/


/*Se registran los espacios que pueden ser utilizados para guarderia*/
create table if not exists tb_espaciosGuarderia(

 idEspacioGuarderia      int auto_increment,
 nombre                  varchar(100) not null,
 observacion             varchar(300),
 capacidad               int not null,
 espaciosOcupados        int not null,
 estado                  enum('A','I'),
 idSucursal              int,
 
 primary key (idEspacioGuarderia),
 
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/



/*Se registra una mascota en un espacio de guarderia*/
create table if not exists tb_guarderia(

 idGuarderia             int auto_increment,
 fechaIngreso            date,
 horaIngreso             time,
 observaciones           text,
 fechaSalida             date,
 horaSalida              time,
 idMascota               int,
 idEspacioGuarderia      int,
 
 primary key (idGuarderia),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idEspacioGuarderia) references tb_espaciosGuarderia (idEspacioGuarderia)

);
/*---*/


/*Se guardan las tareas de una guarderia o items que se realizan dentro de un cuidado en la guarderioa (como dar medicina o de comer a cierta hora)*/
create table if not exists tb_tareas_guarderia(

 idTareaGuarderia      int auto_increment,
 hora                  time,
 tarea                 varchar(300) not null,
 estado                enum('realizado','pendiente'),
 idGuarderia           int,
 
 primary key (idTareaGuarderia),
 
 foreign key (idGuarderia) references tb_guarderia (idGuarderia)

);
/*---*/


/*Guarada el listado de los examenes que se pueden realizar */
create table if not exists tb_listadoExamenes(

 idListadoExamen      int auto_increment,
 nombre               varchar(100) not null,
 codigo               varchar(20),
 precio               varchar(10) not null,
 descripcion          text,
 estado               enum('A','I'),
 
 primary key (idListadoExamen)

);
/*---*/


/*Se guarda el encabezado de los examenes */
create table if not exists tb_examenes(

 idExamen          int auto_increment,
 fecha             date,
 hora              time,
 observaciones     text,
 idMascota         int,
 idUsuario         int,
 idSucursal        int,
 
 primary key (idExamen),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idUsuario) references tb_usuarios (idUsuario),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/



/*Detalle del examen*/
create table if not exists tb_examenDetalle(

 idExamenDetalle      int auto_increment,
 observacion          text,
 idExamen             int,
 idListadoExamen      int,
 idExamenReplica	  int,
 
 primary key (idExamenDetalle),
 
 foreign key (idExamen) references tb_examenes (idExamen),
 foreign key (idListadoExamen) references tb_listadoExamenes (idListadoExamen)

);
/*---*/


/*Para registrar los resultados de los examenes*/
create table if not exists tb_resultadoExamen(

 idresultadoExamen       int auto_increment,
 fecha                   date,
 hora                    date,
 general                 enum('Bueno','Regular','Malo'),
 observaciones           text,
 idExamenDetalle         int,
 idUsuario               int,
 
 primary key (idresultadoExamen),
 
 foreign key (idExamenDetalle) references tb_examenDetalle (idExamenDetalle),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Se registran las cirugias practicadas a una mascota*/
create table if not exists tb_cirugias(

 idCirugia                   int auto_increment,
 fecha                       date,
 hora                        time,
 fechaFin                    date,
 horaFin                     time,
 tipoAnestesia               enum('General','Local','NA'),
 motivo                      text,
 complicaciones              text,
 observaciones               text,
 planASeguir                 text,
 edadActualMascota           varchar(50),
 idMascota                   int,
 idSucursal                  int,
 idUsuario				     int,
 
 primary key (idCirugia),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idSucursal) references tb_sucursales (idSucursal),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/



/*Se relacionan los usuarios que estaran en la cirugia*/
create table if not exists tb_usuarios_cirugias(

 idUsuarioCirugia    int auto_increment,
 idCirugia           int,
 idUsuario           int,
 
 primary key (idUsuarioCirugia),
 
 foreign key (idCirugia) references tb_cirugias (idCirugia),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/



/*Para guardar los paneles de las cirugias*/
create table if not exists tb_panelesCirugia(

 idPanelCirugia        int auto_increment,
 nombre                varchar(100) not null,
 observacion           varchar(300),
 estado                enum('A','I'),
 
 primary key (idPanelCirugia)

);
/*---*/



/*Diagnosticos de un panel para cirugias*/
create table if not exists tb_panelesCirugiaDiagnosticos(

 idPanelCirugiaDiagnostico   int auto_increment,
 nombre                      varchar(100) not null,
 codigo                      varchar(10) not null,
 observacion                 varchar(300),
 precio                      varchar(10) not null,
 estado                      enum('A','I'),
 idPanelCirugia              int,
 
 primary key (idPanelCirugiaDiagnostico),
 
 foreign key (idPanelCirugia) references tb_panelesCirugia (idPanelCirugia)

);
/*---*/


/*Se relacionan los diagnosticos con una cirugia*/
create table if not exists tb_diagnosticosCirugias(

 idDiagnosticoCirugia            int auto_increment,
 descripcion                     varchar(200),
 idPanelCirugiaDiagnostico       int,
 idCirugia                       int,
 
 primary key (idDiagnosticoCirugia),
 
 foreign key (idPanelCirugiaDiagnostico) references tb_panelesCirugiaDiagnosticos (idPanelCirugiaDiagnostico),
 foreign key (idCirugia) references tb_cirugias (idCirugia)

);
/*---*/



/*Notas aclaratorias para una cirugia*/
create table if not exists tb_cirugiasNotasAclaratorios(

 idCirugiaNotaAclaratoria     int auto_increment,
 texto                        varchar(200) not null,
 fecha                        date,
 hora                         time,
 idCirugia                    int,
 idUsuario                    int,
 
 primary key (idCirugiaNotaAclaratoria),
 
 foreign key (idCirugia) references tb_cirugias (idCirugia),
 foreign key (idUsuario) references tb_usuarios (idUsuario)
 
);
/*---*/



/*Se registran las hospitalizaciones de una mascota*/
create table if not exists tb_hospitalizacion (

 idHospitalizacion           int auto_increment,
 fechaIngreso                date,
 horaIngreso                 time,
 motivoHospitalizacion       text,
 observacion                 varchar(300),
 idMascota                   int,
 idUsuario                   int,
 idSucursal                  int,
 
 primary key (idHospitalizacion),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idUsuario) references tb_usuarios (idUsuario),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/



/*Se vinculan las cirugias que se realizan en una hospitalización*/
create table if not exists tb_cirugia_hospitalizacion(

 idCirugiaHospitalizacion     int auto_increment,
 idHospitalizacion            int,
 idCirugia                    int,
 
 primary key (idCirugiaHospitalizacion),
 
 foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
 foreign key (idCirugia) references tb_cirugias (idCirugia)

);
/*---*/



/*Se vinculan las consultas que se realizan dentro de una hospitalizacion*/
create table if not exists tb_ConsultaHospitalzacion(

 idConsultaHospitalizacion    int auto_increment,
 idHospitalizacion            int,
 idConsulta                   int,
 
 primary key (idConsultaHospitalizacion),
 
 foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
 foreign key (idConsulta) references tb_consultas (idConsulta)

);
/*---*/



/*Se vinculan los examenes que se realicen a un mascota hospitalizada*/
create table if not exists tb_examen_hospitalizacion(

 idExamenHospitalizacion      int auto_increment,
 idHospitalizacion            int,
 idExamen                     int,
 
 primary key (idExamenHospitalizacion),
 
 foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
 foreign key (idExamen) references tb_examenes (idExamen)

);
/*---*/


/*Se vinculan las formulas que se realicen a un mascota hospitalizada*/
create table if not exists tb_formula_hospitalizacion(
	  
	idFormulaHospitalizacion     int auto_increment,
	idHospitalizacion            int,
	idFormula                    int,
												
	primary key (idFormulaHospitalizacion),
														
	foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
	foreign key (idFormula) references tb_formulas (idFormula)
															
);
/*---*/


/*Se registra cuando se le da de alta  aun paciente de una hospitalización*/
create table if not exists tb_hospitalizacionAlta (

 idHospitalizacionAlta           int auto_increment,
 fecha                           date,
 hora                            time,
 observaciones                   text,
 cuidadosATener                  text,
 vivo                            enum('Si','No'),
 idHospitalizacion               int,
 idUsuario                       int,
 
 primary key (idHospitalizacionAlta),
 
 foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/



/*Se ingresan los espacios disponibles para la hospitalizacion*/
create table if not exists tb_espacioHospitalizacion(

 idEspacioHospitalizacion       int auto_increment,
 nombre                         varchar(100) not null,
 observacion                    varchar(300),
 capacidad                      int not null,
 espaciosOcupados               int not null,
 estado                         enum('A','I'),
 idSucursal                     int,
 
 primary key (idEspacioHospitalizacion),
 
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/




/*Se vincula una hospitalizacion con un espacio para hospitalizar*/
create table if not exists tb_espacioHospitalizacion_Hospitalizacion(

 idEspacioHospitalizacionHospitalizacion      int auto_increment,
 estado										  enum('A','I'),											
 idEspacioHospitalizacion                     int,
 idHospitalizacion                            int,
 
 primary key (idEspacioHospitalizacionHospitalizacion),
 
 foreign key (idEspacioHospitalizacion) references tb_espacioHospitalizacion (idEspacioHospitalizacion),
 foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion)

);
/*---*/



/*Tabla que almacena los facturadores*/
create table if not exists tb_facturadores(

 idFacturador                 int auto_increment,
 tipoIdentificacion           varchar(5) not null,
 identificacion               varchar(30) not null,
 nombre                       varchar(100) not null,
 apellido                     varchar(100) not null,
 telefono                     varchar(20),
 celular                      varchar(20),
 direccion                    varchar(50),
 email                        varchar(100),
 tipoRegimen				  varchar(100),
 razonSocial				  varchar(300),
 identificacionEmisor         varchar(30),
 nombreEmisor                 varchar(100),
 estado                       enum('A','I'),
 
 primary key (idFacturador)

);
/*---*/


/*tabla para lamacenar los proveedores*/
create table if not exists tb_proveedores(

 idProveedor                 int auto_increment,
 identificativoNit           varchar(50) not null,
 nombre                      varchar(100) not null,
 telefono1                   varchar(20),
 telefono2                   varchar(20),
 celular                     varchar(20),
 direccion                   varchar(50),
 email                       varchar(100),
 estado                      enum('A','I'),
 
 primary key (idProveedor)

);
/*---*/



/*Se almacnan las categorias para los productos*/
create table if not exists tb_categoriasProductos(

 idCategoria        int auto_increment,
 nombre             varchar(100) not null,
 descripcion        varchar(200),
 estado             enum('A','I'),
 
 primary key (idCategoria)

);



/*Se almacenan los productos que se manejan*/
create table if not exists tb_productos(

 idProducto           int auto_increment,
 nombre               varchar(50) not null,
 descripcion          text,
 codigo               varchar(20) not null,
 precio               varchar(10) not null,
 estado               enum('A','I'),
 idCategoria          int,
 idExterno			  int default 0,
 primary key (idProducto),
 
 primary key (idProducto),
 
 foreign key (idCategoria) references tb_categoriasProductos (idCategoria)

);
/*---*/



/*Se relacionan los productos con los proveedores*/
create table if not exists tb_productos_proveedores(

 idProductosProveedores     int auto_increment,
 costo                      varchar(10) not null,
 estado                     enum('A','I'),
 idProducto                 int,
 idProveedor                int,
 
 primary key (idProductosProveedores),
 
 foreign key (idProducto)  references tb_productos (idProducto),
 foreign key (idProveedor) references tb_proveedores (idProveedor)

);
/*---*/


/*Se relacionan los productos con las sucursales*/
create table if not exists tb_productos_sucursal(

 idProductoSucursal     int auto_increment,
 cantidad               int not null,
 stockMinimo            int not null,
 idProducto             int,
 idSucursal             int,
 
 primary key (idProductoSucursal),
 
 foreign key (idProducto) references tb_productos (idProducto),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/


/*Se registran las resoluciones dian*/
create table if not exists tb_resolucionDian( 

 
 idResolucionDian        int auto_increment,
 numeroResolucion		 varchar(45),
 consecutivoInicial      int not null,
 consecutivoFinal        int not null,
 iniciarFacturaEn        int not null,
 fechaResolucion         date,
 fechaVencimiento        date,
 autoCorrectorIva        enum('Si','No'),
 porcentajeIva           varchar(10) not null,
 proximaFactura			 int,
 estado                  enum('A','I'),
 
 
 primary key (idResolucionDian)
 
 
);
/*---*/



/*Se registran los servicios*/
create table if not exists tb_servicios(

 idServicio        int auto_increment,
 codigo            varchar(20) not null,
 nombre            varchar(50) not null,
 descripcion       varchar(200) not null,
 precio            varchar(10) not null,
 estado            enum('A','I') not null,
 
 primary key (idServicio)

);
/*---*/



/*Se registra la peluqueria*/
create table if not exists tb_peluqueria(

 idPeluqueria       int auto_increment,
 horaInicio         time,
 horaFin            time,
 observaciones      text,
 idMascota          int,
 idSucursal         int,
 
 primary key (idPeluqueria),
 
 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/



/*Se registran las items de la peluqueria*/
create table if not exists tb_peluqueriaItems(

 idPeluqueriaItem       int auto_increment,
 nombre                 varchar(100) not null,
 horaAdicion            time,
 horaFin                time,
 estado                 enum('Pendiente','Terminado'),
 observaciones          text,
 idPeluqueria           int,
 
 primary key (idPeluqueriaItem),
 
 foreign key (idPeluqueria) references tb_peluqueria (idPeluqueria)

);
/*---*/


/*Se almacenan las facturas*/
create table if not exists tb_facturas(

 idFactura             int auto_increment,
 numeroFactura         int not null,
 fecha                 date,
 hora                  time,
 fechaFin              date,
 horaFin               time, 
 iva                   varchar(10) not null,
 valorIva              varchar(10) not null,
 descuento			   varchar(10) not null,
 subtotal              varchar(10) not null,
 total                 varchar(10) not null,
 numeroImpresiones     int,
 metodopago			   enum('cheque','efectivo','bono','tdebito','tcredito'),
 observaciones		   varchar(300),
 estado                enum('Anulada','Cancelada','Iniciada','Activa'),
 idFacturador          int,
 idResolucionDian      int,
 idUsuario             int,
 idSucursal            int,
 idPropietario		   int,
 
 primary key (idFactura),
 
 foreign key (idPropietario) references tb_propietarios (idPropietario), 
 foreign key (idFacturador) references tb_facturadores (idFacturador),
 foreign key (idResolucionDian) references tb_resolucionDian (idResolucionDian),
 foreign key (idUsuario) references tb_usuarios (idUsuario),
 foreign key (idSucursal) references tb_sucursales (idSucursal)

);
/*---*/



/*Se almacena los desparasitantes*/
create table if not exists tb_desparasitantes(

 idDesparasitante			int auto_increment,
 nombre						varchar(100) not null,
 descripcion				varchar(200),
 estado						enum('A','I'),
 
 primary key (idDesparasitante)

);
/*---*/


/*Se vincula un desparasitante con una mascota*/
create table if not exists tb_desparasitantesMascotas(

 idDesparasitanteMascota		int auto_increment,
 dosificacion					varchar(100) not null,
 fecha							date,
 hora							time,
 fechaProximoDesparasitante		date,
 observacion					varchar(300),
 idMascota						int,
 idDesparasitante				int,
 
 primary key (idDesparasitanteMascota),

 foreign key (idMascota) references tb_mascotas (idMascota),
 foreign key (idDesparasitante) references tb_desparasitantes (idDesparasitante)

);
/*---*/

/*Personalizados motivo de consulta*/
create table if not exists tb_personalizados_motivoConsulta(

 idPersonalizadoMotivoConsulta		int auto_increment,
 titulo								varchar(100) not null,
 texto								longtext not null,
 estado								enum('A','I'),
 idUsuario							int,
 
 primary key (idPersonalizadoMotivoConsulta),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/



/*Personalizados observaciones de consulta*/
create table if not exists tb_personalizados_observacionesConsulta(

 idPersonalizadoObservacionConsulta		int auto_increment,
 titulo									varchar(100) not null,
 texto									longtext not null,
 estado									enum('A','I'),
 idUsuario								int,

 primary key (idPersonalizadoObservacionConsulta),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizados plan a seguir de consulta*/
create table if not exists tb_personalizados_planConsulta(

 idPersonalizadoPlanConsulta		    int auto_increment,
 titulo									varchar(100) not null,
 texto									longtext not null,
 estado									enum('A','I'),
 idUsuario								int,

 primary key (idPersonalizadoPlanConsulta),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Personalizado observaciones examen fisico*/
create table if not exists tb_personalizados_observacionesExamenFisico(

 idPersonalizadoObservacionExamenFisico		int auto_increment,
 titulo										varchar(100) not null,
 texto										longtext not null,
 estado										enum('A','I'),
 idUsuario									int,

 primary key (idPersonalizadoObservacionExamenFisico),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizado observaciones examen formulacion*/
create table if not exists tb_personalizados_observacionesFormulacion(

 idPersonalizadoObservacionFormulacion		int auto_increment,
 titulo										varchar(100) not null,
 texto										longtext not null,
 estado										enum('A','I'),
 idUsuario									int,

 primary key (idPersonalizadoObservacionFormulacion),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Personalizados motivo de cirugia*/
create table if not exists tb_personalizados_motivoCirugia(
      
 idPersonalizadoMotivoCirugia		int auto_increment,
 titulo								varchar(100) not null,
 texto								longtext not null,
 estado								enum('A','I'),
 idUsuario							int,
 
 primary key (idPersonalizadoMotivoCirugia),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizados obsevaciones de cirugia*/
create table if not exists tb_personalizados_observacionesCirugia(
      
 idPersonalizadoObservacionCirugia	int auto_increment,
 titulo								varchar(100) not null,
 texto								longtext not null,
 estado								enum('A','I'),
 idUsuario							int,

 primary key (idPersonalizadoObservacionCirugia),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizados plan de cirugia*/
create table if not exists tb_personalizados_planCirugia(
      
 idPersonalizadoPlanCirugia		int auto_increment,
 titulo							varchar(100) not null,
 texto							longtext not null,
 estado							enum('A','I'),
 idUsuario						int,

 primary key (idPersonalizadoPlanCirugia),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizado observaciones examen*/
create table if not exists tb_personalizados_observacionesExamen(

 idPersonalizadoObservacionExamen			int auto_increment,
 titulo										varchar(100) not null,
 texto										longtext not null,
 estado										enum('A','I'),
 idUsuario									int,

 primary key (idPersonalizadoObservacionExamen),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Personalizados motivo hospitalizacion*/
create table if not exists tb_personalizados_motivoHospitalizacion(

 idPersonalizadoMotivoHospitalizacion		int auto_increment,
 titulo										varchar(100) not null,
 texto										longtext not null,
 estado										enum('A','I'),
 idUsuario									int,
 
 primary key (idPersonalizadoMotivoHospitalizacion),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Perosnalizados observaciones Hospitalización*/
create table if not exists tb_personalizados_observacionesHospitalizacion(

 idPersonalizadoObservacionHospitalizacion		int auto_increment,
 titulo											varchar(100) not null,
 texto											longtext not null,
 estado											enum('A','I'),
 idUsuario										int,

 primary key (idPersonalizadoObservacionHospitalizacion),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Perosnalizados cuidados alta*/
create table if not exists tb_personalizados_cuidadosAlta(

 idPersonalizadoCuidadosAlta		int auto_increment,
 titulo								varchar(100) not null,
 texto								longtext not null,
 estado								enum('A','I'),
 idUsuario							int,
 
 primary key (idPersonalizadoCuidadosAlta),

 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/

/*Adjuntos para consulta*/
create table if not exists tb_adjuntosConsulta(

 idAdjuntoConsulta		int auto_increment,
 fecha					date,
 urlArchivo				varchar(300),
 pesoArchivo			varchar(30),
 idConsulta				int,
 idUsuario				int,

 primary key (idAdjuntoConsulta),

 foreign key (idConsulta) references tb_consultas (idConsulta),
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);
/*---*/


/*Adjuntos para cirugias*/
create table if not exists tb_adjuntosCirugias(

 idAdjuntoCirugia		int auto_increment,
 fecha					date,
 urlArchivo				varchar(300) not null,
 pesoArchivo			varchar(30),
 idCirugia				int,
 idUsuario				int,
 
 primary key (idAdjuntoCirugia),
 
 foreign key(idCirugia) references tb_cirugias(idCirugia),
 foreign key(idUsuario) references tb_usuarios(idUsuario)

);

/*---*/

/*Registrar entradas de un producto*/
create table if not exists tb_productos_sucursal_entradas(

 idProductoSucursalEntrada		int auto_increment,
 cantidad						int not null,
 costo							varchar(10) not null,
 fecha							date,
 idProducto						int,
 idSucursal						int,
 idProveedor					int,
 idUsuario						int,
 
 primary key (idProductoSucursalEntrada),
 
 foreign key(idProducto) references tb_productos (idProducto),
 foreign key(idSucursal) references tb_sucursales (idSucursal),
 foreign key(idProveedor) references tb_proveedores(idProveedor),
 foreign key(idUsuario) references tb_usuarios(idUsuario)

);

/*---*/


create table if not exists tb_facturadoresResolucionDian(

 idFacturadoresResolucionDian		int auto_increment,
 estado								enum('A','I'),
 idFacturador						int,
 idResolucionDian					int ,
 
 primary key (idFacturadoresResolucionDian),
 
 foreign key (idFacturador) references tb_facturadores (idFacturador),
 foreign key (idResolucionDian) references tb_resolucionDian (idResolucionDian)

);

/*---*/

/*Tabla que hace de puente entre una factura o un recibo de caja con los destalles*/
create table if not exists tb_registro_factura_caja(

 idRegistroFacturaCaja   int auto_increment,
 fecha					 date,
 hora					 time,
 tipoElemento			 enum('Factura','Caja','Ninguno'),
 motivoninguno			 varchar(300),
 idTipoElemento			 int not null,
 idUsuario				 int,
 
 primary key (idRegistroFacturaCaja),
 
 foreign key (idUsuario) references tb_usuarios (idUsuario)

);

/*---*/

/*Tabla que permite la union de los detalles con el pago */

create table if not exists tb_pago_factura_caja_detalle(

 idPagoFacturaCajaDetalle		int auto_increment,
 tipoDetalle					varchar(20) not null,
 idTipoDetalle					int not null,
 tipoSubDetalle					varchar(20),
 idTipoSubDetalle				int, 
 valorUnitario					varchar(10),
 descuento						varchar(10),
 cantidad						int,
 estado							enum('Activo','Anulado','Borrado'),
 idSucursal						int,
 idPagoFacturaCaja				int,
 
 primary key (idPagoFacturaCajaDetalle),
 
 foreign key(idSucursal) references tb_sucursales (idSucursal),
 foreign key (idPagoFacturaCaja) references tb_pago_factura_caja (idPagoFacturaCaja) 

);

/*---*/


/*Tabla para los mensajes a los usuarios */

create table if not exists tb_mensajesUsuarios(

     idMensajeUsuarios		int auto_increment,
	 fechaCreacion			date,
	 horaCreacion			time,
	 texto					varchar(300),
	 fechaVencimiento		date,
	 estado					enum('A','I'),
	 idUsuario				int,
	 
	 primary key (idMensajeUsuarios),
	 
	 foreign key (idUsuario) references tb_usuarios (idUsuario)

);

/*---*/


/*------------------------ Insert para tablas por defecto ----------------------------------------------*/

/*---------------- tb_paises --------------------------------------*/

INSERT INTO tb_paises VALUES(1,  'Afganistán','AF', 'afghanistan_64.png', 'A');
INSERT INTO tb_paises VALUES(2,  'Islas Gland','AX', 'aland_islands_64.png', 'A');
INSERT INTO tb_paises VALUES(3,  'Albania','AL', 'albania_64.png', 'A');
INSERT INTO tb_paises VALUES(4,  'Alemania','DE', 'Alemania.png', 'A');
INSERT INTO tb_paises VALUES(5,  'Andorra','AD', 'Andorra.png', 'A');
INSERT INTO tb_paises VALUES(6,  'Angola','AO', 'Angola.png', 'A');
INSERT INTO tb_paises VALUES(7,  'Anguilla','AI', 'Anguilla.png', 'A');
INSERT INTO tb_paises VALUES(8,  'Antártida','AQ', 'Antártida.png', 'A');
INSERT INTO tb_paises VALUES(9,  'Antigua y Barbuda','AG', 'AntiguayBarbuda.png', 'A');
INSERT INTO tb_paises VALUES(10,  'Antillas Holandesas','AN', 'Antillas.png', 'A');
INSERT INTO tb_paises VALUES(11,  'Arabia Saudí','SA', 'Arabia.png', 'A');
INSERT INTO tb_paises VALUES(12,  'Argelia','DZ', 'Argelia.png', 'A');
INSERT INTO tb_paises VALUES(13,  'Argentina','AR', 'Argentina.png', 'A');
INSERT INTO tb_paises VALUES(14,  'Armenia','AM', 'Armenia.png', 'A');
INSERT INTO tb_paises VALUES(15,  'Aruba','AW', 'Aruba.png', 'A');
INSERT INTO tb_paises VALUES(16,  'Australia','AU', 'Australia.png', 'A');
INSERT INTO tb_paises VALUES(17,  'Austria','AT', 'Austria.png', 'A');
INSERT INTO tb_paises VALUES(18,  'Azerbaiyán','AZ', 'Azerbaiyán.png', 'A');
INSERT INTO tb_paises VALUES(19,  'Bahamas','BS', 'Bahamas.png', 'A');
INSERT INTO tb_paises VALUES(20,  'Bahréin','BH', 'Bahréin.png', 'A');
INSERT INTO tb_paises VALUES(21,  'Bangladesh','BD', 'Bangladesh.png', 'A');
INSERT INTO tb_paises VALUES(22,  'Barbados','BB', 'Barbados.png', 'A');
INSERT INTO tb_paises VALUES(23,  'Bielorrusia','BY', 'Bielorrusia.png', 'A');
INSERT INTO tb_paises VALUES(24,  'Bélgica','BE', 'Bélgica.png', 'A');
INSERT INTO tb_paises VALUES(25,  'Belice','BZ', 'Belice.png', 'A');
INSERT INTO tb_paises VALUES(26,  'Benin','BJ', 'Benin.png', 'A');
INSERT INTO tb_paises VALUES(27,  'Bermudas','BM', 'Bermudas.png', 'A');
INSERT INTO tb_paises VALUES(28,  'Bhután','BT', 'Bhután.png', 'A');
INSERT INTO tb_paises VALUES(29,  'Bolivia','BO', 'Bolivia.png', 'A');
INSERT INTO tb_paises VALUES(30,  'Bosnia y Herzegovina','BA', 'Bosnia.png', 'A');
INSERT INTO tb_paises VALUES(31,  'Botsuana','BW', 'Botsuana.png', 'A');
INSERT INTO tb_paises VALUES(32,  'Isla Bouvet','BV', 'IslaBouvet.png', 'A');
INSERT INTO tb_paises VALUES(33,  'Brasil','BR', 'Brasil.png', 'A');
INSERT INTO tb_paises VALUES(34,  'Brunéi','BN', 'Brunéi.png', 'A');
INSERT INTO tb_paises VALUES(35,  'Bulgaria','BG', 'Bulgaria.png', 'A');
INSERT INTO tb_paises VALUES(36,  'Burkina Faso','BF', 'BurkinaFaso.png', 'A');
INSERT INTO tb_paises VALUES(37,  'Burundi','BI', 'Burundi.png', 'A');
INSERT INTO tb_paises VALUES(38,  'Cabo Verde','CV', 'CaboVerde.png', 'A');
INSERT INTO tb_paises VALUES(39,  'Islas Caimán','KY', 'IslasCaimán.png', 'A');
INSERT INTO tb_paises VALUES(40,  'Camboya','KH', 'Camboya.png', 'A');
INSERT INTO tb_paises VALUES(41,  'Camerún','CM', 'Camerún.png', 'A');
INSERT INTO tb_paises VALUES(42,  'Canadá','CA', 'Canadá.png', 'A');
INSERT INTO tb_paises VALUES(43,  'República Centroafricana','CF', 'República.png', 'A');
INSERT INTO tb_paises VALUES(44,  'Chad','TD', 'Chad.png', 'A');
INSERT INTO tb_paises VALUES(45,  'República Checa','CZ', 'República.png', 'A');
INSERT INTO tb_paises VALUES(46,  'Chile','CL', 'Chile.png', 'A');
INSERT INTO tb_paises VALUES(47,  'China','CN', 'China.png', 'A');
INSERT INTO tb_paises VALUES(48,  'Chipre','CY', 'Chipre.png', 'A');
INSERT INTO tb_paises VALUES(49,  'Isla de Navidad','CX', 'IsladeNavidad.png', 'A');
INSERT INTO tb_paises VALUES(50,  'Ciudad del Vaticano','VA', 'CiudaddelVaticano.png', 'A');
INSERT INTO tb_paises VALUES(51,  'Islas Cocos','CC', 'IslasCocos.png', 'A');
INSERT INTO tb_paises VALUES(52,  'Colombia','CO', 'Colombia.png', 'A');
INSERT INTO tb_paises VALUES(53,  'Comoras','KM', 'Comoras.png', 'A');
INSERT INTO tb_paises VALUES(54,  'República Democrática del Congo','CD', 'RepúblicaDemocráticadelCongo.png', 'A');
INSERT INTO tb_paises VALUES(55,  'Congo','CG', 'Congo.png', 'A');
INSERT INTO tb_paises VALUES(56,  'Islas Cook','CK', 'IslasCook.png', 'A');
INSERT INTO tb_paises VALUES(57,  'Corea del Norte','KP', 'CoreadelNorte.png', 'A');
INSERT INTO tb_paises VALUES(58,  'Corea del Sur','KR', 'CoreadelSur.png', 'A');
INSERT INTO tb_paises VALUES(59,  'Costa de Marfil','CI', 'CostadeMarfil.png', 'A');
INSERT INTO tb_paises VALUES(60,  'Costa Rica','CR', 'Costa.png', 'A');
INSERT INTO tb_paises VALUES(61,  'Croacia','HR', 'Croacia.png', 'A');
INSERT INTO tb_paises VALUES(62,  'Cuba','CU', 'Cuba.png', 'A');
INSERT INTO tb_paises VALUES(63,  'Dinamarca','DK', 'Dinamarca.png', 'A');
INSERT INTO tb_paises VALUES(64,  'Dominica','DM', 'Dominica.png', 'A');
INSERT INTO tb_paises VALUES(65,  'República Dominicana','DO', 'RepúblicaDominicana.png', 'A');
INSERT INTO tb_paises VALUES(66,  'Ecuador','EC', 'Ecuador.png', 'A');
INSERT INTO tb_paises VALUES(67,  'Egipto','EG', 'Egipto.png', 'A');
INSERT INTO tb_paises VALUES(68,  'El Salvador','SV', 'ElSalvador.png', 'A');
INSERT INTO tb_paises VALUES(69,  'Emiratos Árabes Unidos','AE', 'EmiratosÁrabesUnidos.png', 'A');
INSERT INTO tb_paises VALUES(70,  'Eritrea','ER', 'Eritrea.png', 'A');
INSERT INTO tb_paises VALUES(71,  'Eslovaquia','SK', 'Eslovaquia.png', 'A');
INSERT INTO tb_paises VALUES(72,  'Eslovenia','SI', 'Eslovenia.png', 'A');
INSERT INTO tb_paises VALUES(73,  'España','ES', 'España.png', 'A');
INSERT INTO tb_paises VALUES(74,  'Islas ultramarinas de Estados Unidos','UM', 'IslasultramarinasdeEstadosUnidos.png', 'A');
INSERT INTO tb_paises VALUES(75,  'Estados Unidos','US', 'EstadosUnidos.png', 'A');
INSERT INTO tb_paises VALUES(76,  'Estonia','EE', 'Estonia.png', 'A');
INSERT INTO tb_paises VALUES(77,  'Etiopía','ET', 'Etiopía.png', 'A');
INSERT INTO tb_paises VALUES(78,  'Islas Feroe','FO', 'IslasFeroe.png', 'A');
INSERT INTO tb_paises VALUES(79,  'Filipinas','PH', 'Filipinas.png', 'A');
INSERT INTO tb_paises VALUES(80,  'Finlandia','FI', 'Finlandia.png', 'A');
INSERT INTO tb_paises VALUES(81,  'Fiyi','FJ', 'Fiyi.png', 'A');
INSERT INTO tb_paises VALUES(82,  'Francia','FR', 'Francia.png', 'A');
INSERT INTO tb_paises VALUES(83,  'Gabón','GA', 'Gabón.png', 'A');
INSERT INTO tb_paises VALUES(84,  'Gambia','GM', 'Gambia.png', 'A');
INSERT INTO tb_paises VALUES(85,  'Georgia','GE', 'Georgia.png', 'A');
INSERT INTO tb_paises VALUES(86,  'Islas Georgias del Sur y Sandwich del Sur','GS', 'IslasGeorgiasdelSurySandwichdelSur.png', 'A');
INSERT INTO tb_paises VALUES(87,  'Ghana','GH', 'Ghana.png', 'A');
INSERT INTO tb_paises VALUES(88,  'Gibraltar','GI', 'Gibraltar.png', 'A');
INSERT INTO tb_paises VALUES(89,  'Granada','GD', 'Granada.png', 'A');
INSERT INTO tb_paises VALUES(90,  'Grecia','GR', 'Grecia.png', 'A');
INSERT INTO tb_paises VALUES(91,  'Groenlandia','GL', 'Groenlandia.png', 'A');
INSERT INTO tb_paises VALUES(92,  'Guadalupe','GP', 'Guadalupe.png', 'A');
INSERT INTO tb_paises VALUES(93,  'Guam','GU', 'Guam.png', 'A');
INSERT INTO tb_paises VALUES(94,  'Guatemala','GT', 'Guatemala.png', 'A');
INSERT INTO tb_paises VALUES(95,  'Guayana Francesa','GF', 'GuayanaFrancesa.png', 'A');
INSERT INTO tb_paises VALUES(96,  'Guinea','GN', 'Guinea.png', 'A');
INSERT INTO tb_paises VALUES(97,  'Guinea Ecuatorial','GQ', 'GuineaEcuatorial.png', 'A');
INSERT INTO tb_paises VALUES(98,  'Guinea-Bissau','GW', 'GuineaBissau.png', 'A');
INSERT INTO tb_paises VALUES(99,  'Guyana','GY', 'Guyana.png', 'A');
INSERT INTO tb_paises VALUES(100,  'Haití','HT', 'Haití.png', 'A');
INSERT INTO tb_paises VALUES(101,  'Islas Heard y McDonald','HM', 'IslasHeardyMcDonald.png', 'A');
INSERT INTO tb_paises VALUES(102,  'Honduras','HN', 'Honduras.png', 'A');
INSERT INTO tb_paises VALUES(103,  'Hong Kong','HK', 'HongKong.png', 'A');
INSERT INTO tb_paises VALUES(104,  'Hungría','HU', 'Hungría.png', 'A');
INSERT INTO tb_paises VALUES(105,  'India','IN', 'India.png', 'A');
INSERT INTO tb_paises VALUES(106,  'Indonesia','ID', 'Indonesia.png', 'A');
INSERT INTO tb_paises VALUES(107,  'Irán','IR', 'Irán.png', 'A');
INSERT INTO tb_paises VALUES(108,  'Iraq','IQ', 'Iraq.png', 'A');
INSERT INTO tb_paises VALUES(109,  'Irlanda','IE', 'Irlanda.png', 'A');
INSERT INTO tb_paises VALUES(110,  'Islandia','IS', 'Islandia.png', 'A');
INSERT INTO tb_paises VALUES(111,  'Israel','IL', 'Israel.png', 'A');
INSERT INTO tb_paises VALUES(112,  'Italia','IT', 'Italia.png', 'A');
INSERT INTO tb_paises VALUES(113,  'Jamaica','JM', 'Jamaica.png', 'A');
INSERT INTO tb_paises VALUES(114,  'Japón','JP', 'Japón.png', 'A');
INSERT INTO tb_paises VALUES(115,  'Jordania','JO', 'Jordania.png', 'A');
INSERT INTO tb_paises VALUES(116,  'Kazajstán','KZ', 'Kazajstán.png', 'A');
INSERT INTO tb_paises VALUES(117,  'Kenia','KE', 'Kenia.png', 'A');
INSERT INTO tb_paises VALUES(118,  'Kirguistán','KG', 'Kirguistán.png', 'A');
INSERT INTO tb_paises VALUES(119,  'Kiribati','KI', 'Kiribati.png', 'A');
INSERT INTO tb_paises VALUES(120,  'Kuwait','KW', 'Kuwait.png', 'A');
INSERT INTO tb_paises VALUES(121,  'Laos','LA', 'Laos.png', 'A');
INSERT INTO tb_paises VALUES(122,  'Lesotho','LS', 'Lesotho.png', 'A');
INSERT INTO tb_paises VALUES(123,  'Letonia','LV', 'Letonia.png', 'A');
INSERT INTO tb_paises VALUES(124,  'Líbano','LB', 'Líbano.png', 'A');
INSERT INTO tb_paises VALUES(125,  'Liberia','LR', 'Liberia.png', 'A');
INSERT INTO tb_paises VALUES(126,  'Libia','LY', 'Libia.png', 'A');
INSERT INTO tb_paises VALUES(127,  'Liechtenstein','LI', 'Liechtenstein.png', 'A');
INSERT INTO tb_paises VALUES(128,  'Lituania','LT', 'Lituania.png', 'A');
INSERT INTO tb_paises VALUES(129,  'Luxemburgo','LU', 'Luxemburgo.png', 'A');
INSERT INTO tb_paises VALUES(130,  'Macao','MO', 'Macao.png', 'A');
INSERT INTO tb_paises VALUES(131,  'ARY Macedonia','MK', 'ARY.png', 'A');
INSERT INTO tb_paises VALUES(132,  'Madagascar','MG', 'Madagascar.png', 'A');
INSERT INTO tb_paises VALUES(133,  'Malasia','MY', 'Malasia.png', 'A');
INSERT INTO tb_paises VALUES(134,  'Malawi','MW', 'Malawi.png', 'A');
INSERT INTO tb_paises VALUES(135,  'Maldivas','MV', 'Maldivas.png', 'A');
INSERT INTO tb_paises VALUES(136,  'Malí','ML', 'Malí.png', 'A');
INSERT INTO tb_paises VALUES(137,  'Malta','MT', 'Malta.png', 'A');
INSERT INTO tb_paises VALUES(138,  'Islas Malvinas','FK', 'IslasMalvinas.png', 'A');
INSERT INTO tb_paises VALUES(139,  'Islas Marianas del Norte','MP', 'IslasMarianasdelNorte.png', 'A');
INSERT INTO tb_paises VALUES(140,  'Marruecos','MA', 'Marruecos.png', 'A');
INSERT INTO tb_paises VALUES(141,  'Islas Marshall','MH', 'IslasMarshall.png', 'A');
INSERT INTO tb_paises VALUES(142,  'Martinica','MQ', 'Martinica.png', 'A');
INSERT INTO tb_paises VALUES(143,  'Mauricio','MU', 'Mauricio.png', 'A');
INSERT INTO tb_paises VALUES(144,  'Mauritania','MR', 'Mauritania.png', 'A');
INSERT INTO tb_paises VALUES(145,  'Mayotte','YT', 'Mayotte.png', 'A');
INSERT INTO tb_paises VALUES(146,  'México','MX', 'México.png', 'A');
INSERT INTO tb_paises VALUES(147,  'Micronesia','FM', 'Micronesia.png', 'A');
INSERT INTO tb_paises VALUES(148,  'Moldavia','MD', 'Moldavia.png', 'A');
INSERT INTO tb_paises VALUES(149,  'Mónaco','MC', 'Mónaco.png', 'A');
INSERT INTO tb_paises VALUES(150,  'Mongolia','MN', 'Mongolia.png', 'A');
INSERT INTO tb_paises VALUES(151,  'Montserrat','MS', 'Montserrat.png', 'A');
INSERT INTO tb_paises VALUES(152,  'Mozambique','MZ', 'Mozambique.png', 'A');
INSERT INTO tb_paises VALUES(153,  'Myanmar','MM', 'Myanmar.png', 'A');
INSERT INTO tb_paises VALUES(154,  'Namibia','NA', 'Namibia.png', 'A');
INSERT INTO tb_paises VALUES(155,  'Nauru','NR', 'Nauru.png', 'A');
INSERT INTO tb_paises VALUES(156,  'Nepal','NP', 'Nepal.png', 'A');
INSERT INTO tb_paises VALUES(157,  'Nicaragua','NI', 'Nicaragua.png', 'A');
INSERT INTO tb_paises VALUES(158,  'Níger','NE', 'Níger.png', 'A');
INSERT INTO tb_paises VALUES(159,  'Nigeria','NG', 'Nigeria.png', 'A');
INSERT INTO tb_paises VALUES(160,  'Niue','NU', 'Niue.png', 'A');
INSERT INTO tb_paises VALUES(161,  'Isla Norfolk','NF', 'IslaNorfolk.png', 'A');
INSERT INTO tb_paises VALUES(162,  'Noruega','NO', 'Noruega.png', 'A');
INSERT INTO tb_paises VALUES(163,  'Nueva Caledonia','NC', 'NuevaCaledonia.png', 'A');
INSERT INTO tb_paises VALUES(164,  'Nueva Zelanda','NZ', 'NuevaZelanda.png', 'A');
INSERT INTO tb_paises VALUES(165,  'Omán','OM', 'Omán.png', 'A');
INSERT INTO tb_paises VALUES(166,  'Países Bajos','NL', 'Países.png', 'A');
INSERT INTO tb_paises VALUES(167,  'Pakistán','PK', 'Pakistán.png', 'A');
INSERT INTO tb_paises VALUES(168,  'Palau','PW', 'Palau.png', 'A');
INSERT INTO tb_paises VALUES(169,  'Palestina','PS', 'Palestina.png', 'A');
INSERT INTO tb_paises VALUES(170,  'Panamá','PA', 'Panamá.png', 'A');
INSERT INTO tb_paises VALUES(171,  'Papúa Nueva Guinea','PG', 'Papúa.png', 'A');
INSERT INTO tb_paises VALUES(172,  'Paraguay','PY', 'Paraguay.png', 'A');
INSERT INTO tb_paises VALUES(173,  'Perú','PE', 'Perú.png', 'A');
INSERT INTO tb_paises VALUES(174,  'Islas Pitcairn','PN', 'Islas.png', 'A');
INSERT INTO tb_paises VALUES(175,  'Polinesia Francesa','PF', 'Polinesia.png', 'A');
INSERT INTO tb_paises VALUES(176,  'Polonia','PL', 'Polonia.png', 'A');
INSERT INTO tb_paises VALUES(177,  'Portugal','PT', 'Portugal.png', 'A');
INSERT INTO tb_paises VALUES(178,  'Puerto Rico','PR', 'PuertoRico.png', 'A');
INSERT INTO tb_paises VALUES(179,  'Qatar','QA', 'Qatar.png', 'A');
INSERT INTO tb_paises VALUES(180,  'Reino Unido','GB', 'ReinoUnido.png', 'A');
INSERT INTO tb_paises VALUES(181,  'Reunión','RE', 'Reunión.png', 'A');
INSERT INTO tb_paises VALUES(182,  'Ruanda','RW', 'Ruanda.png', 'A');
INSERT INTO tb_paises VALUES(183,  'Rumania','RO', 'Rumania.png', 'A');
INSERT INTO tb_paises VALUES(184,  'Rusia','RU', 'Rusia.png', 'A');
INSERT INTO tb_paises VALUES(185,  'Sahara Occidental','EH', 'SaharaOccidental.png', 'A');
INSERT INTO tb_paises VALUES(186,  'Islas Salomón','SB', 'IslasSalomón.png', 'A');
INSERT INTO tb_paises VALUES(187,  'Samoa','WS', 'Samoa.png', 'A');
INSERT INTO tb_paises VALUES(188,  'Samoa Americana','AS', 'SamoaAmericana.png', 'A');
INSERT INTO tb_paises VALUES(189,  'San Cristóbal y Nevis','KN', 'SanCristóbalyNevis.png', 'A');
INSERT INTO tb_paises VALUES(190,  'San Marino','SM', 'SanMarino.png', 'A');
INSERT INTO tb_paises VALUES(191,  'San Pedro y Miquelón','PM', 'SanPedroyMiquelón.png', 'A');
INSERT INTO tb_paises VALUES(192,  'San Vicente y las Granadinas','VC', 'SanVicenteylasGranadinas.png', 'A');
INSERT INTO tb_paises VALUES(193,  'Santa Helena','SH', 'SantaHelena.png', 'A');
INSERT INTO tb_paises VALUES(194,  'Santa Lucía','LC', 'SantaLucía.png', 'A');
INSERT INTO tb_paises VALUES(195,  'Santo Tomé y Príncipe','ST', 'SantoToméyPríncipe.png', 'A');
INSERT INTO tb_paises VALUES(196,  'Senegal','SN', 'Senegal.png', 'A');
INSERT INTO tb_paises VALUES(197,  'Serbia y Montenegro','CS', 'SerbiayMontenegro.png', 'A');
INSERT INTO tb_paises VALUES(198,  'Seychelles','SC', 'Seychelles.png', 'A');
INSERT INTO tb_paises VALUES(199,  'Sierra Leona','SL', 'SierraLeona.png', 'A');
INSERT INTO tb_paises VALUES(200,  'Singapur','SG', 'Singapur.png', 'A');
INSERT INTO tb_paises VALUES(201,  'Siria','SY', 'Siria.png', 'A');
INSERT INTO tb_paises VALUES(202,  'Somalia','SO', 'Somalia.png', 'A');
INSERT INTO tb_paises VALUES(203,  'Sri Lanka','LK', 'SriLanka.png', 'A');
INSERT INTO tb_paises VALUES(204,  'Suazilandia','SZ', 'Suazilandia.png', 'A');
INSERT INTO tb_paises VALUES(205,  'Sudáfrica','ZA', 'Sudáfrica.png', 'A');
INSERT INTO tb_paises VALUES(206,  'Sudán','SD', 'Sudán.png', 'A');
INSERT INTO tb_paises VALUES(207,  'Suecia','SE', 'Suecia.png', 'A');
INSERT INTO tb_paises VALUES(208,  'Suiza','CH', 'Suiza.png', 'A');
INSERT INTO tb_paises VALUES(209,  'Surinam','SR', 'Surinam.png', 'A');
INSERT INTO tb_paises VALUES(210,  'Svalbard y Jan Mayen','SJ', 'SvalbardyJanMayen.png', 'A');
INSERT INTO tb_paises VALUES(211,  'Tailandia','TH', 'Tailandia.png', 'A');
INSERT INTO tb_paises VALUES(212,  'Taiwán','TW', 'Taiwán.png', 'A');
INSERT INTO tb_paises VALUES(213,  'Tanzania','TZ', 'Tanzania.png', 'A');
INSERT INTO tb_paises VALUES(214,  'Tayikistán','TJ', 'Tayikistán.png', 'A');
INSERT INTO tb_paises VALUES(215,  'Territorio Británico del Océano Índico','IO', 'TerritorioBritánicodelOcéanoÍndico.png', 'A');
INSERT INTO tb_paises VALUES(216,  'Territorios Australes Franceses','TF', 'TerritoriosAustralesFranceses.png', 'A');
INSERT INTO tb_paises VALUES(217,  'Timor Oriental','TL', 'TimorOriental.png', 'A');
INSERT INTO tb_paises VALUES(218,  'Togo','TG', 'Togo.png', 'A');
INSERT INTO tb_paises VALUES(219,  'Tokelau','TK', 'Tokelau.png', 'A');
INSERT INTO tb_paises VALUES(220,  'Tonga','TO', 'Tonga.png', 'A');
INSERT INTO tb_paises VALUES(221,  'Trinidad y Tobago','TT', 'TrinidadyTobago.png', 'A');
INSERT INTO tb_paises VALUES(222,  'Túnez','TN', 'Túnez.png', 'A');
INSERT INTO tb_paises VALUES(223,  'Islas Turcas y Caicos','TC', 'IslasTurcasyCaicos.png', 'A');
INSERT INTO tb_paises VALUES(224,  'Turkmenistán','TM', 'Turkmenistán.png', 'A');
INSERT INTO tb_paises VALUES(225,  'Turquía','TR', 'Turquía.png', 'A');
INSERT INTO tb_paises VALUES(226,  'Tuvalu','TV', 'Tuvalu.png', 'A');
INSERT INTO tb_paises VALUES(227,  'Ucrania','UA', 'Ucrania.png', 'A');
INSERT INTO tb_paises VALUES(228,  'Uganda','UG', 'Uganda.png', 'A');
INSERT INTO tb_paises VALUES(229,  'Uruguay','UY', 'Uruguay.png', 'A');
INSERT INTO tb_paises VALUES(230,  'Uzbekistán','UZ', 'Uzbekistán.png', 'A');
INSERT INTO tb_paises VALUES(231,  'Vanuatu','VU', 'Vanuatu.png', 'A');
INSERT INTO tb_paises VALUES(232,  'Venezuela','VE', 'Venezuela.png', 'A');
INSERT INTO tb_paises VALUES(233,  'Vietnam','VN', 'Vietnam.png', 'A');
INSERT INTO tb_paises VALUES(234,  'Islas Vírgenes Británicas','VG', 'IslasVírgenesBritánicas.png', 'A');
INSERT INTO tb_paises VALUES(235,  'Islas Vírgenes de los Estados Unidos','VI', 'IslasVírgenesdelosEstadosUnidos.png', 'A');
INSERT INTO tb_paises VALUES(236,  'Wallis y Futuna','WF', 'Wallis.png', 'A');
INSERT INTO tb_paises VALUES(237,  'Yemen','YE', 'Yemen.png', 'A');
INSERT INTO tb_paises VALUES(238,  'Yibuti','DJ', 'Yibuti.png', 'A');
INSERT INTO tb_paises VALUES(239,  'Zambia','ZM', 'Zambia.png', 'A');
INSERT INTO tb_paises VALUES(240,  'Zimbabue','ZW', 'Zimbabue.png', 'A');

/*---------------- fin tb paises ----------------------------------*/


/*------------------- tb_idiomas -----------------------------------*/

INSERT INTO tb_idiomas VALUES(1, 'Español', 'Es', 'colombia_64.png', 'A');
INSERT INTO tb_idiomas VALUES(2, 'English', 'En', 'united_states_of_america_64.png', 'A');

/*------------------- fin tb_idiomas --------------------------------*/