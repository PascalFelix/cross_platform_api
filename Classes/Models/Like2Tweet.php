<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;

class Like2Tweet extends BaseModel
{
    public function getTableName(): string
    {
        return 'like2tweet';
    }
    public function getTweetID(): string
    {
        return $this->TweetID;
    }
    public function getUserID(): string
    {
        return $this->UserID;
    }

    public function getId(): string
    {
        return intval($this->ID);
    }

    public function toggleLike(User $oUser, string $sPassword, string $sTweetID):bool
    {
        if(!$oUser->passwordsMatch($sPassword)){
            throw new UserPasswordNotMatch($oUser->getUserName());
        }else{

            $oLike2Tweet = new Like2Tweet();
            if($oLike2Tweet->loadByUserIdAndTweetID($oUser,$sTweetID)){
                //delete Like
                $sDelete = "
                DELETE FROM " . $this->getTableName() . "
                WHERE ID = '".$oLike2Tweet->getId()."';     
                ";
                return $this->_oDB->execute($sDelete);

            }else{
                //like tweet
                $sINSERT = "
                 INSERT INTO " . $this->getTableName() . " (TweetID, UserID)
                 VALUES ('" . $sTweetID . "'," . $oUser->getId() . ");
                 ";
                return $this->_oDB->execute($sINSERT);
            }

        }
    }

    public function removeLike(User $oUser,string $sPassword,string $sTweetID):bool
    {
        return false;
    }
    public function loadByUserIdAndTweetID(User $oUser,string $sTweetID): bool
    {
        $sSELECT = "
        SELECT t.ID
        FROM " . $this->getTableName() . " t
        WHERE t.UserID = '" . $oUser->getId() . "' and t.TweetID = '".$sTweetID."'
        ";
        $aResult = $this->_oDB->getAsArray($sSELECT);
        if (empty($aResult)) {
            return $this->load("-1");
        } else {
            return $this->load($aResult[0]["ID"]);
        }
    }



}