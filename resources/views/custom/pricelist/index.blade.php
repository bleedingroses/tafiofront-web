    <script src="{{ asset('js/vue-select-1.3.3.js') }}"></script>

@extends('tafio::layouts.main')
@section('main')


  @component('tafio::core.header')

    Pricelist {{!empty($pricelist)?$pricelist:''}}
  @endcomponent
  <div class="container-fluid r-aside">


<div class="row kiri" ><div class=" col-md-3 sidebar">

          <ul class="list-group">
                  <li class="list-group-item"><a href="{{ url('pricelist/brosur') }}">brosur</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/amplop') }}">amplop</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/buku') }}">buku</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/kalender_duduk') }}">kalender duduk</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/kalender_dinding') }}">kalender dinding</a></li>

                  <li class="list-group-item"><a href="{{ url('pricelist/kenangan') }}">kenangan</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/kopsurat') }}">kopsurat</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/ljk') }}">ljk</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/majalah') }}">majalah</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/map') }}">map</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/nota') }}">nota</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/notes') }}">notes</a></li>

                  <li class="list-group-item"><a href="{{ url('pricelist/paperbag') }}">paperbag</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/poster') }}">poster</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/stiker') }}">stiker</a></li>
                  <li class="list-group-item"><a href="{{ url('pricelist/sertifikat') }}">sertifikat</a></li>

          </ul>
        </div>
        <div class="col-md-9">

@component('tafio::core.header')

@endcomponent

@component('tafio::widgets.card')


        @include('tafio::_partial.flash_message')


@if(!empty($pricelist))


<x-tafio::form.open method="PATCH" />

@include('custom.pricelist.'.$pricelist,compact('cetak'))

</form>
 @include('tafio::errors.form_error_list')

@endif
@endcomponent

</div>
</div>
</div>

@stop
