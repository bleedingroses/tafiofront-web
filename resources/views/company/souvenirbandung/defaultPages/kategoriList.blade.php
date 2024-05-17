@extends($folder . 'layouts.main')

@section('main')
    <section id="header">
        <div class="container">
            <h1>Sahabat <span style="color: #72c02c">Cetakmu</span></h1>
        </div>
    </section>
    <section id="profil">
        <div class="container">
            <h2>Kategori List</h2>
            <div class="row">
                <div class="col-lg-6">
                    <img style="width: 100%" src="{{ asset('frontend/assets/img/profile.jpg') }}" alt="">
                </div>
                <div style="padding: 10px" class="col-lg-6 text-ket">

                    {!! $content->isi ?? '' !!}

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
        tl3.from('#header', {
                opacity: 0,
                duration: 0.6,
                y: -50,
                ease: "Power1.ease"
            })
            .from('#profil', {
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
