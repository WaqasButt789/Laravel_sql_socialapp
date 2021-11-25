<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ForgetController;
Route::group(['middleware'=>'cauth'],function(){

    /**
     * forget password route
     */
    Route::post('/forgetpassword',[ForgetController::class,'forgetPassword']);

    /**
     * Change Password route
     */
    Route::post('/changepassword',[ForgetController::class,'changePassword']);


});
