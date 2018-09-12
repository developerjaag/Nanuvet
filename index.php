<?php

	//para que la sesion dure 2 horas 
	//ini_set("session.cookie_lifetime","7200");
	//ini_set("session.gc_maxlifetime","7200");

	if(!isset($_SESSION)){
		    session_start();
		}
	
	//evitar cache
	/*header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");*/
	
	require_once('Config/config.php');//se importa las configuraciones

	//decision para implementar archivos
        
        if(!empty($_GET["accion"])){
    
            $accion=$_GET["accion"];
        }else{
            
            $accion="index";
        }
        
    //decision para el idioma
        if(isset($_SESSION['usuario_idioma'])){
    
            $idiomaIndex = $_SESSION['usuario_idioma'];
			//$idiomaIndex = "En";
     
        }else{
            $idiomaIndex = Config::getUserLanguage();
            
            switch ($idiomaIndex) {
            	case 'es':
            		$idiomaIndex="Es";
            		break;
            		
            	case 'en':
            		$idiomaIndex="En";
            		break;
            	
            	default:
            		$idiomaIndex="Es";
            		break;
            }
            
            
        }//fin else para detectar idioma   

        
?>


<!Doctype html>
<html lang="<?php echo $idiomaIndex ?>">






<head>

	<title>NanuVet - Historias clínicas veterinarias</title>
	
	<link rel="shortcut icon" href="<?php echo Config::ruta()?>Public/img/logos/favicon.png">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Jheison Alexander Alzate">
	<meta name="owner" content="Jheison Alexander Alzate" />
	<meta name="application-name" content="NanuVet" />
	<meta name="description" content="Software de historias clínicas veterinarias elaborado para realizar un trabajo rapido y eficaz, buscando ayudar en el día a día de los médicos veterinarios" />
	
	<meta name="keywords" content="software, mascotas, animales, veterinaria, historia clínica" />
	
	<meta name="robots" content="index, follow" />
	
	<!-- Evitar cache-->
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">	
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">	
	<meta http-equiv="Pragma" content="no-cache">
	

<!-- Google analitycs-->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-89647072-1', 'auto');
	  ga('send', 'pageview');
	
	</script>
<!-- Google analitycs-->



	
	<!-- Css-->

<?php
		if($accion == 'agenda'){
?>
			<!-- Fullcalendar-->
			<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/fullcalendar-3.0.1/fullcalendar.css" />
			<!-- Fullcalendar-->
<?php			
		}
?>	

	
		<!-- timeTo (trabajando--archivo temporal)-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/timeTo/timeTo.css" />
		
		<!-- Intro -tutorial interactivo- -->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/intro.js-2.4.0/introjs.css" />


    <!-- Jquery -->
    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/jquery-2.2.0.min.js"></script>	
		
	<!-- Intro js -->
    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/intro.js-2.4.0/intro.js"></script>
	
    
		<!-- sweet alert-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/sweetalert2-master/dist/sweetalert2.css" />
		
		<!-- Jquery ui-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/jquery-ui-1.11.4/jquery-ui.min.css" />
		
	    <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <!-- datetimepicker-->
        <link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/datetimepicker-master/jquery.datetimepicker.css" />
        
        
		<!-- materialize-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/materialize/css/materialize.css" />



		<!-- iconos font awesome-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/font-awesome-4.5.0/css/font-awesome.min.css" />
		
				
		<!-- Animated-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/css/animate.css" />
		
		<!-- full page -->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/fullpage/jquery.fullPage.css" />
	
		
		<!-- Estilos generales -->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/css/css_general.css" />
		
		

<?php
        //importar css segun modulo cargado               
        if(is_file("Public/css/".$accion.".css")){
?>
            <link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/css/<?php echo $accion ?>.css" />           
<?php  
        }
?>	


		<!-- Offline-->
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/offline-0.7.13/themes/offline-theme-dark.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/offline-0.7.13/themes/offline-language-<?php echo $idiomaIndex?>-indicator.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Config::ruta()?>Public/libs/offline-0.7.13/themes/offline-language-<?php echo $idiomaIndex?>.css" />

	
	<!-- Fin Css -->


	
</head>

<body style="overflow-y: scroll !important;">
	
	
	
