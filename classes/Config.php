<?php

class Config
{
    static $instance;
    private $host = "localhost";
    private $dbName = "game";
    private $userName = "root";
    private $password = "qwerty";
    private $charset = "Utf8";

    public static function getInstance()
    {
        return self::$instance = new Config();
    }

    public function getConfig()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }


}