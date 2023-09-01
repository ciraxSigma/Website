<?php

    use Framework\Helpers\Validator;
    use Framework\Helpers\Files;
    use Framework\Helpers\Linker;

    session_start();

    function view($page, $data = null){

        $fileController = new Files();
        
        $linker = new Linker();

        $pagePath = $fileController->makePath("/app/Pages/$page" . ".php");

        $page = $linker->link(file_get_contents($pagePath), $data);
    
        $page = eval("?>" . $page . "<?php ");

        echo $page;
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

    function get($argumentName){

        if(isset($_GET[$argumentName])){
            return $_GET[$argumentName];
        }else{
            exit();
        }

    }

    


?>