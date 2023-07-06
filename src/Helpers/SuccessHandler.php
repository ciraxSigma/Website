<?php

    namespace App\Helpers;

    class SuccessHandler{

        public static function successMessage($message){
            echo "\e[32mSuccess: \e[0m" . $message . " \n";
        }

        public static function migrationSucceeded($tablesToMigrate){

            foreach($tablesToMigrate as $tableName){
                $tableName = lcfirst($tableName);
                $message = "Table $tableName was successfully migrated";
                SuccessHandler::successMessage($message);
            }

        }

    }

?>