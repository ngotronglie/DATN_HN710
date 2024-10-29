@foreach($children as $child)
<div class="single-comment-wrap mb-3" style="margin-left: 20px;" id="comment-{{$child->id}}">
    <a class="author-thumb" href="#">
        <img src="{{Storage::url(path: $comment->user->avatar)  }}" alt="User Avatar" accept="image/*">
    </a>
    <div class="comments-info">
        <p class="mb-1">{{$child->content}}</p>
        <div class="comment-footer d-flex justify-content-between">
            <span class="author"><a href="#"><strong>{{$child->user->name}}</strong></a> <span>
                    {{$child->created_at->diffForHumans()}} </span> </span>
            <!-- <button id="replyBtn-{{$child->id}}" style="background-color: transparent; border:none;"
                data-id="{{$child->id}}" data-user="{{$child->user_id}}" class="btn-reply"><i class="fa fa-reply"></i>
                Trả lời</button> -->
        </div>
    </div>
</div>

<!-- Vùng chèn form trả lời -->
<div id="replyBox-{{$child->id}}" class="reply-box" style="display:none; margin-left: 40px;">
    <div class="blog-comment-form-wrapper mt-4 aos-init" data-aos="fade-up" data-aos-delay="400">
        <div class="comment-box">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="parent_id" id="parent-id-{{$child->id}}" value="{{$child->id}}">
                <div class="row">
                    <div class="col-12 col-custom">
                        <div class="input-item mt-4 mb-4">
                            <textarea cols="30" rows="5" name="content" id="box-reply-{{$child->id}}"
                                class="rounded-0 w-100 custom-textarea input-area" placeholder="Your reply"
                                required></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-custom mt-4">
                        <button type="submit" class="btn btn-primary btn-hover-dark">Gửi trả lời</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@if($child->children != null)
@include('client.pages._comment-child',['children' => $child->children])
@endif
@endforeach

<script>
$(document).ready(function() {
    // Xử lý sự kiện click trên nút trả lời
    $('.btn-reply').click(function(event) {
        event.preventDefault();

        // Lấy ID bình luận để trả lời
        var commentId = $(this).data('id'); // Lấy ID từ thuộc tính data-id của nút
        var replyBox = $('#replyBox-' + commentId);
        var parent_Id_box = $('#parent-id-' + commentId);

        // Gán giá trị parent_id cho bình luận hiện tại trong trường ẩn
        parent_Id_box.val(commentId);

        // Ẩn tất cả các hộp trả lời khác ngoại trừ hộp hiện tại
        $('.reply-box').not(replyBox).slideUp(); // Tùy chọn: Thu gọn các hộp trả lời khác
        replyBox.slideToggle(); // Hiện hoặc ẩn hộp trả lời hiện tại

        // Đầu ra để kiểm tra
        console.log("Đang trả lời bình luận ID:", commentId);
        console.log("Parent ID:", parent_Id_box.val()); // Kiểm tra giá trị parent_id
    });

    // Xóa giá trị parent_id nếu một bình luận mới đang được gửi
    $('.blog-comment-form-wrapper').on('submit', function() {
        $('#parent-id').val(''); // Điều chỉnh nếu bạn có nhiều form
    });
});
</script>