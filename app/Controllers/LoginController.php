<?php

    namespace App\Controllers;

    class LoginController {

        public function index($params){

            

            $hash = "$2y$10\$ou1EOodCRJKg9NNtlyi.2O3Llv/m7pWP/lkxKDH3jRzcpXu68l8.K";

            $verify = password_verify($params["password"], $hash);


            if($verify){

                login(["username" => "Admin"]);

                redirect("/documents");

            }
            else {
                redirect(latestUri());
            }



        }

    }
    
?>