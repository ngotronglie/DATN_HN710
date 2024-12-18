<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatClosedEvent;
use App\Events\CommentEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
   
    public function show(Chat $chat)
    {
        $chat = Chat::find($chat->id);
        $messages = ChatDetail::where('chat_id', $chat->id)->with('sender')->get();
        return view('admin.layout.chat', compact('chat', 'messages'));
    }
    
    public function sendMessage(Request $request, Chat $chat)
    {
      $message= ChatDetail::create([
             'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'content'=>$request->message
       ]);
       
      
        broadcast(new CommentEvent(Chat::find($chat->id),  $message));
        return response()->json([
            'log'   => 'success'
        ], 201);
    }
    
}
