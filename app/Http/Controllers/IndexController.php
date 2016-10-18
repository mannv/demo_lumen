<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    //
    public function index() {
        $hash1 = \Hash::make('123123');
        $hash2 = '$2y$10$jXXQfi7pJtIkwgpaFliADeJ1xRy3r0cB/aAOSbYfMtfFpigpm2kQu';
        echo $hash1 . '<br />';
        echo $hash2 . '<br />';
        var_dump(\Hash::check('123123',$hash1) && \Hash::check('123123',$hash2));
        die;

        $credentials = \Auth::attempt(array(
            'email' => 'anhmantk@gmail.com',
            'password' => '123123',
            'status' => 1
        ));
        var_dump($credentials);die;
//
//        \Auth::guard();

        $u = new User();
        $u->name = 'anhmantk';
        $u->email = 'anhmantk@gmail.com';
        $u->password = \Hash::make('123123');
        $u->save();
        die;

        return view ('welcome');
    }
}