<?php


namespace Classes\Request;


use Classes\Models\User;

class GetRequestHandler extends RequestHandler
{

    public function __construct(array $aRequest)
    {
        parent::__construct($aRequest);
    }

    public function execute(): array
    {
        try {
            /**
             * "tpye" => "$type"
             */
            $aBody = $this->_aRequest["get"];
            switch ($aBody["type"]) {
                case "user":
                    return $this->_getUser($aBody);
                case "tweet":
                    return $this->_getTweet($aBody);
                case "tweets":
                    return $this->_getTweets($aBody);
                case "login":
                    return $this->_getLogin($aBody);
                case "comments":
                    return $this->_getComments($aBody);
                default:
                    $oEmpty = new EmptyRequest($this->_aRequest);
                    return $oEmpty->execute();
            }
        } catch (\Exception $exception) {
            $oEmpty = new EmptyRequest($this->_aRequest);
            return $oEmpty->execute();
        }
    }

    /**
     * @param array $aBody
     * @return \int[][]
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    protected function _getLogin(array $aBody): array
    {
        $aReturn = ["result" =>
            [
                "type" => -1
            ]
        ];
        $oUser = new User();
        if ($oUser->loadByName($aBody["username"])) {
            if ($oUser->passwordsMatch($aBody["password"])){
                $aReturn["result"]["type"] = 1;
            }else{
                $aReturn["result"]["type"] = 2;
            }
        } else {
            //user dose not exist
            $aReturn["result"]["type"] = 3;
        }
        return $aReturn;
    }

    protected function _getTweet(array $aBody): array
    {
        return array();
    }

    protected function _getTweets(array $aBody): array
    {
        return array();
    }

    protected function _getComments(array $aBody): array
    {
        return array();
    }

    protected function _getUser(array $aBody): array
    {
        return array();
    }


}