<?php

/**
 * Controlador para agrupar las vistas
 **/
 
 //se llama al controlador para el login
 require_once("Controllers/login/loginController.php");
 
 require_once("Views/Layout/menuPWeb.phtml");
 
 $video = rand(1,9);
 
 //se llama al json que tiene los precios
 $data = file_get_contents("Views/index/resources/precios.json");
 $precios = json_decode($data, true);
 
 $tamano = sizeof($precios["precios"]);
 
?>



<div id="modal_terminosCondiciones" class="modal modal-fixed-footer" style="height: 88% !important ; width: 75% !important ;  max-height: 100% !important ;">
    <div class="modal-content">
      <h4 class="center-align"><?php echo $lang_index[46]//Terminos y condiciones?></h4>
      <p>                            	CONTRATO DE PRESTACIÓN DE SERVICIOS PARA EL MANEJO Y ARCHIVO DE INFORMACIÓN CLINICA <p/>
 
<p>  los suscritos a saber NanuVet,  por una parte y que en adelante se denominará como LA EMPRESA y por otra parte EL CLIENTE que acepta los términos 
	de acuerdo con el clausulado adjunto y que hace parte integral de este contrato y cuya aceptación es requisito para la prestación del servicio, 
	hemos decidido celebrar el contrato de utilización de servicios en la nube (S.a.a.S.-Software as a Service o software como servicio) para el archivo 
	y manejo de información, que consta en el documento que ahora se suscribe y que se rige por las cláusulas que se enuncian y en lo no previsto 
	en ellas por las disposiciones legales aplicables a la materia de qué trata este acto jurídico.</p>

<p>GLOSARIO:</p>
<p>PARTNER: es la empresa de servicios donde se alojan los datos físicos y cuya sede puede estar en un país fuera de Colombia.</p>
<p>INFRAESTRUCTURA: son todos los elementos físicos o no que permiten a la EMPRESA prestar el Servicio.</p>
<p> NanuVet o simplemente NanuVet: es el software desarrollado y propiedad de la empresa que permite realizar el manejo de la información del CLIENTE y cuya licencia hace parte del presente contrato con las condiciones mas adelante detalladas.</p>
<p> SOFTWARE COMO SERVICIO (S.a.a.S.- Software as a service): es un modelo de distribución de software donde el soporte lógico y los datos que maneja se alojan en servidores de una compañía de tecnologías de información y comunicación (TIC), a los que se accede con un navegador web desde un cliente, a través de Internet.</p> 
<p> PLATAFORMA: es el conjunto de servicios físicos y virtuales puestos a disposición del CLIENTE para el cabal cumplimiento del objeto del contrato.</p>
<p> CLIENTE: es la persona natural o jurídica, profesional veterinario en cualquier área, debidamente acreditado ante las autoridades competentes y demostrada tal calidad ante la EMPRESA o la persona jurídica cuyo fin es el  de contratar el Software como Servicio  que presta  la EMPRESA en el objeto de este contrato.</p>
<p> USUARIO: es la persona que utiliza el servicio.</p>
<p> ADMINISTRADOR: es la persona a quien inicialmente NanuVet le asigna el rol que permite parametrizar a los usuarios. El administrador solo podrá utilizar las funcionalidades de NanuVet cuando el mismo se configure como usuario de acuerdo con las políticas internas de la institución.</p>
<p> LA EMPRESA: es la sociedad especializada en diseños e implementación de soluciones tecnológicas quien presta el servicio de manejo de información médica en la nube y propietaria del Software NanuVet que permite este servicio. </p>
<p> LA PÁGINA: es el sitio web www.nanuvet.com donde el usuario accede a la prestación del servicio con el Software NanuVet y que posibilita el manejo de la información del CLIENTE acorde a la propuesta comercial.</p>
<p> INFORMACIÓN: son los datos propiedad del CLIENTE que se manejan con NanuVet los cuales son personales y privados con todos los derechos y responsabilidades que ello implica.</p>
<p>INTEOPERABILIDAD: es el intercambio de información mediante parámetros estándar. En el caso presente se refiere a la información que con el propósito de permitir una buena información clínica, se envía entre un aplicativo y otro.</p>
<p> CLAUSULAS:</p>
 <blockquote>
