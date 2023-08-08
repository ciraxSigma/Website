<?php

    namespace App\Controllers;

use Framework\Helpers\Upload;

    class UploadController {

        public function index(){

            $upload = new Upload();

            $upload->upload('image');

        }

    }
    
?>