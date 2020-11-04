<?php

include 'loader.php';

$oRequest = new \Classes\Helper\PostRequestHelper();

try {
    $oApiHelper = new \Classes\Helper\ApiHelper($_POST);
    echo json_encode($oApiHelper->getRequestHandler()->execute());

} catch (\Exception $exception) {
    throw $exception;
}

