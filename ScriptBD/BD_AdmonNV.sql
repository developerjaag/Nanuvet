CREATE database AAAadmonNanuVet DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

use AAAadmonNanuVet;


/*tabla para las solicitudes de recuperar contraseña*/
create table if not exists tb_recuperarPass(

	idRecuperarPass				int unsigned auto_increment,
    titular						varchar(100),
    correoIngresado				varchar(300),
    idUsuarioEncontrado			int,
    correoUsuarioEncontrado 	varchar(300),
    token						varchar(300),
    estado						enum('A','Usado'),
    fechaSolicitud				date,
    
    primary key(idRecuperarPass)
    

);
/*------------*/

/*Tabla para almacenar el listado de los clientes*/
create table if not exists tb_listadoClienteNV(

 idListadoClienteNV					int auto_increment,
 identificacion						varchar(30) not null,
 nombre								varchar(100) not null,
 nombrePersonaContacto				varchar(100) not null,
 direccion							varchar(100) not null,
 telefono1							varchar(20) not null,
 telefono2							varchar(20),
 celular							varchar(30) not null,
 email								varchar(100) not null,
 nombrePais							varchar(50) not null,
 nombreCiudad						varchar(50) not null,
 cantidadLicencias					int unsigned not null,
 fechaInicio						date,
 fechaRetiro						date,
 ubicacion_BD						varchar(50) not null,
 usuario_BD							varchar(50) not null,
 pass_BD							varchar(50) not null,
 nombre_BD							varchar(50) not null,
 estado								enum('A','I'),
 demo								enum('No','Si') default 'No',
 
 primary key (idListadoClienteNV)

);
/*---*/



/*Tabla para relacionar licencias con un cliente*/
create table if not exists tb_licencias(

 idLicencia				int auto_increment,
 fechaAdquisicion		date,
 fechaInicio			date,
 fechaFin				date,
 observacion			varchar(300),
 estado					enum('EnUso','Disponible'),
 idListadoClienteNV		int,
 
 primary key (idLicencia),
 
 foreign key (idListadoClienteNV) references tb_listadoClienteNV (idListadoClienteNV)

);
/*---*/