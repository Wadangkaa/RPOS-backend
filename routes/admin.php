<?php

// auth
use App\Http\Controllers\User\UserAuthController;

Route::post('/login', [UserAuthController::class, 'login']);

Route::group(['middleware' => 'auth:rider'], function () {
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::get('/profile', [UserAuthController::class, 'profile']);
});
