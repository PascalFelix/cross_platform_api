<?php


namespace Classes\Request;


use Classes\Models\Feed;
use Classes\Models\Like2Tweet;
use Classes\Models\Tweet;
use Classes\Models\User;

class PutRequestHandler extends RequestHandler
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
            $aBody = $this->_aRequest;
            switch ($aBody["type"]) {
                case "tweet":
                    return $this->_tweet($aBody);
                case "like":
                    return $this->_like($aBody);
                case "registeruser":
                    return $this->_registerUser($aBody);
                case "togglefollow":
                    return $this->_toggleFollow($aBody);
                default:
                    $oEmpty = new EmptyRequest($this->_aRequest);
                    return $oEmpty->execute();
            }
        } catch (\Exception $exception) {
            $oEmpty = new EmptyRequest($this->_aRequest);
            return $oEmpty->execute();
        }
    }

    protected function _toggleFollow(array $aBody):array
    {
        $aReturn = ["result" =>
            [
                "status" => false
            ]
        ];
        try {
            $oUser = new User();
            $oUser->load($aBody["userid"]);
            $oTargetUser = new User();
            $oTargetUser->load($aBody["targetuserid"]);
            $aReturn["result"]["status"] = $oUser->toggleFollow($oTargetUser,$aBody["password"]);
        } catch (\Exception $exception) {

        }
        return $aReturn;
    }

    protected function _registerUser(array $aBody):array
    {
        $aReturn = ["result" =>
            [
                "status" => false
            ]
        ];
        try {
            $oUser = new User();
            $aReturn["result"]["status"] = $oUser->registerUser($aBody["username"], $aBody["password"]);
        } catch (\Exception $exception) {

        }
        return $aReturn;
    }

    protected function _like(array $aBody): array
    {
        $aReturn = ["result" =>
            [
                "status" => false
            ]
        ];
        try {
            $oLike2Tweet = new Like2Tweet();
            $oUser = new User();
            $oUser->loadByName($aBody["username"]);
            $aReturn["result"]["status"] = $oLike2Tweet->toggleLike($oUser, $aBody["password"], $aBody["tweetid"]);
        } catch (\Exception $exception) {

        }
        return $aReturn;
    }

    protected function _tweet(array $aBody):array
    {
        $aReturn = ["result" =>
            [
                "status" => false
            ]
        ];
        try {
            $oTweet = new Tweet();
            $oUser = new User();
            $oUser->loadByName($aBody["username"]);
            $aReturn["result"]["status"] = $oTweet->tweet($oUser, $aBody["password"], $aBody["tweet"]);
        } catch (\Exception $exception) {

        }
        return $aReturn;
    }
}