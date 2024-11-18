@foreach ($comments as $item)
<div class="single-comment-wrap">
    <a class="author-thumb" href="#">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmhF7UB6jv1t_oyGDzqSb_h0JPspDnfqohVA&sr">
    </a>
    <div class="comments-info">
        <div class="comment-footer d-flex justify-content-between">
            <span class="author"><a href="#"><strong>{{ $item->user->name }}</strong></a> - {{ $item->created_at->diffForHumans() }}</span>
            <a href="javascript:void(0);" class="btn-reply" onclick="showReplyForm({{ $item->id }})"><i class="fa fa-reply"></i> Trả lời</a>
        </div>
        <p class="mb-1">{{ $item->content }}</p>
    </div>
</div>
<div id="reply-form-{{ $item->id }}" class="reply-form d-none comment-box mb-2">
    <form class="reply-comment-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="parent_id" value="{{ $item->id }}">
        <textarea name="content" class="form-control mb-2" placeholder="Viết câu trả lời..."></textarea>
        <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
        <button type="button" class="btn btn-sm btn-secondary" onclick="hideReplyForm({{ $item->id }})">Hủy</button>
    </form>
</div>
@foreach ($item->children as $child)
<div class="single-comment-wrap mb-4 comment-reply">
    <a class="author-thumb" href="#">
        <img src="https://tse1.mm.bing.net/th?id=OIP.KdRE7KHqL-46M8nrvOX2CgHaHa&pid=Api&P=0&h=220">
    </a>
    <div class="comments-info">
        <div class="comment-footer d-flex justify-content-between">
            <span class="author"><a href="#"><strong>{{ $child->user->name }}</strong></a> - {{ $child->created_at->diffForHumans() }}</span>
        </div>
        <p class="mb-1">{{ $child->content }}</p>
    </div>
</div>
@endforeach
@endforeach
<div>
    {{ $comments->links('pagination::bootstrap-5') }}
</div>
