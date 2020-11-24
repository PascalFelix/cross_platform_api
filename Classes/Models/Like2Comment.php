<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;

class Like2Comment extends BaseModel
{
    public function getTableName(): string
    {
        return 'like2tweet';
    }
    public function getId(): string
    {
        return intval($this->ID);
    }

    public function toggleLike(User $oUser, string $sPassword, string $sCommentID):bool
    {
        if(!$oUser->passwordsMatch($sPassword)){
            throw new UserPasswordNotMatch($oUser->getUserName());
        }else{

            $oLike2Tweet = new Like2Comment();
            if($oLike2Tweet->loadByCommentAndUser($oUser,$sCommentID)){
                //delete Like
                $sDelete = "
                DELETE FROM " . $this->getTableName() . "
                WHERE ID = '".$oLike2Tweet->getId()."';     
                ";
                return $this->_oDB->execute($sDelete);

            }else{
                //like tweet
                $sINSERT = "
                 INSERT INTO " . $this->getTableName() . " (CommentID, UserID)
                 VALUES ('" . $sCommentID . "'," . $oUser->getId() . ");
                 ";
                return $this->_oDB->execute($sINSERT);
            }

        }
    }

    public function loadByCommentAndUser(User $oUser,string $sCommentID): bool
    {
        $sSELECT = "
        SELECT l2c.ID
        FROM " . $this->getTableName() . " l2c
        WHERE l2c.UserID = '" . $oUser->getId() . "' and l2c.CommentID = '".$sCommentID."'
        ";
        $aResult = $this->_oDB->getAsArray($sSELECT);
        if (empty($aResult)) {
            return $this->load("-1");
        } else {
            return $this->load($aResult[0]["ID"]);
        }
    }

}