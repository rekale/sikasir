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



Route::group(['prefix' => 'doc'], function()
{
    get('/endpoint', function () {
        return view('doc.endpoint');
    });
    get('/format', function () {
        return view('doc.format');
    });
});

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
        
        Route::group(['namespace' => 'Employees'], function ()
        {
            get('employees', 'EmployeesController@index');
            get('employees/{id}', 'EmployeesController@show');
            post('employees', 'EmployeesController@store');
            put('employees/{id}', 'EmployeesController@update');
            delete('employees/{id}', 'EmployeesController@destroy');
        });

        Route::group(['namespace' => 'Outlets'], function()
        {

            post('outlets', 'OutletsController@store');
            get('outlets', 'OutletsController@index');
            get('outlets/{id}', 'OutletsController@show');
            put('outlets/{id}', 'OutletsController@update');
            delete('outlets/{id}', 'OutletsController@destroy');

            get('outlets/{id}/incomes', 'IncomesController@index');
            post('outlets/{id}/incomes', 'IncomesController@store');
            delete('outlets/{id}/incomes/{incomeId}', 'IncomesController@destroy');

            get('outlets/{id}/outcomes', 'OutcomesController@index');
            post('outlets/{id}/outcomes', 'OutcomesController@store');
            delete('outlets/{id}/outcomes/{outcomeId}', 'OutcomesController@destroy');

            get('outlets/{id}/customers', 'CustomersController@index');
            post('outlets/{id}/customers', 'CustomersController@store');

            get('outlets/{id}/products', 'ProductsController@index');

            get('outlets/{id}/employees', 'EmployeesController@index');
            
            
            Route::group(['namespace' => 'Stocks'], function()
            {
                
                get('outlets/{id}/entries', 'EntriesController@index');
                get('outlets/{id}/outs', 'OutsController@index');
                
                get('outlets/{id}/stocks', 'StocksController@index');
               
            });
            
        });
        
         
        Route::group(['namespace' => 'Products'], function()
        {
            get('products', 'ProductsController@index');
            get('products/{id}', 'ProductsController@show');
            post('products', 'ProductsController@store');
            put('products/{id}', 'ProductsController@update');
            delete('products/{id}', 'ProductsController@destroy');
            
            get('categories', 'CategoriesController@index');
            
        });
        
        Route::group(['namespace' => 'Finances'], function()
        {
            delete('incomes/{id}', 'IncomesController@destroy');

        });

        Route::group(['namespace' => 'Employees'], function()
        {
            get('employees', 'EmployeesController@index');

        });

        Route::group(['namespace' => 'Users'], function()
        {
            get('users/profile', 'UsersController@profile');
        });

    });


});
