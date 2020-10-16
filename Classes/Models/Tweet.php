<?php


namespace Classes\Models;


class Tweet extends BaseModel
{
    public function getTableName(): string
    {
        return 'tweets';
    }

    public function getContent(): string
    {
        return $this->Content;
    }

    public function getLikes(): int
    {
        return intval($this->Likes);
    }

    public function getRetweetCount(): int
    {
        return intval($this->Retweets);
    }
    public function getId(): string
    {
        return $this->ID;
    }
}