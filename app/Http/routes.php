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
        
        /* CUSTOMERS */
        Route::group(['namespace' => 'Customers'], function ()
        {
            get('customers', 'CustomersController@index');
            get('customers/{id}', 'CustomersController@show');
            post('customers', 'CustomersController@store');
            put('customers/{id}', 'CustomersController@update');
            delete('customers/{id}', 'CustomersController@destroy');
            
            get('customers/{id}/histories/{dateRange}', 'CustomersController@transactionHistories');
        });
  
        /* EMPLOYEES */
        Route::group(['namespace' => 'Employees'], function ()
        {
            get('employees', 'EmployeesController@index');
            get('employees/{id}', 'EmployeesController@show');
            post('employees', 'EmployeesController@store');
            put('employees/{id}', 'EmployeesController@update');
            delete('employees/{id}', 'EmployeesController@destroy');
        });
        
        /* SUPPLIER */
        Route::group(['namespace' => 'Suppliers'], function ()
        {
            get('suppliers', 'SuppliersController@index');
            get('suppliers/{id}', 'SuppliersController@show');
            post('suppliers', 'SuppliersController@store');
            put('suppliers/{id}', 'SuppliersController@update');
            delete('suppliers/{id}', 'SuppliersController@destroy');
            
            get('suppliers/{id}/purchases', 'SuppliersController@purchaseOrders');
        });

        Route::group(['namespace' => 'Outlets'], function()
        {
            /* OUTLETS */
            post('outlets', 'OutletsController@store');
            get('outlets', 'OutletsController@index');
            get('outlets/{id}', 'OutletsController@show');
            put('outlets/{id}', 'OutletsController@update');
            delete('outlets/{id}', 'OutletsController@destroy');
            
            /* INCOMES */
            get('outlets/{id}/incomes', 'IncomesController@index');
            post('outlets/{id}/incomes', 'IncomesController@store');
            delete('outlets/{id}/incomes/{incomeId}', 'IncomesController@destroy');

            /* OUTCOMES */
            get('outlets/{id}/outcomes', 'OutcomesController@index');
            post('outlets/{id}/outcomes', 'OutcomesController@store');
            delete('outlets/{id}/outcomes/{outcomeId}', 'OutcomesController@destroy');
            
            /* CATEGORIES */
            get('outlets/all/categories/reports/{dateRange}', 'CategoriesController@allReports');
            get('outlets/{outletId}/categories/reports/{dateRange}', 'CategoriesController@reports');
            
            /* PRODUCTS */
            get('outlets/all/products', 'ProductsController@all');
            get('outlets/all/products/reports/{dateRange}', 'ProductsController@allReports');
            get('outlets/all/products/reports/{dateRange}/best-seller', 'ProductsController@allBestSeller');
            get('outlets/{outletId}/products/reports/{dateRange}', 'ProductsController@reports');
            get('outlets/{outletId}/products/reports/{dateRange}/best-seller', 'ProductsController@bestSeller');
            
            get('outlets/{outletId}/products', 'ProductsController@index');
            get('outlets/{outletId}/products/{productId}', 'ProductsController@show');
            put('outlets/{outletId}/products/{productId}', 'ProductsController@update');
            delete('outlets/{outletId}/products/{productId}', 'ProductsController@destroy');
            
            /* EMPLOYEES */ 
            get('outlets/{id}/employees', 'EmployeesController@index');
            //get('outlets/{id}/employees/reports', 'EmployeesController@reports');
            
            /* PRINTERS */
            post('outlets/{id}/printers', 'PrintersController@store');
            put('outlets/{outletId}/printers/{printerId}', 'PrintersController@update');
            delete('outlets/{outletId}/printers/{printerId}', 'PrintersController@destroy');
            
            /* ORDERS */
            get('outlets/all/orders/{dateRange}', 'OrdersController@all');
            get('outlets/{id}/orders/{dateRange}', 'OrdersController@index');
            get('outlets/{id}/orders/{dateRange}/void', 'OrdersController@void');
            get('outlets/{id}/orders/{dateRange}/debt', 'OrdersController@debtNotSettled');
            get('outlets/{id}/orders/{dateRange}/debt-settled', 'OrdersController@debtSettled');
            post('outlets/{id}/orders', 'OrdersController@store');
            
            /* PAYMENTS */
            get('outlets/all/payments/reports/{dateRange}', 'PaymentsController@allReports');
            get('outlets/{outletId}/payments/reports/{dateRange}', 'PaymentsController@reports');
            
            Route::group(['namespace' => 'Stocks'], function()
            {
                
                get('outlets/{id}/entries', 'EntriesController@index');
                post('outlets/{id}/entries', 'EntriesController@store');
                
                get('outlets/{id}/outs', 'OutsController@index');
                post('outlets/{id}/outs', 'OutsController@store');
                
                get('outlets/{id}/opnames', 'OpnamesController@index');
                post('outlets/{id}/opnames', 'OpnamesController@store');
                
                get('outlets/{id}/purchases', 'PurchasesController@index');
                post('outlets/{id}/purchases', 'PurchasesController@store');
                
            });
            
        });
        
        /* PRODUCTS AND CATEGORIES */ 
        Route::group(['namespace' => 'Products'], function()
        {
            post('products', 'ProductsController@store');
            
            get('categories', 'CategoriesController@index');
            post('categories', 'CategoriesController@store');
            put('categories/{id}', 'CategoriesController@update');
            delete('categories/{id}', 'CategoriesController@destroy');
            
        });
        
        Route::group(['namespace' => 'Settings'], function()
        {
            
            /* DISCOUNT */
            post('discounts', 'DiscountsController@store');
            put('discounts/{id}', 'DiscountsController@update');
            delete('discounts/{id}', 'DiscountsController@destroy');
            
            
            /* TAXES */
            post('taxes', 'TaxesController@store');
            put('taxes/{id}', 'TaxesController@update');
            delete('taxes/{id}', 'TaxesController@destroy');
            
            
            /* PAYMENTS */
            get('payments/reports', 'PaymentsController@reports');
            post('payments', 'PaymentsController@store');
            put('payments/{id}', 'PaymentsController@update');
            delete('payments/{id}', 'PaymentsController@destroy');

        });

        Route::group(['namespace' => 'Employees'], function()
        {
            get('employees', 'EmployeesController@index');
            get('employees/{id}', 'EmployeesController@show');
            post('employees', 'EmployeesController@store');
            put('employees', 'EmployeesController@update');

        });

        Route::group(['namespace' => 'Users'], function()
        {
            get('users/profile', 'UsersController@profile');
        });

    });


});
