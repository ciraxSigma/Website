<?php

    use Framework\Helpers\Files;

    $fileController = new Files();

    array_shift($argv);

    $arguments = $argv;

    foreach($arguments as $argument){
        $fileController->writeModelTemplateFile($argument);
    }

?>