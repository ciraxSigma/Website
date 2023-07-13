<?php

    namespace Framework\Helpers;
    
    class Files{

        private function resolveTempKeys($tempContent, $keys){

            foreach($keys as $key => $value){
                if($key == "className"){
                    $tempContent = str_replace("{{className}}", $value, $tempContent);
                }
            }

            return $tempContent;

        }

        public function getBasePath(){
            return __DIR__ . '/../..';
        }

        public function removeExtension($fileName){
            return explode('.', $fileName)[0];
        }

        public function addExtension($fileName){
            return $fileName . ".php";
        }

        public function readDir($path){
            $fileNames = array_diff(scandir($this->getBasePath() . $path), array('..', '.'));
            $fileNamesWithoutExetensions = [];
            foreach($fileNames as $fileName){
                $fileNamesWithoutExetensions [] = $this->removeExtension($fileName);
            }

            return $fileNamesWithoutExetensions;
        }

        public function makePath($path){
            return $this->getBasePath() . $path;
        }

        public function writeTableTemplateFile($fileNameWE){
            $fileName = $this->addExtension($fileNameWE);
            $path = $this->makePath('/database/tables/'). $fileName;
            $tableFile = fopen($path, "w");

            $tableFileTemplate = file_get_contents($this->makePath('/src/Templates/TableTemplate.temp'));

            fwrite($tableFile, $tableFileTemplate);
            
            fclose($tableFile);
        }

        public function writeModelTemplateFile($fileNameWE){
            $fileName = $this->addExtension($fileNameWE);
            $path = $this->makePath("/models/") . $fileName;

            $modelFile = fopen($path, "w");

            $modelFileTemplate = file_get_contents($this->makePath("/src/Templates/ModelTemplate.temp"));

            fwrite($modelFile, $this->resolveTempKeys($modelFileTemplate, array("className" => $fileNameWE)));

            fclose($modelFile);
        }
    }

?>