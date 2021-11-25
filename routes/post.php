<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\controllers\PostController;

Route::group(['middleware'=>'cauth'],function(){
    
    /**
     *  create a new post
     */
    Route::post('/createpost',[PostController::class,'createPost']);
    /**
     * update post Route
     */
    Route::post('/updatepost',[PostController::class,'updatePost']);
    /**
     * delete post Route
     */
    Route::post('/deletepost',[PostController::class,'deletePost']);
    /**
     * get all posts
     */
     Route::post('/getposts',[PostController::class,'readPost']);
});
