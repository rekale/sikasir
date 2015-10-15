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
    
    post('/signup', 'AuthController@authenticate');
    
    Route::post('/signin', function () {
        $credentials = \Request::only('email', 'password');

        if ( ! $token = \JWTAuth::attempt($credentials)) {
            return response()->json(false, HttpResponse::HTTP_UNAUTHORIZED);
        }

        return response()->json(compact('token'));
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