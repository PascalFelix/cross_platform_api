<?php

namespace Classes\Helper;

use Classes\Exceptions\NoDbConnection;

class dbConnector
{
    protected string $_sDbIp = "localhost";
    protected string $_sDbUserName = "root";
    protected string $_sDbPassword = "";
    protected string $_sDb = "bitter";


    protected ?\mysqli $_oMysqli = null;

    /**
     * dbConnector constructor.
     * @throws NoDbConnection
     */
    public function __construct()
    {

        $this->_connect();
        $this->_disconnect();

    }

    /**
     * @param string $sSelect
     * @return array
     * @throws NoDbConnection
     */
    public function getAsArray(string $sSelect): array
    {
        $this->_connect();
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

    public function execute(string $sQuery)
    {

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