<?php

    use Framework\Routing\Route;

    

    Route::get("/something", function(){

        view('something', ["name" => "Lazar" , 'lastName' => "Cira"]);

    });

    Route::get("/", function(){

        view("welcome");
    })

?>