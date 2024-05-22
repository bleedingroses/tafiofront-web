@extends($folder . 'layouts.main')

@section('main')
    <section class="wrapper bg-soft-primary">
        <div class="text-center">
            <img src="{{ asset($company->name . '/img/bg16.png') }}" alt="">
            <!-- /.row -->
        </div>
        <!-- /.container -->
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