PRIMERA: OBJETO: lo constituye La autorización de uso del servicio de alojamiento de información y utilización de NanuVet y sus actualizaciones en la nube acorde a la propuesta comercial que hace parte integral del presente contrato. 
</blockquote>
 <blockquote>
SEGUNDA: Funciones de NanuVet: mediante la licencia de NanuVet para ser utilizada en LA PAGINA,  EL USUARIO puede hacer las siguientes funciones:
•    Configurar de manera personalizada algunas de las tablas de datos, enriqueciéndolas para su comodidad, activando o desactivando las ya configuradas mientras que no  cambien las adecuadas características técnico-científicas y de ley de los registros.
•    Ingresar registros tanto de pacientes nuevos como registrados previamente, bien sea para agendarlos, diligenciar datos demográficos y clínicos necesarios para la historia clínica y generar los documentos entregables derivados de ella.
•    Generar otros informes estadísticos que la EMPRESA implemente para comodidad en la generación de información para el cliente.
•    Todas las demás que los nuevos desarrollos permitan al cliente/usuario mayor comodidad y facilidad en la ejecución de su trabajo.
 </blockquote>
 <blockquote>
TERCERA: PROPIEDAD DE LA INFORMACIÓN: la información con que se alimenta el sistema es de propiedad exclusiva del CLIENTE, así mismo la responsabilidad sobre su contenido de manera que esté acorde a las normas y leyes que reglamenten la materia, no obstante, en las áreas de contenido público de la página EL USUARIO acepta que la EMPRESA  pueda usar, adaptar y/o modificar el contenido y pueda hacer usos honestos de la misma sin perjuicios de los derechos morales que sobre la misma tenga el USUARIO o el titular de la información.
 </blockquote>
  <blockquote>
INTEROPERABILIDAD:
<p> EL CLIENTE  autoriza a LA EMPRESA a enviar y archivar en el  servidor de LAS ENTIDADES ALIANZA con quienes él tenga convenio los datos relativos a los pacientes de dicha entidad que EL CLIENTE posea en la nube mediante el servicio prestado por LA EMPRESA  y por otra parte la posibilidad por parte del CLIENTE de consultar toda la Historia médica que LA ENTIDAD ALIANZA posea sobre el paciente de esa entidad.</p> 
<p>2: EL CLIENTE  autoriza a LA EMPRESA a crear un enlace con LAS ENTIDADES ALIANZA con quienes él tenga convenio con la finalidad que está última pueda acceder a los datos e historias clínicas de los pacientes adscritos a esta ENTIDADES ALIANZA y atendidos por EL CLIENTE y almacenar estas historias en sus servidores.</p> 
<p>3: El CLIENTE, podrá de igual forma acceder a las historias clínicas de los pacientes que esté tratando en ese momento a través de un repositorio  creado en los servidores de LA ENTIDAD ALIANZA y  que serán enviados de forma automática para su lectura; los datos recibidos de este repositorio no se podrán guardar ni modificar bajo ninguna circunstancia, para garantizar la integridad y custodia de la información.</p> 
<p>4: LA EMPRESA, se exime de cualquier responsabilidad por el contenido de la información y solo es responsable por el manejo de la misma.</p> 
</blockquote>
<blockquote>
CUARTA: CUENTAS DEMO: Una cuente DEMO o cuenta temporal de demostración, es utilizada por un usuario por un periodo máximo de 15 días calendario; Esta cuenta puede ser desactivada antes del plazo máximo anteriormente mencionado  si LA EMPRESA así lo decide. A demas LA EMPRESA tiene la autoridad de realizar cambios en las licencias del CLIENTE sin previo aviso.
</blockquote>
<blockquote>
QUINTA: DESTINO DE LA INFORMACIÓN POR SUPENSIÓN O TERMINACIÓN DEL CONTRATO: si el contrato se termina, la información será conservada durante un mes por seguridad en la plataforma, aunque no haya acceso a la misma, luego de ser entregada a su propietario en formatos txt, cvs y/o xls, según éste lo solicite; después de este lapso LA EMPRESA puede eliminarla sin responsabilidad de su parte. Si el cliente, desea que se le preste el servicio de solo custodia, podrá adquirirlo a las tarifas fijadas por la empresa. Los datos temporales se eliminaran una vez cumplan su ciclo. Si el USUARIO lo requiere en una estructura diferente podrá previo el pago de una tarifa fijada por la EMPRESA, y conforme a la capacidad tecnológica de la misma, obtener una copia de todos sus archivos para su migración a otra plataforma.
</blockquote>
<blockquote>
SEXTA: ACCESO A LA INFORMACIÓN: cada usuario es responsable de la creación y custodia de la contraseña o contraseñas de ingreso a la PLATAFORMA,  la misma podrá ser accedida desde cualquier parte del mundo que cumpla con las especificaciones técnicas mínimas para ello, incluyendo la conectividad al sistema,  la mala utilización es de su responsabilidad y podrá ser causal de terminación unilateral con justa causa del presente contrato y de eliminación o restricción de su acceso si con ella se vulnera los derechos de terceros.
</blockquote>

