<?php

namespace Classes\Helper;

use Classes\Exceptions\NoDbConnection;

class dbConnector
{
    protected string $_sDbIp = dbip;
    protected string $_sDbUserName = user;
    protected string $_sDbPassword = password;
    protected string $_sDb = dbname;


    protected ?\mysqli $_oMysqli = null;

    /**
     * dbConnector constructor.
     * @throws NoDbConnection
     */
    public function __construct()
    {
        $this->_connect();
        $this->_disconnect();
        $this->_connect();
    }

    /**
     * @param string $sSelect
     * @return array
     * @throws NoDbConnection
     */
    public function getAsArray(string $sSelect): array
    {
        $mResult = $this->_oMysqli->query($sSelect);
        $mResult = $mResult->fetch_all(1);
        if($mResult === false){
            return array();
        }else if(is_array($mResult)){
            return $mResult;
        }else{
            return array();
        }
    }

    public function execute(string $sQuery): bool
    {
        $bReturn = $this->_oMysqli->query($sQuery);
        return $bReturn;
    }

    protected function _connect()
    {
        $this->_oMysqli = new \mysqli($this->_sDbIp, $this->_sDbUserName, $this->_sDbPassword, $this->_sDb);
        if ($this->_oMysqli->connect_errno) {
            throw new NoDbConnection($this->_oMysqli->connect_error);
        }
    }

    protected function _disconnect()
    {
        $this->_oMysqli->close();
    }


}