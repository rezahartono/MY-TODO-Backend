<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RestAuthController extends Controller
{
    public function __construct()
    {
    }

    public function doLogin(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return ResponseFormatter::error($request->segment(3), null, "Unauthorized", 401, "Unauthorized");
        }

        $data = [
            'token' => $token,
            'type' => 'Bearer',
        ];

        return ResponseFormatter::success($request->segment(3), $data, "Authorized", 200);
    }

    public function doRegister(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:150', 'email', 'unique:users,email'],
            'password' => ['required', 'max:150'],
        ]);

        //if validation fails
        if ($validator->fails()) {
            return
                ResponseFormatter::error($request->segment(3), $validator->errors(), $validator->errors(), 400, "Bad Request");
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->role = 'user';
        $user->remember_token = Str::random(10);

        if ($user->save()) {
            return ResponseFormatter::success($request->segment(3), null, "User has been created!", 201, "Created");
        }
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        auth()->logout();
        return
            ResponseFormatter::success($request->segment(3), null, "You are has been logged out!", 200,);
    }
}
