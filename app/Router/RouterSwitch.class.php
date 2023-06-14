<?php

namespace Router;
use Model\Product;

abstract class RouterSwitch{

    protected function insertProd()
    {
        global $data;
        $prod = new Product();

        # percorre os parâmetros da URI, se possuir todos, prossegue para a inclusão do produto
        if(!empty($data['prod_desc']) && !empty($data['prod_cost']) && !empty($data['prod_mkp']))
            $prod->register($data);
        else
            throw new \Exception("Dados do produto Inválidos, corrija e envie novamente!");
    }
}

?>