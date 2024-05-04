<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="percetakan brosur, poster, buku, kartunama, majalah, kop surat, map, amplop, banner, spanduk, nota, paper bag, notes, buku kenangan, stiker, cd, ljk, kalender">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cetak brosur, poster, buku online murah | Percetakan Bandung</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Favicon-->
    @php
        if (!empty($sistem)) {
            $words = explode(' ', $sistem['logo']);
            $word = implode(' ', array_splice($words, 0, 5));
            $link = 'sistem/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';
        }
    @endphp
    <link rel="icon" type="image/x-icon" href="{{ !empty($sistem) ? Storage::url($link . $sistem['logo']) : '' }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,500,600" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend/css/cubeportfolio.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend/css/jquery.exzoom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/themify-icons/themify-icons.css') }}">  
    @stack('addons-style')
</head>

<body id="page-top">
    @include($folder.'partials.navbar')
    @yield('main')
    @include($folder.'partials.footer')
    <a id="back-top" href="#"><i class='bx bx-chevrons-up'></i></a>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery-latest.min.js') }}"></script>
    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GSAP JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/ScrollTrigger.min.js"></script>

    <script src="{{ asset('frontend/js/scripts.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.cubeportfolio.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            'use strict';
            $('#back-top').on('click', function() {
                $('html').animate({
                    scrollTop: 0
                }, 800);
            });
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 300) {
                    $('#back-top').fadeIn();
                } else {
                    $('#back-top').fadeOut();
                }
            });
        });
    </script>
    @stack('addons-script')
</body>

</html>
