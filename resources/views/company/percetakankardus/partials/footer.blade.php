<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @php
                    if (!empty($sistem)) {
                        $words = explode(' ', $sistem['logo']);
                        $word = implode(' ', array_splice($words, 0, 5));
                        $link = 'storage/sistem/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';
                    }
                @endphp
                <a class="img" href="#">
                    <img src="{{ !empty($sistem) ? url($link . $sistem['logo']) : '' }}" alt="..." />
                </a>
                <p><br>2022 ©All Rights Reserved. </p>
            </div>
            <div class="col-lg-2">
                <h5>Home</h5>
                <ul>
                    <li>
                        <i class="fas fa-chevron-right"></i>
                        <a href="asdf">Profil</a>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right"></i>
                        <a href="asdf">Kontak</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h5>Marketplace</h5>
                <ul class="list-group">
                    <li>
                        <div class="d-flex">
                            <div><img style="height: 20px; width:100%" src="{{ asset('frontend/assets/shopee.png') }}"
                                    alt="" srcset=""></div>
                            <div class="ps-2 pt-1"><a target="_blank"
                                href="https://shopee.co.id/{{ !empty($sistem) ? $sistem['shopee'] : '' }}">Shopee</a></div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div><img style="height: 20px; width:100%" src="{{ asset('frontend/assets/tokopedia.png') }}"
                                    alt="" srcset=""></div>
                            <div class="ps-2 pt-1"><a target="_blank"
                                href="https://www.tokopedia.com/{{ !empty($sistem) ? $sistem['tokopedia'] : '' }}">Tokopedia</a></div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <div><img style="height: 20px; width:100%" src="{{ asset('frontend/assets/lazada.png') }}"
                                    alt="" srcset=""></div>
                            <div class="ps-2 pt-1"><a target="_blank"
                                href="https://www.lazada.co.id/shop/{{ !empty($sistem) ? $sistem['lazada'] : '' }}">lazada</a></div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Kontak</h5>
                <ul>
                    <li>
                        <i class="fas fa-chevron-right"></i>
                        <span href="">{{ !empty($sistem) ? $sistem['alamat'] : ''  }}</span>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right"></i>
                        <span class="" href="">{{ !empty($sistem) ? $sistem['cs-bandung'] : '' }}</span>
                    </li>
                    <li>
                        <i class="fas fa-chevron-right"></i>
                        <a href="mailto:{{ !empty($sistem) ? $sistem['email'] : '' }}">{{ !empty($sistem) ? $sistem['email'] : '' }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h5>Ikuti kami</h5>
                <a class="btn btn-social" href="https://www.facebook.com/{{ !empty($sistem) ? $sistem['facebook'] : '' }}/"><i
                        class="fab fa-facebook-f"></i></a>
                <a class="btn btn-social" href="https://www.instagram.com/{{ !empty($sistem) ? $sistem['instagram'] : '' }}/"><i
                        class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>
