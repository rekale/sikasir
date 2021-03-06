<?php

use Sikasir\V1\Outlets\Outlet;

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

get('/tes/{id}', function($id) {
	return Outlet::where('company_id', '=', 1)
	->find($id)
	->variants()->where('variants.name', 'like', 'nihil')->get();
});
    
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
        get('/refresh', 'AuthController@refresh');
        

    });

    Route::group(['middleware' => 'jwt.auth'], function ()
    {
        
        Route::group(['namespace' => 'Tenants'], function ()
        {
            get('/', 'TenantController@myCompany');
            get('/business_field', 'TenantController@businessField');
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
            get('customers/search/{field}/{word}', 'CustomersController@search');
            get('customers/{id}', 'CustomersController@show');
            post('customers', 'CustomersController@store');
            put('customers/{id}', 'CustomersController@update');
            delete('customers/{id}', 'CustomersController@destroy');

            get('customers/{id}/histories/{dateRange}', 'CustomersController@reportFor');
        });
        
        /* 	EMPLOYEES */
        Route::group(['namespace' => 'Employees'], function()
        {
        	get('employees', 'EmployeesController@index');
        	get('employees/search/{field}/{word}', 'EmployeesController@search');
        	get('employees/reports/{dateRange}', 'EmployeesController@report');
        	get('employees/{id}/reports/{dateRange}', 'EmployeesController@reportFor');
        	get('employees/salesreport/{dateRange}', 'EmployeesController@salesReport');
        	get('employees/{id}', 'EmployeesController@show');
        	post('employees', 'EmployeesController@store');
        	put('employees/{id}', 'EmployeesController@update');
        	delete('employees/{id}', 'EmployeesController@destroy');
        
        });
  
       
        /* SUPPLIER */
        Route::group(['namespace' => 'Suppliers'], function ()
        {
            get('suppliers', 'SuppliersController@index');
            get('suppliers/search/{field}/{word}', 'SuppliersController@search');
            get('suppliers/{id}', 'SuppliersController@show');
            post('suppliers', 'SuppliersController@store');
            put('suppliers/{id}', 'SuppliersController@update');
            delete('suppliers/{id}', 'SuppliersController@destroy');

            get('suppliers/{id}/purchases/search/{field}/{word}', 'POController@searchThrough');
            get('suppliers/{id}/purchases', 'POController@indexThrough');
        });

        Route::group(['namespace' => 'Outlets'], function()
        {
            /* OUTLETS */
            post('outlets', 'OutletsController@store');
            get('outlets/search/{field}/{word}', 'OutletsController@search');
            get('outlets', 'OutletsController@index');
            get('outlets/{id}', 'OutletsController@show');
            put('outlets/{id}', 'OutletsController@update');
            delete('outlets/{id}', 'OutletsController@destroy');
            
            /* INCOMES */
            get('outlets/{id}/incomes/search/{field}/{word}', 'IncomesController@searchThrough');
            get('outlets/{id}/incomes', 'IncomesController@indexThrough');
            post('outlets/{id}/incomes', 'IncomesController@storeThrough');
            delete('outlets/{id}/incomes/{incomeId}', 'IncomesController@destroyThrough');

            /* OUTCOMES */
            get('outlets/{id}/outcomes/search/{field}/{word}', 'OutcomesController@searchThrough');
            get('outlets/{id}/outcomes', 'OutcomesController@indexThrough');
            post('outlets/{id}/outcomes', 'OutcomesController@storeThrough');
            delete('outlets/{id}/outcomes/{outcomeId}', 'OutcomesController@destroyThrough');

            /* TAXES */
            get('outlets/all/taxes/reports/{dateRange}', 'TaxesController@allReports');
            get('outlets/{outletId}/taxes/reports/{dateRange}', 'TaxesController@reports');
            
            /*VARIANTS*/
            get('outlets/{outletId}/variants/search/{field}/{word}', 'OutletsController@searchVariants');
            
            /* PRODUCTS */
           	get('outlets/all/products', 'ProductsController@index');
           	get('outlets/{id}/products/search/{field}/{word}', 'ProductsController@searchThrough');
           	get('outlets/all/products/reports/{dateRange}', 'ProductsController@report');
            get('outlets/all/products/reports/{dateRange}/best-seller', 'ProductsController@bestSeller');
            get('outlets/{outletId}/products/reports/{dateRange}', 'ProductsController@reportThrough');
            get('outlets/{outletId}/products/reports/{dateRange}/best-seller', 'ProductsController@bestSellerThrough');
            
            /* INVENTORY */
            get('outlets/{outletId}/products', 'ProductsController@indexThrough');
            get('outlets/{outletId}/products/{productId}', 'ProductsController@showThrough');
            
            /* PRINTERS */
            get('outlets/{id}/printers/search/{field}/{word}', 'PrintersController@searchThrough');
			get('outlets/{throughId}/printers', 'PrintersController@indexThrough');
            get('outlets/{throughId}/printers/{id}', 'PrintersController@showThrough');
            post('outlets/{id}/printers', 'PrintersController@storeThrough');
            put('outlets/{outletId}/printers/{printerId}', 'PrintersController@updateThrough');
            delete('outlets/{outletId}/printers/{printerId}', 'PrintersController@destroyThrough');
            
            /* ORDERS */
            get('outlets/all/orders/search/{field}/{word}', 'OrdersController@search');
            get('outlets/{id}/orders/search/{field}/{word}', 'OrdersController@searchThrough');
            get('outlets/all/orders', 'OrdersController@index');
            get('outlets/{outletId}/orders', 'OrdersController@indexThrough');
            get('outlets/{outletId}/orders/{id}', 'OrdersController@showThrough');
            post('outlets/{id}/orders', 'OrdersController@storeThrough');
            
            put('orders/{id}/void', 'OrdersController@voidOrder');
            put('orders/{id}/debt-settled', 'OrdersController@debtSettledOrder');
            
            get('outlets/all/orders/reports/{dateRange}', 'OrdersController@report');
            get('outlets/{id}/orders/reports/{dateRange}', 'OrdersController@reportThrough');
            get('outlets/all/orders/reports/{dateRange}/void', 'OrdersController@void');
            get('outlets/{id}/orders/reports/{dateRange}/void', 'OrdersController@voidThrough');
            get('outlets/all/orders/reports/{dateRange}/debt', 'OrdersController@debt');
            get('outlets/{id}/orders/reports/{dateRange}/debt', 'OrdersController@debtThrough');
            get('outlets/all/orders/reports/{dateRange}/debt-settled', 'OrdersController@settled');
            get('outlets/{id}/orders/reports/{dateRange}/debt-settled', 'OrdersController@settledThrough');
            
            
            /* PAYMENTS */
            get('outlets/all/payments/reports/{dateRange}', 'PaymentsController@allReports');
            get('outlets/{outletId}/payments/reports/{dateRange}', 'PaymentsController@reports');
            
            Route::group(['namespace' => 'Stocks'], function()
            {

            	get('outlets/{id}/entries/search/{field}/{word}', 'EntriesController@searchThrough');
            	get('outlets/{outletId}/entries/{id}', 'EntriesController@showThrough');
                get('outlets/{id}/entries', 'EntriesController@indexThrough');
                post('outlets/{id}/entries', 'EntriesController@storeThrough');

                get('outlets/{id}/entries/search/{field}/{word}', 'OutsController@searchThrough');
                get('outlets/{outletId}/outs/{id}', 'OutsController@showThrough');
                get('outlets/{id}/outs', 'OutsController@indexThrough');
                post('outlets/{id}/outs', 'OutsController@storeThrough');
                
                get('outlets/{id}/opnames', 'OpnamesController@indexThrough');
                post('outlets/{id}/opnames', 'OpnamesController@storeThrough');
                
                get('outlets/{id}/purchases', 'PurchasesController@indexThrough');
                get('outlets/{outletId}/purchases/{id}', 'PurchasesController@showThrough');
                post('outlets/{id}/purchases', 'PurchasesController@storeThrough');
                
            });
            
        });
        
        /* PRODUCTS AND CATEGORIES */ 
        Route::group(['namespace' => 'Products'], function()
        {
            post('products', 'ProductsController@store');
            put('products/{id}', 'ProductsController@update');
            delete('products/{id}', 'ProductsController@destroy');
            delete('variants/{id}', 'ProductsController@destroyVariants');
            
            get('outlets/all/categories/reports/{dateRange}', 'CategoriesController@report');
            get('outlets/{outletId}/categories/reports/{dateRange}', 'CategoriesController@reportThrough');
            
            get('categories/search/{field}/{word}', 'CategoriesController@search');
            get('categories/{id}', 'CategoriesController@show');
            post('categories', 'CategoriesController@store');
            put('categories/{id}', 'CategoriesController@update');
            delete('categories/{id}', 'CategoriesController@destroy');
            
        });
        
        Route::group(['namespace' => 'Settings'], function()
        {
            
            /* DISCOUNT */
            get('discounts/search/{field}/{word}', 'DiscountsController@search');
            get('discounts', 'DiscountsController@index');
            get('discounts/{id}', 'DiscountsController@show');
            post('discounts', 'DiscountsController@store');
            put('discounts/{id}', 'DiscountsController@update');
            delete('discounts/{id}', 'DiscountsController@destroy');
            
            
            /* TAXES */
            get('taxes/search/{field}/{word}', 'TaxesController@search');
            get('taxes', 'TaxesController@index');
            get('taxes/{id}', 'TaxesController@show');
            post('taxes', 'TaxesController@store');
            put('taxes/{id}', 'TaxesController@update');
            delete('taxes/{id}', 'TaxesController@destroy');
            
            
            /* PAYMENTS */
            get('payments/search/{field}/{word}', 'PaymentsController@search');
            get('payments', 'PaymentsController@index');
            get('payments/{id}', 'PaymentsController@show');
            post('payments', 'PaymentsController@store');
            put('payments/{id}', 'PaymentsController@update');
            delete('payments/{id}', 'PaymentsController@destroy');

        });


        Route::group(['namespace' => 'Users'], function()
        {
            get('users/profile', 'UsersController@profile');
        });

    });


});
