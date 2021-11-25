<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\updatecontroller;
use App\Http\Controllers\UserController;

Route::group(['middleware'=>'cauth'],function(){

    /**
     * get all user information
     */
    Route::post('/getuser',[UserController::class,'getUserData']);

    /**
     * logout route
     */
    Route::post('/logout',[UserController::class,'logOut']);

    /**
     * update user
     */
    Route::post('/updateuser',[UserController::class,'updateUser']);


    Route::post('/getpost',[UserController::class,'getPostDetails']);


});

 /**
 * signup route
 */
Route::post('/signup',[UserController::class,'userSignup'])->middleware('EmailExistsAuth');

/**
 * login route
 */
Route::post('/login',[UserController::class,'userLogin'])->middleware('eauth');

/**
 * update verified email
 */
Route::get('/verify/{email}/{token}',[UpdateController::class,'updateData']);



