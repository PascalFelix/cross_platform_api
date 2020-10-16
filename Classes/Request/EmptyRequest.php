<?php


namespace Classes\Request;


class EmptyRequest extends RequestHandler
{
    public function execute(): array
    {
        return ["result" => null];
    }
}