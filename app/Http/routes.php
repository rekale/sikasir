<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'v1'], function()
{
   
    Route::group(['namespace' => 'User', 'prefix' => 'auth'], function()
    {
        post('mobile/login', 'AuthController@mobileLogin');
        post('login', 'AuthController@login');
        post('/signup', 'AuthController@signup');
    });
    
    Route::group(['middleware' => 'jwt.auth'], function ()
    {
        
         Route::group(['namespace' => 'Outlets', 'middleware' => 'jwt.auth'], function()
        {
            get('outlets/{outletId}/incomes', 'OutletIncomeController@index');
            post('outlets/{outletId}/incomes', 'OutletIncomeController@store');
            delete('outlets/{outletId}/incomes/{incomeId}', 'OutletIncomeController@destroy');

            get('outlets/{outletId}/outcomes', 'OutletOutcomeController@index');
            post('outlets/{outletId}/outcomes', 'OutletOutcomeController@store');
            delete('outlets/{outletId}/outcomes/{outcomeId}', 'OutletOutcomeController@destroy');
            
            get('outlets/{outletId}/customers', 'OutletCustomerController@index');
            post('outlets/{outletId}/customers', 'OutletCustomerController@store');
            delete('outlets/{outletId}/customers/{customerId}', 'OutletCustomerController@destroy');

        });

        Route::group(['namespace' => 'Finances'], function()
        {
            delete('incomes/{id}', 'IncomesController@destroy');

        });
        
        
    });
   
    
});