<blockquote>
SEPTIMA: RESPONSABILIDAD POR EL CONTENIDO DE LA INFORMACIÒN: en la medida en que la información sobre los servicios o productos ofrecidos, son de responsabilidad del USUARIO, LA EMPRESA no responderá por la seriedad o veracidad de los mismos y se excluye de cualquier responsabilidad de las consagradas en las normas de protección al consumidor.
</blockquote>
<blockquote>
OCTAVA: ACTUALIZACIONES DEL SISTEMA: LA EMPRESA es libre de actualizar el programa o cambiar de PARTNER garantizando al USUARIO la perfecta operatividad y la capacitación necesaria para el correcto funcionamiento, no obstante, estas actualizaciones son discrecionales de la EMPRESA y no una obligación.
</blockquote>
<blockquote>
NOVENA: SOPORTE DEL SISTEMA: dentro del precio del servicio no está contenido soporte o mantenimiento diferente al del servicio NanuVet, es decir soporte de internet, impresoras, equipos de propiedad del cliente.
</blockquote>
<blockquote>
DECIMA: PROPIEDAD INTELECTUAL: LA EMPRESA es titular de los derechos de autor sobre NanuVet y las marcas y demás signos distintivos de la página, EL USARIO reconoce esta titularidad y se compromete a respetar los derechos en cabeza de LA EMPRESA y del PARTNER, y no podrá usar los signos en su beneficio personal o de un tercero, ni reproducir, copiar o comercializar NanuVet y demás obras protegidas por el Derecho de autor aun para su uso personal.
</blockquote>
<blockquote>
DECIMO PRIMERA: AUTORIZACIÒN: para fines estadísticos y de referencia EL USUARIO autoriza a LA EMPRESA a recabar y usar su información conservándola con la respectiva reserva de los datos que la ameriten. LA EMPRESA en el desarrollo y mejora continua de su portafolio puede permitir que terceros ofrezcan sus productos y servicios o los promocionen. El USUARIO autoriza a LA EMPRESA  a realizar modificaciones en las opciones de todas las aplicaciones de la Herramienta para efectos de incluir en ellas listas desplegables con sugerencia de productos o servicios de diversa índole relacionados con la prestación de servicios médicos y de salud prestados por el USUARIO a pacientes o terceros.
</blockquote>
<p> 
No obstante la cláusula anterior, en los eventos en que se celebren actos o negocios entre terceros y los usuarios, estos serán completamente ajenos a la relación que regula este contrato, de manera que LA EMPRESA no tendrá responsabilidad alguna por defectos de dichos productos, o daños que pueda causar, con origen en defectos en su diseño, fabricación, embalaje, distribución, información o con origen en publicidad engañosa.
</p>
<blockquote>
DECIMO SEGUNDA: REQUISITOS TECNICOS: para el cabal desempeño de NanuVet y la PLATAFORMA  el usuario deberá contar con un equipo que reúna mínimo las siguientes características: equipo de cómputo con sistema operativo Windows desde XP hasta Windows 8, MAC o Linux, memoria RAM a partir de 1 Gb o superior, procesador de 2.8 ghz o superior, teclado, mouse de cualquier especificación, conexión a internet 2 Mb o superior; así mismo acepta mejorar estas características cuando las actualizaciones del sistema o el PARTNER lo requieran.
</blockquote>
<blockquote>
DECIMO TERCERA: SOPORTE TECNICO: por la misma naturaleza del servicio el soporte técnico no incluye el hardware o equipos del USUARIO, y se limita a la correcta operatividad del sistema. El soporte se hará en línea en horario laboral de la EMPRESA. La respuesta a la solicitud de servicio se hará en lo pertinente dentro de las 48 horas siguientes a la solicitud documentada ante la EMPRESA
</blockquote>
<blockquote>
DECIMO CUARTA: OBLIGACIONES DE LA EMPRESA: se obliga: 
a) Poner el software en estado de funcionamiento para el USUARIO. 
b) Entregar los tutoriales para autocapacitarse 
c) Realizar los mantenimientos por garantía y a solicitud 
d) Propender por que la plataforma se mantenga en operación dentro de sus posibilidades 
e) Atender oportunamente los reclamos del USUARIO
</blockquote>

