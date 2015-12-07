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


Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function()
{

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function()
    {
        post('mobile/login', 'AuthController@mobileLogin');
        post('login', 'AuthController@login');
        post('/register', 'AuthController@signup');

    });

    Route::group(['middleware' => 'jwt.auth'], function ()
    {

        Route::group(['namespace' => 'Owners'], function ()
        {
            get('owners', 'OwnersController@index');
            get('owners/{id}', 'OwnersController@show');
            post('owners', 'OwnersController@store');
            put('owners/{id}', 'OwnersController@update');
            delete('owners/{id}', 'OwnersController@destroy');
        });

        Route::group(['namespace' => 'Cashiers'], function ()
        {
            get('cashiers', 'CashiersController@index');
            get('cashiers/{id}', 'CashiersController@show');
            post('cashiers', 'CashiersController@store');
            put('cashiers/{id}', 'CashiersController@update');
            delete('cashiers/{id}', 'CashiersController@destroy');
        });

        Route::group(['namespace' => 'Outlets'], function()
        {

            post('outlets', 'OutletsController@store');
            get('outlets', 'OutletsController@index');
            get('outlets/{outletId}', 'OutletsController@show');
            put('outlets/{outletId}', 'OutletsController@update');
            delete('outlets/{outletId}', 'OutletsController@destroy');

            get('outlets/{outletId}/incomes', 'IncomesController@index');
            post('outlets/{outletId}/incomes', 'IncomesController@store');
            delete('outlets/{outletId}/incomes/{incomeId}', 'IncomesController@destroy');

            get('outlets/{outletId}/outcomes', 'OutcomesController@index');
            post('outlets/{outletId}/outcomes', 'OutcomesController@store');
            delete('outlets/{outletId}/outcomes/{outcomeId}', 'OutcomesController@destroy');

            get('outlets/{outletId}/customers', 'CustomersController@index');
            post('outlets/{outletId}/customers', 'CustomersController@store');

            get('outlets/{outletId}/products', 'ProductsController@index');

            get('outlets/{outletId}/employees', 'EmployeesController@index');


        });

        Route::group(['namespace' => 'Finances'], function()
        {
            delete('incomes/{id}', 'IncomesController@destroy');

        });

        Route::group(['namespace' => 'Employees'], function()
        {
            get('employees', 'EmployeesController@index');

        });



        Route::group(['namespace' => 'Products'], function()
        {


        });

        Route::group(['namespace' => 'Users'], function()
        {
            get('users/profile', 'UsersController@profile');
        });

    });


});
