<?php
namespace Classes\Tests;

class ApiTest
{
    public function __construct()
    {
        $this->_getUserTest();
        $this->_getTweetsTest();
        $this->_getTweetTest();
        $this->_loginTests();
    }
    protected function _getUserTest()
    {
        echo '<br>';
        echo ' START get user Test';
        echo '<br>';

        $aRequest = [
            "get" => [
                "type" => "user",
                "id" => "1"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());
        echo '<br>';

        $aRequest = [
            "get" => [
                "type" => "user",
                "id" => "-1"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());

        echo '<br>';
        echo ' END get user Test';
        echo '<br>';
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

    protected function _getTweetsTest()
    {
        echo '<br>';
        echo ' START get tweets Test';
        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "tweets",
                "id" => "1",
                "offset" => "0"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());

        echo '<br>';
        $aRequest = [
            "get" => [
                "type" => "tweets",
                "id" => "1",
                "offset" => "5"
            ]
        ];
        $oApiHelper = new \Classes\Helper\ApiHelper($aRequest);
        print_r($oApiHelper->getRequestHandler()->execute());

        echo '<br>';
        echo ' END get tweets Test';
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