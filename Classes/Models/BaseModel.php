<?php

namespace Classes\Models;

use Classes\Helper\dbConnector;

abstract class BaseModel
{
    abstract public function getTableName(): string;

    protected ?dbConnector $_oDB = null;
    protected bool $_bIsLoaded = false;

    public function __construct()
    {
        $this->_oDB = new dbConnector();
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        if (isset($name, $name)) {
            return $this->$name;
        } else {
            return null;
        }
    }


    /**
     * @param string $sId
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function load(string $sId): bool
    {
        $sSelect = "
        SELECT *
        FROM " . $this->getTableName() . " t
        WHERE t.ID = " . $sId . "
        ";

        $aResult = $this->_oDB->getAsArray($sSelect);
        $this->_loadFields($aResult);
        $this->_bIsLoaded = true;
        return !empty($aResult);
    }

    protected function _loadFields(array $aResult)
    {
        if (empty($aResult)) {
            $this->_loadFieldNames();
        } else {
            $aResult = $aResult[0];
            foreach ($aResult as $sFieldName => $sValue) {
                $this->$sFieldName = $sValue;
            }
        }
    }

    /**
     * @throws \Classes\Exceptions\NoDbConnection
     */
    protected function _loadFieldNames()
    {
        $sSELECT = "
        DESCRIBE " . $this->getTableName() . "
        ";
        $aResult = $this->_oDB->getAsArray($sSELECT);
        foreach ($aResult as $key => $aColumn) {
            $sFieldName = $aColumn["Field"];
            $this->$sFieldName = '';
        }
    }
}