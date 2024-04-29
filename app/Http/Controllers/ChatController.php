<?php

namespace App\Http\Controllers;

use App\Models\UserChat;
use Illuminate\Http\Request;

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
        ], 400);


        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Chats cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
