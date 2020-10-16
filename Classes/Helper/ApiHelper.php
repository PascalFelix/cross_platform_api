<?php


namespace Classes\Helper;


use Classes\Request\EmptyRequest;
use Classes\Request\GetRequestHandler;
use Classes\Request\PutRequestHandler;
use Classes\Request\RequestHandler;

class ApiHelper
{
    protected array $_aRequest = array();

    /**
     * ApiHelper constructor.
     * @param array $aRequest
     */
    public function __construct(array $aRequest)
    {
        $this->_aRequest = $aRequest;
    }

    /**
     * @return RequestHandler
     */
    public function getRequestHandler(): RequestHandler
    {
        if (empty($this->_aRequest)) {
            return new EmptyRequest($this->_aRequest);
        } else if (array_keys($this->_aRequest)[0] == "get") {
            return new GetRequestHandler($this->_aRequest);
        } else if (array_keys($this->_aRequest)[0] == "put") {
            return new PutRequestHandler($this->_aRequest);
        }
    }

}