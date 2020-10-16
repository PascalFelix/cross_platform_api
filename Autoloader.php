<?php


class Autoloader
{
    protected string $_sPath = __DIR__ . '\\Classes\\';

    public function __construct(string $sSubDir)
    {
        $this->_sPath .= $sSubDir . '\\';
        $aFiles = scandir($this->_sPath);
        foreach ($aFiles as $sFile) {

            if (is_string($sFile)) {
                if (strpos($sFile, '.php') !== false) {
                    include_once $this->_sPath . $sFile;
                }
            }
        }
    }

}