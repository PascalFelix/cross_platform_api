<?php
namespace Classes\Tests;

class ApiTest
{
    public function __construct()
    {
        $this->_getTweetTest();
        $this->_loginTests();
    }
    protected function _getTweetTest()
    {
        echo '<br>';
        echo ' START get tweet Test';
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "tweet",
                "id" => "1"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "tweet",
                "id" => "-1"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';
        echo ' END get tweet Test';
        echo '<br>';
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