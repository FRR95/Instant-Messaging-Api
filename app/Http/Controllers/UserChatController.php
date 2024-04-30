<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
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

            if ($userIdChat->count() === 0) {
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

    public function addUserToChat($userId, $chatId, Request $request)
    {
        try {
            $findChat = Chat::find($chatId);
            $findUser = User::find($userId);

            if (!$findChat) {
                return response()->json([
                    'success' => false,
                    'message' => "Chat not found",
                ], 400);
            }
            if (!$findUser) {
                return response()->json([
                    'success' => false,
                    'message' => "User not found",
                ], 400);
            }

            
            $findAuthorChat=Chat::where("id", $chatId)
            ->where("author_id", auth()->user()->id)
            ->get();

            if($findAuthorChat->count() === 0){
                return response()->json([
                    'success' => false,
                    'message' => "You are not allowed to add this user because you are not the author of this chat",
                ], 400);
            }


            $findUserChat = UserChat::where("chat_id", $chatId)
                ->where("user_id", $userId)
                ->get();

            if($findUserChat->count()===1){
                return response()->json([
                    'success' => false,
                    'message' => "This user is already in this chat!",
                ], 400);
            }

            $addUserChat=new UserChat();

            $addUserChat->user_id=$userId;
            $addUserChat->chat_id=$chatId;

            $addUserChat->save();


            return response()->json([
                'success' => true,
                'message' => "User added to chat successfully",
                'data' =>$addUserChat
            ], 200);
        


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be added to chat',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
