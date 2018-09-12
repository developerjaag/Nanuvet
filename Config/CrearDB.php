<?php

/**
 * Archivo utilizado para crear una nueva base de datos automaticamente
 * */
 
 //se importa el archivo config para las conexiones
 //require_once("config.php");
 
 //se crea una clase para interactuar con las bases de datos
 class crearBD extends Config{
  
  	  //aqui se almacena la conexón para crear la BD
  	  protected $pdo;
  
      //atributos para la conexion
      private $servidor;
      private $usuario;
      private $pass;
      private $bd;
      
     //constructor para inicializar los parametros de la clase
     function __construct($servidor, $usuario, $pass, $bd) {
       
       $this->servidor = $servidor;
       $this->usuario  = $usuario;
       $this->pass     = $pass;
       $this->bd       = $bd;
       //conexión para permitir crear la BD
	   $this->pdo = new PDO("mysql:host=".$servidor.";", $usuario, $pass);
       
     }//fin contructor
     
     
     //metodo que devuelve la conexión a la base de datos para ejecutar los insert
     private function conexionNuevaBD(){
      
   		$link = mysqli_connect($this->servidor,$this->usuario,$this->pass,$this->bd) or die("Error en la conexión de la nueva BD" . mysqli_error($link));
 		$link->query("SET NAMES 'utf8'");
 		return $link;
      
      
     }//fin metodo conexionNuevaBD
     
     //metodo para escapar parametros para la base nueva base de datos
     private function escaparQueryNuevaBD($parametro){
        
        $conexion = $this->conexionNuevaBD();
        
        $parametro = $conexion->real_escape_string($parametro);
        
        return $parametro;
     }
          
     //metodo para crear la base de datos y sus tablas
     public function crearBDCLiente(){
         
         
         //se crea la base de datos
         $crear_db = $this->pdo->prepare("CREATE DATABASE IF NOT EXISTS $this->bd DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");							  
      		 $crear_db->execute();
      		 
      		 //decimos que queremos usar la base de datos que acabamos de crear
      		if($crear_db):
          		$use_db = $this->pdo->prepare("USE $this->bd");						  
          		$use_db->execute();
      		endif;
      		
      		//si se ha creado la base de datos y estamos en uso de ella creamos las tablas
      		if($use_db):
		    
		    //se inicia la creación de las tablas
		    
		    
  		    
      		    /*Almacena los paises*/
      		    $tb_paises = $this->pdo->prepare("create table if not exists tb_paises(
      
                                                               idPais         int auto_increment,
                                                               nombre         varchar(100) not null,
                                                               abreviatura    varchar(2),
                                                               urlBandera     varchar(300),
                                                               estado         enum('A','I'),
                                                               
                                                               primary key(idPais)
                                                          
                                                          );");							
      		    $tb_paises->execute();
      //--------------------------------------------------------------------------------------		    
      
      
      
      		    /*tabla para las ciudades*/
      		    $tb_ciudades = $this->pdo->prepare("create table if not exists tb_ciudades(
      
                                                           idCiudad       int auto_increment,
                                                           nombre         varchar(100) not null,
                                                           idPais         int,
                                                           estado         enum('A','I'),
                                                           
                                                           primary key (idCiudad),
                                                           
                                                           foreign key (idPais) references tb_paises (idPais)
                                                      );");							
      		    $tb_ciudades->execute();
      //--------------------------------------------------------------------------------------	
      
      
      
      		    /*Tabla para los barrios*/
      		    $tb_barrios = $this->pdo->prepare("create table if not exists tb_barrios(
          
                                                           idBarrio       int auto_increment,
                                                           nombre         varchar(100) not null,
                                                           idCiudad       int,
                                                           estado         enum('A','I'),
                                                           
                                                           primary key (idBarrio),
                                                           
                                                           foreign key (idCiudad) references tb_ciudades (idCiudad)
                                                      
                                                      );");							
      		    $tb_barrios->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Tabla para la clinica o nombre del establecimiento*/
      		    $tb_clinica = $this->pdo->prepare("create table if not exists tb_clinica(
      
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
                                                  
                                                  );");							
      		    $tb_clinica->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Tabla para las sucursales*/
      		    $tb_sucursales = $this->pdo->prepare("create table if not exists tb_sucursales(
                                                  
                                                       idSucursal                 int auto_increment,
                                                       identificativoNit          varchar(50) not null,
                                                       nombre                     varchar(100) not null,
                                                       telefono1                  varchar(20) not null,
                                                       telefono2                  varchar(20),
                                                       celular                    varchar(20) not null,
                                                       direccion                  varchar(50) not null,
                                                       longitud					  varchar(100),
													   latitud					  varchar(100),
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
                                                  
                                                  );");							
      		    $tb_sucursales->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Para almacenar las configuraciones por defecto*/
      		    $tb_configuraciones = $this->pdo->prepare("create table if not exists tb_configuraciones(
      
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
                                                      
                                                      );");							
      		    $tb_configuraciones->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Para vincular las configuraciones con una sucursal en particula*/
      		    $tb_sucursales_configuraciones = $this->pdo->prepare("create table if not exists tb_sucursales_configuraciones(
      
                                                               idSucursalConfiguracion    int auto_increment,
                                                               estado                     enum('A','I'),
                                                               idSucursal                 int,
                                                               idconfiguracion            int,
                                                               
                                                               primary key (idSucursalConfiguracion),
                                                               
                                                               foreign key (idSucursal)       references tb_sucursales (idSucursal),
                                                               foreign key (idconfiguracion)  references tb_configuraciones(idconfiguracion)
                                                          
                                                          );");							
      		    $tb_sucursales_configuraciones->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Para almacenar los idiomas*/
      		    $tb_idiomas = $this->pdo->prepare("create table if not exists tb_idiomas(
      
                                                       idIdioma       int auto_increment,
                                                       nombre         varchar(100) not null,
                                                       urlArchivo     varchar(300) not null,
                                                       urlBandera     varchar(300) not null,
                                                       estado         enum('A','I'),
                                                       
                                                       primary key (idIdioma)
                                                  
                                                  );");							
      		    $tb_idiomas->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Para almacenar los usuarios*/
      		    $tb_usuarios = $this->pdo->prepare("create table if not exists tb_usuarios(
      
      
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
                                                        idLicencia				int,
                                                        
                                                        primary key (idUsuario),
                                                        
                                                        foreign key (idIdioma) references tb_idiomas (idIdioma)
                                                  
                                                  );");							
      		    $tb_usuarios->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*Para almacenar los permisos que se le pueden asignar a un usuario*/
      		    $tb_permisos = $this->pdo->prepare("create table if not exists tb_permisos(
      
                                                            idPermiso          int auto_increment,
                                                            nombre             varchar(100),
                                                            descripcion        varchar(200),
                                                            
                                                            primary key (idPermiso)
                                                      
                                                      );");							
      		    $tb_permisos->execute();
      //--------------------------------------------------------------------------------------		
      
      
      
      		    /*relaciona los permisos con los usuarios*/
      		    $tb_permisos_usuarios = $this->pdo->prepare("create table if not exists tb_permisos_usuarios(
      
                                                                    idPermisoUsuario    int auto_increment,
                                                                    idPermiso           int,
                                                                    idUsuario           int,
                                                                    estado              enum('A','I'),
                                                                    
                                                                    primary key (idPermisoUsuario),
                                                                    
                                                                    foreign key (idPermiso) references tb_permisos (idPermiso),
                                                                    foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                              
                                                              );");							
      		    $tb_permisos_usuarios->execute();
      //--------------------------------------------------------------------------------------			
      		
      
      
      
      		    /*se almacenan las especialidades*/
      		    $tb_especialidades = $this->pdo->prepare("create table if not exists tb_especialidades(
      
                                                               idEspecialidad          int auto_increment,
                                                               nombre                  varchar(50) not null,
                                                               descripcion             varchar(300),
                                                               estado                  enum('A','I'),
                                                               
                                                               primary key (idEspecialidad)
                                                              
                                                              );");							
      		    $tb_especialidades->execute();
      //--------------------------------------------------------------------------------------		
      		
      
      
      
      		    /*Se relacionan las especialidades con los usuarios*/
      		    $tb_especialidades_usuario = $this->pdo->prepare("create table if not exists tb_especialidades_usuario(
      
                                                                   idEspecialidadUsuario        int auto_increment, 
                                                                   idEspecialidad               int,
                                                                   idUsuario                    int,
                                                                   
                                                                   primary key (idEspecialidadUsuario),
                                                                   
                                                                   foreign key (idEspecialidad) references tb_especialidades (idEspecialidad),
                                                                   foreign key (idUsuario)      references tb_usuarios (idUsuario)
                                                                  
                                                                  
                                                                  );");							
      		    $tb_especialidades_usuario->execute();
      //--------------------------------------------------------------------------------------			
      		
      
      
      
      		    /*Se relaciona un usuario con una sucursal*/
      		    $tb_usuarios_sucursal = $this->pdo->prepare("create table if not exists tb_usuarios_sucursal(
      
                                                               idUsuarioSucursal       int auto_increment,
                                                               idSucursal              int,
                                                               idUsuario               int,
                                                               estado                  enum('A','I'),
                                                               porDefecto              enum('Si','No') DEFAULT 'No',
                                                               enUso	               enum('Si','No') DEFAULT 'No',
                                                               
                                                               primary key (idUsuarioSucursal),
                                                               
                                                               foreign key (idSucursal) references tb_sucursales (idSucursal),
                                                               foreign key (idUsuario)  references tb_usuarios (idUsuario)
                                                              
                                                              );");							
      		    $tb_usuarios_sucursal->execute();
      //--------------------------------------------------------------------------------------
      		
      
      
      
      		    /*Se almacenana todos los tutoriales a modo de intro*/
      		    $tb_introTutorial = $this->pdo->prepare("create table if not exists tb_introTutorial(
      
                                                           idIntroTutorial     int auto_increment,
                                                           nombre              varchar(50) not null,
                                                           
                                                           primary key (idIntroTutorial)
                                                          
                                                          );");							
      		    $tb_introTutorial->execute();
      //--------------------------------------------------------------------------------------
      		
      
      
      
      		    /*Se relaciona un usuario con un introTutorial y el estado en que se encuentre*/
      		    $tb_usuario_introTutorial = $this->pdo->prepare(" create table if not exists tb_usuario_introTutorial(

                                                                     idUsuarioIntroTutorial       int auto_increment,
                                                                     idIntroTutorial              int,
                                                                     idUsuario                    int,
                                                                     estado                       enum('A','I'),
                                                                     
                                                                     primary key (idUsuarioIntroTutorial),
                                                                     
                                                                     foreign key (idUsuario) references tb_usuarios (idUsuario),
                                                                     foreign key (idIntroTutorial) references tb_introTutorial (idIntroTutorial)

                                                                    );");							
      		    $tb_usuario_introTutorial->execute();
      //--------------------------------------------------------------------------------------		
      		
      
      
      
      		    /*Se alamacenanan los horarios de un usuario*/
      		    $tb_agendaHorarioUsuario = $this->pdo->prepare(" create table if not exists tb_agendaHorarioUsuario(
      
                                                                   idAgendaHorarioUsuario       int auto_increment,
                                                                   horaInicio                   time,
                                                                   horaFin                      time,
                                                                   numeroDia                    int not null,
                                                                   estado                       enum('A','I'),
                                                                   idUsuario                    int,
                                                                   
                                                                   primary key (idAgendaHorarioUsuario),
                                                                   
                                                                   foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                                  
                                                                  );");							
      		    $tb_agendaHorarioUsuario->execute();
      //--------------------------------------------------------------------------------------		
      		
      
      
      
      		    /*Se almacenan los horarios por fehas de un usurio*/
      		    $tb_agendaHorarioFechaUsuario = $this->pdo->prepare("create table if not exists tb_agendaHorarioFechaUsuario(
      
                                                                       idAgendaHorarioFechaUsuario    int auto_increment,
                                                                       horaInicio                     time,
                                                                       horaFin                        time,
                                                                       fecha                          date,
                                                                       estado                         enum('A','I'),
                                                                       idUsuario                      int,
                                                                       
                                                                       primary key (idAgendaHorarioFechaUsuario),
                                                                       
                                                                       foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                                       
                                                                      
                                                                      );");							
      		    $tb_agendaHorarioFechaUsuario->execute();
      //--------------------------------------------------------------------------------------	
      		
      
      
      
      		    /*Se guardan los recesos de los usuarios*/
      		    $tb_agendaRecesosUsuario = $this->pdo->prepare("create table if not exists tb_agendaRecesosUsuario (
      
                                                                   idAgendaRecesosUsuario     int auto_increment,
                                                                   numeroDia                  int not null,
                                                                   idUsuario                  int,
                                                                   
                                                                   primary key (idAgendaRecesosUsuario),
                                                                   
                                                                   foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                                  
                                                                  );");							
      		    $tb_agendaRecesosUsuario->execute();
      //--------------------------------------------------------------------------------------	
      		
      
      
      
      		    /*Se almacenan los horarios de los recesos*/
      		    $tb_agendaHorarioReceso = $this->pdo->prepare("create table if not exists tb_agendaHorarioReceso(
      
                                                               idAgendaHorarioReceso          int auto_increment,
                                                               horaInicio                     time,
                                                               horaFin                        time,
                                                               estado                         enum('A','I'),
                                                               idAgendaRecesosUsuario         int,
                                                               
                                                               primary key (idAgendaHorarioReceso),
                                                               
                                                               foreign key (idAgendaRecesosUsuario) references tb_agendaRecesosUsuario (idAgendaRecesosUsuario)
                                                              
                                                              );");							
      		    $tb_agendaHorarioReceso->execute();
      //--------------------------------------------------------------------------------------	
      		
      
      
      
      		    /*Se almacena los recesos por fecha */
      		    $tb_agendaRecesosFechaUsuario = $this->pdo->prepare("create table if not exists tb_agendaRecesosFechaUsuario(
      
                                                                       idAgendaRecesosFechaUsuario    int auto_increment,
                                                                       fecha                          date,
                                                                       idUsuario                      int,
                                                                       
                                                                       primary key (idAgendaRecesosFechaUsuario)
                                                                      
                                                                      );");							
      		    $tb_agendaRecesosFechaUsuario->execute();
      //--------------------------------------------------------------------------------------	
      		
      
      
      
      		    /*Se almacenan los horarios de los recesesos por fecha*/
      		    $tb_agendaHorarioRecesoFecha = $this->pdo->prepare("create table if not exists tb_agendaHorarioRecesoFecha(
      
                                                                       idAgendaHorarioRecesoFecha     int auto_increment,
                                                                       horaInicio                     time,
                                                                       horaFin                        time,
                                                                       estado                         enum('A','I'),
                                                                       idAgendaRecesosFechaUsuario    int,
                                                                       
                                                                       primary key (idAgendaHorarioRecesoFecha),
                                                                       
                                                                       foreign key (idAgendaRecesosFechaUsuario) references tb_agendaRecesosFechaUsuario (idAgendaRecesosFechaUsuario)
                                                                      
                                                                      );");							
      		    $tb_agendaHorarioRecesoFecha->execute();
      //--------------------------------------------------------------------------------------	
      		
      
      
      
      		    /*Para saber que logs se almacenan*/
      		    $tb_logs = $this->pdo->prepare("create table if not exists tb_logs(
      
                                                   idLog          int auto_increment,
                                                   descripcion    varchar(300) not null,
                                                   
                                                   primary key (idLog)
                                                  
                                                  );");							
      		    $tb_logs->execute();
      //--------------------------------------------------------------------------------------
      		
      
      
      
      		    /*Se registran los logs por usuarios*/
      		    $tb_logs_usuario = $this->pdo->prepare("create table if not exists tb_logs_usuario(
      
                                                           idLogUsuario      int auto_increment,
                                                           idElemento        varchar(20) not null,
                                                           fecha             date,
                                                           hora              time,
                                                           idLog             int,
                                                           idUsuario         int,
                                                           
                                                           primary key (idLogUsuario),
                                                           
                                                           foreign key (idLog) references tb_logs (idLog),
                                                           foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                          
                                                          );");							
      		    $tb_logs_usuario->execute();
      //--------------------------------------------------------------------------------------
      		
      
      
      
      		    /*Almacena los propietarios*/
      		    $tb_propietarios = $this->pdo->prepare("create table if not exists tb_propietarios(
      
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
                                                          
                                                          );");							
      		    $tb_propietarios->execute();
      //--------------------------------------------------------------------------------------	
      	
      		
      
      
      
      		    /*Almacena las especies de animales*/
      		    $tb_especies = $this->pdo->prepare("create table if not exists tb_especies(
      
                                                       idEspecie      int auto_increment,
                                                       nombre         varchar(100) not null,
                                                       descripcion    varchar(300),
                                                       estado         enum('A','I'),
                                                       
                                                       primary key (idEspecie)
                                                      
                                                      );");							
      		    $tb_especies->execute();
      //--------------------------------------------------------------------------------------
      	
      		
      
      
      
      		    /*Almacena las distintas razas*/
      		    $tb_razas = $this->pdo->prepare("create table if not exists tb_razas(
      
                                                   idRaza         int auto_increment,
                                                   nombre         varchar(100) not null,
                                                   descripcion    varchar(300),
                                                   estado         enum('A','I'),
                                                   idEspecie      int,
                                                   
                                                   primary key (idRaza),
                                                   
                                                   foreign key (idEspecie) references tb_especies (idEspecie)
                                                  
                                                  );");							
      		    $tb_razas->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Almacena las mascotas o pacientes*/
      		    $tb_mascotas = $this->pdo->prepare("create table if not exists tb_mascotas(
      
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
                                                       idReplica				  int DEFAULT 0,
                                                       
                                                       primary key (idMascota),
                                                       
                                                       foreign key (idPropietario) references  tb_propietarios (idPropietario),
                                                       foreign key (idRaza)        references  tb_razas (idRaza),
                                                       foreign key (idEspecie)     references  tb_especies  (idEspecie)
                                                       
                                                      
                                                      );");							
      		    $tb_mascotas->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Almacena los tipos de cita*/
      		    $tb_tiposCita = $this->pdo->prepare("create table if not exists tb_tiposCita(
      
                                                       idTipoCita     int auto_increment,
                                                       nombre         varchar(100) not null,
                                                       estado         enum('A','I'),
                                                       
                                                       primary key (idTipoCita)
                                                      
                                                      );");							
      		    $tb_tiposCita->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Se registran las citas*/
      		    $tb_agendaCitas = $this->pdo->prepare("create table if not exists tb_agendaCitas(
      
                                                       idAgendaCita           int auto_increment,
                                                       fecha                  date,
                                                       fechaFin               date,
                                                       horaInicio             time,
                                                       horaFin                time,
                                                       duracionHoras		  varchar(10),
                                                       duracionMinutos		  varchar(10),
                                                       estado                 enum('Asignada','inasistida','Cancelada','Atendida'),                                                                                                              
                                                       observaciones          text,
                                                       motivoCancelacion	  varchar(200),
                                                       idUsuarioCancela		  int,
                                                       idMascota              int,
                                                       idSucursal             int,
                                                       idTipoCita             int,
                                                       idPropietario		  int,
                                                       
                                                       primary key (idAgendaCita),
                                                       
                                                       foreign key (idMascota) references tb_mascotas (idMascota),
                                                       foreign key (idSucursal) references tb_sucursales (idSucursal),
                                                       foreign key (idPropietario) references tb_propietarios (idPropietario)
                                                       
                                                      
                                                      );");							
      		    $tb_agendaCitas->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Se vincula un usuario con una cita*/
      		    $tb_agendaCitas_usuarios = $this->pdo->prepare("create table if not exists tb_agendaCitas_usuarios(
      
                                                                   idAgendaCitasUsuarios      int auto_increment,
                                                                   idAgendaCita               int,
                                                                   idUsuario                  int,
                                                                   estado                     enum('A','I'),
                                                                   
                                                                   primary key (idAgendaCitasUsuarios),
                                                                   
                                                                   foreign key (idAgendaCita) references tb_agendaCitas (idAgendaCita),
                                                                   foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                                  
                                                                  );");							
      		    $tb_agendaCitas_usuarios->execute();
      //--------------------------------------------------------------------------------------		
      	
      	
      		
      
      
      
      		    /*Tabla para guardar las formulas*/
      		    $tb_formulas = $this->pdo->prepare("create table if not exists tb_formulas(
      
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
                                                      
                                                      );");							
      		    $tb_formulas->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Se almacena el listado de medicamentos que posteriormente pueden se rutilizados en una formula*/
      		    $tb_listadoMedicamentos = $this->pdo->prepare("create table if not exists tb_listadoMedicamentos(
      
                                                                   idMedicamento   int auto_increment,
                                                                   nombre          varchar(100) not null,
                                                                   codigo          varchar(20),
                                                                   observacion     varchar(300),
                                                                   estado          enum('A','I'),
                                                                   
                                                                   primary key (idMedicamento)
                                                                  
                                                                  );");							
      		    $tb_listadoMedicamentos->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Se relacionan los medicamentos en una formula*/
      		    $tb_medicamentosFormula = $this->pdo->prepare("create table if not exists tb_medicamentosFormula(
      
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
                                                                  
                                                                  );");							
      		    $tb_medicamentosFormula->execute();
      //--------------------------------------------------------------------------------------	
      	
      	
      		
      
      
      
      		    /*Se almacenan las cosnultas*/
      		    $tb_consultas = $this->pdo->prepare("create table if not exists tb_consultas (
      
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
                                                      
                                                      );");							
      		    $tb_consultas->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Encabezado de paneles para los diagnosticos de las consultas*/
      		    $tb_panelesConsulta = $this->pdo->prepare("create table if not exists tb_panelesConsulta(
      
                                                               idPanelConsulta    int auto_increment,
                                                               nombre             varchar(100) not null,
                                                               observacion        varchar(300),
                                                               estado             enum('A','I'),
                                                               
                                                               primary key (idPanelConsulta)
                                                              
                                                              );");							
      		    $tb_panelesConsulta->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se almacenan los diagnosticos por paneles*/
      		    $tb_panelDiagnosticoConsulta = $this->pdo->prepare("create table if not exists tb_panelDiagnosticoConsulta(
      
                                                                       idPanelDiagnosticoConsulta   int auto_increment,
                                                                       nombre                       varchar(100) not null,
                                                                       codigo                       varchar(10) not null,
                                                                       observacion                  varchar(300),
                                                                       estado                       enum('A','I'),
                                                                       idPanelConsulta              int,
                                                                      
                                                                       primary key (idPanelDiagnosticoConsulta),
                                                                      
                                                                       foreign key (idPanelConsulta) references tb_panelesConsulta (idPanelConsulta)
                                                                      
                                                                      );");							
      		    $tb_panelDiagnosticoConsulta->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*se almacenan los diagnosticos que se vinulan con una consulta*/
      		    $tb_consultas_diagnosticos = $this->pdo->prepare("create table if not exists tb_consultas_diagnosticos(
      
                                                                       idConsultaDiagnostico             int auto_increment,
                                                                       observacion                       varchar(200),
                                                                       idConsulta                        int,
                                                                       idPanelDiagnosticoConsulta        int,
                                                                      
                                                                       primary key (idConsultaDiagnostico),
                                                                       
                                                                       foreign key (idConsulta) references tb_consultas (idConsulta),
                                                                       foreign key (idPanelDiagnosticoConsulta) references tb_panelDiagnosticoConsulta(idPanelDiagnosticoConsulta)
                                                                      
                                                                      );");							
      		    $tb_consultas_diagnosticos->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se almacena el examen fisico que se realice en una consulta*/
      		    $tb_examenFisico = $this->pdo->prepare("create table if not exists tb_examenFisico(
      
                                                           idExamenFisico      int auto_increment,
                                                           peso                varchar(20),
                                                           medidaCm            varchar(20),
                                                           temperatura         varchar(10),
                                                           observaciones       text,
                                                           idConsulta          int,
                                                           
                                                           primary key (idExamenFisico),
                                                           
                                                           foreign key (idConsulta) references tb_consultas (idConsulta)
                                                          
                                                          );");							
      		    $tb_examenFisico->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se vinculan algunos items con el examen fisico*/
      		    $tb_itemsExamenFisico = $this->pdo->prepare("create table if not exists tb_itemsExamenFisico(
      
                                                               idItiemExamenFisico     int auto_increment,
                                                               nombre                  varchar(50) not null,
                                                               observacion             text,
                                                               estadoRevision          enum('B','R','M','NA'),
                                                               idExamenFisico          int,
                                                               
                                                               primary key (idItiemExamenFisico),
                                                               
                                                               foreign key (idExamenFisico) references tb_examenFisico (idExamenFisico)
                                                              
                                                              );");							
      		    $tb_itemsExamenFisico->execute();
      //--------------------------------------------------------------------------------------
      	
      	
       
      
      		    /*Se guardan las notas aclaratorias de una consulta*/
      		    $tb_consultasNotasAclaratorias = $this->pdo->prepare("create table if not exists tb_consultasNotasAclaratorias(
      
                                                                idConsultaNotaAclaratoria		int auto_increment,
																 texto							varchar(200) not null,
																 fecha							date,
																 hora							time,
																 idConsulta						int,
																 idUsuario						int,
																 
																 primary key (idConsultaNotaAclaratoria),
																 
																 foreign key (idConsulta) references tb_consultas (idConsulta),
																 foreign key (idUsuario) references tb_usuarios (idUsuario)
																
																);");							
      		    $tb_consultasNotasAclaratorias->execute();
      //--------------------------------------------------------------------------------------     		
      
      
      
      		    /*Se almacenan las vacunas para aplicar a los pacientes*/
      		    $tb_vacunas = $this->pdo->prepare("create table if not exists tb_vacunas(
      
                                                       idVacuna       int auto_increment,
                                                       nombre         varchar(100) not null,
                                                       descripcion    varchar(200),
                                                       estado         enum('A','I'),
                                                       
                                                       primary key (idVacuna)
                                                      
                                                      );");							
      		    $tb_vacunas->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se registran las vacunas que se le aplican a los pacientes*/
      		    $tb_mascotas_vacunas = $this->pdo->prepare("create table if not exists tb_mascotas_vacunas(
      
                                                               idMascotaVacunas         int auto_increment,
                                                               fecha                    date,
                                                               hora						time,
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
                                                              
                                                              );");							
      		    $tb_mascotas_vacunas->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se registran los espacios que pueden ser utilizados para guarderia*/
      		    $tb_espaciosGuarderia = $this->pdo->prepare("create table if not exists tb_espaciosGuarderia(
      
                                                               idEspacioGuarderia      int auto_increment,
                                                               nombre                  varchar(100) not null,
                                                               observacion             varchar(300),
                                                               capacidad               int not null,
                                                               espaciosOcupados        int not null,
                                                               estado                  enum('A','I'),
                                                               idSucursal              int,
                                                               
                                                               primary key (idEspacioGuarderia),
                                                               
                                                               foreign key (idSucursal) references tb_sucursales (idSucursal)
                                                              
                                                              );");							
      		    $tb_espaciosGuarderia->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se registra una mascota en un espacio de guarderia*/
      		    $tb_guarderia = $this->pdo->prepare("create table if not exists tb_guarderia(
      
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
                                                      
                                                      );");							
      		    $tb_guarderia->execute();
      //--------------------------------------------------------------------------------------
      	
      	
      		
      
      
      
      		    /*Se guardan las tareas de una guarderia o items que se realizan dentro de un cuidado en la guarderioa (como dar medicina o de comer a cierta hora)*/
      		    $tb_tareas_guarderia = $this->pdo->prepare("create table if not exists tb_tareas_guarderia(
      
                                                               idTareaGuarderia      int auto_increment,
                                                               hora                  time,
                                                               tarea                 varchar(300) not null,
                                                               estado                enum('realizado','pendiente'),
                                                               idGuarderia           int,
                                                               
                                                               primary key (idTareaGuarderia),
                                                               
                                                               foreign key (idGuarderia) references tb_guarderia (idGuarderia)
                                                              
                                                              );");							
      		    $tb_tareas_guarderia->execute();
      //--------------------------------------------------------------------------------------		
      	
      	
      		
      
      
      
      		    /*Guarada el listado de los examenes que se pueden realizar */
      		    $tb_listadoExamenes = $this->pdo->prepare("create table if not exists tb_listadoExamenes(
      
                                                       idListadoExamen      int auto_increment,
                                                       nombre               varchar(100) not null,
                                                       codigo               varchar(20),
                                                       precio               varchar(10) not null,
                                                       descripcion          text,
                                                       estado               enum('A','I'),
                                                       
                                                       primary key (idListadoExamen)
                                                      
                                                      );");							
      		    $tb_listadoExamenes->execute();
      //--------------------------------------------------------------------------------------				
      	
      	
      		
      
      
      
      		    /*Se guarda el encabezado de los examenes */
      		    $tb_examenes = $this->pdo->prepare("create table if not exists tb_examenes(
      
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
                                               
                                               );");							
      		    $tb_examenes->execute();
      //--------------------------------------------------------------------------------------				
      	
      	
      		
      
      
      
      		    /*Detalle del examen*/
      		    $tb_examenDetalle = $this->pdo->prepare("create table if not exists tb_examenDetalle(
      
                                                     idExamenDetalle      int auto_increment,
                                                     observacion          text,
                                                     idExamen             int,
                                                     idListadoExamen      int,
                                                     idExamenReplica	  int,
													 
                                                     primary key (idExamenDetalle),
                                                     
                                                     foreign key (idExamen) references tb_examenes (idExamen),
                                                     foreign key (idListadoExamen) references tb_listadoExamenes (idListadoExamen)
                                                    
                                                    );");							
      		    $tb_examenDetalle->execute();
      //--------------------------------------------------------------------------------------					
      
      	
      		
      
      
      
      		    /*Para registrar los resultados de los examenes*/
      		    $tb_resultadoExamen = $this->pdo->prepare("create table if not exists tb_resultadoExamen(
      
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
                                                      
                                                      );");							
      		    $tb_resultadoExamen->execute();
      //--------------------------------------------------------------------------------------				
      
      	
      		
      
      
      
      		    /*Se registran las cirugias practicadas a una mascota*/
      		    $tb_cirugias = $this->pdo->prepare("create table if not exists tb_cirugias(
      
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
                                               idUsuario				   int,	
                                               
                                               primary key (idCirugia),
                                               
                                               foreign key (idMascota) references tb_mascotas (idMascota),
                                               foreign key (idSucursal) references tb_sucursales (idSucursal),
                                               foreign key (idUsuario) references tb_usuarios (idUsuario)
                                              
                                              );");							
      		    $tb_cirugias->execute();
      //--------------------------------------------------------------------------------------				
      
      	
      		
      
      
      
      		    /*Se relacionan los usuarios que estaran en la cirugia*/
      		    $tb_usuarios_cirugias = $this->pdo->prepare("create table if not exists tb_usuarios_cirugias(
      
                                                          idUsuarioCirugia    int auto_increment,
                                                          idCirugia           int,
                                                          idUsuario           int,
                                                          
                                                          primary key (idUsuarioCirugia),
                                                          
                                                          foreign key (idCirugia) references tb_cirugias (idCirugia),
                                                          foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                         
                                                         );");							
      		    $tb_usuarios_cirugias->execute();
      //--------------------------------------------------------------------------------------				
      	
      	
      		
      
      
      
      		    /*Para guardar los paneles de las cirugias*/
      		    $tb_panelesCirugia = $this->pdo->prepare("create table if not exists tb_panelesCirugia(
      
                                                      idPanelCirugia        int auto_increment,
                                                      nombre                varchar(100) not null,
                                                      observacion           varchar(300),
                                                      estado                enum('A','I'),
                                                      
                                                      primary key (idPanelCirugia)
                                                     
                                                     );");							
      		    $tb_panelesCirugia->execute();
      //--------------------------------------------------------------------------------------			
      	
      	
      		
      
      
      
      		    /*Diagnosticos de un panel para cirugias*/
      		    $tb_panelesCirugiaDiagnosticos = $this->pdo->prepare("create table if not exists tb_panelesCirugiaDiagnosticos(
      
                                                                  idPanelCirugiaDiagnostico   int auto_increment,
                                                                  nombre                      varchar(100) not null,
                                                                  codigo                      varchar(10) not null,
                                                                  observacion                 varchar(300),
                                                                  precio                      varchar(10) not null,
                                                                  estado                      enum('A','I'),
                                                                  idPanelCirugia              int,
                                                                  
                                                                  primary key (idPanelCirugiaDiagnostico),
                                                                  
                                                                  foreign key (idPanelCirugia) references tb_panelesCirugia (idPanelCirugia)
                                                                 
                                                                 );");							
      		    $tb_panelesCirugiaDiagnosticos->execute();
      //--------------------------------------------------------------------------------------					
      	
      	
      		
      
      
      
      		    /*Se relacionan los diagnosticos con una cirugia*/
      		    $tb_diagnosticosCirugias = $this->pdo->prepare("create table if not exists tb_diagnosticosCirugias(
      
                                                             idDiagnosticoCirugia            int auto_increment,
                                                             descripcion                     varchar(200),
                                                             idPanelCirugiaDiagnostico       int,
                                                             idCirugia                       int,
                                                             
                                                             primary key (idDiagnosticoCirugia),
                                                             
                                                             foreign key (idPanelCirugiaDiagnostico) references tb_panelesCirugiaDiagnosticos (idPanelCirugiaDiagnostico),
                                                             foreign key (idCirugia) references tb_cirugias (idCirugia)
                                                            
                                                            );");							
      		    $tb_diagnosticosCirugias->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Notas aclaratorias para una cirugia*/
      		    $tb_cirugiasNotasAclaratorios = $this->pdo->prepare("create table if not exists tb_cirugiasNotasAclaratorios(
      
                                                                 idCirugiaNotaAclaratoria     int auto_increment,
                                                                 texto                        varchar(200) not null,
                                                                 fecha                        date,
                                                                 hora                         time,
                                                                 idCirugia                    int,
                                                                 idUsuario                    int,
                                                                 
                                                                 primary key (idCirugiaNotaAclaratoria),
                                                                 
                                                                 foreign key (idCirugia) references tb_cirugias (idCirugia),
                                                                 foreign key (idUsuario) references tb_usuarios (idUsuario)
                                                                 
                                                                );");							
      		    $tb_cirugiasNotasAclaratorios->execute();
      //--------------------------------------------------------------------------------------		
      		
      	
      		
      
      
      
      		    /*Se registran las hospitalizaciones de una mascota*/
      		    $tb_hospitalizacion = $this->pdo->prepare("create table if not exists tb_hospitalizacion (
      
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
                                                      
                                                      );");							
      		    $tb_hospitalizacion->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Se vinculan las cirugias que se realizan en una hospitalización*/
      		    $tb_cirugia_hospitalizacion = $this->pdo->prepare("create table if not exists tb_cirugia_hospitalizacion(
      
                                                              idCirugiaHospitalizacion     int auto_increment,
                                                              idHospitalizacion            int,
                                                              idCirugia                    int,
                                                              
                                                              primary key (idCirugiaHospitalizacion),
                                                              
                                                              foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
                                                              foreign key (idCirugia) references tb_cirugias (idCirugia)
                                                             
                                                             );");							
      		    $tb_cirugia_hospitalizacion->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Se vinculan las consultas que se realizan dentro de una hospitalizacion*/
      		    $tb_ConsultaHospitalzacion = $this->pdo->prepare("create table if not exists tb_ConsultaHospitalzacion(
      
                                                               idConsultaHospitalizacion    int auto_increment,
                                                               idHospitalizacion            int,
                                                               idConsulta                   int,
                                                               
                                                               primary key (idConsultaHospitalizacion),
                                                               
                                                               foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
                                                               foreign key (idConsulta) references tb_consultas (idConsulta)
                                                              
                                                              );");							
      		    $tb_ConsultaHospitalzacion->execute();
      //--------------------------------------------------------------------------------------			
      		
      	
      		
      
      
      
      		    /*Se vinculan los examenes que se realicen a un mascota hospitalizada*/
      		    $tb_examen_hospitalizacion = $this->pdo->prepare("create table if not exists tb_examen_hospitalizacion(
      
                                                             idExamenHospitalizacion      int auto_increment,
                                                             idHospitalizacion            int,
                                                             idExamen                     int,
                                                             
                                                             primary key (idExamenHospitalizacion),
                                                             
                                                             foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
                                                             foreign key (idExamen) references tb_examenes (idExamen)
                                                            
                                                            );");							
      		    $tb_examen_hospitalizacion->execute();
      //--------------------------------------------------------------------------------------					
      		
      	
      	
      		
      
      
      
      		    /*Se vinculan las formulas que se realizan en una hospitalización*/
      		    $tb_formula_hospitalizacion = $this->pdo->prepare("create table if not exists tb_formula_hospitalizacion(
      
																	idFormulaHospitalizacion     int auto_increment,
																	idHospitalizacion            int,
																	idFormula                    int,
																
																	primary key (idFormulaHospitalizacion),
																
																	foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion),
																	foreign key (idFormula) references tb_formulas (idFormula)
																
																);");							
      		    $tb_formula_hospitalizacion->execute();
      //--------------------------------------------------------------------------------------				
      		      		
      
      
      
      		    /*Se registra cuando se le da de alta a un paciente de una hospitalización*/
      		    $tb_hospitalizacionAlta = $this->pdo->prepare("create table if not exists tb_hospitalizacionAlta (
      
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
                                                         
                                                         );");							
      		    $tb_hospitalizacionAlta->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Se ingresan los espacios disponibles para la hospitalizacion*/
      		    $tb_espacioHospitalizacion = $this->pdo->prepare("create table if not exists tb_espacioHospitalizacion(
      
                                                              idEspacioHospitalizacion       int auto_increment,
                                                              nombre                         varchar(100) not null,
                                                              observacion                    varchar(300),
                                                              capacidad                      int not null,
                                                              espaciosOcupados               int not null,
                                                              estado                         enum('A','I'),
                                                              idSucursal                     int,
                                                              
                                                              primary key (idEspacioHospitalizacion),
                                                              
                                                              foreign key (idSucursal) references tb_sucursales (idSucursal)
                                                             
                                                             );");							
      		    $tb_espacioHospitalizacion->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Se vincula una hospitalizacion con un espacio para hospitalizar*/
      		    $tb_espacioHospitalizacion_Hospitalizacion = $this->pdo->prepare("create table if not exists tb_espacioHospitalizacion_Hospitalizacion(
      
                                                                              idEspacioHospitalizacionHospitalizacion      int auto_increment,
                                                                              estado									   enum ('A','I'),
                                                                              idEspacioHospitalizacion                     int,
                                                                              idHospitalizacion                            int,
                                                                              
                                                                              primary key (idEspacioHospitalizacionHospitalizacion),
                                                                              
                                                                              foreign key (idEspacioHospitalizacion) references tb_espacioHospitalizacion (idEspacioHospitalizacion),
                                                                              foreign key (idHospitalizacion) references tb_hospitalizacion (idHospitalizacion)
                                                                             
                                                                             );");							
      		    $tb_espacioHospitalizacion_Hospitalizacion->execute();
      //--------------------------------------------------------------------------------------				
      		
      	
      		
      
      
      
      		    /*Tabla que almacena los facturadores*/
      		    $tb_facturadores = $this->pdo->prepare("create table if not exists tb_facturadores(
      
                                                    idFacturador                 int auto_increment,
                                                    tipoIdentificacion           varchar(5) not null,
                                                    identificacion               varchar(30) not null,
                                                    nombre                       varchar(100) not null,
                                                    apellido                     varchar(100) not null,
                                                    telefono                     varchar(20),
                                                    celular                      varchar(20),
                                                    direccion                    varchar(50),
                                                    email                        varchar(100),
                                                    tipoRegimen					 varchar(100),
													razonSocial					 varchar(300),
                                                    identificacionEmisor         varchar(30),
                                                    nombreEmisor                 varchar(100),
                                                    estado                       enum('A','I'),
                                                    
                                                    primary key (idFacturador)
                                                   
                                                   );");							
      		    $tb_facturadores->execute();
      //--------------------------------------------------------------------------------------				
      			
      	
      		
      
      
      
      		    /*tabla para lamacenar los proveedores*/
      		    $tb_proveedores = $this->pdo->prepare("create table if not exists tb_proveedores(
      
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
                                                  
                                                  );");							
      		    $tb_proveedores->execute();
      //--------------------------------------------------------------------------------------			
      			
      	
      		
      
      
      
      		    /*Se almacnan las categorias para los productos*/
      		    $tb_categoriasProductos = $this->pdo->prepare("create table if not exists tb_categoriasProductos(
      
                                                           idCategoria        int auto_increment,
                                                           nombre             varchar(100) not null,
                                                           descripcion        varchar(200),
                                                           estado             enum('A','I'),
                                                           
                                                           primary key (idCategoria)
                                                          
                                                          );");							
      		    $tb_categoriasProductos->execute();
      //--------------------------------------------------------------------------------------				
      				
      	
      		
      
      
      
      		    /*Se almacenan los productos que se manejan*/
      		    $tb_productos = $this->pdo->prepare("create table if not exists tb_productos(
      
                                                 idProducto           int auto_increment,
                                                 nombre               varchar(50) not null,
                                                 descripcion          text,
                                                 codigo               varchar(20) not null,
                                                 precio               varchar(10) not null,
                                                 estado               enum('A','I'),
                                                 idCategoria          int,
                                                 tipoExterno		  varchar(30) default 0,
                                                 idExterno			  int default 0,
                                                 primary key (idProducto),
                                                 
                                                 foreign key (idCategoria) references tb_categoriasProductos (idCategoria)
                                                
                                                );");							
      		    $tb_productos->execute();
      //--------------------------------------------------------------------------------------		
      				
      	
      		
      
      
      
      		    /*Se relacionan los productos con los proveedores*/
      		    $tb_productos_proveedores = $this->pdo->prepare("create table if not exists tb_productos_proveedores(
      
                                                            idProductosProveedores     int auto_increment,
                                                            costo                      varchar(10) not null,
                                                            estado                     enum('A','I'),
                                                            idProducto                 int,
                                                            idProveedor                int,
                                                            
                                                            primary key (idProductosProveedores),
                                                            
                                                            foreign key (idProducto)  references tb_productos (idProducto),
                                                            foreign key (idProveedor) references tb_proveedores (idProveedor)
                                                           
                                                           );");							
      		    $tb_productos_proveedores->execute();
      //--------------------------------------------------------------------------------------			
      				
      	
      		
      
      
      
      		    /*Se relacionan los productos con las sucursales*/
      		    $tb_productos_sucursal = $this->pdo->prepare("create table if not exists tb_productos_sucursal(
      
                                                          idProductoSucursal     int auto_increment,
                                                          cantidad               int not null,
                                                          stockMinimo            int not null,
                                                          idProducto             int,
                                                          idSucursal             int,
                                                          
                                                          primary key (idProductoSucursal),
                                                          
                                                          foreign key (idProducto) references tb_productos (idProducto),
                                                          foreign key (idSucursal) references tb_sucursales (idSucursal)
                                                         
                                                         );");							
      		    $tb_productos_sucursal->execute();
      //--------------------------------------------------------------------------------------			
      				
      	
      		
      
      
      
      		    /*Se registran las resoluciones dian*/
      		    $tb_resolucionDian = $this->pdo->prepare("create table if not exists tb_resolucionDian( 
      
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
                                                     
                                                     
                                                     
                                                    );");							
      		    $tb_resolucionDian->execute();
      //--------------------------------------------------------------------------------------				
      				
      	
      		
      
      
      
      		    /*Se registran los servicios*/
      		    $tb_servicios = $this->pdo->prepare("create table if not exists tb_servicios(
      
                                                 idServicio        int auto_increment,
                                                 codigo            varchar(20) not null,
                                                 nombre            varchar(50) not null,
                                                 descripcion       varchar(200) not null,
                                                 precio            varchar(10) not null,
                                                 estado            enum('A','I') not null,
                                                 
                                                 primary key (idServicio)
                                                
                                                );");							
      		    $tb_servicios->execute();
      //--------------------------------------------------------------------------------------				
      				
      	
      		
      
      
      
      		    /*Se registra la peluqueria*/
      		    $tb_peluqueria = $this->pdo->prepare("create table if not exists tb_peluqueria(
      
                                                  idPeluqueria       int auto_increment,
                                                  horaInicio         time,
                                                  horaFin            time,
                                                  observaciones      text,
                                                  idMascota          int,
                                                  idSucursal         int,
                                                  
                                                  primary key (idPeluqueria),
                                                  
                                                  foreign key (idMascota) references tb_mascotas (idMascota),
                                                  foreign key (idSucursal) references tb_sucursales (idSucursal)
                                                 
                                                 );");							
      		    $tb_peluqueria->execute();
      //--------------------------------------------------------------------------------------				
      				
      	
      		
      
      
      
      		    /*Se registran las items de la peluqueria*/
      		    $tb_peluqueriaItems = $this->pdo->prepare("create table if not exists tb_peluqueriaItems(
      
                                                       idPeluqueriaItem       int auto_increment,
                                                       nombre                 varchar(100) not null,
                                                       horaAdicion            time,
                                                       horaFin                time,
                                                       estado                 enum('Pendiente','Terminado'),
                                                       observaciones          text,
                                                       idPeluqueria           int,
                                                       
                                                       primary key (idPeluqueriaItem),
                                                       
                                                       foreign key (idPeluqueria) references tb_peluqueria (idPeluqueria)
                                                      
                                                      );");							
      		    $tb_peluqueriaItems->execute();
      //--------------------------------------------------------------------------------------				
      				
      	
      		
      
      
      
      		    /*Se almacenan las facturas*/
      		    $tb_facturas = $this->pdo->prepare("create table if not exists tb_facturas(
      
                                               idFactura             int auto_increment,
                                               numeroFactura         int not null,
                                               fecha                 date,
                                               hora                  time,
                                               fechaFin              date,
                                               horaFin               time,
                                               iva                   varchar(10) not null,
                                               valorIva              varchar(10) not null,
                                               descuento			 varchar(10) not null,
                                               subtotal              varchar(10) not null,
                                               total                 varchar(10) not null,
                                               numeroImpresiones     int,
                                               metodopago			 enum('cheque','efectivo','bono','tdebito','tcredito'),
                                               observaciones		 varchar(300),
                                               estado                enum('Anulada','Cancelada','Iniciada','Activa'),
                                               idFacturador          int,
                                               idResolucionDian      int,
                                               idUsuario             int,
                                               idSucursal            int,
                                               idPropietario		 int,
                                               
                                               primary key (idFactura),
                                               
											   foreign key (idPropietario) references tb_propietarios (idPropietario),
                                               foreign key (idFacturador) references tb_facturadores (idFacturador),
                                               foreign key (idResolucionDian) references tb_resolucionDian (idResolucionDian),
                                               foreign key (idUsuario) references tb_usuarios (idUsuario),
                                               foreign key (idSucursal) references tb_sucursales (idSucursal)
                                              
                                              );");							
      		    $tb_facturas->execute();
      //--------------------------------------------------------------------------------------				
		
		
  
      		    /*Se almacena los desparasitantes*/
      		    $tb_desparasitantes = $this->pdo->prepare("create table if not exists tb_desparasitantes(

																 idDesparasitante			int auto_increment,
																 nombre						varchar(100) not null,
																 descripcion				varchar(200),
																 estado						enum('A','I'),
																 
																 primary key (idDesparasitante)
																
																);");							
      		    $tb_desparasitantes->execute();
      //--------------------------------------------------------------------------------------			
      

      
      				
      	
      		
      
      
      
      		    /*Se vincula un desparasitante con una mascota*/
      		    $tb_desparasitantesMascotas = $this->pdo->prepare("create table if not exists tb_desparasitantesMascotas(

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
																
																);");							
	      		 $tb_desparasitantesMascotas->execute();
      //--------------------------------------------------------------------------------------	     
       

      
      				
      	
      		
      
      
      
      		    /*Personalizados para motivo de consulta*/
      		    $tb_personalizados_motivoConsulta = $this->pdo->prepare("create table if not exists tb_personalizados_motivoConsulta(

																	 idPersonalizadoMotivoConsulta		int auto_increment,
																	 titulo								varchar(100) not null,
																	 texto								longtext not null,
																	 estado								enum('A','I'),
																	 idUsuario							int,
																	 
																	 primary key (idPersonalizadoMotivoConsulta),
																	
																	 foreign key (idUsuario) references tb_usuarios (idUsuario)
																	
																	);");							
	      		 $tb_personalizados_motivoConsulta->execute();
      //--------------------------------------------------------------------------------------	     
       

      
      				
      	
      		
      
      
      
      		    /*Personalizados para observaciones de consulta*/
      		    $tb_personalizados_observacionesConsulta = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesConsulta(

																		 idPersonalizadoObservacionConsulta		int auto_increment,
																		 titulo									varchar(100) not null,
																		 texto									longtext not null,
																		 estado									enum('A','I'),
																		 idUsuario								int,
																		
																		 primary key (idPersonalizadoObservacionConsulta),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_observacionesConsulta->execute();
      //--------------------------------------------------------------------------------------	       
      
      				
      	
      		
      
      
      
      		    /*Personalizados para plan a seguir de consulta*/
      		    $tb_personalizados_planConsulta = $this->pdo->prepare("create table if not exists tb_personalizados_planConsulta(

																				 idPersonalizadoPlanConsulta		    int auto_increment,
																				 titulo									varchar(100) not null,
																				 texto									longtext not null,
																				 estado									enum('A','I'),
																				 idUsuario								int,
																				
																				 primary key (idPersonalizadoPlanConsulta),
																				
																				 foreign key (idUsuario) references tb_usuarios (idUsuario)
																				
																				);");							
	      		 $tb_personalizados_planConsulta->execute();
      //--------------------------------------------------------------------------------------	   
      
      
      
      		    /*Personalizados para observaciones de examen fisico*/
      		    $tb_personalizados_observacionesExamenFisico = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesExamenFisico(

																		 idPersonalizadoObservacionExamenFisico		int auto_increment,
																		 titulo										varchar(100) not null,
																		 texto										longtext not null,
																		 estado										enum('A','I'),
																		 idUsuario									int,
																		
																		 primary key (idPersonalizadoObservacionExamenFisico),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_observacionesExamenFisico->execute();
      //--------------------------------------------------------------------------------------	          
      

      
      
      
      		    /*Personalizados para motivo de cirugia*/
      		    $tb_personalizados_motivoCirugia = $this->pdo->prepare("create table if not exists tb_personalizados_motivoCirugia(
		      
																		 idPersonalizadoMotivoCirugia		int auto_increment,
																		 titulo								varchar(100) not null,
																		 texto								longtext not null,
																		 estado								enum('A','I'),
																		 idUsuario							int,
																		 
																		 primary key (idPersonalizadoMotivoCirugia),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_motivoCirugia->execute();
      //--------------------------------------------------------------------------------------	          
            
      

      
      
      
      		    /*Personalizados para observaciones de cirugia*/
      		    $tb_personalizados_observacionesCirugia = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesCirugia(
																				      
																				 idPersonalizadoObservacionCirugia	int auto_increment,
																				 titulo								varchar(100) not null,
																				 texto								longtext not null,
																				 estado								enum('A','I'),
																				 idUsuario							int,
																				
																				 primary key (idPersonalizadoObservacionCirugia),
																				
																				 foreign key (idUsuario) references tb_usuarios (idUsuario)
																				
																				);");							
	      		 $tb_personalizados_observacionesCirugia->execute();
      //--------------------------------------------------------------------------------------            

            
      

      
      
      
      		    /*Personalizados para observaciones de cirugia*/
      		    $tb_personalizados_planCirugia = $this->pdo->prepare("create table if not exists tb_personalizados_planCirugia(
      
																		 idPersonalizadoPlanCirugia		int auto_increment,
																		 titulo							varchar(100) not null,
																		 texto							longtext not null,
																		 estado							enum('A','I'),
																		 idUsuario						int,
																		
																		 primary key (idPersonalizadoPlanCirugia),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_planCirugia->execute();
      //--------------------------------------------------------------------------------------    
                  

                  
      		    /*Personalizados para motivo de hopsitalizacion*/
      		    $tb_personalizados_motivoHospitalizacion = $this->pdo->prepare("create table if not exists tb_personalizados_motivoHospitalizacion(

																	 idPersonalizadoMotivoHospitalizacion		int auto_increment,
																	 titulo										varchar(100) not null,
																	 texto										longtext not null,
																	 estado										enum('A','I'),
																	 idUsuario									int,
																	 
																	 primary key (idPersonalizadoMotivoHospitalizacion),
																	
																	 foreign key (idUsuario) references tb_usuarios (idUsuario)
																	
																	);");							
	      		 $tb_personalizados_motivoHospitalizacion->execute();
      //-------------------------------------------------------------------------------------                  
                  
                  
      		    /*Personalizados para observaciones de hospitalizacion*/
      		    $tb_personalizados_observacionesHospitalizacion = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesHospitalizacion(

																		 idPersonalizadoObservacionHospitalizacion		int auto_increment,
																		 titulo											varchar(100) not null,
																		 texto											longtext not null,
																		 estado											enum('A','I'),
																		 idUsuario										int,
																		
																		 primary key (idPersonalizadoObservacionHospitalizacion),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_observacionesHospitalizacion->execute();
      //--------------------------------------------------------------------------------------	
                        

      		    /*Personalizados para cuidados alta*/
      		    $tb_personalizados_cuidadosAlta = $this->pdo->prepare("create table if not exists tb_personalizados_cuidadosAlta(

																	 idPersonalizadoCuidadosAlta		int auto_increment,
																	 titulo								varchar(100) not null,
																	 texto								longtext not null,
																	 estado								enum('A','I'),
																	 idUsuario							int,
																	 
																	 primary key (idPersonalizadoCuidadosAlta),
																	
																	 foreign key (idUsuario) references tb_usuarios (idUsuario)
																	
																	);");							
	      		 $tb_personalizados_cuidadosAlta->execute();
      //--------------------------------------------------------------------------------------	                         
                                          
      		    /*para adjuntos de las consultas*/
      		    $tb_adjuntosConsultas = $this->pdo->prepare("create table if not exists tb_adjuntosConsulta(

																		 idAdjuntoConsulta		int auto_increment,
																		 fecha					date,
																		 urlArchivo				varchar(300),
																		 pesoArchivo			varchar(30),
																		 idConsulta				int,
																		 idUsuario				int,
																		
																		 primary key (idAdjuntoConsulta),
																		
																		 foreign key (idConsulta) references tb_consultas (idConsulta),
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_adjuntosConsultas->execute();
      //--------------------------------------------------------------------------------------	        
      
                  
      		    /*para adjuntos de las cirugias*/
      		    $tb_adjuntosCirugias = $this->pdo->prepare("create table if not exists tb_adjuntosCirugias(

															 idAdjuntoCirugia		int auto_increment,
															 fecha					date,
															 urlArchivo				varchar(300) not null,
															 pesoArchivo			varchar(30),
															 idCirugia				int,
															 idUsuario				int,
															 
															 primary key (idAdjuntoCirugia),
															 
															 foreign key(idCirugia) references tb_cirugias(idCirugia),
															 foreign key(idUsuario) references tb_usuarios(idUsuario)
															
															);");	
						
	      		 $tb_adjuntosCirugias->execute();
      //--------------------------------------------------------------------------------------	           
      

      
      		    /*Personalizados para observaciones de examen */
      		    $tb_personalizados_observacionesExamen = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesExamen(

																		 idPersonalizadoObservacionExamen			int auto_increment,
																		 titulo										varchar(100) not null,
																		 texto										longtext not null,
																		 estado										enum('A','I'),
																		 idUsuario									int,
																		
																		 primary key (idPersonalizadoObservacionExamen),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_observacionesExamen->execute();
      //--------------------------------------------------------------------------------------	             
      


      
      		    /*Personalizados para observaciones de formulacion */
      		    $tb_personalizados_observacionesFormulacion = $this->pdo->prepare("create table if not exists tb_personalizados_observacionesFormulacion(

																		 idPersonalizadoObservacionFormulacion		int auto_increment,
																		 titulo										varchar(100) not null,
																		 texto										longtext not null,
																		 estado										enum('A','I'),
																		 idUsuario									int,
																		
																		 primary key (idPersonalizadoObservacionFormulacion),
																		
																		 foreign key (idUsuario) references tb_usuarios (idUsuario)
																		
																		);");							
	      		 $tb_personalizados_observacionesFormulacion->execute();
      //--------------------------------------------------------------------------------------	         
                  
         
      		    /*Registrar entradas de un producto */
      		    $tb_productos_sucursal_entradas = $this->pdo->prepare("create table if not exists tb_productos_sucursal_entradas(

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
																			
																			);");							
	      		 $tb_productos_sucursal_entradas->execute();
      //--------------------------------------------------------------------------------------	               
                  
         
      		    /*relacionar facturadores con una resolucion */
      		    $tb_facturadoresResolucionDian = $this->pdo->prepare("create table if not exists tb_facturadoresResolucionDian(

																	 idFacturadoresResolucionDian		int auto_increment,
																	 estado								enum('A','I'),
																	 idFacturador						int,
																	 idResolucionDian					int ,
																	 
																	 primary key (idFacturadoresResolucionDian),
																	 
																	 foreign key (idFacturador) references tb_facturadores (idFacturador),
																	 foreign key (idResolucionDian) references tb_resolucionDian (idResolucionDian)
																	
																	);");							
	      		 $tb_facturadoresResolucionDian->execute();
      //--------------------------------------------------------------------------------------	 

                  
         
      		    /*Tabla que hace de puente entre una factura o un recibo de caja con los destalles */
      		    $tb_pago_factura_caja = $this->pdo->prepare("create table if not exists tb_pago_factura_caja(

																 idPagoFacturaCaja   int auto_increment,
																 fecha					 date,
																 hora					 time,
																 tipoElemento			 enum('Factura','Caja','Ninguno'),
																 motivoninguno			 varchar(300),
																 idTipoElemento			 int not null,
																 idUsuario				 int,
																 
																 primary key (idPagoFacturaCaja),
																 
																 foreign key (idUsuario) references tb_usuarios (idUsuario)
																
																);");							
	      		 $tb_pago_factura_caja->execute();
      //--------------------------------------------------------------------------------------	     
        

                  
         
      		    /*Tabla que permite la union de los detalles con el pago */
      		    $tb_pago_factura_caja_detalle = $this->pdo->prepare("create table if not exists tb_pago_factura_caja_detalle(

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
															
															);");							
	      		 $tb_pago_factura_caja_detalle->execute();
      //--------------------------------------------------------------------------------------	      

      
      		    /*Tabla para guardar los mensajes que se muestran a todos los usuarios */
      		    $tb_mensajesUsuarios = $this->pdo->prepare("create table if not exists tb_mensajesUsuarios(

															     idMensajeUsuarios		int auto_increment,
																 fechaCreacion			date,
																 horaCreacion			time,
																 texto					varchar(300),
																 fechaVencimiento		date,
																 estado					enum('A','I'),
																 idUsuario				int,
																 
																 primary key (idMensajeUsuarios),
																 
																 foreign key (idUsuario) references tb_usuarios (idUsuario)
															
															);");							
	      		 $tb_mensajesUsuarios->execute();
      //--------------------------------------------------------------------------------------	            
                            
		       endif;//fin para el use de la base de datos
         
         
         
         
     }//fin metodo crearBDCLiente
     
     
     //meotodo para realizar el insert d elos paises
     public function insertPais(){
     		
     		$retorno = "";

          $query = "INSERT INTO tb_paises VALUES(1,  'Afganistán','AF', 'afghanistan_64.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(2,  'Islas Gland','AX', 'aland_islands_64.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(3,  'Albania','AL', 'albania_64.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(4,  'Alemania','DE', 'Alemania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(5,  'Andorra','AD', 'Andorra.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(6,  'Angola','AO', 'Angola.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(7,  'Anguilla','AI', 'Anguilla.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(8,  'Antártida','AQ', 'Antártida.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(9,  'Antigua y Barbuda','AG', 'AntiguayBarbuda.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(10,  'Antillas Holandesas','AN', 'Antillas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(11,  'Arabia Saudí','SA', 'Arabia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(12,  'Argelia','DZ', 'Argelia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(13,  'Argentina','AR', 'Argentina.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(14,  'Armenia','AM', 'Armenia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(15,  'Aruba','AW', 'Aruba.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(16,  'Australia','AU', 'Australia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(17,  'Austria','AT', 'Austria.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(18,  'Azerbaiyán','AZ', 'Azerbaiyán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(19,  'Bahamas','BS', 'Bahamas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(20,  'Bahréin','BH', 'Bahréin.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(21,  'Bangladesh','BD', 'Bangladesh.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(22,  'Barbados','BB', 'Barbados.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(23,  'Bielorrusia','BY', 'Bielorrusia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(24,  'Bélgica','BE', 'Bélgica.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(25,  'Belice','BZ', 'Belice.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(26,  'Benin','BJ', 'Benin.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(27,  'Bermudas','BM', 'Bermudas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(28,  'Bhután','BT', 'Bhután.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(29,  'Bolivia','BO', 'Bolivia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(30,  'Bosnia y Herzegovina','BA', 'Bosnia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(31,  'Botsuana','BW', 'Botsuana.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(32,  'Isla Bouvet','BV', 'IslaBouvet.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(33,  'Brasil','BR', 'Brasil.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(34,  'Brunéi','BN', 'Brunéi.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(35,  'Bulgaria','BG', 'Bulgaria.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(36,  'Burkina Faso','BF', 'BurkinaFaso.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(37,  'Burundi','BI', 'Burundi.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(38,  'Cabo Verde','CV', 'CaboVerde.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(39,  'Islas Caimán','KY', 'IslasCaimán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(40,  'Camboya','KH', 'Camboya.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(41,  'Camerún','CM', 'Camerún.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(42,  'Canadá','CA', 'Canadá.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(43,  'República Centroafricana','CF', 'República.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(44,  'Chad','TD', 'Chad.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(45,  'República Checa','CZ', 'República.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(46,  'Chile','CL', 'Chile.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(47,  'China','CN', 'China.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(48,  'Chipre','CY', 'Chipre.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(49,  'Isla de Navidad','CX', 'IsladeNavidad.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(50,  'Ciudad del Vaticano','VA', 'CiudaddelVaticano.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(51,  'Islas Cocos','CC', 'IslasCocos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(52,  'Colombia','CO', 'Colombia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(53,  'Comoras','KM', 'Comoras.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(54,  'República Democrática del Congo','CD', 'RepúblicaDemocráticadelCongo.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(55,  'Congo','CG', 'Congo.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(56,  'Islas Cook','CK', 'IslasCook.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(57,  'Corea del Norte','KP', 'CoreadelNorte.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(58,  'Corea del Sur','KR', 'CoreadelSur.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(59,  'Costa de Marfil','CI', 'CostadeMarfil.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(60,  'Costa Rica','CR', 'Costa.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(61,  'Croacia','HR', 'Croacia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(62,  'Cuba','CU', 'Cuba.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(63,  'Dinamarca','DK', 'Dinamarca.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(64,  'Dominica','DM', 'Dominica.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(65,  'República Dominicana','DO', 'RepúblicaDominicana.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(66,  'Ecuador','EC', 'Ecuador.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(67,  'Egipto','EG', 'Egipto.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(68,  'El Salvador','SV', 'ElSalvador.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(69,  'Emiratos Árabes Unidos','AE', 'EmiratosÁrabesUnidos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(70,  'Eritrea','ER', 'Eritrea.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(71,  'Eslovaquia','SK', 'Eslovaquia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(72,  'Eslovenia','SI', 'Eslovenia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(73,  'España','ES', 'España.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(74,  'Islas ultramarinas de Estados Unidos','UM', 'IslasultramarinasdeEstadosUnidos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(75,  'Estados Unidos','US', 'EstadosUnidos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(76,  'Estonia','EE', 'Estonia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(77,  'Etiopía','ET', 'Etiopía.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(78,  'Islas Feroe','FO', 'IslasFeroe.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(79,  'Filipinas','PH', 'Filipinas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(80,  'Finlandia','FI', 'Finlandia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(81,  'Fiyi','FJ', 'Fiyi.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(82,  'Francia','FR', 'Francia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(83,  'Gabón','GA', 'Gabón.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(84,  'Gambia','GM', 'Gambia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(85,  'Georgia','GE', 'Georgia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(86,  'Islas Georgias del Sur y Sandwich del Sur','GS', 'IslasGeorgiasdelSurySandwichdelSur.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(87,  'Ghana','GH', 'Ghana.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(88,  'Gibraltar','GI', 'Gibraltar.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(89,  'Granada','GD', 'Granada.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(90,  'Grecia','GR', 'Grecia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(91,  'Groenlandia','GL', 'Groenlandia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(92,  'Guadalupe','GP', 'Guadalupe.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(93,  'Guam','GU', 'Guam.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(94,  'Guatemala','GT', 'Guatemala.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(95,  'Guayana Francesa','GF', 'GuayanaFrancesa.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(96,  'Guinea','GN', 'Guinea.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(97,  'Guinea Ecuatorial','GQ', 'GuineaEcuatorial.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(98,  'Guinea-Bissau','GW', 'GuineaBissau.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(99,  'Guyana','GY', 'Guyana.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(100,  'Haití','HT', 'Haití.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(101,  'Islas Heard y McDonald','HM', 'IslasHeardyMcDonald.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(102,  'Honduras','HN', 'Honduras.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(103,  'Hong Kong','HK', 'HongKong.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(104,  'Hungría','HU', 'Hungría.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(105,  'India','IN', 'India.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(106,  'Indonesia','ID', 'Indonesia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(107,  'Irán','IR', 'Irán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(108,  'Iraq','IQ', 'Iraq.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(109,  'Irlanda','IE', 'Irlanda.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(110,  'Islandia','IS', 'Islandia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(111,  'Israel','IL', 'Israel.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(112,  'Italia','IT', 'Italia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(113,  'Jamaica','JM', 'Jamaica.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(114,  'Japón','JP', 'Japón.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(115,  'Jordania','JO', 'Jordania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(116,  'Kazajstán','KZ', 'Kazajstán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(117,  'Kenia','KE', 'Kenia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(118,  'Kirguistán','KG', 'Kirguistán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(119,  'Kiribati','KI', 'Kiribati.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(120,  'Kuwait','KW', 'Kuwait.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(121,  'Laos','LA', 'Laos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(122,  'Lesotho','LS', 'Lesotho.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(123,  'Letonia','LV', 'Letonia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(124,  'Líbano','LB', 'Líbano.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(125,  'Liberia','LR', 'Liberia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(126,  'Libia','LY', 'Libia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(127,  'Liechtenstein','LI', 'Liechtenstein.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(128,  'Lituania','LT', 'Lituania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(129,  'Luxemburgo','LU', 'Luxemburgo.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(130,  'Macao','MO', 'Macao.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(131,  'ARY Macedonia','MK', 'ARY.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(132,  'Madagascar','MG', 'Madagascar.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(133,  'Malasia','MY', 'Malasia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(134,  'Malawi','MW', 'Malawi.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(135,  'Maldivas','MV', 'Maldivas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(136,  'Malí','ML', 'Malí.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(137,  'Malta','MT', 'Malta.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(138,  'Islas Malvinas','FK', 'IslasMalvinas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(139,  'Islas Marianas del Norte','MP', 'IslasMarianasdelNorte.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(140,  'Marruecos','MA', 'Marruecos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(141,  'Islas Marshall','MH', 'IslasMarshall.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(142,  'Martinica','MQ', 'Martinica.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(143,  'Mauricio','MU', 'Mauricio.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(144,  'Mauritania','MR', 'Mauritania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(145,  'Mayotte','YT', 'Mayotte.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(146,  'México','MX', 'México.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(147,  'Micronesia','FM', 'Micronesia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(148,  'Moldavia','MD', 'Moldavia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(149,  'Mónaco','MC', 'Mónaco.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(150,  'Mongolia','MN', 'Mongolia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(151,  'Montserrat','MS', 'Montserrat.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(152,  'Mozambique','MZ', 'Mozambique.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(153,  'Myanmar','MM', 'Myanmar.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(154,  'Namibia','NA', 'Namibia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(155,  'Nauru','NR', 'Nauru.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(156,  'Nepal','NP', 'Nepal.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(157,  'Nicaragua','NI', 'Nicaragua.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(158,  'Níger','NE', 'Níger.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(159,  'Nigeria','NG', 'Nigeria.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(160,  'Niue','NU', 'Niue.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(161,  'Isla Norfolk','NF', 'IslaNorfolk.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(162,  'Noruega','NO', 'Noruega.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(163,  'Nueva Caledonia','NC', 'NuevaCaledonia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(164,  'Nueva Zelanda','NZ', 'NuevaZelanda.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(165,  'Omán','OM', 'Omán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(166,  'Países Bajos','NL', 'Países.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(167,  'Pakistán','PK', 'Pakistán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(168,  'Palau','PW', 'Palau.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(169,  'Palestina','PS', 'Palestina.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(170,  'Panamá','PA', 'Panamá.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(171,  'Papúa Nueva Guinea','PG', 'Papúa.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(172,  'Paraguay','PY', 'Paraguay.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(173,  'Perú','PE', 'Perú.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(174,  'Islas Pitcairn','PN', 'Islas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(175,  'Polinesia Francesa','PF', 'Polinesia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(176,  'Polonia','PL', 'Polonia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(177,  'Portugal','PT', 'Portugal.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(178,  'Puerto Rico','PR', 'PuertoRico.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(179,  'Qatar','QA', 'Qatar.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(180,  'Reino Unido','GB', 'ReinoUnido.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(181,  'Reunión','RE', 'Reunión.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(182,  'Ruanda','RW', 'Ruanda.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(183,  'Rumania','RO', 'Rumania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(184,  'Rusia','RU', 'Rusia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(185,  'Sahara Occidental','EH', 'SaharaOccidental.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(186,  'Islas Salomón','SB', 'IslasSalomón.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(187,  'Samoa','WS', 'Samoa.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(188,  'Samoa Americana','AS', 'SamoaAmericana.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(189,  'San Cristóbal y Nevis','KN', 'SanCristóbalyNevis.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(190,  'San Marino','SM', 'SanMarino.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(191,  'San Pedro y Miquelón','PM', 'SanPedroyMiquelón.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(192,  'San Vicente y las Granadinas','VC', 'SanVicenteylasGranadinas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(193,  'Santa Helena','SH', 'SantaHelena.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(194,  'Santa Lucía','LC', 'SantaLucía.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(195,  'Santo Tomé y Príncipe','ST', 'SantoToméyPríncipe.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(196,  'Senegal','SN', 'Senegal.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(197,  'Serbia y Montenegro','CS', 'SerbiayMontenegro.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(198,  'Seychelles','SC', 'Seychelles.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(199,  'Sierra Leona','SL', 'SierraLeona.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(200,  'Singapur','SG', 'Singapur.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(201,  'Siria','SY', 'Siria.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(202,  'Somalia','SO', 'Somalia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(203,  'Sri Lanka','LK', 'SriLanka.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(204,  'Suazilandia','SZ', 'Suazilandia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(205,  'Sudáfrica','ZA', 'Sudáfrica.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(206,  'Sudán','SD', 'Sudán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(207,  'Suecia','SE', 'Suecia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(208,  'Suiza','CH', 'Suiza.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(209,  'Surinam','SR', 'Surinam.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(210,  'Svalbard y Jan Mayen','SJ', 'SvalbardyJanMayen.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(211,  'Tailandia','TH', 'Tailandia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(212,  'Taiwán','TW', 'Taiwán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(213,  'Tanzania','TZ', 'Tanzania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(214,  'Tayikistán','TJ', 'Tayikistán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(215,  'Territorio Británico del Océano Índico','IO', 'TerritorioBritánicodelOcéanoÍndico.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(216,  'Territorios Australes Franceses','TF', 'TerritoriosAustralesFranceses.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(217,  'Timor Oriental','TL', 'TimorOriental.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(218,  'Togo','TG', 'Togo.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(219,  'Tokelau','TK', 'Tokelau.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(220,  'Tonga','TO', 'Tonga.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(221,  'Trinidad y Tobago','TT', 'TrinidadyTobago.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(222,  'Túnez','TN', 'Túnez.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(223,  'Islas Turcas y Caicos','TC', 'IslasTurcasyCaicos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(224,  'Turkmenistán','TM', 'Turkmenistán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(225,  'Turquía','TR', 'Turquía.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(226,  'Tuvalu','TV', 'Tuvalu.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(227,  'Ucrania','UA', 'Ucrania.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(228,  'Uganda','UG', 'Uganda.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(229,  'Uruguay','UY', 'Uruguay.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(230,  'Uzbekistán','UZ', 'Uzbekistán.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(231,  'Vanuatu','VU', 'Vanuatu.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(232,  'Venezuela','VE', 'Venezuela.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(233,  'Vietnam','VN', 'Vietnam.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(234,  'Islas Vírgenes Británicas','VG', 'IslasVírgenesBritánicas.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(235,  'Islas Vírgenes de los Estados Unidos','VI', 'IslasVírgenesdelosEstadosUnidos.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(236,  'Wallis y Futuna','WF', 'Wallis.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(237,  'Yemen','YE', 'Yemen.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(238,  'Yibuti','DJ', 'Yibuti.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(239,  'Zambia','ZM', 'Zambia.png', 'A');";
          $query .= "INSERT INTO tb_paises VALUES(240,  'Zimbabue','ZW', 'Zimbabue.png', 'A');";  
          
          
          //se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno =  "Nuevos registros de paises ingresados!";
           } else {
              $retorno =  "Error ingresadon paises";
           }
      
      		return $retorno;
      
     }//fin metodo insertPais
     
     
     //insert para listado de tutoriales
     public function encabezadoTutoriales(){
     	
		$retorno = "";


			$query = "";
			$query .= "INSERT INTO tb_introTutorial (nombre) VALUES ('Home');";
			
          
          //se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno =  "Nuevos registros de intros ingresados!";
           } else {
              $retorno =  "Error ingresadon paises";
           }
      
      		return $retorno;
		
     }//fin metodo encabezadoTutoriales
     
     
     //funcion para ingresar especies por defecto
     public function insertEspecies(){
     	
		$retorno = "";
		
		$query = "INSERT INTO tb_especies (nombre, estado) VALUES ('Canina', 'A');";
		$query .= "INSERT INTO tb_especies (nombre, estado) VALUES ('Felina', 'A');";
		$query .= "INSERT INTO tb_especies (nombre, estado) VALUES ('Equina', 'A');";
		$query .= "INSERT INTO tb_especies (nombre, estado) VALUES ('Bovina', 'A');";
		$query .= "INSERT INTO tb_especies (nombre, estado) VALUES ('Roedor', 'A');";
		$query .= "INSERT INTO tb_especies (nombre, estado) VALUES ('Ave', 'A');";

		//se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno =  "Nuevos registros de paises ingresados!";
           } else {
              $retorno =  "Error ingresadon paises";
           }
      
      		return $retorno;
		
     }//fin metodo insertEspecies
     
 
     //funcion para ingresar razas por defecto
     public function insertRazas(){
     	
		$retorno = "";
		
		$query = "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Akita','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Akita Americano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Afgano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Airedale Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Alaskan Malamute','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American Pitt Bull Terrier ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American Staffordshire Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American Water Spaniel','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Antiguo Pastor Inglés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Australian Kelpie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Australian Shepherd ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Barzoi','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Basset Azul de Gaseogne','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Basset Hound','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Basset leonado de Bretaña','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Beagle','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bearded Collie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Beauceron ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Berger Blanc Suisse ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bichón Frisé','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bichón Habanero','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bichón Maltés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bloodhound','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bobtail','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Border Collie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Borzoi ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boston Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boxer','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boyero Australiano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boyero de Flandes','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boyero de Montaña Bernés ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Braco Alemán','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Braco de Weimar ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Braco Húngaro','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Briard','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bull Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bulldog Americano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bulldog Francés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bulldog Inglés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bullmastiff','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cane Corso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Caniche','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Carlino','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Chien de Saint Hubert ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Chihuahua','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Chino Crestado','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Chow Chow','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cirneco del Etna','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cocker Spaniel Americano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cocker Spaniel Inglés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Collie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Coton de Tuléar ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dachshunds','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dálmata','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Deutsch Drahthaar','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Deutsch Kurzhaar ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dobermann','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dogo Alemán','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dogo Argentino','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dogo Canario ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dogo de Burdeos','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Drahthaar','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('English Springer Spaniel ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Epagneul Bretón','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Eurasier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fila Brasileiro ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fox Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Foxhound Americano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Foxhound Inglés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Galgo Afgano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Galgo Español','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Galgo Italiano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Galgo Ruso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gigante de los Pirineos','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Golden Retriever','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gos d Atura','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gran Danés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gran Perro Japonés ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Irish Wolfhound','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Jack Russel','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Japanes Chin','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Kelpie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Kerry Blue','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Komondor','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Kuvasz','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Labrador Retriever','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Laika de Siberia Occidental','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Laika Ruso-europeo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Lebrel ruso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Leonberger','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Lhasa Apso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Magyar Vizsla','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Maltés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mastín del Alentejo ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mastín del Pirineo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mastin del Tibet','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mastín Español','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mastín Napolitano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Norfolk Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ovtcharka','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pachón Navarro ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor Alemán','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor Australiano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor Belga','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor Blanco Suizo ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor de Beauce','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor de Brie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor de los Pirineos de Cara Rosa','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor de Shetland ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pastor del Cáucaso ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pekinés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero Burgos ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero Chesapeake Bay','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero de Drentse','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero de Pelo lido','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero de pelo rizado','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perdiguero Portugués','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perro Crestado Chino','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perro de Aguas','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perro sin pelo de Mexico ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Perro sin pelo del Perú','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pinscher miniatura ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pitbull','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Podenco Andaluz','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Podenco Ibicenco','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Podenco Portugués','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('presa canario','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Presa Mallorquin','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Rafeiro do Alentejo ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Rottweiler','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Rough Collie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sabueso Español','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sabueso Hélenico','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sabueso Italiano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sabueso Suizo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Saint Hubert ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Saluki','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Samoyedo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('San Bernardo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Schnaucer','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Scottish Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sealyhalm Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Setter Gordon','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Setter Irlandés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shar Pei','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shiba','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shiba Inu','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shih Tzu','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Siberian Husky','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Smooth Collie','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Spaniel Japonés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Spinone Italiano ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Spitz Alemán','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Springer Spaniel Inglés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Staffordshire Bull Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Teckel','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terranova','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Australiano','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Escocés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Irlandés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Japonés','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Negro Ruso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Norfolk','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Terrier Ruso','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Tibetan Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Vizsla','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Welhs Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('West Highland T.','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Wolfspitz','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Xoloitzquintle ','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Yorkshire Terrier','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mestizo','','A','1');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Criollo','','A','1');";		

		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Abisinio','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Aphrodites Giants','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Australian Mist','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American Curl','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Azul ruso','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American shorthair','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('American wirehair','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Angora turco','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Africano doméstico','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bengala','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bobtail japonés','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bombay','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bosque de Noruega','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Brazilian Shorthair','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Brivon de pelo corto','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Brivon de pelo largo','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('British Shorthair','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Burmés','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Burmilla','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cornish rex','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('California Spangled','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ceylon','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cymric','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Chartreux','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Deutsch Langhaar','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Devon rex','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dorado africano','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Don Sphynx','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dragon Li','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Europeo Común','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Exótico de Pelo Corto','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gato europeo bicolor','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('FoldEx','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('German Rex','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Habana brown','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Himalayo','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Korat','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Khao Manee','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Maine Coon','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Manx','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mau egipcio','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Munchkin','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ocicat','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Oriental','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Oriental de pelo largo','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ojos azules','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('PerFold','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Persa Americano o Moderno','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Persa Clásico o Tradicional','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Peterbald','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pixie Bob','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ragdoll','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sagrado de Birmania','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Scottish Fold','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Selkirk rex','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Serengeti','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Seychellois','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Siamés','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Siamés Moderno','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Siamés Tradicional','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Siberiano','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Snowshoe','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sphynx','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Tonkinés','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Van Turco','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mestizo','','A','2');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Criollo','','A','2');";

		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Akhal-Teké','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Anglo - árabe','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Appaloosa','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Arabe','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Azteca','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Alter Real','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Ardenés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Asturcón','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Albino','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Aveliñes','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Andaluz','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Australiano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Belga de Tiro','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Berberisco','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bretón','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Bávaro','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Boloñes','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Brabante','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Brumby','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Budyonny','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Clydesdale','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cob','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Criollo','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cuarto de milla','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Camargues','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Caspio','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cleveland Bay','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Clydesdale','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Cob Galés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Comtois','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Connemara','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('C. Americano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('C. Argentino','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Don','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dales','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dartmoor','','A','3');";
			$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Dole','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Darashouri','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De Islandia','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De Przewalski','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De Silla','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De tiro Holandés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De tiro Irlandés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('De tiro Italiano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Exmoor','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Falabella','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Frisón','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fell','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fjord','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Frederiksborg','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Freiberger','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fiordo','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Fox trotter','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Frisio','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Frisio Oriental','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Furioso','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gelderland','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gotland','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Gallego','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Hack','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Hannoveriano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Holstein','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Haflinger','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Húngaro','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Hunter Irlandés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Hackney','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Jaca','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Jaca Galesa','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Kabardin','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Karabair','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Kladruber','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Knabstrup','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Karabakh','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Lipizzano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Lusitano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Letón','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mangalarga','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Morgan','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mustang','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Mallorquin','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Nonius','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Nórico','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Northlands','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Oldenburgo','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Palomino','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Paso Fino','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Percherón','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Paso Peruano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pinto','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Americano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Australiano','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Camargue','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Dalés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Dartmoor','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni de Java','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni de Monta','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni de Shetland','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Exmoor','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Fell','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Highland','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni New Forest','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Poni Polo','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Pura Sangre','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Quarter','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Salerno','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('S. Cal. Holandés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('S. Cal. Sueco','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shagya Arabe','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shetland Amer','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Silla Francés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Shire','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Standardbred','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Suffolk Punch','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sorraia','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Sueco del Norte','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Tennessee','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Tersky','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Trakehner','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Trotón Francés','','A','3');";
		$query .= "INSERT INTO tb_razas(nombre,descripcion,estado,idEspecie)VALUES('Trotón Orlov','','A','3');";
		
		
		//se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno =  "Nuevos registros de paises ingresados!";
           } else {
              $retorno =  "Error ingresadon paises";
           }
      
      		return $retorno;
		
     }//fin metodo insertRazas
     
      
     
     //metodo para insertar los idiomas 
     public function insertIdiomas(){
      
	  		$retorno = "";
	  
         $query = "INSERT INTO tb_idiomas VALUES(1, 'Español', 'Es', 'colombia_64.png', 'A');";
         $query .= "INSERT INTO tb_idiomas VALUES(2, 'English', 'En', 'united_states_of_america_64.png', 'A');";
         
         //se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno = "Nuevos registros de idiomas ingresados!";
           } else {
               $retorno = "Error ingresadon idiomas";
           }
         
		 return $retorno;
         
     }//fin metodo insertIdiomas
     
     
     //metodo para ingresar la clinica
     public function insertClinica($identificativoNit, $nombre, $telefono1, $telefono2, $celular, $direccion, $email){
      
	  	 $retorno = "";
	  
         $identificativoNit = $this->escaparQueryNuevaBD($identificativoNit);
         $nombre 			= $this->escaparQueryNuevaBD($nombre);
         $telefono1 		= $this->escaparQueryNuevaBD($telefono1);
         $telefono2 		= $this->escaparQueryNuevaBD($telefono2);
         $celular 			= $this->escaparQueryNuevaBD($celular);
         $direccion 		= $this->escaparQueryNuevaBD($direccion);
         $email 			= $this->escaparQueryNuevaBD($email);
      
         $query = "INSERT INTO tb_clinica (identificativoNit, nombre, telefono1, telefono2, celular, direccion, email) ".
                 " VALUES ".
                 " ('$identificativoNit', '$nombre', '$telefono1', '$telefono2', '$celular', '$direccion', '$email') ";
         
          if($this->conexionNuevaBD()->query($query)){
            $retorno =  "insert de la clínica ok";
          }else{
            $retorno = "falló el insert de la clínica";
          }
		  
		  return $retorno;
      
     }//fin metodo insertClinica
     
     
     //metodo para ingresar el usuario
     public function ingresarPrimerUsuario($identificacion,$nombre,$apellido,$pass,$telefono,$celular,$direccion,$email,$idLicencia){
     	
		$retorno = "";
		
		$query = "INSERT INTO tb_usuarios
					(tipoIdentificacion,identificacion,nombre,apellido,pass,telefono,celular,direccion,email,agenda,idIdioma,estado,idLicencia)
				  VALUES
					('CC','$identificacion','$nombre','$apellido','$pass','$telefono','$celular','$direccion','$email','Si','1','A','$idLicencia');";
		
		if($this->conexionNuevaBD()->query($query)){
            $retorno = "insert del Usuario ok";
          }else{
            $retorno = "falló el insert del usuario";
          }
		  
		  return $retorno;
     	
     }//fin metodo ingresarPrimerUsuario
     
     
     
     //metodo para ingresar los permisos
     public function ingresarPermisos(){
			
     	$retorno	= "";
     	
     	
		$query = "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (1,'Personalizados','Gestionar personalizados');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (2,'Acceso cuenta','Acceder a la información d ela cuenta');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (3,'Licencias ver','Ver las licencias y sus dechas de vencimientos de la cuenta y a que usuario estan relacionadas tales licencias');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (4,'Licencias adicionar','Permite comprar más licencias para la cuenta');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (5,'Licencias usuarios','Permite asignar o modificar licencias a usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (6,'Permisos ver','Puede ver que permisos tienen los usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (7,'Permisos editar','Permite modificar los permisos de los usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (8,'Sucuarsales ver','Puede ver la informacion de las sucursales creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (9,'Sucursales adicionar','Permite crear nuevas sucursales');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (10,'Sucursales usuarios','Puede relacionar usuarios con las sucursales');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (11,'Usuarios crear','Puede crear nuevos usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (12,'Usuarios ver','Permite obeservar la información de los usuarios existentes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (13,'Usuarios desactivar','Permite marcar un usuario como inactivo');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (14,'Listados Barrios ver','Puede consultar los barrios creados');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (15,'Listado Barrios Adicionar','Puede crear nuevos barrios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (16,'Listado Barrios Editar','Puede modificar la información de los barrios creados');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (17,'Listado Ciudades Ver','Puede consultar las ciudades creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (18,'Listado Ciudades Adicionar','Puede crear nuevas ciudades');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (19,'Listado Ciudades Editar','Puede modificar la información de las ciudades creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (20,'Listado Diagnosticos Ver','Puede ver la información de los diagnosticos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (21,'Listados Diagnostico Adicionar','Puede crear nuevos diagnosticos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (22,'Listado Diagnosticos Editar','Puede modificar la información de los diagnosticos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (23,'Listado Especialidades Ver','Puede ver las especialidades');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (24,'Listado Especialidades Editar','Puede editar la información de las especialidades');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (25,'Listado Especialidades Crear','Puede crear nuevas especialidades');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (26,'Listado Diagnosticos Ver','Puede ver los diagnosticos o cirugias');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (27,'Listado Diagnosticos Adicionar','Permite adicionar nuevos diagnosticos para las cirugias');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (28,'Listado Diagnosticos Editar','Puede editar la informacion de los diagnosticos de cirugias');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (29,'Listado Especies Ver','Puede ver las especies creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (30,'Listado Especies Adicionar','Puede adicionar nuevas especies');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (31,'Listado Especies Modificar','Puede modificar la informacion de las especies');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (32,'Listado Razas Ver','Puede ver la información de las razas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (33,'Listado Razas Adicionar','Puede adicionar nuevas razas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (34,'Listado Razas Modificar','Puede modificar el la información de las razas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (35,'Reportes','Puede ver los diferentes reportes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (36,'Facturar','Puede generar facturas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (37,'Facturadores Ver','Puede ver la información de los facturadores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (38,'Facturadores Modificar','Puede modificar la información de los facturadores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (39,'Facturadores Adicionar','Permite crear nuevos facturadores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (40,'Resoluciones Ver','Ver inforamción de las resoluciones creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (41,'Resolucion Editar','modificar la información de una resolucion');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (42,'Resolucion Adicionar','Puede crear nuevas resoluciones');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (43,'Productos Ver','Puede ver la información de los productos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (44,'Productos Adicionar','Puede crear nuevos productos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (45,'Productos Modificar','Modificar la información de los productos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (46,'Proveedores ver','Observar la infomación de los proveedores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (47,'Proveedores Editar','Editar la información de los proveedores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (48,'Proveedores Adicionar','Crear nuevos proveedores');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (49,'Guarderia crear Espacios','Crear nuevos espacios para la guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (50,'Guarderia Editar Espacios','Editar la información de los espacios para la guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (51,'Guarderia crear tarea','crear tareas para la guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (52,'Guarderia editar tarea','editar una tarea de la guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (53,'Guarderia Adicionar ','Crear una tarea para una guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (54,'Guarderia Crear registro','Vincular una mascota con la guarderia');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (55,'Peluqueria Crear registro','Permite crear un registro para la peluqueria vinculando una mascota');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (56,'Peluqueria item Crear','crea un items para la peluqueria');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (57,'Peluqueria Item Modificar','Modificar el item de la peluqueria');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (58,'Propietario Ver','Permite ver los propietarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (59,'Propetario Crear','Puede Crear un nuevo propietario');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (60,'Propietario Editar','Permite editar la informacion de un propietario');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (61,'Paciente Crear','Puede crear nuevos pacientes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (62,'Paciente Ver','Solo puede ver los pacientes y su información');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (63,'Paciente Modificar','Puede modificar la información de un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (64,'Formulas crear','Crear nuevas formulas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (65,'Formulas Ver','Ver las formulas creadas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (66,'Medicamentos Ver','Puede ver el listado de los medicamentos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (67,'Medicamentos Adicionar','Crear nuevos medicamentos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (68,'Medicamentos Editar','Editar los medicamentos');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (69,'Examenes Ver','Ver los examenes creados');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (70,'Examenes Crear','Crear examenes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (71,'Listado examenes Crear','Crear items para los examenes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (72,'Listado examenes Ver','ver el listado de los items de examenes creados');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (73,'Listado Examanes Editar','Editar los items de los examenes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (74,'Resultado examenes Ver','Ver el resultado de los examenes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (75,'Resultado examenes Crear','Registrar un resultado de examenes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (76,'Vacunas ver','Ver el listado de vacunas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (77,'Vacunas adicionar','Adicionar vacunas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (78,'vacunas modificar','modificar vacunas');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (79,'Vacunacion Adicionar','Permite registrar la aplicación de vacunas a los pacientes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (80,'vacunación ver','Ver las vacunas aplicadas a los pacientes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (81,'Desparasitantes Ver','Ver los desparacitantes');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (82,'Desparasitantes Adicionar','Crear nuevo desparasitante');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (83,'Desparasitante Modificar','Modificar la info de un desparasitante');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (84,'Desparasitacion Ver','Puede ver los desparasitantes aplicados a un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (85,'Desparasitacion adicionar','Puede registrar la aplicación de un desparasitante a un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (86,'Consultas crear','crear consultas a un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (87,'Consultas Ver','Ver las consultas de un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (88,'Consultas notas aclaratorias crear','Crear notas aclaratorias para una consulta');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (89,'Consulta notas aclaratorias ver','Ver las notas aclaratorias de una consulta');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (90,'Adicionar Item Examen fisico','Adicionar item en examen fisico consulta');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (91,'Cirugias Crear','Peude crear una cirugia para un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (92,'Cirugias Ver','Ver las cirugias de un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (93,'Hospitalizar','hospitalizar un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (94,'Hospitalizacion alta','Dar de alta a un paciente');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (95,'Agenda ver','Ver la agenda');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (96,'Agenda ver otras usuarios','ver la agenda de otros usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (97,'Agenda horarios','ver los horarios de la agenda');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (98,'Agenda horarios otros usuarios','Ver los horarios de otros usuarios');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (99,'Agenda tipos cita Ver','Ver los tipos de cita de la agenda');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (100,'Agenda tipos cita adicionar','Adicionar nuevos tipos de cita');";
		$query .= "INSERT INTO tb_permisos (idPermiso,nombre,descripcion) VALUES (101,'Agenda tipos de cita modificar','Modificar los tipos de cita');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Categoria productos ver', 'Ver el listado de las categorias para productos');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Categoria productos editar', 'Editar las categorias para productos');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Categoria productos adicionar', 'Crear categoria productos');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Hospitalizacion espacios ver', 'Ver los espacios que se tienen para la hospitalizacion');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Hospitalizacion espacios adicionar', 'Crear espacios para hospitalizacion');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Hospitalizacion espacios modificar', 'Editar espacios para hospitalizacion');";
		$query .= "INSERT INTO tb_permisos (nombre, descripcion) VALUES ('Ver logs', 'Ver los logs registrados');";
		
		
		     	
		//se ejecuta el multi query
          if ($this->conexionNuevaBD()->multi_query($query) === TRUE) {
               $retorno =  "Nuevos registros de permisos ingresados!";
           } else {
              $retorno =  "Error ingresadon permisos";
           }
      
      		return $retorno;
		
     }//fin metodo ingresarPermisos
     

     
     //metodo para ingresar los paneles por defecto para los diagnósticos de consulta y cirugia
     public function ingresarPrimerosPaneles(){
     	
		$retorno = "";
		
		$query = "INSERT INTO tb_panelesCirugia (idPanelCirugia, nombre, observacion, estado) VALUES (1,'Default', 'Default', 'A');";
		
		if($this->conexionNuevaBD()->query($query)){
            $retorno = "insert del panel ok";
          }else{
            $retorno = "falló el insert del panel";
          }
		  
		$query2 = "INSERT INTO tb_panelesConsulta (idPanelConsulta, nombre, observacion, estado) VALUES ('1', 'Default', 'Default', 'A');";
		
		if($this->conexionNuevaBD()->query($query2)){
            $retorno = "insert del panel ok";
          }else{
            $retorno = "falló el insert del panel";
          }
		  
		  return $retorno;
     	
     }//fin metodo ingresarPrimerosPaneles
     
     
     //metodo para dar permisos al primer usuario
     public function primerosPermisosUsuario(){
     	
		$retorno = "";
		
		$query = "insert into 
						tb_permisos_usuarios (idPermiso, idUsuario, estado) 
					select idPermiso, '1', 'A' from tb_permisos;";
		
		if($this->conexionNuevaBD()->query($query)){
            $retorno = "insert del permisos Usuario ok";
          }else{
            $retorno = "falló el insert de los permisos usuario";
          }
		  
		  return $retorno;
		
		
     }//fin metodo primerosPermisosUsuario
          
     
     
 }//fin clase
 
 
 
 