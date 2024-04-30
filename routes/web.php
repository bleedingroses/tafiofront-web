<?php

use Illuminate\Support\Facades\Route;
use App\Models\company;
use App\Http\Controllers\ContentController;

Route::get('/', function () {
    return view('welcome');
});


 
$companies=company::get();

foreach($companies as $company)
{
Route::domain($company->name)->group( 
function() use($company)  {
  Route::get('/', function () use($company){
      return "Halaman ".$company->name;
  });

foreach($company->menu as $menu)
{
  Route::get($menu->nama, [ContentController::class,'index']);
}

  
});

}




