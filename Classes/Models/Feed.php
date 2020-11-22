<?php


namespace Classes\Models;


use Classes\Exceptions\UserPasswordNotMatch;
use Classes\Helper\dbConnector;

class Feed
{
    protected ?dbConnector $_oDB = null;
    protected ?User $_oUser = null;

    protected int $_iMaxLoadCount = 20;

    public function __construct()
    {
        $this->_oDB = new dbConnector();
    }

    /**
     * @param string $sUserName
     * @param string $sPassword
     * @param int $iOffset
     * @return array
     * @throws UserPasswordNotMatch
     * @throws \Classes\Exceptions\NoDbConnection
     * @throws \Classes\Exceptions\ObjectNotLoadedException
     */
    public function loadFeed(string $sUserName, string $sPassword, int $iOffset): array
    {
        $aReturn = [];
        $this->_oUser = new User();
        $this->_oUser->loadByName($sUserName);
        if (!$this->_oUser->passwordsMatch($sPassword)) {
            throw new UserPasswordNotMatch($sUserName);
        } else {
            $sSelect =
                "
                SELECT v.ID
                FROM tweets v
                INNER JOIN user2user u2u ON u2u.UserID = '1'
                WHERE v.UserID = u2u.UserID OR v.UserID IN (u2u.UserToFollowID)
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