<?php

set_time_limit(0);
session_start();

require_once (dirname(__FILE__) . "/libs/Smarty/Smarty.class.php");
require_once (dirname(__FILE__) . "/libs/propel/Propel.php");

require_once (dirname(__FILE__) . "/controller/smartyController.php");
require_once (dirname(__FILE__) . "/controller/despachador.php");
require_once (dirname(__FILE__) . "/controller/appController.php");
require_once (dirname(__FILE__) . "/controller/funcion.php");
require_once (dirname(__FILE__) . "/controller/user.php");
require_once (dirname(__FILE__) . "/controller/profesor.php");

Propel::init(dirname(__FILE__) . '/conf/mathgraph-conf.php');

if (isset($_SESSION['user'])) {
    DespacharUser();
} else {
    Despachar();
}


