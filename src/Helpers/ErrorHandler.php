<?php

    namespace Framework\Helpers;

    class ErrorHandler{

        private static function TerminateWithMessage($message){
            echo "\e[31mError: \e[0m" . $message . "\n";
            exit();
        }

        public static function ColumnValidationError($tableName, $columName, $propertiesString){
            
            $message = "Expression invalid in " . ucwords($tableName) . ".php: " . $columName . " => " . $propertiesString; 

            ErrorHandler::TerminateWithMessage($message);

        }

        public static function tableAlreadyExistsError(){
            $message = "Table already exists in database";
            ErrorHandler::TerminateWithMessage($message);
        }

        public static function tableDoesntExistsError(){
            $message = "Table doesn't exists";
            ErrorHandler::TerminateWithMessage($message);
        }

    }

?>