<blockquote>
DECIMO QUINTA: OBLIGACIONES DEL USUARIO se obliga:

<p>a) Utilizar NanuVet acorde a los parámetros establecidos</p>
<p>b) Mantener los códigos de acceso bajo reserva y brindarles buen manejo</p> 
<p>c) No ceder ni vender los derechos sobre le presente contrato a ningún tercero</p> 
<p>d) Mantener su información por su cuenta y riesgo y alimentar su base de datos en NanuVet</p> 
<p>e) Responder por las faltas legales que sucedan por la mala utilización de NanuVet o por los datos que almacene en NanuVet</p> 
<p>f) Responder por la EMPRESA cuando sea llamado en garantía por la violación legal de cualquier índole ocasionada por culpa del usuario</p> 
<p>g) realizar los pagos estipulados por el uso de NanuVet y por los mantenimientos solicitados.</p>
</blockquote>
<blockquote>
DECIMA SEXTA: DURACIÒN, el presente contrato tendrá duración de un año y se prorrogará automáticamente por el mismo lapso, salvo que una o ambas partes manifiesten por escrito a las direcciones físicas o virtuales anotadas en el presente contrato, con al menos un mes de anticipación al vencimiento del contrato o sus prorrogas, la intención de darlo por terminado.
</blockquote>
<blockquote>
DECIMA SEPTIMA: VALOR DEL CONTRATO: el valor del contrato es el que está informado en la página WEB  de la EMPRESA y que por este acto EL CLIENTE acepta, tanto en el monto inicial como los pagos anuales y las formas de hacerlo. El no pago de las prorrogas por parte del USUARIO dará lugar a declarar el incumplimiento del contrato y cobrar la clausula penal independientemente de los demás daños y perjuicios que se puedan cobrar por las vías de resolución de conflictos operantes al presente contrato Parágrafo: el valor del contrato para los siguientes años será el que determine LA EMPRESA, y su incremento no deberá ser inferior al IPC del año inmediatamente anterior.
</blockquote>
<blockquote>
DECIMA OCTAVA: RELACIÓN DE LAS PARTES: el presente contrato no genera relación laboral entre las partes, y sus obligaciones y derechos están regidas por las cláusulas aquí contenidas y por el Código de Comercio en lo no regulado, así como por las Decisiones Supranacionales y Leyes que rigen los Derechos de Autor y Conexos, por tanto no son admisibles reclamaciones de índole laboral.
</blockquote>
<blockquote>
VIGESIMA: CLAUSULA PENAL: en caso de incumplimiento de lo aquí pactado, la parte incumplida pagará a la otra una suma equivalente al 50% del valor del contrato a manera de indemnización, sin perjuicio de las demás acciones civiles y penales a que haya lugar.
VIGESIMA PRIMERA: CLAUSULA COMPROMISORIA: todas las controversias que se susciten entre las partes con respecto a este contrato o con respecto a su interpretación, cumplimiento, vencimiento, cancelación, validez y terminación, serán resueltas de manera definitiva  por lo medios reconocidos de resolución de conflictos, inicialmente se intentará la conciliación entre las partes y sus apoderados de ser el caso; de no ser posible la conciliación se acudirá a la mediación de un tercero, escogido de común acuerdo por las partes, quien decidirá la controversia en equidad; de no ser posible elegir conjuntamente un mediador, se optará por el mecanismo alternativo del  arbitraje regido de acuerdo con la disposición del Código de Comercio de Colombia, Decreto 2279 de 1989, Ley 23 de 1991 y las normas que las adicionen o reformen y con sujeción a las reglas del Centro de Arbitraje y Conciliación de la Cámara de Comercio de Medellín, por intermedio de un solo árbitro que será designado por  la misma Cámara de Comercio y sus decisiones serán en derecho. Dicho tribunal sesionará en la ciudad de Medellín.

