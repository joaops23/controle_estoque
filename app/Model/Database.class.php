<?php 

namespace Model;


class Database extends \PDO{
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

    public function getInstance() {
        if(!isset(self::$instance)) {
            $this::$instance = new \PDO("mysql:host={$this->host};
            dbname={$this->database}","{$this->user}","{$this->pass}",
            array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this::$instance->setAttribute(\PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION);
            $this::$instance->setAttribute(\PDO::ATTR_ORACLE_NULLS,
            \PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }

    public static function save($obj)
    {
        global $banco;
        $pdo = $banco->getInstance();

        $contents = $obj->getData();
        $table = $contents['table'];
        unset($contents['table']);

        $columns = self::setParams($contents);
        $data = self::setDatas($contents);

        $stmt = $pdo->prepare("INSERT INTO $table ($data) VALUES ($columns)");
        $stmt->execute($contents);
        
        if($pdo->lastInsertId()){
            return $pdo->lastInsertId();
        } else{
            throw new \Exception("Excessão encontrada! Não foi possível inserir o produto");
        }

    }

    public static function consult($table, $param = null)
    {
        global $banco;
        $pdo = $banco->getInstance();
        
        if($param != null){

            $columns = self::setParams($param);
            $data = self::setDatas($param);
            $query = "SELECT * FROM $table WHERE $data = $columns ";
            $consult = $pdo->prepare($query);
            $consult->execute($param);
        } else {
            $consult = $pdo->prepare("SELECT * FROM $table");
            $consult->execute();
        }

        return $consult->fetchAll(\PDO::FETCH_ASSOC);
    }

    # Busca as colunas que serão persistidos
    public static function setParams($contents)
    {
        global $banco;
        $columns = '';
        foreach($contents as $index => $val){
            $columns .= ":" . $index . ",";
        }

        $len = strlen($columns);
        return substr($columns, 0, $len-1);
    }

    # Carrega os dados que serão persistidos
    public static function setDatas($contents)
    {
        global $banco;
        $data = "";
        foreach($contents as $index => $val){
            $data .= $index . ',';
        }

        $len = strlen($data);
        return substr($data, 0,$len - 1);
    }

    public static function update($obj, $param = array()) // $param expeteds 1 column, references a $id
    {
        global $banco;
        $pdo = $banco->getInstance();

        $contents = $obj->getData();
        $table = $contents['table'];
        unset($contents['table']);
        #carregar os parâmetros
        ksort($contents);

        $params = $contents;

        
        $params[] = $param[key($param)]; // Set a value of id
        
        $columns = implode(' = ?, ', array_keys($contents));
        $columns .= " = ?";
        
        $stmt = $pdo->prepare("UPDATE $table SET $columns WHERE ". key($param) ." = ?");
        $ret = $stmt->execute(array_values($params));
        
        return $ret;

    }

    public static function delete($table, $param){
        #table, param = id do item


        return json_encode([$table, $param]);
        
    }
}

?>