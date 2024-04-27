<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $name = $request->input('name');
            $nickname = $request->input('nickname');
            $password = $request->input('password');
            $biography = "Hola!,soy $name y esta es mi biografía";
            $email = $request->input('email');
            $url_profile_img = "https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Windows_10_Default_Profile_Picture.svg/2048px-Windows_10_Default_Profile_Picture.svg.png";


            $validator = Validator::make($request->all(), [ //validator facades
                'name' => 'required|string|min:4|max:10',
                'nickname' => 'required|string|unique:users|unique:users',
                'password' => 'required|string|min:4|max:10',
                'email' => 'required|string|unique:users'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors()
                ]);
            }

            $hashPassword = bcrypt($password);

            $newUser = new User();
            $newUser->name = $name;
            $newUser->nickname = $nickname;
            $newUser->biography = $biography;
            $newUser->password = $hashPassword;
            $newUser->url_profile_image = $url_profile_img;
            $newUser->email = $email;
            $newUser->password = $hashPassword;
            $newUser->save();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $newUser
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be registered',
                'error' => $th->getMessage()
            ]);
        }
    }
}
