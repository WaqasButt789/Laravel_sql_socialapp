<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\ListingController;
Route::group(['middleware'=>'cauth'],function(){

    /**
     * Listing All posts Route
     */
    Route::post('/showallposts', [ListingController::class, 'listPosts']);

});
