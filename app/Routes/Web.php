<?php

    use App\Controllers\EmailController;
    use Framework\Routing\Route;


    Route::post("/",EmailController::class,"index");

    Route::get("/", function(){
        view("home-page");
    });

?>