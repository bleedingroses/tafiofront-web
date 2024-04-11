    <script src="{{ asset('js/vue-select-1.3.3.js') }}"></script>

@extends('tafio::layouts.main')
@section('main')

@component('tafio::core.header')

  Calculator {{!empty($calculator)?$calculator:''}}

@endcomponent
<div class="container-fluid r-aside">

<div class="row kiri"><div class=" col-md-3 sidebar">

          <ul class="list-group">
                  <li class="list-group-item"><a href="{{ url('calculator/optimasi') }}">optimasi potong</a></li>
                  <li class="list-group-item"><a href="{{ url('calculator/optimasi_bahan') }}">optimasi bahan</a></li>
                  <li class="list-group-item"><a href="{{ url('calculator/optimasi_setting') }}">optimasi setting</a></li>
                  <li class="list-group-item"><a href="{{ url('calculator/optimasi_harga') }}">hitung harga</a></li>
                  <li class="list-group-item"><a href="{{ url('calculator/berat') }}">berat kertas</a></li>
          </ul>
        </div>
        <div class="col-md-9">




        @component('tafio::widgets.card')



        @include('tafio::_partial.flash_message')


@if(!empty($calculator))


<x-tafio::form.open method="PATCH" />

@include('calculator.'.$calculator,compact('cetak'))

</form>
 @include('tafio::errors.form_error_list')

@endif

 @endcomponent
</div>
</div>

@stop
