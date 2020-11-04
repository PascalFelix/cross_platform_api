<?php

function exception_handler($exception)
{
    wh_log($exception, 'errors');
}

function wh_log($log_msg, string $slogName)
{
    if (!file_exists('log')) {
        mkdir('log', 0777, true);
    }
    file_put_contents('log/' . $slogName, $log_msg . "\n", FILE_APPEND);
}

function apilog($mValue)
{
    wh_log(print_r($mValue, true), 'dump');
}

set_exception_handler('exception_handler');

require_once 'Autoloader.php';

$oAuto = new Autoloader('Exceptions');
$oAuto = new Autoloader('Helper');
include_once 'Classes/Request/RequestHandler.php';
$oAuto = new Autoloader('Request');
$oAuto = new Autoloader('Models');
$oAuto = new Autoloader('Tests');

