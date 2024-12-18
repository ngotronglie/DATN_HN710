<?php
namespace App\Http\Controllers;

use App\Events\AdminNotificationEvent;
use App\Events\ChatClosedEvent;
use App\Events\CommentEvent;
use App\Models\Chat;
use App\Models\ChatDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $chat = Chat::where('user_id', $user_id)->first();

        if ($chat) {
            $messages = ChatDetail::where('chat_id', $chat->id)->with('sender')->get();

            return view('client.pages.chat', compact('chat','messages'));
        }

        return view('client.pages.support');
    }
    

    public function createRoom()
    {
        $user_id = Auth::id();
        $existingChat = Chat::where('user_id', $user_id)->exists();
    
        // Nếu đã có phòng chat, không cho tạo mới
        if ($existingChat) {
            return redirect()->back()->with('error', 'Hiện tại không còn nhân viên hỗ trợ nào.');
        }
    
        // Thời gian hiện tại
        $now = Carbon::now();
    
        // Tìm kiếm nhân viên khả dụng (role '1'), và đang trong ca làm việc
        $availableStaffs = User::where('role', '1')
            ->whereHas('workShift', function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereTime('start_time', '<=', $now->toTimeString())
                      ->whereTime('end_time', '>=', $now->toTimeString());
                })->orWhere(function ($q) use ($now) {
                    // Trường hợp giờ kết thúc nhỏ hơn giờ bắt đầu (qua ngày hôm sau)
                    $q->whereTime('end_time', '<', 'start_time')
                      ->where(function ($subQuery) use ($now) {
                          $subQuery->whereTime('start_time', '<=', $now->toTimeString())
                                   ->orWhereTime('end_time', '>=', $now->toTimeString());
                      });
                });
            })
            ->get();
        // Kiểm tra nếu không có nhân viên khả dụng
        if ($availableStaffs->isEmpty()) {
            return redirect()->back()->with('error', 'Hiện không còn nhân viên hỗ trợ nào');
        }
    
        // Chọn nhân viên đầu tiên trong danh sách khả dụng
        $staff = $availableStaffs->first();
    
        // Kiểm tra nếu user_id và staff_id không trùng nhau
        if ($user_id === $staff->id) {
            return redirect()->back()->with('error', 'Bạn không thể trò chuyện với chính mình.');
        }
    
        // Kiểm tra xem đã tồn tại phòng chat giữa người dùng và nhân viên này chưa
        $chat = Chat::where(function ($query) use ($user_id, $staff) {
            $query->where('user_id', $user_id)->where('staff_id', $staff->id)
                ->orWhere('user_id', $staff->id)->where('staff_id', $user_id);
        })->first();
    
        if (!$chat) {
            $chat = Chat::create([
                'user_id' => $user_id,
                'staff_id' => $staff->id,
            ]);
        }
            return redirect()->route('chat.show', $chat);
    }

    
    
    public function show($chatId)
{
    // Tìm chat theo ID
    $chat = Chat::find($chatId);

    // Kiểm tra xem có tồn tại không
    if (!$chat) {
        return redirect()->route('support')->with('error', 'Phòng chat đã kết thúc');
    }

    // Lấy các tin nhắn của chat này
    $messages = ChatDetail::where('chat_id', $chat->id)->with('sender')->get();

    return view('client.pages.chat', compact('chat', 'messages'));
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
