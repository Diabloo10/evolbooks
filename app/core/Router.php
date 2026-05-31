<?php 

class Router
{
    public function route()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : "home/index";

        $url = explode("/", filter_var(rtrim($url, "/"), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . "Controller";
        $method = isset($url[1]) ? $url[1] : "index";

        $controllerFile = "../app/controllers/" . $controllerName . ".php";

        if(file_exists($controllerFile)) {

            require_once $controllerFile;

            $controller = new $controllerName();

            if(method_exists($controller, $method)) {

                $params = array_slice($url, 2);

                call_user_func_array([$controller, $method], $params);

            } else {
                echo "Method not found";
            }

        } else {
            echo "Controller not found";
        }
    }
}

?>