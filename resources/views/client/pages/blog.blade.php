@extends('client.index')


@section('main')
    <!-- Breadcrumb Section Start -->
    <div class="section">

        <!-- Breadcrumb Area Start -->
        <div class="breadcrumb-area bg-light">
            <div class="container-fluid">
                <div class="breadcrumb-content text-center">
                    <h1 class="title">Blog</h1>
                    <ul>
                        <li>
                            <a href="/">Home </a>
                        </li>
                        <li class="active"> Blog</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Breadcrumb Area End -->

    </div>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Start -->
    <div class="section section-margin">
        <div class="container">

            <div class="row mb-n8">

                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/1.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>14 Jul 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Some Winter Collections</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="300">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/2.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>20 Feb 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">My Perty Fashion</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/3.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>18 Mar 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Perfect Fashion House</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/4.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>11 Jun 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Some Winter Collections</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="300">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/5.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>02 Apr 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Flip Flops Year Round</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/6.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>09 May 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Style For the Soul</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="200">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/7.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>13 Aug 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Trends Only Here</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="300">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/8.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>15 Dec 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Small Scale Style</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
                <div class="col-md-6 col-lg-4 mb-8" data-aos="fade-up" data-aos-delay="400">
                    <!-- Single Blog Start -->
                    <div class="blog-single-post-wrapper">
                        <div class="blog-thumb">
                            <a class="blog-overlay" href="/blog-detail">
                                <img src="{{ asset('theme/client/assets/images/blog/blog-post/9.jpg') }}" alt="Blog Post">
                            </a>
                        </div>
                        <div class="blog-content">
                            <div class="post-meta">
                                <span>By : <a href="#">Admin</a></span>
                                <span>26 Dec 2023</span>
                            </div>
                            <h3 class="title"><a href="/blog-detail">Fashion Vitamins</a></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit, sed do eiusmod tempo</p>
                            <a href="/blog-detail" class="link">Read More</a>
                        </div>
                    </div>
                    <!-- Single Blog End -->
                </div>
            </div>

            <div class="row mb-2 mb-lg-0">

                <!-- Pagination Start -->
                <div class="col" data-aos="fade-up" data-aos-delay="300">
                    <nav class="mt-8 pt-8 border-top d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Pagination End -->

            </div>

        </div>
    </div>
    <!-- Blog Section End -->
@endsection
