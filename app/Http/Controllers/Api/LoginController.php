<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Http\RedirectResponse;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        if(!auth::attempt($request->only("email","password"))) {
            return response()->json([
                'status' => false,
                'message'=> 'gagal login'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'=> true,
            'data' => $user,
            'access_token' => 'login success',
        ], 200);

    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status'=> true,
            'message'=> 'logout success',
        ], 200);
    }
}
