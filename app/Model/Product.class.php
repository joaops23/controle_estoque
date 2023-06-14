<?php 
/**
 * Classe produtos
 * registra, busca e manipula o produto e seu cadastro no banco de dados
 */
namespace Model;

class Product{

    private $table = "products";
    public static $prod_id;
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

    # Methods
    public function register(array $prod)
    {
        global $banco;

        $this::setDesc($prod['prod_desc']);
        $this::setCost($prod['prod_cost']);
        $this::setMarkup($prod['prod_mkp']);

        $banco->save($this);
    }

    public function getData()
    {
        return [
            "table" => $this->table,
            "prod_desc" => $this::getDesc(),
            "prod_cost" => $this::getCost(),
            "prod_mkp" => $this::getMarkup()
        ];
    }
}
?>