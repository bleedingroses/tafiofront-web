@extends($folder . 'layouts.main')


@section('main')

    <section id="header-kontak">
        <div class="container">
            <h1>
            {{$content->menu->nama??''}}
        </span></h1>
        </div>
    </section>
    <section id="kontak">
        <div class="container">
          
            {{$content->ringkasan}}
            {{$content->isi}}
           
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



