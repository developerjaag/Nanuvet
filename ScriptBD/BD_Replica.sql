CREATE database `AAAReplica` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

use AAAReplica;




/*Tabla para almacenar los paises*/
create table if not exists tb_paises(

 idPais			int auto_increment,
 nombre			varchar(100) not null,
 abreviatura	varchar(2) not null,
 urlBandera		varchar(300) not null,
 estado			enum('A','I'),
 
 primary key (idPais)

);
/*----------------------*/




/*Tabla que almacena los propietarios*/
create table if not exists tb_propietarios(

 idPropietario			int auto_increment,
 identificacion			varchar(30) not null,
 nombre					varchar(100) not null,
 apellido				varchar(100) not null,
 telefono				varchar(20),
 celular				varchar(20) not null,
 direccion				varchar(50),
 email					varchar(100) not null,
 idPais					int,
 estado					enum('A','I'),
 fechaRegistro			datetime,
 
 primary key (idPropietario),
 
 foreign key (idPais) 		references tb_paises (idPais)

);
/*---------------*/


/*Tabla para almacenar las especies*/
create table if not exists tb_especies(

 idEspecie		int auto_increment,
 nombre			varchar(100) not null,
 descripcion	varchar(300),
 estado			enum('A','I'),
 
 primary key (idEspecie)

);
/*---------------*/


/*tabla para las razas*/
create table if not exists tb_razas(

 idRaza			int auto_increment,
 nombre			varchar(100) not null,
 descripcion	varchar(300),
 estado			enum('A','I'),
 idEspecie		int,
 
 primary key (idRaza),
 
 foreign key (idEspecie) references tb_especies (idEspecie)

);
/*---------------*/



/*tabla para almacenar los datos de las mascotas*/
create table if not exists tb_mascotas(

 idMascota				int auto_increment,
 nombre					varchar(50) not null,
 numeroChip				varchar(50),
 sexo					enum('M','H'),
 esterilizado			enum('Si','No'),
 color					varchar(100),
 fechaNacimiento		date,
 urlFoto				varchar(300),
 estado					enum('vivo','muerto'),
 alimento				varchar(50),
 frecuenciaDiaria		int,
 cantidadComidaGramos	varchar(10),
 frecuenciaBanoDias		int,
 idPropietario			int,
 idRaza					int,
 idEspecie				int,
 
 primary key (idMascota),
 
 foreign key (idPropietario) 	references tb_propietarios (idPropietario)
 
);
/*---------------*/


/*tabla para los desparasitantes*/
create table if not exists tb_desparasitantes (

 idDesparasitante				int auto_increment,
 fecha							date,
 hora							time,
 fechaProximoDesparasitante		date,
 nombre							varchar(100),
 dosificacion					varchar(100),
 observaciones					text,
 estado							enum('A','I'),
 idMascota						int,
 
 primary key (idDesparasitante),
 
 foreign key (idMascota) references tb_mascotas (idMascota)

);
/*----------------*/


/*Tabla para registrar las vacunas de las mascotas*/
create table if not exists tb_mascotas_vacunas(

 idMascotaVacunas			int auto_increment,
 fecha						date,
 hora						time,
 fechaProximaVacuna			date,
 observaciones				text,
 estado						enum('A','I'),
 nombreVacuna				varchar(100) not null,
 descripcionVacuna			varchar(200),
 idMascota					int,
 usuario					varchar(200),
 nombreSucursal				varchar(300),
 
 primary key (idMascotaVacunas),
 
 foreign key (idMascota) references tb_mascotas (idMascota)
 
);
/*---------------*/


/*tabla para las citas que tenga la mascota*/
create table if not exists tb_citas(

 idCita				int auto_increment,
 fecha				date,
 horaInicio			time,
 horaFin			time,
 estado				enum('Asignada','inasistida','Cancelada','Atendida'),
 observaciones		text,
 tipoCita			varchar(100),
 direccion			varchar(50),
 latitud			varchar(100),
 longitud			varchar(100),
 usuario			varchar(200),
 idMascota			int,
 
 primary key (idCita),
 
 foreign key (idMascota) references tb_mascotas (idMascota)

);
/*---------------*/


/*Para almacenar las formulas*/
create table if not exists tb_formulas(

 idFormula			int auto_increment,
 fecha				date,
 hora				time,
 observaciones		text,
 usuario			varchar(200) not null,
 nombreSucursal		varchar(100) not null,
 idMascota			int,
 
 primary key (idFormula),

 foreign key (idMascota) references tb_mascotas (idMascota)

);
/*---------------*/



