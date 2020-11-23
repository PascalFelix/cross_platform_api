<?php


namespace Classes\Models;


use Classes\Exceptions\ObjectNotLoadedException;

class User extends BaseModel
{

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'user';
    }

    /**
     * @param string $sUserName
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function loadByName(string $sUserName): bool
    {
        $sSELECT = "
        SELECT t.ID
        FROM " . $this->getTableName() . " t
        WHERE t.UserName = '" . $sUserName . "'
        ";
        $aResult = $this->_oDB->getAsArray($sSELECT);
        if (empty($aResult)) {
            return $this->load("-1");
        } else {
            return $this->load($aResult[0]["ID"]);
        }
    }

    /**
     * @param string $sPassword
     * @return bool
     * @throws ObjectNotLoadedException
     */
    public function passwordsMatch(string $sPassword): bool
    {
        if ($this->_bIsLoaded) {
            if ($this->{'Password'} == $sPassword) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ObjectNotLoadedException("User object was not loaded yet");
        }
    }

    public function getId(): string
    {
        return $this->ID;
    }

    public function getUserName(): string
    {
        return $this->UserName;
    }

    public function getFollowerCount(): string
    {
        return $this->Follower;
    }

    public function getFollowsCount(): string
    {
        return $this->Follows;
    }

    public function getTweetCount(): string
    {
        $sSelect = "
        SELECT count(*) as counter
        FROM tweets v
        WHERE v.UserID = '" . $this->getId() . "'
        ";
        $var = $this->_oDB->getAsArray($sSelect);
        return strval($var[0]['counter']);
    }

    public function isUserNameTaken(string $sUsername): bool
    {
        $sSelect = "
        SELECT count(*) as counter
        FROM user v
        WHERE v.UserName = '" . $sUsername . "'
        ";
        $var = $this->_oDB->getAsArray($sSelect);
        return intval(strval($var[0]['counter'])) == 0 ? false : true;
    }

    public function registerUser(string $sUsername, string $sPassword): bool
    {
        $sINSERT = "
                 INSERT INTO " . $this->getTableName() . " (UserName, Password)
                 VALUES ('" . $sUsername . "','" . $sPassword . "');
                 ";
        return $this->_oDB->execute($sINSERT);
    }

    /**
     * @return array
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function getUserlist(): array
    {
        $sSelect = "
        SELECT u.ID
        FROM user u
        ";
        $var = $this->_oDB->getAsArray($sSelect);

        $aReturn = [];
        foreach ($var as $key => $aRow) {
            $aReturn[] = $aRow['ID'];
        }
        return $aReturn;
    }

    /**
     * @param User $oTargetUser
     * @param string $sPassword
     * @return bool
     * @throws ObjectNotLoadedException
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\UserPasswordNotMatch
     */
    public function toggleFollow(User $oTargetUser, string $sPassword): bool
    {
        $oObject = new user2user();
        return $oObject->toggleFollow($this, $sPassword, $oTargetUser);
    }

}