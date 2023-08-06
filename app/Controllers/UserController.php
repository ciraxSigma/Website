<?php

    namespace App\Controllers;

    class UserController {

        public function index(){

            view("user");
            
        }

        public function create($params){


            $userData = validate($params, array(
                "username" => "max:6",
                "password" => "min:6",
                "email" => "email"
            ));

            var_dump($userData);

            //redirect("success");

        }

        public function test(){

            echo "<h1>Success</h1>";

        }
    }
    
?>