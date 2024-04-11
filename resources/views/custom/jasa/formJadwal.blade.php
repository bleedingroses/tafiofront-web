<?php 
    $projectDetail = $crud->projectDetail;
    $projectFlow = $crud->jadwal;
    $awal=false;
$default=[];
?>


@section('main')
    <div id="app">
        @component('tafio::widgets.header')
            Project
            <x-tafio::custom.panah />
            Schedule
        @endcomponent
        <div class="container-fluid r-aside">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="pull-left">
                                <h3 class="card-title">update</h3>
                            </div>
                        </div>
                        <form
                             method="POST" action="{{ url('bisnis/jasa/project/' .$projectDetail->project_id .'/schedule/' .$projectDetail->id .'') }}"
                            accept-charset="UTF-8"
                            onsubmit="document.getElementById('submit').disabled=true; document.getElementById('submit').value='proses';"
                            enctype="multipart/form-data" class="form-horizontal">
                            @csrf

                                <input name="_method" type="hidden" value="PATCH">

                            @foreach ($projectFlow as $item)



                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">{{ $item->nama }}</label>
                                                <div class="col-lg-9">
                                                    <input 
                                                         type="date"
                                                        name="data_{{ $item->id }}" class="form-control"
                                                       
                                                        v-model="data_{{$item->id}}"
                                                        :min="min_{{$item->id}}"
                                                        :max="max_{{$item->id}}"


                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">deadline <font color=red>*</font></label>
                                     
                                        <div class="col-lg-9">
                                            <input type="date" name="deadline" 

v-model=deadline
:min="deadline_min"


                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="isian form-group"><input id="submit" type="submit" value="simpan"
                                    class="btn btn-primary"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / #project -->
    </div>
@endsection



@push('addons-script')
<script>
new Vue({
  el: '#app',
  data: {

<?php

foreach ($projectFlow as $list) {
// foreach($default as $nama=>$isi)
// {

if(!$awal)
$awal=$list->id;

    $cek=$projectDetail->flow()->find($list->id);
    if($cek)
    $deadline=$cek->pivot->deadline;
    else
    $deadline='';

echo "data_".$list->id.":'".$deadline."',";
}
?>
    min_{{$awal}}:'{{$projectDetail->created_at->format('Y-m-d')}}',
    deadline:'{{!empty($projectDetail->deadline)?$projectDetail->deadline:''}}'


  },
   computed: {
<?php
$i=1;

foreach ($projectFlow as $list) {

if ($i==1)
 $jadwal_sekarang=$list->id;


if($i>=2)
echo "max_".$jadwal_sekarang.": function () {return  this.data_".$list->id." ? this.data_".$list->id.": this.max_".$list->id."},";

if($i>=3)
echo "min_".$jadwal_sekarang.": function () {return  this.data_".$jadwal_sebelumnya." ? this.data_".$jadwal_sebelumnya.": this.min_".$jadwal_sebelumnya."},";

if($i>=2)
{
$jadwal_sebelumnya=$jadwal_sekarang;
$jadwal_sekarang=$list->id;
}

$i++;
 }
echo "max_".$jadwal_sekarang.": function () {return  this.deadline ? this.deadline: ''},";
echo "min_".$jadwal_sekarang.": function () {return  this.data_".$jadwal_sebelumnya." ? this.data_".$jadwal_sebelumnya.": this.min_".$jadwal_sebelumnya."},";
echo "deadline_min: function () {return  this.data_".$jadwal_sekarang." ? this.data_".$jadwal_sekarang.": this.min_".$jadwal_sekarang."},";

 ?>

  }
})

</script>
@endpush
