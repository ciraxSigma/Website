<?php

    namespace App\Helpers;

    use App\Interfaces\FilesInterface;
    use App\Helpers\Files;

    class FileWriter implements FilesInterface{
        use Files;

        public function writeTableTemplateFile($fileNameWE){
            $fileName = $this->addExtension($fileNameWE);
            $path = $this->makePath('/database/tables/'). $fileName;
            $tableFile = fopen($path, "w");

            $tableFileTemplate = file_get_contents($this->makePath('/src/Templates/TableTemplate.temp'));

            fwrite($tableFile, $tableFileTemplate);
            
            fclose($tableFile);
        }
    } 

?>