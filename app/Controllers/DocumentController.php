<?php

    namespace App\Controllers;

    use Framework\Helpers\Download;

    class DocumentController {

        public function index(){

            $download = new Download();

            $download->download(get("file"));

        }

    }
    
?>