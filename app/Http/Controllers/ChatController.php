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
        $chats= UserChat::where('user_id',$userId)
                        ->with('chat')
                        ->get()
                        ->pluck('chat');

        if(!$chats){
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

    public function createNewChat(Request $request){
     try {
        $userId = auth()->user()->id;
        $name = $request->input('name');
        if(!$userId){
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

        $userChat=new UserChat();
        
        $userChat->user_id=$userId;
        $userChat->chat_id=$newChat->id;

        $userChat->save();

     
    
        return response()->json([
            'success' => true,
            'message' => 'Chats created successfully',
            'data'=> $newChat
      
        ], 200);


     } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Chats cannot be created',
            'error' => $th->getMessage()
        ], 500);
     }
    }
}
