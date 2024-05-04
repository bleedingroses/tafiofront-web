<!-- Masthead-->
<header>
    <div class="text-animation">
        <h1>{{ !empty($sistem) ? $sistem['tagline'] : '' }}</h1>
        <h2><span class="ityped"></span> </h2>        
        <p>Yang tidak sempat desain. Tidak mau <br> macet atau antri. Serta butuh kepastian harga.</p>
    </div>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
                @php
                    $words = explode(' ', $slider->big_img);
                    $word = implode(' ', array_splice($words, 0, 5));
                    $link = 'storage/slider/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';

                    $words2 = explode(' ', $slider->mobile_img);
                    $word2 = implode(' ', array_splice($words2, 0, 5));
                    $link2 = 'storage/slider/' . $word2[0] . $word2[1] . '/' . $word2[2] . $word2[3] . '/';
                @endphp
                <div class="swiper-slide">
                    <img class="img-web" src="{{ url($link . $slider->big_img) }}" alt="">
                    <img class="img-mobile" src="{{ url($link2 . $slider->mobile_img) }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</header>
