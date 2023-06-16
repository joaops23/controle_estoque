<?php
namespace Router;

require_once __DIR__ . "/RouterSwitch.class.php";

use Router\RouterSwitch;

class Router extends RouterSwitch
{
    public function run(string $requestUri) {
        global $data;
        $route = substr($requestUri, 1);

        
        if($route === ''){
            //$this->home();
            throw new \Exception("Teste");
        } else{
            $data = json_decode(file_get_contents('php://input'), true);
            echo $this->$route();
        }
    }
}
?>