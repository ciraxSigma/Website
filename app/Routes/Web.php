<?php

    use Framework\Routing\Route;
    use App\Controllers\DownloadController;
use App\Controllers\UploadController;
use Framework\Helpers\Upload;

    Route::get("/download", DownloadController::class, "index");

    Route::get("/", function(){

        view("welcome");

    });

    Route::get("/main", function (){

        view("download");

    });

    Route::post("/upload", UploadController::class, "index");

    Route::post("/something" , function(){
        
        $upload = new Upload();

        $upload->extensions = ['jpg', 'png', 'jpeg'];

        $upload->upload("image");

    })
?>