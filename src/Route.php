<?php
namespace agregalel\router_php;

use ReflectionMethod;

class Route {

    private static $routes = [];

    public static function initRouter(){
        include __DIR__ . "/" . "router/router.php";
    }

    public static function get(string $route, $controller){
        if(!is_array($controller)){
            trigger_error("Second parameter of Route::get() is not Array should be [Controller, method]", E_USER_ERROR);
            return;
        }
        array_push(self::$routes, [$route, $controller, 'get']);
    }

    public static function post(string $route, $controller){
        if(!is_array($controller)){
            trigger_error("Second parameter of Route::get() is not Array should be [Controller, method]", E_USER_ERROR);
            return;
        }

        array_push(self::$routes, [$route, $controller, 'post']);
    }

    public function getRoutes(){
        return self::$routes;
    }

    public function proccessRequest(string $str_uri, $routes){
        $uri = explode("/", $str_uri);

        $equal_url = false;
        $param_exists = [];
        $values_param = [];
        foreach($routes as $route) {
            $arr_route = explode("/", $route[0]);
            foreach ($arr_route as $key => $param){
                if(count($arr_route) !== count($uri)){
                    break;
                }
                if(isset($uri[$key])){
                    if($this->getParam($param) !== null){
                        array_push($param_exists, $this->getParam($param));
                        array_push($values_param, $uri[$key]);
                        continue;
                    }
                    if($param === $uri[$key] && strtolower($_SERVER['REQUEST_METHOD']) === $route[2]){
                        $equal_url = true;
                    }else{
                        $equal_url = false;
                        break;
                    }
                }else{
                    $equal_url = false;
                    break;
                }
            }
            if($equal_url){
                switch (($_SERVER['REQUEST_METHOD'])) {
                    case 'GET':
                        $this->connectWithController($route[1], $param_exists, $values_param);
                        break;
                    
                    case 'POST':
                        $this->connectWithPostController($route[1]);
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            }
        }

        if(!$equal_url){
            header("Location: /404");

            echo "404 Not Found";
        }
    }

    private function getParam(string $param) {
        if(str_contains($param , "{")){
            $result = str_replace("{", "", $param);
            $result = str_replace("}", "", $result);
            $result = str_replace(":", "", $result);
            return $result;
        }
    }

    private function connectWithController($route, $param = [], $value_param = [] ){
        $controller = $route[0];
        $method = trim($route[1]);

        $reflection = new ReflectionMethod($controller, $method);
        $result = array();

        foreach ($reflection->getParameters() as $parameter ){
            foreach ($param as $key => $nameParam){
                if($parameter->name === $nameParam){
                    array_push($result, $value_param[$key]);
                }
            }
        }

        $reflection->invokeArgs($controller, $result);
    }

    private function connectWithPostController($route){
        $controller = $route[0];
        $method = trim($route[1]);

        $controller->$method($_POST);
    }
}