<div class="container">
    <h2>Danh sách người trò chuyện</h2>

    @if(Auth::user()->role == 1)  <!-- Kiểm tra nếu là nhân viên -->
        <ul>
            @foreach($chats as $chat)
                <li>
                    <a href="{{ route('chat.show', $chat->id) }}">
                        {{ $chat->user->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <a href="{{ route('chat.createRoom') }}" class="btn btn-primary">Bắt đầu chat ngẫu nhiên với nhân viên</a>
    @endif
</div>
