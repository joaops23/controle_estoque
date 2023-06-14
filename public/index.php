<?php
require_once getcwd() . '/vendor/autoload.php';

use Model\Database;
use Router\Router;

# Pacote utilizado para manipular o arquivo .env
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(getcwd());
$dotenv->load();

#autoload de classes
function MyAutoLoad($className) {
    $extension = spl_autoload_extensions();
    require_once (getcwd() . '/app/' . $className . $extension);
}
spl_autoload_extensions('.class.php');
spl_autoload_register('MyAutoLoad');

#inicia o PDO
$banco = new Database($_ENV['DB_HOSTNAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PASS'], $_ENV['DB_DATABASE']);


function exceptions_error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}
set_error_handler('exceptions_error_handler');
#recebendo rota e enviando para o controlador utilizando object literals na classe router
try{
    $data = ''; # Variável responsável por armazenar os dados do body da requisição
    $requestUri = $_SERVER['REQUEST_URI'];
    $router = new Router();
    $router->run($requestUri);
}catch(Exception $e){
    echo "Excessão encontrada: " . $e->getMessage();
}
?>