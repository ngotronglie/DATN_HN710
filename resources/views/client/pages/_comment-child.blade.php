@foreach($children as $child)
<div class="single-comment-wrap mb-3" style="margin-left: 20px;" id="comment-{{$child->id}}">
    <a class="author-thumb" href="#">
        <img src="{{$child->user->avatar}}" alt="User Avatar" accept="image/*">
    </a>
    <div class="comments-info">
        <p class="mb-1">{{$child->content}}</p>
        <div class="comment-footer d-flex justify-content-between">
            <span class="author"><a href="#"><strong>{{$child->user->name}}</strong></a> - July 30, 2023</span>
            <button id="replyBtn-{{$child->id}}" style="background-color: transparent; border:none;"
                data-id="{{$child->id}}" class="btn-reply"><i class="fa fa-reply"></i> Reply</button>
        </div>
    </div>
</div>

<!-- Vùng chèn form trả lời -->
<div id="replyBox-{{$child->id}}" class="reply-box" style="display:none; margin-left: 40px;">
    <div class="blog-comment-form-wrapper mt-4 aos-init" data-aos="fade-up" data-aos-delay="400">
        <div class="comment-box">
            <form action="{{ route('admin.comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="parent_id" value="{{ $child->id }}">
                <div class="row">
                    <div class="col-12 col-custom">
                        <div class="input-item mt-4 mb-4">
                            <textarea cols="30" rows="5" name="content"
                                class="rounded-0 w-100 custom-textarea input-area" placeholder="Your reply"
                                required></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-custom mt-4">
                        <button type="submit" class="btn btn-primary btn-hover-dark">Submit Reply</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-reply').forEach(button => {
            button.addEventListener('click', function() {
                const replyBox = document.getElementById('replyBox-' + this.getAttribute(
                    'data-id'));
                replyBox.style.display = (replyBox.style.display === 'none' || replyBox.style
                    .display === '') ? 'block' : 'none';
                replyBox.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>