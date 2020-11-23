<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;

class user2user extends BaseModel
{
    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'user2user';
    }

    public function getId(): string
    {
        return "-1";
    }

    /**
     * @param User $oUser
     * @param string $sPassword
     * @param User $oTargetUser
     * @return bool
     * @throws UserPasswordNotMatch
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    public function toggleFollow(User $oUser,string $sPassword,User $oTargetUser)
    {
        if(!$oUser->passwordsMatch($sPassword)){
            throw new UserPasswordNotMatch($oUser->getUserName());
        }else{

            $oLike2Tweet = new user2user();
            if($oLike2Tweet->userAlreadyFollowsUser($oUser,$oTargetUser)){
                //delete follow
                $sDelete = "
                DELETE FROM " . $this->getTableName() . "
                WHERE UserID = '".$oUser->getId()."' and UserToFollowID = '".$oTargetUser->getId()."';     
                ";
                return $this->_oDB->execute($sDelete);

            }else{
                //like tweet
                $sINSERT = "
                INSERT INTO " . $this->getTableName() . "
                VALUES('".$oUser->getId()."' , '".$oTargetUser->getId()."');  
                 ";
                return $this->_oDB->execute($sINSERT);
            }

        }
    }

    /**
     * @param User $oUser
     * @param User $oTargetUser
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function userAlreadyFollowsUser(User $oUser, User $oTargetUser): bool
    {
        $sSelect = "
        SELECT count(*) as counter
        FROM user2user u2u
        WHERE u2u.UserID= '".$oUser->getId()."' AND u2u.UserToFollowID = '".$oTargetUser->getId()."'
        ";

        $aResult = $this->_oDB->getAsArray($sSelect);
        return  intval($aResult[0]['counter']) != 0;
    }


}