<?php

    namespace App\Helpers;
    
    trait Files{

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
    }

?>