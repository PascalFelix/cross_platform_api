<?php


namespace Classes\Models;


use Classes\Exceptions\ObjectNotLoadedException;
use Classes\Helper\dbConnector;

class CommentList
{
    protected ?dbConnector $_oDB = null;
    protected int $_iMaxLoadCount = 10;

    protected bool $_bIsLoaded = false;
    protected array $_aComments = array();

    public function __construct()
    {
        $this->_oDB = new dbConnector();
    }

    /**
     * @param string $sId
     * @param int $iOffset
     * @return bool
     * @throws \Classes\Exceptions\NoDbConnection
     */
    public function loadForTweetID(string $sId, int $iOffset): bool
    {
        $sSelect = "
        SELECT c.ID
        FROM comments c
        WHERE c.TweetID = '" . $sId . "'
        ORDER BY c.Timestamp desc
        LIMIT " . $this->_iMaxLoadCount . " OFFSET " . $iOffset . "
        ";
        $aResult = $this->_oDB->getAsArray($sSelect);
        foreach ($aResult as $key => $aRow) {
            $oComment = new Comment();
            if ($oComment->load($aRow["ID"])) {
                $this->_aComments[] = $oComment;
            }
        }
        $this->_bIsLoaded = true;
        return true;
    }
    /**
     * @return array
     * @throws ObjectNotLoadedException
     */
    public function getCommentIds(): array
    {
        if ($this->_bIsLoaded) {
            $aReturn = [];
            /**
             * @var $oTweet Comment
             */
            foreach ($this->_aComments as $oComment) {
                $aReturn[] = $oComment->getId();
            }
            return $aReturn;
        } else {
            throw new ObjectNotLoadedException("Commentlist was not loaded");
        }
    }


}