/*Detalle d ela formula*/
create table if not exists tb_medicamentosFormula(

 idMedicamentoFormula		int auto_increment,
 nombreMedicamento			varchar(100) not null,
 via						varchar(20) not null,
 cantidad					int,
 frecuencia					varchar(20) not null,
 dosificacion				varchar(50) not null,
 observacion				text,
 idFormula					int,
 
 primary key (idMedicamentoFormula),
 
 foreign key (idFormula) references tb_formulas (idFormula)
 

);
/*---------------*/


/*tabla para almacenar los examenes de las mascotas*/
create table if not exists tb_examenes(

 idExamen			int auto_increment,
 fecha				date,
 hora				time,
 observaciones		text,
 usuario			varchar(200) not null,
 nombreSucursal		varchar(100) not null,
 idMascota			int, 
 
 primary key (idExamen),
 
 foreign key (idMascota) references tb_mascotas (idMascota) 

);
/*---------------*/


/*Tabla para el detalle de los examenes*/
create table if not exists tb_examenDetalle(

 idExamenDetalle		int auto_increment,
 nombre					varchar(100) not null,
 descripcion			text,
 observacion			text,
 idExamen				int,
 
 primary key (idExamenDetalle),
 
 foreign key (idExamen) references tb_examenes (idExamen)

);
/*---------------*/



/*tabla para los resultados de los examens*/
create table if not exists tb_resultadoExamen(

 idresultadoExamen		int auto_increment,
 fecha					date,
 hora					time,
 general				enum('Bueno','Regular','Malo'),
 observaciones			text,
 usuario				varchar(200) not null,
 nombreClinica			varchar(100) not null,
 nombreSucursal			varchar(100) not null,
 estado					enum('Visto','Pendiente'),
 idExamenDetalle		int,
 
 primary key (idresultadoExamen),
 
 foreign key (idExamenDetalle) references tb_examenDetalle (idExamenDetalle)

);



/*Tabla para almacenar los antigarrabaptas y antipulgas*/
create table if not exists tb_antiPulgasGarrapatas(

 idAntiPulgasGarrapatas			int auto_increment,
 fecha							date,
 nombreProducto					varchar(100) not null,
 observaciones					varchar(300),
 fechaProximaAplicacion			date,
 estadoAlertaAplicacion			enum('Visto','Pendiente'),
 idMascota						int,
 
 primary key (idAntiPulgasGarrapatas),
 
 foreign key (idMascota) references tb_mascotas (idMascota) 

);

create table if not exists tb_consultas(

 idConsulta			int auto_increment,
 fecha				date,
 hora				time,
 motivo				text,
 observaciones		text,
 planASeguir		text,
 edadActualMascota	varchar(50),
 medico				varchar(200),
 nombreSucursal		varchar(300),
 idMascota			int,
 
 primary key (idConsulta)

);


create table if not exists tb_diagnosticosConsulta(

 idDiagnosticoConsulta		int auto_increment,
 descripcion				varchar(200),
 nombreDiagnostico			varchar(300),
 idConsulta					int,
 
 primary key (idDiagnosticoConsulta)

);


create table if not exists tb_cirugias(

 idCirugia			int auto_increment,
 fecha				date,
 hora				time,
 fechaFin			date,
 horaFin			time,
 tipoAnestesia		enum('General','Local','NA'),
 motivo				text,
 complicaciones		text,
 observaciones		text,
 planASeguir		text,
 edadActualMascota	varchar(50),
 medico				varchar(200),
 nombreSucursal		varchar(300),
 idMascota			int,

  primary key (idCirugia)
);


create table if not exists tb_diagnosticosCirugias(

 idDiagnosticoCirugia		int auto_increment,
 descripcion				varchar(200),
 nombreDiagnostico			varchar(300),
 idCirugia					int,
 
 primary key (idDiagnosticoCirugia)

);


create table if not exists tb_examenFisico(

   idExamenFisico      int auto_increment,
   peso                varchar(20),
   medidaCm            varchar(20),
   temperatura         varchar(10),
   observaciones       text,
   idConsulta          int,
   
   primary key (idExamenFisico)
  
);


CREATE TABLE IF NOT EXISTS tb_itemsExamenFisico (
    idItiemExamenFisico INT AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    observacion TEXT,
    estadoRevision ENUM('B', 'R', 'M', 'NA'),
    idExamenFisico INT,
    PRIMARY KEY (idItiemExamenFisico)

);


















