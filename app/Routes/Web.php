<?php

    use App\Controllers\EmailController;
    use App\Controllers\DocumentController;
    use App\Controllers\LoginController;
    use Framework\Helpers\Files;
    use Framework\Routing\Route;


    Route::post("/",EmailController::class,"index");

    Route::get("/", function(){
        if(auth()){
            logout();
        }
        view("home-page");
    });

    Route::get("/login", function() {
        view("login");
    });

    Route::post("/login", LoginController::class, "index");

    Route::group("auth", function() {
    
        Route::get("/documents", function(){
    
            $fileController = new Files();
    
            $files = $fileController->readDirWithExt("/app/Downloads");
    
            view("documents", ["files" => $files]);
        });
    
        Route::get("/documents/download", DocumentController::class, "index");

    });



?>