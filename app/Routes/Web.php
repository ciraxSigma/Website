<?php

    use Framework\Routing\Route;
    use App\Controllers\UserController;

    Route::post("/users", UserController::class, "create");
    Route::get("/users", UserController::class, "index");
    Route::get("/success", UserController::class, "test");


?>