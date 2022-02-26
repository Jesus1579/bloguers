<?php

use App\Http\Controllers\Api\RequerimentController as Controller;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['jwt.verify']], function() {//
    Route::get('/', [Controller::class,'index']);
    Route::get('/{id}', [Controller::class,'show']);
    Route::post('/', [Controller::class,'store']);
    Route::put('/{id}', [Controller::class,'update']);
    Route::delete('/{id}', [Controller::class,'destroy']);
});
