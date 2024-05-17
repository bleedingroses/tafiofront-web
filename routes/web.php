<?php

use App\Http\Controllers\ContentController;
use App\Models\company;
use Illuminate\Support\Facades\Route;

$companies = company::get();

foreach ($companies as $company) {
    Route::domain($company->domain)->group(
        function () use ($company) {

            Route::get('/', [ContentController::class, 'index']);

            foreach ($company->menu as $menu) {
                $replaced = str_replace(' ', '-', $menu->nama);
                if ($menu->jenis == 'content') {
                    Route::get($replaced, [ContentController::class, 'content']);
                    Route::get($replaced . '/{id}', [ContentController::class, 'single']);
                } else if ($menu->jenis == 'kategori') {
                    Route::get($replaced, [ContentController::class, 'kategori']);
                    Route::get($replaced . '/{kategori}', [ContentController::class, 'content']);
                    Route::get($replaced . '/{kategori}/{id}', [ContentController::class, 'single']);
                } else {
                    Route::get($replaced, [ContentController::class, 'single']);
                }

            }

        }
    );

}
