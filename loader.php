<?php
require_once 'Autoloader.php';

$oAuto = new Autoloader('Exceptions');
$oAuto = new Autoloader('Helper');
include_once 'Classes/Request/RequestHandler.php';
$oAuto = new Autoloader('Request');
$oAuto = new Autoloader('Models');
$oAuto = new Autoloader('Tests');