<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;

class Comment extends BaseModel
{
    public function getTableName(): string
    {
        return 'comments';
    }

    public function getId(): string
    {
        return $this->ID;
    }
    public function getContent(): string
    {
        return $this->Content;
    }
    public function getTweetID(): string
    {
        return $this->TweetID;
    }
    public function getTimestamp(): string
    {
        return $this->Timestamp;
    }
    /**
     * @param string|null $sUserID
     * @return bool
     */
    public function userLikedComment(?string $sUserID): bool
    {
        if(!empty($sUserID)){

        }
        return false;
    }

    public function comment(User $oUser, string $sPassword, string $sTweetID,string $sComment): bool
    {
        if(!$oUser->passwordsMatch($sPassword)){
            throw new UserPasswordNotMatch($oUser->getUserName());
        }else{
            $sINSERT = "
         INSERT INTO comments (Content ,TweetID)
         VALUES ('".$sComment."',".$sTweetID.");
         ";
            apilog($sINSERT);
            return $this->_oDB->execute($sINSERT);
        }
    }

}