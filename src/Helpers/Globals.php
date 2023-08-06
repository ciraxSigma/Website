<?php

    use Framework\Helpers\Validator;

    session_start();

    function view($page, $data = null){

        if($data != null){
            extract($data);
        }
        return require("../app/Pages/$page" . ".php");
    }

    function redirect($url){
        
        header("Location: $url");

    }

    function validate($data, $conditions){

        $_SESSION["POST_DATA"] = $_POST;

        $validator = new Validator();

        foreach($conditions as $key => $value){


            $validator->validateKey($key, $data[$key], $value);

        }

        $validator->redirectIfNotPassed();

        unset($_SESSION["POST_DATA"]);
        unset($_SESSION["VALIDATION_FAILS"]);

        return $validator->getData();

    }

    function old($oldValueName){

        if(isset($_SESSION["POST_DATA"][$oldValueName])){
            return $_SESSION["POST_DATA"][$oldValueName];
        }else{
            return false;
        }
    }

    function invalid($inputName){

        if(isset($_SESSION['VALIDATION_FAILS'][$inputName])){
            return $_SESSION['VALIDATION_FAILS'][$inputName];
        }
        else {
            return false;
        }

    }
?>