<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\UserChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            ->with("user")
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Messages retrieved successfully',
                'data' => $messagesChat
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

    public function createMessage($chatId, Request $request)
    {
        try {
            $findChatId = Chat::find($chatId);

            $messageContent = $request->input("content");

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
                    'message' => 'You cannot create the message to this chat because you are not in this chat',
                ], 400);
            }


            $validator = Validator::make($request->all(), [
                'content' => 'required|string|min:1|max:100'
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

            $message = new Message();
            $message->content = $messageContent;
            $message->chat_id = $chatId;
            $message->user_id = auth()->user()->id;

            $message->save();

            return response()->json([
                'success' => true,
                'message' => 'Messages created successfully',
                'data' => $message
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Message cannot be created',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function updateMessage($chatId, $messageId, Request $request)
    {
        try {

            $findChatId = Chat::find($chatId);
            $findMessageId = Message::find($messageId);
            $message = $request->input('content');

            if (!$findChatId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 400);
            }
            if (!$findMessageId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message not found'
                ], 400);
            }

            $findUserChat = UserChat::where("user_id", auth()->user()->id)
                ->where("chat_id", $chatId)
                ->get();

            if ($findUserChat->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot update the message to this chat because you are not in this chat',
                ], 400);
            }

            $findUserMesssage = Message::where("user_id", auth()->user()->id)
                ->where("id", $messageId)
                ->get();


            if ($findUserMesssage->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot update the message because you are not the owner of the message',
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'content' => 'required|string|min:1|max:100'
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

            $findMessageId->content = $message;
            $findMessageId->save();


            return response()->json([
                'success' => true,
                'message' => 'Message updated successfully',
                'data' => $findMessageId
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Message cannot be updated',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteMessage($chatId, $messageId, Request $request)
    {
        try {
            $findChatId = Chat::find($chatId);
            $findMessageId = Message::find($messageId);
            

            if (!$findChatId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat not found'
                ], 400);
            }
            if (!$findMessageId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Message not found'
                ], 400);
            }

            $findUserChat = UserChat::where("user_id", auth()->user()->id)
                ->where("chat_id", $chatId)
                ->get();

            if ($findUserChat->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete the message to this chat because you are not in this chat',
                ], 400);
            }

            $findUserMesssage = Message::where("user_id", auth()->user()->id)
                ->where("id", $messageId)
                ->get();


            if ($findUserMesssage->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete the message because you are not the owner of the message',
                ], 400);
            }

            $findMessageId->delete();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Message cannot be deleted',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
