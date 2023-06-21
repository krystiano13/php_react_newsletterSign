<?php

abstract class DatabaseAbstract
{
    public $connection;
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $result;

    abstract public function connect(): bool;
}

class Database extends DatabaseAbstract
{
    public $connection;
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $result;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->dbname = 'news';
        $this->user = 'root';
        $this->password = '';
        $this->result = true;
    }

    public function connect(): bool
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->password,
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            $this->result = true;
        } catch (PDOException $e) {
            echo json_encode(array('msg' => 'err'));
            $this->result = false;
        }

        return $this->result;
    }
}