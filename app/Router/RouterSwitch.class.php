<?php

namespace Router;
use Model\Product;

abstract class RouterSwitch
{
    ## Rotas para o produto
    protected function insertProd()
    {
        global $data;
        $prod = new Product();

        # percorre os parâmetros da URI, se possuir todos, prossegue para a inclusão do produto
        if(!empty($data['prod_desc']) && !empty($data['prod_cost']) && !empty($data['prod_markup']))
            $id = $prod->register($data);
        else
            throw new \Exception("Dados do produto Inválidos, corrija e envie novamente!");

        return json_encode($id);
    }

    protected function getProd()
    {
        global $data;
        $prod = new Product();
        $id = !empty($_GET['id']) ? ['prod_id' => $_GET['id']] : null;

        $list = json_encode($prod->getProds($id));

        return $list;
        
    }

    
}

?>