@extends('admin.dashboard')

@section('content')

<div class="container">
    <h2>Danh sách người trò chuyện</h2>

</div>
<div class="breadcrumbs mb-5">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Hỗ Trợ khách hàng</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Bảng điều khiển</a></li>
                            <li><a href="#">Hỗ trợ</a></li>
                            <li class="active"><a href="" id="userOnline"></a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content mb-5">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div style="padding: 15px 30px">
                    <!-- Chat Header -->
                    <form action="{{ route('admin.chat.delete', $chat->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Dong</button>
                    </form>
                    <div style="padding: 10px; background-color: #cbcbcb; color: #fff; text-align: center; border-bottom: 1px solid #ddd;">
                        <h3 style="margin: 0;"> 
                            
                            
                                   Trò chuyện với {{ $chat->user->name }}
                              
                           
                      </h3>
                    </div>
                    <div class="chat-box" >
                        <div class="contentBlock" style="min-height: 200px">
                     
                        @foreach ($messages as $value)
                                        <p @if ($value->sender_id == Auth::id()) class="text-end" @endif>{{ $value->sender->name }}:
                                            {{ $value->content }} </p>
                                    @endforeach
                        </div>
                       
                    </div>
                    <div class="d-flex">
                        <input type="text" placeholder="Gửi tin nhắn..." class="form-control" id="inputMessage">
                        <button class="btn btn-success" id="btnSendMessage">Gửi</button>
                    </div>
                    <!-- Chat Messages -->
                    {{-- <div style="flex: 1; overflow-y: auto; padding: 10px; background-color: #f9f9f9;">
                        <div style="text-align: left; margin-bottom: 10px;">
                            <p style="background-color: #e9ecef; display: inline-block; padding: 8px 12px; border-radius: 8px;">Hello Admin!</p>
                            <span style="font-size: 12px; color: #aaa; display: block;">10:01 AM</span>
                        </div>
                        <div style="text-align: right; margin-bottom: 10px;">
                            <p style="background-color: #007bff; color: #fff; display: inline-block; padding: 8px 12px; border-radius: 8px;">Hello User!</p>
                            <span style="font-size: 12px; color: #aaa; display: block;">10:02 AM</span>
                        </div>
                        <!-- Repeat for more messages -->
                    </div> --}}
            
                    <!-- Chat Input -->
                    {{-- <div style="border-top: 1px solid #ddd; padding: 10px; background-color: #fff;">
                        <form action="/admin/send-message" method="POST" style="display: flex;">
                            <input type="text" name="message" placeholder="Type a message..." style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-right: 10px;">
                            <button type="submit" style="background-color: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Send</button>
                        </form>
                    </div> --}}
                </div>

            </div>
  </div>
</div>
</div>

  


@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    let chatId="{{$chat->id}}"
    let userSignIn = '{{ Auth::id() }}'
    let routeMessage = "{{ route('chat.sendMessage', $chat) }}"
 
 </script>
 @vite('resources/js/comment.js')
@endsection