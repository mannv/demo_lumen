<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    
    public function __construct() {
        $this->middleware('jwt.auth',['only' => 'show']);
    }
    
    public function register(Request $request)
    {
        $validate = $this->validateRegisterUser($request->all());
        if ($validate->fails()) {
            $errors = $validate->errors();
            return response()->json($errors, 500);
        } else {
            $password = trim($request->get('password'));
            $email = trim($request->get('email'));
            $user = new User();
            $user->name = trim($request->get('name'));
            $user->email = $email;
            $user->password = \Hash::make($password);
            $user->save();

            $token = JWTAuth::attempt(['email' => $email, 'password' => $password]);
            $user->access_token = $token;
            $user->save();
            return response()->json(['status' => 1, 'access_token' => $token], 200);
        }
    }

    private function validateRegisterUser($data = array())
    {
        return \Validator::make($data, [
            'name' => 'required|min:5|max:45',
            'email' => 'required|email',
            'password' => 'required|min:6|max:32'
        ], [
            'name.required' => 'Vui long nhap ten cua ban',
            'name.min' => 'Ten cua ban it nhat phai co :min ky tu',
            'name.max' => 'Ten cua ban nhieu nhat :max ky tu',
            'email.required' => 'Vui long nhap email cua ban',
            'email.email' => 'Email khong dung dinh dang',
            'password.required' => 'Vui long nhap mat khau',
            'password.min' => 'Mat khau it nhat phai co :min ky tu',
            'password.max' => 'Mat khau nhieu nhat chi co :max ky tu'
        ]);
    }


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
            if (empty($token)) {
                return response()->json([
                    'error' => 'invalid credentials'
                ], 401);
            }
        } catch (JWTException $ex) {
            return response()->json([
                'error' => $ex->getMessage()
            ], 500);
        }
        return response()->json(['status' => 1,'access_token' => $token]);
    }


    public function show() {
        try {
            $list = User::orderBy('id', 'DESC')->paginate(10);
            return response()->json(['status' => 1, 'users' => $list]);
        } catch (Exception $ex) {
            return response()->json(['status' => -1, 'message' => $ex->getMessage()], 404);
        }
    }
}
