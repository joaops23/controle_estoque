# Estrutura do projeto

- app/
    - controller/
    - model/
        - Database.class
        - Product.class
        - Stock.class
    - Router/
        - Router.class
        - RouterSwitch.class
- public/
- templates/
- vendor/
- .env
- composer.json


## Cadastrar produto 

~~~JS
// JSON de exemplo para cadastro de novo produto
{
    "prod_desc": "alicate de corte",
    "prod_cost": 5.75,
    "prod_mkp": 60.5
}
~~~


## Em construção:

### Processos realizados:

- Criação do banco de dados
- Conexão com o  banco de dados
- Arquitetura inicial
- classes (Database, Product, Router, RouterSwitch, Stock) criadas.
- método Database::save() -> Finalizado(método está salvando o registro e retornando id da inclusão)


### Próximos:
- criar demais rotas do produto, estoque e controle (rotas feitas= /insertProd | /getProd)
- finalizar métodos do produto para criação, persistência, manipulação e visualização do produto
- realizar o mesmo processo para o estoque 
- desenvolver o controle de estoque que irá manipular e popular a tabela stock_balance, controlar o fluxo de entrada-saida dos produtos
- logs
- testes


### Rotas

- #### Produto
    - /insertProd (Rota para inserir o produto na base de dados)
    - /getProd/$id? (Consultar produto, id(Opcional))
    - /updateProd/$id (enviar em post, no body da requisição, caso queira alterar, os campos: prod_desc, prod_cost, prod_markup)
    - /deleteProd/$id (Deletar registro de um produto específico) - Ainda não finalizado.