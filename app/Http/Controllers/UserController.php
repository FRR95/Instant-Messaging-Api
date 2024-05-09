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

    public function updateProfile(Request $request)
    {
        try {
            $user = User::where("id", auth()->user()->id)
                ->first();

            if (!$user) {
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
                ], 400);
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
    public function getAllUsers(Request $request)
    {
        try {

            $nickname = $request->input('nickname');

            if(!$nickname){
                $users = User::all();


        

               
            }

            else{

                $users = User::query()
                              ->where("nickname","LIKE","%{$nickname}%")
                              ->orWhere("name","LIKE","%{$nickname}%")
                              ->get();
            }

            

            return response()->json([
                'success' => true,
                'message' => 'Users retrieved successfully',
                'data' => $users
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Users cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getUserProfile($id)
    {
        try {
            $user = User::where("id", $id)
                ->first();
            if (!$user) {
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
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function updateUserProfile($id, Request $request)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "user not found"
                    ],
                    400
                );
            }
          
            if ($user->role_id === 2) {
                return response()->json([
                    "success" => false,
                    "message" => "You cannot update an admin",
                ], 400);
            }

            $name = $request->input('name');
            $biography = $request->input('biography');

            $validator = Validator::make($request->all(), [ //validator facades
                'name' => 'required|string|min:4|max:10',
                'biography' => 'required|string|max:40'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors()
                ], 400);
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
                'message' => 'User profile cannot be updated',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteOneUserAccount($id,Request $request){

        try {
          
      
            $user = User::find($id);

     


            if (!$user) {
                return response()->json([
                    "success" => false,
                    "message" => "User not found",
                ], 400);
            }
            if ($user->role_id === 2) {
                return response()->json([
                    "success" => false,
                    "message" => "You cannot delete an admin",
                ], 400);
            }

   
          $userRemoved= $user->delete();
                               

            return response()->json([
                "success" => true,
                "message" => "User deleted successfully",
                "data"=>$userRemoved
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User profile cannot be deleted',
                'error' => $th->getMessage()
            ], 500);
        }

    }
    public function deleteUserAccount(Request $request){

        try {
            $userToRemove = $request->input("checkbox");
      
            $user = User::find($userToRemove);

     


            if (!$user) {
                return response()->json([
                    "success" => false,
                    "message" => "User not found",
                ], 400);
            }
          

   
          $userRemoved=  User::destroy($userToRemove);
                               

            return response()->json([
                "success" => true,
                "message" => "User deleted successfully",
                "data"=>$userRemoved
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User profile cannot be deleted',
                'error' => $th->getMessage()
            ], 500);
        }

    }
    
}
