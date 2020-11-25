<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;
use Classes\Helper\dbConnector;

class Feed
{
    protected ?dbConnector $_oDB = null;
    protected ?User $_oUser = null;

    protected int $_iMaxLoadCount = 10;

    public function __construct()
    {
        $this->_oDB = new dbConnector();
    }

    /**
     * @param string $sId
     * @param string $sPassword
     * @param int $iOffset
     * @return array
     * @throws UserPasswordNotMatch
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    public function loadFeed(string $sId, string $sPassword, int $iOffset): array
    {
        $aReturn = [];
        $this->_oUser = new User();
        $this->_oUser->load($sId);
        if (!$this->_oUser->passwordsMatch($sPassword)) {
            throw new UserPasswordNotMatch($sId);
        } else {
            $sSelect =
                "
                SELECT v.ID
                FROM tweets v
                WHERE v.UserID = '".$this->_oUser->getId()."' OR v.UserID IN (
					 	SELECT u2u.UserToFollowID
						FROM user2user u2u
						WHERE u2u.UserID = '".$this->_oUser->getId()."'
						)
                ORDER BY v.Timestamp desc
                LIMIT " . $this->_iMaxLoadCount . " OFFSET " . $iOffset . "
                ";
            $aResult = $this->_oDB->getAsArray($sSelect);
            foreach ($aResult as $iKey => $aRow) {
                $aReturn[] = $aRow['ID'];
            }
        }
        return $aReturn;
    }


}