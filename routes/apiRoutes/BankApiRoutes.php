<?php

use App\Http\Controllers\Api\BankController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BankController::class,'index']);

Route::middleware(['jwt.verify','jwt.verify.role:admin|office|finance|approves'])->group(function(){
    Route::post('/', [BankController::class,'store']);
    Route::get('/{id}', [BankController::class,'show']);
    Route::put('/{id}', [BankController::class,'update']);
    Route::delete('/{id}', [BankController::class,'destroy']);
});
