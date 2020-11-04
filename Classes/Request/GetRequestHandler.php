<?php


namespace Classes\Request;


use Classes\Models\Tweet;
use Classes\Models\TweetList;
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
            $aBody = $this->_aRequest;
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
                "type" => -1,
                "userid" => ""
            ]
        ];
        $oUser = new User();
        if ($oUser->loadByName($aBody["username"])) {
            if ($oUser->passwordsMatch($aBody["password"])) {
                $aReturn["result"]["type"] = 1;
                $aReturn["result"]["userid"] = $oUser->getId();
            } else {
                $aReturn["result"]["type"] = 2;
                $aReturn["result"]["userid"] = -1;
            }
        } else {
            //user dose not exist
            $aReturn["result"]["type"] = 3;
            $aReturn["result"]["userid"] = -1;
        }
        return $aReturn;
    }

    /**
     * @param array $aBody
     * @return array[]
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Exception
     */
    protected function _getTweet(array $aBody): array
    {
        $aReturn = ["result" =>
            [
                "content" => "",
                "likes" => 0,
                "retweets" => 0,
                "timestamp" => 0,
                "userid" => 0,
            ]
        ];

        $oTweet = new Tweet();
        if (!$oTweet->load($aBody["id"])) {
            throw new \Exception("No tweet for this ID");
        } else {
            $aReturn["result"]["content"] = $oTweet->getContent();
            $aReturn["result"]["userid"] = $oTweet->getUserID();
            $aReturn["result"]["timestamp"] = $oTweet->getTime();
            $aReturn["result"]["retweets"] = $oTweet->getRetweetCount();
            $aReturn["result"]["likes"] = $oTweet->getLikes();
        }

        return $aReturn;
    }

    /**
     * @param array $aBody
     * @return \array[][]
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    protected function _getTweets(array $aBody): array
    {
        $aReturn = ["result" =>
            [
                "tweetIds" => []
            ]
        ];
        $oTweetList = new TweetList();
        if($oTweetList->loadForUserID($aBody["id"],intval($aBody["offset"]))){
            $aReturn["result"]["tweetIds"] = $oTweetList->getTweetIds();
        }
        return $aReturn;
    }

    protected function _getComments(array $aBody): array
    {
        $oEmpty = new EmptyRequest($this->_aRequest);
        return $oEmpty->execute();
    }

    /**
     * @param array $aBody
     * @return \string[][]
     * @throws \Classes\Exceptions\NoDbConnection
     */
    protected function _getUser(array $aBody): array
    {
        $aReturn = ["result" =>
            [
                "username" => "",
                "follower" => "",
                "tweets" => "",
                "follows" => ""
            ]
        ];
        $oUser = new User();
        if($oUser->load($aBody["id"])){
            $aReturn["result"]["username"] = $oUser->getUserName();
            $aReturn["result"]["follower"] = $oUser->getFollowerCount();
            $aReturn["result"]["follows"] = $oUser->getFollowsCount();
            $aReturn["result"]["tweets"] = $oUser->getTweetCount();
        }else{
            throw new \Exception("No user for this ID");
        }

        return $aReturn;
    }


}