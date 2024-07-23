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
                $url=$menu->url;
                if ($menu->jenis == 'content') {
                    Route::get($url, [ContentController::class, 'content']);
                    Route::get($url . '/{content}', [ContentController::class, 'listDetail']);
                } else if ($menu->jenis == 'kategori') {
                    Route::get($url, [ContentController::class, 'kategori']);
                    Route::get($url . '/{kategori}', [ContentController::class, 'content']);
                    Route::get($url . '/{kategori}/{content}', [ContentController::class, 'single']);
                } else {
                    Route::get($url, [ContentController::class, 'single']);
                }

            }

        }
    );

}
