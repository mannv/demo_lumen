<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BaseController extends Controller
{
    /**
     * save user access token
     * @param $user_id
     * @param string $access_token
     */
    protected function saveUserAccessToken($access_token = '', $user_id = 0) {
        if(empty($access_token)) {
            return;
        }
        if($user_id == 0) {
            $user_id = \Auth::id();
        }
        if($user_id == 0) {
            return;
        }
        $redisKey = 'access_token_' . $user_id;
        \Redis::set($redisKey, $access_token);
    }

    /**
     * get user access token
     * @param $user_id
     * @return bool|string
     */
    protected function getUserAccessToken($user_id = 0) {
        if($user_id == 0) {
            $user_id = \Auth::id();
        }
        if($user_id == 0) {
            return;
        }
        $redisKey = 'access_token_' . $user_id;
        $token = \Redis::get($redisKey);
        return $token;
    }
}
