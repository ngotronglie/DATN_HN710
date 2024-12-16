@extends('admin.dashboard')

@section('content')
  
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
                                <li><a href="#">Hỗ trợ khách hàng</a></li>
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
                    <div style="padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <!-- Chat Header -->
                        <div style="display: flex; justify-content: space-between; align-items: center; background-color: #007bff; color: white; padding: 15px; border-radius: 8px 8px 0 0;">
                            <h4 style="margin: 0;">Trò chuyện với {{ $chat->user->name }}</h4>
                            <form action="{{ route('admin.chat.delete', $chat->id) }}" method="post" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  style="background-color: #dc3545; border: none; color: white; padding: 5px 10px; border-radius: 5px; cursor: pointer;"><i class="fa fa-times"></i> </button>
                            </form>
                        </div>
    
                        <!-- Chat Messages -->
                        <div class="contentBlock" style="min-height: 300px; overflow-y: auto; padding: 15px; background-color: white; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 0 0 8px 8px;">
                            @foreach ($messages as $value)
                            <div style="margin-bottom: 10px; text-align: {{ $value->sender_id == Auth::id() ? 'right' : 'left' }};">
                             
                                    <img src="{{ $value->sender->avatar ? Storage::url($value->sender->avatar) : asset('/theme/client/assets/images/logo/avata.jpg') }}" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;margin-right: 5px">
                             
                                    <span style="display: inline-block; max-width: 80%; line-height: 1.4; font-size: 14px; background-color: #f4f4f4; padding: 5px 10px; border-radius: 10px;">{{ $value->content }}</span>                              
                                    <span style="font-size: 10px; color: gray; margin-top: 5px; align-self: flex-end;">{{ $value->created_at->format('H:i') }}</span>
                                </div>

                        @endforeach
                        
                        </div>
                        <div class="d-flex">
                            <input type="text" placeholder="Gửi tin nhắn..." class="form-control" id="inputMessage" style="margin-right: 10px">
                            <button class="btn btn-dark" id="btnSendMessage">   <i class="fa fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script>
        let chatId = "{{ $chat->id }}"
        let userSignIn = '{{ Auth::id() }}'
        let routeMessage = "{{ route('chat.sendMessage', $chat) }}"

    </script>
    @vite('resources/js/comment.js')
@endsection
