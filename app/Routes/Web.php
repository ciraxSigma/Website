<?php

    use Framework\Routing\Route;

    Route::get("/", function(){
        view("welcome");
    });

?>