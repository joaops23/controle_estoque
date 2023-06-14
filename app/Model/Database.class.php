<?php 

namespace Model;


class Database {
    public static $instance; 
    private $host;
    private $user;
    private $pass;
    private $database;

    public function __construct($host, $user, $pass, $database) {
        Database::setCon($host, $user, $pass, $database);
    }

    public function setCon($host, $user, $pass, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new PDO("mysql:host={$this->host};
            dbname={$this->database}","{$this->user}","{$this->pass}",
            array(PDO::MYSQL_ATTRINIT_COMMAND => "SET NAMES utf8"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
            self:$instance->setAttribute(PDO::ATTR_ORACLE_NULLS,
            PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }

    public static function save($obj)
    {
        global $banco;
        $contents = $obj->getData();
        $table = $contents['table'];

        $banco->prepare();
    }
}

?>