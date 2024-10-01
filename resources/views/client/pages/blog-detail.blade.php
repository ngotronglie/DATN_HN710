@extends('client.index')

@section('main')
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Blog Details</h1>
                    <ul>
                        <li>
                            <a href="index.html">Home </a>
                        </li>
                        <li class="active"> Blog Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Details Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row">
                <!-- Blog Main Area Start -->
                <div class="col-lg-9 m-auto overflow-hidden">

                    <!-- Single Post Details Start -->
                    <div class="blog-details mb-10">

                        <!-- Blog Details Image Start -->
                        <div class="image mb-6" data-aos="fade-up" data-aos-delay="300">
                            <img class="fit-image" src="assets/images/blog/blog-details/1.jpg" alt="Blog">
                        </div>
                        <!-- Blog Details Image End -->

                        <!-- Single Post Details Content Start -->
                        <div class="content" data-aos="fade-up" data-aos-delay="300">

                            <!-- Title Start -->
                            <h2 class="title mb-3">Fashion for the Clueless</h2>
                            <!-- Title End -->

                            <!-- Meta List Start -->
                            <div class="meta-list mb-3">
                                <span>By <a href="#" class="meta-item author mr-1">Admin,</a></span>
                                <span class="meta-item date">May 21, 2023</span>
                                <span class="meta-item comment"><a href="#">03 Comments</a></span>
                            </div>
                            <!-- Meta List End -->

                            <!-- Description Start -->
                            <div class="desc">
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration some form, by injected humour, or randomised words which don't look
                                    even slightly believable. Ifyouare going to use a passage of Lorem Ipsum, you need to be
                                    sure there isanything embarrassing hidden i the middletext.There are many variations of
                                    passages of Lorem Ipsum available, but the majority hsuffered alteration in some form,
                                    by injected humour.</p>

                                <!-- Blockquote Start -->
                                <blockquote class="blockquote mt-5 mb-5">
                                    <p>“Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
                                        himenaeos. Sed rutrum at ante in lacinia. Maecenas dignissim lacus orci, a euismod
                                        ipsum ornare convallis. Morbi tristique consectetur purus, quis cursus ante posuere
                                        nec. Cras quis pharetra ex. Cras vehicula dignissim suscipit.”</p>
                                    <footer class="blockquote-footer">
                                        <span>John Doe</span>
                                    </footer>
                                </blockquote>
                                <!-- Blockquote End -->

                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration some form, by injected humour, or randomised words which don't look
                                    even slightly believable.</p>
                                <div class="row mt-6">
                                    <div class="col-sm-6 col-12 mb-6" data-aos="fade-right" data-aos-delay="300">
                                        <img class="fit-image" src="assets/images/blog/blog-details/2.jpg" alt="Blog">
                                    </div>
                                    <div class="col-sm-6 col-12 mb-6" data-aos="fade-left" data-aos-delay="300">
                                        <img class="fit-image" src="assets/images/blog/blog-details/3.jpg" alt="Blog">
                                    </div>
                                </div>
                                <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as
                                    necessary, making this the first true generator on the Internet. It uses a dictionary o
                                    first true generator on the Internet. It uses a dictionary of over 200 Latin words,
                                    combined with a handful of model </p>
                            </div>
                            <!-- Description End -->

                        </div>
                        <!-- Single Post Details Content End -->

                        <!-- Single Post Details Footer Start -->
                        <div class="single-post-details-footer mt-10" data-aos="fade-up" data-aos-delay="300">
                            <!-- Shear Article Start -->
                            <div class="share-article">
                                <span class="left-side">
                                    <a href="#"> <i class="fa fa-long-arrow-left"></i> Older Post</a>
                                </span>
                                <h6 class="share-title text-uppercase">Share this article</h6>
                                <span class="right-side">
                                    <a href="#">Newer Post <i class="fa fa-long-arrow-right"></i></a>
                                </span>
                            </div>
                            <!-- Shear Article Start -->
                            <!-- Social Shear Start -->
                            <div class="widget-social border-top pt-2">
                                <a title="Facebook" href="#"><i class="fa fa-facebook-f"></i></a>
                                <a title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                                <a title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                                <a title="Youtube" href="#"><i class="fa fa-youtube"></i></a>
                                <a title="Vimeo" href="#"><i class="fa fa-vimeo"></i></a>
                            </div>
                            <!-- Social Shear Start -->
                        </div>
                        <!-- Single Post Details Footer End -->

                    </div>
                    <!-- Single Post Details End -->

                    <!-- Comments Area Wrapper Start -->
                    <div class="comment-area-wrapper mt-5" data-aos="fade-up" data-aos-delay="400">

                        <!-- Title Start -->
                        <h3 class="title mb-6">5 Comments</h3>
                        <!-- Title End -->

                        <!-- Single Comment Wrapper Start -->
                        <div class="single-comment-wrap mb-10">
                            <a class="author-thumb" href="#">
                                <img src="assets/images/blog/thumb/1.jpg" alt="Author">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">This book is a treatise on the theory of ethics, very popular during the
                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Duy</strong></a> - July 30, 2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Comment Wrapper End -->

                        <!-- Single Comment Wrapper Start -->
                        <div class="single-comment-wrap mb-10 comment-reply">
                            <a class="author-thumb" href="#">
                                <img src="assets/images/blog/thumb/2.jpg" alt="Author">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">Praesent bibendum risus pellentesque faucibus rhoncus. Etiam a mollis
                                    odio. Integer urna nisl, fermentum eu mollis et, gravida eu elit.</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Alex</strong></a> - August 30,
                                        2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Comment Wrapper End -->

                        <!-- Single Comment Wrapper Start -->
                        <div class="single-comment-wrap mb-10">
                            <a class="author-thumb" href="#">
                                <img src="assets/images/blog/thumb/3.jpg" alt="Author">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">Praesent bibendum risus pellentesque faucibus rhoncus. Etiam a mollis
                                    odio. Integer urna nisl, fermentum eu mollis et, gravida eu elit.</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Tuntuni</strong></a> - September 10,
                                        2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Comment Wrapper End -->

                        <!-- Single Comment Wrapper Start -->
                        <div class="single-comment-wrap mb-10">
                            <a class="author-thumb" href="#">
                                <img src="assets/images/blog/thumb/4.jpg" alt="Author">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">This book is a treatise on the theory of ethics, very popular during the
                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Jack</strong></a> - October 23,
                                        2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Comment Wrapper End -->

                        <!-- Single Comment Wrapper Start -->
                        <div class="single-comment-wrap comment-reply">
                            <a class="author-thumb" href="#">
                                <img src="assets/images/blog/thumb/2.jpg" alt="Author">
                            </a>
                            <div class="comments-info">
                                <p class="mb-1">Praesent bibendum risus pellentesque faucibus rhoncus. Etiam a mollis
                                    odio. Integer urna nisl, fermentum eu mollis et, gravida eu elit.</p>
                                <div class="comment-footer d-flex justify-content-between">
                                    <span class="author"><a href="#"><strong>Alex</strong></a> - October 26,
                                        2023</span>
                                    <a href="#" class="btn-reply"><i class="fa fa-reply"></i> Reply</a>
                                </div>
                            </div>
                        </div>
                        <!-- Single Comment Wrapper End -->

                    </div>
                    <!-- Comments Area Wrapper End -->

                    <!-- Blog Comments Form Start -->
                    <div class="blog-comment-form-wrapper mt-10" data-aos="fade-up" data-aos-delay="400">

                        <!-- Blog Comment Form Title Start -->
                        <div class="blog-comment-form-title">
                            <h2 class="title">Leave a comment</h2>
                        </div>
                        <!-- Blog Comment Form Title End -->

                        <!-- Comment Box Start -->
                        <div class="comment-box">
                            <form action="#">
                                <div class="row">

                                    <!-- Message Input Start -->
                                    <div class="col-12 col-custom">
                                        <div class="input-item mt-4 mb-4">
                                            <textarea cols="30" rows="5" name="comment" class="rounded-0 w-100 custom-textarea input-area"
                                                placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <!-- Message Input End -->

                                    <!-- Name Input Start -->
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="rounded-0 w-100 input-area name" type="text"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <!-- Name Input End -->

                                    <!-- Email Input Start -->
                                    <div class="col-md-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="rounded-0 w-100 input-area email" type="text"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <!-- Email Input End -->

                                    <!-- Website Input Start -->
                                    <div class="col-12-6 col-custom">
                                        <div class="input-item mb-4">
                                            <input class="rounded-0 w-100 input-area name" type="text"
                                                placeholder="Website">
                                        </div>
                                    </div>
                                    <!-- Website Input End -->

                                    <!-- Submit Button Start -->
                                    <div class="col-12 col-custom mt-4">
                                        <button type="submit" class="btn btn-primary btn-hover-dark">Post
                                            comment</button>
                                    </div>
                                    <!-- Submit Button End -->

                                </div>
                            </form>
                        </div>
                        <!-- Comment Box End -->

                    </div>
                    <!-- Blog Comments Form End -->

                </div>
                <!-- Blog Main Area End -->
            </div>

        </div>
    </div>
@endsection
