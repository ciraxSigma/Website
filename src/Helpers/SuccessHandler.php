<?php

    namespace Framework\Helpers;

    class SuccessHandler{

        public static function successMessage($message){
            echo "\e[32mSuccess: \e[0m" . $message . " \n";
        }

        public static function migrationSucceeded($tablesToMigrate){

            foreach($tablesToMigrate as $tableName){
                $tableName = lcfirst($tableName);
                $message = "Table \e[90m$tableName\e[0m was successfully migrated";
                SuccessHandler::successMessage($message);
            }

        }

        public static function deleteSucceeeded($tablesToDelete){

            foreach($tablesToDelete as $tableName){
                $tableName = lcfirst($tableName);
                $message = "Table '\e[90m$tableName\e[0m' was successfully deleted";
                SuccessHandler::successMessage($message);
            }

        }

        public static function modelCreationSucceeded($modelsNames){
            foreach($modelsNames as $modelName){
                $message = "Model '\e[90m$modelName\e[0m' was successfullly created";
                SuccessHandler::successMessage($message);
            }
        }

        public static function factoryCreationSucceeded($factoriesNames){
            foreach($factoriesNames as $factoryName){
                $message = "Factory '\e[90m$factoryName\e[0m' was successfullly created";
                SuccessHandler::successMessage($message);
            }
        }

    }

?>