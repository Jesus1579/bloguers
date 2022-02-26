<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['jwt.verify'])->group(function(){
    Route::get('/', [OrderController::class,'index']);
    Route::post('/', [OrderController::class,'store']);
    Route::put('/{id}', [OrderController::class,'update']);
    Route::get('/{id}', [OrderController::class,'show']);
    Route::delete('/{id}', [OrderController::class,'destroy']);
    Route::put('/{id}', [OrderController::class,'update']);
    Route::post('/', [OrderController::class,'store'])->middleware(['jwt.verify.role:client']);
});

