<?php


namespace Classes\Models;


use Classes\Exceptions\ObjectNotLoadedException;

class User extends BaseModel
{

    private bool $_realced = false;

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

    /**
     * @return string
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function getFollowerCount(): string
    {
        $this->_recalc();
        return $this->Follower;
    }

    /**
     * @return string
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function getFollowsCount(): string
    {
        $this->_recalc();
        return $this->Follows;
    }

    /**
     * @return string
     * @throws \Classes\Exceptions\NoDbConnection
     */
    private function _recalc()
    {
        if(!$this->_realced) {
            $this->_realced = true;
            $sWorkID = md5(uniqid());
            $sUpdate = "
        UPDATE user
        SET workID = '" . $sWorkID . "'
        WHERE user.workID = '' AND TIMESTAMPDIFF(MINUTE, user.Timestamp,CURRENT_TIMESTAMP()) > 1 AND user.ID = '" . $this->getId() . "'
        ";
            $this->_oDB->execute($sUpdate);
            $sSelect = "
        SELECT COUNT(*) AS counter
        FROM user u
        WHERE u.workID = '" . $sWorkID . "' 
        ";
            $var = $this->_oDB->getAsArray($sSelect);
            if (intval($var[0]['counter']) === 1) {
                //recalc
                $this->_oDB->execute("START TRANSACTION");
                $sCounters = "
            #follows
            SELECT COUNT(*) AS counter
            FROM user2user u2u1
            WHERE u2u1.UserID = '" . $this->getId() . "'
            
            UNION ALL
            #follower
            SELECT COUNT(*)AS counter 
            FROM user2user u2u2
            WHERE u2u2.UserToFollowID = '" . $this->getId() . "'
            
            UNION ALL 
              #tweet count
            SELECT COUNT(*) AS counter
            FROM tweets t
            WHERE t.UserID = '" . $this->getId() . "'
            
            ";
                $aCounters = $this->_oDB->getAsArray($sCounters);
                $sUpdateCounter = "
            UPDATE user
            SET 
            user.Follower = " . $aCounters[1]['counter'] . ",
            user.Follows = " . $aCounters[0]['counter'] . ",
            user.Tweets = " . $aCounters[2]['counter'] . "
            WHERE user.ID = '" . $this->getId() . "'
            ";
                $this->_oDB->execute($sUpdateCounter);
                $sResetWorkID = "
            UPDATE user
            SET workID = ''
            WHERE user.workID = '" . $sWorkID . "' 
            ";
                $this->_oDB->execute($sResetWorkID);
                $this->_oDB->execute("COMMIT");
            }
            $this->load($this->getId());
        }
    }

    public function getTweetCount(): string
    {
        $this->_recalc();
        return $this->Tweets;
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