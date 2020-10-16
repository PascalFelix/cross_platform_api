<?php
namespace Classes\Tests;

class ApiTest
{
    public function __construct()
    {
        $this->_loginTests();
    }
    protected function _loginTests()
    {
        echo '<br>';
        echo ' START login Test';
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "login",
                "username" => "Test",
                "password" => "123"
            ]
        ];

        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "login",
                "username" => "Test2",
                "password" => "123"
            ]
        ];

        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "login",
                "username" => "Test23",
                "password" => "123"
            ]
        ];

        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        $aRequest = [

        ];

        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        echo ' END login Test';
    }
}