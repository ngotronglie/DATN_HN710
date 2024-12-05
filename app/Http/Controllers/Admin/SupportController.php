<?php

namespace App\Http\Controllers\Admin;

use App\Events\CommentEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    //     public function index()
    // {
    //     $user = Auth::user(); // Lấy người dùng đang đăng nhập
    
    //     // Lấy tất cả các phòng chat mà người dùng đang tham gia
    //     $chats = Chat::where('user_id', $user->id)->orWhere('staff_id', $user->id)->with(['user', 'staff'])->get();
    
    //     return view('admin.include.header', compact('chats'));
    // }
    public function show(Chat $chat)
    {
        $chat = Chat::find($chat->id);

        $messages = ChatDetail::where('chat_id', $chat->id)->with('sender')->get();
        return view('admin.layout.chat', compact('chat', 'messages'));
    }
    public function sendMessage(Request $request, Chat $chat)
    {

        // $message= $chat->messages()->create([
        //     'content' => $request->content,
        //     'sender_id' => Auth::id(),
        // ]);
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
    public function delete(Chat $chat) {
        $chat->delete(); // Xóa chat đã được truyền
        return redirect()->route('admin.dashboard'); 
    }
}
