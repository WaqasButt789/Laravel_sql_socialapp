<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCommentController;


Route::group(['middleware'=>'cauth'],function(){

/**
 * create comment
 */
Route::post('/comment',[UserCommentController::class,'createComment']);

/**
 * update comment
 */

Route::post('/updatecomment',[UserCommentController::class,'updateComment']);

/**
 * delete post
 */
Route::post('/deletecomment',[UserCommentController::class,'deleteComment']);
// Route::post('/comment',[user_comment_controller::class,'create_comment']);


});
