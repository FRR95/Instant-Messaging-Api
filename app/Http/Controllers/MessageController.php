<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\UserChat;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessagesFromChat($chatId, Request $request)
    {
        try {
            $findChatId = Chat::find($chatId);

            if (!$findChatId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 400);
            }

            $findUserChat = UserChat::where("user_id", auth()->user()->id)
                ->where("chat_id", $chatId)
                ->get();

            if ($findUserChat->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot retrieve the messages from this chat because you are not in this chat',
                ], 400);
            }

            $messagesChat = Message::where("chat_id", $chatId)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Messages retrieved successfully',
                'data' =>$messagesChat
            ], 200);

            dd($messagesChat);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Messages cannot be retrieved',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
