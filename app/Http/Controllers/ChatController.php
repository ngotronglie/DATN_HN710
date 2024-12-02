<?php
namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\Chat;
use App\Models\ChatDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Lấy người dùng đang đăng nhập
    
        // Lấy tất cả các phòng chat mà người dùng đang tham gia
        $chats = Chat::where('user_id', $user->id)->orWhere('staff_id', $user->id)->with(['user', 'staff'])->get();
    
        return view('chats.index', compact('chats'));
    }
    

    public function createRoom()
    {
        $user_id = Auth::id();
        
        // Lấy danh sách nhân viên role = 1 và có số lượng chat <= 10
        $availableStaffs = User::where('role', '1')
            ->whereNotIn('id', function ($query) {
                $query->select('staff_id')
                    ->from('chats')
                    ->groupBy('staff_id')
                    ->havingRaw('COUNT(*) >= 5');
            })
            ->get();
        
        // Kiểm tra nếu không có nhân viên khả dụng
        if ($availableStaffs->isEmpty()) {
            return redirect()->back()->with('success', 'Hiện không còn nhân viên nào khả dụng để chat.');
        }
    
        // Chọn ngẫu nhiên một nhân viên từ danh sách khả dụng
        $staff = $availableStaffs->random();
    
        // Kiểm tra xem đã tồn tại phòng chat giữa người dùng và nhân viên này chưa
        $chat = Chat::where(function ($query) use ($user_id, $staff) {
            $query->where('user_id', $user_id)->where('staff_id', $staff->id);
        })->first();
    
        // Nếu chưa có phòng chat, tạo mới
        if (!$chat) {
            $chat = Chat::create([
                'user_id' => $user_id,
                'staff_id' => $staff->id,
            ]);
        }
    
        // Điều hướng đến trang hiển thị chat
        return redirect()->route('chat.show', $chat);
    }
    
    
    
    public function show(Chat $chat)
    {
        $chat = Chat::find($chat->id);

        $messages = ChatDetail::where('chat_id', $chat->id)->with('sender')->get();
        return view('chats.show', compact('chat', 'messages'));
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

   
}
