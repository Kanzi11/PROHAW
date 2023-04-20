<?php
require_once('../../entities/dto/detalle_pedido.php');


if (isset($_GET['action'])) {

    session_start();

    $detalle_pedido = new Detalle_Pedido;
    