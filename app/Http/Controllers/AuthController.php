<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function login(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');


            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'email' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Validation failed",
                        "error" => $validator->errors()
                    ],
                    400
                );
            }

            $user = User::query()
                ->where('email', $email)
                ->first();

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Email not found",

                    ],
                    400
                );
            }

            $checkPasswordUser = Hash::check($password, $user->password);


            if (!$checkPasswordUser) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Incorrect password",

                    ],
                    400
                );
            }

            $token = $user->createToken('api-token')->plainTextToken;



            $user->is_active = 1;
            $user->save();

            // Responder con el token
            return response()->json(
                [
                    "success" => true,
                    "message" => "User logged successfully",
                    "token" => $token
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be logged',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            // $user = User::where("id", auth()->user()->id)
            //     ->get();


            $request->user()->tokens()->delete();

            // $user->is_active = 0;
            // $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully',

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be logged out',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function userDisconnect(Request $request)
    {
        try {

        

                $user = User::query()
                ->where('id', auth()->user()->id)
                ->first();

            $user->is_active = 0;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User disconnected successfully',

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be disconnected',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
