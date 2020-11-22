<?php


namespace Classes\Models;


use Classes\Exceptions\ObjectNotLoadedException;
use Classes\Helper\dbConnector;

class TweetList
{
    protected ?dbConnector $_oDB = null;
    protected bool $_bIsLoaded = false;


    protected int $_iMaxLoadCount = 10;
    protected array $_aTweets = array();

    public function __construct()
    {
        $this->_oDB = new dbConnector();
    }

    /**
     * @param string $sId
     * @param int $iOffset
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function loadForUserID(string $sId, int $iOffset): bool
    {
        $sSelect = "
        SELECT t.ID
        FROM tweets t
        WHERE t.UserID = '" . $sId . "'
        ORDER BY t.Timestamp desc
        LIMIT " . $this->_iMaxLoadCount . " OFFSET " . $iOffset . "
        ";

        $aResult = $this->_oDB->getAsArray($sSelect);
        foreach ($aResult as $key => $aRow) {
            $oTweet = new Tweet();
            if ($oTweet->load($aRow["ID"])) {
                $this->_aTweets[] = $oTweet;
            }
        }

        $this->_bIsLoaded = true;
        return true;
    }

    /**
     * @return array
     * @throws ObjectNotLoadedException
     */
    public function getTweetIds(): array
    {
        if ($this->_bIsLoaded) {
            $aReturn = [];
            /**
             * @var $oTweet Tweet
             */
            foreach ($this->_aTweets as $oTweet) {
                $aReturn[] = $oTweet->getId();
            }
            return $aReturn;
        } else {
            throw new ObjectNotLoadedException("TweetList was not loaded");
        }
    }


}