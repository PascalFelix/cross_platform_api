<?php

echo '<h1>Hello World</h1>';
include 'loader.php';
//echo phpinfo ();

try {
    $oTest = new \Classes\Helper\dbConnector();
    var_dump($oTest->getAsArray("SELECT * FROM user WHERE ID = '2'"));
    echo '<br>';
    var_dump($oTest->getAsArray("DESCRIBE user"));

}catch (\Exception $exception){

    var_dump($exception->getMessage());
}

