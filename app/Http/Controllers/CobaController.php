<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\kelurahan;


class CobaController extends Controller
{

public function index()
{
//
// $member=Member::whereNotNull('kelurahanx')->get();
//
// $ambil=kelurahan::select('id','dpc_id','nama')->get();
// $kelurahan=$ambil->pluck('nama','id')->toArray();
// $kelurahan2=$ambil->keyBy('id')->toArray();
//
//
// $kelurahan=array_map('strtolower',$kelurahan);
//
// // dd($kelurahan2);
//
// foreach ($member as $value) {
//   // code...
// // echo $value->namaLengkap;
// $ok=array_search(strtolower($value->kelurahanx),$kelurahan);
// // if()
// if($ok)
// {
//   // echo $value->kelurahanx;
//
// $member2=Member::find($value->id);
// $member2->update(['kecamatanx'=>null,'kelurahanx'=>null,'kelurahan_id'=>$ok,'kecamatan_id'=>$kelurahan2[$ok]['dpc_id'],'kota'=>1]);
// // $member2->update(['kelurahan_id'=>$ok,'kecamatan_id'=>$kelurahan2[$ok]['dpc_id'],'kota'=>1]);
//
// }
// }
// echo 'finish';
//
// }


}
}
