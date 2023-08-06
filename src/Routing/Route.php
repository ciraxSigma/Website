<?php

    namespace Framework\Routing;

    class Route{

        public static function get($route, $callable, $action = null){
            
            if($_SERVER["REQUEST_METHOD"] != "GET"){
                return;
            }

            $uri = $_SERVER["REQUEST_URI"];

            $uriParts = explode('/', $uri);
            array_shift($uriParts);

            $routeParts = explode('/', $route);
            array_shift($routeParts);

            $arguments = array();

            if(count($uriParts) != count($routeParts)){
                return;
            }


            if(preg_match("/\[.*\]/", $route)){   
                            
                for($i = 0; $i < count($routeParts); $i++){


                    if(!preg_match("/\[.*\]/", $routeParts[$i])){

                        if($uriParts[$i] == $routeParts[$i]){
                            continue;
                        }

                        return;

                    }


                    $argumentName = substr($routeParts[$i], 1, strlen($routeParts[$i]) - 2);

                    $routeParts[$i] = $uriParts[$i];
                    
                    $arguments[$argumentName] = $uriParts[$i];

                }

            }

            if($action == null && "/" . implode("/", $routeParts) == $uri){
                $callable();
                exit();
            }


            if("/" . implode("/", $routeParts) == $uri){

               $_SESSION["LATEST_GET_URI"] = $uri;

               $controller = new $callable();

               $controller->$action($arguments);

                exit();
            }

        }



        public static function post($route, $class, $action){
            
            if($_SERVER["REQUEST_METHOD"] != "POST"){
                return;
            }

            $uri = $_SERVER["REQUEST_URI"];

            if($uri == $route){

                $controller = new $class();

                $controller->$action($_POST);

                exit();
            }
        }

        public static function put($route){

        }

        public static function delete($route){

        }


    }

?>