VIGESIMA SEGUNDA: DIVISIBILIDAD: se busca que este contrato se ejecute de acuerdo con y en toda la extensión permitida por la ley y disposiciones aplicables en Colombia. Si cualquier disposición de este Contrato o la aplicación del presente a cualquier persona o circunstancia es declarada nula o no ejecutable por cualquier razón y en cualquier medida, entonces el resto de este Contrato no se verá afectado por ello, sino que se hará valer en la medida permitida por la ley.

VIGESIMA TERCERA: NOTIFICACIONES: a efecto de notificar cualquier situación inherente al presente contrato, las partes podrán hacerlo válidamente a la dirección física o electrónica que a continuación se establece:
La EMPRESA: info@nanuvet.com
El CLIENTE: en la dirección de correo electrónico informada en la aceptación del contrato 
Parágrafo: cualquier cambio en las direcciones deberá ser comunicada por una parte a la otra de manera oportuna sopesa de entenderse realizadas todas las notificaciones que se hagan a las direcciones anotadas,    
VIGESIMA CUARTA: PERFECCIONAMIENTO: el presente contrato queda perfeccionado con la aceptación de estas clausulas expresadas virtualmente por las partes y que se constituyen en prerrequisito para el inicio en la prestación del servicio.
</blockquote>
                         	
                            
    </div>
    <div class="modal-footer">
      <a href="javascript:void(0)" class="modal-action modal-close waves-effect waves-green btn-flat "><?php echo $lang_botones[3]//Cerrar?></a>
    </div>
  </div>





