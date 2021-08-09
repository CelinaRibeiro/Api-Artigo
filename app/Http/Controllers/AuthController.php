<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function create(Request $request) {
        $array = ['error' => ''];

        $rules = [
            'name' => 'required',   
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $hash;
        $newUser->token = '';
        $newUser->save();

        return $array;
    }

    public function login(Request $request) {
        $array = ['error' => ''];

        $creds = $request->only('email', 'password');

        $token = Auth::attempt($creds);

        if($token) {
            $array['token'] = $token;
        } else {
            $array['error'] = 'E-mail e/ou senha incorretos!';
        }

        return $array;
    }

    public function logout() {
        $array = ['error' => ''];

        Auth::logout();

        return $array;
    }

    //pegar user logado
    public function me() {
        $array = ['error' => ''];

        $user = Auth::user();

        $array['email'] = $user->email;

        return $array;
    }

}
