CREATE database `AAAweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

use AAAweb;

/*tabla para almacenar los registros de los clientes*/
create table if not exists tb_registrosClientes(

 idRegistroCliente			int auto_increment,
 identificacion				varchar(50) not null,
 nombre						varchar(100) not null,
 nombrePersonaContacto		varchar(100),
 telefono1					varchar(20) not null,
 telefono2					varchar(20),
 celular					varchar(20) not null,
 direccion					varchar(100),
 email						varchar(100) not null,
 nombrePais					varchar(50),
 nombreCiudad				varchar(50),
 cantidadLicencias			int,
 fechaRegistro				date,
 horaRegistro				time,
 valorPago					varchar(50),
 descripcionVenta			varchar(255),
 referenciaVenta			varchar(255) not null,
 
 primary key (idRegistroCliente)

);

/*------*/


/*tabla para almacenar las respuestas de los pagos*/
create table if not exists tb_respuestaPagos(

 idRegistroClie								int auto_increment,
 merchantId									int,
 transactionState							int,
 risk										float,
 polResponseCode							varchar(65),
 referenceCode								varchar(255),
 reference_pol								varchar(255),
 signature									varchar(255),
 polPaymentMethod							int,
 installmentsNumber							int,
 TX_VALUE									float,
 TX_TAX										float,
 buyerEmail									varchar(255),
 processingDate								datetime,
 currency									varchar(10),
 cus										varchar(255),
 pseBank									varchar(255),
 lng										varchar(10),
 description								varchar(255),
 lapResponseCode							varchar(65),
 lapPaymentMethod							varchar(255),
 lapPaymentMethodType						varchar(255),
 lapTransactionState						varchar(50),
 message									varchar(255),
 extra1										varchar(255),
 extra2										varchar(255),
 extra3										varchar(255),
 authorizationCode							varchar(20),
 merchant_address							varchar(255),
 merchant_name								varchar(255),
 merchant_url								varchar(255),
 orderLanguage								varchar(5),
 pseCycle									int,
 pseReference1								varchar(255),
 pseReference2								varchar(255),
 pseReference3								varchar(255),
 telephone									varchar(20),
 transactionId								varchar(50),
 trazabilityCode							varchar(100),
 TX_ADMINISTRATIVE_FEE						float,
 TX_TAX_ADMINISTRATIVE_FEE					float,
 TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE		float,
 action_code_description					varchar(255),
 cc_holder									varchar(255),
 cc_number									varchar(255),
 processing_date_time						varchar(255),
 request_number								varchar(255),
 
 primary key (idRegistroClie)

);
/*-------*/

/*Tabla para lamacenar la confirmación del pago*/
create table if not exists tb_confirmacion(

 idConfirmacion					int auto_increment,
 merchant_id					int,
 state_pol						varchar(20),
 risk							float,
 response_code_pol				varchar(255),
 reference_sale					varchar(255),
 reference_pol					varchar(255),
 sign							varchar(255),
 extra1							varchar(255),
 extra2							varchar(255),
 payment_method					int,
 payment_method_type			int,
 installments_number			int,
 value							float,
 tax							float,
 additional_value				float,
 transaction_date				datetime,
 currency						float(20),
 email_buyer					varchar(255),
 cus							varchar(100),
 pse_bank						varchar(255),
 test							varchar(20),
 description					varchar(255),
 billing_address				varchar(255),
 shipping_address				varchar(255),
 phone							varchar(255),
 office_phone					varchar(250),
 account_number_ach				varchar(100),
 account_type_ach				varchar(100),
 administrative_fee				float,
 administrative_fee_base		float,
 administrative_fee_tax			float,
 airline_code					varchar(10),
 attempts						int,
 authorization_code				varchar(20),
 bank_id						varchar(255),
 billing_city					varchar(255),
 billing_country				varchar(5),
 commision_pol					float,
 commision_pol_currency			varchar(5),
 customer_number				int,
 date							datetime,
 error_code_bank				varchar(255),
 error_message_bank				varchar(255),
 exchange_rate					float,
 ip								varchar(50),
 nickname_buyer					varchar(150),
 nickname_seller				varchar(150),
 payment_method_id				int,
 payment_request_state			varchar(50),
 pseReference1					varchar(255),
 pseReference2					varchar(255),
 pseReference3					varchar(255),
 response_message_pol			varchar(255),
 shipping_city					varchar(100),
 shipping_country				varchar(100),
 transaction_bank_id			varchar(255),
 transaction_id					varchar(50),
 payment_method_name			varchar(255),
 resultadoFirmas				varchar(45),
 resultadoTransaccion			varchar(200),
 
 primary key (idConfirmacion)

);
/*--------*/


/*Tabla para almacenar los registros del directorio*/
create table if not exists tb_registrosDirectorio(

 idRegistroDirectorio			int auto_increment,
 identificacion					varchar(50) not null,
 nombre							varchar(100) not null,
 telefono1						varchar(20) not null,
 telefono2						varchar(20),
 celular						varchar(20) not null,
 direccion						varchar(100) not null,
 latitud						varchar(200) not null,
 longitud						varchar(200) not null,
 urlImagen						varchar(300),
 email							varchar(100) not null,
 nombrePais						varchar(50) not null,
 nombreCiudad					varchar(50) not null,
 fechaRegistro					date,
 horaRegistro					time,
 fechaInicio					date,
 fechaFin						date,
 valorPago						float,
 descripcionVenta				varchar(255),
 referenciaVenta				varchar(255),
 estado							enum('Activo','PendientePago','Inactivo','Caducado'),

 primary key (idRegistroDirectorio)

);
/*--------*/

/*Tabla para registrar los mensajes de los usuarios en contactenos*/
create table if not exists tb_mensajesContactenos(

	idMensajeContactenos		int unsigned auto_increment,
    nombrePersona				varchar(100),
    email						varchar(200),
    mensaje						varchar(500),
    fechaHora					datetime,
    estado						enum('Registrado','Respondido','Leido'),
    
    
    primary key (idMensajeContactenos)
    
);
/*------------*/



