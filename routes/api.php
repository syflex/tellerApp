<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::namespace('Api')->group(function () {
    
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::resource('zone', 'ZoneController');

    Route::middleware('auth:api')->group(function () {   
        Route::get('user', 'AuthController@user');
        Route::resource('subscriber', 'UserController'); 
        Route::resource('transaction', 'TransactionController'); 
        Route::resource('dashboard', 'DashboardController');
        Route::resource('staff/dashboard', 'StaffDashboardController'); 
        Route::resource('expenses', 'ExpensesController');
        Route::resource('payment/token', 'PaymentTokenController');
        Route::resource('staff', 'StaffController');
        Route::resource('payment/cycle', 'PaymentCycleController');
    });
});