<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
        $this->validate($request, $rules);
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);
        $success['token'] = $user->createToken('app')->accessToken;
        return response($success);
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:4'
        ];
        $this->validate($request, $rules);
        $user = User::where('email', $request->email)->first();
        if (Hash::check($request->password, $user->password)) {
            return response(['token' => $user->createToken('token')->accessToken]);
        } else {
            return response('Credential did not match', 401);
        }
    }

    public function user()
    {
        return response(auth()->user());
    }

    public function logout()
    {
        auth('api')->user()->tokens->each(function ($token) {
            $token->delete();
        });
        return response('logged out');
    }
}
