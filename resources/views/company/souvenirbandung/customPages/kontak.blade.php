@extends($folder . 'layouts.main')


@section('main')

    <section id="header-kontak">
        <div class="container">
            <h1>Kontak <span style="color: #72c02c">Kami</span></h1>
        </div>
    </section>
    <section id="kontak">
        <div class="container">
          
            <div class="row">
                <div class="col-lg-7 col-sm-7 col-xs-7 maps ">                
                    <div class="shadow p-2 mb-5 bg-white rounded">
                        <div class="embed-responsive embed-responsive-16by9">
                               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.535924146217!2d107.6142842142142!3d-6.9459291949817015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e88eba122df9%3A0x99f2f5ec42610780!2sId%20card%20bandung!5e0!3m2!1sid!2sid!4v1580457268129!5m2!1sid!2sid" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                  </div>
                <div class="col-lg-4 mt-4">
                    <div class="d-flex">
                        <i class='bx bxs-map-pin'></i>
                        <div class="media-body">
                            <h5>Alamat</h5>
                            <p>kontak</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-mail-send'></i>
                        <div class="media-body">
                            <h5>Email</h5>
                            <p>kontak</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-phone-call'></i>
                        <div class="media-body">
                            <h5>Telepon</h5>
                            <p>kontak</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bxl-whatsapp'></i>
                        <div class="media-body">
                            <h5>Whatsapp</h5>
                            <p>kontak</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class='bx bx-mobile-vibration icon-navitem'></i>
                        <div class="media-body">
                            <h5>HP</h5>
                            <p>kontak</p>
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