<!-- modal para registrar un nuevo propietario en la replica-->
 <div id="modal_nuevoPropietarioReplica" class="modal modal-fixed-footer" style="height: 88% !important ; width: 75% !important ;  max-height: 100% !important ;">
    <div class="modal-content">
      <h4 class="center-align"><?php echo $lang_index[45]//Nuevo propietario?></h4>
            	
              	
              	  <input type="hidden" id="idPais"   name="idPais"    value="0"/>
                  
              	
              	 <div class="row">
              	 	
			        <div class="input-field col s12 m4 l4">
			          <input id="propietario_identificacion" name="propietario_identificacion" type="text" class="validate" length="30" maxlength="30" onkeypress="buscarPropietarioDesdeReplicaCreando(this.id)" >
			          <label id="label_propietario_identificacion" for="propietario_identificacion" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_perfil[1]//Identificación?></label>
			        </div>
			        
			        <div class="input-field col s12 m4 l4">
			          <input id="propietario_nombre" name="propietario_nombre" type="text" class="validate" length="30" maxlength="30">
			          <label id="label_propietario_nombre" for="propietario_nombre" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_perfil[2]//Nombres?></label>
			        </div>
			        
			        <div class="input-field col s12 m4 l4">
			          <input id="propietario_apellido" name="propietario_apellido" type="text" class="validate" length="30" maxlength="30">
			          <label id="label_propietario_apellido" for="propietario_apellido" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_perfil[3]//Apellido?></label>
			        </div>
			        
			      </div><!-- Fin row-->
			      
			      <div class="row">
			      	
			      	<div class="input-field col s12 m4 l4">
			          <input id="propietario_telefono" name="propietario_telefono" type="text" class="validate" length="20" maxlength="20">
			          <label id="label_propietario_telefono" for="propietario_telefono" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_general[0]//Teléfono ?></label>
			        </div>
			        
			        <div class="input-field col s12 m4 l4">
			          <input id="propietario_celular" name="propietario_celular" type="text" class="validate" length="20" maxlength="20">
			          <label id="label_propietario_celular" for="propietario_celular" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_general[2]//Celular ?> </label>
			        </div>
			        
			        <div class="input-field col s12 m4 l4">
			          <input id="propietario_direccion" name="propietario_direccion" type="text" class="validate" length="50" maxlength="50">
			          <label id="label_propietario_direccion" for="propietario_direccion" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_general[3]//Dirección?></label>
			        </div>
			      	
			      </div><!-- Fin row-->
			      
			      <div class="row">
			      	<div class="input-field col s12 m12 l12">
			      		<input id="propietario_email" name="propietario_email" type="email" class="validate" length="100" maxlength="100">
			            <label id="label_propietario_email" for="propietario_email" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:100%; text-align: left;" ><?php echo $lang_general[4] //E-mail ?> </label>
			      	</div>
			      </div><!-- Fin row-->
			      
			      <div class="row">
                          
                      <div class="input-field col s12 m4 l4">
                            <input id="pais" name="pais"  type="text" class="validate" onkeypress="buscarPaisReplica()" >
                            <label id="label_propietario_pais" for="pais" data-error="<?php echo $lang_error[0]//Debe completar este campo?>" data-success="<?php echo $lang_error[1]//Ok?>" style="width:95%; text-align: left;" ><?php echo $lang_general[5]//País (Escriba y seleccione)?></label> 
                      </div>
                      
                  </div><!-- fin row-->

                  <div class="row">
                    <div class="col s12 m12 l12 ">
                      <a class="waves-effect waves-light btn right" onclick="ValidarDatosNuevoPropietarioReplica()"><?php echo $lang_botones[2]//Guardar?></a>
                    </div>
                  </div>

              	
      
      
    </div>
    <div class="modal-footer">
      <a href="javascript:void(0)" class="modal-action modal-close waves-effect waves-red btn-flat "><?php echo $lang_botones[3]//Cerrar?></a>
    </div>
  </div>
<!-- Fin modal regristrar nuevo propietario en la replica-->


<main>
<?php
 require_once("Views/index/section_0.phtml");
 require_once("Views/index/section_1.phtml");
 require_once("Views/index/section_2.phtml");
 require_once("Views/index/section_4.phtml");
 require_once("Views/index/section_5.phtml");
 require_once("Views/index/section_6.phtml");
 require_once("Views/index/section_7.phtml");
?>
</main>
	    