<?php


namespace Classes\Request;


class PutRequestHandler extends RequestHandler
{
    public function __construct(array $aRequest)
    {
        parent::__construct($aRequest);
    }

    public function execute(): array
    {
        return array();
    }
}