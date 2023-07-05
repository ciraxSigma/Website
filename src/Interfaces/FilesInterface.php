<?php

    namespace App\Interfaces;

    interface FilesInterface{

        public function getBasePath();
        public function removeExtension($fileName);
        public function addExtension($fileName);
        public function readDir($path);
        public function makePath($path);
    }

?>