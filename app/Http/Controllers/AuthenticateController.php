<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $token = '';
        try {
            $token = JWTAuth::attempt($credentials);
            if(empty($token)) {
                return response()->json([
                    'error' => 'invalid credentials'
                ], 401);
            }
        } catch (JWTException $ex) {
            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
        return response()->json($token);
    }
}
