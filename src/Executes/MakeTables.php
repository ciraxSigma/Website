<?php
    
    use App\Helpers\FileWriter;

    array_shift($argv);

    $writer = new FileWriter();

    foreach($argv as $argument){
        
        foreach($writer->readDir('/database/tables') as $tabeName){
            if($argument == $tabeName){
                echo "This table already Exists. Please enter tables that doesn't exist. \n";
                exit();
            }
        }


        $writer->writeTableTemplateFile($argument);

    }

?>