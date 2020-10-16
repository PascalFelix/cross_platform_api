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
}