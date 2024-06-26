@extends('web.layouts.detail')

@section('main')
    <section id="header-kontak">
        <div class="container">
            <h1>Kontak <span style="color: #72c02c">Kami</span></h1>
        </div>
    </section>
    <section id="kontak">
        <div class="container">
            <h2>Profile</h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="shadow p-2 mb-5 bg-white rounded">
                        <div class="embed-responsive embed-responsive-16by9">
                            {!! html_entity_decode($sistem['map']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4">
                    <div class="d-flex">
                        <i class='bx bxs-map-pin'></i>
                        <div class="media-body">
                            <h5>Alamat</h5>
                            <p>{{ !empty($sistem) ? $sistem['alamat'] : '' }}</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-mail-send'></i>
                        <div class="media-body">
                            <h5>Email</h5>
                            <p><a
                                    href="mailto:{{ !empty($sistem) ? $sistem['email'] : '' }}">{{ !empty($sistem) ? $sistem['email'] : '' }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-phone-call'></i>
                        <div class="media-body">
                            <h5>Telepon</h5>
                            <p><b>bandung:</b> {{ !empty($sistem) ? $sistem['telp-kantor-bandung'] : '' }}</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bxl-whatsapp'></i>
                        <div class="media-body">
                            <h5>Whatsapp</h5>
                            @php
                                $jakarta = str_replace(' ', '%20', !empty($sistem) ? $sistem['text-wa-jakarta'] : '');
                                $bandung = str_replace(' ', '%20', !empty($sistem) ? $sistem['text-wa-bandung'] : '');
                            @endphp
                            <p>
                                <b>jakarta:</b>
                                <a href="https://web.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}&amp;text={{ $jakarta }}"
                                    target="_blank">{{ !empty($sistem) ? $sistem['wa-jakarta'] : '' }}</a>
                                <br>
                                <b>bandung:</b>
                                <a href="https://web.whatsapp.com/send?phone={{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}&amp;text={{ $bandung }}"
                                    target="_blank">{{ !empty($sistem) ? $sistem['wa-bandung'] : '' }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-mobile-vibration icon-navitem'></i>
                        <div class="media-body">
                            <h5>HP</h5>
                            <p>{{ !empty($sistem) ? $sistem['cs-bandung'] : '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('addons-style')
    <style>
        .footer {
            background-color: #f0f0f0;
        }
    </style>
@endpush

@push('addons-script')
    <script>
        let tl3 = gsap.timeline();
        tl3.from('#header-kontak', {
                opacity: 0,
                duration: 0.6,
                y: -50,
                ease: "Power1.ease"
            })
            .from('#kontak', {
                opacity: 0,
                duration: 1,
                y: -50,
                ease: "Power1.ease"
            }, "-=0.2")
            .from('.footer .row', {
                opacity: 0,
                duration: 1,
                y: -50,
                ease: "Power1.ease"
            }, "-=0.5")
    </script>
@endpush
