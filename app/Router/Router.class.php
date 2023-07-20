<?php
namespace Router;

require_once __DIR__ . "/RouterSwitch.class.php";

use Router\RouterSwitch;

class Router extends RouterSwitch
{
    public function run(string $requestUri) {
        global $data;
        $route = substr($requestUri, 1);
        $pos = strpos($route, "?");
        $route = substr($route,0,$pos);

        
        if($route === ''){
            //$this->home();
            throw new \Exception("Teste");
        } else{
            $data = json_decode(file_get_contents('php://input'), true);
            $data = empty($data) ? self::bindParams() : $data;
            echo $this->$route();
        }
    }
    private static function bindParams(){
        global $_REQUEST;

        $data = array();
        foreach($_REQUEST as $req => $val){
            $data[$req] = $val;
        }
        return $data;
    }

}
?>