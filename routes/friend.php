<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\FreindController;

Route::group(['middleware'=>'cauth'],function(){

    /**
     * add friend route
     */
    Route::post('/addfriend',[FreindController::class,'addFriend'])->middleware("isregister");

    /**
     * unfriend route
     */
    Route::post('/unfriend',[FreindController::class,'removeFriend']);

});
