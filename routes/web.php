<?php

use Illuminate\Support\Facades\Route;
use App\Models\company;
use App\Http\Controllers\ContentController;




 
$companies=company::get();




foreach($companies as $company)
{
Route::domain($company->domain)->group( 
function() use($company)  {


Route::get('/', [ContentController::class,'index']);



foreach($company->menu as $menu)
{
if($menu->jenis=='content')
{
Route::get($menu->nama, [ContentController::class,'content']);
Route::get($menu->nama.'/{id}', [ContentController::class,'single']);
}
else if($menu->jenis=='kategori')
{


Route::get($menu->nama, [ContentController::class,'kategori']);
Route::get($menu->nama.'/{kategori}', [ContentController::class,'content']);
Route::get($menu->nama.'/{kategori}/{id}', [ContentController::class,'single']);
}

else
Route::get($menu->nama, [ContentController::class,'single']);
}

  
});

}




