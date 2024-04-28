<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',

                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $user
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request){
        try {
            $user = User::where("id", auth()->user()->id)
            ->first();

            if(!$user){
                return response()->json(
                    [
                        "success" => false,
                        "message" => "user not found"
                    ],
                    400
                );
            }

            $name = $request->input('name');
            $biography = $request->input('biography');

            $validator = Validator::make($request->all(), [ //validator facades
                'name' => 'required|string|min:4|max:10',
                'biography' => 'required|string|max:30'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors()
                ],400);
            }

            if ($name) {
                $user->name = $name;
                $user->biography = $biography;
            }


            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "user profile updated successfully",
                    "data" => $user
                ],
                200
            );
    

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be updated',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getUserProfile($id){
        try {
            $user=User::where("id",$id)
                      ->first();
            if(!$user){
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'User profile retrieved successfully',
                'data' => $user,
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User profile cannot be retrived',
            ], 500);
        }
    }


}
