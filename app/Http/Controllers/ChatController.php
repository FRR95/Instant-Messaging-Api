<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\UserChat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function getUserChats(Request $request)
    {
        try {

            $userId = auth()->user()->id;
            $chats = UserChat::where('user_id', $userId)
                ->with('chat')
                ->get()
                ->pluck('chat');

            if (!$chats) {
                return response()->json([
                    'success' => false,
                    'message' => 'chats not found',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'chats retrieved successfully',
                'data' => $chats,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Chats cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function createNewChat(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $name = $request->input('name');
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 400);
            }

            $validator = Validator::make($request->all(), [ //validator facades
                'name' => 'required|string|min:4|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors()
                ]);
            }

            $newChat = new Chat();
            $newChat->name = $name;
            $newChat->author_id = $userId;

            $newChat->save();

            $userChat = new UserChat();

            $userChat->user_id = $userId;
            $userChat->chat_id = $newChat->id;

            $userChat->save();



            return response()->json([
                'success' => true,
                'message' => 'Chats created successfully',
                'data' => $newChat

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Chats cannot be created',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function updateChat($id, Request $request)
    {
        try {
        $findChat= Chat::find($id);

        if(!$findChat){
            return response()->json([
                'success' => false,
                'message' => 'Room not found',  
            ], 400);
        }

        if($findChat->author_id !== auth()->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'You dont have permissions to update the room',  
            ], 400);
        }

        $name=$request->input('name');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:10'
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

        $findChat->name=$name;

        $findChat->save();

        return response()->json([
            'success' => true,
            'message' => 'Chat updated successfully',
            'data' => $findChat ,
        ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Chat cannot be updated',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteChat($id, Request $request){
        try {
          $chat=Chat::find($id);

          if(!$chat){
            return response()->json([
                'success' => false,
                'message' => 'Chat not found',    
            ], 400);
          }

          if($chat->author_id !== auth()->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'You dont have permissions to delete the chat',  
            ], 400);
        }

        $chat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat deleted successfully',  
        ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Chat cannot be deleted',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
