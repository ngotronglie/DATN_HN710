<div class="section">
    <div class="hero-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                @foreach ($banners as $key => $item)
                    <!-- Hero Slider Item Start -->
                    <div class="hero-slide-item swiper-slide">
                        <!-- Hero Slider Bg Image Start -->
                        <div class="hero-slide-bg">
                            <img src="{{ Storage::url($item->image) }}" alt="Slider Image" />
                        </div>
                        <!-- Hero Slider Bg image End -->

                        <!-- Hero Slider Content Start -->
                        <div class="container">
                            <div class="hero-slide-content">
                                @php
                                    // Tách title thành các từ
                                    $titleParts = explode(' ', $item->title);
                                    $totalWords = count($titleParts);

                                    // Số từ của dòng trên sẽ là tổng số từ chia 2, rồi làm tròn lên
                                    $wordsInFirstLine = ceil($totalWords / 2);

                                    // Lấy các từ cho dòng trên và dòng dưới
                                    $firstLine = implode(' ', array_slice($titleParts, 0, $wordsInFirstLine));
                                    $secondLine = implode(' ', array_slice($titleParts, $wordsInFirstLine));
                                @endphp

                                <h2 class="title">
                                    {{ $firstLine }} <br />
                                    {{ $secondLine }}
                                </h2>
                                <p>{{ $item->description }}</p>
                                <a href="{{ $item->link }}" class="btn btn-lg btn-primary btn-hover-dark">Shop Now</a>
                            </div>
                        </div>
                        <!-- Hero Slider Content End -->
                    </div>
                    <!-- Hero Slider Item End -->
                @endforeach

            </div>

            <!-- Swiper Pagination Start -->
            <div class="swiper-pagination d-md-none"></div>
            <!-- Swiper Pagination End -->

            <!-- Swiper Navigation Start -->
            <div class="home-slider-prev swiper-button-prev main-slider-nav d-md-flex d-none"><i
                    class="pe-7s-angle-left"></i></div>
            <div class="home-slider-next swiper-button-next main-slider-nav d-md-flex d-none"><i
                    class="pe-7s-angle-right"></i></div>
            <!-- Swiper Navigation End -->

        </div>
    </div>
</div>
