<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\UserChat;
use Illuminate\Http\Request;

class UserChatController extends Controller
{
    public function getUsersChat($id, Request $request)
    {
        try {
            $chatId = Chat::find($id);

            if (!$chatId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found',
                ], 400);
            }
            $userIdChat =  UserChat::where("user_id", auth()->user()->id)
                                   ->where("chat_id", $id)
                                   ->get();
                                   
            if($userIdChat->count() === 0){
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot see the users from this chat because you are not in this chat',
                ], 400);
            }
            
            $userchat = UserChat::where("chat_id", $id)
                ->with("user")
                ->get()
                ->pluck("user");
            
                return response()->json([
                    'success' => true,
                    'message' => 'Users chat retrieved successfully',
                    'data' => $userchat,
                ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Users Chat cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
