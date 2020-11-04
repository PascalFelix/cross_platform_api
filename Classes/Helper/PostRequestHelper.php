<?php


namespace Classes\Helper;


class PostRequestHelper
{

    public function getRequestValue(string $sKey)
    {
        if(empty($_POST[$sKey])){
            return null;
        }else{
            return $_POST[$sKey];
        }
    }


}