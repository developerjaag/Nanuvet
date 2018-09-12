<?php

/*
 * Archivo para anular un item de la factura
 */
 
 require_once("../../Config/config.php");
 require_once("../../Models/factura_model.php");
 
 $objetoFactura = new factura();
 
 $idDetalleParaAnular = $_POST['idDetalleParaAnular'];
 
 $objetoFactura->anularItemDetalle($idDetalleParaAnular) ;

?>