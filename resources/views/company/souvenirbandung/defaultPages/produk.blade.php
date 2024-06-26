@extends('web.layouts.detail')

@section('main')
    <section class="produk-detail">
        <div class="container">
            <h2>{{ $produk->nama }}</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box">
                            <ul class='exzoom_img_ul'>
                                @foreach ($galleries as $gallery)
                                    @php
                                        $words = explode(' ', $gallery->images);
                                        $word = implode(' ', array_splice($words, 0, 5));
                                        $link = 'gallery/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';
                                    @endphp
                                    <li><img src="{{ Storage::url($link . $gallery->images) }}" /></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn">
                                < </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img class="img-profil" src="{{ asset($company->name . '/img/profil.jpg') }}" alt="">

                    <p>
                        {{ $produk->deskripsi }}
                    </p>
                </div>
            </div>
            <div class="mt-5">
                @if (View::exists('web.partials.pricelist.' . $produk->slug))
                    @include('web.partials.pricelist.fungsi')
                    @include('web.partials.pricelist.' . $produk->slug)
                @else
                    {!! html_entity_decode($produk->pricelist) !!}
                @endif
            </div>
        </div>
    </section>
@endsection

@push('addons-script')
    <script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
    <script>
        $("#exzoom").exzoom({
            autoPlay: true,
            autoPlayTimeout: 5000,

        });
        $("#exzoom").removeClass('hidden')
    </script>
@endpush

@push('addons-style')
    <style>
        .footer {
            background-color: #f0f0f0;
        }

        .table {
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            border: 0.2rem solid #fff !important;
        }

        .table>thead {
            background-color: #72c02c;
        }
    </style>
@endpush
