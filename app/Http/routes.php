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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'v1'], function()
{
   
    Route::group(['namespace' => 'User', 'prefix' => 'auth'], function()
    {
        post('mobile/login', 'AuthController@mobileLogin');
        post('login', 'AuthController@login');
        post('/signup', 'AuthController@signup');
    });
    
    Route::group(['namespace' => 'Outlets'], function()
    {
        get('outlets/{outletId}/incomes', 'OutletIncomeController@index');
        post('outlets/{outletId}/incomes', 'OutletIncomeController@store');
        delete('outlets/{outletId}/incomes/{incomeId}', 'OutletIncomeController@destroy');
    });
    
    Route::group(['namespace' => 'Finances'], function()
    {
        delete('incomes/{id}', 'IncomesController@destroy');
        
    });
    
    
   
     Route::get('/restricted', [
   'middleware' => 'jwt.auth',
   function () {
       $token = \JWTAuth::getToken();
       $user = \JWTAuth::toUser($token);

       return response()->json([
           'data' => [
               'email' => $user->email,
               'registered_at' => $user->created_at->toDateTimeString()
           ]
       ]);
   }
]);
    
});