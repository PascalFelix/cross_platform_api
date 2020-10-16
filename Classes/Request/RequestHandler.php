<?php


namespace Classes\Request;


abstract class RequestHandler
{
    protected array $_aRequest = array();

    /**
     * GetRequestHandler constructor.
     * @param array $aRequest
     */
    public function __construct(array $aRequest)
    {
        $this->_aRequest = $aRequest;
    }
    abstract public function execute():array;

}