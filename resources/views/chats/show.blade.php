<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
<div class="container">
    <h2>Phòng chat số  ({{$chat->id}})</h2>
       
    <div class="col-4">
        <h1>Trò chuyện với:</h1>

        @if(Auth::user()->role==0)
        Nhan vien
        <ul class="list-group" id="userOnline">

        </ul> 
       
        @else
        Nguoi dung
        <ul class="list-group" id="userOnline">

        </ul> 
            
        @endif
        
    </div>
    <div class="chat-box">
        <div class="contentBlock" style="min-height: 200px">
     
        @foreach ($messages as $value)
                        <p @if ($value->sender_id == Auth::id()) class="text-end" @endif>{{ $value->sender->name }}:
                            {{ $value->content }}</p>
                    @endforeach
        </div>
        {{-- <ul class="list-group" id="userOnline">

        </ul> --}}
    </div>
    <div class="d-flex">
        <input type="text" placeholder="Gửi tin nhắn..." class="form-control" id="inputMessage">
        <button class="btn btn-success" id="btnSendMessage">Gửi</button>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
   let chatId="{{$chat->id}}"
   let userSignIn = '{{ Auth::id() }}'
   let routeMessage = "{{ route('chat.sendMessage', $chat) }}"

</script>
@vite('resources/js/comment.js')

</body>
</html>