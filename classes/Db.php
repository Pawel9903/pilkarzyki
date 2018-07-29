<?php

class Db
{
    static $instance;

    public static function getInstance()
    {
        return self::$instance = new Db();
    }

    public function getDb()
    {
        $parameters = Config::getInstance()->getConfig();

        $pdo = new PDO('mysql:host='.$parameters->getHost().';
            dbname='.$parameters->getDbName().';
            charset=' .$parameters ->getCharset().'',
            $parameters->getUserName(),
            $parameters->getPassword()
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $pdo;
    }
}