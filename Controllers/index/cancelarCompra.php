<?php

/**
 * Archivo llamado con un ajax para cancelar una compra y mostrar nuevamente el formulario de compra de section_5
 * */

//se consulta el archivo json para consultar los precios
 $data = file_get_contents("../../Views/index/resources/precios.json");
 $precios = json_decode($data, true);
 
//se llama la vista que contiene el formulario
 require_once("../../Views/index/section_5xCancelacion.phtml");