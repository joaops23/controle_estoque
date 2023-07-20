<?php 
/**
 * Classe produtos
 * registra, busca e manipula o produto e seu cadastro no banco de dados
 */
namespace Model;

class Product{

    private $table = "products";
    public static $id;
    protected $prod_desc;
    protected $prod_cost;
    protected $prod_markup;

    # Setters
    protected function setDesc(String $desc)
    {
        $this->prod_desc = addslashes(trim($desc));
    }
    protected function setCost(Float $cost)
    {
        $this->prod_cost = round($cost, 2);
    }
    protected function setMarkup(Float $mkp)
    {
        $this->prod_markup = round($mkp, 2);
    }

    protected function setId(int $id)
    {
        $this->id = trim($id);
    }

    # Getters
    protected function getDesc()
    {
        return $this->prod_desc;
    }
    protected function getCost()
    {
        return $this->prod_cost;
    }
    protected function getMarkup()
    {
        return $this->prod_markup;
    }

    protected function getId()
    {
        return $this->id;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setProd($prod)
    {
        # Retorno utilizado na alteração do produto
        if( !empty($prod['prod_desc']) || !empty($prod['prod_cost']) || !empty($prod['prod_markup'])){
            $this::setDesc($prod['prod_desc']);
            $this::setCost($prod['prod_cost']);
            $this::setMarkup($prod['prod_markup']);

            return true;
        } else {
            return false;
        }

    }

    # Methods
    public function register(array $prod)
    {
        global $banco;

        $this->setProd($prod);

        return $banco->save($this);
    }

    public function getProds(array $id = null)
    {
        global $banco;
        $pdo = $banco->getInstance();

        $list = $banco::consult($this->table, $id);

        return $list;
        
    }

    public function getData()
    {
        return [
            "table" => $this->table,
            "prod_desc" => $this::getDesc(),
            "prod_cost" => $this::getCost(),
            "prod_markup" => $this::getMarkup()
        ];
    }
    
    public function upProd(Int $id = null, $params = array())
    {
        global $banco;

        $set = $this->setProd($params);

        if(!$set){
            return throw new \Exception('Não foram enviados dados para alteração!');
        }

        return $banco->update($this, ["prod_id" => $id]);
    }

    public function delProd($params){
        global $banco;

        if(!empty($params['prod_id'])){
            return $banco->delete($this->table, $params);
        } else {
            return throw new \Exception('Identificação do produto para exclusão não encontrado!');
        }
    }
}
?>