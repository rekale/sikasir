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

get('refresh', function(){
})->middleware('jwt.refresh');

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
        
        Route::group(['namespace' => 'Tenants'], function ()
        {
            get('/', 'TenantController@index');
        });
        
        Route::group(['namespace' => 'Owners'], function ()
        {
            get('owners', 'OwnersController@index');
            get('owners/{id}', 'OwnersController@show');
            post('owners', 'OwnersController@store');
            put('owners/{id}', 'OwnersController@update');
            delete('owners/{id}', 'OwnersController@destroy');
        });
        
        Route::group(['namespace' => 'Customers'], function ()
        {
            get('customers', 'CustomersController@index');
            get('customers/{id}', 'CustomersController@show');
            post('customers', 'CustomersController@store');
            put('customers/{id}', 'CustomersController@update');
            delete('customers/{id}', 'CustomersController@destroy');
        });
  
        Route::group(['namespace' => 'Employees'], function ()
        {
            get('employees', 'EmployeesController@index');
            get('employees/{id}', 'EmployeesController@show');
            post('employees', 'EmployeesController@store');
            put('employees/{id}', 'EmployeesController@update');
            delete('employees/{id}', 'EmployeesController@destroy');
        });
        
        Route::group(['namespace' => 'Suppliers'], function ()
        {
            get('suppliers', 'SuppliersController@index');
            get('suppliers/{id}', 'SuppliersController@show');
            post('suppliers', 'SuppliersController@store');
            put('suppliers/{id}', 'SuppliersController@update');
            delete('suppliers/{id}', 'SuppliersController@destroy');
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
            
            get('outlets/{id}/products', 'ProductsController@index');

            get('outlets/{id}/employees', 'EmployeesController@index');
            
            get('outlets/{id}/orders', 'OrdersController@index');
            post('outlets/{id}/orders', 'OrdersController@store');
 
            get('outlets/{id}/orders/void', 'OrdersController@voided');
            get('outlets/{id}/orders/paid', 'OrdersController@paid');
            get('outlets/{id}/orders/unpaid', 'OrdersController@unpaid');
            
            Route::group(['namespace' => 'Stocks'], function()
            {
                
                get('outlets/{id}/entries', 'EntriesController@index');
                get('outlets/{id}/outs', 'OutsController@index');
                get('outlets/{id}/opnames', 'OpnamesController@index');
                get('outlets/{id}/purchases', 'PurchasesController@index');
                
                get('outlets/{id}/stocks', 'StocksController@index');
               
            });
            
        });
        
         
        Route::group(['namespace' => 'Products'], function()
        {
            get('products/{id}', 'ProductsController@show');
            post('products', 'ProductsController@store');
            put('products/{id}', 'ProductsController@update');
            delete('products/{id}', 'ProductsController@destroy');
            
            get('categories', 'CategoriesController@index');
            post('categories', 'CategoriesController@store');
            put('categories/{id}', 'CategoriesController@update');
            delete('categories/{id}', 'CategoriesController@destroy');
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
