<?php

class DataBase
{
    private $PDO;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = require_once 'config.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->PDO = new PDO($dsn, $config['username'], $config['password']);
        return $this;
    }

    public function query($sql)
    {
        $sth = $this->PDO->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result === false) {
            return [];
        }
        return $result;
    }

    public function lastInsertId()
    {
        return $this->PDO->lastInsertId();
    }
}
