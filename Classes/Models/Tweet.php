<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;

class Tweet extends BaseModel
{
    public function getTableName(): string
    {
        return 'tweets';
    }

    public function getContent(): string
    {
        return $this->Content;
    }

    public function getLikes(): int
    {
        return intval($this->Likes);
    }

    public function getRetweetCount(): int
    {
        return intval($this->Retweets);
    }
    public function getId(): string
    {
        return $this->ID;
    }
    public function getUserID(): string
    {
        return $this->UserID;
    }
    public function getTime(): string
    {
        return $this->Timestamp;
    }

    /**
     * @param User $oUser
     * @param string $sPassword
     * @param string $sTweet
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    public function tweet(User $oUser, string $sPassword, string $sTweet)
    {
        if(!$oUser->passwordsMatch($sPassword)){
            throw new UserPasswordNotMatch($oUser->getUserName());
        }else{
         $sINSERT = "
         INSERT INTO tweets (Content, UserID)
         VALUES ('".$sTweet."',".$oUser->getId().");
         ";
         return $this->_oDB->execute($sINSERT);
        }
    }

    /**
     * @param string $sUserID
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function userLikedTweet(string $sUserID): bool
    {
        if(!empty($sUserID)){
            apilog($sUserID);
            $oTemp = new Like2Tweet();
            $oUser = new User();
            $oUser->load($sUserID);
            return $oTemp->loadByUserIdAndTweetID($oUser,$this->getId());
        }else{
            return false;
        }
    }


}