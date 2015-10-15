<?php

namespace Sikasir\Http\Controllers;

use Illuminate\Http\Request;
use Sikasir\Http\Requests;
use Sikasir\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $data = $request->only('email', 'password', 'name');
        

        try {
            $user = \Sikasir\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            ]);
        } catch (Exception $e) {
            
            return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
        }

        $token = \JWTAuth::fromUser($user);

        return response()->json(compact('token'));
    }
}
