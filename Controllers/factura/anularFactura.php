<?php

/*
 * Archivo para anular una factura y todos sus items
 */
 
 $idFactura = $_POST['idFactura'];

 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura();
 
 $idPagoFacturaCaja =  $objetoFactura->anularFactura($idFactura);
 
 //metodo para anular todos los detalles de una factura
 $objetoFactura->anularTodosDetallesFactura($idPagoFacturaCaja);


?>