<?php
        //importar archivo de idioma
        require_once("Lang/".$idiomaIndex.".php");

        //importar controladores
				
		if(is_file("Controllers/".$accion."/".$accion."Controller.php")){

        	require_once("Controllers/".$accion."/".$accion."Controller.php");
	
        }else{
        	
        	require_once("Controllers/error/errorController.php");
        } 
		
?>
	
	
	<!-- Js -->
	
		
	
		<!-- gmaps-->
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyC8RGCnDieRGPEOYhW3KakiwMoa6r0GFUo"></script>
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/gmaps-master/gmaps.js" ></script>
	    <!-- timeTo (trabajando--archivo temporal)-->
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/timeTo/jquery.time-to.js"></script>
	    
	    <!-- Jquery UI -->
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	    

<?php
		if($accion == 'agenda'){
?>
			<!-- Fullcalendar-->
			 <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/fullcalendar-3.0.1/lib/moment.min.js"></script>
			 <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/fullcalendar-3.0.1/fullcalendar.js"></script>
			 <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/fullcalendar-3.0.1/locale-all.js"></script>
			<!-- Fullcalendar-->
<?php			
		}
?>	

	    
	    <!-- datetimepicker-->
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/datetimepicker-master/build/jquery.datetimepicker.full.js"></script>
	    
	    <!-- sweet alert -->
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/sweetalert2-master/dist/sweetalert2.min.js"></script>
	    
	    
	    <!-- scroll inside sections-->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/fullpage/vendors/jquery.slimscroll.min.js"></script>
		
	    <!-- full page-->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/fullpage/jquery.fullPage.js"></script>
		
		<!-- Leterin-->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/letering/jquery.lettering.js"></script>
		
		<!-- textillate-->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/textillate/jquery.textillate.js"></script>
		
	    
	    <!-- materialize-->
	    <script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/materialize/js/materialize.min.js"></script>
	    
		

		
		<!-- Funciones generales -->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/js/js_general.js"></script>

		<!--Archivo js segun idioma -->
		<script type="text/javascript" src="<?php echo Config::ruta()?>Lang/<?php echo $idiomaIndex?>.js"></script>

<?php        
        //importar archivos js segun modulo
        if(is_file("Public/js/".$accion.".js")){
?>           
            <script type="text/javascript" src="<?php echo Config::ruta()?>Public/js/<?php echo $accion?>.js"></script>          
<?php  
        }
?>

		<!-- offline--> 
		<script type="text/javascript" src="<?php echo Config::ruta()?>Public/libs/offline-0.7.13/offline.min.js"></script>

	<script>
		$(document).ready(function () {
			
			//para activar los Dropdown del menu
			$(".dropdown-button").dropdown({hover: false});
			//para el boton de barras en vista mobil
			$(".button-collapse").sideNav();
			//para contar los caracteres en los campos
			$('input#input_text').characterCounter();
			//para mostrar los tooltips
			$('.tooltipped').tooltip({delay: 50});
			//para cargar los modales
			$('.modal-trigger').leanModal();
			//para las tabs
			//$('ul.tabs').tabs();
			//para los select
			$('select').material_select();
			//Para ampliar las imagenes
			$('.materialboxed').materialbox();
			//para inicializar el menu lateral
			$(".button-collapse").sideNav();
			
			
			
			<?php
				if(isset($_SESSION['mensaje'])){
			?>
  					Materialize.toast('<?php echo $_SESSION['mensaje']?>', 4000);
  			<?php
				}
			?>
			
			//para validar las
				Offline.options ={	
					
					// Should we check the connection status immediatly on page load.
					  checkOnLoad: true,
					
					  // Should we monitor AJAX requests to help decide if we have a connection.
					  interceptRequests: true,
					
										
					  // Should we store and attempt to remake requests which fail while the connection is down.
					  requests: false,
					
					  // Should we show a snake game while the connection is down to keep the user entertained?
					  // It's not included in the normal build, you should bring in js/snake.js in addition to
					  // offline.min.js.
					  game: false
					
					};
					
			
			<?php
				if(isset($_SESSION['usuario_idUsuario'])){
			?>
				
				setInterval('refresSession()',1020000);	

  			<?php
				}
			?>			
			
			
			<?php
				if($accion == "index"){
			?>
					$.fn.fullpage.reBuild();
			<?php		
				}
			?>
			

		});
		
		
	</script>

			
	<!-- Fin Js -->
	
</body>

</html>

<?php
	unset ($_SESSION['mensaje']);
?>